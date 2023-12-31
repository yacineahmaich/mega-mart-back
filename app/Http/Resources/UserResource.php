<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'isAdmin' => $this->when($this->isAdmin(), true),
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => new ImageResource($this->avatar)
        ];
    }
}
