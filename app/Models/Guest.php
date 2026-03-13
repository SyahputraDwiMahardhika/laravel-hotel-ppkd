<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'full_name', 'occupation', 'company', 'nationality',
        'id_card_number', 'passport_number', 'address',
        'phone_number', 'member_number',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function activeRegistration()
    {
        return $this->hasOne(Registration::class)->where('status', 'active')->latest();
    }
}
