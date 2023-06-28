<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Str;

class ArticleObserver
{
    public function creating(Article $article)
    {
        $article->slug = Str::uuid();
    }
}
