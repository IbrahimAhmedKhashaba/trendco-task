<?php

namespace App\Services\Category;

use App\Http\Resources\Category\CategoryResource;
use App\Interfaces\Repositories\Category\CategoryRepositoryInterface;
use App\Interfaces\Services\Category\CategoryServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class CategoryService implements CategoryServiceInterface
{
    private $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
    public function getAllCategories(): JsonResponse {
        $categories = $this->categoryRepository->getAllCategories();
        return response()->apiSuccessResponse([
            'categories' => CategoryResource::collection($categories),
        ], __('msgs.category_all_data'));
    }
    public function getCategoryById($id): JsonResponse {
        try {
            $Category = $this->categoryRepository->getCategoryById($id);
            if(!$Category){
                return response()->apiErrorResponse(__('msgs.category_not_found'), 404);
            }
            return response()->apiSuccessResponse([
                'category' => new CategoryResource($Category),
            ], __('msgs.category_data'));
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_erroe'), 404);
        }
    }
    public function storeCategory(array $data): JsonResponse {
        try {
            $category = $this->categoryRepository->storeCategory($data);
            return response()->apiSuccessResponse([
                'category' => new CategoryResource($category),
            ], __('msgs.category_created') , 201);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
    public function updateCategoryById(array $data, $id): JsonResponse {
        try {
            $category = $this->categoryRepository->getCategoryById($id);
            if(!$category){
                return response()->apiErrorResponse(__('msgs.category_not_found') , 404);
            }
            $category = $this->categoryRepository->updateCategory($category, $data);
            return response()->apiSuccessResponse([
                'category' => new CategoryResource($category),
            ], __('msgs.category_created') , 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
    public function destroyCategoryById($id): JsonResponse{
        try {
            $category = $this->categoryRepository->getCategoryById($id);
            if(!$category){
                return response()->apiErrorResponse(__('msgs.category_not_found') , 404);
            }
            $this->categoryRepository->destroyCategory($category);
            return response()->apiSuccessResponse([], __('msgs.category_deleted') , 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse(__('msgs.internal_error'), 500);
        }
    }
}