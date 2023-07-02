<?php

namespace App\Providers;

use App\Events\JobProcessed;
use App\Events\TestEvent;
use App\Jobs\ImportCsv;
use App\Listeners\SendJobProcessedEvent;
use App\Models\Article;
use App\Models\Post;
use App\Models\User;
use App\Observers\ArticleObserver;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    protected $observers = [
        User::class => [UserObserver::class],
        Post::class => [PostObserver::class],
        Article::class => [ArticleObserver::class]
    ];
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
