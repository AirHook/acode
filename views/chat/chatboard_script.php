			<script>
				// scroll slimScroll enabled chat-wraps to bottom using chat-content height as reference
				var scrollTo_int = $('.chat-wrap').prop('scrollHeight') + 'px';
				$('.chat-content').slimScroll({
					scrollTo: scrollTo_int
				});
				
				// reference link for this chat engine
				// https://css-tricks.com/jquery-php-chat/
				
				var message_alert = document.getElementById('message_alert');
				var instance = false;
				var state;
				var ws_user_id = 0;
				
				var chat_id = $('#chat_id').val();
				var admin_sales_id;
				
				function Chat_admin () {
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
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
							'admin_sales_id': admin_sales_id
						},
						dataType: "json",
						success: function(data){
							if(data.text){
								var isClient = false;
								for (var i = 0; i < data.text.length; i += 2) {
									$('#chat-wrap').append(
										$('<li class="' + (data.text[i] == 'admin' ? 'out' : 'in') + '"><div class="avatar label label-sm label-' + (data.text[i] == 'admin' ? 'default' : 'primary') + '"><i class="fa fa-user fa-2x" style="margin-top:13px;"></i></div><div class="message"><span class="arrow"> </span><a href="javascript:;" class="name"> ' + (data.text[i] == 'admin' ? 'you' : 'client') + ' </a><span class="datetime hide"> at 20:11 </span><span class="body"> ' + data.text[i+1] + '</span></li>')
									);
									isClient = data.text[i] == 'client' ? true : false;
								}								  
								if (isClient) message_alert.play();
								var scrollTo_int = $('.chat-wrap').prop('scrollHeight') + 'px';
								$('.chat-content').slimScroll({
									scrollTo: scrollTo_int
								});
								instance = false;
							}
							state = data.state;
						},
						error: function(jqXHR, textStatus, errorThrown) {
							alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown + "\n" + "<?php echo base_url(); ?>chat/update/index/" + chat_id + "/" + state);
							//location.reload();
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
							url: "<?php echo base_url(); ?>chat/send/admin/" + chat_id,
							data: {
								'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
								'admin_sales_id': admin_sales_id,
								'message': message
							},
							dataType: "json",
							success: function(data){
								//alert(data);
								if (message != 'close_chat') updateChat();
							}
						});
					}
					// admin new chat
					if(ws_user_id > 0 && chat_id == 0){
						$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>chat/send/admin_new/" + ws_user_id,
							data: {
								'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
								'admin_sales_id': admin_sales_id,
								'message': message
							},
							dataType: "json",
							success: function(data){
								// we need to set state to zero as this is always a start
								state = 0;
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
				var chat2 =  new Chat_admin();
				
				//chat.getState();
				
				// we need to define this change function before 
				// triggering it on the chat functions below
				// watch for change of chat_id value
				$('#chat_id').change(function(){
					if($('#chat_id').val() > 0){var admin_message_check_interval = setInterval('chat2.check()', 1500)};
				});
				
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
						chat2.send(text);
						$(this).val("");
					}
				});
				
				// watch click of submit button
				$('.btn-cont').click(function(){
					var text = $('#sendie').val();
					chat2.send(text);
					$('#sendie').val("");
				});
				
				if(chat_id > 0){var admin_message_check_interval = setInterval('chat2.check()', 1500)};
				
				var user_id;
				var ws_user_id;
				var this_admin_sales_id;
				
				// watch click of online user
				$('.online_user').on('click', function(){
					// grab some data
					ws_user_id = $(this).attr('id');
					this_chat_id = $(this).attr('data-chat_id');
					this_admin_sales_id = $(this).attr('data-admin_sales_id');
					// set params
					state = 0;
					// set close_chat input element param to 0
					$('#close_chat').val('0');
					// clear the chatboard
					$('#chat-wrap').html('');
					// set chat board title to user store_name
					$('.chat_board .caption .caption-subject').html($(this).data('store_name'));
					// show the close chat button
					$('#admin_close_chat').show();
					// colorize current user to chat with
					$('.feeds > li').css('background', '#fafafa');
					$(this).closest('li').css('background','#e5e5e5');
					// if chat_id is present, this means eithre of the following:
					// 1.0 user types on his chat box looking for a representative
					// 2.0 currently chatting with admin
					if (this_chat_id > '0'){
						// set user_id and admin_sales_id
						user_id = ws_user_id;
						admin_sales_id = this_admin_sales_id;
						// set chat_id to text input field form
						chat_id = this_chat_id;
						$('#chat_id').val(this_chat_id).change();
						// set the admin_sales_id to input field form
						$('#admin_sales_id').val(this_admin_sales_id);
						// try populating chatboard
						chat2.update();
					} else {
						admin_sales_id = this_admin_sales_id;
						/*
						alert('User is currently idle.' + '\n' + 'Refreshing list...');
						$('#reloading .modal-content .modal-body .modal-body-text').html('');
						$('#reloading').modal('show');
						location.reload();
						*/
					}
				});
				
				// watch to close chat
				$('#admin_close_chat').click(function(){
					// set close chat input element param to 1
					$('#close_chat').val('1');
					// programatically send a close pass code to close chat
					// and set state back to zero
					chat2.send('close_chat');
					// reset online user data-chat_id on online user list
					$('#'+user_id).attr('data-chat_id','0');
					// reset var
					ws_user_id = 0;
					// hide the close chat button
					$('#admin_close_chat').hide();
					// colorize current user to chat with
					$('.feeds > li').css('background', '#fafafa');
					// clear chatboard
					$('#chat-wrap').html('');
					// set chat board title to user original text
					$('.chat_board .caption .caption-subject').html('Click on an online user to start chat...');
					// reset chat_id to zero
					$('#chat_id').val('0').change();
					// reset admin_sales_id to default
					$('#admin_sales_id').val('1');
					// clear interval
					clearInterval(admin_message_check_interval);
				});
			</script>
