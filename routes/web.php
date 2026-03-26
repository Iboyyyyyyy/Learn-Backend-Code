<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\CategoriesController;

Route::get('/', [MainController::class, 'indexView']);


// Product routes
Route::get('/products', [MainController::class, 'indexView']);
Route::post('/products', [MainController::class, 'store'])->name('products.store');
// Route::get('/products/{product_name}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products', [MainController::class, 'search'])->name('products.search');
Route::put('/products', [MainController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [MainController::class, 'destroy'])->name('products.destroy');

// Order routes
Route::post('/orders', [MainController::class, 'storeOrder'])->name('orders.store');

// Categories routes
// Route::get('/', [CategoriesController::class, 'index']);
