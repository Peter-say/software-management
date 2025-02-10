<?php

namespace App\Services\Dashboard\Hotel\Bar;

use App\Helpers\FileHelpers;
use App\Imports\BarItemImport;
use App\Models\HotelSoftware\BarItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class BarItemsService
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
        $item = BarItem::find($id);
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
            $imageDirectory = 'hotel/bar/items/';
            $imagePath = basename(FileHelpers::saveImageRequest($request->file('image'), $imageDirectory));
            $validatedData['image'] = $imagePath;
        }

        if ($item_id = $request->item_id) {
            // Update existing item
            $item = $this->getById($item_id);
            $item->update($validatedData);
        } else {
            // Create a new item
            $item = BarItem::create($validatedData);
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
        $import = new BarItemImport();
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
        $filePath = '';

        if ($request->current_url === url(route('dashboard.hotel.restaurant-items.index'))) {
            // Define base directory dynamically
            $basePublicPath = app()->environment('local')
                ? public_path('dashboard/samples/restaurant_menu_sample_with_ingredients.csv')
                : public_path('public/dashboard/samples/restaurant_menu_sample_with_ingredients.csv');

            $filePath = $basePublicPath;
        }

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }
        return response()->download($filePath);
    }


    public function generateImageForItems()
    {
        $items = BarItem::all();
    
        foreach ($items as $item) {
            $imageDirectory = 'hotel/bar/items';
            
            if (is_null($item->image) || !file_exists(public_path($imageDirectory . '/' . $item->image))) {
                $randomImagePath = $this->getRandomImages();
                
                if (file_exists($randomImagePath) && is_readable($randomImagePath)) {
                    if (!file_exists(public_path($imageDirectory))) {
                        mkdir(public_path($imageDirectory), 0755, true);
                    }
    
                    $fileName = basename($randomImagePath);
                    $destinationPath = public_path($imageDirectory . '/' . $fileName);
    
                    if (copy($randomImagePath, $destinationPath)) {
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
        $images = glob(getStoragePath('dashboard/drink/*'));
        $randomImage =  $images[array_rand($images)];
        if (empty($images)) {
            throw new \Exception('No images found in the specified directory.');
        }
        return $randomImage;
    }


    public function trucateItems()
    {
        $items = BarItem::all();
        if ($items->isEmpty()) {
            throw new ModelNotFoundException("Items not found");
        }
        $items->truncate(); // Truncate the items

        return "All items have been successfully deleted."; // Return a success message
    }
}
