<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class ModulePreference extends Model
{
    protected $guarded = [];

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_module_preferences');
    }

    public function hotelModulePreferences()
    {
        return $this->hasMany(HotelModulePreference::class, 'module_preference_id');
    }
}
