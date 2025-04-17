<?php

namespace App\Models\HotelSoftware;

use App\Models\HotelSoftware\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HotelUser extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id', 'user_account_id', 'hotel_id', 'role', 'phone', 'photo', 'address', 'gender'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photo()
    {
        $photo = $this->photo;
        if ($photo) {
            return getStorageUrl('hotel/users/photos/' . $photo);
        }
        return getStorageUrl('dashboard/images/gallery/hotel1.jpg');
    }
}
