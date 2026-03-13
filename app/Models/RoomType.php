<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name', 'code', 'description', 'price_per_night',
        'max_occupancy', 'bed_type', 'facilities',
    ];

    protected $casts = [
        'facilities' => 'array',
        'price_per_night' => 'decimal:2',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function availableRooms()
    {
        return $this->hasMany(Room::class)->where('status', 'available');
    }
}
