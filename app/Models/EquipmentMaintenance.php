<?php
// app/Models/EquipmentMaintenance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentMaintenance extends Model
{
    use HasFactory;

    protected $table = 'equipment_maintenance';

    protected $fillable = [
        'equipment_id',
        'type',
        'maintenance_date',
        'next_maintenance_date',
        'description',
        'notes',
        'performed_by',
        'cost',
        'duration_minutes',
        'parts_replaced',
        'status',
        'requires_followup',
        'followup_notes',
        'attachments',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'cost' => 'decimal:2',
        'parts_replaced' => 'array',
        'attachments' => 'array',
        'requires_followup' => 'boolean',
        'duration_minutes' => 'integer'
    ];

    protected $appends = ['type_label', 'status_color'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type);
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'scheduled' => 'info',
            'in_progress' => 'warning',
            'completed' => 'success',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['scheduled', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRequiresFollowup($query)
    {
        return $query->where('requires_followup', true);
    }
}
