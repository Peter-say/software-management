<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Models\Requisition;
use App\Models\User;
use App\Services\Dashboard\Hotel\Requisition\RequisitionService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RequisitionController extends Controller
{
    protected $requisition_service;

    public function __construct()
    {
        $this->requisition_service = new RequisitionService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requisitions = Requisition::whereHas('hotel',  User::getAuthenticatedUser()->hotel->id)
        ->latest()->paginate(30);
        return view('dashboard.hotel.requisition.index', [
            'requisitions' => $requisitions,
            'sn' => $requisitions->firstItem(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.requisition.create', [
            'departments' => AppConstants::DEPARTMENTS,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->requisition_service->save($request);
            return redirect()->route('dashboard.hotel.requisitions.index')->with('success_message', 'Requisition created successfully');
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
        try {
            return view('dashboard.hotel.requisition.show', [
                'requisition' => $this->requisition_service->getById($id),
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.requisitions.index')->with('error_message', 'Requisition not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $requisition = $this->requisition_service->getById($id);
            return view('dashboard.hotel.store-item.create', [
                'requisition' => $requisition,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.requisitions.index')->with('error_message', 'Requisition not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->requisition_service->save($request, $id);
            return redirect()->route('dashboard.hotel.requisitions.index')->with('success_message', 'Requisition updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Requisition not found');
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
            $requisition = $this->requisition_service->getById($id);
            $requisition->delete();
            return redirect()->route('dashboard.hotel.requisitions.index')->with('success_message', 'Requisition deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.requisitions.index')->with('error_message', 'Requisition not found');
        } catch (Exception $e) {
            return redirect()->route('dashboard.hotel.requisitions.index')->with('error_message', $e->getMessage());
        }
    }
}
