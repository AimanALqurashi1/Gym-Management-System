<?php
// app/Models/EquipmentAssignment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EquipmentAssignment extends Model
{
    use HasFactory;

    protected $table = 'equipment_assignments';

    protected $fillable = [
        'equipment_id',
        'assignable_type',
        'assignable_id',
        'quantity',
        'assigned_at',
        'expected_return_at',
        'returned_at',
        'status',
        'purpose',
        'notes',
        'assigned_by',
        'received_by'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'expected_return_at' => 'datetime',
        'returned_at' => 'datetime',
        'quantity' => 'integer'
    ];

    protected $appends = ['duration', 'is_overdue'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function assignable()
    {
        return $this->morphTo();
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function getDurationAttribute()
    {
        if (!$this->returned_at) {
            return null;
        }

        return $this->assigned_at->diffInMinutes($this->returned_at);
    }

    public function getIsOverdueAttribute()
    {
        return $this->status == 'assigned' &&
            $this->expected_return_at &&
            now()->gt($this->expected_return_at);
    }

    public function markAsReturned($receivedById = null)
    {
        $this->returned_at = now();
        $this->status = 'returned';
        $this->received_by = $receivedById ?? Auth::id();
        $this->save();

        // Update equipment availability
        $this->equipment->updateAvailability();

        return $this;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'assigned')
            ->whereNotNull('expected_return_at')
            ->where('expected_return_at', '<', now());
    }

    public function scopeForMember($query, $memberId)
    {
        return $query->where('assignable_type', Member::class)
            ->where('assignable_id', $memberId);
    }

    public function scopeForTrainer($query, $trainerId)
    {
        return $query->where('assignable_type', Trainer::class)
            ->where('assignable_id', $trainerId);
    }
}
