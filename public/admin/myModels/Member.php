<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'membership_start_date' => 'date',
        'membership_end_date' => 'date',
        'date_of_birth' => 'date',
        'joined_at' => 'datetime',
    ];

    protected $appends = [

        'name',
        'picture',
        'memberType',
        'status',
        'joinDate',
        'department',
        'role',
        'bio',
        'address'
    ];

    // Accessors for your view compatibility
    public function getNameAttribute()
    {
        return $this->full_name;
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getPictureAttribute()
    {
        return $this->profile_photo ?? 'https://via.placeholder.com/50';
    }

    public function getMemberTypeAttribute()
    {
        return $this->plan ? $this->plan->name : 'No Plan';
    }

    public function getStatusAttribute()
    {
        return $this->membership_status;
    }

    public function getJoinDateAttribute()
    {
        return $this->membership_start_date?->format('Y-m-d');
    }

    public function getDepartmentAttribute()
    {
        return $this->plan ? $this->plan->category : 'No Department';
    }


    public function getBioAttribute()
    {
        return $this->fitness_goals ?? 'No fitness goals specified.';
    }

    public function getAddressAttribute()
    {
        return $this->address_line1 ?? 'No address provided';
    }

    // Relationships
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'member_trainer')
            ->withPivot(['assignment_type', 'assigned_at', 'status', 'sessions_per_week'])
            ->withTimestamps();
    }

    public function primaryTrainer()
    {
        return $this->belongsToMany(Trainer::class, 'member_trainer')
            ->wherePivot('assignment_type', 'primary')
            ->wherePivot('status', 'active')
            ->withPivot(['assigned_at', 'sessions_per_week']);
    }

    public function classes()
    {
        return $this->belongsToMany(Course::class, 'course_member')
            ->withPivot(['schedule_id', 'booking_status', 'booking_date', 'check_in_time', 'rating'])
            ->withTimestamps();
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'course_member')
            ->withPivot(['booking_status', 'check_in_time'])
            ->withTimestamps();
    }

    public function planHistory()
    {
        return $this->hasMany(MemberPlanHistory::class);
    }



    public function goals()
    {
        return $this->hasMany(MemberGoal::class);
    }

    // Get member's schedule based on plan type
    public function getSchedule()
    {
        if (!$this->plan) {
            return collect();
        }

        switch ($this->plan->category) {
            case 'elite':
                return $this->getElitePlanSchedule();
            case 'pro':
                return $this->getProPlanSchedule();
            case 'basic':
                return $this->getBasicPlanSchedule();
            default:
                return collect();
        }
    }

    private function getElitePlanSchedule()
    {
        // Elite plan: 1-on-1 sessions with top trainer, personalized schedule
        return Schedule::whereHas('class', function ($q) {
            $q->where('category', 'personal_training');
        })
            ->whereHas('trainer', function ($q) {
                $q->where('is_top_trainer', true);
            })
            ->whereHas('members', function ($q) {
                $q->where('member_id', $this->id)
                    ->wherePivot('booking_status', 'booked');
            })
            ->with(['class', 'trainer'])
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();
    }

    private function getProPlanSchedule()
    {
        // Pro plan: Group classes, monthly schedule based on performance
        return Schedule::whereHas('members', function ($q) {
            $q->where('member_id', $this->id)
                ->wherePivot('booking_status', 'booked');
        })
            ->with(['class', 'trainer'])
            ->whereBetween('start_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();
    }

    private function getBasicPlanSchedule()
    {
        // Basic plan: Selected classes with specific trainer
        return Schedule::whereHas('members', function ($q) {
            $q->where('member_id', $this->id)
                ->wherePivot('booking_status', 'booked');
        })
            ->with(['class', 'trainer'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();
    }

    // Check if member is active
    public function isActive()
    {
        return $this->membership_status === 'active' &&
            $this->membership_end_date &&
            $this->membership_end_date->isFuture();
    }

    // Get membership duration in months
    public function getDurationInMonthsAttribute()
    {
        return $this->membership_duration ?? 6; // Default to 6 months
    }
}
