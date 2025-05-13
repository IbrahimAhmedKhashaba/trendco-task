<?php 


namespace App\Services\Payment;

use App\Interfaces\Services\Payment\PaymentStrategyInterface;
use App\Models\User;

class StripeService implements PaymentStrategyInterface{
    public function createPayment(){
        
    }

    public function getUser():User{
        return auth()->user();
    }
}