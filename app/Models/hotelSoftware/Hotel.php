<?php

namespace App\Models\hotelSoftware;

use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'hotel_name',
        'address',
        'phone',
        'state_id',
        'country_id',
        'logo',
        'website',
        'uuid',
        'user_id',
    ];

    public function hotelUser()
    {
        return $this->hasMany(HotelUser::class, 'hotel_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function room()
    {
        return $this->hasMany(Room::class, 'user_id');
    }
}
