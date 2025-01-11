<?php

namespace App\Services\Dashboard\Hotel\Requisition;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RequisitionService
{
    public function validated(array $data)
    {
        $validator = Validator::make($data, [
            'department' => 'required|string',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
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
            $hotel = User::getAuthenticatedUser()->hotel;
            $data = $this->validated($request->all());

            $data['hotel_id'] =  $hotel->id;

            if ($requisition_id) {
                $requisition = $this->getById($requisition_id);
                $requisition->update($data);
            } else {
                $requisition = Requisition::create($data);
            }
            foreach ($request->items as $item) {
                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? null,
                ]);
            }
        });
    }
}
