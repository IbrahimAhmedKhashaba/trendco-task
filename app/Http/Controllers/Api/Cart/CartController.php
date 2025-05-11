<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\Cart\CartServiceInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    //

    private $cartService;
    public function __construct(CartServiceInterface $cartService){
        $this->cartService = $cartService;
    }
    public function add(Request $request)
    {
        return $this->cartService->add($request);
    }
    public function index(Request $request)
    {

        return $this->cartService->index();
    }

    public function update(Request $request , $rowId)
    {
        return $this->cartService->update($request , $rowId);
    }
    public function remove($rowId)
    {
        return $this->cartService->remove($rowId);
    }
    public function clear()
    {
        return $this->cartService->clear();
    }
}
