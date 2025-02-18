<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelPaymentPlatform extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'payment_platform_id',
        'public_key',
        'secret_key',
        'is_enabled',
        'extra_config',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'extra_config' => 'array', 
    ];

    // Relationship: Belongs to a hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function paymentPlatform()
    {
        return $this->belongsTo(PaymentPlatform::class);
    }
}
