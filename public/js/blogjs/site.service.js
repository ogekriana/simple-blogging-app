var blogAppServices = angular.module('blogAppServices', []);

blogAppServices.service('postService', ['$http', function($http){

	this.setPostId = function(postId){
		this.postId = postId;
	};

	this.getPostById = function(postId){		
		if(!postId){
			var endpoint = '/api/v1/posts/'+this.postId;
		}else{
			var endpoint = '/api/v1/posts/'+postId;
		}
		
		return $http({
			method: 'GET',
			url: endpoint
		})
		.success(function(data){
			return data;
		})
		.error(function(data){
			return data;
		});
	}

	this.getPostByUser = function(userId, page){
		this.userId = userId;
		var endpoint = '/api/v1/users/'+this.userId+'/posts?page='+page;
	    return $http({
				method: 'GET',
				url: endpoint
			})
			.success(function(data) {
				return data;
			})
			.error(function(data) {
				return data;
			});
	};

	this.createPost = function(param){
		var endpoint = '/api/v1/users/'+this.userId+'/post';
		return $http({
			method : 'POST',
			url : endpoint,
			data : param,
			headers: {
					'Content-Type': 'application/json'
				}
			})
			.success(function(data){
				return data;
			})
			.error(function(data){
				return data;
			});
	};

	this.updatePost =function(param){
		var endpoint = '/api/v1/users/'+this.userId+'/posts/'+param.id;
		return $http({
			method: 'PUT',
			url: endpoint,
			data: param,
			headers: {'Content-Type': 'application/json'}
		})
		.success(function(data){
			return data;
		})
		.error(function(data){
			return data;
		});		
	};

	this.postDelete = function(param){
		var endpoint = '/api/v1/posts/'+param;
		return $http({
			method : 'DELETE',
			url : endpoint
			})
			.success(function(data){
				return data;
			})
			.error(function(data){
				return data;
			});
	};

}]);

blogAppServices.service('homepageService', ['$http', function($http){

	this.getPublishedPost =function(status){
		var endpoint = '/api/v1/posts/all';
	    return $http({
				method: 'GET',
				url: endpoint
			})
			.success(function(data) {
				return data;
			})
			.error(function(data) {
				return data;
			});
	};

	this.getSinglePost = function(postId){		
		var endpoint = '/api/v1/single-post/'+postId;
		
		return $http({
			method: 'GET',
			url: endpoint
		})
		.success(function(data){
			return data;
		})
		.error(function(data){
			return data;
		});
	};

}]);