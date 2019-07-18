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
 *
 * bgcolor="#f6f8f1" -> removed
 */
?>
<body yahoo style="margin: 0;padding: 0; min-width: 100% !important; font-family: verdana; font-size: 12px;">
	
	<br />
	<br />

	<p> Daily Product Clicks Report [for date - <?php echo $date; ?>]: </p>
	
	<?php if ($product_clicks) { ?>

	<?php
	/***********
	 * Create the table headers
	 */
	?>
	<br /><br />
	<table style="font-size:12px;">
		<tr style="vertical-align:top;font-weight:bold;">
			<td style="padding-right:20px;"></td>
			<td style="padding-right:20px;">PROD<br />NO.</td>
			<td style="padding-right:20px;"><br />DESIGNER</td>
			<td style="padding-right:20px;">CONSUMER<br />CLICKS</td>
			<td style="padding-right:20px;">WHOLESALE<br />CLICKS</td>
			<td style="padding-right:20px;"><br />TOTAL</td>
		</tr>
		<tr><td colspan="5">&nbsp;</td></tr>
		
		<?php
		/***********
		 * Loop throug each item for the body
		 */
		?>
		<?php foreach ($product_clicks as $prod_no => $clicks) { ?>
		
			<?php
			/***********
			 * We need to get the src attribut for the thumbnail
			 */
			// initialize product details
			$this->product_details->initialize(array('tbl_product.prod_no'=>$prod_no));
			
			// get the image url segments
			$img_thumb = 
				$this->config->slash_item('PROD_IMG_URL')
				.'product_assets/WMANSAPREL'
				.'/'.$this->product_details->d_url_structure
				.'/'.$this->product_details->sc_url_structure
				.'/product_front/thumbs/'
				.$this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_2.jpg'
			;
			// new way of referencing thumbs via medai library
			$img_thumb = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_f2.jpg';
			
			// de-initialize class
			$this->product_details->deinitialize();
			?>
		<tr>
			<td style="padding-right:10px;vertical-align:top;" rowspan="3"><img src="<?php echo $img_thumb; ?>" /></td>
			<td style="padding-right:20px;"><?php echo $prod_no; ?></td>
			<td style="padding-right:20px;"><?php echo $clicks[2]; ?></td>
			<td style="padding-right:20px;"><?php echo $clicks[0]; ?></td>
			<td style="padding-right:20px;"><?php echo $clicks[1]; ?></td>
			<td style="padding-right:20px;"><?php echo $clicks[0] + $clicks[1]; ?></td>
		</tr>
		
			<?php if (isset($clicks[3])) { ?>
			
		<tr style="font-style:italic;font-size:0.8em;color:blue;vertical-align:bottom;">
			<td style="padding-right:10px;text-align:right;">Page:</td>
			<td style="padding-right:20px;" colspan="4">
				<?php echo @$clicks[3] ?: '...'; ?>
			</tr>
		</tr>
		<tr style="font-style:italic;font-size:0.8em;color:blue;vertical-align:top;">
			<td style="padding-right:10px;text-align:right;">Referer:</td>
			<td style="padding-right:20px;" colspan="4">
				<?php echo @$clicks[4] ?: '...'; ?>
			</tr>
		</tr>
		
			<?php } ?>
		
		<?php } ?>
	
		<?php
		/***********
		 * Footer items
		 */
		?>
		<tr><td colspan="5">&nbsp;</td></tr>
		<tr>
			<td style="padding-right:20px;"></td>
			<td style="padding-right:20px;"></td>
			<td style="padding-right:20px;">TOTALS = </td>
			<td style="padding-right:20px;"><?php echo $total_cs_clicks; ?></td>
			<td style="padding-right:20px;"><?php echo $total_ws_clicks; ?></td>
			<td style="padding-right:20px;"><?php echo $overall_total; ?></td>
		</tr>
	</table>
	
	<?php } else { ?>
	
	No product clicks.
	
	<?php } ?>
	
	<br /><br />
	<br /><br />
	
	End...
	
	<br /><br />
	<br /><br />
	<br /><br />
	
</body>
</html>
