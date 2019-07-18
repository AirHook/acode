<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Linesheet HTML Email</title>
	
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
 * body[yahoo] .class {}			#f6f8f1
 */
?>
<body yahoo bgcolor="" style="margin: 0;padding: 0; min-width: 100% !important;">
	
	<br>

	<?php
	/***********
	 * setup $USER here
	 */
	?>
	Dear <?php echo $username ?: 'Guest'; ?>,
	
	<br><br>
	
	<?php
	/***********
	 * setup $email_message here
	 */
	?>
	See attached linesheets...<br>
	Please respond with items of interest for your stores.
	
	<br><br>
	
	<br><br>
	<?php echo $sales_username; ?> <br>
	<?php echo $sales_ref_designer; ?> <br>
	230 West 38th Street <br>
	New York , NY 10018 <br>
	212-840-9811 <br>
	
	<br><br>
	
	<?php
	/***********
	 * Optout option using md5 email for now
	 * as class is using md5 email to process it
	 */
	?>
	<span style="color:red;">[
		To opt out from product updates, please click <a href="<?php echo base_url(); ?>wholesale/optout/<?php echo md5($email); ?>" target="_blank">here</a>.
	]</span>
	<br>
	<span style="color:gray;font-size:0.6em;">[
		You are receiving this product linesheet offer from us because you may have communicated with our sales team regarding our products. Please contact us <a href="<?php echo site_url('contact'); ?>" target="_blank">here</a> if otherwise.
	]</span>
	<br>
	
</body>
</html>
