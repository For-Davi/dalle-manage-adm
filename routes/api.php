<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/reset', [AuthController::class, 'reset']);
Route::put('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth'])->group(function () {
    Route::prefix('enterprises')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/{enterpriseID}', [UserController::class, 'indexUsersByEnterprise']);
            Route::post('/{enterpriseID}', [UserController::class, 'createUserByEnterprise']);
            Route::put('/{userID}', [UserController::class, 'updateUserByEnterprise']);
            Route::delete('/{userID}', [UserController::class, 'deleteUserByEnterprise']);
        });

        Route::get('/', [EnterpriseController::class, 'index']);
        Route::post('/', [EnterpriseController::class, 'create']);
        Route::put('/{id}', [EnterpriseController::class, 'update']);
        Route::delete('/{id}', [EnterpriseController::class, 'delete']);
    });

    Route::prefix('users')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::put('/data', [UserController::class, 'updateProfile']);
            Route::put('/password', [UserController::class, 'updatePasswordProfile']);
        });

        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'create']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
    });

    Route::prefix('sellers')->group(function () {
        Route::prefix('registrations')->group(function () {
            Route::get('/', [SellerController::class, 'indexRegistration']);
        });

        Route::get('/', [SellerController::class, 'index']);
        Route::post('/', [SellerController::class, 'create']);
        Route::put('/{id}', [SellerController::class, 'update']);
        Route::delete('/{id}', [SellerController::class, 'delete']);
    });
});
