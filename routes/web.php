<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/clientes', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/fornecedores', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');

    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/pdv', [PosController::class, 'index'])->name('orders.pos');
    Route::get('/pedidos/produtos', [PosController::class, 'products'])->name('orders.pos.products');
    Route::post('/pedidos/pdv', [PosController::class, 'store'])->name('orders.pos.store');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/recebimentos', [PaymentController::class, 'index'])->name('payments.index');

    Route::post('/caixa/abrir', [CashRegisterController::class, 'store'])->name('cash-register.open');
    Route::post('/caixa/fechar', [CashRegisterController::class, 'close'])->name('cash-register.close');
});
