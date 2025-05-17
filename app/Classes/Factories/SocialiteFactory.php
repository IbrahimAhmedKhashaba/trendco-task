<?php

namespace App\Classes\Factories;

use App\Interfaces\Factories\SocialiteFactoryInterface;
use App\Interfaces\Services\Auth\SocialiteAuthStrategyInterface;

class SocialiteFactory implements SocialiteFactoryInterface
{
    public function __construct(
        protected SocialiteAuthStrategyInterface $socialiteAuthService,
    ) {}
    public function create($provider)
    {
        return match ($provider) {
            'google' => $this->socialiteAuthService,
            default => abort(404, 'Provider not found')
        };
    }
}
