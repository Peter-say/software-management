<?php

namespace App\Services\Dashboard\Hotel\Store;

use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreItemService
{
    public function validated(array $data)
    {
        $validator = Validator::make($data, [
            'item_category_id' => 'required|exists:item_categories,id',
            'item_sub_category_id' => 'nullable|exists:item_sub_categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable',
            'description' => 'nullable|string',
            'unit_measurement' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'low_stock_alert' => 'nullable|numeric|min:0',
            'for_sale' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function getById($id)
    {
        $purchase = StoreItem::with('store')->find($id);
        if (!$purchase) {
            throw new ModelNotFoundException('Store Item not found');
        }
        return $purchase;
    }

    public function save(Request $request, $store_item_id = null)
    {
        return DB::transaction(function () use ($request, $store_item_id) {
            $store = User::getAuthenticatedUser()->hotel->store;
            $data = $this->validated($request->all());

            $data['code'] = StoreItem::generateItemCode();
            $data['store_id'] =  $store->id;

            if ($request->hasFile('image')) {
                $image_directory = 'hotel/store/items/files';
                $image_path = FileHelpers::saveImageRequest($request->file('image'), $image_directory);
                $data['image'] = basename($image_path);
                // Delete the old file if it exists
                if ($store_item_id) {
                    $purchase = $this->getById($store_item_id);
                    $old_image_path = $purchase->image;
                    if (!empty($old_image_path)) {
                        FileHelpers::deleteFiles([public_path($image_directory . '/' . $old_image_path)]);
                    }
                }
            }
            if ($store_item_id) {
                $store_item = $this->getById($store_item_id);
                $store_item->update($data);
            } else {
                $store_item = StoreItem::create($data);
            }
        });
    }
}
