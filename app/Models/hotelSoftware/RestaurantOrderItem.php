<?php

namespace App\Models;

use App\Models\HotelSoftware\RestaurantItem;
use App\Models\HotelSoftware\RestaurantOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantOrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['restaurant_item_id', 'restaurant_order_id', 'qty', 'amount', 
    'tax_rate', 'tax_amount', 'discount_rate', 'discount_type', 'discount_amount', 'total_amount'];

    public function restaurantOrder(){
        return $this->belongsTo(RestaurantOrder::class);
    }

    public function restaurantItem(){
        return $this->belongsTo(RestaurantItem::class);
    }
}
