<?php

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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'indexPage'])
    ->name('home');

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/signup', [RegisterController::class, 'form'])->name('register');
    Route::post('/signup', [RegisterController::class, 'storeWithSession'])->name('register.post');

    Route::get('/signin', [LoginController::class, 'form'])->name('login');
    Route::post('/signin', [LoginController::class, 'storeWithSession'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::prefix('seo')->group(function () {
        Route::get('/history', [SeoController::class, 'history'])->name('history');

        Route::delete('/history/{id}', [SeoController::class, 'delete'])->name('history.delete');

        Route::post('/analyze', [SeoController::class, 'analyze'])->middleware('check.limit')
            ->name('analysis');

        Route::get('/analysis/{id}', [SeoController::class, 'analyzeId'])->name('analysis.id');
    });

    Route::get('/export/{id}', [SeoController::class, 'exportPdf'])->name('export.pdf');
    Route::post('/auth/signout', [LogoutController::class, 'storeWithSession'])->name('logout');

    Route::get('/{username}/editprofile', [UpdateWithoutPasswordController::class, 'form'])
        ->name('profile.edit');

    Route::put('/{username}/editprofile', [UpdateWithoutPasswordController::class, 'storeWithSession'])
        ->name('profile.update');

    Route::get('/{username}/changepassword', [UpdateOnlyPasswordController::class, 'form'])
        ->name('profile.password.edit');

    Route::put('/{username}/changepassword', [UpdateOnlyPasswordController::class, 'storeWithSession'])
        ->name('profile.password.update');

    Route::get('/{username}/deleteaccount', [DeleteController::class, 'form'])
        ->name('profile.delete.form');

    Route::delete('/{username}/deleteaccount', [DeleteController::class, 'storeWithSession'])
        ->name('profile.delete');
});

Route::get('/{username}', [DashboardController::class, 'profilePage'])
    ->name('profile.show');
