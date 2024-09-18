<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PassengerController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\RideController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\WalletController;
use Illuminate\Support\Facades\Route;

// Admin Login
Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'postLogin'])->name('admin.login');

Route::prefix('admin')->middleware('auth', 'role:admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('/passengers', PassengerController::class);
    Route::post('/passenger/update-status/{id}', [PassengerController::class, 'updateStatus'])->name('passenger.update.status');
    Route::get('/passenger/delete/{id}', [PassengerController::class, 'destroy'])->name('passenger.delete');

    Route::resource('/drivers', DriverController::class);

    Route::get('/rides', [RideController::class, 'index'])->name('rides.index');
    Route::get('/rides/{ride}', [RideController::class, 'show'])->name('rides.show');

    Route::resource('/wallet', WalletController::class);

    Route::resource('/rewards', RewardController::class);

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');

});
