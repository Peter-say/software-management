<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileHelpers
{

    public static function saveFileRequest($file, $directory)
    {
        // Check if the file was uploaded successfully
        if (!$file->isValid()) {
            throw new \Exception('File upload failed');
        }

        // Generate a unique file name
        $file_name = uniqid() . '_' . $file->getClientOriginalName();

        // Store the file in the specified directory within the storage folder
        Storage::disk('public')->put($directory . '/' . $file_name, file_get_contents($file));

        // Return the path to the saved file
        return $file_name;
    }


    public static function deleteFiles(array $imagePaths)
    {
        foreach ($imagePaths as $path) {
            if (file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }
    }
}
