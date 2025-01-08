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

}
