<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'hire_date' => 'date',
        'certifications' => 'array',
        'availability' => 'array',
    ];

    // Relationships

    // Many-to-Many with Members
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_trainer')
            ->withPivot([
                'id',
                'assignment_type',
                'assigned_at',
                'end_date',
                'sessions_per_week',
                'session_price',
                'trainer_commission',
                'goals',
                'achievements',
                'notes',
                'status'
            ])
            ->withTimestamps();
    }

    // Active members under this trainer
    public function activeMembers()
    {
        return $this->belongsToMany(Member::class, 'member_trainer')
            ->wherePivot('status', 'active');
    }

    // Many-to-Many with Classes (through schedules)
    public function classes()
    {
        return $this->belongsToMany(Course::class, 'schedules')
            ->withPivot([
                'id',
                'day_of_week',
                'start_time',
                'end_time',
                'start_date',
                'end_date',
                'room',
                'status'
            ])
            ->withTimestamps();
    }

    // Many-to-Many with Classes they're certified to teach
    public function certifiedClasses()
    {
        return $this->belongsToMany(Course::class, 'trainer_class')
            ->withPivot('qualification_level', 'certified_at', 'certification_expiry', 'average_rating')
            ->withTimestamps();
    }

    // Schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Today's schedule
    public function todaysSchedule()
    {
        return $this->hasMany(Schedule::class)
            ->where('day_of_week', strtolower(now()->format('l')))
            ->where('status', 'scheduled')
            ->with('class');
    }

    // Upcoming schedules
    public function upcomingSchedules()
    {
        return $this->hasMany(Schedule::class)
            ->where('start_date', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('start_date')
            ->orderBy('start_time');
    }

    // Attendance records for classes they taught
    public function attendanceRecords()
    {
        return $this->hasMany(MemberAttendance::class);
    }

    // Health records they've created

    // Goals they've set for members
    public function memberGoals()
    {
        return $this->hasMany(MemberGoal::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvailable($query, $dayOfWeek, $time)
    {
        // Query trainers available at specific day/time
        return $query->whereJsonContains('availability->days', $dayOfWeek)
            ->whereTime('availability->start_time', '<=', $time)
            ->whereTime('availability->end_time', '>=', $time);
    }

    // Methods
    public function isAvailable($dayOfWeek, $startTime, $endTime)
    {
        $availability = $this->availability;

        if (!in_array($dayOfWeek, $availability['days'] ?? [])) {
            return false;
        }

        $availStart = $availability['start_time'] ?? '00:00';
        $availEnd = $availability['end_time'] ?? '23:59';

        return $startTime >= $availStart && $endTime <= $availEnd;
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
