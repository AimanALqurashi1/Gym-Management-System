<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Added
        'phone', // Added
        'photo', // Added
        'code', // Added
        'address', // Added
        'status', // Added
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string', // ← ADD THIS LINE!
            'status' => 'string', // ← ADD THIS LINE TOO!
        ];
    }

    // these functions we will use them in the view , while we can not call them in the controller or middleware
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user is trainer
     */
    public function isTrainer()
    {
        return $this->role === 'trainer';
    }

    /**
     * Check if user is member
     */
    public function isMember()
    {
        return $this->role === 'member';
    }

    public function trainer()
    {
        return $this->hasOne(Trainer::class, 'user_id');
    }
}
