<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showAuthForm'])->name('login');
Route::get('/reset-password/{token}', [UserController::class, 'showResetForm'])->name('reset.password')->where('token', '.*');

Route::middleware(['auth'])->group(function () {
    Route::prefix('adm')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'show'])->name('show.dashboard');
        Route::get('/enterprises', [EnterpriseController::class, 'show'])->name('show.enterprises');
        Route::get('/users', [UserController::class, 'show'])->name('show.users');
        Route::get('/subscriptions', [SubscriptionsController::class, 'show'])->name('show.subscriptions');

        Route::prefix('sellers')->group(function () {
            Route::get('/', [SellerController::class, 'show'])->name('show.sellers');

            Route::prefix('registrations')->group(function () {
                Route::get('/', [RegistrationController::class, 'show'])->name('show.registrations');
            });
        });
    });
});
