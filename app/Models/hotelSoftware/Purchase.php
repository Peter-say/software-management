<?php

namespace App\Models\HotelSoftware;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id', 'item_category_id', 'description', 'purchase_date', 'amount',
        'note', 'store_id', 'status', 'total_amount', 'tax_amount', 'tax_rate', 'discount',
    ];
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\ItemCategory', 'item_category_id');
    }
    public function items()
    {
        return $this->hasMany('App\Models\PurchaseStoreItem', 'purchase_id');
    }
    public function storeItem()
    {
        return $this->hasMany('App\Models\StoreItem', 'purchase_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function purchasestoreItem(){
        return $this->hasMany(purchasestoreItem::class);
    }
    public function status()
    {
        $status = "";
        switch ($this->status) {
            case 1:
                $status = "Received";
                break;
            case 2:
                $status = "Partial";
                break;
            case 3:
                $status = "Ordered";
                break;
            case 4:
                $status = "Pending";
                break;

            default:
                # code...
                break;
        }
        return $status;
    }
}
