<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Model;

class PaymentPlatform extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_url',
        'logo',
        'mode',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function hotelPaymentPlatforms()
    {
        return $this->hasMany(HotelPaymentPlatform::class);
    }
}
