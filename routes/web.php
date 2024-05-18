<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;

// Authentication Routes
Auth::routes();

// Home Route (After Login)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Item Routes
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create'); // Ensure this line is present
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');

// Cart Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{itemId}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

    // Order Routes
    Route::get('/orders/{id}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('orders.show');
});
