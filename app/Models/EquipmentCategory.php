<?php
// app/Models/EquipmentCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getEquipmentCountAttribute()
    {
        return $this->equipment()->count();
    }

    public function getAvailableCountAttribute()
    {
        return $this->equipment()->where('status', 'available')->count();
    }
}
