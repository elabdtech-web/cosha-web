<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PassengerController;
use Illuminate\Support\Facades\Route;

// Admin Login
Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'postLogin'])->name('admin.login');


Route::prefix('admin')->middleware('auth', 'role:admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    // Other admin routes

    // Passengers
    Route::get('/passengers', [PassengerController::class, 'index'])->name('passengers');
    Route::get('/passenger/create', [PassengerController::class, 'create'])->name('passenger.create');
    Route::post('/passenger/store', [PassengerController::class, 'store'])->name('passenger.store');
    Route::get('/passenger/edit/{id}', [PassengerController::class, 'edit'])->name('passenger.edit');
    Route::post('/passenger/update/{id}', [PassengerController::class, 'update'])->name('passenger.update');
    Route::post('/passenger/update-status/{id}', [PassengerController::class, 'updateStatus'])->name('passenger.update.status');
    Route::get('/passenger/delete/{id}', [PassengerController::class, 'destroy'])->name('passenger.delete');
});
