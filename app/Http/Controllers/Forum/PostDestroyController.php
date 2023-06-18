<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostDestroyRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PostDestroyRequest $request, Post $post)
    {
        $post->delete();

        return back();
    }
}
