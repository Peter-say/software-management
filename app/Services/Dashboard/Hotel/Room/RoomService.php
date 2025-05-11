<?php

namespace App\Services\Dashboard\Hotel\Room;

use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\RoomFile;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomService
{
    public function validated($data)
    {

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'nullable|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function save(Request $request, $data)
    {
        $validatedData = $this->validated($data);
        if (isset($data['id'])) {
            $validatedData['id'] = $data['id'];
        }
        $validatedData['hotel_id'] = User::getAuthenticatedUser()->hotel->id;
        if (isset($validatedData['id'])) {
            $room = Room::find($validatedData['id']);
            if (!$room) {
                throw new Exception('Room not found');
            }
            $room->update($validatedData);
        } else {
            $room = Room::create($validatedData);
        }
        if ($request->hasFile('file_upload')) {
            foreach ($request->file('file_upload') as $file) {
                $fileDirectory = 'hotel/room/files';
                $fileId = FileHelpers::saveFileRequest($file, $fileDirectory);
                RoomFile::create([
                    'room_id' => $room->id,
                    'file_id' => $fileId,
                ]);
            }
        }

        return $room;
    }

    public function availableRooms()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $available_rooms = Room::with('roomType')
            ->where('hotel_id', $hotel->id)
            ->whereDoesntHave('reservations', function ($query) {
                $query->whereNull('checked_in_at');
                $query->whereNull('checked_out_at');
            });

        return $available_rooms;
    }

    public function occupiedRooms()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $occupied_rooms = Room::with('roomType')
            ->where('hotel_id', $hotel->id)
            ->whereHas('reservations', function ($query) {
                $query->whereNotNull('checked_out_at');
            });

        return $occupied_rooms;
    }
}
