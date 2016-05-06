<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Requests;
use Response;

use App\PublishedPost;


class BlogPostController extends Controller
{
    public function findByUser(Request $request){
        $blog_posts = BlogPost::where('blog_posts.user_id', $request->user)
            ->orderBy('blog_posts.created_at', 'desc')
            ->paginate(10);
        return Response::json($blog_posts, 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->status)){
            $blog_posts = BlogPost::where('blog_posts.post_status', $request->status)
                ->orderBy('blog_posts.post_date', 'desc')
                ->with('users')
                ->get();
        }else{
            $blog_posts = BlogPost::orderBy('blog_posts.created_at', 'desc')
                ->get();
        }   

        return Response::json(['data' => $blog_posts], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['user_id'] = $request->user;
        $rules = array(
            'user_id' => 'required | exists:users,id',
            'post_date' => 'required | date_format:Y-m-d',
            'post_title' => 'required | max:100',
            'post_content' => 'required',
            'post_status' => 'required | in:draft,published',
        );
        $validator = \Validator::make($attributes, $rules);
        if ($validator->fails()) {
            return Response::json([
                'error' =>[
                    $validator->errors()
                ]
            ],422);
        }else{
            $blogPost = BlogPost::create($attributes);

            return Response::json([
                    'message' => 'Post Created Succesfully',
                    'data' => $blogPost
            ]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){        

        $blogPost = BlogPost::find($request->post); 

        if(!$blogPost){
            return Response::json([
                'error' => [
                    'message' => 'Post doesn\'t exist'
                ]
            ], 404);
        }        

        return Response::json(['data' => $blogPost], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        //var_dump($request->input('date'));die;
        $rules = array(
            'post_date' => 'date_format:Y-m-d',
            'post_title' => 'max:100',
            'post_status' => 'in:draft,published',
        );
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json([
                'error' =>[
                    $validator->errors()
                ]
            ],422);
        }else{
            $blogPost = BlogPost::find($request->post);
            $blogPost->user_id = $request->user;
            $blogPost->post_date = $request->post_date;
            if($request->post_title != '')
                $blogPost->post_title = $request->post_title;
            if($request->post_content != '')
            $blogPost->post_content = $request->post_content;
            $blogPost->post_status = $request->post_status;
            $blogPost->save();

            return Response::json([
                    'message' => 'Post Updated Succesfully',
                    'data' => $blogPost
            ]);
        }       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        BlogPost::destroy($request->post);
        return Response::json(['message' => 'Post Deleted Succesfully']);
    }    

}
