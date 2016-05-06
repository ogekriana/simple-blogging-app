<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Http\Requests;
use App\BlogPost;

class PublishedPostController extends Controller
{
    protected $connection = 'mongodb';
    protected $collection = 'user_posts';

    public function getAllPosts(){
        $blogPosts = \DB::connection($this->connection)->collection($this->collection)->get();
        return Response::json([
                    'data' => $blogPosts
            ]);
    }

    public function syncAllPublished(){
    	$post = BlogPost::with('users')->where('post_status', 'published')->get();
    	foreach ($post as $key) {
    		$blogPost = \DB::connection($this->connection)->collection($this->collection)
	    		->insert(array(
	    				'_id' => $key->id,
	    				'post_date' => $key->post_date,
	    				'post_content' => $key->post_content,
	    				'post_status' => $key->post_status,
	    				'count_view' => $key->count_view,
	    				'author' => array(
	    						'user_id' => $key->users->id,
	    						'name' => $key->users->name
	    					)
	    			));	    	
    	}
    }
}
