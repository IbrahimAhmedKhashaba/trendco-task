<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'rowId' => $this->row_id,
            'id' => $this->product_id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price,
        ];
    }
}
