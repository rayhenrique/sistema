<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/clientes', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/fornecedores', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');

Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');

Route::get('/recebimentos', [PaymentController::class, 'index'])->name('payments.index');
