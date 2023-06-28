<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticlePatchRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class PublishArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ArticlePatchRequest $request, Article $article)
    {
        $article->update([
            'is_published' => !$article->is_published
        ]);

        return response()->json([
            'message' => 'Article published successfully',
        ]);
    }
}
