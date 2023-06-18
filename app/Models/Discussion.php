<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Discussion extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug'
    ];

    /**
     * @return array
     */
    public function toSearchableArray(): array
    {
        return $this->only('id', 'title');
    }

    /**
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();

        static::created(function ($discussion) {
            $discussion->update(['slug' => $discussion->title]);
        });
    }

    /**
     * @param $value
     * @return void
     */
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = $this->id . '-' . Str::slug($value);
    }

    /**
     * @param $query
     * @return void
     */
    public function scopeOrderByPinned($query): void
    {
        $query->orderBy('pinned_at', 'asc');
    }

    /**
     * @param $query
     * @return void
     */
    public function scopeOrderByLastPost($query): void
    {
        $query->orderBy(Post::select('created_at')
            ->whereColumn('posts.discussion_id', 'discussions.id')
            ->latest()
            ->take(1),
            'desc'
        );
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return bool
     */
    public function isPinned(): bool
    {
        return !is_null($this->pinned_at);
    }

    /**
     * @return BelongsTo
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Post::class)
            ->whereNotNull('parent_id');
    }

    /**
     * @return HasOne
     */
    public function post(): HasOne
    {
        return $this->hasOne(Post::class)
            ->whereNull('parent_id');
    }

    /**
     * @return HasOne
     */
    public function latestPost(): HasOne
    {
        return $this->hasOne(Post::class)
            ->latestOfMany();
    }

    /**
     * @return HasManyThrough
     */
    public function participants(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Post::class,
            'discussion_id',
            'id',
            'id',
            'user_id')
            ->distinct();
    }

    /**
     * @return BelongsTo
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'solution_post_id');
    }
}
