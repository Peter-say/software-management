<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class StoreInventory extends Model
{
    protected $casts = [
        'date' => 'datetime',
    ];
    protected $guarded = [];

    public function storeItem()
    {
        return $this->belongsTo(StoreItem::class, 'item_id');
    }
}
