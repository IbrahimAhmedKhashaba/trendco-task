<?php 

namespace App\Interfaces\Services\Payment;

interface PaypalInterface
{
    public function success($request , $id);
    public function cancel();
}