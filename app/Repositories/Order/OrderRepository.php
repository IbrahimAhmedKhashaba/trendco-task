<?php

namespace App\Repositories\Order;

use App\Interfaces\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Support\Str;


class OrderRepository implements OrderRepositoryInterface
{
    public function getAllOrders(): Collection
    {
        $user = $this->getUser();
        return Order::get();
    }
    public function getOrderById($id): ?Order
    {
        $order = Order::with('user')->whereId($id)->first();
        return $order;
    }
    public function storeOrder($request): Order
    {
        $user = $this->getUser();
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => strtoupper('ORD' . Str::random(10)),
            'city_name' => $request->city_name,
            'address_name' => $request->address_name,
            'building_number' => $request->building_number,
            'payment_status' => 'not paid',
            'status' => 'pending',
            'total' => 0,
        ]);

        $cartItems = $this->getCartItems();

        $total = $this->calculateTotal($cartItems);

        $this->updateOrderTotal($order, $total);

        $this->storeOrderProducts($order, $cartItems);

        return $order;
    }
    public function update($Order, $data): Order
    {
        $Order->update($data);
        return $Order;
    }

    public function getCartItems(): collection
    {
        $user = $this->getUser();
        return CartItem::where('user_id', $user->id)->get();
    }

    public function getUser():User
    {
        return auth()->user();
    }

    public function calculateTotal($cartItems):float
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $subtotal = $item->qty * $item->price;
            $total += $subtotal;
        }
        return $total;
    }
    public function updateOrderTotal($order, $total)
    {
        return $order->update(['total' => $total]);
    }

    public function storeOrderProducts($order, $cartItems):void
    {
        foreach ($cartItems as $item) {
            $subtotal = $item->qty * $item->price;
            $order->products()->attach($item->product_id, [
                'quantity' => $item->qty,
                'price' => $item->price,
                'subtotal' => $subtotal,
            ]);
        }
    }

    public function clearCart():void{
        $user = $this->getUser();
        CartItem::where('user_id', $user->id)->delete();
    }

    public function destroyOrder($order):void
    {
        if($order->payment_status == 'not paid'){
            foreach($order->products as $product){
                $product->increment('quantity', $product->pivot->quantity);
            }
        }
        $order->products()->detach();
        $order->delete();
    }
}
