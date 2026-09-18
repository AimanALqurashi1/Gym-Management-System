<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'course_trainer')
            ->withTimestamps(); // if you have timestamps in pivot
    }


    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function classInstances()
    {
        return $this->hasMany(ClassInstance::class);
    }
}
