<?php

namespace App\Listeners;

use App\Events\CountView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BlogPost;

class CountViewFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CountView  $event
     * @return void
     */
    public function handle(CountView $event)
    {
        $blogPost = BlogPost::find($event->postId);
        $blogPost->count_view = (int)$blogPost->count_view + 1;
        $blogPost->save();
    }
}
