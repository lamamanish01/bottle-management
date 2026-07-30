<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CollectorController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\BottleTypeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'collectors' => CollectorController::class,
        'buyers' => BuyerController::class,
        'bottle-types' => BottleTypeController::class,
        'collections' => CollectionController::class,
        'sales' => SaleController::class,
        'payments' => PaymentController::class,
        // 'expenses' => ExpenseController::class,
    ]);
});

require __DIR__.'/auth.php';
