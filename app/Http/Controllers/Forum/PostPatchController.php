<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostPatchRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostPatchController extends Controller
{
    public function __invoke(PostPatchRequest $request, Post $post)
    {
        $post->update($request->validated());

        return back();
    }
}
