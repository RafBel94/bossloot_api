<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'category' => $this->category,
            'model' => $this->model,
            'brand' => $this->brand,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'on_offer' => $this->on_offer,
            'discount' => $this->discount,
            'featured' => $this->featured,
            'image' => $this->image,
            'points' => $this->points,
            'specs' => $this->specs
        ];
    }
}
