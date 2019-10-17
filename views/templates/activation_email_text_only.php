<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Activation HTML Email</title>
	
	<?php
	/***********
	 * For editing purposes, css are placed here initially
	 * Transfer all styles inline because some clients, such as Gmail, 
	 * will ignore or strip out your <style> tag contents, or ignore them.
	 */
	?>
	<style type="text/css">
	<?php
	/***********
	 * On mobile, it's ideal if the whole button is a link, not just the text, 
	 * because it's much harder to target a tiny text link with your finger.
	 */
	?>
	@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
		body[yahoo] .buttonwrapper {background-color: transparent!important;}
		body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important; display: block!important;}
		
		/* Unsubscribe footer button only on mobile devices */
		body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
		body[yahoo] .hide {display: none!important;}
	}

	<?php
	/***********
	 * A Fix for Apple Mail
	 * Weirdly, Apple Mail (normally a very progressive email client) 
	 * doesn't support the max-width property either.
	 * It does support media queries though, so we can add one that tells 
	 * it to set a width on our 'content' class table, as long as the viewport 
	 * can display the whole 600px.
	 */
	?>
	@media only screen and (min-device-width: 801px) {
		.content {width: 800px !important;}
		.col380 {width: 400px !important;}
	}
	</style>
	
</head>
	
<?php
/***********
 * Hiding Mobile Styles From Yahoo!
 *
 * You will notice that the body tag has an extra attribute. 
 * Yahoo Mail loves to interpret your media queries as gospel, 
 * so to prevent this, you need to use attribute selectors. 
 * The easiest way to do this (as suggested by Email on Acid) 
 * is to simply add an arbitrary attribute to the body tag.
 *
 * You can then target specific classes by using the attribute selector for your body tag in the CSS.
 * body[yahoo] .class {}
 */
?>
<body yahoo bgcolor="#f6f8f1" style="margin: 0;padding: 0; min-width: 100% !important;">
	
	<br>

	Hello <?php echo $username; ?>,
	
	<br><br>
	
	<?php
	/***********
	 * setup $email_message here
	 */
	?>
	<?php if ($this->config->item('site_slug') == 'tempoparis') { ?>
		Welcome to the wholesale order system for <?php echo $this->config->item('site_name'); ?><br />
	<?php } else { ?>
		<?php if ($this->config->item('site_slug') !== 'instylenewyork') { ?>
		<?php echo ucfirst($this->webspace_details->site); ?> is the new online order system for <?php echo $designer?>. <br />
		<?php } ?>
	<?php } ?>
	
	<br><br>
	
	To access the wholesale resource, click below:
	
	<br><br>
	
	<a href="https://www.<?php echo $this->webspace_details->site; ?>/wholesale/signin.html">
		https://www.<?php echo $this->webspace_details->site; ?>/wholesale/signin.html
	</a>
	
	<br><br>
	
	Username: <?php echo $email; ?>
	<br>
	Password: <?php echo $password; ?>
	
	<br><br>
	
	For Login Assistance or Tech Support, call us at <?php echo $designer_phone; ?>
	
	<br><br>
	<br><br>
	<br><br>
	
	<?php echo $sales_rep; ?>
	
	<br><br>
	
	<?php echo $designer; ?> <br>
	<?php echo $designer_address1; ?> <br>
	<?php echo $designer_address2; ?> <br>
	<?php echo $designer_phone; ?> <br>
	
	<br><br>
	
	<?php if ($reference_designer != 'tempoparis') { ?>
	TERMS OF SALE
	<br><br>
	<span style="font-size:0.80em;">
		First order minimum 7 pieces of any style/color combination
		<br>
		After first order we send 1 by 1 as ordered
		<br>
		All production orders require 30% deposit to begin Balance prior to shipping
		<br>
		All production orders take 14 weeks to produce from date of deposit
	</span>
	<?php } ?>
	
	<br>
	
</body>
</html>
