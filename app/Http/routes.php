<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::auth();

Route::get('/dashboard', 'HomeController@index');
Route::get('/post/{id}/{slug}', 'PublishedPostController@detail');

Route::group(['prefix' => 'api/v1/'], function(){
	//get post by post id
	Route::get('posts/{post}', [
    	'as'   => 'post.show',
	    'uses' => 'BlogPostController@show'
	])->where('post', '[0-9]+');
	Route::get('posts', [
    	'as'   => 'post.index',
	    'uses' => 'BlogPostController@index'
	]);
	Route::delete('posts/{post}', [
    	'as'   => 'users.post.delete',
	    'uses' => 'BlogPostController@destroy'
	])->where('post', '[0-9]+');


	Route::get('posts/all','PublishedPostController@getAllPosts');
	Route::get('single-post/{post}','PublishedPostController@getPost');
	Route::delete('deletepost/{post}','PublishedPostController@deleteRecord');


	//get pots by user
	Route::get('users/{user}/posts', [
		'as' => 'users.post.all',
		'uses' => 'BlogPostController@findByUser'
	])->where('user','[0-9]+');
	//store new post
	Route::post('users/{user}/post', [
		'as' => 'users.post.store',
		'uses' => 'BlogPostController@store'
	])->where('user','[0-9]+');	

	Route::put('users/{user}/posts/{post}', [
    	'as'   => 'users.post.update',
	    'uses' => 'BlogPostController@update'
	])->where('user', '[0-9]+')->where('post', '[0-9]+');	

});
