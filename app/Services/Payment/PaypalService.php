<?php


namespace App\Services\Payment;

use App\Interfaces\Services\Payment\PaymentStrategyInterface;
use App\Models\Order;
use App\Models\User;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Crypt;

class PaypalService implements PaymentStrategyInterface
{
    public function createPayment()
    {
        $user = $this->getUser();
        if (!$user->order) {
            return response()->apiErrorResponse(__('msgs.order_not_found'));
        }
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => $user->order->id,
                    "amount" => [
                        "currency_code" => env('PAYPAL_CURRENCY', 'USD'),
                        "value" => $user->order->total
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => env('PAYPAL_SUCCESS_URL'),
                "cancel_url" => env('PAYPAL_ERROR_URL'),
            ]
        ]);
        // dd($response);
        if (isset($response['id']) && $response['status'] === 'CREATED') {
            // $user->order->payment_id = $response['id'];
            $user->order->save();
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return response()->apiSuccessResponse([
                        'url' => $link['href'],
                        'order_id' => $response['id']
                    ], __('msgs.payment_link'));
                }
            }
        }
    }

    public function getUser(): User
    {
        return auth()->user();
    }

    public function handle($request)
    {
        $payload = $request->getContent();
        $data = json_decode($payload, true);
        $orderId = $data['resource']['purchase_units'][0]['reference_id'];
        $order = Order::find($orderId);
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => 'paypal',
        ]);
        return response()->apiSuccessResponse(['status' => 'success'], 200);
    }
}
