<?php

namespace App\Models\HotelSoftware;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class HotelCurrency extends Model
{
    protected $guarded = [];
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
