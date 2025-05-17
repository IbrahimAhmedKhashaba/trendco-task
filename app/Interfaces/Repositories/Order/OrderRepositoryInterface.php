<?php


namespace App\Interfaces\Repositories\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;


interface OrderRepositoryInterface
{
    public function getAllOrders(): Collection;
    public function getOrderById($id): ?Order;
    public function storeOrder($request): Order;
    public function update($order, $status): Order;
    public function getCartItems();
    public function getUser();
    public function calculateTotal($cartItems);
    public function storeOrderProducts($order, $cartItems);
    public function destroyOrder($order);
}
