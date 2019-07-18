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
        
		<img src="<?php echo $img_inquiry; ?>" alt="" style="float:left;margin-top:50px;margin-right:5px;padding:10px 25px 0;" />
	
		<div>
		
            <!--bof form=========================================================================-->
			<?php echo form_open('about_product/inquiry'); ?>
			
				<input type="hidden" name="the_time" value="<?php echo time(); ?>" />
				<input type="hidden" name="return_url" value="<?php echo @$return_url ?: $this->uri->uri_string(); ?>" />
				<input type="hidden" name="prod_no" value="<?php echo @$prod_no; ?>" />
				<input type="hidden" name="color_code" value="<?php echo @$color_code; ?>" />
				<input type="hidden" name="no_stocks_at_all" value="<?php echo @$no_stocks_at_all; ?>" />
				
				<table>
					<col width="120" />
					<col width="180"/>
					<col />
					<col width="47"/>
				<tr height="25">
					<tr height="25">
						<td style="vertical-align:middle;">NAME <span style="color:red;">*</span></td>
						<td style="vertical-align:middle;">
							<input type="text" name="name" id="name" style="width:180px;background:#dddddd;border:1px solid #a0a0a0;" />
						</td>
						<td style="vertical-align:middle;padding-left:20px;">DRESS SIZE <span style="color:red;">*</span></td>
						<td align="right" style="vertical-align:middle;">
							<input type="text" name="dress_size" id="dress_size" style="width:47px;background:#dddddd;border:1px solid #a0a0a0; padding:0px;" />
						</td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;">EMAIL ADDRESS <span style="color:red;">*</span></td>
						<td colspan="3" style="vertical-align:middle;">
							<input type="email" name="email" id="email" class="diff" style="width:330px;background:#dddddd;border:1px solid #a0a0a0;" />
						</td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;"><span style="color:red;">Send me special offers on future on-sale items *</span></td>
						<td colspan="3" style="vertical-align:middle;">
							<input type="radio" name="opt_type" id="opt_type" value="1" class="diff" /> <span style="color:red;position:relative;bottom:2px;left:5px;">Yes</span> &nbsp; &nbsp; 
							<input type="radio" name="opt_type" id="opt_type" value="0" class="diff" /> <span style="color:red;position:relative;bottom:2px;left:5px;">No</span>
						</td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;"><span style="color:red;">I AM A STORE *</span></td>
						<td colspan="3" style="vertical-align:middle;">
							<input type="radio" name="u_type" id="u_type_store" value="Store" class="diff" /> 
							<span style="color:red;position:relative;bottom:2px;left:5px;">You will be taken to fill out wholesale form for verification</span>
						</td>
					</tr>
					<tr height="25">
						<td style="vertical-align:middle;"><span style="color:red;">I AM A CONSUMER *</span></td>
						<td colspan="3" style="vertical-align:middle;">
							<input type="radio" name="u_type" id="u_type_consumer" value="Consumer" class="diff" /> 
							<span style="color:red;position:relative;bottom:2px;left:5px;">You will be taken to shop7thavenue.com our shop site</span>
						</td>
					</tr>
					<tr>
						<td style="vertical-align:middle;">MESSAGE OR<br> COMMENTS</td>
						<td colspan="3" style="vertical-align:middle;">
							<textarea name="message" id="message" col="50" rows="5" style="width:330px;background:#dddddd;border:1px solid #a0a0a0;padding:0px;"></textarea>
							</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="3">
						
							<input type="hidden" name="image" value="<?php echo $image; ?>" />
							<br />
							<button type="submit" class="btn dark btn-block" name="send" value="Send">SEND</button>
							
						</td>
					</tr>
				</table>

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
