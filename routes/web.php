<?php

use App\Http\Controllers\BottleTypeController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'users' => UserController::class,
        'collectors' => CollectorController::class,
        'buyers' => BuyerController::class,
        'bottle-types' => BottleTypeController::class,
        'collections' => CollectionController::class,
        'sales' => SaleController::class,
        'payments' => PaymentController::class,
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
        // 'expenses' => ExpenseController::class,
    ]);
});

require __DIR__.'/auth.php';
