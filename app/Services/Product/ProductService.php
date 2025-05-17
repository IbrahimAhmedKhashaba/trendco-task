<?php

namespace App\Services\Product;

use App\Http\Resources\Product\ProductResource;
use App\Interfaces\Repositories\Product\ProductRepositoryInterface;
use App\Interfaces\Services\Product\ProductServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class ProductService implements ProductServiceInterface
{
    private $ProductRepository;
    public function __construct(ProductRepositoryInterface $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }
    public function getAllProducts(): JsonResponse
    {
        $products = $this->ProductRepository->getAllProducts();
        return response()->apiSuccessResponse([
            'products' => ProductResource::collection($products),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
            'links' => [
                'first' => $products->url(1),
                'last' => $products->url($products->lastPage()),
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
            ],
        ], __('msgs.product_all_data'));
    }
    public function getProductById($id): JsonResponse
    {
        try {
            $Product = $this->ProductRepository->getProductById($id);
            if(!$Product){
                return response()->apiErrorResponse(__('msgs.product_not_found'), 404);
            }
            return response()->apiSuccessResponse([
                'Product' => new ProductResource($Product),
            ], __('msgs.product_data'));
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
    public function storeProduct(array $data): JsonResponse
    {
        try {
            $Product = $this->ProductRepository->storeProduct($data);
            return response()->apiSuccessResponse([
                'Product' => new ProductResource($Product),
            ], __('msgs.product_created'), 201);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
    public function updateProductById(array $data, $id): JsonResponse
    {
        try {
            $Product = $this->ProductRepository->getProductById($id);
            if (!$Product) {
                return response()->apiErrorResponse(__('msgs.product_not_found'), 404);
            }
            $Product = $this->ProductRepository->updateProduct($Product, $data);
            return response()->apiSuccessResponse([
                'Product' => new ProductResource($Product),
            ], __('msgs.product_updated'), 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
    public function destroyProductById($id): JsonResponse
    {
        try {
            $Product = $this->ProductRepository->getProductById($id);
            if (!$Product) {
                return response()->apiErrorResponse(__('msgs.product_not_found'), 404);
            }
            $this->ProductRepository->destroyProduct($Product);
            return response()->apiSuccessResponse([], __('msgs.product_deleted'), 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
}
