<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'gallery' => 'array',
        'meta_data' => 'array',
        'is_active' => 'boolean',
        'requires_approval' => 'boolean',
    ];

    // Relationships

    // Many-to-Many with Trainers (through schedules)
    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'schedules')
            ->withPivot([
                'id',
                'day_of_week',
                'start_time',
                'end_time',
                'start_date',
                'end_date',
                'room',
                'current_capacity',
                'max_capacity',
                'status'
            ])
            ->withTimestamps();
    }

    // Many-to-Many with Trainers certified to teach this class
    public function certifiedTrainers()
    {
        return $this->belongsToMany(Trainer::class, 'trainer_class')
            ->withPivot('qualification_level', 'certified_at', 'certification_expiry')
            ->withTimestamps();
    }

    // Many-to-Many with Members (through course_member)
    public function members()
    {
        return $this->belongsToMany(Member::class, 'course_member')
            ->withPivot([
                'id',
                'schedule_id',
                'booking_status',
                'booking_date',
                'check_in_time',
                'check_out_time',
                'price_paid',
                'payment_status',
                'rating',
                'feedback'
            ])
            ->withTimestamps();
    }

    // Schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Active schedules
    public function activeSchedules()
    {
        return $this->hasMany(Schedule::class)
            ->where('status', 'scheduled')
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    // Plans that include this class
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_class')
            ->withPivot([
                'id',
                'access_type',
                'sessions_limit',
                'sessions_used',
                'period',
                'discount_percentage',
                'discounted_price',
                'priority',
                'max_bookings_per_period'
            ])
            ->withTimestamps();
    }

    // Attendance records
    public function attendance()
    {
        return $this->hasMany(MemberAttendance::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePopular($query)
    {
        return $query->withCount('members')
            ->orderBy('members_count', 'desc');
    }

    // Methods
    public function getCurrentCapacityAttribute()
    {
        return $this->schedules()->sum('current_capacity');
    }

    public function getTotalCapacityAttribute()
    {
        return $this->schedules()->sum('max_capacity');
    }

    public function getOccupancyRateAttribute()
    {
        $total = $this->total_capacity;
        if ($total == 0) return 0;
        return round(($this->current_capacity / $total) * 100, 2);
    }
}
