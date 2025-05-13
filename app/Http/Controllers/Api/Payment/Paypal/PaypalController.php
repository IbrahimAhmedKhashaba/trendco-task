<?php

namespace App\Http\Controllers\Api\Payment\Paypal;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\Payment\PaypalInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    //

    private $paypalService;
    public function __construct(PaypalInterface $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function success(Request $request, $id)
    {
        return $this->paypalService->success($request, $id);
    }
    public function cancel(Request $request)
    {
        return $this->paypalService->cancel();
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $data = json_decode($payload, true);
        $orderId = $data['resource']['purchase_units'][0]['reference_id'];
        $order = Order::find($orderId);
        $query = $order->update(['payment_status' => 'paid']);
        Log::info('query' , [$query]);
        return response()->json(['status' => 'success'], 200);
    }
}
