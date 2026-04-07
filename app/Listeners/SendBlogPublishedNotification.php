<?php

namespace App\Listeners;

use App\Events\BlogPublished;
use App\Models\User;
use App\Notifications\BlogPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBlogPublishedNotification implements ShouldQueue
{


    public $tries = 5;

    public $queue = 'low';

    public $delay = 30;

    public function __construct()
    {
        //
    }

    public function backoff(): int
    {
        return 60; // retry after 60s if fails
    }
    /**
     * Handle the event.
     */
    public function handle(BlogPublished $event): void
    {
        //
        $user = User::find($event->blog->user_id);
        if ($user) {
            $user->notify(new BlogPublishedNotification($event->blog));
        }
    }
}
