<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start' => $this->discount_start,
            'end' => $this->discount_end,
            'percentage' => $this->percentage,
            'price' =>
            $this->product->price - ($this->product->price * $this->percentage / 100),
            'product' => $this
                ->whenLoaded(
                    'product',
                    function () {
                        return new ProductResource($this->product);
                    }
                ),
        ];
    }
}
