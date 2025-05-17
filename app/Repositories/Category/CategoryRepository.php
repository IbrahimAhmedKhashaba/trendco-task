<?php

namespace App\Repositories\Category;

use App\Interfaces\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;
use App\Traits\ImageManagementTrait;

class CategoryRepository implements CategoryRepositoryInterface
{
    use ImageManagementTrait;
    public function getAllCategories(): Collection {
        return Category::active()->with('image')->get();
    }
    public function getCategoryById($id): ?Category {
        return Category::active()->with('image')->where('id', $id)->first();
    }
    public function storeCategory(array $data): Category {
        $category = Category::create($data);
        $fileName = $this->uploadImageToDisk($data['image'], 'categories');

        $category->image()->create([
            'url' => $fileName,
            'alt_text' => $category->getTranslation('name', 'en'),
        ]);
        return $category;
    }
    public function updateCategory($category , array $data): Category {
        if(isset($data['image'])){
            $this->deleteImageFromDisk('uploads/categories/'.$category->image->url);
            $fileName = $this->uploadImageToDisk($data['image'], 'categories');
            $category->image()->update([
                'url' => $fileName,
                'alt_text' => $category->getTranslation('name', 'en'),
            ]);
        }
        $category->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => $data['status'],
        ]);
        return $category;
    }
    public function destroyCategory($category): bool{
        $this->deleteImageFromDisk('uploads/categories/'.$category->image->url);
        return $category->delete();
    }
}