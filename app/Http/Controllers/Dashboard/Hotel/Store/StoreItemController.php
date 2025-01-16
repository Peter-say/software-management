<?php

namespace App\Http\Controllers\Dashboard\Hotel\Store;

use App\Constants\CurrencyConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use App\Services\Dashboard\Hotel\Store\StoreItemService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class StoreItemController extends Controller
{
    protected $store_item_service;

    public function __construct()
    {
        $this->store_item_service = new StoreItemService();

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store_items = StoreItem::whereHas('store', function ($query) {
            $query->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
        })->latest()->paginate(30);
        return view('dashboard.hotel.store-item.index', [
            'store_items' => $store_items,
            'sn' => $store_items->firstItem(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.store-item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->store_item_service->save($request);
            return redirect()->route('dashboard.hotel.store-items.index')->with('success_message', 'store_item created successfully');
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
            return view('dashboard.hotel.store-item.show', [
                'store_item' => $this->store_item_service->getById($id),
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.store-items.index')->with('error_message', 'store_item not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $store_item = $this->store_item_service->getById($id);
            return view('dashboard.hotel.store-item.create', [
                'store_item' => $store_item,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.store-items.index')->with('error_message', 'store_item not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->store_item_service->save($request, $id);
            return redirect()->route('dashboard.hotel.store-items.index')->with('success_message', 'store_item updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Store item not found');
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
            $store_item = $this->store_item_service->getById($id);
            $store_item->delete();
            return redirect()->route('dashboard.hotel.store-items.index')->with('success_message', 'store_item deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.store-items.index')->with('error_message', 'store_item not found');
        } catch (Exception $e) {
            return redirect()->route('dashboard.hotel.store-items.index')->with('error_message', $e->getMessage());
        }
    }

    // public function overview(Request $request)
    // {
    //     $period = $request->get('period', 'day');
    //     $chart_period = $request->get('chart_period', 'day');
    //     if (!in_array($period, ['day', 'week', 'month', 'year'])) {
    //         $period = 'day';
    //     }
    //     if (!in_array($chart_period, ['day', 'week', 'month', 'year'])) {
    //         $chart_period = 'day';
    //     }
    //     $top_store_item = store_item::whereHas('store', function ($store) {
    //         $store->where('store_id', User::getAuthenticatedUser()->hotel->id);
    //     })->limit(5)->get();
    //     return view('dashboard.hotel.store_items.dashboard', [
    //         'store_item_stats' => $this->store_item_stat_service->stats(['period' => $period]),
    //         'store_item_chart_data' => $this->store_item_chart_service->chartStats(['chart_period' => $chart_period]),
    //         'top_store_item' => $top_store_item,
    //     ]);
    // }
}
