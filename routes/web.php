<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('intro');
})->name('intro');

Route::get('/tienda', [ShopController::class, 'index'])->name('tienda');
Route::get('/tienda/{id}', [ShopController::class, 'show'])->name('shop.show');

// Rutas del carrito
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Rutas de Checkout
use App\Http\Controllers\CheckoutController;

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('cart.checkout');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
