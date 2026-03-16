<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'registration_id',
        'amount',
        'payment_method',
        'status',
        'notes'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
