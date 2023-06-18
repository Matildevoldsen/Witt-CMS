<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class DiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'title' => $this->title,
            'slug' => $this->slug,
            'post' => PostResource::make($this->whenLoaded('post')),
            'is_pinned' => $this->isPinned(),
            'replies_count' => $this->replies_count . ' ' . Str::plural('reply', $this->replies_count),
            'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
            'participants' => PublicUserResource::collection($this->whenLoaded('participants')),
            'solution' => PostResource::make($this->whenLoaded('solution')),
            'user_can' => [
                'reply' => $request->user()?->can('reply', $this->resource),
                'solve' => $request->user()?->can('solve', $this->resource),
                 //Todo: add later
//                'edit' => $request->user()?->can('edit', $this->resource),
//                'delete' => $request->user()?->can('delete', $this->resource),
//                'pin' => $request->user()?->can('pin', $this->resource),
//                'lock' => $request->user()?->can('lock', $this->resource),
//                'unlock' => $request->user()?->can('unlock', $this->resource),
            ]
        ];
    }
}
