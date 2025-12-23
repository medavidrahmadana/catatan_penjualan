<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SaleController;

Route::resource('sales', SaleController::class);

use App\Http\Controllers\PaymentController;

Route::resource('payments', PaymentController::class);

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
