"use strict";

$(document).ready(() => {



//Auto play video when in view
const videoObserver = new IntersectionObserver((entries, observer) => {
	entries.forEach(entry => {
		if(entry.isIntersecting){
			entry.target.play();
		}else{
			entry.target.pause();
		}
	})
})

$('video').each((index) => {
	videoObserver.observe($('video').get(index));
})



})