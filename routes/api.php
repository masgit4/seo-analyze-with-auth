<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\DeleteController;
use App\Http\Controllers\Profile\UpdateOnlyPasswordController;
use App\Http\Controllers\Profile\UpdateWithoutPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/signup', [RegisterController::class, 'storeOnce']);

    Route::post('/signin', [LoginController::class, 'storeOnce']);
});

Route::get('/profile/{username}', [DashboardController::class, 'apiOnlyUserProfile']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/analyze', [SeoController::class, 'analyzeApi']);

    Route::get('/history', function (Request $request) {
        return $request->user()->analyses()->latest()->get();
    });

    Route::post('/auth/signout', [LogoutController::class, 'storeOnce']);

    Route::get('/me', [DashboardController::class, 'apiProfile']);

    Route::put('/me/profile', [UpdateWithoutPasswordController::class, 'storeOnce']);

    Route::put('/me/password', [UpdateOnlyPasswordController::class, 'storeOnce']);

    Route::delete('/me/account', [DeleteController::class, 'storeOnce']);
});
