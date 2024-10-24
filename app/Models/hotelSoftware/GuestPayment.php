<?php

namespace App\Models\hotelSoftware;

use App\Models\HotelSoftware\Guest;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestPayment extends Model
{
    protected $fillable = ['guest_id'];
    use HasFactory;

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }
}
