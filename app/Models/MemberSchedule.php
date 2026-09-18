<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberSchedule extends Model
{
    use HasFactory;  // This now correctly references Illuminate\Database\Eloquent\Factories\HasFactory

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'schedule_id',
        'plan_id',
        'course_id',
        'enrolled_date',
        'expiry_date',
        'status',
        'added_by',
        // Payment related fields
        'total_amount',
        'payment_status',
        'amount_paid',
        'amount_due',
        'last_payment_date',
        'payment_due_date',
        // Cancellation related fields
        'cancelled_at',
        'cancellation_reason',
        'cancelled_by',
        'refund_amount',
        'refund_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'enrolled_date' => 'date',
        'expiry_date' => 'date',
        'last_payment_date' => 'date',
        'payment_due_date' => 'date',
        'cancelled_at' => 'datetime',
        'refund_date' => 'date',
        'amount_paid' => 'decimal:2',
        'amount_due' => 'decimal:2',
        'refund_amount' => 'decimal:2'
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_schedule_id');
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class, 'member_schedule_id');
    }




    /**
     * Calculate refund eligibility and amount
     */
    public function calculateRefund()
    {
        $enrolledDate = Carbon::parse($this->enrolled_date);
        $expiryDate = Carbon::parse($this->expiry_date);
        $today = Carbon::now();

        // Calculate total period in days
        $totalPeriodDays = $expiryDate->diffInDays($enrolledDate);
        $halfPeriodDays = $totalPeriodDays / 2;
        $daysSinceEnrollment = $enrolledDate->diffInDays($today);

        $totalPaid = $this->amount_paid;
        $refundPercentage = 0;
        $refundAmount = 0;

        if ($daysSinceEnrollment <= 2) {
            // Within 2 days - 100% refund
            $refundPercentage = 100;
            $refundAmount = $totalPaid;
        } elseif ($daysSinceEnrollment <= $halfPeriodDays) {
            // Within first half - 50% refund
            $refundPercentage = 50;
            $refundAmount = $totalPaid * 0.5;
        } else {
            // After half period - no refund
            $refundPercentage = 0;
            $refundAmount = 0;
        }

        return [
            'eligible' => $refundAmount > 0,
            'percentage' => $refundPercentage,
            'amount' => $refundAmount,
            'days_since_enrollment' => $daysSinceEnrollment,
            'total_period_days' => $totalPeriodDays,
            'half_period_days' => round($halfPeriodDays),
            'message' => $this->getRefundMessage($refundPercentage, $daysSinceEnrollment)
        ];
    }

    /**
     * Get refund eligibility message
     */
    private function getRefundMessage($percentage, $daysSinceEnrollment)
    {
        if ($percentage == 100) {
            return "You are eligible for a 100% refund (within 2 days of enrollment).";
        } elseif ($percentage == 50) {
            return "You are eligible for a 50% refund (within first half of the period).";
        } else {
            return "You are not eligible for a refund (past the half period).";
        }
    }

    /**
     * Process cancellation and refund
     */
    public function processCancellation($reason, $notes = null)
    {
        $refundInfo = $this->calculateRefund();

        DB::beginTransaction();

        try {
            // Update enrollment status
            $this->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
                'cancelled_by' => Auth::user()->id,
                'refund_amount' => $refundInfo['amount'],
                'refund_date' => $refundInfo['eligible'] ? now() : null,
            ]);

            // Create refund record if eligible
            if ($refundInfo['eligible'] && $refundInfo['amount'] > 0) {
                // Get all payments for this enrollment
                $payments = Payment::where('member_schedule_id', $this->id)
                    ->where('status', 'paid')
                    ->get();

                $totalRefundAmount = 0;

                foreach ($payments as $payment) {
                    // Calculate refund for this payment (proportional)
                    $paymentRefundAmount = ($payment->amount / $this->amount_paid) * $refundInfo['amount'];

                    Refund::create([
                        'payment_id' => $payment->id,
                        'member_id' => $this->member_id,
                        'member_schedule_id' => $this->id,
                        'refund_amount' => $paymentRefundAmount,
                        'refund_percentage' => $refundInfo['percentage'],
                        'refund_date' => now(),
                        'cancellation_reason' => $reason,
                        'notes' => $notes,
                        'processed_by' => Auth::user()->id,
                    ]);

                    $totalRefundAmount += $paymentRefundAmount;

                    // Update payment status
                    if ($paymentRefundAmount >= $payment->amount) {
                        $payment->update(['status' => 'refunded']);
                    } else {
                        $payment->update(['status' => 'partial_refund']);
                    }
                }


                $this->payments()->update([
                    'status' => 'refunded'
                ]);

                // Update member's outstanding balance
                /*   $this->member->update([
                    'outstanding_balance' => max(0, $this->member->outstanding_balance - $totalRefundAmount),
                    'payment_status' => 'good_standing'
                ]); */
            }

            // Remove member from future class instances
            $futureInstances = ClassInstance::where('schedule_id', $this->schedule_id)
                ->where('start_date', '>=', now())
                ->get();

            foreach ($futureInstances as $instance) {
                $instance->member()->detach($this->member_id);
                $instance->updateAvailableSpots();
            }

            DB::commit();

            return $refundInfo;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
