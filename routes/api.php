<?php

use App\Http\Controllers\Api\Admin\Admin\AdminController;
use App\Http\Controllers\Api\Admin\User\UserController;
use App\Http\Controllers\Api\Auth\Email\VerificationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SocialiteController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Admin\Category\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\Order\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('set_locale')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::match(['get', 'post'], 'register', [RegisterController::class, 'register']);
        Route::get('redirect/{provider}', [SocialiteController::class, 'getSocialiteLink']);
        Route::controller(LoginController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('logout', 'logout')->middleware('auth:sanctum');
        });

        Route::controller(VerificationController::class)->group(function () {
            Route::get('email/verify/{id}/{hash}', 'verify')
                // ->middleware(['signed'])
                ->name('verify');
            Route::post('email/resend', 'resend')
                ->middleware('auth:sanctum');
        });
    });

    Route::middleware(['auth:sanctum', 'verified'])->group(function () {

        // Admin Dashboard Routes
        Route::group([
            'prefix' => '/admin',
            'middleware' => 'is_admin',
            'as' => 'admin.'
        ], function () {
            Route::apiResource('admins', AdminController::class)->except(['update', 'destroy']);
            Route::apiResource('users', UserController::class);
            Route::apiResource('categories', AdminCategoryController::class);
            Route::apiResource('products', AdminProductController::class);
            Route::apiResource('orders', AdminOrderController::class);
        });
    });



    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
        Route::apiResource('orders', OrderController::class)->except(['destroy']);
        Route::apiResource('products', ProductController::class)->only(['index', 'show']);
        Route::controller(CartController::class)->group(function () {
            Route::post('/cart', 'add');
            Route::get('/cart', 'index');
            Route::put('{rowId}/cart', 'update');
            Route::delete('{rowId}/cart', 'remove');
            Route::delete('/cart/clear', 'clear');
        });
        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile', 'show');
            Route::put('profile', 'update');
        });

        Route::get('/paypal/create-payment', [PaymentController::class, 'createPayment']);
    });

    Route::post('/payment/handle', [PaymentController::class, 'handle']);
});


