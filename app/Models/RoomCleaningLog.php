<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCleaningLog extends Model
{
    protected $fillable = [
        'room_id', 'user_id', 'action', 'notes', 'action_at',
    ];

    protected $casts = [
        'action_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'start_cleaning' => 'Mulai Membersihkan',
            'finish_cleaning' => 'Selesai Membersihkan',
            'ready_for_checkin' => 'Siap Check-in',
            'maintenance_start' => 'Mulai Maintenance',
            'maintenance_done' => 'Maintenance Selesai',
            default => $this->action,
        };
    }
}
