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
        $post = \DB::connection('mongodb')->collection('user_posts')
            ->find((int)$event->postId);
                
        \DB::connection('mongodb')->collection('user_posts')
          ->where('_id', (int)$event->postId)
          ->update(array('count_view' => $post['count_view'] + 1));
    }
}
