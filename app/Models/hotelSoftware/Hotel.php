<?php

namespace App\Models\hotelSoftware;

use App\Models\HotelSoftware\HotelUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    public function hotelUser()
    {
        return $this->hasMany(HotelUser::class, 'hotel_id');
    }
}
