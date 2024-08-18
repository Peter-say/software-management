<?php

namespace App\Models\HotelSoftware;

use App\Models\hotelSoftware\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function RoomImage()
    {
        $firstFile = $this->files()->first();
        if ($firstFile) {
            return asset('storage/' . $firstFile->file_path);
        }
        return null;
    }
}
