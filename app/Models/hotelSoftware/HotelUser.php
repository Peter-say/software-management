<?php

namespace App\Models\HotelSoftware;

use App\Models\hotelSoftware\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelUser extends Model
{
    use HasFactory;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
