<?php
// app/Models/Equipment.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'category_id',
        'description',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'purchase_price',
        'current_value',
        'supplier',
        'warranty_until',
        'location',
        'status',
        'quantity',
        'available_quantity',
        'image',
        'notes',
        'specifications',
        'maintenance_schedule',
        'last_maintenance_date',
        'next_maintenance_date',
        'needs_maintenance',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_until' => 'date',
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'purchase_price' => 'decimal:2',
        'current_value' => 'decimal:2',
        'specifications' => 'array',
        'maintenance_schedule' => 'array',
        'needs_maintenance' => 'boolean',
        'quantity' => 'integer',
        'available_quantity' => 'integer'
    ];

    protected $appends = ['status_color', 'status_label', 'maintenance_status'];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(EquipmentMaintenance::class, 'equipment_id')->orderBy('maintenance_date', 'desc');
    }

    public function assignments()
    {
        return $this->hasMany(EquipmentAssignment::class, 'equipment_id');
    }

    public function activeAssignments()
    {
        return $this->hasMany(EquipmentAssignment::class, 'equipment_id')->where('status', 'assigned');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'available' => 'success',
            'in_use' => 'info',
            'maintenance' => 'warning',
            'broken' => 'danger',
            'retired' => 'secondary',
            default => 'secondary'
        };
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getMaintenanceStatusAttribute()
    {
        if (!$this->next_maintenance_date) {
            return 'not_scheduled';
        }

        $today = now();
        $nextMaintenance = Carbon::parse($this->next_maintenance_date);

        if ($this->needs_maintenance) {
            return 'overdue';
        } elseif ($nextMaintenance->diffInDays($today) <= 7) {
            return 'due_soon';
        } else {
            return 'ok';
        }
    }

    public function updateAvailability()
    {
        $assignedCount = $this->activeAssignments()->sum('quantity');
        $this->available_quantity = $this->quantity - $assignedCount;

        // Update status based on availability
        if ($this->available_quantity <= 0) {
            $this->status = 'in_use';
        } elseif ($this->available_quantity == $this->quantity) {
            $this->status = 'available';
        }

        $this->save();

        return $this->available_quantity;
    }

    public function checkMaintenanceNeeded()
    {
        if ($this->next_maintenance_date && now()->gte($this->next_maintenance_date)) {
            $this->needs_maintenance = true;
            $this->save();
            return true;
        }
        return false;
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
            ->where('available_quantity', '>', 0)
            ->where('needs_maintenance', false);
    }

    public function scopeNeedsMaintenance($query)
    {
        return $query->where('needs_maintenance', true)
            ->orWhereDate('next_maintenance_date', '<=', now());
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }
}
