<?php 



namespace App\Interfaces\Services\Auth;

interface AuthStrategyInterface
{
    public function register(array $data);
}