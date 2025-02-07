<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    protected $fillable = ['name', 'hotel_id'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function barItems()
    {
        return $this->hasMany(BarItem::class);
    }
}
