<?php

namespace App\Models;
use App\Models\HotelSoftware\RoomReservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payable_id',
        'payable_type',
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'payment_method_token',
        'transaction_id',
        'status',
        'description',
    ];

    public function payable()
    {
        return $this->morphTo();
    }

    public function reservation()
    {
        return $this->belongsTo(RoomReservation::class, 'payable');
    }

    
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
