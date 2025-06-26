<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\LandingPageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [IndexController::class, 'index']);

Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing-page');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
