<?php

use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// VIEW
Route::get('/', function () {
    return Inertia::render('Auth');
})->name('login');
Route::get('/reset-password/{token}', [UserController::class, 'showResetForm'])->name('reset.password')->where('token', '.*');

// AÇÕES
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
Route::post('/reset', [UserController::class, 'reset'])->name('verify.reset');
Route::put('/reset-password', [UserController::class, 'resetPassword'])->name('user.reset');

Route::middleware(['auth'])->group(function () {

    Route::prefix('adm')->group(function () {
        // VIEW

        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/enterprises', [EnterpriseController::class, 'index'])->name('enterprises');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/subscriptions', [SubscriptionsController::class, 'index'])->name('subscriptions');

        // ACTIONS
        Route::prefix('user')->group(function () {
            Route::put('/update-data', [UserController::class, 'updateData'])->name('user.update.data');
            Route::put('/update-password', [UserController::class, 'updatePassword'])->name('user.update.password');
        });

        Route::prefix('enterprise')->group(function () {
            Route::post('/create', [EnterpriseController::class, 'create'])->name('enterprise.create');
            Route::put('/update/{id}', [EnterpriseController::class, 'update'])->name('enterprise.update');
            Route::delete('/delete/{id}', [EnterpriseController::class, 'delete'])->name('enterprise.delete');
        });

        Route::prefix('users')->group(function () {
            Route::post('/create', [UserController::class, 'create'])->name('user.create');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
            Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        });
    });

    // MANAGE
});
