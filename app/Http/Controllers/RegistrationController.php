<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['guest', 'room.roomType', 'receptionist'])
            ->orderBy('created_at', 'desc');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('guest', function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('id_card_number', 'like', "%$search%")
                    ->orWhere('passport_number', 'like', "%$search%");
            })->orWhere('registration_number', 'like', "%$search%");
        }

        $registrations = $query->paginate(15);
        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $roomTypes = RoomType::with('availableRooms')->get();
        $rooms = Room::with('roomType')->where('status', 'available')->get();
        $receptionists = User::where('is_active', true)->get();
        return view('registrations.create', compact('roomTypes', 'rooms', 'receptionists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'num_guests' => 'required|integer|min:1',
            'num_rooms' => 'required|integer|min:1',
            'receptionist_id' => 'required|exists:users,id',
            'check_in_date' => 'required|date',
            'arrival_time' => 'required',
            'check_out_date' => 'required|date|after:check_in_date',
            'full_name' => 'required|string|max:255',
            'nationality' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            // Create or update guest
            $guest = Guest::updateOrCreate(
                ['id_card_number' => $request->id_card_number ?: null,],
                [
                    'full_name' => $request->full_name,
                    'occupation' => $request->occupation,
                    'company' => $request->company,
                    'nationality' => $request->nationality,
                    'id_card_number' => $request->id_card_number,
                    'passport_number' => $request->passport_number,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'member_number' => $request->member_number,
                ]
            );

            // Calculate price
            $room = Room::with('roomType')->find($request->room_id);
            $checkIn = \Carbon\Carbon::parse($request->check_in_date);
            $checkOut = \Carbon\Carbon::parse($request->check_out_date);
            $nights = $checkIn->diffInDays($checkOut);
            $totalPrice = $room->roomType->price_per_night * $nights * $request->num_rooms;

            // Create registration
            $registration = Registration::create([
                'registration_number' => Registration::generateNumber(),
                'guest_id' => $guest->id,
                'room_id' => $request->room_id,
                'receptionist_id' => $request->receptionist_id,
                'num_guests' => $request->num_guests,
                'num_rooms' => $request->num_rooms,
                'check_in_date' => $request->check_in_date,
                'arrival_time' => $request->arrival_time,
                'check_out_date' => $request->check_out_date,
                'departure_date' => $request->departure_date,
                'deposit_box_number' => $request->deposit_box_number,
                'issued_by' => $request->issued_by,
                'total_price' => $totalPrice,
                'notes' => $request->notes,
                // PAYMENT
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,

                // CREDIT CARD
                'card_number' => $request->card_number,
                'card_holder_name' => $request->card_holder_name,
                'card_expired' => $request->card_expired,

                // BANK TRANSFER
                'bank_name' => $request->bank_name,
                'bank_account_name' => $request->bank_account_name,
                'bank_account_number' => $request->bank_account_number,


                'status' => 'active',
            ]);

            // Update room status
            $room->update(['status' => 'occupied']);

            return $registration;
        });

        return redirect()->route('registrations.index')
            ->with('success', 'Registrasi berhasil dibuat!');
    }

    public function show(Registration $registration)
    {
        $registration->load(['guest', 'room.roomType', 'receptionist']);
        return view('registrations.show', compact('registration'));
    }

    public function print(Registration $registration)
    {
        $registration->load(['guest', 'room.roomType', 'receptionist']);
        return view('registrations.print', compact('registration'));
    }

    public function checkout(Registration $registration)
    {
        DB::transaction(function () use ($registration) {
            $registration->update([
                'status' => 'checked_out',
                'departure_date' => now()->toDateString(),
            ]);

            // Set room to cleaning
            $registration->room->update(['status' => 'cleaning']);
        });

        return redirect()->route('registrations.index')
            ->with('success', 'Guest berhasil check-out. Kamar sudah ditandai untuk dibersihkan.');
    }
}
