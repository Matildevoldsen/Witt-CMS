<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use Illuminate\Http\Request;

class ForumIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia()->render('Forum/Index', [
            'discussions' => DiscussionResource::collection(
                Discussion::with('topic')
                    ->paginate(10)
            ),
        ]);
    }
}
