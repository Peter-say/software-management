<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\CurrencyConstants;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Expense;
use App\Models\User;
use App\Services\Dashboard\Hotel\Expenses\ExpensesService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected $expenses_service;
    public function __construct(ExpensesService $expenses_service)
    {
        $this->expenses_service = $expenses_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expense = Expense::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->latest()->paginate(50);
        return view('dashboard.hotel.expenses.index', [
            'expenses' => $expense,
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
