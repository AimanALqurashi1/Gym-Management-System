<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ClassInstance extends Model
{

    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime', // or 'date'
        'start_time' => 'datetime',
        // other casts...
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the class type
     */
    public function Course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the instructor for this instance
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }


    public function member()
    {
        return $this->belongsToMany(Member::class, 'class_instance_member')
            ->withPivot('attendance_status', 'check_in_time', 'note')
            ->withTimestamps();
    }




    /* Update available spots based on current attendees */
    public function updateAvailableSpots()
    {
        try {
            // Make sure the columns exist
            if (!$this->total_spots) {
                Log::warning('total_spots is null for ClassInstance ID: ' . $this->id);
                return null;
            }

            $currentAttendees = $this->member()->count();
            $this->available_spots = max(0, $this->total_spots - $currentAttendees); // Ensure non-negative
            $this->save();

            return $this->available_spots;
        } catch (\Exception $e) {
            Log::error('Error in updateAvailableSpots: ' . $e->getMessage());
            return null;
        }
    }

    public function isFull()
    {
        return $this->available_spots <= 0;
    }


    /**
     * Check if a specific member is marked in this instance
     */
    public function isMemberMarked($memberId)
    {
        return $this->member()->where('member_id', $memberId)->exists();
    }

    /**
     * Get attendance status for a specific member
     */
    public function getMemberAttendanceStatus($memberId)
    {
        $member = $this->member()->where('member_id', $memberId)->first();
        return $member ? $member->pivot->attendance_status : null;
    }
}
