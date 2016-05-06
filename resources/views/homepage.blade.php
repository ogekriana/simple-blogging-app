@extends('layouts.app')

@section('content')
<div class="container" ng-controller="homepageCtrl">
    <div class="row">
        <div class="col-md-12">                        
            <div ng-repeat="post in publishedPost">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="" ng-click="postDetail(post._id)">
                            <% post.post_title %>
                        </a>   
                        <a style="float:right" ng-hide="publishedPost.length > 0" ng-cloak ng-click="backHomepage()">BACK</a>                     
                    </div>

                    <div class="panel-body">
                        <p>Posted on <% post.post_date %> by <% post.author.name %></p>
                        <p><% post.post_content %></p>
                        <div>                            
                            <div style="float:right"><% post.count_view %> view(s)</div>
                        </div>
                        
                    </div>
                </div>
            </div> 

        </div>
    </div>
</div>
@endsection
