<?php  


namespace App\Interfaces\Repositories\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;


interface CategoryRepositoryInterface{
    public function getAllCategories() : Collection;
    public function getCategoryById($id) : ?Category;
    public function storeCategory(array $data) : Category;
    public function updateCategory($category , array $data) : Category;
    public function destroyCategory($category) : bool;
}