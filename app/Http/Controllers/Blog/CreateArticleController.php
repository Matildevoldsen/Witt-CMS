<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class CreateArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $article = Article::create([
            'title' => 'Untitled Article',
            'body' => 'Write your article here...',
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('blog.edit', $article);
    }
}
