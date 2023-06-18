<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'totalPrice' => $this->total_price,
            'customer' =>  new UserResource($this->customer),
            "delivery" => [
                'shippingAddress' => $this->shipping_address,
                'email' => $this->email,
                'name' => $this->name,
                'phone' => $this->phone,
                'note' => $this->note,
            ],
            'delivered' => $this->delivered,
            'deliveredAt' => $this->whenNotNull($this->delivered_at->format('Y-m-d H:i:s')),
            'date' => $this->created_at->format('Y-m-d'),
            'items' => new ItemCollection($this->items),
        ];
    }
}
