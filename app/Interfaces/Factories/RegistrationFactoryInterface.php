<?php 

namespace App\Interfaces\Factories;

use App\Interfaces\Services\Auth\AuthStrategyInterface;

interface RegistrationFactoryInterface{
    public function create(string $provider): AuthStrategyInterface;
}