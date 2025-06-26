<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        // You can add any logic here if needed, such as fetching data for the landing page.
        return view('web.landing-page');
    }
}
