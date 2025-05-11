<?php

use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\ValorationController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PayPalController;

// User routes
Route::post('users/update-profile/{id}', [UserController::class, 'updateProfile'])->middleware(['auth:sanctum']);
Route::resource('users', UserController::class)->except(['store'])->middleware(['auth:sanctum', 'role:admin']);
Route::post('register', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);

// Verification routes
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/check-verification', [VerificationController::class, 'checkEmailVerified'])->name('verification.check');
Route::post('/resend-verification', [VerificationController::class, 'resendEmailVerification'])->name('verification.resend');

// Product routes
Route::get('products/featured', [ProductController::class, 'showFeatured'])->name('products.latest');
Route::get('products/detailed/{id}', [ProductController::class, 'showDetailed'])->name('products.detailed');
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::post('products', [ProductController::class, 'store'])->middleware(['auth:sanctum', 'role:admin']);
Route::put('products/{id}', [ProductController::class, 'update'])->middleware(['auth:sanctum', 'role:admin']);
Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware(['auth:sanctum', 'role:admin']);

// Category routes
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
Route::post('categories', [CategoryController::class, 'store'])->middleware(['auth:sanctum', 'role:admin']);
Route::put('categories/{id}', [CategoryController::class, 'update'])->middleware(['auth:sanctum', 'role:admin']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->middleware(['auth:sanctum', 'role:admin']);

// Brand routes
Route::resource('brands', BrandController::class)->only(['index', 'show']);
Route::post('brands', [BrandController::class, 'store'])->middleware(['auth:sanctum', 'role:admin']);
Route::put('brands/{id}', [BrandController::class, 'update'])->middleware(['auth:sanctum', 'role:admin']);
Route::delete('brands/{id}', [BrandController::class, 'destroy'])->middleware(['auth:sanctum', 'role:admin']);

// Valoration routes
Route::resource('valorations', ValorationController::class)->only(['index', 'show']);
Route::post('valorations', [ValorationController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('valorations/{id}', [ValorationController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('valorations/{id}', [ValorationController::class, 'destroy'])->middleware(['auth:sanctum']);

// Favorite routes
Route::get('favorites/user-favorites/{id}', [FavoriteController::class, 'getUserFavorites'])->middleware(['auth:sanctum']);
Route::get('favorites/show/{userId}/{productId}', [FavoriteController::class, 'show'])->middleware(['auth:sanctum']);
Route::delete('favorites/delete/{userId}/{productId}', [FavoriteController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::post('favorites/store', [FavoriteController::class, 'store'])->middleware(['auth:sanctum']);

// Contact routes
Route::post('contact', [ContactController::class, 'sendContactForm']);
Route::get('contact-forms', [ContactController::class, 'index'])->middleware(['auth:sanctum', 'role:admin']);
Route::get('contact-forms/{id}', [ContactController::class, 'show'])->middleware(['auth:sanctum', 'role:admin']);
Route::put('contact-forms/{id}/resolve', [ContactController::class, 'resolve'])->middleware(['auth:sanctum', 'role:admin']);
Route::delete('contact-forms/{id}', [ContactController::class, 'destroy'])->middleware(['auth:sanctum', 'role:admin']);

// Cart, orders and paypal routes
Route::middleware('auth:sanctum')->group(function () {
    // Carrito
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/items', [CartController::class, 'addItem']);
    Route::put('/cart/items/{itemId}', [CartController::class, 'updateItem']);
    Route::delete('/cart/items/{itemId}', [CartController::class, 'removeItem']);
    Route::delete('/cart', [CartController::class, 'clear']);
    
    // Órdenes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
    
    // PayPal
    Route::post('/paypal/create-order/{orderId}', [PayPalController::class, 'createOrder']);
    Route::post('/paypal/capture-payment', [PayPalController::class, 'capturePayment']);
});

// Public paypal routes
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');