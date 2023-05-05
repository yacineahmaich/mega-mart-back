<?php

namespace App\Http\Resources;

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
            "id" => $this->id,
            "items" => $this->cart_items->map(function ($item) {
                return [
                    "id" => $this->id,
                    "name" => $this->name,
                    "price" => $this->price,
                    "quantity" => $this->quantity,
                ];
            }),
            "total" => $this->cart_items->sum("price")

        ];

    }
}