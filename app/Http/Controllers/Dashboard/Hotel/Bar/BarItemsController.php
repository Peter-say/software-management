<?php

namespace App\Http\Controllers\Dashboard\Hotel\Bar;

use App\Services\Dashboard\Hotel\Bar\BarItemsService;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\barItem;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarItemsController extends Controller
{

    protected $bar_item_service;
    public function __construct(BarItemsService $bar_item_service)
    {
        $this->bar_item_service = $bar_item_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the authenticated user's hotel
        $hotel = User::getAuthenticatedUser()->hotel;
        // Get all outlets associated with the hotel
        $outlets = $hotel->outlet->where('type', 'bar');
        // Get all bar items that belong to these outlets
        $bar_items = barItem::whereIn('outlet_id', $outlets->pluck('id'))->latest()->paginate(30);
        return view('dashboard.hotel.bar-items.index', [
            'bar_items' => $bar_items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.bar-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->bar_item_service->save($request);
            return redirect()->route('dashboard.hotel.bar-items.index')->with('success_message', 'bar item created successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.hotel.bar-items.create', [
            'bar_item' => $this->bar_item_service->getById($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.hotel.bar-items.create', [
            'item' =>  $this->bar_item_service->getById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->bar_item_service->save($request);
            return redirect()->route('dashboard.hotel.bar-items.index')->with('success_message', 'bar item updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'bar item not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->bar_item_service->delete($id);
            return redirect()->route('dashboard.hotel.bar-items.index')->with('success_message', 'bar item deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'bar item not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    public function importItems(Request $request)
    {
        try {
            $message = $this->bar_item_service->importItems($request);
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirectUrl' => route('dashboard.hotel.bar-items.index')
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(),], 500); // Send a 500 response on error
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function truncateItems(Request $request)
    {
        dd($request->all());
        try {
            $message = $this->bar_item_service->trucateItems($request);
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Items not found']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(),], 500); // Send a 500 response on error
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
   
}
