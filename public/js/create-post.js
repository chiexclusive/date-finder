"use strict"

//Window related properties
window.hasLoadedCard = false;

$(document).ready(() => {




//Variables
var emojiInstance, emojiInstanceCard, postMessage = "", postVisibility = "friends";
var postImage = [];
var postVideo = [];






//Elements
const postTextContainer = $(".post-text-field-container");
const imageField = $("#create-post-image-field");
const videoField = $("#create-post-video-field");
const imagePreviewContainer = $(".image-preview-container");
const mediaPreviewContainer = $(".media-preview-container");
const videoPreviewContainer = $(".video-preview-container");
const cancelMedia = $(".cancel-media");
const publishButton  = $(".publish");






//Bring in the emoji
emojiInstance = postTextContainer.find("textarea").emojioneArea({pickerPosition: "bottom", shortnames : true, saveEmojisAs: "shortname", events:{
	keyup: function(editor, event){
		$(".create-post-log").html("");
		postMessage = emojiInstance[0].emojioneArea.getText();
		activatePublishButton();
	},

	emojibtn_click: function(button, event){
		$(".create-post-log").html("");
		postMessage = emojiInstance[0].emojioneArea.getText();
		activatePublishButton();
	}
}});





//Get Image
imageField.on("change", (event) => {
	$(".create-post-log").html("");
	let files = event.target.files;
	postImage = [...postImage, ...files];
	previewLoadedMedia("image", files);
	activatePublishButton();
})


//Get Video
videoField.on("change", (event) => {
	$(".create-post-log").html("");
	let files = event.target.files;
	postVideo= [...postVideo, ...files];
	previewLoadedMedia("video", files);
	activatePublishButton();
})



//Delete Loaded images and vidos
mediaPreviewContainer.on("click", ".cancel-media", (event) => {
	const targetIndex = $(event.target).attr("data-cancel");
	const type =  $(event.target).attr("data-type");

	if(type === "image") postImage.splice(targetIndex, 1);
	else postVideo.splice(targetIndex, 1);

	
	$(event.target).parent().remove();

	//Check to remove preview header
	if(type === "image" && postImage.length === 0) $(".image-preview-header").hide();
	else if(type === "video" && postVideo.length === 0) $(".video-preview-header").hide();

	activatePublishButton();

})


function previewLoadedMedia(type, files){
	
	let previewContent = "";
	for(var x = 0; x < files.length; x++){
		previewContent = `
			${previewContent}
			<div class = "each-media-preview-video">
		          <span class = "cancel-media" data-cancel = "${x}" data-type = "${type}">&times</span>
		          <div style = "${type === 'video'? '':'width: 50px;'}">
		          ${
		          	type === "video" ? (
		          		`<video  width= "100" name="media">
			              <source src="${URL.createObjectURL(files[x])}" type="video/mp4">
			            </video>`
		          	): (
		          		`<img src = "${URL.createObjectURL(files[x])}" class = "w-100"/>`
		          	)
		          }
		            
	          </div>
	       </div>
		`
	}


	//Show preview header
	if(type ==="video") $(".video-preview-header").show();
	else $(".image-preview-header").show();


	//Get previous content
	let container = type === "video" ? videoPreviewContainer : imagePreviewContainer;


	if($(container).html().toString().trim().length === 0) $(container).append($(previewContent));
	else $(previewContent).insertBefore($(container).children(":first"));
}





//Set post visibility
window.setPostVisibility = (value) =>
{
	postVisibility = value;
	const visibilityOptions = {friends: "Friends", public: "Public", me: "Only Me"};
	const visibilityIcons = {friends: "group", public: "globe", me: "lock"}
	let html = `
		<span class = "fa fa-${visibilityIcons[postVisibility]}"></span>
        <span class = "">${visibilityOptions[postVisibility]}</span>
        <span class = "fa fa-arrow-right"></span>
	`;

	$(".privacy-box").html(html);

}








//Check to enable button
function activatePublishButton ()
{
	if(postMessage.length > 0 || postImage.length > 0 || postVideo.length > 0 ) publishButton.attr("disabled", false);
	else publishButton.attr("disabled", true);
}







publishButton.on("click", () => {
	//Set processing state in button
	publishButton.text("Publishing...").attr("disabled", true);

	//Cook up a form data
	const data = new FormData();
	data.append("message", postMessage);

	postImage.forEach((file, fileIndex) => {
		data.append("image_"+fileIndex, file);
	})

	postVideo.forEach((file, fileIndex) => {
		data.append("video_"+fileIndex, file);
	})

	data.append("postVisibility", postVisibility);

	let url = "/post";
	let config = {
		method: "POST",
		body: data,
		headers: {
			'X-CSRF-TOKEN': $("#createPostModal").find("input[name='_token']").val(),
		}
	}

	fetch(url, config)
	.then((response) => response.json()
	.then((res) => {
		//Handle success
		if(typeof res === 'object' && 'success' in res && res.success === true){

			//Display Success Message
			$(".create-post-log").html(`
				<div class = "alert alert-success">${res.message}</div>
			`)

			window.location.reload();

			publishButton.text("Publish").attr("disabled", false);
			
		}


		//Handle failure
		if(typeof res === 'object' && 'success' in res && res.success === false){

			//Display Success Message
			$(".create-post-log").html(`
				<div class = "alert alert-danger">${res.message}</div>
			`)

			publishButton.text("Publish").attr("disabled", true);
		}


		
	})).catch(() => {
		publishButton.text("Publish").attr("disabled", false);
	})

})






})//End of file