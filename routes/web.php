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
    });
// Backend Routes End
