<?php

namespace App\Services\Dashboard\Hotel\Restaurant;

use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\RestaurantItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RestaurantItemsService
{

    public function validatedData(array $data, $item_id = null)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
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
}
