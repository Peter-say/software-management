<?php

namespace App\Models\HotelSoftware;

use App\Models\hotelSoftware\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantItem extends Model
{
    use HasFactory;

    protected $fillable = ['outlet_id', 'name', 'image', 'price', 'cost', 'description', 'is_available'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function orders()
    {
        return $this->belongsToMany(RestaurantOrder::class)->withPivot('qty');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }
    public function itemImage()
    {
        $image = $this->image;
        if ($image) {
            return asset('storage/hotel/restaurant/items/' . $image);
        }
        return null;
    }
}
