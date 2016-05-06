<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PublishedPostController;

class SyncPublishedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:all:published';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize all published post to mongodb collection';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->publishedPost = new PublishedPostController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->publishedPost->syncAllPublished();
        $this->info('all published posts synchronize succesfully');
    }
}
