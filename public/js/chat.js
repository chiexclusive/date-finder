"use strict"

//Variables
var chatData = [];
var renderedChat = [];
var userId;
var users = [];
var token;
var selectedChat;
var usersIdList = [];


$(document).ready(() => {

	//Get token
	token = document.getElementsByName("_token")[0].value;

	//Get user id
	userId = $(".auth").text();


	if(userId == undefined || userId == "") return;

	//Toggle chat box in mobil
	$(".mobile-chat-toggle").click(() => {
		$(".chat-section").removeClass("cover");
		$(".mobile-message-toggler").addClass("appear");
		$(".chat").css({"height": "100%", "width": "unset"});
		setTimeout(() => {
			$(".mobile-message-toggler").css({"transform": "rotate(360deg"})
		},100);
	})
	$(".mobile-message-toggler").click(() => {
		$(".toggle-chevron").find(".fa").removeClass("rotate-down").addClass("rotate-up")
		$(".mobile-message-toggler").css({"transform": "rotate(-360deg"})
		setTimeout(() => {
			$(".chat-section").addClass("cover");
			$(".chat-section-body").show();
			$(".mobile-message-toggler").removeClass("appear")
			$(".chat").css({"height": "100%", "width": "100%"});
			deleteSelectedChat()
		}, 300);
	})


	//Toggle chat box on desktop
	$(".toggle-chevron").find(".fa-chevron-down").click(() => {

		if($(".toggle-chevron").find(".fa-chevron-down").hasClass("rotate-up")){
			$(".toggle-chevron").find(".fa-chevron-down").addClass("rotate-down").removeClass("rotate-up");
			$(".chat-section-body").hide();
			deleteSelectedChat();
		} 
		else{
			$(".toggle-chevron").find(".fa-chevron-down").removeClass("rotate-down").addClass("rotate-up");
			$(".chat-section-body").show();
		}
	})


	$(".toggle-messages").click(() => {
		if($(".toggle-chevron").find(".fa-chevron-down").hasClass("rotate-up")){
			$(".toggle-chevron").find(".fa-chevron-down").addClass("rotate-down").removeClass("rotate-up");
			$(".chat-section-body").hide();
			deleteSelectedChat();
		} 
		else{
			$(".toggle-chevron").find(".fa-chevron-down").removeClass("rotate-down").addClass("rotate-up");
			$(".chat-section-body").show();
		}
	})



	start();


	//Add click functionality to each of the  item in the chat list
	$(".chat-list-section").on("click", ".chat-list-item", function () {
		let id = $(this).attr("data-id");
		//Set chat id
		selectedChat = id;
		loadChatContent(undefined);
		emojilize()
		$(".chat-content-section").addClass("show");

	})


	//Implement sending of message
	$(".chat-content-section").find(".send-message").click(() => {
		let messageField = $(".send-message-field");
		let message = $(messageField).val();
		sendChat(message)
		.then(() => {
			//Clean up
			$(".send-message-container").find(".emojionearea-editor").html("");
		})
	})


	//Close the chat
	$(".chat-content-section").find(".close").click(() => {
		$(".chat-content-section").removeClass("show");
	})



	//Message user
	$(".message-user").click(async function (){
		let id = $(this).attr("data-id");
		usersIdList.push(id);
		await fetchUsersInformation();
		loadChatContent(id);
		$(".chat-content-section").addClass("show");

		//Match mobile and click the toggler
		if(window.matchMedia("(max-width: 750px)").matches)	$(".mobile-message-toggler").click();
	})



	//Implement refresh
	$(".chat-section").find(".refresh").click(async function (){
		$(this).addClass("rotate")
		await refresh()
		$(this).removeClass("rotate")
	})



	$(".chat-room").find(".refresh").click(async function (){
		await refresh()
	})



	//Filter chats
	$(".search-chats").on("keyup", function (){
		filterChats($(this).val());
	})






})



//Get chats and render
function start(){
	return new Promise(async (resolve, reject) => {
		await getChatData();

		//Populate the user list
		chatData.forEach((item, index) => {
			if(item.first_user_id.toString() !== userId) usersIdList.push(item.first_user_id);
			else usersIdList.push(item.second_user_id);
		})

		if(chatData.length !== 0) await fetchUsersInformation();
		renderChat(chatData, users);
		setTimeout(() => emojilize());
		resolve();
	})
}





