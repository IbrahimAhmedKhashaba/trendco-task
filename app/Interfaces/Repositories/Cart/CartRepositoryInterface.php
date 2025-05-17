<?php


namespace App\Interfaces\Repositories\Cart;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;



interface CartRepositoryInterface
{
    public function storeCartItems($item): ?CartItem;

    public function getCartItems(): Collection;

    public function updateCartItem($item, $qty): ?CartItem;
    public function deleteCartItem($item): bool;
    public function clearCart($user): bool;
}
