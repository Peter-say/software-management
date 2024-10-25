<?php

namespace App\Models\hotelSoftware;

use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenOrder extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'status', 'started_at', 'completed_at', 'notes'];

    public function restaurantOrder()
    {
        return $this->belongsTo(RestaurantOrder::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
