<?php

namespace App\Services\Order;

use App\Http\Resources\Order\OrderResource;
use App\Interfaces\Repositories\Order\OrderRepositoryInterface;
use App\Interfaces\Services\Order\OrderServiceInterface;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class OrderService implements OrderServiceInterface
{
    private $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function getAllOrders(): JsonResponse {
        $orders = $this->orderRepository->getAllOrders();
        return response()->apiSuccessResponse([
            'orders' => OrderResource::collection($orders),
        ], 'Orders Data');
    }
    public function getOrderById($id): JsonResponse {
        $order = $this->orderRepository->getOrderById($id);
        if (!$order) {
            return response()->apiErrorResponse('Order not found', 404);
        }
        return response()->apiSuccessResponse([
            'order' => new OrderResource($order),
        ], 'Order Data');
    }
    public function storeOrder($request): JsonResponse
    {

        $cartItems = $this->orderRepository->getCartItems();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            $order = $this->orderRepository->storeOrder($request);
            $this->orderRepository->clearCart();
            DB::commit();
            return response()->json([
                'message' => 'Order placed successfully',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to place order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateOrderStatusById(array $data, $id): JsonResponse
    {
        try {
            $order = $this->orderRepository->getOrderById($id);
            if (!$order) {
                return response()->apiErrorResponse('Order Not Found', 404);
            }
            $order = $this->orderRepository->updateOrderStatus($order, $data['order_status']);
            return response()->apiSuccessResponse([
                'Order' => new OrderResource($order),
            ], 'Order Status Updated Successfully', 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse('Order Status not Updated, Try again!', 500);
        }
    }
}
