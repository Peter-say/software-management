<?php

namespace App\Services\Dashboard\Hotel\Room;

use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\RoomFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoomService{
    public function validated($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'nullable|string|max:255',
            'room_type' => 'required|exists:room_types,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function save(Request $request, $data)
    {
        // Validate the incoming data
        $validatedData = $this->validated($data);
    
        // Check if this is an update or create request
        $room = null;
        if (isset($validatedData['id'])) {
            // Update existing room
            $room = Room::find($validatedData['id']);
            if (!$room) {
                throw new Exception('Room not found');
            }
            $room->update($validatedData);
        } else {
            // Create a new room
            $room = Room::create($validatedData);
        }
    
        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileDirectory = 'hotel/room/files';
                Storage::disk('public')->makeDirectory( $fileDirectory);
                $fileId = FileHelpers::saveFileRequest($file, 'files', $fileDirectory);
                // Associate file with the room
                RoomFile::create([
                    'room_id' => $room->id,
                    'file_id' => $fileId,
                ]);
            }
        }
    
        return $room;
    }
    
}