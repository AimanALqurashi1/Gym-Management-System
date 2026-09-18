<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
