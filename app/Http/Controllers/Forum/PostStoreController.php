<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;

class PostStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PostStoreRequest $request, Discussion $discussion)
    {
        $post = Post::make($request->validated());

        $post->user()->associate(auth()->user());
        $post->discussion()->associate($discussion);
        $post->parent()->associate($discussion->post);

        $post->save();

        return redirect(route('discussions.show', $discussion) . '?post=' . $post->id);
    }
}
