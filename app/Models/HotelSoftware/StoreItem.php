<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'name',
        'item_category_id',
        'description',
        'unit_measurement',
        'qty',
        'for_sale',
        'code',
        'low_stock_alert',
        'cost_price',
        'selling_price',
        'image'
    ];
    public function category()
    {
        $category = "";
        switch ($this->item_category_id) {
            case 1:
                $category = "Food";
                break;
            case 2:
                $category = "Drink";
                break;
            case 3:
                $category = "Housekeeping";
                break;
            case 4:
                $category = "Maintenance";
                break;
            case 5:
                $category = "Staff";
                break;
            case 6:
                $category = "Administrative";
                break;
            case 7:
                $category = "Others";
                break;

            default:
                # code...
                break;
        }
        return $category;
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }
    public function itemSubCategory()
    {
        return $this->belongsTo(ItemSubCategory::class);
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function activities()
    {
        return $this->hasMany(StoreItemActivity::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // StoreItem.php
    public function restaurantItems()
    {
        return $this->belongsToMany(RestaurantItem::class, 'store_item_restaurant_item')
            ->withPivot('quantity');
    }

    public static function generateItemCode()
    {
        $randomString = strtoupper(mt_rand(0, 999999)); // Generates a 6 digit
        do {
            $code = $randomString;
        } while (self::where('code', $code)->exists());
        return $code;
    }

    public function storeInventory()
    {
        return $this->hasMany(StoreInventory::class, 'item_id');
    }

    public function incomingInventory()
    {
        return $this->storeInventory()->where('movement_type', 'incoming');
    }

    public function outgoingInventory()
    {
        return $this->storeInventory()->where('movement_type', 'outgoing');
    }
}
