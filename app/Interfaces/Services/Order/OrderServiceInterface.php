<?php  


namespace App\Interfaces\Services\Order;

use Illuminate\Http\JsonResponse;

interface OrderServiceInterface{
    public function getAllOrders() : JsonResponse;
    public function getOrderById($id) : JsonResponse;
    public function storeOrder(array $data) : JsonResponse;
    public function updateOrderStatusById(array $data, $id) : JsonResponse;
}