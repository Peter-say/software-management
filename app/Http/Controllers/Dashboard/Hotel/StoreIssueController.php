<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\StoreIssue;
use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use App\Services\Dashboard\Hotel\Store\StoreIssueService;
use Exception;
use Illuminate\Http\Request;

class StoreIssueController extends Controller
{

    protected $store_issue_service;

    public function __construct()
    {
        $this->store_issue_service = new StoreIssueService();
    }


    public function index()
    {
        $store_issues = StoreIssue::whereHas('store', function ($query) {
            $query->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
        })->latest()->paginate(30);
        return view('dashboard.hotel.store-item.index', [
            'store_issues' => $store_issues,
            'sn' => $store_issues->firstItem(),
        ]);
    }

    public function create()
    {
        return view('dashboard.hotel.store-item-issue.create', [
            'recipients' => HotelUser::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->store_issue_service->save($request);
            return redirect()->back()->with('success_message', 'Item issued to ' . ($request->extenal_recipient_name ?? $request->recipient_name) . ' successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    public function getItemByCategory(Request $request)
    {
        $categoryId = $request->category_id;
        $items = StoreItem::where('item_category_id', $categoryId)
            ->select('id', 'name', 'code', 'unit_measurement', 'qty', 'low_stock_alert')
            ->orderBy('name', 'asc')->get();
        return response()->json(['items' => $items]);
    }
}
