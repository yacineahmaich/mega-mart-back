<?php

namespace App\Http\Resources;

use App\Http\Resources\ImageCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'discount' => new DiscountResource($this->discount),
            'avgRating' => $this->calcAvgRating(),
            'category' => $this->whenLoaded('category', new CategoryResource($this->category)),
            'images' => new ImageCollection($this->images),
            'totalReviews' => count($this->reviews)
        ];
    }
}
