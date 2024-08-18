<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'hotel_id', 'description', 'rate', 'discounted_rate'
    ];

    public function files()
    {
        return $this->belongsToMany(File::class, 'room_type_files');
    }

    public function room()
    {
        return $this->hasMany(Room::class);
    }
}
