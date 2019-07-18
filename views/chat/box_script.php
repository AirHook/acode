<script>
	document.getElementById('chat-wrap').scrollTop = document.getElementById('chat-wrap').scrollHeight;
	
	// reference link for this chat engine
	// https://css-tricks.com/jquery-php-chat/
	
	var message_alert = document.getElementById('message_alert');
	var instance = false;
	var state;
	var unread = 0;
	var box_maximized = true;
	
	var chat_id = $('#chat_id').val();
	var ws_user_id = $('#ws_user_id').val();
	var admin_sales_id = $('#admin_sales_id').val();
	var token = '<?php echo $this->security->get_csrf_hash(); ?>';
	
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
					'<?php echo $this->security->get_csrf_token_name(); ?>': token
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
				'<?php echo $this->security->get_csrf_token_name(); ?>': token,
				'admin_sales_id': admin_sales_id
			},
			dataType: "json",
			success: function(data){
				if(data.text){
					var isAdmin = false;
					for (var i = 0; i < data.text.length; i += 2) {
						if (data.text[i+1] == 'close_chat') {
							$('#chat-wrap').append(
								$('<p class="' + data.text[i] + '">' 
									+ 'Thank you! Have a nice day!' 
									+ '<cite>- ' 
									+ (data.text[i] == 'admin' ? 'admin' : 'you') 
									+ '</cite></p>'
								)
							);
							chat_id = 0;
							$('#chat_id').val('0');
							$.get('<?php echo base_url(); ?>chat/set_session/unset_chat');
						} else {
							$('#chat-wrap').append(
								$('<p class="' + data.text[i] + '">' 
									+ data.text[i+1] 
									+ '<cite>- ' 
									+ (data.text[i] == 'admin' ? 'admin' : 'you') 
									+ '</cite></p>'
								)
							);
						}
						isAdmin = data.text[i] == 'admin' ? true : false;
					}								  
					if (isAdmin) {
						message_alert.play();
						$('#notice-looking_for_rep').hide();
					}
					document.getElementById('chat-wrap').scrollTop = document.getElementById('chat-wrap').scrollHeight;
					instance = false;
				}
				if (data.unread && box_maximized != '<?php echo $this->session->chat_box_maximized; ?>') {
					//$('.count').html(data.unread);
					$('.unread-messages').show();
				}
				unread = data.unread;
				state = data.state;
			}/*,
			error: function(jqXHR, textStatus, errorThrown) {
				alert(
					"Error, status = " + textStatus + ", " + "error thrown: " + errorThrown + "\n" 
					+ "<?php echo base_url(); ?>chat/update/index/" + chat_id + "/" + state
				);
				//location.reload();
			}
			*/
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
					'<?php echo $this->security->get_csrf_token_name(); ?>': token,
					'admin_sales_id': admin_sales_id,
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
					'<?php echo $this->security->get_csrf_token_name(); ?>': token,
					'admin_sales_id': admin_sales_id,
					'message': message
				},
				dataType: "json",
				success: function(data){
					// we need to set state to zero as this is always a start
					state = 0;
					// set new token
					//token = data.token;
					// update chat it
					if(data.chat_id){
						chat_id = data.chat_id;
						$('#chat_id').val(data.chat_id).change();
					}
					// update chat box
					updateChat();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Error, status = " + textStatus + ",\n" 
					+ "error thrown: " + errorThrown + ",\n" 
					+ "at ws_new"
					);
				}
			});
		}
	}

	// kick off chat
	var chat =  new Chat();
	
	// we need to define this change function before 
	// triggering it on the chat functions below
	// watch for change of chat_id valie
	$('#chat_id').change(function(){
		if($('#chat_id').val() > 0){var message_check_interval = setInterval('chat.check()', 1500)};
	});
	
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
	
	if(chat_id > 0){
		var message_check_interval = setInterval('chat.check()', 1500)
	};
	
	// watch chat box icon click
	$('#chat-box-icon').on('click', function(){
		// show the chat box
		$('#chat-box-wrap').show(); 
		// hide the chat icon
		$(this).hide(); 
		// since chat box is now shown,
		// this mean the new message has been read
		// reset var unread
		unread = 0;
		// hide the unread message badge
		$('.unread-messages').hide();
		// set session for page changes to show either the box or the icon
		$.get('<?php echo base_url(); ?>chat/set_session/index/1'); 
	});
	
	// watch chat box wrap minimize button click
	$('#chat-box-wrap #close').on('click', function(){
		// hide the chat box
		$('#chat-box-wrap').hide();
		// show the chat icon
		$('#chat-box-icon').show();
		$.get('<?php echo base_url(); ?>chat/set_session/');
	});

</script>

