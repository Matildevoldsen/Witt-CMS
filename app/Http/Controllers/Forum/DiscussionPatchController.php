<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscussionSolutionPatchRequest;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;

class DiscussionPatchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DiscussionSolutionPatchRequest $request, Discussion $discussion)
    {
        $discussion->solution()->associate(Post::find($request->post_id));
        $discussion->save();

        return back();
    }
}
