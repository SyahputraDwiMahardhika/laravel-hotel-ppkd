<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Registration extends Model
{
    protected $fillable = [
        'registration_number', 'guest_id', 'room_id', 'receptionist_id',
        'num_guests', 'num_rooms', 'check_in_date', 'arrival_time',
        'check_out_date', 'departure_date', 'deposit_box_number',
        'issued_by', 'total_price', 'status', 'notes',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'departure_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function receptionist()
    {
        return $this->belongsTo(User::class, 'receptionist_id');
    }

    public function getNightsAttribute(): int
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    public static function generateNumber(): string
    {
        $prefix = 'REG';
        $date = now()->format('Ymd');
        $last = static::whereDate('created_at', today())->count() + 1;
        return sprintf('%s-%s-%04d', $prefix, $date, $last);
    }
}
