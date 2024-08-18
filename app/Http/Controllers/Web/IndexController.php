<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index()
    {
        if (view()->exists('welcomeview')) {
            return view('welcomeview'); // Show the welcome view if it exists
        } else {
            if (Auth::check()) {
                return redirect()->route('dashboard.home'); // Redirect to dashboard homepage if the authenticated
            } else {
                return redirect()->route('login'); // Redirect to login if the view does not exist
            }
        }
    }
}
