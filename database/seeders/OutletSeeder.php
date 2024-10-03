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
        'name' => 'Main Restaurant',
        'type' => 'restaurant',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Main Bar',
        'type' => 'bar',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Pool Bar',
        'type' => 'bar',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Café',
        'type' => 'cafe',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Room Service',
        'type' => 'room_service',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Spa',
        'type' => 'spa',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Fitness Center',
        'type' => 'fitness_center',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Business Center',
        'type' => 'business_center',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Conference Room A',
        'type' => 'conference_room',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Conference Room B',
        'type' => 'conference_room',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Gift Shop',
        'type' => 'gift_shop',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Nightclub',
        'type' => 'nightclub',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Tennis Court',
        'type' => 'tennis_court',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Beach Club',
        'type' => 'beach_club',
      ],
      [
        'hotel_id' => 1,
        'name' => 'Cooking Class',
        'type' => 'cooking_class',
      ],
    ]);
  }
}
