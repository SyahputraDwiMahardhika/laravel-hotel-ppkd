<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\RoomCleaningLog;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['roomType', 'activeRegistration.guest']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->floor) {
            $query->where('floor', $request->floor);
        }

        $rooms = $query->orderBy('room_number')->get();
        $floors = Room::distinct()->pluck('floor')->sort();
        $statusCounts = Room::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');

        return view('rooms.index', compact('rooms', 'floors', 'statusCounts'));
    }

    public function updateStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,cleaning,maintenance,out_of_order',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $room->status;
        $room->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Log cleaning action
        $actionMap = [
            'cleaning' => 'start_cleaning',
            'available' => 'ready_for_checkin',
            'maintenance' => 'maintenance_start',
        ];

        if (isset($actionMap[$request->status])) {
            RoomCleaningLog::create([
                'room_id' => $room->id,
                'user_id' => auth()->id(),
                'action' => $actionMap[$request->status],
                'notes' => $request->notes,
            ]);
        }

        return redirect()->back()->with('success', "Status kamar {$room->room_number} berhasil diperbarui.");
    }

    public function create()
    {
        // $this->authorize('admin');
        
        $roomTypes = RoomType::all();
        return view('rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer',
        ]);

        Room::create($request->only('room_number', 'room_type_id', 'floor', 'notes'));
        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer',
        ]);

        $room->update($request->only('room_number', 'room_type_id', 'floor', 'notes'));
        return redirect()->route('rooms.index')->with('success', 'Data kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->status === 'occupied') {
            return redirect()->back()->with('error', 'Tidak bisa menghapus kamar yang sedang terisi.');
        }
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
