<?php

namespace App\Models\HotelSoftware;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $casts = [
        'purchase_date' => 'datetime',
    ];
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }

    public function items()
    {
        return $this->belongsToMany(StoreItem::class, 'purchase_store_items')
            ->withPivot([
                'qty', 'rate', 'amount', 'unit_qty', 'received', 
                'discount', 'tax_rate', 'tax_amount', 'total_amount'
            ]);
    }

    public function getItems()
    {
        $itemsString = '';
        $itemNames = $this->items->map(function ($purchaseItem) {
            return $purchaseItem->name;
        })->toArray();

        $itemsString = implode(', ', $itemNames);
        return $itemsString;
    }


    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function paymentStatus()
    {
        $payments = $this->payments()->get();
        $totalPayment = $this->sum('amount');
        if ($payments->isEmpty()) {
            return 'pending';
        } elseif ($payments->sum('amount') < $totalPayment) {
            return 'partial';
        } else {
            return 'paid';
        }
    }

    public function storeItem()
    {
        return $this->hasMany(StoreItem::class, 'purchase_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function purchasestoreItem()
    {
        return $this->hasMany(PurchaseStoreItem::class);
    }
}
