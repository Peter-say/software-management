<?php

namespace App\Models\HotelSoftware;

use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\Outlet as HotelSoftwareOutlet;
use App\Models\HotelSoftware\Room;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'hotel_name',
        'address',
        'phone',
        'state_id',
        'country_id',
        'logo',
        'website',
        'uuid',
        'user_id',
    ];

    // Relationship with HotelUser
    public function hotelUsers()
    {
        return $this->hasMany(HotelUser::class);
    }

    // Relationship with User through HotelUser
    public function users()
    {
        return $this->hasManyThrough(User::class, HotelUser::class);
    }

    public function room()
    {
        return $this->hasMany(Room::class, 'user_id');
    }

    public function outlet()
    {
        return $this->hasMany(HotelSoftwareOutlet::class);
    }

    public function defaultRestaurant()
    {
        return $this->outlet()->where('type', 'restaurant')->first();
    }

    public function defaultBar()
    {
        //return the first outlet that is a bar belonging to this hotel
        return $this->outlet()->where('type', 'bar')->first();
    }

    protected static function boot()
    {
        parent::boot();

        // Define the created event listener
        static::created(function ($hotel) {
            Store::create([
                'hotel_id' => $hotel->id,
                'name' => $hotel->hotel_name . "'s" . ' Store',
            ]);
        });
    }
    public function modulePreferences()
    {
        return $this->belongsToMany(ModulePreference::class, 'hotel_module_preferences');
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function bar()
    {
        return $this->hasMany(Bar::class);
    }
}
