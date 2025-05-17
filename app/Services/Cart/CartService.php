<?php

namespace App\Services\Cart;

use App\Interfaces\Repositories\Cart\CartRepositoryInterface;
use App\Interfaces\Services\Cart\CartServiceInterface;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartStorageService;
use Illuminate\Http\Request;
use App\Http\Resources\Cart\CartResource;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartService implements CartServiceInterface
{
    private $cartRepository;
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }
    public function add($request)
    {
        try {
            $product = Product::find($request->id);
            if (!$product) {
                return response()->apiErrorResponse(__('msgs.product_not_found'), 404);
            }
            if ($product->quantity < $request->qty) {
                return response()->apiErrorResponse(__('msgs.product_quantity_not_enough'), 400);
            }
            $item = Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->qty ?? 1,
                'price' => $product->has_discount ? $product->discounted_price : $product->price,
                'options' => ['images' => $product->images]
            ]);

            $product->quantity -= $request->qty;
            $product->save();
            $item = $this->cartRepository->storeCartItems($item);

            return response()->apiSuccessResponse(['item' => new CartResource($item)], __('msgs.cart_created'), 201);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.cart_found'), 401);
        }
    }

    public function index()
    {
        $items = $this->cartRepository->getCartItems();

        $total = Cart::content()->sum(function ($item) {
            return $item->price * $item->qty;
        });

        return response()->apiSuccessResponse([
            'items' => CartResource::collection($items),
            'total' => number_format($total, 2)
        ], __('msgs.cart_all_data'));
    }

    public function update($request, $rowId)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $qty = $request->qty;

        

        $item = CartItem::where('row_id', $rowId)->where('user_id', auth()->id())->first();


        if (!$item) {
            return response()->apiErrorResponse(__('msgs.cart_not_found'), 404);
        }

        $product = $item->product;
        $product->quantity = $product->quantity - $request->qty + $item->qty;
        if($product->quantity < 0){
            return response()->apiErrorResponse(__('msgs.product_quantity_not_enough'), 400);
        }
        $product->save();

        $item = $this->cartRepository->updateCartItem($item, $qty);


        return response()->apiSuccessResponse([
            'item' => new CartResource($item),
        ], __('msgs.cart_updated'));
    }

    public function remove($rowId)
    {
        $item = CartItem::where('row_id', $rowId)->where('user_id', auth()->id())->first();
        if (!$item) {
            return response()->apiErrorResponse(__('msgs.product_not_found'), 404);
        }

        $this->cartRepository->deleteCartItem($item);

        return response()->apiSuccessResponse([], __('msgs.cart_deleted'));
    }

    public function clear()
    {
        $user = $this->getUser();
        Cart::destroy();
        $this->cartRepository->clearCart($user);
        return response()->apiSuccessResponse([], __('msgs.cart_cleared'));
    }

    public function getUser()
    {
        return Auth::user();
    }
}