function openChatContent()
{

}



function getChatData()
{
	return new Promise((resolve, reject) => {
		//Fetch chats from the server
		let url = `/users/${userId}/chats`;
		let config = {
			method: "GET"
		}

		fetch(url, config)
		.then((response) => response.json())
		.then((res) => {

			//Response will be of this structure
			// res = [
			// 	id: 
			// 	first_user_id:
			// 	second_user_id:
			// 	messages: [
			// 		0: {
			// 			sender: 
			// 			receiver:
			// 			message: 
			// 			read:
			// 		}
			// 	]
			// ]
			chatData = res;
			resolve();
		});
	})
}






function fetchUsersInformation(chatData){
	return new Promise((resolve, reject) => {


		let userList = usersIdList;

		userList = [userId, ...userList];

		let form = new FormData();
		form.append("list", JSON.stringify(userList));



		let url = `/users/fetch`;
		let config = {
			method: "POST",
			body: form,
			headers: {
				'X-CSRF-TOKEN': token
			}
		}

		fetch(url, config)
		.then((response) => response.json())
		.then((res) => {
			if(res.success == true) users = res.data;
			else users = [];

			resolve();
		});
	})


}





function setChatData()
{

}






function renderChat()
{

	//Render chat list first
	let chatHtml = "";
	let listContainer = $(".chat-list-section").find("ul");
	if(chatData.length > 0 && Object.keys(users).length > 0){
		chatData.forEach((item, index) => {
			let refId = item.first_user_id != userId ? item.first_user_id : item.second_user_id;
			let messages = JSON.parse(item.messages);

			let lastMessage = messages[messages.length - 1].message;
			let unread = 0;

			//Calculate the number of unread messages

			messages.forEach((messageItem, messageIndex) => {

				if(messageItem.receiver == userId && messageItem.read == false) unread++;
			})

			//Design html chat item
			chatHtml += `<li class="active chat-list-item" data-id = "${item.id}">
		                  <a href="#contact-1" data-toggle="tab">
		                    <div class="contact">
		                      <img src= ${users[refId].image !== null ? users[refId].image : '/images/default_profile_image.png'} alt="" class="profile-photo-sm pull-left">
		                      <div class="msg-preview">
		                        <h6>${window.ucwords(users[refId].firstname + " "+ users[refId].lastname)}</h6>
		                        <p class="text-muted message">${lastMessage}</p>
		                        <small class="text-muted">${window.diffForHumans(item.updated_at)}</small>
		                        ${unread == 0 ? '<div class="seen"><i class="icon ion-checkmark-round"></i></div>': '<div class="chat-alert">'+unread+'</div>'} 
		                      </div>
		                    </div>
		                  </a>
	                	</li>`

		})
	}else{
		chatHtml = "<div style = 'text-align: center'><strong>No Chats.</strong></div>";
	}


	listContainer.html(chatHtml);	
}



function  loadChatContent (endUserId) 
{
	let id = selectedChat;



	let targetId = endUserId;

	if(targetId == undefined){
		//Get userid of end user
		chatData.forEach((item, index) => {
			if(item.id == id){
				if(item.first_user_id == userId) targetId = item.second_user_id
				else targetId = item.first_user_id
			}
		})
	}else{
		chatData.forEach((item, index) => {
			if(item.first_user_id == userId && item.second_user_id == targetId) selectedChat = item.id;
			else if(item.second_user_id == userId && item.first_user_id == targetId) selectedChat = item.id;
		})
	}


	//Set Name
	$(".chat-content-section").find(".end-user-name").text(window.ucwords(users[targetId].firstname + " " + users[targetId].lastname));

	//Set Image
	let src = users[targetId].image !== null ? users[targetId].image : '/images/default_profile_image.png';
	$(".chat-content-section").find(".end-user-image").attr("src", src);

	//Return for new chats
	if(selectedChat == undefined) return;

	//Set Chat content
	let chatHtml = "";
	chatData.forEach((chatItem, chatIndex) => {
		if(chatItem.id == id){
			JSON.parse(chatItem.messages).forEach((item, index) => {
				let refId = "";
				if(item.sender == userId) refId = item.receiver;
				else refId = item.sender

				chatHtml += `
					<li class="${item.sender == userId? 'right': 'left'}" id = "message_${index}">
			            <img src="${item.sender != userId? users[refId].image !== null ? users[refId].image : '/images/default_profile_image.png':   users[userId].image !== null ? users[userId].image : '/images/default_profile_image.png'}" alt="" class="profile-photo-sm ${item.sender == userId? 'pull-right': 'pull-left'}">
			            <div class="chat-item">
			              <div class="chat-item-header">
			                <h5>${item.sender != userId ? window.ucwords(users[refId].firstname + " " + users[refId].lastname) : window.ucwords(users[userId].firstname + " " + users[userId].lastname)}</h5>
			                <small class="text-muted">${window.diffForHumans(item.time)}</small>
			              </div>
			              <p class = "message">${item.message}</p>
			            </div>
			          </li>

					`;

			})
		}
	})

	$(".chat-content-section").find(".chat-message").html(chatHtml);


	setTimeout(() => scrollToLastRead(selectedChat));

	setTimeout(() => observeUnread(selectedChat))


}


