<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    protected $fillable = ['name','hotel_id','type'];

    public function restaurantItems()
    {
        return $this->hasMany(RestaurantItem::class);
    }
}
