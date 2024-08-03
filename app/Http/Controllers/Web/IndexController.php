<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index()
    {
        if (view()->exists('welcomeview')) {
            return view('welcomeview'); // Show the welcome view if it exists
        } else {
            Log::info('Redirecting to login route');
            return redirect()->route('login'); // Redirect to login if the view does not exist
        }
    }
}
