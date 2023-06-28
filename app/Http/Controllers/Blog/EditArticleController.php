<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EditArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Article $article): \Inertia\Response
    {
        return inertia()->render('Blog/Edit', [
            'article' => ArticleResource::make($article),
        ]);
    }
}
