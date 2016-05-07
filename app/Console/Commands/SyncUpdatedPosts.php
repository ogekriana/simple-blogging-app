<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PublishedPostController;

class SyncUpdatedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:updated:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize last 1 minute updated posts';

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
        if($this->publishedPost->syncUpdatedPosts() != '[]'){
            $this->info('all updated posts synchronize succesfully');    
        }else{
            $this->info('no update was made');
        }
        
    }
}
