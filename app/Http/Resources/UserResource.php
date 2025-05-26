<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'adress_1' => $this->adress_1,
            'adress_2' => $this->adress_2,
            'mobile_phone' => $this->mobile_phone,
            'level' => $this->level,
            'points' => $this->points,
            'email_confirmed' => $this->email_confirmed,
            'activated' => $this->activated,
            'profile_picture' => $this->profile_picture,
            'deleted' => $this->deleted,
        ];
    }
}
