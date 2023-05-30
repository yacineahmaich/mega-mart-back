<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'createdAt' => $this->created_at->format('Y M d'),
            'totalProducts' => count(collect($this->products))
            // 'products' => new ProductCollection($this->whenLoaded('products'))
        ];
    }
}
