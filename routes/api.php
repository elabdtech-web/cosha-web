<?php

use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\Driver\DriverLicenseController;
use App\Http\Controllers\Api\Driver\DriverVehicleController;
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
        Route::post('profile/update', [PassengerController::class, 'updateProfile']);

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
        Route::post('profile/update', [DriverController::class, 'updateProfile']);

        // Driver Vehicle
        Route::get('vehicle', [DriverVehicleController::class, 'index']);
        Route::post('vehicle/update', [DriverVehicleController::class, 'updateVehicle']);

        // Driver License
        Route::get('license', [DriverLicenseController::class, 'index']);
        Route::post('license/update', [DriverLicenseController::class, 'updateLicense']);

        // Logout
        Route::post('logout', [DriverController::class, 'logout']);
    });
    // End of Authenticated Routes of Driver

});
