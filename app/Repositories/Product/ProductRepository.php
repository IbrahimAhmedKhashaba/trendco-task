<?php

namespace App\Repositories\Product;

use App\Http\Resources\Product\ProductResource;
use App\Interfaces\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;
use App\Traits\ImageManagementTrait;

class ProductRepository implements ProductRepositoryInterface
{
    use ImageManagementTrait;
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::active()->with(['images', 'categories'])->paginate(10);
    }
    public function getProductById($id): ?Product
    {
        return Product::active()->with(['images', 'categories'])->where('id', $id)->first();
    }
    public function storeProduct(array $data): Product
    {
        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'status' => $data['status'],
            'discounted_price' => isset($data['discounted_price']) ? $data['discounted_price'] : null,
            'has_discount' => isset($data['discounted_price']) ? 1 : 0,
        ]);
        $images = [];
        foreach ($data['images'] as $image) {
            $fileName = $this->uploadImageToDisk($image, 'products');
            $images[] = [
                'url' => $fileName,
                'alt_text' => $product->getTranslation('name', 'en'),
            ];
        }
        $product->images()->createMany($images);
        $product->categories()->sync($data['categories']);
        return $product;
    }
    public function updateProduct($product, array $data): Product
    {
        if (!empty($data['images'])) {
            foreach ($product->images as $image) {
                $this->deleteImageFromDisk('uploads/products/' . $image->url);
            }
            $product->images()->delete();

            $images = [];
            foreach ($data['images'] as $image) {
                $fileName = $this->uploadImageToDisk($image, 'products');
                $images[] = [
                    'url' => $fileName,
                    'alt_text' => $product->getTranslation('name', 'en'),
                ];
            }
            $product->images()->createMany($images);
        }

        if (!empty($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'status' => $data['status'],
            'discounted_price' => $data['discounted_price'] ?? null,
            'has_discount' => isset($data['discounted_price']) ? 1 : 0,
        ]);

        return $product;
    }
    public function destroyProduct($product): bool
    {
        foreach ($product->images as $image) {
                $this->deleteImageFromDisk('uploads/products/' . $image->url);
            }
        return $product->delete();
    }
}
