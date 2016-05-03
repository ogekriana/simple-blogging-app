@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">        
        <div class="col-md-8 col-md-offset-2" ng-controller="blogPostCtrl" ng-cloak> 
            @include('modals.create_post_modal')
            @include('modals.update_post_modal')
            <div ng-init="user_id={{Auth::user()->id }}"></div>
            <div class="panel panel-default" ng-show="blogPosts.data.length == 0">
                <div class="panel-heading">You haven't create any Post yet</div>
                <div class="panel-body" style="text-align:center">
                    <p>Click on button bellow to create a new POST!</p>
                    <a href="" ng-click="openModalCreate()" type="button" class="btn btn-primary">CREATE NEW POST</a>
                </div>                
            </div>                                             
            <div ng-show="blogPosts.data.length != 0" ng-cloak>
                <a href="" ng-click="openModalCreate()" type="button" class="btn btn-primary btn-block">CREATE NEW POST</a> 
                <br>
                <div class="panel panel-default" ng-repeat="blogPost in blogPosts.data">
                    <div class="panel-heading">
                        <% blogPost.post_title %>                                             
                    </div>                    
                    <div class="panel-body">
                        <p>Post date: <% blogPost.post_date %></p>
                        <p><% blogPost.post_content %></p>                    
                    </div>                               
                    <div class="panel-footer">  
                        <span ng-if="blogPost.post_status == 'published'"><% blogPost.post_status %></span>
                        <a ng-if="blogPost.post_status == 'draft'" href="" ng-click="publishPost(blogPost.id)">Publish Post</a>                      
                        <span style="float:right">
                            <a href="" ng-click="openModalUpdate(blogPost.id)">Update</a>
                             | 
                            <a href="" ng-click="deletePost(blogPost.id)">Delete</a>                             
                        </span>
                    </div>
                </div>
                <div>
                    <posts-pagination></posts-pagination>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
