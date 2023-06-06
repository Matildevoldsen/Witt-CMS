<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\PostResource;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Response;

class DiscussionShowController extends Controller
{
    /**
     * Handle the incoming request.
     * @param Discussion $discussion
     * @return Response
     */
    public function __invoke(Discussion $discussion): \Inertia\Response
    {
        return inertia()->render('Forum/Show', [
            'discussion' => DiscussionResource::make($discussion->load(['topic'])),
            'posts' => PostResource::collection(
                Post::whereBelongsTo($discussion)
                    ->with(['user', 'discussion'])
                    ->oldest()
                    ->paginate(10)
            )
        ]);
    }
}
