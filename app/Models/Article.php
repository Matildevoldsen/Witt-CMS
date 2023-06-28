<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'slug',
        'meta_description',
        'image',
        'is_published'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
