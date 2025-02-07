<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class BarOrderItem extends Model
{
    protected $fillable = ['bar_item_id', 'bar_order_id', 'qty', 'amount', 
    'tax_rate', 'tax_amount', 'discount_rate', 'discount_type', 'discount_amount', 'total_amount'];


    public function barOrder()
    {
        return $this->belongsTo(BarOrder::class);
    }

    public function barItem(){
        return $this->belongsTo(BarItem::class);
    }

    public function totalPayment()
    {
        return $this->total_amount;
    }
}
