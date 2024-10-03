<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'hotel_id'];
    public function hotel()
    {
        $this->belongsTo(Hotel::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function storeItem()
    {
        return $this->hasMany(StoreItem::class, 'store_id');
    }
    
}
