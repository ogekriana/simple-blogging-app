<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    public $table = "blog_posts";
    protected $fillable = [
    	'user_id', 'post_date', 'post_title', 'post_content', 'post_status'	
    ];

    public function users(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
