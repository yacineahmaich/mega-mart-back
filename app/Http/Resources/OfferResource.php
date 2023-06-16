<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    static $wrap = null;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start' => $this->offer_start,
            'end' => $this->offer_end,
            'backdrop' => new ImageResource($this->image),
            'product' => $this->whenLoaded('product', $this->product)
        ];
    }
}
