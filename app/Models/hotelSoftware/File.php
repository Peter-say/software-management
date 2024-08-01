<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_files');
    }

    public function room()
    {
        return $this->belongsToMany(Room::class, 'room_files');
    }
}
