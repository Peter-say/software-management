<?php

namespace App\Services\Dashboard\Hotel\Supplier;

use App\Models\hotelSoftware\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HotelSupplierService
{
    public function validatedData($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'contact_person_phone' => 'required|string|max:11',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_no' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $validated = $validator->validated();
        return $validated;
    }

    public function getById($id)
    {
        $supplier = Supplier::find($id);
        if (empty($supplier)) {
            throw new ModelNotFoundException("Supplier not found");
        }
        return $supplier;
    }

    public function save(Request $request, $supplier_id = null)
    {
        return DB::transaction(function () use ($request, $supplier_id) {
            // Validate the incoming data
            $validatedData = $this->validatedData($request->all(), $supplier_id);
            $validatedData['hotel_id'] = User::getAuthenticatedUser()->hotel->id;

            if ($request->supplier_id) {
                $supplier = $this->getById($supplier_id);
                $supplier->update($validatedData);
            } else {
                $supplier = Supplier::create($validatedData);
            }
            return $supplier;
        });
    }

    public function delete($id)
    {
        $supplier = $this->getById($id);
        $supplier->delete();
    }
}
