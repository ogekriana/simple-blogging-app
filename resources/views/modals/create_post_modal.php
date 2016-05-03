<script type="text/ng-template" id="CreatePostModal.html">
	<div class="modal-header">
		<div class="modal-title">CREATE NEW POST</div>
	</div>
	<div class="modal-body">
		<form>
			<div class="form-group">
				<label for="post-title">Title</label>
	        	<input id="post-title" placeholder="Title" class="form-control" type="text" ng-model="posts.post_title">
	        </div>
	        <div class="form-group">
	        	<label for="post-content">Content</label>
	        	<textarea style="height: 350px;" id="post-content" placeholder="Content" class="form-control" type="text" ng-model="posts.post_content"></textarea>				        	
	        </div>	        
		</form>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary" ng-click="savePost(posts,'draft')">Save as Draft</button>
		<button type="submit" class="btn btn-default" ng-click="savePost(posts, 'published')">Publish</button>
	</div>
</script>



