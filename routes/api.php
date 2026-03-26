<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\MainOrderController;
use App\Http\Controllers\API\OrderController;



// Product API routes
Route::get('products', [ProductController::class, 'index']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);



// Categories API routes
Route::get('categories', [CategoriesController::class, 'index']);
Route::post('categories', [CategoriesController::class, 'store']);
Route::get('categories/{id}', [CategoriesController::class, 'show']);
Route::put('categories/{id}', [CategoriesController::class, 'update']);
Route::delete('categories/{id}', [CategoriesController::class, 'destroy']);



// Order API routes
Route::get('orders', [OrderController::class, 'index']);

// Main Order API routes
Route::get('main-orders', [MainOrderController::class, 'getdata']);
Route::post('main-orders', [MainOrderController::class, 'store']);
