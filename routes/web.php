<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\ClientController;
use Inertia\Inertia;
// VIEW
Route::get('/', function () {
    return Inertia::render('Auth');
})->name('login');
//AÇÕES
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');


Route::middleware(['auth'])->group(function () {

    Route::prefix('adm')->group(function () {
        // VIEW

        Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/enterprises', function () {
        return Inertia::render('Enterprises');
        })->name('enterprises');

        Route::get('/clients', function () {
        return Inertia::render('Clients');
        })->name('clients');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/enterprises', [EnterpriseController::class, 'index'])->name('enterprises');
        Route::get('/clients', [ClientController::class, 'index'])->name('clients');

        // ACTIONS
        Route::prefix('user')->group(function () {
        Route::put('/update-data', [UserController::class, 'updateData'])->name('user.update.data');
        Route::put('/update-password', [UserController::class, 'updatePassword'])->name('user.update.password');
    });
    });



//MANAGE
});
