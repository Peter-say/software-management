<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\CurrencyConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Expense;
use App\Models\User;
use App\Services\Dashboard\Hotel\Chart\DashboardExpensesService;
use App\Services\Dashboard\Hotel\Expenses\ExpensesService;
use App\Services\Dashboard\Hotel\Expenses\ExpensesStatsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected $expenses_service;
    protected $expenses_stat_service;
    protected $expenses_chart_service;
    public function __construct(ExpensesService $expenses_service)
    {
        $this->expenses_service = $expenses_service;
        $this->expenses_stat_service = new ExpensesStatsService();
        $this->expenses_chart_service = new DashboardExpensesService();
    }

    public function dashboard(Request $request)
    {
        $period = $request->get('period', 'day');
        $chart_period = $request->get('chart_period', 'day');
        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'day';
        }
        if (!in_array($chart_period, ['day', 'week', 'month', 'year'])) {
            $chart_period = 'day';
        }
        $top_expenses = Expense::where('hotel_id', User::getAuthenticatedUser()->hotel->id)
            ->orderBy('amount', 'desc')->limit(5)->get();
        return view('dashboard.hotel.expenses.dashboard', [
            'expenses_stats' => $this->expenses_stat_service->stats(['period' => $period]),
            'expenses_chart_data' => $this->expenses_chart_service->chartStats(['chart_period' => $chart_period]),
            'top_expenses' => $top_expenses,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->latest()->paginate(50);
        return view('dashboard.hotel.expenses.index', [
            'expenses' => $expenses,
            'payableType' => get_class(new Expense()),
            'currencies' => CurrencyConstants::CURRENCY_CODES,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.hotel.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $this->expenses_service->save($request);
            return redirect()->route('dashboard.hotel.expenses.index')->with('success_message', 'Expenses created successfully');
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
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense =  $this->expenses_service->getById($id);
        foreach ($expense->items as $item) {
            // dd($expense->items, $item);
        }

        return view('dashboard.hotel.expenses.create',  [
            'expense' => $this->expenses_service->getById($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->expenses_service->save($request, $id);
            return redirect()->route('dashboard.hotel.expenses.index')->with('success_message', 'Expenses updated successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Expense not found');
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
        //
    }
}
