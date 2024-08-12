<?php

namespace App\Helpers;

use App\Models\HotelSoftware\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileHelpers
{

    public static function saveFileRequest($file, $directory, $description = null)
    {
        // Check if the file was uploaded successfully
        if (!$file->isValid()) {
            Log::error('File upload failed', [
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'directory' => $directory,
            ]);
            throw new \Exception('File upload failed');
        }

        // Generate a unique file name
        $file_name = uniqid() . '_' . $file->getClientOriginalName();

        // Store the file in the specified directory within the storage folder
        Storage::disk('public')->put($directory . '/' . $file_name, file_get_contents($file));

        // Determine the file type using the file extension
        $fileType = self::fileType($file->getClientOriginalExtension());

        // Create a record in the files table with additional information
        $fileRecord = File::create([
            'file_name' => $file_name,
            'file_path' => $directory . '/' . $file_name,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'type' =>  $fileType, // you can change this based on context
            'description' => $description,
        ]);

        return $fileRecord->id;
    }



    public static function deleteFiles(array $imagePaths)
    {
        foreach ($imagePaths as $path) {
            if (file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }
    }

    public static function fileType($extension)
    {
        // List of known extensions for each file type
        $imageExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp', 'bmp', 'svg'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'];
        $documentExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv'];
        $googleDocExtensions = ['gdoc', 'gsheet', 'gslides'];

        // Determine the type based on the file extension
        if (in_array(strtolower($extension), $imageExtensions)) {
            return 'Image';
        } elseif (in_array(strtolower($extension), $videoExtensions)) {
            return 'Video';
        } elseif (in_array(strtolower($extension), $documentExtensions)) {
            return 'Document';
        } elseif (in_array(strtolower($extension), $googleDocExtensions)) {
            return 'Google Document';
        } else {
            return 'Other';
        }
    }
}
