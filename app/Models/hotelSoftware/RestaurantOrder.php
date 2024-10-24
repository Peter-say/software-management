<?php

namespace App\Models\HotelSoftware;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Invoice;

class RestaurantOrder extends Model
{
    use HasFactory;

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

    public function restaurantOrderItems()
    {
        return $this->hasMany(RestaurantOrderItem::class);
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
        $totalPayment = $this->restaurantOrderItems->sum('total_amount');

        // Check the payment status based on total payment and payments
        if ($payments->isEmpty()) {
            return 'pending';
        } elseif ($payments->sum('amount') < $totalPayment) {
            return 'partial';
        } else {
            return 'paid';
        }
    }

    public function kitchenOrder()
    {
        return $this->hasMany(KitchenOrder::class, 'order_id');
    }
   
    public function items()
    {
        return $this->belongsToMany(RestaurantItem::class, 'restaurant_order_items', 'restaurant_order_id', 'restaurant_item_id')
            ->withPivot('qty', 'price', 'amount');
    }

    protected static function booted()
    {
        // Listen for the created event
        static::created(function ($restaurant_order) {
            // Create an invoice for the bar order
            //$restaurant_order->createInvoice();
        });
    }

    public function getItems()
    {
        $itemsString = '';
        $items = $this->items()->pluck('name')->toArray();

        $itemsString = implode(', ', $items);
        return $itemsString;
    }
}
