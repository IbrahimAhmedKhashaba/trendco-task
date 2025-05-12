<?php 

namespace App\Classes\Factories;

use App\Interfaces\Factories\PaymentFactoryInterface;
use App\Interfaces\Services\Payment\PaymentStrategyInterface;
use App\Services\Payment\PaypalService;
use App\Services\Payment\StripeService;

class PaymentFactory implements PaymentFactoryInterface{
    public function __construct(
        protected PaypalService $paypalService,
        protected StripeService $stripeService,
    ) {}
    public function createPayment(string $method): PaymentStrategyInterface{
        return match ($method) {
            'paypal' => $this->paypalService,
            default => $this->stripeService,
        };
    }
}