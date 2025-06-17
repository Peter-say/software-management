<?php

use App\Http\Controllers\API\V1\AI\ChatController;
use App\Http\Controllers\API\V1\Assistant\SeoAnalyzerController;
use App\Http\Controllers\API\V1\Auth\ForgetPasswordController;
use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::post('sign-out', [LoginController::class, 'logout'])->name('sign-out');
        Route::post('password/forget', [ForgetPasswordController::class, 'forgetPassword']);
        Route::post('password/reset', [ForgetPasswordController::class, 'ResetUserPassword']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('get-conversations', [ChatController::class, 'getUserConversation'])->name('get-conversations');
            Route::get('conversations/{uuid}', [ChatController::class, 'getConversationMessages'])->name('conversations');
            Route::post('chat-ai', [ChatController::class, 'ask'])->name('chat-ai');
            Route::delete('clear-conversation/{uuid}', [ChatController::class, 'clearConversation'])->name('clear-conversation');
            Route::delete('clear-conversations', [ChatController::class, 'clearConversations'])->name('clear-conversations');
            Route::prefix('assistant')->group(function () {
                Route::get('/seo/analyze', [SeoAnalyzerController::class, 'analyze'])->name('seo.analyze');
                 Route::post('/seo/save-analysis', [SeoAnalyzerController::class, 'save'])->name('seo.save-analysis');
            });
        });
        Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
