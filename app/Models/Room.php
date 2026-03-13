<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number', 'room_type_id', 'floor', 'status', 'notes',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function activeRegistration()
    {
        return $this->hasOne(Registration::class)->where('status', 'active');
    }

    public function cleaningLogs()
    {
        return $this->hasMany(RoomCleaningLog::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'available' => 'success',
            'occupied' => 'danger',
            'cleaning' => 'warning',
            'maintenance' => 'secondary',
            'out_of_order' => 'dark',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'cleaning' => 'Sedang Dibersihkan',
            'maintenance' => 'Maintenance',
            'out_of_order' => 'Tidak Tersedia',
            default => 'Unknown',
        };
    }
}
