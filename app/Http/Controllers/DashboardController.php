<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Registration;
use App\Models\Guest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_rooms' => Room::count(),
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'cleaning' => Room::where('status', 'cleaning')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
            'today_checkins' => Registration::whereDate('check_in_date', today())->where('status', 'active')->count(),
            'today_checkouts' => Registration::whereDate('check_out_date', today())->where('status', 'active')->count(),
            'total_guests' => Guest::count(),
            'active_registrations' => Registration::where('status', 'active')->count(),
        ];

        $recentRegistrations = Registration::with(['guest', 'room.roomType', 'receptionist'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $todayCheckouts = Registration::with(['guest', 'room'])
            ->whereDate('check_out_date', today())
            ->where('status', 'active')
            ->get();

        return view('dashboard', compact('stats', 'recentRegistrations', 'todayCheckouts'));
    }
}
