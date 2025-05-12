<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\ProductResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'order_number' => $this->order_number,
            'order_status' => $this->order_status,
            'city_name' => $this->city_name,
            'address_name' => $this->address_name,
            'building_number' => $this->building_number,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
