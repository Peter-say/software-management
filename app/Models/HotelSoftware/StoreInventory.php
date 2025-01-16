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

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function scopeIncomingInventory($query)
    {
        return $query->where('movement_type', 'incoming');
    }

    public function scopeOutgoingInventory($query)
    {
        return $query->where('movement_type', 'outgoing');
    }
}
