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
        if (!$file->isValid()) {
            throw new \Exception('File upload failed');
        }
        $file_name = uniqid() . '_' . $file->getClientOriginalName();

        $destinationPath = public_path($directory);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $fileType = self::fileType($file->getClientOriginalExtension());
        $fileRecord = File::create([
            'file_name' => $file_name,
            'file_path' =>   $destinationPath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'type' =>  $fileType,
            'description' => $description,
        ]);

        return $fileRecord->id;
    }

    public static function saveImageRequest($file, $directory)
    {
        if (!$file->isValid()) {
            throw new \Exception('File upload failed');
        }
        $file_name = uniqid() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path($directory);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $file->move($destinationPath, $file_name);
        return $directory . '/' . $file_name;
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
