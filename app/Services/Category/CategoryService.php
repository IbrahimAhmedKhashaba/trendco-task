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
        ], 'Categories data');
    }
    public function getCategoryById($id): JsonResponse {
        try {
            $Category = $this->categoryRepository->getCategoryById($id);
            return response()->apiSuccessResponse([
                'category' => new CategoryResource($Category),
            ], 'Category data');
        } catch (\Exception $e) {
            return response()->apiErrorResponse('Category not found', 404);
        }
    }
    public function storeCategory(array $data): JsonResponse {
        try {
            $category = $this->categoryRepository->storeCategory($data);
            return response()->apiSuccessResponse([
                'category' => new CategoryResource($category),
            ], 'Category Created Successfully' , 201);
        } catch (\Exception $e) {
            return response()->apiErrorResponse('Category not created, Try again!', 500);
        }
    }
    public function updateCategoryById(array $data, $id): JsonResponse {
        try {
            $category = $this->categoryRepository->getCategoryById($id);
            if(!$category){
                return response()->apiErrorResponse('Category Not Found' , 404);
            }
            $category = $this->categoryRepository->updateCategory($category, $data);
            return response()->apiSuccessResponse([
                'category' => new CategoryResource($category),
            ], 'Category Updated Successfully' , 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse('Category not Updated, Try again!', 500);
        }
    }
    public function destroyCategoryById($id): JsonResponse{
        try {
            $category = $this->categoryRepository->getCategoryById($id);
            if(!$category){
                return response()->apiErrorResponse('Category Not Found' , 404);
            }
            $this->categoryRepository->destroyCategory($category);
            return response()->apiSuccessResponse([], 'Category Deleted Successfully' , 200);
        } catch (\Exception $e) {
            return response()->apiErrorResponse('Category not Deleted, Try again!', 500);
        }
    }
}