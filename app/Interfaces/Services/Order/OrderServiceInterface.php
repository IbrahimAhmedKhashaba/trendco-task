<?php  


namespace App\Interfaces\Services\Order;

use Illuminate\Http\JsonResponse;

interface OrderServiceInterface{
    public function getAllOrders() : JsonResponse;
    public function getOrderById($id) : JsonResponse;
    public function storeOrder(array $data) : JsonResponse;
    public function update(array $data, $id) : JsonResponse;
    public function destroy($order);
}