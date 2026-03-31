<?php

// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

use App\Http\Controllers\ProductController;
// use App\Http\Controllers\CategoriesController;
// use App\Http\Controllers\UserController;

Route::get('/welcome', [MainController::class, 'indexView']);



Route::get('/', [MainController::class, 'login']);

Route::get('/products', [MainController::class, 'indexView']);

Route::get('/products', [MainController::class, 'search'])->name('products.search');

Route::delete('/products/{id}', [MainController::class, 'destroy'])->name('products.destroy');

Route::post('/orders', [MainController::class, 'storeOrder'])->name('orders.store');

Route::post('/logininput', [MainController::class, 'logininput'])->name('logininput');






// Product routes
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::put('/update', [ProductController::class, 'update'])->name('products.update');
