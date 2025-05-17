<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'description'  => $this->description,
            'price'  => $this->price,
            'discounted_price'  => $this->discounted_price,
            'quantity'  => $this->quantity,
            'status'  => $this->status,
            'has_discount'  => $this->has_discount,
            'images' => $this->whenLoaded('images', function () {
                return [
                    'path' => asset('uploads/products'),
                    'images' => ImageResource::collection($this->images),
                ];
            }),

            'categories' => $this->whenLoaded('categories', function () {
                return CategoryResource::collection($this->categories);
            }),
        ];
    }
}
