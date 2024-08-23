<?php

namespace App\Models\HotelSoftware;

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
}
