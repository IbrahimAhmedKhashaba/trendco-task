<?php 

namespace App\Classes\Factories;

use App\Classes\Registration\Registration;
use App\Interfaces\Factories\RegistrationFactoryInterface;
use App\Interfaces\Services\Auth\AuthStrategyInterface;
use App\Services\Auth\EmailAuthService;
use App\Services\Auth\SocialiteAuthService;

class RegistrationFactory implements RegistrationFactoryInterface
{

    public function __construct(
        protected EmailAuthService $emailAuthService,
        protected SocialiteAuthService $socialiteAuthService,
    ) {}
    public function create(string $provider): AuthStrategyInterface
    {
        return match ($provider) {
            'google' => $this->socialiteAuthService,
            default => $this->emailAuthService,
        };
    }
}