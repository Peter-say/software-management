<?php

namespace Database\Seeders;

use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; 

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('role', 'Admin')->first();

        if (!$adminUser) {
            throw new Exception('Admin user not found. Make sure the UserSeeder has run successfully.');
        }

        // Seed the hotels table with some example data
        $hotel = Hotel::create([
            'uuid' => Str::uuid(),
            'user_id' => $adminUser->id,
            'hotel_name' => 'Hotel Grand',
            'address' => '123 Main St, Grand City',
            'phone' => '09088556677',
            'state_id' => 1,
            'country_id' => 1,
            'logo' => null,
            'website' => 'http://hotelgrand.com',
        ]);

        // Create a hotel user for this hotel
        HotelUser::create([
            'hotel_id' => $hotel->id,
            'user_id' => $adminUser->id,
            'phone' => '09088556677',
            'photo' => null, // Adjust as needed
            'address' => '123 Main St, Grand City',
            'role' => 'Hotel_Owner',
            'status' => 'Active',
            'user_account_id' => $adminUser->id,
        ]);

    }
}
