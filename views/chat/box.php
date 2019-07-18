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
.unread-messages .fa {
	position: absolute;
	top: -1px;
	right: 0px;
	color: red;
	z-index: 10002
}
.unread-messages .count {
	position: relative;
	top: 3px;
	right: 7px;
	color: white;
	z-index: 20000
}
</style>

<div id="chat-box-icon" class="chat-wrapper" style="padding:0px;position:fixed;bottom:15px;right:15px;z-index:10001;cursor:pointer;<?php echo $this->session->chat_box_maximized ? 'display:none;': ''; ?>">

	<img src="<?php echo base_url(); ?>assets/images/icons/chat-icon-goldish.png" style="width:75px;" />
	<p class="unread-messages" style="position:absolute;top:0;right:0;padding:0;margin:0;display:none;">
		<i class="fa fa-circle fa-2x"></i>
		<span class="count"> 1 </span> 
	</p>

</div>

<div id="chat-box-wrap" class="chat-wrapper" style="padding:0px;position:fixed;bottom:15px;right:15px;border:1px solid #cccccc;z-index:10000;background:white;<?php echo $this->session->chat_box_maximized ? '': 'display:none;'; ?>" data-base_url="<?php echo base_url(); ?>">

	<div id="chat-box-title" style="padding:2px 5px;margin:0px;background:#846921;color:white;">

		<div id="close" style="right;float:right;cursor:pointer;">
			<i class="fa fa-minus-square"></i>
		</div>
		
		<p id="title-text" style="padding:0px;margin:0px;">
			<!--Connecting...-->&nbsp;
		</p>
			
	</div>
	
    <div id="chat-wrap" style="padding:0px;font-size:0.85rem;border-bottom:1px solid #dedede;height:200px;width:230px;overflow:auto;color:#555;vertical-align:bottom;">
	
		<p class="admin" id="notice-looking_for_rep" style="font-style:italic;padding-left:5px;font-size:0.85em;">
			Looking for available representative for you... you can type and send anything ahead so the representative can read it as soon as available.
		</p>

	</div>
	
    <form id="send-message-area" style="margin:0;padding:5px;">
		<input type="hidden" id="chat_id" name="chat_id" value="<?php echo isset($logindata['chat_id']) ? $logindata['chat_id'] : '0'; ?>" />
		<input type="hidden" id="ws_user_id" name="ws_user_id" value="<?php echo ($this->session->user_loggedin && $this->session->user_cat == 'wholesale') ? $this->wholesale_user_details->user_id : '0'; ?>" />
		<input type="hidden" id="admin_sales_id" name="admin_sales_id" value="<?php echo ($this->session->user_loggedin && $this->session->user_cat == 'wholesale') ? $this->wholesale_user_details->admin_sales_id : '0'; ?>" />
        <textarea id="sendie" rows="1" placeholder="your message..." maxlength="500" style="border:1px solid #dedede;padding:5px;width:200px;font-size:0.8rem;width:100%;"></textarea>
    </form>

	<audio id="message_alert">
		<source src="<?php echo base_url(); ?>chat_archive/google_notification.mp3" type="audio/mpeg" />
		<embed hidden="true" src="<?php echo base_url(); ?>chat_archive/google_notification.mp3" />
	</audio>
	
</div>

<?php $this->load->view('chat/box_script'); ?>
