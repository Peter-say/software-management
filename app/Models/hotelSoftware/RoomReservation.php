<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReservation extends Model
{
    use HasFactory;

    protected $casts = [
        'checkin_date' => 'datetime',
        'checkout_date' => 'datetime',
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

    // Define relationship with Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
