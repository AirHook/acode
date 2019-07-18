<script language="Javascript">
	function check()
	{
		var name=document.forms["myform"]["name"].value;
		var email=document.forms["myform"]["email"].value;
		var dress=document.forms["myform"]["dress_size"].value;
		var type=document.forms["myform"]["u_type"].value;
		
		var atpos=email.indexOf("@");
		var dotpos=email.lastIndexOf(".");
		
		if (name==null || name=="" || email==null || email=="" || dress==null || dress=="")
  		{
			alert("Required Fields Must Be Filled Out");
			return false;
  		}
		else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
  		{
			alert("Not a valid e-mail address");
			return false;
  		}
		else if ( ( document.myform.u_type[0].checked == false )&& ( document.myform.u_type[1].checked == false ) )
    	{
        	alert ( "Please choose If Your a Store or a Consumer" );
        	return false;
    	}
	}
	// This function reload page after 3mins (anti spam feature working with server side script too)
	// variable t declared globally at beginning
	function set_timer()
	{
		t = setTimeout("alert_msg()",180000);
	}
	function alert_msg()
	{
		alert('Your time has ran out.' + "\n" + 'Reloading page');
		window.location.reload();
	}
</script>

<!--[if IE 7]>
<style type="text/css">
.ie7-text{padding-top:10px;}
.ie7-padd{height:40px;}
</style>
<![endif]-->

