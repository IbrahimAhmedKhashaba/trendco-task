<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id'    => $this->id,
            'name'  => $this->name,
            'description'  => $this->description,
            'status'  => $this->status,
            'image' => $this->whenLoaded('image' , function(){
                return asset('uploads/categories/'.$this->image->url);
            })
        ];

        if(request()->routeIs('admin.categories.index')) {
            $data['status'] = $this->status;
            $data['created_at'] = $this->created_at->format('Y-m-d H:i:s');
            $data['updated_at'] = $this->updated_at->format('Y-m-d H:i:s');
        }

        return $data;
    }
}
