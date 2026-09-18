<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $casts = [
        'features' => 'array',
        'accessible_areas' => 'array',
        'accessible_hours' => 'array',
        'meta_data' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'refundable' => 'boolean',
        'requires_approval' => 'boolean',
    ];

    // Relationships

    // Members on this plan
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    // Active members on this plan
    public function activeMembers()
    {
        return $this->members()->where('membership_status', 'active');
    }

    // Classes included in this plan
    public function includedClasses()
    {
        return $this->belongsToMany(Course::class, 'plan_class')
            ->withPivot([
                'id',
                'sessions_limit',
                'sessions_used',
                'period',
                'access_type',
                'priority'
            ])
            ->wherePivot('access_type', 'included')
            ->withTimestamps();
    }

    // Classes with discount in this plan
    public function discountedClasses()
    {
        return $this->belongsToMany(Course::class, 'plan_class')
            ->withPivot('discount_percentage', 'discounted_price', 'access_type')
            ->wherePivot('access_type', 'discounted')
            ->withTimestamps();
    }

    // All class access rules
    public function classAccess()
    {
        return $this->hasMany(PlanClass::class);
    }

    // Member plan history
    public function memberHistory()
    {
        return $this->hasMany(MemberPlanHistory::class);
    }

    // Payments made for this plan
    public function payments()
    {
        return $this->hasMany(MemberPayment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Methods
    public function getMonthlyPriceAttribute()
    {
        switch ($this->billing_cycle) {
            case 'yearly':
                return $this->price / 12;
            case 'quarterly':
                return $this->price / 3;
            default:
                return $this->price;
        }
    }

    public function canMemberBookClass($member, $classId)
    {
        $planClass = $this->classAccess()
            ->where('course_id', $classId)
            ->first();

        if (!$planClass || $planClass->access_type === 'blocked') {
            return false;
        }

        if ($planClass->access_type === 'included') {
            $bookingsThisPeriod = $member->classes()
                ->where('course_id', $classId)
                ->wherePivot('booking_date', '>=', now()->startOf($planClass->period))
                ->count();

            return $bookingsThisPeriod < $planClass->sessions_limit;
        }

        return true;
    }
}
