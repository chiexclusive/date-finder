"use strict";

$(document).ready(() => {
	$(".preview-medias-container").find(".close").click(() => {
		$(".preview-medias-container").hide().find(".content-container").html("");
	});

	$(".post-media-container").click(function(){

		$(".preview-medias-container").find(".content-container").html($(this).html());
		$(".preview-medias-container").css({"display": "flex"});

		$(".preview-medias-container").find("video").toArray().forEach((item, index) => {
			$(item).attr("controls", true);
		})

	})
});