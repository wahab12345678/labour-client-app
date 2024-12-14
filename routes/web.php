<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

// Backend Routes
Route::get('/admin', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home'); // render login page here
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post'); // post login request

// Auth Middleware Routes
Route::middleware(['auth'])->group(function () {
    // route with prefix
    Route::prefix('dashboard')->group(function () {
        Route::middleware(['admin'])->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.dashboard');
        });
    });
});
