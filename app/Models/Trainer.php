<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_trainer')
            ->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function classInstances()
    {
        return $this->hasMany(ClassInstance::class);
    }




    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
