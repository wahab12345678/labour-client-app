<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

// Backend Routes
Route::get('/admin', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home'); // render login page here
