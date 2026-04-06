<?php

namespace App\Listeners;

use App\Events\BlogPublished;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendBlogPulishedNofication
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BlogPublished $event): void
    {
        //
        $user = User::all();

        Notification::send($user, new BlogPublished($event->blog));
    }
}