function sendChat(message){
	return new Promise((resolve, reject) => {

		let receipient;

		chatData.forEach((item, index) => {
			if(item.id == selectedChat){
				receipient = item.first_user_id == userId ? item.second_user_id : item.first_user_id;
			}
		});


		if(receipient == undefined) receipient =  usersIdList[usersIdList.length - 1] ;

		if(receipient == userId) return 

		let form = new FormData();
		form.append("message", message);


		let url = `/users/chats/${selectedChat == undefined ? 'new': selectedChat}/${receipient}/store`;

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
				await start();
				let id;
				if(selectedChat == undefined) selectedChat = chatData[0].id
				loadChatContent(undefined);
				setTimeout(() => emojilize());
				setTimeout( () => scrollToLast());

				resolve();
			}
		});
	})
}



function refresh()
{
	return new Promise(async (resolve, reject) => {
		await start();
		let id = selectedChat == undefined ? usersIdList[usersIdList.length - 1] : undefined;
		loadChatContent(id);
		setTimeout(() => emojilize());
		resolve();
	})
}


function deleteSelectedChat()
{
	//Set chat id
	selectedChat = undefined;
}



function scrollToLastRead(id){
	let scrolled = false
	chatData.forEach((item, index) => {
		if(item.id == id){
			let messages = JSON.parse(item.messages);

			messages.forEach((message, messageId) => {
				if(message.receiver == userId && message.read == false && scrolled == false){
					//Get element
					let elem = $("#message_"+ messageId);


					let parent = $(".chat-content-section").find(".scroll-wrapper");

					let parentVerticalOffset = parent.offset().top;
					let elementVerticalOffset = elem.offset().top;
					let elementHeight = elem.height();
					let diff = elementVerticalOffset - parentVerticalOffset
					parent[0].scrollTo(0, diff);
					scrolled = true;
				}
			})


			if(scrolled == false){
				scrollToLast();
			}
		}
	})
}


function scrollToLast(){
	let parent = $(".chat-content-section").find(".scroll-wrapper");
	parent[0].scrollTo(0, parent[0].scrollHeight)

}



function observeUnread (id)
{

	//Scroll and update the read
	const messageObserver = new IntersectionObserver((entries, observer) => {
		entries.forEach(entry => {
			if(entry.isIntersecting){
				updateRead(id, entry.target);
			}
		})
	});


	chatData.forEach((item, index) => {
		if(item.id == id){
			let messages = JSON.parse(item.messages);

			messages.forEach((message, messageId) => {
				if(message.receiver == userId && message.read == false){
					messageObserver.observe($("#message_"+ messageId).get(0));
				}
			})
		}
	})

}


function updateRead(id, target)
{
	let chatId = id;
	let msgId = target.id.replace("message_", "");


	let url = `/users/chats/${chatId}/message/${msgId}/update`
	let config = {
		method: "POST",
		headers: {
			'X-CSRF-TOKEN': token
		}
	}

	fetch(url, config)
	.then((response) => response.json())
	.then(async (res) => {
		if(res.success === true){
			await start();
		}
	});
}


function filterChats(filter){
	let chats = $(".chat-list-item").toArray();

	chats.forEach((item, index) => {
		$(item).hide();
		if($(item).find(".msg-preview").find("h6").text().toLowerCase().includes(filter.toLowerCase())) $(item).show();
	})
}



function emojilize()
{
	$(".message").each((index, item)=> {
		var converted = emojione.toImage($(item).html())
    	$(item).html(converted);
	})
		
}



