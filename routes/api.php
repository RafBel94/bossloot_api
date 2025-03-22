<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

// User routes
Route::resource('users', UserController::class)->except(['store'])->middleware(['auth:sanctum', 'role:admin']);
Route::post('register', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);
Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])->name('verification.verify');

// Product routes
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::post('products', [ProductController::class, 'store'])->middleware(['auth:sanctum', 'role:admin']);
Route::put('products/{id}', [ProductController::class, 'update'])->middleware(['auth:sanctum', 'role:admin']);
Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware(['auth:sanctum', 'role:admin']);
