<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'file_id',
    ];

    public function File()
    {
        return $this->belongsToMany(File::class, 'file_id');
    }
}
