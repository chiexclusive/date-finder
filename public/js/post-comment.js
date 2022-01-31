"use strict";

var comments = [];
var users = {};
var likes = {};



$(document).ready(() =>{
	emojilize();


	$(".emojionearea.post-comment-field").toArray().forEach((item, index) => {

		$(item).on("keyup", async function(event){
			if(event.which == 13){
				
				//Get post content
				let comment = $(this).prev().val();

				let postId = $(this).prev().attr("data-post-id");


				//Register post
				await registerComment((index), comment, postId);

				//Do some rendering
			}
		})
	})



	//Refresh comment
	$(".refresh-comment").click(function(){
		let postId = $(this).attr("data-post");
		refreshComments(postId)
	})


	//View more comment
	$(".view-more-comment").click(function (){
		let loaded = $(this).attr("data-loaded");
		$(this).attr("data-loaded", loaded + 5);
		let id = $(this).attr("data-post");
		if(comments.length  > 0) renderComments(id);
		else refreshComments(id);
	})

	//Like comments
	$('.comment-container').on("click", ".comment-like-container i", async function (){
		let commentId = $(this).attr("data-comment");
		let postId = $(this).attr("data-post");
		await registerCommentLike(commentId, postId);
	})

})



function registerComment (index, comment, postId)
{
	return new Promise((resolve, reject) => {

		let data = new FormData();
		data.append("comment", comment);

		let url = `/post/${postId}/comment`;

		let config = {
			method: "POST",
			body: data,
			headers: {
				'X-CSRF-TOKEN': $("input[name='_token']").val(),
			}
		}

		fetch(url, config)
		.then((response) => response.json())
		.then((res) => {
			//Handle success
			if(typeof res === 'object' && 'success' in res && res.success === true){
				//Empty the field
				window.commentEmoji[index][0].emojioneArea.setText("");
				refreshComments(postId);
				resolve();
			}else if("redirect" in res){
				// window.location = "/"+ res.redirect;
			}
		})
	}) 
}



function refreshComments(postId)
{
	//Get all comments
	//Get all users that made the comments
	//Get all likes for the comments


	return new Promise((resolve, reject) => {

		let data = new FormData();

		let url = `/post/${postId}/comment/get`;

		let config = {
			method: "POST",
			headers: {
				'X-CSRF-TOKEN': $("input[name='_token']").val(),
			}
		}

		fetch(url, config)
		.then((response) => response.json())
		.then((res) => {
			//Handle success
			if(typeof res === 'object' && 'success' in res && res.success === true){
				comments = res.data.comments;
				users = res.data.users;
				likes = res.data.likes;

				renderComments(postId);
				resolve();
			}else if("redirect" in res){
				// window.location = "/"+ res.redirect;
			}
		})
	}) 
}


function renderComments (id)
{
	let counter = 0;
	let html = "";
	let target = $("#comment_"+id);
	let loaded = $(target).parent().parent().find(".view-more-comment").attr("data-loaded");
	
	comments.forEach((comment, commentId) => {

			html += `

				<div class="post-comment">
                    <div>
                        <img src="${users[comment.user_id].image === null ? '/images/default_profile_image.png' : users[comment.user_id].image}" alt="" class="profile-photo-sm">
                    </div>
                    <p style = "position: relative;">
                        <a href="/profile/${users[comment.user_id].id}/timeline" class="profile-link">
                            ${window.ucwords(users[comment.user_id].firstname)}
                        </a> 
                        <span class = "message">${comment.comment}</span>
                        <span class = "comment-like-container">
                            <i class="icon ion-thumbsup" data-post = "${id}" data-comment = "${comment.id}"></i>
                            ${likes[comment.id].length > 0 ? `<span>${likes[comment.id].length}</span>`: ''}     
                        </span>
                    </p>
                </div>

			`;

		counter++;
	})

	$(target).html(html);

	setTimeout(() => emojilize());
}


function registerCommentLike(commentId, postId)
{
	return new Promise((resolve, reject) => {

		let data = new FormData();

		let url = `/post/${postId}/comment/${commentId}}/like`;

		let config = {
			method: "POST",
			headers: {
				'X-CSRF-TOKEN': $("input[name='_token']").val(),
			}
		}

		fetch(url, config)
		.then((response) => response.json())
		.then((res) => {
			//Handle success
			if(typeof res === 'object' && 'success' in res && res.success === true){
				refreshComments(postId);
				resolve();
			}else if("redirect" in res){
				// window.location = "/"+ res.redirect;
			}
		})
	})
}


function emojilize()
{
	$(".message").each((index, item)=> {
		var converted = emojione.toImage($(item).html())
    	$(item).html(converted);
	})
		
}