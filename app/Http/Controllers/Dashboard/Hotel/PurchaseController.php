<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Purchase;
use App\Models\User;
use App\Services\Dashboard\Hotel\Chart\PurchasesDashboardService;
use App\Services\Dashboard\Hotel\Purchase\PurchasesService;
use App\Services\Dashboard\Hotel\Purchase\PurchasesStatsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $purchases_service;
    protected $purchase_stat_service;
    protected $purchase_chart_service;

    public function __construct(PurchasesService $purchases_service)
    {
        $this->purchases_service = $purchases_service;
        $this->purchase_stat_service = new PurchasesStatsService();
        $this->purchase_chart_service = new PurchasesDashboardService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->latest()->paginate(50);
        return view('dashboard.hotel.purchases.index', [
            'purchases' => $purchases,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.purchases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->purchases_service->save($request);
            return redirect()->route('dashboard.hotel.purchases.index')->with('success_message', 'Purchase created successfully');
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
            $purchase = $this->purchases_service->getById($id);
            return view('dashboard.hotel.purchases.show', [
                'purchase' => $purchase,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.purchases.index')->with('error_message', 'Purchase not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $purchase = $this->purchases_service->getById($id);
            return view('dashboard.hotel.purchases.create', [
                'purchase' => $purchase,
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.purchases.index')->with('error_message', 'Purchase not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->purchases_service->save($request, $id);
            return redirect()->route('dashboard.hotel.purchases.index')->with('success_message', 'Purchase updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Purchase not found');
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
            $purchase = $this->purchases_service->getById($id);
            $purchase->delete();
            return redirect()->route('dashboard.hotel.purchases.index')->with('success_message', 'Purchase deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('dashboard.hotel.purchases.index')->with('error_message', 'Purchase not found');
        } catch (Exception $e) {
            return redirect()->route('dashboard.hotel.purchases.index')->with('error_message', $e->getMessage());
        }
    }

    public function overview(Request $request)
    {
        $period = $request->get('period', 'day');
        $chart_period = $request->get('chart_period', 'day');
        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'day';
        }
        if (!in_array($chart_period, ['day', 'week', 'month', 'year'])) {
            $chart_period = 'day';
        }
        $top_purchase = Purchase::whereHas('store', function ($store) {
            $store->where('store_id', User::getAuthenticatedUser()->hotel->id);
        })->limit(5)->get();
        return view('dashboard.hotel.purchases.dashboard', [
            'purchase_stats' => $this->purchase_stat_service->stats(['period' => $period]),
            'purchase_chart_data' => $this->purchase_chart_service->chartStats(['chart_period' => $chart_period]),
            'top_purchase' => $top_purchase,
        ]);
    }
}
