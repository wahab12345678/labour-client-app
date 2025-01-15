<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/about', [\App\Http\Controllers\Frontend\HomeController::class, 'about'])->name('about');
Route::get('/client_register', [\App\Http\Controllers\Frontend\HomeController::class, 'client'])->name('client_register');
Route::post('/client_register', [\App\Http\Controllers\Frontend\HomeController::class, 'storeClient'])->name('client_register.store');
Route::get('/contact', [\App\Http\Controllers\Frontend\HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\Frontend\HomeController::class, 'storeContact'])->name('contact.store');
Route::get('/services', [\App\Http\Controllers\Frontend\HomeController::class, 'services'])->name('services');
Route::get('/services/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'serviceDetail'])->name('service.details');
Route::get('/contractor/details/{slug}', [\App\Http\Controllers\Frontend\HomeController::class, 'contractorDetail'])->name('contractor.details');

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
            Route::post('/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.category.create');
            Route::post('/update',  [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.change-status');
            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\CategoryController::class,  'edit'])->name('categories.edit');

        });
        Route::prefix('labour')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\LabourController::class, 'index'])->name('admin.labour');
            Route::get('/list', [\App\Http\Controllers\Admin\LabourController::class, 'list'])->name('admin.labour.list');
            Route::post('/store', [\App\Http\Controllers\Admin\LabourController::class, 'store'])->name('admin.labour.store');
            Route::post('/update', [\App\Http\Controllers\Admin\LabourController::class, 'update'])->name('admin.labour.update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\LabourController::class, 'destroy'])->name('admin.labour.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\LabourController::class, 'toggleStatus'])->name('admin.labour.change-status');

            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\LabourController::class,  'edit'])->name('labour.edit');

        });
        Route::prefix('Contractor')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ContractorController::class, 'index'])->name('admin.contractor');
            Route::get('/list', [\App\Http\Controllers\Admin\ContractorController::class, 'list'])->name('admin.contractor.list');
            Route::post('/store', [\App\Http\Controllers\Admin\ContractorController::class, 'store'])->name('admin.contractor.store');
            Route::post('/update', [\App\Http\Controllers\Admin\ContractorController::class, 'update'])->name('admin.contractor.update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\ContractorController::class, 'destroy'])->name('admin.contractor.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\ContractorController::class, 'toggleStatus'])->name('admin.contractor.change-status');

            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\ContractorController::class,  'edit'])->name('labour.edit');

        });
        Route::prefix('client')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('admin.client');
            Route::get('/list', [\App\Http\Controllers\Admin\ClientController::class, 'list'])->name('admin.client.list');
            Route::post('/store', [\App\Http\Controllers\Admin\ClientController::class, 'store'])->name('admin.client.store');
            Route::post('/update',  [\App\Http\Controllers\Admin\ClientController::class, 'update'])->name('admin.client.update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('admin.client.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\ClientController::class, 'toggleStatus'])->name('admin.client.change-status');

            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\ClientController::class,  'edit'])->name('admin.client.edit');

        });
        Route::prefix('booking')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('admin.booking');
            Route::get('/list', [\App\Http\Controllers\Admin\BookingController::class, 'list'])->name('admin.booking.list');
            Route::post('/store', [\App\Http\Controllers\Admin\BookingController::class, 'store'])->name('admin.booking.store');
            Route::post('/update',  [\App\Http\Controllers\Admin\BookingController::class, 'update'])->name('admin.booking.update');
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('admin.booking.destroy');
            Route::post('/change-status', [\App\Http\Controllers\Admin\BookingController::class, 'toggleStatus'])->name('admin.booking.change-status');

            Route::get('/edit/{id}', [\App\Http\Controllers\Admin\BookingController::class,'edit'])->name('admin.booking.edit');

        });
        Route::prefix('review')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.review');
            Route::get('/list', [\App\Http\Controllers\Admin\ReviewController::class, 'list'])->name('admin.review.list');
            // Route::post('/store', [\App\Http\Controllers\Admin\ReviewController::class, 'store'])->name('admin.review.store');
            // Route::put('/update',  [\App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('admin.review.update');
            // Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.review.destroy');
            // Route::post('/change-status', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleStatus'])->name('admin.review.change-status');
        });
    });
// Backend Routes End
