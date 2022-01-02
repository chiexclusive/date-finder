"use strict";

$(document).ready(() => {


$(".post-isibility-save").click(() => {

	window.setPostVisibility($("input[name='post-visibility']:checked").val());
})


})