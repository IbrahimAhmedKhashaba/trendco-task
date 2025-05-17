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
        ], __('msgs.order_all_data'));
    }
    public function getOrderById($id): JsonResponse {
        $order = $this->orderRepository->getOrderById($id);
        if (!$order) {
            return response()->apiErrorResponse(__('msgs.order_not_found'), 404);
        }
        return response()->apiSuccessResponse([
            'order' => new OrderResource($order),
        ], __('msgs.order_data'));
    }
    public function storeOrder($request): JsonResponse
    {

        $cartItems = $this->orderRepository->getCartItems();

        if ($cartItems->isEmpty()) {
            return response()->apiErrorResponse(__('msgs.cart_empty'), 400);
        }

        DB::beginTransaction();

        try {
            $order = $this->orderRepository->storeOrder($request);
            $this->orderRepository->clearCart();
            DB::commit();
            return response()->apiSuccessResponse([
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ],__('msgs.order_created') ,201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
    public function update(array $data, $id): JsonResponse
    {
        try {
            $order = $this->orderRepository->getOrderById($id);
            if (!$order) {
                return response()->apiErrorResponse(__('msgs.order_not_found'), 404);
            }
            $order = $this->orderRepository->update($order, $data);
            return response()->apiSuccessResponse([
                'Order' => new OrderResource($order),
            ], __('msgs.order_updated'), 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $order = $this->orderRepository->getOrderById($id);
            if (!$order) {
                return response()->apiErrorResponse(__('msgs.order_not_found'), 404);
            }
            $order = $this->orderRepository->destroyOrder($order);
            return response()->apiSuccessResponse([], __('msgs.order_deleted'), 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal'), 500);
        }
    }
}
