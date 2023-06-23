<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\QueryFilters\Forum\MentionedQueryFilter;
use App\Http\QueryFilters\Forum\MineQueryFilter;
use App\Http\QueryFilters\Forum\NoRepliesQueryFilter;
use App\Http\QueryFilters\Forum\ParticipatingQueryFilter;
use App\Http\QueryFilters\Forum\SolvedQueryFilter;
use App\Http\QueryFilters\Forum\TopicQueryFilter;
use App\Http\QueryFilters\Forum\UnresolvedQueryFilter;
use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
            'query' => (object) $request->query(),
            'discussions' => DiscussionResource::collection(
                QueryBuilder::for(Discussion::class)->with(['topic', 'latestPost.user', 'participants', 'post'])
                    ->allowedFilters($this->allowedFilters())
                    ->withCount('replies')
                    ->orderByPinned()
                    ->orderByLastPost()
                    ->tap(function ($builder) use ($request) {
                        if (filled($request->search)) {
                            $ids = Discussion::search($request->search)->get()->pluck('id');
                            return $builder->whereIn('id', $ids);
                        }
                    })
                    ->paginate(10)
                    ->appends($request->query())
            ),
        ]);
    }

    private function allowedFilters() {
        return [
            AllowedFilter::custom('noreplies', new NoRepliesQueryFilter()),
            AllowedFilter::custom('mine', new MineQueryFilter()),
            AllowedFilter::custom('participating', new ParticipatingQueryFilter()),
            AllowedFilter::custom('topic', new TopicQueryFilter()),
            AllowedFilter::custom('solved', new SolvedQueryFilter()),
            AllowedFilter::custom('unresolved', new UnresolvedQueryFilter()),
            AllowedFilter::custom('mentioned', new MentionedQueryFilter()),
        ];
    }
}
