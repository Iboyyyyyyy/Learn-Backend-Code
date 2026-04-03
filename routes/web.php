<?php

// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckAge;

// use App\Http\Controllers\CategoriesController;
// use App\Http\Controllers\UserController;





Route::get('/', [MainController::class, 'login']);

Route::middleware(CheckAge::class)->group(function () {
    Route::get('/welcome', [MainController::class, 'indexView']);
    Route::get('/dashboard', [MainController::class, 'dashboardView']);
    Route::get('/products', [MainController::class, 'indexView']);
});

Route::get('/products', [MainController::class, 'search'])->name('products.search');

Route::delete('/products/{id}', [MainController::class, 'destroy'])->name('products.destroy');

Route::post('/orders', [MainController::class, 'storeOrder'])->name('orders.store');

Route::post('/logininput', [LoginController::class, 'login'])->name('logininput');






// Product routes
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::put('/update', [ProductController::class, 'update'])->name('products.update');
