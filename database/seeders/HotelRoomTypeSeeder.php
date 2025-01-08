<?php

namespace Database\Seeders;

use App\Models\HotelSoftware\RoomType;
use App\Helpers\FileHelpers;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HotelRoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $imageDirectory = glob(getStorageUrl('dashboard/images/room/*'));

        // Check if there are any images in the directory
        // if (empty($imageDirectory)) {
        //     throw new \Exception('No images found in the directory.');
        // }

        // Loop through your data array and seed RoomType and associated files
        $datas = [
            [
                'name' => 'Single',
                'hotel_id' => 1,
                'currency_id' => 1,
                'description' => 'Category description',
                'rate' => 35000,
                'discounted_rate' => 0,
            ],
            [
                'name' => 'Double',
                'hotel_id' => 1,
                'currency_id' => 1,
                'description' => 'Category description',
                'rate' => 65000,
                'discounted_rate' => 5000,
            ],
        ];

        foreach ($datas as $data) {
            // Create RoomType record
            $roomType = RoomType::create($data);

            // Pick a random image from the directory
            // $randomImagePath = $imageDirectory[array_rand($imageDirectory)];
            // if (!file_exists($randomImagePath)) {
            //     throw new \Exception("File does not exist: {$randomImagePath}");
            // }
            // // Create an UploadedFile instance
            // $uploadedFile = new UploadedFile(
            //     $randomImagePath,
            //     basename($randomImagePath),
            //     mime_content_type($randomImagePath),
            //     null,
            //     true
            // );

            // Upload the file using FileHelpers
            // $fileId = FileHelpers::saveFileRequest(
            //     null, //$uploadedFile,
            //     'hotel/room-type/images/',
            //     'Room type image',
            // );

            // Associate the file with the RoomType
            // $roomType->files()->attach($fileId);
        }
    }
}
