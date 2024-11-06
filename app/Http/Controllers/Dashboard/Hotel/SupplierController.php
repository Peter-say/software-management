<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Supplier;
use App\Models\User;
use App\Services\Dashboard\Hotel\Supplier\HotelSupplierService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplier_service;
    public function __construct(HotelSupplierService $supplier_service)
    {
        $this->supplier_service = $supplier_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.hotel.supplier.index', [
            'suppliers' => Supplier::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->supplier_service->save($request);
            return redirect()->route('dashboard.hotel.suppliers.index')->with('success_message', 'Supplier created successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.hotel.supplier.create', [
            'supplier' => $this->supplier_service->getById($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->supplier_service->save($request, $id);
            return redirect()->route('dashboard.hotel.suppliers.index')->with('success_message', 'Supplier updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Supplier not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->supplier_service->delete($id);
            return redirect()->route('dashboard.hotel.supplierss.index')->with('success_message', 'Supplier deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'supplier not found');
        } catch (Exception $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }
}
