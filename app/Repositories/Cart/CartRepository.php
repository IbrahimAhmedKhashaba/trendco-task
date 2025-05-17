<?php

namespace App\Repositories\Cart;

use App\Interfaces\Repositories\Cart\CartRepositoryInterface;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function storeCartItems($item):?CartItem
    {
        $user = $this->getUser();
        return CartItem::create([
            'user_id' => $user->id,
            'row_id' => $item->rowId,
            'product_id' => $item->id,
            'name' => $item->name,
            'qty' => $item->qty,
            'price' => $item->price,
            'options' => json_encode($item->options),
        ]);
    }

    public function getCartItems():Collection
    {
        $items = CartItem::where('user_id', Auth::user()->id)->get();
        Cart::destroy();
        foreach ($items as $item) {
            Cart::add([
                'rowId' => $item->row_id,
                'id' => $item->product_id,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'options' => json_decode($item->options, true),
            ]);
        }
        return $items;
    }

    public function updateCartItem($item, $qty):?CartItem
    {
        $item->qty = $qty;
        $item->save();
        return $item;
    }

    public function deleteCartItem($item):bool
    {
        $product = $item->product;
        $product->quantity += $item->qty;
        $product->save();
        return $item->delete();
    }
    public function clearCart($user):bool
    {
        $items = CartItem::where('user_id', $user->id)->get();
        foreach ($items as $item) {
            $product = $item->product;
            $product->quantity += $item->qty;
            $product->save();
        }
        return CartItem::where('user_id', $user->id)->delete();
    }

    public function getUser()
    {
        return Auth::user();
    }
}
