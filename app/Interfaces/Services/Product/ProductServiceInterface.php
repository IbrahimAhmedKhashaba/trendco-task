<?php  


namespace App\Interfaces\Services\Product;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

interface ProductServiceInterface{
    public function getAllProducts() : JsonResponse;
    public function getProductById($id) : JsonResponse;
    public function storeProduct(array $data) : JsonResponse;
    public function updateProductById(array $data, $id) : JsonResponse;
    public function destroyProductById($id) : JsonResponse;
}