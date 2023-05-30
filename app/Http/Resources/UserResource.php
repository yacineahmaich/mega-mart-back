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
            'isAdmin' => $this->role === 'admin',
            'name' => $this->name,
            'email' => $this->email,
            'profileImg' => $this->profile_image
        ];
    }
}
