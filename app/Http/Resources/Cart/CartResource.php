<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rowId' => $this->row_id,
            'id' => $this->product_id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
            'options' => json_decode($this->options, true),
        ];
    }
}
