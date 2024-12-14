<?php

namespace App\Models\HotelSoftware;

use App\Models\Country;
use App\Models\Payment;
use App\Models\State;
use App\Models\Wallet;
use App\Services\Dashboard\Hotel\Room\ReservationService;
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

    public function restaurantOrder(){
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

    public function purchaseHistory()
    {
        return $this->reservations()->whereNotNull('checked_in_at')
        ->whereNotNull('checked_out_at')
        ->latest('checked_in_at') // Order by the most recent check-in
        ->skip(1) // Skip the most recent reservation
        ->take(PHP_INT_MAX) // Set an arbitrarily large limit to get all remaining records
        ->get();
    }
}
