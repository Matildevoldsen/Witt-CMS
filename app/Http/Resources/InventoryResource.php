<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'title' => $this->title,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'delivery_fee' => $this->delivery_fee,
            'sku' => $this->sku,
            'description' => $this->description,
            'additional_data' => $this->additional_data,
            'images' => explode(',', $this->images),
        ];
    }
}
