<?php

namespace App\Models\HotelSoftware;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Stripe\Invoice;

class BarOrder extends Model
{
    protected $fillable = [
        'outlet_id',
        'hotel_id',
        'user_id',
        'guest_id',
        'order_date',
        'status',
        'amount',
        'tax_rate',
        'tax_amount',
        'discount_rate',
        'discount_type',
        'discount_amount',
        'total_amount',
        'walk_in_customer_id',
        'notes'
    ];

   public function outlet()
   {
       return $this->belongsTo(Outlet::class);
   }

   public function hotel()
   {
       return $this->belongsTo(Hotel::class);
   }

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function guest()
   {
       return $this->belongsTo(Guest::class);
   }

   public function walkInCustomer()
   {
       return $this->belongsTo(WalkInCustomer::class);
   }

   public function barOrderItems()
   {
       return $this->hasMany(BarOrderItem::class);
   }

   public function invoice()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function paymentStatus()
    {
        // Get the payments collection
        $payments = $this->payments()->get();

        // Calculate the total payment required from all related order items
        $totalPayment = $this->barOrderItems->sum('total_amount');

        // Check the payment status based on total payment and payments
        if ($payments->isEmpty()) {
            return 'pending';
        } elseif ($payments->sum('amount') < $totalPayment) {
            return 'partial';
        } else {
            return 'paid';
        }
    }

    public function items()
    {
        return $this->belongsToMany(BarItem::class, 'bar_order_items', 'bar_order_id', 'bar_item_id')
            ->withPivot('qty', 'amount');
    }
}
