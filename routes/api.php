<?php

use App\Http\Controllers\Api\Admin\Admin\AdminController;
use App\Http\Controllers\Api\Auth\Email\VerificationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SocialiteController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Payment\Paypal\PaypalController;
use App\Http\Controllers\Api\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('set_locale')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('register', [RegisterController::class, 'register']);
        Route::get('redirect/{provider}', [SocialiteController::class, 'getSocialiteLink']);
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('callback', [RegisterController::class, 'getSocialiteUser']);

        Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
            ->middleware(['signed'])
            ->name('verification.verify');

        Route::post('email/resend', [VerificationController::class, 'resend'])
            ->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function () {
        
        // Admin Dashboard Routes
        Route::group([
            'prefix' => '/admin',
            'middleware' => 'is_admin',
        ], function () {
            Route::apiResource('admins', AdminController::class);
        });
    });



    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/cart', [CartController::class, 'add']);
        Route::get('/cart', [CartController::class, 'index']);
        Route::put('{rowId}/cart', [CartController::class, 'update']);
        Route::delete('{rowId}/cart', [CartController::class, 'remove']);
        Route::delete('/cart/clear', [CartController::class, 'clear']);

        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('orders', OrderController::class)->except(['destroy']);

        Route::get('/paypal/create-payment', [PaymentController::class, 'createPayment']);
    });

    Route::post('/payment/handle', [PaymentController::class, 'handle']);


    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware(['auth:sanctum', 'verified']);
});
