<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Hotel\Currency\ManageCurrencyService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ManageCurrencyController extends Controller
{
    protected $hotel_currency;
    public function __construct()
    {
        $this->hotel_currency = new ManageCurrencyService();
    }
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $this->hotel_currency->save($data);
            return redirect()->back()->with('success_message', 'Currency updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while updating the currency.');
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        try {
            $this->hotel_currency->save($data);
            return back()->with('success_message', 'Currency updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while updating the currency.');
        }
    }
}
