<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberSchedule;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['member', 'recorder']);

        // Filter by member
        if ($request->has('member_id') && $request->member_id) {
            $query->where('member_id', $request->member_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('payment_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('payment_date', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $payments = $query->orderBy('payment_date', 'desc')->paginate(20);

        // For filter dropdown
        $members = Member::orderBy('name')->get();

        $stats = [
            'total_payments' => Payment::sum('amount'),
            'total_refunds' => Refund::sum('refund_amount'),
            'net_revenue' => Payment::sum('amount') - Refund::sum('refund_amount'),
            'payments_this_month' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
        ];

        return view('payments.index', compact('payments', 'members', 'stats'));
    }


    /**
     * Show form to create new payment
     */
    public function payment_list(Request $request)
    {
        $memberId = $request->member_id;

        if ($memberId) {
            $member = Member::with(['memberSchedule' => function ($q) {
                $q->where('status', 'active')
                    ->where('payment_status', '!=', 'paid');
            }])->findOrFail($memberId);

            $enrollments = $member->memberSchedule;
            $plans = Plan::where('is_active', 1)->get();
            $need_to_pay = MemberSchedule::where('member_id', $memberId)->get();

            return view('payments.table_payment', compact('member', 'enrollments', 'plans', 'need_to_pay'));
        }

        $members = Member::whereHas('memberSchedule', function ($q) {
            $q->where('status', 'active')
                ->where('payment_status', '!=', 'paid');
        })->orderBy('name')->get();

        return view('payments.select_member', compact('members'));
    }

    public function create_payment($memberId, $paymentId)
    {


        if ($memberId) {
            $member = Member::findOrFail($memberId);
            $enrollment = MemberSchedule::with(['schedule.course', 'schedule.trainer'])
                ->findOrFail($paymentId);

            $remaining = $enrollment->total_amount - $enrollment->amount_paid;
            $plans = Plan::where('is_active', 1)->get();

            return view('payments.create_payment', compact('member', 'enrollment', 'plans', 'remaining'));
        }
    }


    public function storeForCourse(Request $request, $memberScheduleId)
    {
        $request->validate([
            'amount' => 'required|numeric|',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
            'receipt_image' => 'nullable|image|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $enrollment = MemberSchedule::findOrFail($memberScheduleId);
            $remaining = $enrollment->total_amount - $enrollment->amount_paid;

            if ($request->amount > $remaining) {
                return redirect()->back()
                    ->with('error', "Amount cannot exceed remaining balance of $" . number_format($remaining, 2))
                    ->withInput();
            }

            // Handle receipt image
            $receiptImagePath = null;
            if ($request->hasFile('receipt_image')) {
                $image = $request->file('receipt_image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/receipts'), $filename);
                $receiptImagePath = 'uploads/receipts/' . $filename;
            }

            // Create payment
            $payment = Payment::create([
                'member_id' => $enrollment->member_id,
                'member_schedule_id' => $enrollment->id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => 'cash',
                'receipt_number' => Payment::generateReceiptNumber(),
                'receipt_image' => $receiptImagePath,
                'notes' => $request->notes,
                'recorded_by' => Auth::id(),
            ]);

            // Update enrollment
            $newTotalPaid = $enrollment->amount_paid + $request->amount;
            $newRemaining = $enrollment->total_amount - $newTotalPaid;

            $paymentStatus = 'pending';
            if ($newTotalPaid >= $enrollment->total_amount) {
                $paymentStatus = 'paid';
            } elseif ($newTotalPaid > 0) {
                $paymentStatus = 'partial';
            }

            $enrollment->update([
                'amount_paid' => $newTotalPaid,
                'amount_due' => $newRemaining,
                'payment_status' => $paymentStatus,
                'last_payment_date' => $request->payment_date,
            ]);

            DB::commit();

            return redirect()->route('payments.payment_list', [$enrollment->member_id, $enrollment->id])
                ->with('success', 'Payment of $' . number_format($request->amount, 2) . ' recorded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error recording payment: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Show payment details
     */
    public function show($id)
    {
        $payment = Payment::with(['member', 'recorder'])->findOrFail($id);

        // Get the associated enrollment to show course details
        $enrollment = null;
        if ($payment->member_schedule_id) {
            $enrollment = MemberSchedule::with(['schedule.course', 'schedule.trainer'])
                ->find($payment->member_schedule_id);
        }

        return view('payments.show', compact('payment', 'enrollment'));
    }

    /**
     * Generate and download receipt PDF
     */
    public function generateReceipt($id)
    {
        $payment = Payment::with(['member'])->findOrFail($id);

        // Get enrollment for course details if exists
        $enrollment = null;
        if ($payment->member_schedule_id) {
            $enrollment = MemberSchedule::with(['schedule.course', 'schedule.trainer'])
                ->find($payment->member_schedule_id);
        }

        $pdf = Pdf::loadView('payments.receipt', compact('payment', 'enrollment'));

        return $pdf->download("receipt_{$payment->receipt_number}.pdf");
    }

    /**
     * View receipt in browser (preview before printing)
     */
    public function viewReceipt($id)
    {
        $payment = Payment::with(['member'])->findOrFail($id);

        // Get enrollment for course details if exists
        $enrollment = null;
        if ($payment->member_schedule_id) {
            $enrollment = MemberSchedule::with(['schedule.course', 'schedule.trainer'])
                ->find($payment->member_schedule_id);
        }

        $pdf = Pdf::loadView('payments.receipt', compact('payment', 'enrollment'));

        return $pdf->stream("receipt_{$payment->receipt_number}.pdf");
    }
}
