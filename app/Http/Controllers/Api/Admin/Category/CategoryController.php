<?php

namespace App\Http\Controllers\Api\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Interfaces\Services\Category\CategoryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(): JsonResponse
    {
        //
        return $this->categoryService->getAllCategories();
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        //
        return $this->categoryService->storeCategory($request->all());
    }

    public function show(string $id): JsonResponse
    {
        //
        return $this->categoryService->getCategoryById($id);
    }

    public function update(CategoryRequest $request, string $id): JsonResponse
    {
        //
        return $this->categoryService->updateCategoryById($request->all() , $id);
    }

    public function destroy(string $id): JsonResponse
    {
        //
        return $this->categoryService->destroyCategoryById($id);
    }
}