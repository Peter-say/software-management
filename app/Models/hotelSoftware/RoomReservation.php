<?php

namespace App\Models\HotelSoftware;

use App\Models\Payment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    use HasFactory;

    protected $casts = [
        'checkin_date' => 'datetime',
        'checkout_date' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'hotel_id',
        'guest_id',
        'room_id',
        'rate',
        'total_amount',
        'checkin_date',
        'checkout_date',
        'status',
        'checked_in_at',
        'checked_out_at',
        'bill_number',
        'reservation_code',
        'payment_status',
        'notes'
    ];

    // Define relationship with Guest
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // Define relationship with Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function calculateNight()
    {
        $from_date = Carbon::parse($this->checkin_date);
        $to_date = Carbon::parse($this->checkout_date);
        $date = $from_date->diffInDays($to_date);
        return $date;
    }
}
