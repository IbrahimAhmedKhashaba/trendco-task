<?php

namespace App\Providers;

use App\Classes\Factories\RegistrationFactory;
use App\Interfaces\Factories\RegistrationFactoryInterface;
use App\Interfaces\Repositories\Auth\EmailAuthRepositoryInterface;
use App\Interfaces\Repositories\Auth\SocialiteAuthRepositoryInterface;
use App\Interfaces\Repositories\Cart\CartRepositoryInterface;
use App\Interfaces\Repositories\Category\CategoryRepositoryInterface;
use App\Interfaces\Repositories\Product\ProductRepositoryInterface;
use App\Interfaces\Services\Cart\CartServiceInterface;
use App\Interfaces\Services\Category\CategoryServiceInterface;
use App\Interfaces\Services\Product\ProductServiceInterface;
use App\Repositories\Auth\EmailAuthRepository;
use App\Repositories\Auth\SocialiteAuthRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Cart\CartService;
use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
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
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
