<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rating' => $this->rating,
            'comment' => $this->comment,
            'at' => $this->created_at->format('Y M d'),
            'author' => new UserResource($this->author),
            'product' => new ProductResource($this->whenLoaded('product'))

        ];
    }
}
