<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:delete-soft-delete-blog')]
#[Description('Command description')]
class DeleteSoftDeleteBlog extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // delete blog present in trash after 30 days
        Blog::onlyTrashed()
            ->where('deleted_at', '<', Carbon::now()->subDay(30))
            ->forceDelete();

        $this->info('old soft blogs are deleted successfully');
    }
}
