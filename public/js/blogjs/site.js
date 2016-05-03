var blogApp = angular.module('blogApp', ['ngRoute', 'blogAppController', 'ui.bootstrap'],  function($interpolateProvider){
	$interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');	
});

var blogAppController = angular.module('blogAppController', ['blogAppServices']);

blogApp.directive('postsPagination', function(){  
   return{
      restrict: 'E',
      template: '<ul class="pagination" ng-show="totalPages > 1">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="init(user_id,1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="init(user_id,currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in pages" ng-class="{active : currentPage == i}">'+
            '<a href="javascript:void(0)" ng-click="init(user_id,i)"><% i %></a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="init(user_id,currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="init(user_id,totalPages)">&raquo;</a></li>'+
      '</ul>'
   };
});

blogAppController.controller('blogPostCtrl', ['$scope','$window','postService', '$uibModal', function($scope, $window, $postService, $uibModal){

  $scope.init = function(user_id, page){
    
    if(undefined != page){
      $scope.currentPage = page;
    }else{
      $scope.currentPage = 1;
    }
    $postService.getPostByUser($scope.user_id, $scope.currentPage).then(function(response){
      	$scope.totalPages = response.data.last_page;      
      	$scope.pages = []; 

      	for (var i = 1; i <= $scope.totalPages; i++) { 
        	$scope.pages.push(i) 
      	} 
      	$scope.blogPosts = response.data;
    	});
  	}

  	$scope.$watch('user_id', function () {
    	$scope.init($scope.user_id, $scope.currentPage);
  	});  


  	$scope.animationsEnabled = true;

 	$scope.openModalCreate = function(){
 		var modalInstance = $uibModal.open({
 			animation: $scope.animationsEnabled,
 			templateUrl: 'CreatePostModal.html',
 			controller: 'createPostCtrl' 			
 		});
 	};
 	$scope.openModalUpdate = function(postId){
 		$postService.setPostId(postId);		
		
    	var modalInstance = $uibModal.open({
      		animation: $scope.animationsEnabled,
      		templateUrl: 'UpdatePostModal.html',
      		controller: 'updatePostCtrl',
      		resolve: {
        		blogPosts: function () {
          			return $scope.posts;
        		}
      		}
    	});
 	};

  	$scope.toggleAnimation = function () {
    	$scope.animationsEnabled = !$scope.animationsEnabled;
  	};	

  	$scope.deletePost = function(postId){
  		$postService.postDelete(postId)
			.success(function(data){
				alert(data.message);
				$scope.$watch('user_id', function () {
			    	$scope.init($scope.user_id, $scope.currentPage);
			  	}); 
			})
			.error(function(data){
				alert("Failed to delete post!");
			});	
  	};

  	$scope.publishPost = function(postId){
  		var posts = {};
		var date = new Date();
		posts.post_date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);  
		posts.id=postId;
		posts.post_status='published';

		$postService.updatePost(posts).then(function(response){
			$scope.init(response.data.data.user_id, $scope.currentPage);
		});
			

  	};

}]);

blogAppController.controller('createPostCtrl', ['$scope','$window','postService','$uibModalInstance', function($scope,$window, $postService, $uibModalInstance){

	$scope.savePost = function(posts,status){	
		posts.post_status = status;
		var date = new Date();
		posts.post_date = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

		$postService.createPost(posts)
			.success(function(data) {
				$scope.message = data.message;	
				$uibModalInstance.close();
				$window.location.reload();	
			})
			.error(function(data) {
				$scope.reasons = data.reasons;
			});
	}
}]);	

blogAppController.controller('updatePostCtrl', ['$scope','$window','postService','$uibModalInstance', function($scope,$window, $postService, $uibModalInstance){

	$postService.getPostById().then(function(response){
		$scope.posts = response.data.data;
	});
	$scope.updatePost = function(data){
		$postService.updatePost(data)
			.success(function(data){
				$uibModalInstance.close();
				$window.location.reload();
			})
			.error(function(data){

			});
	}

	$scope.cancel = function(){
		$uibModalInstance.dismiss('cancel');
	}
}]);	

blogAppController.controller('homepageCtrl', ['$scope','$window','homepageService', 'postService', '$uibModal', '$log', '$http', function($scope, $window, $homepageService, $postService, $uibModal, $log, $http){
	$scope.stat = false;
	$scope.init = function(){
		$homepageService.getPublishedPost('published').then(function(response){
			$scope.publishedPost = response.data.data;
		});
	}
	if(!$scope.stat){
		$scope.init();
	}	

	$scope.postDetail = function(postId){
		$scope.stat = true;
		$postService.getPostById(postId).then(function(response){
			$scope.publishedPost = response.data;
		});
	}	

	$scope.backHomepage = function(){
		$scope.stat = false;
		$scope.init();
	}
}]);