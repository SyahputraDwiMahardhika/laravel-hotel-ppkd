<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@hotelppkd.com',
            'password' => Hash::make('admin123'),
            'role' => 'administrator',
            'is_active' => true,
        ]);

        // Create Receptionists
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@hotelppkd.com',
            'password' => Hash::make('budi123'),
            'role' => 'receptionist',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari@hotelppkd.com',
            'password' => Hash::make('sari123'),
            'role' => 'receptionist',
            'is_active' => true,
        ]);

        // Room Types (dari yang murah sampai premium)
        $types = [
            [
                'name' => 'Standard Room',
                'code' => 'STD',
                'description' => 'Kamar standar nyaman dengan fasilitas dasar. Cocok untuk tamu yang membutuhkan akomodasi sederhana namun bersih.',
                'price_per_night' => 350000,
                'max_occupancy' => 2,
                'bed_type' => 'Single/Twin',
                'facilities' => ['AC', 'TV', 'WiFi', 'Kamar Mandi Pribadi', 'Handuk'],
            ],
            [
                'name' => 'Superior Room',
                'code' => 'SUP',
                'description' => 'Kamar superior dengan pemandangan kota dan fasilitas yang lebih lengkap dari kamar standar.',
                'price_per_night' => 550000,
                'max_occupancy' => 2,
                'bed_type' => 'Double/Queen',
                'facilities' => ['AC', 'TV LED', 'WiFi', 'Kamar Mandi Pribadi', 'Bathtub', 'Hair Dryer', 'Minibar'],
            ],
            [
                'name' => 'Deluxe Room',
                'code' => 'DLX',
                'description' => 'Kamar deluxe luas dengan dekorasi elegan dan fasilitas premium. Tersedia pemandangan kolam renang atau taman.',
                'price_per_night' => 850000,
                'max_occupancy' => 3,
                'bed_type' => 'Queen/King',
                'facilities' => ['AC', 'Smart TV', 'WiFi Premium', 'Bathtub & Shower', 'Hair Dryer', 'Minibar', 'Safe Box', 'Balcony'],
            ],
            [
                'name' => 'Junior Suite',
                'code' => 'JST',
                'description' => 'Junior Suite dengan ruang tamu terpisah, cocok untuk tamu bisnis atau keluarga kecil.',
                'price_per_night' => 1500000,
                'max_occupancy' => 3,
                'bed_type' => 'King',
                'facilities' => ['AC', 'Smart TV x2', 'WiFi Premium', 'Bathtub & Rain Shower', 'Living Room', 'Work Desk', 'Minibar', 'Safe Box', 'Breakfast Included'],
            ],
            [
                'name' => 'Suite Room',
                'code' => 'STE',
                'description' => 'Suite mewah dengan ruang tamu dan ruang makan terpisah. Fasilitas bintang 5 dengan layanan butler.',
                'price_per_night' => 2500000,
                'max_occupancy' => 4,
                'bed_type' => 'King',
                'facilities' => ['AC', 'Smart TV x3', 'WiFi Ultra', 'Jacuzzi', 'Rain Shower', 'Living & Dining Room', 'Pantry', 'Butler Service', 'Breakfast + Dinner', 'Airport Pickup'],
            ],
            [
                'name' => 'Presidential Suite',
                'code' => 'PST',
                'description' => 'Puncak kemewahan hotel. Dua lantai eksklusif dengan pemandangan 360° kota, layanan butler 24 jam, dan privasi total.',
                'price_per_night' => 5000000,
                'max_occupancy' => 6,
                'bed_type' => 'King + Extra Beds',
                'facilities' => ['AC Multi-Zone', 'Smart TV x5', 'WiFi Ultra', 'Private Pool', 'Jacuzzi', 'Full Kitchen', 'Dining Room', 'Butler 24 Jam', 'Limousine', 'All Meals', 'Meeting Room', 'Gym Access'],
            ],
        ];

        foreach ($types as $type) {
            RoomType::create($type);
        }

        // Create rooms for each type
        $roomData = [
            1 => [101, 102, 103, 104, 105, 106], // Standard - Floor 1
            2 => [201, 202, 203, 204, 205, 206], // Superior - Floor 2
            3 => [301, 302, 303, 304, 305],       // Deluxe - Floor 3
            4 => [401, 402, 403, 404],             // Junior Suite - Floor 4
            5 => [501, 502, 503],                  // Suite - Floor 5
            6 => [601],                             // Presidential - Floor 6
        ];

        foreach ($roomData as $typeId => $rooms) {
            foreach ($rooms as $roomNum) {
                Room::create([
                    'room_number' => (string)$roomNum,
                    'room_type_id' => $typeId,
                    'floor' => (int)substr($roomNum, 0, 1),
                    'status' => 'available',
                ]);
            }
        }
    }
}
