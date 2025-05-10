<?php  


namespace App\Interfaces\Services\Category;

use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

interface CategoryServiceInterface{
    public function getAllCategories() : JsonResponse;
    public function getCategoryById($id) : JsonResponse;
    public function storeCategory(array $data) : JsonResponse;
    public function updateCategoryById(array $data, $id) : JsonResponse;
    public function destroyCategoryById($id) : JsonResponse;
}