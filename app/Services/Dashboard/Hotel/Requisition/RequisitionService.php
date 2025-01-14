<?php

namespace App\Services\Dashboard\Hotel\Requisition;

use App\Models\HotelSoftware\HotelUser;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\User;
use App\Notifications\StoreItemRequisitionNotification;
use App\Services\RoleService\HotelServiceRole;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RequisitionService
{
    public function validated(array $data)
    {
        $validator = Validator::make($data, [
            'purpose' => 'required|string',
            'department' => 'required|string',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function getById($id)
    {
        $purchase = Requisition::with('hotel')->find($id);
        if (!$purchase) {
            throw new ModelNotFoundException('Requisition not found');
        }
        return $purchase;
    }

    public function save(Request $request, $requisition_id = null)
    {
        return DB::transaction(function () use ($request, $requisition_id) {
            $user = User::getAuthenticatedUser();
            $this->validated($request->all());
            $data = $request->except(['item_name', 'quantity', 'unit', 'requisition_id', 'items', '_token']);
            $data['hotel_id'] =  $user->hotel->id;
            $data['hotel_user_id'] =  $user->hotelUser->id;
            if ($requisition_id) {
                $requisition = $this->getById($requisition_id);
                $requisition->update($data);
            } else {
                $requisition = Requisition::create($data);
            }
            foreach ($request->items as $item) {
              $requisitionItem =  RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? null,
                ]);
            }
            // Notify store staff
            $user = Auth::user();
            $roleService = new HotelServiceRole();
            $storeStaff = HotelUser::whereIn('role', $roleService->userCanAccessStoreRole())->get();
            foreach ($storeStaff as $staff) {
                if ($staff->user && $staff->user->email) {
                    $staff->user->notify(new StoreItemRequisitionNotification($requisitionItem, $staff->user, $roleService));
                }
            }
        });
    }
}
