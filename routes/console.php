<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Log::info('Job started processing.');
// Schedule::command('queue:listen')
//          ->everyMinute()
//          ->runInBackground();

// Log::info('Job finished processing.');
