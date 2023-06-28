<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ArticleIndexRequest $request, Article $article)
    {
        return inertia()->render('Blog/Index', [
            'article' => ArticleResource::make($article)
        ]);
    }
}
