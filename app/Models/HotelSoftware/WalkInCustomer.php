<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkInCustomer extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function restaurantOrders()
    {
        return $this->hasMany(RestaurantOrder::class, 'walk_in_customer_id');
    }
    public function barOrders()
    {
        return $this->hasMany(BarOrder::class, 'walk_in_customer_id');
    }
    public function walkInCustomerInfo()
    {
        return trim($this->name . ' - ' . $this->phone);
    }
}
