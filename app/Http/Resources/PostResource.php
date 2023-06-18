<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class PostResource extends JsonResource
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
            'body' => $this->body,
            'body_markdown' => app(MarkdownRenderer::class)->toHTML($this->body),
            'user' => PublicUserResource::make($this->whenLoaded('user')),
            'body_preview' => Str::limit($this->body, 200),
            'created_at' => DateTimeResource::make($this->created_at),
            'discussion' => DiscussionResource::make($this->whenLoaded('discussion')),
            'user_can' => [
                'edit' => auth()->user()?->can('edit', $this->resource),
                'destroy' => auth()->user()?->can('destroy', $this->resource),
             ]
        ];
    }
}
