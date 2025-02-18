<?php

namespace App\Http\Controllers\Dashboard\Hotel\Guest;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Hotel\Guest\GuestWalletService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
class GuestWalletController extends Controller
{

    protected $guest_wallet_service;
    public function __construct(GuestWalletService $guest_wallet_service)
    {
        $this->guest_wallet_service = $guest_wallet_service;
    }

  
    public function getWallet()
    {
        // recordDebitTransaction
    }

    public function creditGuestWallet(Request $request)
    {
        // dd($request->all());
        try {
         $wallet = $this->guest_wallet_service->recordCreditTransaction($request);
          return back()->with('success_message', 'wallet credit successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Guest Wallet not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }

    public function payWithGuestWallet(Request $request, $id = null)
    {
        try {
         $wallet = $this->guest_wallet_service->payWithGuestWallet($request, $id);
          return back()->with('success_message', 'Payment made successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Guest Wallet not found');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }
}
