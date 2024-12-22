<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::middleware('guest')->group(function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home'); // Render login page here
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post'); // Post login request
});
// Backend Routes Start
    // Auth Admin Role Middleware Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        });
        Route::prefix('category')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category');
            Route::get('/list', [\App\Http\Controllers\Admin\CategoryController::class, 'list'])->name('admin.category.list');
            Route::get('/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
            Route::put('/categories',  [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
        });
        Route::prefix('labour')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\LabourController::class, 'index'])->name('admin.labour');
            Route::get('/list', [\App\Http\Controllers\Admin\LabourController::class, 'list'])->name('admin.labour.list');
            Route::post('/store', [\App\Http\Controllers\Admin\LabourController::class, 'store'])->name('admin.labour.store');
            Route::put('/update',  [\App\Http\Controllers\Admin\LabourController::class, 'update'])->name('admin.labour.update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\LabourController::class, 'destroy'])->name('admin.labour.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\LabourController::class, 'toggleStatus'])->name('admin.labour.change-status');
        });
        Route::prefix('client')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('admin.client');
            Route::get('/list', [\App\Http\Controllers\Admin\ClientController::class, 'list'])->name('admin.client.list');
            Route::post('/store', [\App\Http\Controllers\Admin\ClientController::class, 'store'])->name('admin.client.store');
            Route::put('/update',  [\App\Http\Controllers\Admin\ClientController::class, 'update'])->name('admin.client.update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('admin.client.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\ClientController::class, 'toggleStatus'])->name('admin.client.change-status');
        });
        Route::prefix('booking')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('admin.booking');
            Route::get('/list', [\App\Http\Controllers\Admin\BookingController::class, 'list'])->name('admin.booking.list');
            Route::post('/store', [\App\Http\Controllers\Admin\BookingController::class, 'store'])->name('admin.booking.store');
            Route::put('/update',  [\App\Http\Controllers\Admin\BookingController::class, 'update'])->name('admin.booking.update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('admin.booking.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\BookingController::class, 'toggleStatus'])->name('admin.booking.change-status');
        });
    });
// Backend Routes End
