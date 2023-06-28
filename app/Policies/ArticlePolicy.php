<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    public function view(User $user, Article $article)
    {
        if ($user->id === $article->user_id) {
            return true;
        }

        return $article->is_published;
    }

    public function edit(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }
}
