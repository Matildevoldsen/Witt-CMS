<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticlePatchRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;

class ArticlePatchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ArticlePatchRequest $request, Article $article)
    {
        $article->update([
            'title' => $request->title,
            'body' => Purify::clean($request->body),
            'slug' => $request->slug
        ]);

        return redirect()->route('blog.edit',$article->slug);
    }
}
