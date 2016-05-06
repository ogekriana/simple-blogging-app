<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Http\Requests;
use App\BlogPost;
use Event;
use App\Events\CountView;

class PublishedPostController extends Controller
{
    protected $connection = 'mongodb';
    protected $collection = 'user_posts';

    public function getAllPosts(){
        $blogPosts = \DB::connection($this->connection)->collection($this->collection)
            ->orderBy('post_date', 'desc')
            ->get();
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
	    				'post_title' => $key->post_title,
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

    public function getPost(Request $request){																																																																																																																												
    	if(\Auth::guest()){
            Event::fire(new CountView($request->post));
        }
    	$post = \DB::connection($this->connection)->collection($this->collection)
            ->find((int)$request->post);

        if(!$post){
            return Response::json([
                'error' => [
                    'message' => 'Post doesn\'t exist'
                ]
            ], 404);
        }        

        return Response::json(['data' => $post], 200);
    }
}