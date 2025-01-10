<?php

namespace App\Services\Dashboard\Hotel\Purchase;

use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\Purchase;
use App\Models\HotelSoftware\PurchaseStoreItem;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PurchasesService
{
    public function validateData($data)
    {
        // dd($data);
        $validator = Validator::make($data, [
            'purchase_date' => 'required|date',
            'item_category_id' => 'required|exists:item_categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'store_item_id' => 'required|array',
            'store_item_id.*' => 'required|exists:store_items,id',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function getById($id)
    {
        $purchase = Purchase::with('items')->find($id);
        if (!$purchase) {
            throw new ModelNotFoundException('Purchase not found');
        }
        return $purchase;
    }

    public function save(Request $request, $purchase_id = null)
    {
        return DB::transaction(function () use ($request, $purchase_id) {
            $this->validateData($request->all());
            $hotel = User::getAuthenticatedUser()->hotel;
            $data = $request->except(['qty', 'unit_qty', 'rate', 'received', 'store_item_id', 'purchase_id', '_token', '_method']);
            // dd( $data);
            $sum_amount = array_sum($request->amount);

            $fieldsToFilter = ['store_item_id', 'qty', 'rate', 'received', 'amount', 'unit_qty'];
            foreach ($fieldsToFilter as $field) {
                if (!isset($request[$field]) || !is_array($request[$field])) {
                    $request[$request] = []; // Default to an empty array if not set or not an array
                } else {
                    $request[$field] = array_values(array_filter($request[$field]));
                }
            }
            if ($request->hasFile('file_path')) {
                $file_directory = 'hotel/purchase/files';
                $file_path = FileHelpers::saveImageRequest($request->file('file_path'), $file_directory);
                $data['file_path'] = basename($file_path);
                // Delete the old file if it exists
                if ($purchase_id) {
                    $purchase = $this->getById($purchase_id);
                    $old_file_path = $purchase->file_path;
                    if (!empty($old_file_path)) {
                        FileHelpers::deleteFiles([public_path($file_directory . '/' . $old_file_path)]);
                    }
                }
            }
            /* tax info and discount is not set now. 
            $data['discount'] = $data['discount'] ?? 0;
            $data['tax_rate'] = $data['tax_rate'] ?? 0;
            $data['tax_amount'] = $data['tax_amount'] ?? 0;
               this will be included when tax as been created for the hotel */
            $data['hotel_id'] = $hotel->id;
            $data['store_id'] = $hotel->store->id;
            $data['amount'] = $sum_amount;
            $data['total_amount'] = $sum_amount; /*Note: tax details will be calculated when set*/
            if ($purchase_id) {
                $purchase = $this->getById($purchase_id);
                $purchase->update($data);
            } else {
                $purchase = purchase::create($data);
            }
            foreach ($request->amount as $key => $amount) {
                if ($amount === null) {
                    continue; // Skip if the amont is null
                }
                PurchaseStoreItem::updateOrCreate(
                    [
                        'store_id' => $hotel->store->id,
                        'purchase_id' => $purchase->id,
                        'store_item_id' => $request->store_item_id[$key] ?? null,
                    ],
                    [
                        'qty' => $request['qty'][$key] ?? 1,
                        'rate' => $request['rate'][$key] ?? 0,
                        'amount' => $amount,
                        'unit_qty' => $request['unit_qty'][$key] ?? 1,
                        'received' => $request['received'][$key] ?? 0,
                        /* tax info and discount is not set now. 
                        'discount' => $data['discount'][$key] ?? null,
                        'tax_rate' => $data['tax_rate'][$key] ?? null,
                        'tax_amount' => $data['tax_amount'][$key] ?? null,
                          this will be included when tax as been created for the hotel */
                        'total_amount' => $sum_amount,
                    ]
                );
            }

            return $purchase;
        });
    }
}
