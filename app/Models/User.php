<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'administrator';
    }

    public function isReceptionist(): bool
    {
        return $this->role === 'receptionist';
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'receptionist_id');
    }
}
