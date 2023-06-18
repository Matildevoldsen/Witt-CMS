<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserMention;

class UserObserver
{
    public function updated(User $user)
    {
        $user->mention()->searchable();
    }

    public function created(User $user)
    {
        $user->mention()->searchable();
    }
}
