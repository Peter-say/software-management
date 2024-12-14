<?php

namespace App\Models\HotelSoftware;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function files()
    {
        return $this->belongsToMany(File::class, 'room_files', 'room_id', 'file_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function reservations()
    {
        return $this->hasMany(RoomReservation::class, 'room_id');
    }

    public function RoomImage()
    {
        $firstFile = $this->files()->first();
        if ($firstFile) {
            return asset('storage/' . $firstFile->file_path);
        }
        return null;
    }

    public function RoomImages()
    {
        $file = $this->files()->get();
        if ($file) {
            return $file;
        }
        return null;
    }

    
}
