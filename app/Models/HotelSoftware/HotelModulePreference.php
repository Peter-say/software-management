<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class HotelModulePreference extends Model
{
    protected $fillable = ['hotel_id', 'module_preference_id'];

    public function modules()
    {
        return $this->belongsTo(ModulePreference::class);
    }
}
