<?php

namespace App\Models\HotelSoftware;

use App\Models\hotelSoftware\GuestPayment;
use App\Models\Payment;
use App\Models\User;
use App\Models\Wallet;
use App\Services\Dashboard\Hotel\Room\ReservationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Define relationship with Reservation
    public function reservations()
    {
        return $this->hasMany(ReservationService::class);
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

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
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
}
