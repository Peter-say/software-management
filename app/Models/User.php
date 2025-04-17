<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship with HotelUser
    public function hotelUser()
    {
        return $this->hasOne(HotelUser::class);
    }

    // Relationship with Hotel through HotelUser
    public function hotel()
    {
        return $this->hasOneThrough(Hotel::class, HotelUser::class, 'user_id', 'id', 'id', 'hotel_id');
    }

    // public function hotel()
    // {
    //     return $this->hasOneThrough(Hotel::class, HotelUser::class, 'user_id', 'id', 'id', 'hotel_id');
    // }

    public static function getAuthenticatedUser()
    {
        return Auth::user();
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($guest) {
            Wallet::create([
                'user_id' => $guest->id,
                'balance' => 0, // Set initial balance
                'currency' => 'NG', // Default currency
            ]);
        });

        static::created(function ($user) {
            // $hotel =  Hotel::create([
            //     'user_id' => $user->id,
            //     'uuid' => Str::uuid(),
            // ]);
            // HotelUser::create([
            //     'user_id' => $user->id,
            //     'hotel_id' => $hotel->id,
            //     'user_account_id' => $user->id,
            // ]);
        });
    }
}
