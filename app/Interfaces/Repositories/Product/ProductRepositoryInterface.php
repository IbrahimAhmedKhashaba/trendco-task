<?php  


namespace App\Interfaces\Repositories\Product;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;


interface ProductRepositoryInterface{
    public function getAllProducts() : LengthAwarePaginator;
    public function getProductById($id) : ?Product;
    public function storeProduct(array $data) : Product;
    public function updateProduct($product , array $data) : Product;
    public function destroyProduct($product) : bool;
}