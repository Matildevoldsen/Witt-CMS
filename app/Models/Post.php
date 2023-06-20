<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'body'
    ];

    /**
     * @return BelongsTo
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function mentions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'mentions', 'post_id')
            ->withTimestamps();
    }
}
