<?php


namespace App\Services\Payment;

use App\Interfaces\Services\Payment\PaymentStrategyInterface;
use App\Models\Order;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeService implements PaymentStrategyInterface
{
    public function createPayment()
    {

        $order = auth()->user()->order;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => env('STRIPE_CURRENCY', 'usd'),
                    'product_data' => [
                        'name' => 'Order #' . $order->id,
                    ],
                    'unit_amount' => $order->total * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id,
            ],
            'success_url' => env('STRIPE_SUCCESS_URL'),
            'cancel_url' => env('STRIPE_ERROR_URL'),
        ]);

        return response()->apiSuccessResponse([
            'url' => $session->url,
        ], 'Payment Url is ready');
    }

    public function handle($request){
        Log::info('payload' , [$request->all()]);
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $secret
            );
        } catch(\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id;
            $order = Order::find($orderId);
            $order->update(['payment_status' => 'paid']);
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function getUser(): User
    {
        return auth()->user();
    }
}
