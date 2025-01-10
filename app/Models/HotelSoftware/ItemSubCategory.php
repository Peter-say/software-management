<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['item_category_id', 'hotel_id','name'];

    public function storeItem()
    {
        return $this->hasMany(StoreItem::class);
    }
}
