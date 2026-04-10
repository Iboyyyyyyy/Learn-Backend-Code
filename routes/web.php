<?php

// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\GoogleController;
// use App\Http\Middleware\CheckAge;

// use App\Http\Controllers\CategoriesController;
// use App\Http\Controllers\UserController;


Route::get('/redis-test', function () {
    Redis::set('test', 'OK');
    return Redis::get('test');
});


Route::get('/', [MainController::class, 'login']);

Route::middleware('checkage')->group(function () {
    Route::get('/Shopping_Page', [MainController::class, 'pos']);
    Route::get('/dashboard', [MainController::class, 'dashboardView']);
    Route::get('/product', [MainController::class, 'productview']);
});

// Route::get('/products', [MainController::class, 'search'])->name('products.search');

// Route::delete('/products/{id}', [MainController::class, 'destroy'])->name('products.destroy');

// Route::post('/orders', [MainController::class, 'storeOrder'])->name('orders.store');

Route::post('/logininput', [LoginController::class, 'login'])->name('logininput');






// Product routes
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::put('/update', [ProductController::class, 'update'])->name('products.update');

Route::post('/orders', [OrderController::class, 'store']);




// login with google
Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
