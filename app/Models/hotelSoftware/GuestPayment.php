<?php

namespace App\Models\hotelSoftware;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestPayment extends Model
{
    use HasFactory;

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
