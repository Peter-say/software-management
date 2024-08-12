<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\hotelSoftware\Hotel as HotelSoftwareHotel;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        HotelSoftwareHotel::insert([
            [
                'user_id' => $adminUser->id,
                'hotel_name' => 'Hotel Grand',
                'address' => '123 Main St, Grand City',
                'phone' => '09088556677',
                'state_id' => 1, // Adjust these IDs according to your states and countries
                'country_id' => 1,
                'logo' => null,
                'website' => 'http://hotelgrand.com',
            ],
            // Add more hotel records as needed
        ]);
    }
}
