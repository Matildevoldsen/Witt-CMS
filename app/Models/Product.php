<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\Conversion\Conversion;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->getFirstMediaUrl('product-images', 'webp'),
        ];
    }

    public static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\ProductLiveScope);

        static::creating(function ($product) {
            $product->slug = \Str::slug(Str::random(8));
        });
    }

    public function formattedPrice(): \Cknow\Money\Money
    {
        return money($this->price);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format(Manipulations::FORMAT_WEBP)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-images')
            ->useFallbackUrl(url('/storage/no-product-image.png'));
    }
}
