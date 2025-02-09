<?php

namespace Database\Seeders;

use App\Constants\AppConstants;
use App\Models\HotelSoftware\HotelModulePreference;
use App\Models\HotelSoftware\ModulePreference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HotelModulePreferenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotel_id = 1;
        $selected_modules = AppConstants::MODULE_NAMES;
        foreach ($selected_modules as $module_name) {
            $module_preference = ModulePreference::create([
                'hotel_id' => $hotel_id,
                'name' => $module_name,
                'slug' => Str::slug($module_name),
            ]);
            HotelModulePreference::create([
                'hotel_id' =>  $hotel_id,
                'module_preference_id' => $module_preference->id,
            ]);
        }
    }
}
