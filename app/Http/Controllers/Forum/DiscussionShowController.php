<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\QueryFilters\Forum\MineQueryFilter;
use App\Http\QueryFilters\Forum\NoRepliesQueryFilter;
use App\Http\QueryFilters\Forum\ParticipatingQueryFilter;
use App\Http\QueryFilters\Forum\TopicQueryFilter;
use App\Http\Resources\DiscussionResource;
use App\Http\Resources\PostResource;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;

class DiscussionShowController extends Controller
{
    private const POSTS_PER_PAGE = 10;
    /**
     * Handle the incoming request.
     * @param Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function __invoke(Discussion $discussion, Request $request)
    {
        if ($postId = $request->get('post')) {
            return redirect()->route('discussions.show', [
                'discussion' => $discussion,
                'page' => $this->getPageForPost($discussion, $postId),
                'postId' => $postId
            ]);
        }

        $discussion = $discussion->load(['topic', 'posts.discussion', 'solution'])->loadCount(['replies']);
        return inertia()->render('Forum/Show', [
            'query' => (object)$request->query(),
            'discussion' => DiscussionResource::make($discussion),
            'posts' => PostResource::collection(
                Post::whereBelongsTo($discussion)
                    ->with(['user', 'discussion'])
                    ->oldest()
                    ->paginate(self::POSTS_PER_PAGE)
            ),
            'postId' => (int) $request->get('postId')
        ]);
    }

    private function getPageForPost(Discussion $discussion, $postId)
    {
        $index = $discussion->posts->search(fn ($post) => $post->id == $postId);
        $page = (int) ceil(($index + 1) / self::POSTS_PER_PAGE);

        return $page;
    }

    private function allowedFilters()
    {
        return [
            AllowedFilter::custom('noreplies', new NoRepliesQueryFilter()),
            AllowedFilter::custom('mine', new MineQueryFilter()),
            AllowedFilter::custom('participating', new ParticipatingQueryFilter()),
            AllowedFilter::custom('topic', new TopicQueryFilter()),
        ];
    }
}
