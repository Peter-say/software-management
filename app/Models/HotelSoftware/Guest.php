<?php

namespace App\Models\HotelSoftware;

use App\Models\Country;
use App\Models\hotelSoftware\GuestPayment;
use App\Models\Payment;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\Dashboard\Hotel\Room\ReservationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'birthday' => 'date',
    ];

    // Define relationship with Reservation
    public function reservations()
    {
        return $this->hasMany(RoomReservation::class);
    }

    /**
     * Get the full name of the guest.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        // Concatenate title, first name, last name, and other names
        $fullName = trim($this->title . ' ' . $this->first_name . ' ' . $this->last_name . ' ' . $this->other_names);
        // If the full name is empty, return a default message
        return $fullName ?: 'No Name Provided';
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function restaurantOrder()
    {
        return $this->hasMany(RestaurantOrder::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Define the created event listener
        static::created(function ($guest) {
            Wallet::create([
                'guest_id' => $guest->id,
                'balance' => 0, // Set initial balance
                'currency' => 'NGN', // Default currency
            ]);
        });
    }

    public function latestReservation()
    {
        return $this->reservations()
            ->whereNotNull('checked_in_at')
            ->latest('created_at')
            ->first();
    }

    public function purchaseHistory()
    {
        $latestReservation = $this->latestReservation();
        return $this->reservations()->whereNotNull('checked_in_at')->whereNotNull('checked_out_at')
            ->when($latestReservation, function ($query, $latestReservation) {
                return $query->where('id', '!=', $latestReservation->id);
            })->latest('checked_in_at')->get();
    }

    public function transactions()
    {
        // Retrieve transactions for wallet funding
        $walletTransactions = $this->morphMany(Payment::class, 'payable')
            ->where('payable_type', self::class) // App\Model\Hotelsoftware\Guest
            ->with('transactions'); // Load transactions for payments

        // Retrieve transactions for reservations
        $reservationTransactions = Payment::whereHasMorph('payable',[RoomReservation::class],
            function (Builder $query) {$query->where('guest_id', $this->id);
            })->with('transactions'); 

        return $walletTransactions->union($reservationTransactions);
    }


    public function transactionHistory()
    {
        return $this->transactions()->latest()->get();
    }
}
