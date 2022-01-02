"use strict";

$(document).ready(() => {

	//Check when the upload profile field changed
	$("#profile-photo").find(".upload-field-profile").change((event) => {
		let file = event.target.files[0];


		let form = new FormData();
		form.append("image", file);


		let url = `/users/profile/image`;

		let config = {
			method: "POST",
			body: form,
			headers: {
				'X-CSRF-TOKEN': token
			}
		}

		fetch(url, config)
		.then((response) => response.json())
		.then(async (res) => {
			if(res.success === true){
				window.location.reload();
			}
		});
	})



	//Check when the upload profile cover  field changed
	$("#profile-cover").find(".upload-field-cover").change((event) => {
		let file = event.target.files[0];



		let form = new FormData();
		form.append("image", file);


		let url = `/users/profile/cover`;

		let config = {
			method: "POST",
			body: form,
			headers: {
				'X-CSRF-TOKEN': token
			}
		}

		fetch(url, config)
		.then((response) => response.json())
		.then(async (res) => {
			if(res.success === true){
				window.location.reload();
			}
		});
	})


	//Open cover image on click
	$(".timeline-cover-container").on("click", ".cover-photo", function () {
		viewImage($(this));
	})


	$(".timeline-nav-bar").on("click", ".profile-photo", function(){
		viewImage($(this));
	})

	 $(".view-profile-image").click(() => {
	 	viewImage($(".timeline-nav-bar").find(".profile-photo"));
	 })

	 $(".view-cover-image").click(() => {
	 	viewImage($(".timeline-cover-container").find(".cover-photo"));
	 })


	//Close preview
	 $(".profile-image-preview").on("click", "span", function () {
	 	$(".profile-image-preview").hide();
	 })

	
})



function viewImage(img){
	let src = $(img).attr("src");
	let target = $(".profile-image-preview");

	if(src == "" || src == undefined ) return 

	$(target).find("img").attr("src", src);
	$(target).css({"display":"flex"});
}