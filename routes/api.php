<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset', [AuthController::class, 'reset']);
Route::put('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('enterprises')->group(function () {

        Route::get('/', [EnterpriseController::class, 'index']);
        Route::get('/{enterprise}', [EnterpriseController::class, 'show']);
        Route::post('/', [EnterpriseController::class, 'create']);
        Route::put('/{enterprise}', [EnterpriseController::class, 'update']);
        Route::delete('/{enterprise}', [EnterpriseController::class, 'delete']);

        Route::prefix('{enterprise}/users')->group(function () {
            Route::get('/', [UserController::class, 'indexUsersByEnterprise']);
            Route::get('/{user}', [UserController::class, 'showUserByEnterprise']);
            Route::post('/', [UserController::class, 'createUserByEnterprise']);
            Route::put('/{user}', [UserController::class, 'updateUserByEnterprise']);
            Route::delete('/{user}', [UserController::class, 'deleteUserByEnterprise']);
        });
    });

    Route::prefix('users')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::put('/data', [UserController::class, 'updateProfile']);
            Route::put('/password', [UserController::class, 'updatePasswordProfile']);
        });

        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'create']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'delete']);
    });

    Route::prefix('sellers')->group(function () {
        Route::prefix('registrations')->group(function () {
            Route::get('/', [RegistrationController::class, 'index']);
            Route::delete('/{registration}', [RegistrationController::class, 'delete']);
        });

        Route::get('/', [SellerController::class, 'index']);
        Route::get('/{seller}', [SellerController::class, 'show']);
        Route::post('/', [SellerController::class, 'create']);
        Route::put('/{seller}', [SellerController::class, 'update']);
        Route::delete('/{seller}', [SellerController::class, 'delete']);
    });

    Route::prefix('subscriptions')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index']);
        // Route::put('/{id}', [SellerController::class, 'update']);
    });
});
