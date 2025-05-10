<?php

namespace App\Providers;

use App\Classes\Factories\RegistrationFactory;
use App\Interfaces\Factories\RegistrationFactoryInterface;
use App\Interfaces\Repositories\Auth\EmailAuthRepositoryInterface;
use App\Interfaces\Repositories\Auth\SocialiteAuthRepositoryInterface;
use App\Interfaces\Repositories\Category\CategoryRepositoryInterface;
use App\Interfaces\Services\Category\CategoryServiceInterface;
use App\Repositories\Auth\EmailAuthRepository;
use App\Repositories\Auth\SocialiteAuthRepository;
use App\Repositories\Category\CategoryRepository;
use App\Services\Category\CategoryService;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
