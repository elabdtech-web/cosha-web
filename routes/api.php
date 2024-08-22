<?php

use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\Passenger\PassengerController;
use App\Http\Controllers\Api\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ---------------- APIs of passenger with group ---------------- //

Route::group(['prefix' => 'passenger'], function () {
    Route::post('register', [PassportAuthController::class, 'registerPassenger']);
    Route::post('login', [PassportAuthController::class, 'loginPassenger']);
    Route::post('forget-password', [PassportAuthController::class, 'forgetPassword']);

    // Authenticated Routes of Passenger
    Route::middleware(['auth:api', 'role:passenger'])->group(function () {
        // Profile
        Route::get('profile', [PassengerController::class, 'index']);

        // Logout
        Route::post('logout', [PassengerController::class, 'logout']);
    });
    // End of Authenticated Routes of Passenger

});

// End of APIs of passenger with group


// ---------------- APIs of driver with group ---------------- //
Route::group(['prefix' => 'driver'], function () {
    Route::post('register', [PassportAuthController::class, 'registerdriver']);
    Route::post('login', [PassportAuthController::class, 'logindriver']);
    Route::post('forget-password', [PassportAuthController::class, 'forgetPassword']);

    // Authenticated Routes of driver
    Route::middleware(['auth:api', 'role:driver'])->group(function () {
        // Profile
        Route::get('profile', [DriverController::class, 'index']);

        // Logout
        Route::post('logout', [DriverController::class, 'logout']);
    });
    // End of Authenticated Routes of Driver

});
