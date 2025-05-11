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
                return response()->apiErrorResponse('المنتج غير موجود', 404);
            }
            $item = Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->qty ?? 1,
                'price' => $product->price,
                'options' => ['images' => $product->images]
            ]);

            $item = $this->cartRepository->storeCartItems($item);

            return response()->apiSuccessResponse(['item' => new CartResource($item)], 'تم اضافة المنتج بنجاح', 201);
        } catch (\Exception $e) {
            return response()->apiErrorResponse('المنتج موجود بالفعل', 401);
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
        ] , 'Cart Items');
    }

    public function update($request, $rowId)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $qty = $request->qty;

        $item = CartItem::where('row_id', $rowId)->where('user_id', auth()->id())->first();


        if (!$item) {
            return response()->apiErrorResponse('المنتج غير موجود في السلة', 404);
        }

        $item = $this->cartRepository->updateCartItem($item, $qty);


        return response()->apiSuccessResponse([
            'item' => new CartResource($item),
        ] , 'Cart Item Updated');
    }

    public function remove($rowId)
    {
        $item = CartItem::where('row_id', $rowId)->where('user_id', auth()->id())->first();
        if (!$item) {
            return response()->apiErrorResponse('المنتج غير موجود في السلة', 404);
        }

        $this->cartRepository->deleteCartItem($item);

        return response()->apiSuccessResponse([] , 'Cart Item Deleted');
    }

    public function clear()
    {
        $user = $this->getUser();
        Cart::destroy();
        $this->cartRepository->clearCart($user);
        return response()->apiSuccessResponse([] , 'Cart Cleared');
    }

    public function getUser()
    {
        return Auth::user();
    }
}
