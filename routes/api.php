<?php

use App\Http\API\Controllers\VerificationController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

// User routes
Route::resource('users', UserController::class)->except(['store'])->middleware(['auth:sanctum', 'role:admin']);
Route::post('register', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);

// Verification routes
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/check-verification', [VerificationController::class, 'checkEmailVerified'])->name('verification.check');
Route::post('/resend-verification', [VerificationController::class, 'resendVerification'])->name('verification.resend');

// Product routes
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::post('products', [ProductController::class, 'store'])->middleware(['auth:sanctum', 'role:admin']);
Route::put('products/{id}', [ProductController::class, 'update'])->middleware(['auth:sanctum', 'role:admin']);
Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware(['auth:sanctum', 'role:admin']);
