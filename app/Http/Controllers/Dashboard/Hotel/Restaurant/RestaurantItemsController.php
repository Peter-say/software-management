<?php

namespace App\Http\Controllers\Dashboard\Hotel\Restaurant;

use App\Services\Dashboard\Hotel\Restaurant\RestaurantItemsService;
use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use App\Models\HotelSoftware\RestaurantItem;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RestaurantItemsController extends Controller
{

    protected $restaurant_item_service;
    public function __construct(RestaurantItemsService $restaurant_item_service)
    {
        $this->restaurant_item_service = $restaurant_item_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the authenticated user's hotel
        $hotel = User::getAuthenticatedUser()->hotel;
        // Get all outlets associated with the hotel
        $outlets = $hotel->outlet->where('type', 'restaurant');
        // Get all restaurant items that belong to these outlets
        $restaurant_items = RestaurantItem::whereIn('outlet_id', $outlets->pluck('id'))->paginate(30);
        return view('dashboard.hotel.restaurant-item.index', [
            'restaurant_items' => $restaurant_items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.restaurant-item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->restaurant_item_service->save($request);
            return redirect()->route('dashboard.hotel.restaurant-items.index')->with('success_message', 'Restaurant item created successfully');
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
        return view('dashboard.hotel.restaurant-item.create', [
        'restaurant_item' => $this->restaurant_item_service->getById($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.hotel.restaurant-item.create', [
            'item' =>  $this->restaurant_item_service->getById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->restaurant_item_service->save($request);
            return redirect()->route('dashboard.hotel.restaurant-items.index')->with('success_message', 'Restaurant item updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Restaurant item not found');
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
            $this->restaurant_item_service->delete($id);
            return redirect()->route('dashboard.hotel.restaurant-items.index')->with('success_message', 'Restaurant item deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Restaurant item not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }
}
