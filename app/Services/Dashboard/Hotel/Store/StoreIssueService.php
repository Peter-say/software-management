<?php

namespace App\Services\Dashboard\Hotel\Store;

use App\Models\HotelSoftware\StoreInventory;
use App\Models\HotelSoftware\StoreIssue;
use App\Models\HotelSoftware\StoreIssueStoreItem;
use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\returnSelf;

class StoreIssueService
{
    public function __construct() {}

    public function validated($data)
    {

        $validator = Validator::make($data, [
            'recipient_id' => 'nullable|exists:hotel_users,id',
            'outlet_id' => 'required|exists:outlets,id',
            'extenal_recipient_name' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
            'type' => 'nullable|in:issue,return',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    // public function validatedItem($data)
    // {
    //     $validator = Validator::make($data, [
    //         'items.*.qty' => 'required|numeric|min:1',
    //     ]);
    //     if ($validator->fails()) {
    //         throw new ValidationException($validator);
    //     }
    //     return $validator->validated();
    // }

    public function getById($id)
    {
        $purchase = StoreIssue::with('store')->find($id);
        if (!$purchase) {
            throw new ModelNotFoundException('Store Item not found');
        }
        return $purchase;
    }

    public function save(Request $request, $store_issue_id = null)
    {
        return DB::transaction(function () use ($request, $store_issue_id) {
            $data = $this->validated($request->only([
                'outlet_id',
                'recipient_id',
                'recipient_name',
                'note',
                // 'type',
            ]));
            $user = User::getAuthenticatedUser();
            $data['store_id'] = $user->hotel->store->id;
            $data['hotel_user_id'] = $user->hotelUser->id;

            if ($request->has('recipient_id')) {
                $data['recipient_id'] = $request->recipient_id;
            }
            if ($request->has('extenal_recipient_name')) {
                $data['extenal_recipient_name'] = $request->extenal_recipient_name;
            }
            if (empty($data['type'])) {
                $data['type'] = 'default';
            }
            if ($store_issue_id) {
                $store_issue = $this->getById($store_issue_id);
                $store_issue->update($data);
            } else {
                $store_issue = StoreIssue::create($data);
            }
            if (isset($request['items']) && is_array($request['items'])) {
                $data['items'] = array_filter($request['items'], function ($item) {
                    return isset($item['qty']) && $item['qty'] > 0;
                });
                if (empty($data['items'])) {
                    throw ValidationException::withMessages([
                        'items' => ['You must provide at least one item with a quantity greater than zero.']
                    ]);
                }
            }
            foreach ($data['items'] as $item) {
                StoreIssueStoreItem::create([
                    'store_id' => $data['store_id'],
                    'store_issue_id' => $store_issue->id,
                    'store_item_id' => $item['store_item_id'],
                    'qty' => $item['qty'],
                ]);
                StoreItem::where('id', $item['store_item_id'])->decrement('qty', $item['qty']);
                // Log the outgoing inventory movement
                StoreInventory::create([
                    'item_id' => $item['store_item_id'],
                    'store_id' => $user->hotel->store->id,
                    'hotel_id' => $user->hotel->id,
                    'movement_type' => 'outgoing',
                    'quantity' => $item['qty'],
                    'date' => now(),
                ]);
            }
            return $store_issue;
        });
    }
}
