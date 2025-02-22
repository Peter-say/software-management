<?php

namespace App\Models\HotelSoftware;

use App\Models\hotelSoftware\Hotel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
            return getStorageUrl($firstFile->file_path);
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

    public function scopeSearchRooms(Builder $query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                ->orWhereHas('roomType', function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('rate', 'LIKE', "%{$searchTerm}%");
                });
        });
    }

    public function isAvailable($checkin_date, $checkout_date)
    {
        // If no reservations, the room is available
        if (!$this->reservations()->exists()) {
            return true;
        }
    
        if (!$checkin_date || !$checkout_date) {
            return true; // If missing dates, assume available
        }
    
        $checkin_date = $checkin_date;
        $checkout_date = $checkout_date;
    
        return !$this->reservations()
            ->where(function ($query) use ($checkin_date, $checkout_date) {
                $query->where(function ($q) use ($checkin_date, $checkout_date) {
                    $q->where('checkin_date', '<', $checkout_date)
                      ->where('checkout_date', '>', $checkin_date);
                })->orWhere(function ($q) use ($checkin_date, $checkout_date) {
                    $q->where('checkin_date', '<=', $checkin_date)
                      ->where('checkout_date', '>', $checkin_date);
                });
            })
            ->whereNull('checked_out_at')
            ->exists();
    }
    
}
