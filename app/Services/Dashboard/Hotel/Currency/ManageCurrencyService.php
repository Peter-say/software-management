<?php

namespace App\Services\Dashboard\Hotel\Currency;

use App\Models\HotelSoftware\HotelCurrency;
use App\Models\User;

class ManageCurrencyService
{

    public function validate(array $data)
    {
        return validator($data, [
            'currency_id' => 'required|exists:currencies,id',
        ])->validate();
    }
  
    public function save(array $data)
    {
        $this->validate($data);
        $currency = HotelCurrency::updateOrCreate(
            ['hotel_id' => User::getAuthenticatedUser()->hotel->id],
            ['currency_id' => $data['currency_id']]
        );

        return $currency;
    }
}
