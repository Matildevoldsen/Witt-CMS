<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Inertia\Response;

class ForumIndexController extends Controller
{
    /**
     * Handle the incoming request.
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return inertia()->render('Forum/Index', [
            'discussions' => DiscussionResource::collection(
                Discussion::with('topic')
                    ->orderByPinned()
                    ->latest()
                    ->paginate(10)
            ),
        ]);
    }
}
