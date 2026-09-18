<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships

    public function class()
    {
        return $this->belongsTo(Course::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    // Members booked in this schedule
    public function members()
    {
        return $this->belongsToMany(Member::class, 'course_member')
            ->withPivot([
                'booking_status',
                'booking_date',
                'check_in_time',
                'check_out_time',
                'price_paid',
                'payment_status',
                'rating'
            ])
            ->withTimestamps();
    }

    // Booked members (confirmed)
    public function bookedMembers()
    {
        return $this->members()->wherePivot('booking_status', 'booked');
    }

    // Waitlisted members
    public function waitlistedMembers()
    {
        return $this->members()->wherePivot('booking_status', 'waitlisted');
    }

    // Attendance records
    public function attendance()
    {
        return $this->hasMany(MemberAttendance::class);
    }

    // Scopes
    public function scopeForToday($query)
    {
        return $query->where('day_of_week', strtolower(now()->format('l')))
            ->where('status', 'scheduled');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'scheduled')
            ->whereColumn('current_capacity', '<', 'max_capacity');
    }

    // Methods
    public function isFull()
    {
        return $this->current_capacity >= $this->max_capacity;
    }

    public function availableSpots()
    {
        return $this->max_capacity - $this->current_capacity;
    }

    public function incrementCapacity()
    {
        $this->increment('current_capacity');

        if ($this->current_capacity >= $this->max_capacity) {
            $this->update(['status' => 'full']);
        }
    }

    public function decrementCapacity()
    {
        $this->decrement('current_capacity');

        if ($this->current_capacity < $this->max_capacity) {
            $this->update(['status' => 'scheduled']);
        }
    }
}
