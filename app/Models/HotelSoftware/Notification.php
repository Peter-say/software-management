<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;
class Notification extends BaseDatabaseNotification
{
    use HasFactory;

    public function notifiable()
    {
        return $this->morphTo();
    }
}
