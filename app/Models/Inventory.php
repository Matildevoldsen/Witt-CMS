<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Inventory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'name',
        'price',
        'quantity',
        'delivery_fee',
        'description',
        'additional_data',
        'images'
    ];

    public function searchableAs(): string
    {
        return 'inventory';
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'delivery_fee' => $this->delivery_fee,
            'description' => $this->description,
            'additional_data' => $this->additional_data,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
