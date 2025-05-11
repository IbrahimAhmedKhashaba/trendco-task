<?php  


namespace App\Interfaces\Repositories\Cart;



interface CartRepositoryInterface{
     public function storeCartItems($item);

    public function getCartItems();

    public function updateCartItem($item , $qty);
    public function deleteCartItem($item);
    public function clearCart($user);
}