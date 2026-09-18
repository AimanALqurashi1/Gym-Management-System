<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    use HasFactory;
    protected $guarded = [];


    public function courses()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the plan for this schedule
     */
    public function membersWithPlans()
    {
        return $this->belongsToMany(Member::class, 'member_schedule')
            ->join('plans', 'member_schedule.plan_id', '=', 'plans.id')
            ->select('members.*', 'plans.type as plan_name', 'plans.duration as plan_duration')
            ->withPivot(['enrolled_date', 'expiry_date', 'status']);
    }

    /**
     * Get the instructor for this schedule
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function member()
    {
        return $this->belongsToMany(Member::class, 'member_schedule')
            ->withPivot('enrolled_date', 'expiry_date', 'status', 'added_by', 'plan_id')
            ->withTimestamps();
    }


    /* Get only active members (currently enrolled) */
    public function activeMembers()
    {
        return $this->belongsToMany(Member::class, 'member_schedule')
            ->wherePivot('status', 'active')
            ->wherePivot('enrolled_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('member_schedule.expiry_date')
                    ->orWhere('member_schedule.expiry_date', '>=', now());
            })
            ->withPivot(['enrolled_date', 'expiry_date', 'status']);
    }

    /*  Get members who should attend a specific class instance date */
    public function getMembersForDate($date)
    {
        return $this->belongsToMany(Member::class, 'member_schedule')
            ->wherePivot('status', 'active')
            ->wherePivot('enrolled_date', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->whereNull('member_schedule.expiry_date')
                    ->orWhere('member_schedule.expiry_date', '>=', $date);
            })
            ->get();
    }

    public function classInstances()
    {
        return $this->hasMany(ClassInstance::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
