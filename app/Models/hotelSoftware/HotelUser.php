<?php

namespace App\Models\HotelSoftware;

use App\Models\hotelSoftware\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_account_id', 'hotel_id', 'role', 'phone', 'photo', 'address'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
