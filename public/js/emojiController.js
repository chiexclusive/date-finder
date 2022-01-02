"use strict";

$(document).ready(() => {

	//Add to edit profile
	const bioTextArea = $(".timeline").find(".col-md-6").find(".bio").find("textarea");

	if(bioTextArea.length > 0){
		const bioEmoji = bioTextArea.emojioneArea({pickerPosition: "bottom", shortnames : true, saveEmojisAs: "shortname", events:{
			keyup: function(editor, event){
				bioTextArea.val(bioEmoji[0].emojioneArea.getText())
			},

			emojibtn_click: function(button, event){
				bioTextArea.val(bioEmoji[0].emojioneArea.getText())
			}
		}});

		//Set Emoji Area
		bioEmoji[0].emojioneArea.setText(document.getElementsByClassName("bio_initial")[0].textContent);
	}


	//Add to the message field in dm
	const messageField = $(".chat-content-section").find(".send-message-field");

	if(messageField.length > 0){
		const DMEmoji = messageField.emojioneArea({pickerPosition: "top", shortnames : true, saveEmojisAs: "shortname", events:{
			keyup: function(editor, event){
				messageField.val(DMEmoji[0].emojioneArea.getText())
			},

			emojibtn_click: function(button, event){
				messageField.val(DMEmoji[0].emojioneArea.getText())
			}
		}});

	}


	//Add to the message field in dm
	const commentField = $(".post-comment-field");
	window.commentEmoji = [];

	if(commentField.length > 0){
		commentField.toArray().forEach((item, index) =>{
			let commentEmoji = $(item).emojioneArea({pickerPosition: "top", shortnames : true, saveEmojisAs: "shortname", events:{
				keyup: function(editor, event){
					$(item).val(commentEmoji[0].emojioneArea.getText())
				},

				emojibtn_click: function(button, event){
					$(item).val(commentEmoji[0].emojioneArea.getText())
				}
			}});

			window.commentEmoji.push(commentEmoji);
		})

	}


	//Render emoji on designated places
	const emojiLize = [$(".bio-text"), $(".message")];
	emojiLize.forEach((emojiItem, emojiIndex) => {
		$(emojiItem).each((index, item)=> {
			var converted = emojione.toImage($(item).html());
			$(item).html(converted);
		})
	})
})