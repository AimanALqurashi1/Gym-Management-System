<?php
// app/Models/Refund.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'member_id',
        'member_schedule_id',
        'refund_amount',
        'refund_percentage',
        'refund_date',
        'cancellation_reason',
        'notes',
        'processed_by'
    ];

    protected $casts = [
        'refund_date' => 'date',
        'refund_amount' => 'decimal:2',
        'refund_percentage' => 'decimal:2'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function memberSchedule()
    {
        return $this->belongsTo(MemberSchedule::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
