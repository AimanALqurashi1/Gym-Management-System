<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schedule()
    {
        return $this->belongsToMany(Schedule::class, 'member_schedule')
            ->withPivot('enrolled_date', 'expiry_date', 'status', 'added_by', 'plan_id')
            ->withTimestamps();
    }

    /* Get active schedules for this member */
    public function activeSchedules()
    {
        return $this->belongsToMany(Schedule::class, 'member_schedule')
            ->wherePivot('status', 'active')
            ->wherePivot('enrolled_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('member_schedule.expiry_date')
                    ->orWhere('member_schedule.expiry_date', '>=', now());
            })
            ->withPivot(['enrolled_date', 'expiry_date']);
    }


    public function classInstance()
    {
        return $this->belongsToMany(ClassInstance::class, 'class_instance_member')
            ->withPivot('attendance_status', 'check_in_time')
            ->withTimestamps();
    }


    /**
     * Get the member_schedule enrollments for this member.
     */
    public function memberSchedule()
    {
        return $this->hasMany(MemberSchedule::class);
    }
}
