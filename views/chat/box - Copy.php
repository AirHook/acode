<style>
#chat-wrap .admin {
	padding: 5px 20px 5px 5px;
	margin: 0px;
	line-height: normal;
}
#chat-wrap .client {
	padding: 5px 5px 5px 30px;
	margin: 0px;
	line-height: normal;
	text-align: right;
	background: #ededed;
}
#chat-wrap cite {
	display: block;
	font-size: 0.65rem;
	opacity: 0.7;
}
</style>

<div id="chat-box-wrap" style="padding:0px;position:fixed;bottom:15px;right:15px;border:1px solid #cccccc;z-index:10000;background:white;" data-base_url="<?php echo base_url(); ?>">

	<div id="chat-box-title" style="padding:2px 5px;margin:0px;background:#846921;color:white;">

		<div id="close" style="float:right;">
			- X
		</div>
		
		<p id="name-area" style="padding:0px;margin:0px;">
			Connecting...
		</p>
			
	</div>
	
    <div id="chat-wrap" style="padding:0px;font-size:0.85rem;border-bottom:1px solid #dedede;height:200px;width:230px;overflow:auto;color:#555;">
		
	</div>
	
    <form id="send-message-area" style="margin:0;padding:5px;">
		<input type="hidden" id="chat_id" name="chat_id" value="1523264701" />
		<input type="hidden" id="ws_user_id" name="ws_user_id" value="<?php echo ($this->session->user_loggedin && $this->session->user_cat == 'wholesale') ? $this->session->user_id : '0'; ?>" />
        <textarea id="sendie" rows="1" placeholder="your message..." maxlength="500" style="border:1px solid #dedede;padding:5px;width:200px;font-size:0.8rem;width:100%;"></textarea>
    </form>

	<audio id="message_alert">
		<source src="<?php echo base_url(); ?>chat_archive/google_notification.mp3" type="audio/mpeg" />
		<embed hidden="true" src="<?php echo base_url(); ?>chat_archive/google_notification.mp3" />
	</audio>
	
</div>

<script>
	document.getElementById('chat-wrap').scrollTop = document.getElementById('chat-wrap').scrollHeight;
	
	// reference link for this chat engine
	// https://css-tricks.com/jquery-php-chat/
	
	var message_alert = document.getElementById('message_alert');
	var instance = false;
	var state;
	
	var chat_id = $('#chat_id').val();
	var ws_user_id = $('#ws_user_id').val();
	
	function Chat () {
		this.check = contUpdateCheck;
		this.update = updateChat;
		this.send = sendChat;
		this.getState = getStateOfChat;
	}

	//gets the state of the chat
	function getStateOfChat(){
		if(chat_id > 0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>chat/get_state/index/" + chat_id,
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: "json",
				success: function(data){
					state = data.state;
				}/*,
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
				}
				*/
			});
		}
	}
	
	//continuous update check
	function contUpdateCheck(){
		if(!instance){
			instanse = true;
			updateChat();
		}
	}

	//Updates the chat
	function updateChat(){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>chat/update/index/" + chat_id + "/" + state,
			data: {
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: "json",
			success: function(data){
				if(data.text){
					var isAdmin = false;
					for (var i = 0; i < data.text.length; i += 2) {
						$('#chat-wrap').append(
							$('<p class="' + data.text[i] + '">' 
								+ data.text[i+1] + '<cite>- ' 
								+ (data.text[i] == 'admin' ? 'admin' : 'you') + '</cite></p>'
							)
						);
						isAdmin = data.text[i] == 'admin' ? true : false;
					}								  
					if (isAdmin) message_alert.play();
					document.getElementById('chat-wrap').scrollTop = document.getElementById('chat-wrap').scrollHeight;
					instance = false;
				}
				state = data.state;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
				location.reload();
			}
		});
	}

	//send the message
	function sendChat(message){
		// cases to send message:
		// 1.0 the regular way when already in conversation
		// 2.0 wholesale user wanting to chat with someone
		// a third way to send message is after:
		// 3.0 consumer intial chat sending of information
		instance = true;
		//updateChat();
		// already in conversation
		if(chat_id > 0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>chat/send/client/" + chat_id,
				data: {
					/*'function': 'send',
					'nickname': nickname,
					'file': file,*/
					'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
					'message': message
				},
				dataType: "json",
				success: function(data){
					//alert(data);
					updateChat();
				}
			});
		}
		// wholesale user new chat
		if(ws_user_id > 0 && chat_id == 0){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>chat/send/ws_new/" + ws_user_id,
				data: {
					/*'function': 'send',
					'nickname': nickname,
					'file': file,*/
					'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
					'message': message
				},
				dataType: "json",
				success: function(data){
					//alert(data);
					updateChat();
				}
			});
		}
	}

	// kick off chat
	var chat =  new Chat();
	
	//chat.getState();
	
	// watch textarea for key presses
	$("#sendie").keydown(function(event) {  
		var key = event.which;  
		//all keys including return.
		if (key >= 33) {
			var maxLength = $(this).attr("maxlength");  
			var length = this.value.length;  
			// don't allow new content if length is maxed out
			if (length >= maxLength) {  
				event.preventDefault();  
				alert('Message is too long.');
			}  
		}
	});
	
	// watch textarea for release of key press
	$('#sendie').keyup(function(e) {
		if (e.keyCode == 13) {
			var text = $(this).val();
			chat.send(text);
			$(this).val("");
		}
	});
	
	//var message_check_interval = setInterval('chat.check()', 3000);

</script>

