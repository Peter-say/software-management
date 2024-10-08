<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\Hotel\Outlet\OutletService;
use App\Models\HotelSoftware\Outlet;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OutletController extends Controller
{
    protected $outlet_service;
    public function __construct(OutletService $outlet_service)
    {
        $this->outlet_service = $outlet_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.hotel.outlet.index', [
            'outlets' => Outlet::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.outlet.create', [
            'outlets' => AppConstants::OUTLET_NAMES,
            'outlet_types' => AppConstants::OUTLET_TYPES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $this->outlet_service->save($request);
            return redirect()->route('dashboard.hotel.outlets.index')->with('success_message', 'outlet created successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred while creating the outlet.');
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
        return view('dashboard.hotel.outlet.create', [
            'outlets' => AppConstants::OUTLET_NAMES,
            'outlet_types' => AppConstants::OUTLET_TYPES
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        try {
            $this->outlet_service->save($request);
            return redirect()->route('dashboard.hotel.outlets.index')->with('success_message', 'outlet updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Outlet not found');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred while updating the outlet.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
