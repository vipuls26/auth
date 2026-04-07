<?php

namespace App\Providers;

use App\Events\BlogPublished;
use App\Listeners\SendBlogPublishedNofication;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        BlogPublished::class => [
            SendBlogPublishedNofication::class,
        ],
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
