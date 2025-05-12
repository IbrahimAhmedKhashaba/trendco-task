<?php 

namespace App\Interfaces\Factories;

use App\Interfaces\Services\Payment\PaymentStrategyInterface;

interface PaymentFactoryInterface{
    public function createPayment(string $method): PaymentStrategyInterface;
}