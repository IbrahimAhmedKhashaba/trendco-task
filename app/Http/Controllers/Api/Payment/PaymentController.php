<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Interfaces\Factories\PaymentFactoryInterface;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    private $factory, $method;

    public function __construct(PaymentFactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->method = request()->method ?? 'stripe';
    }

    public function createPayment(){
        return $this->factory->createPayment($this->method)->createPayment();
    }

    public function handle(Request $request){
        return $this->factory->createPayment($this->method)->handle($request);
    }
}
