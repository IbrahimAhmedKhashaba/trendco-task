<?php 

namespace App\Interfaces\Services\Payment;

use App\Models\User;

interface PaymentStrategyInterface
{
    public function createPayment();
    public function getUser(): User;
}