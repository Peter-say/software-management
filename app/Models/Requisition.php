<?php

namespace App\Models;

use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function hotelUser()
    {
        return $this->belongsTo(HotelUser::class);
    }
}
