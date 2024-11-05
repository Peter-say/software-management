<?php

namespace App\Services\Dashboard\Hotel\Restaurant;

use App\Helpers\FileHelpers;
use App\Imports\RestaurantItemImport;
use App\Models\HotelSoftware\RestaurantItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class RestaurantItemsService
{

    public function validatedData(array $data, $item_id = null)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'outlet_id' => 'required|exists:outlets,id',
            'is_available' => 'boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
    public function getById($id)
    {
        $item = RestaurantItem::find($id);
        if (empty($item)) {
            throw new ModelNotFoundException("Item not found");
        }
        return $item;
    }
    public function save(Request $request, $item_id = null)
    {
        // Validate data, including the $item_id parameter
        $validatedData = $this->validatedData($request->all(), $item_id);

        // Set 'is_available' only if the 'publish' checkbox is checked
        $validatedData['is_available'] = $request->has('publish') ? true : false;

        // Handle file upload
        if ($request->hasFile('image')) {
            $imageDirectory = 'hotel/restaurant/items/';
            Storage::disk('public')->makeDirectory($imageDirectory);
            $imagePath = basename(FileHelpers::saveImageRequest($request->file('image'), $imageDirectory));
            $validatedData['image'] = $imagePath;
        }

        if ($item_id = $request->item_id) {
            // Update existing item
            $item = $this->getById($item_id);
            $item->update($validatedData);
        } else {
            // Create a new item
            $item = RestaurantItem::create($validatedData);
        }

        return $item;
    }

    public function delete($item_id)
    {
        $item = $this->getById($item_id);
        $item->delete();
    }

    public function importItems(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        $file = $request->file('file');
        $import = new RestaurantItemImport();
        Excel::import($import, $file);
        $this->generateImageForItems();
        $importedItemCount = $import->importedItemCount;
        $skippedItems = $import->skippedItems;

        $message = $importedItemCount . ' Items imported successfully.';

        if (count($skippedItems) > 0) {
            $message .= ' The following items were skipped because they already exist: ' . implode(', ', $skippedItems);
        }

        return $message;
    }

    public function download(Request $request)
    {
        if ($request->current_url === url(route('dashboard.hotel.restaurant-items.index'))) {
            $filePath = public_path('dashboard\samples\restaurant_menu_sample_with_ingredients.csv');
        }

        // Proceed with the download logic
        return response()->download($filePath);
    }

    public function generateImageForItems()
    {
        $items = RestaurantItem::all();
    
        foreach ($items as $item) {
            $imageDirectory = 'hotel/restaurant/items/';
            Storage::disk('public')->makeDirectory($imageDirectory);
    
            // Check if the item image is missing or the file doesn't exist
            if (is_null($item->image) || !Storage::disk('public')->exists($imageDirectory . $item->image)) {
                
                // Get a random image filename
                $randomImagePath = $this->getRandomImages(); // This should return the full path to the random image file
    
                // Verify the random image exists on the filesystem
                if (file_exists($randomImagePath) && is_readable($randomImagePath)) {
                    // Save the random image to the specified directory
                    $fileName = basename($randomImagePath);
                    $storageSuccess = Storage::disk('public')->put($imageDirectory . $fileName, file_get_contents($randomImagePath));
    
                    // Check if the image was successfully stored
                    if ($storageSuccess) {
                        // Update the item record with the new image filename
                        $item->update([
                            'image' => $fileName,
                        ]);
                    } else {
                        throw new \Exception('Failed to store the random image: ' . $fileName);
                    }
                } else {
                    throw new \Exception('Random image file does not exist or is not readable: ' . $randomImagePath);
                }
            }
        }
    }
    


    public function getRandomImages()
    {
        // Get a list of all images in the specified directory
        $images = glob(public_path('dashboard/food/*'));
        $randomImage =  $images[array_rand($images)];
        // Check if any images are found
        if (empty($images)) {
            throw new \Exception('No images found in the specified directory.');
        }
        // Return a random image's basename
        return $randomImage;
    }


    public function trucateItems()
    {
        $items = RestaurantItem::all();
        dd($items);
        if ($items->isEmpty()) {
            throw new ModelNotFoundException("Items not found");
        }
        $items->truncate(); // Truncate the items

        return "All items have been successfully deleted."; // Return a success message
    }
}
