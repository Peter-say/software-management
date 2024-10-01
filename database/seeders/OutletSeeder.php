<?php

namespace Database\Seeders;

use App\Models\HotelSoftware\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Outlet::insert([
            [
              'hotel_id' => 1,
              'name' => 'Main Outlet',
              'type' => 'restaurant',
            ],
      
            [
                'hotel_id' => 1,
                'name' => 'Main Outlet',
                'type' => 'bar',
              ],
              [
                'hotel_id' => 1,
                'name' => 'Semi Outlet',
                'type' => 'restaurant',
              ],
          ]);
    }
}
