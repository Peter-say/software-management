<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        if (view()->exists('welcomeview')) {
            return view('welcomeview'); // Show the welcome view if it exists
        } else {
            return redirect()->route('login'); // Redirect to login if the view does not exist
        }
    }
}
