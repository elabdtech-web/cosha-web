<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

// Admin Login
Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'postLogin'])->name('admin.login');


Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');
    // Other admin routes
});
