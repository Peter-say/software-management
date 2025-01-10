<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class PurchaseStoreItem extends Model
{
    protected $guarded = [];

    public function storeItem()
    {
        return $this->belongsTo(StoreItem::class, 'store_item_id');
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
