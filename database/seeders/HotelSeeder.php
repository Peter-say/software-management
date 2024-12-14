<?php

namespace Database\Seeders;
use App\Models\hotelSoftware\Hotel as HotelSoftwareHotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use FontLib\Table\Type\name;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; 

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch the admin user to get their ID
        $adminUser = User::where('role', 'Admin')->first();

        if (!$adminUser) {
            throw new \Exception('Admin user not found. Make sure the UserSeeder has run successfully.');
        }

        // Seed the hotels table with some example data
        $hotel = HotelSoftwareHotel::create([
            'uuid' => Str::uuid(),
            'user_id' => $adminUser->id,
            'hotel_name' => 'Hotel Grand',
            'address' => '123 Main St, Grand City',
            'phone' => '09088556677',
            'state_id' => 1, // Adjust these IDs according to your states and countries
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
            'user_account_id' => $adminUser->id, // Adjust if needed
        ]);

    }
}
