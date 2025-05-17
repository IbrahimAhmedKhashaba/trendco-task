<?php

namespace App\Providers;

use App\Classes\Factories\PaymentFactory;
use App\Classes\Factories\RegistrationFactory;
use App\Classes\Factories\SocialiteFactory;
use App\Interfaces\Factories\PaymentFactoryInterface;
use App\Interfaces\Factories\RegistrationFactoryInterface;
use App\Interfaces\Factories\SocialiteFactoryInterface;
use App\Interfaces\Repositories\Admin\AdminRepositoryInterface;
use App\Interfaces\Repositories\Auth\EmailAuthRepositoryInterface;
use App\Interfaces\Repositories\Auth\SocialiteAuthRepositoryInterface;
use App\Interfaces\Repositories\Cart\CartRepositoryInterface;
use App\Interfaces\Repositories\Category\CategoryRepositoryInterface;
use App\Interfaces\Repositories\Order\OrderRepositoryInterface;
use App\Interfaces\Repositories\Payment\PayPalRepositoryInterface;
use App\Interfaces\Repositories\Payment\StripeRepositoryInterface;
use App\Interfaces\Repositories\Product\ProductRepositoryInterface;
use App\Interfaces\Repositories\Profile\ProfileRepositoryInterface;
use App\Interfaces\Repositories\User\UserRepositoryInterface;
use App\Interfaces\Services\Admin\AdminServiceInterface;
use App\Interfaces\Services\Auth\SocialiteAuthStrategyInterface;
use App\Interfaces\Services\Cart\CartServiceInterface;
use App\Interfaces\Services\Category\CategoryServiceInterface;
use App\Interfaces\Services\Order\OrderServiceInterface;
use App\Interfaces\Services\Payment\PaypalInterface;
use App\Interfaces\Services\Product\ProductServiceInterface;
use App\Interfaces\Services\Profile\ProfileServiceInterface;
use App\Interfaces\Services\User\UserServiceInterface;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Auth\EmailAuthRepository;
use App\Repositories\Auth\SocialiteAuthRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Payment\PayPalRepository;
use App\Repositories\Payment\StripeRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\User\UserRepository;
use App\Services\Admin\AdminService;
use App\Services\Auth\SocialiteAuthService;
use App\Services\Cart\CartService;
use App\Services\Category\CategoryService;
use App\Services\Order\OrderService;
use App\Services\Payment\PaypalService;
use App\Services\Product\ProductService;
use App\Services\Profile\ProfileService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(RegistrationFactoryInterface::class, RegistrationFactory::class);
        $this->app->bind(EmailAuthRepositoryInterface::class, EmailAuthRepository::class);
        $this->app->bind(SocialiteAuthRepositoryInterface::class, SocialiteAuthRepository::class);
        $this->app->bind(SocialiteAuthStrategyInterface::class, SocialiteAuthService::class);
        $this->app->bind(SocialiteFactoryInterface::class, SocialiteFactory::class);
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(PaymentFactoryInterface::class, PaymentFactory::class);
        $this->app->bind(PayPalRepositoryInterface::class, PayPalRepository::class);
        $this->app->bind(StripeRepositoryInterface::class, StripeRepository::class);
        $this->app->bind(PaypalInterface::class, PaypalService::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
