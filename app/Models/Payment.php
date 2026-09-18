<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'member_schedule_id',
        'amount',
        'payment_date',
        'payment_method',
        'receipt_number',
        'receipt_image',
        'notes',
        'recorded_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function memberSchedule()
    {
        return $this->belongsTo(MemberSchedule::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public static function generateReceiptNumber()
    {
        $lastPayment = self::orderBy('id', 'desc')->first();
        if ($lastPayment) {
            $lastNumber = intval(substr($lastPayment->receipt_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        return 'RCP-' . date('Ymd') . '-' . $newNumber;
    }
}
