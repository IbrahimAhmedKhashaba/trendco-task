<?php


namespace App\Services\Payment;

use App\Interfaces\Services\Payment\PaymentStrategyInterface;
use App\Interfaces\Services\Payment\PaypalInterface;
use App\Models\User;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Crypt;

class PaypalService implements PaymentStrategyInterface, PaypalInterface
{
    public function createPayment()
    {
        $user = $this->getUser();
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
                "return_url" => route('paypal.success', Crypt::encryptString($user->order->id)),
                "cancel_url" => route('paypal.cancel'),
            ]
        ]);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            $user->order->payment_id = $response['id'];
            $user->order->save();
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return response()->apiSuccessResponse([
                        'url' => $link['href'],
                        'order_id' => $response['id']
                    ], 'Payment Url is ready');
                }
            }
        }
    }

    public function getUser(): User
    {
        return auth()->user();
    }

    public function success($request, $id)
    {
        return Crypt::decryptString($id);
    }

    public function cancel()
    {
        return "cancel";
    }
}
