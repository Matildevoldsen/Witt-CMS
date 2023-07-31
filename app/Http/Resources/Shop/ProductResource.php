<?php

namespace App\Http\Resources\Shop;

use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->formattedPrice(),
            'description' => $this->description,
            'images' => $this->getMedia('product-images'),
            'image' => $this->getFirstMediaUrl('product-images', 'webp'),
            'slug' => $this->slug,
            'meta_description' => SEOService::generateFromHtml($this->description),
            'variants' => ProductVariationResource::collection($this->variants),
        ];
    }
}