<div style="width:700px;font-size:11px;margin:0 auto;font-family:arial;">

	<div style="background:black;width:680px;padding:10px 10px 10px 10px;" class="ie7-padd">
		<div style="float:left;padding-top:5px;width:250px;">
			<?php echo img(array('src'=>base_url().'assets/roden_assets/images/logo-'.$this->webspace_details->slug.'.png')); ?>
		</div>
		<div style="color:white;float:right;" class="ie7-text">
			<h3 style="font-size:13px;">COMPLETE FORM TO SEE PRICE AND AVAILABILITY</h3>
		</div>
		<div style="clear:both;"></div>
	</div>

	<div style="border: 1px solid #D0D0D0;width:678px;padding:10px;">
        
		<img src="<?php echo $img_inquiry; ?>" alt="" style="float:left;margin-right:5px;padding:10px 25px 0;" />
	
		<div>
			<?php
			/*
			| --------------------------------------------------------------------------------
			| Some snipets to help prevent spam bots from spamming the form
			| $the_spinner makes the fields of the form hashed and sorta randomized every second of the day
			| Used a honeypot to identify bot spammers
			*/
			$the_spinner = time().'#'.$this->session->userdata('ip_address').'#'.$this->config->item('site_domain').'#'.$this->config->item('a_secret_1');
			?>
		
            <!--bof form=========================================================================-->
			<?php echo form_open('about_product/inquiry', array('onsubmit' => 'return check()')); ?>
			
				<input type="hidden" name="<?php echo md5('the_spinner'); ?>" value="<?php echo md5(@$the_spinner); ?>" />
				<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_time'); ?>" value="<?php echo time(); ?>" />
				
				<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_return_url'); ?>" value="<?php echo @$return_url ?: $this->uri->uri_string(); ?>" />
				<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_prod_no'); ?>" value="<?php echo @$prod_no; ?>" />
				<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_color_code'); ?>" value="<?php echo @$color_code; ?>" />
				<input type="hidden" name="no_stocks_at_all" value="<?php echo @$no_stocks_at_all; ?>" />
				
				<table>
					<col width="120" />
					<col width="180"/>
					<col />
					<col width="47"/>
				<tr height="25">
					<tr height="25">
						<td style="vertical-align:middle;">NAME <span style="color:red;">*</span></td>
						<td style="vertical-align:middle;"><input type="text" name="<?php echo md5(md5($the_spinner).'the_name'); ?>" id="<?php echo md5(md5($the_spinner).'the_name'); ?>" style="width:180px;background:#dddddd;border:1px solid #a0a0a0;" /></td>
						<td style="vertical-align:middle;padding-left:20px;">DRESS SIZE <span style="color:red;">*</span></td>
						<td align="right" style="vertical-align:middle;"><input type="text" name="<?php echo md5(md5($the_spinner).'the_dress_size'); ?>" id="<?php echo md5(md5($the_spinner).'the_dress_size'); ?>" style="width:47px;background:#dddddd;border:1px solid #a0a0a0; padding:0px;" /></td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;">EMAIL ADDRESS <span style="color:red;">*</span></td>
						<td colspan="3" style="vertical-align:middle;"><input type="email" name="<?php echo md5(md5($the_spinner).'the_email'); ?>" id="<?php echo md5(md5($the_spinner).'the_email'); ?>" class="diff" style="width:330px;background:#dddddd;border:1px solid #a0a0a0;" /></td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;"><span style="color:red;">Send me special offers on future on-sale items *</span></td>
						<td colspan="3" style="vertical-align:middle;">
							<input type="radio" name="<?php echo md5(md5($the_spinner).'the_opt_type'); ?>" id="<?php echo md5(md5($the_spinner).'the_opt_type'); ?>" value="1" class="diff" /> <span style="color:red;position:relative;bottom:2px;left:5px;">Yes</span> &nbsp; &nbsp; 
							<input type="radio" name="<?php echo md5(md5($the_spinner).'the_opt_type'); ?>" id="<?php echo md5(md5($the_spinner).'the_opt_type'); ?>" value="0" class="diff" /> <span style="color:red;position:relative;bottom:2px;left:5px;">No</span>
						</td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;"><span style="color:red;">I AM A STORE *</span></td>
						<td colspan="3" style="vertical-align:middle;"><input type="radio" name="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" id="<?php echo md5(md5($the_spinner).'the_u_type'); ?>_store" value="Store" class="diff" /> <span style="color:red;position:relative;bottom:2px;left:5px;">You will be taken to fill out wholesale form for verification</span></td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;"><span style="color:red;">I AM A CONSUMER *</span></td>
						<td colspan="3" style="vertical-align:middle;"><input type="radio" name="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" id="<?php echo md5(md5($the_spinner).'the_u_type'); ?>_consumer" value="Consumer" class="diff" /> <span style="color:red;position:relative;bottom:2px;left:5px;">You will be taken to instylenewyork.com our shop site</span></td>
					</tr>
					<tr>
						<td style="vertical-align:middle;">MESSAGE OR<br> COMMENTS</td>
						<td colspan="3" style="vertical-align:middle;"><textarea name="<?php echo md5(md5($the_spinner).'the_message'); ?>" id="<?php echo md5(md5($the_spinner).'the_message'); ?>" col="50" rows="5" style="width:330px;background:#dddddd;border:1px solid #a0a0a0;padding:0px;"></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
							<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_image'); ?>" value="<?php echo $image; ?>" />
							<button type="submit" class="button button--<?php echo $this->webspace_details->slug; ?>" name="<?php echo md5(md5($the_spinner).'the_send'); ?>" value="Send" onclick=""/>Send</button>
							<button type="reset" class="button button--<?php echo $this->webspace_details->slug; ?>" name="<?php echo md5(md5($the_spinner).'the_clear'); ?>" value="Clear" onclick="">Clear</button>
						</td>
					</tr>
				</table>
				<div style="display:none;">
					<input type="email" name="<?php echo md5(md5($the_spinner).'the_honeypot'); ?>" value="" />
				</div>
			<?php echo form_close(); ?>
			<!--eof form=========================================================================-->
			
		</div>
	</div>

	<div style="border:1px solid #D0D0D0;border-top:none;width:678px;padding:0 10px;">
		<p style="float:left;visibility:hidden;">WHOLESALE INQUIRIES WILL RECEIVE REPLY WITHIN 24 HOURS</p>
		<p style="float:right;color:red;visibility:hidden;">RED STARS ARE MANDATORY</p>
		<div style="clear:both;"></div>
	</div>

</div>
