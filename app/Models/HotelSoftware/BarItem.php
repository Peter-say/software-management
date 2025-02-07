<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class BarItem extends Model
{
    protected $guarded = [];

    public function bar()
    {
        return $this->belongsTo(Bar::class);
    }

    public function orders()
    {
        return $this->belongsToMany(BarOrder::class)->withPivot('qty');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    public function itemImage()
    {
        $image = $this->image;
        if ($image) {
            return getStorageUrl('hotel/bar/items/' . $image);
        }
        return null;
    }
}
