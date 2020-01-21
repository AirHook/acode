<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Sales Package HTML Email</title>

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
		body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #e05443; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
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
	<?php if ($email_message)
	{
		echo $email_message;
		echo '<br>';
		if ($w_images === 'Y' OR $linesheets_only == 'Y') { ?>
		See attached linesheets...	<br />
		<?php }
	}
	else
	{ ?>

		There are several brand new designs for your review.<br>
		Please respond with items of interest for your stores.<br>
		<br>
		<?php if ($w_images === 'Y' OR $linesheets_only == 'Y') { ?>
		See attached linesheets...	<br />
		<?php } ?>

		<?php
	}
	?>

	<br><br>

	<?php
	/***********
	 * setup hash tag email for session and auto login
	 https://www.instylenewyork.com/wholesale/signin.html
	 */
	?>
	<a href="<?php echo $access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html'; ?>"><strong>CLICK HERE</strong></a> for more details of the package...

	<br><br>

	<?php
	/***********
	 * The IMAGES PARENT container
	 */
	?>
	<table cellspacing="0" cellpadding="0" border="0" style="width:758px;">
		<tbody>
			<tr height="10">
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>

					<?php
					/***********
					 * The IMAGES CHILD container
					 */
					?>
					<table cellspacing="0" cellpadding="0" border="0" style="margin-top:10px;width:758px;">
						<tbody>
							<tr>
								<?php
								// load library
								//$this->load->library('product_details');

								$icol = 1; // count the number of columns (5 for 5 thumbs per row)
								$irow = 1; // counter for number of rows upto 2 rows for 5 items each row
								$ii = 0; // items count
								foreach($items as $item)
								{
									// get product details
									$product = $this->product_details->initialize(array('tbl_product.prod_no'=>$item));

									if ( ! $product)
									{
										$exp = explode('_', $item);
										$product = $this->product_details->initialize(
											array(
												'tbl_product.prod_no' => $exp[0],
												'color_code' => $exp[1]
											)
										);

									}

									$options_array =
										$this->session->sa_options
										? json_decode($this->session->sa_options, TRUE)
										: array()
									;
									$price = @$options_array['e_prices'][$item] ?: $product->wholesale_price;

									// set image paths
									// old folder structure system (for depracation)
									$pre_url =
										$this->config->item('PROD_IMG_URL')
										.'product_assets/WMANSAPREL/'
										.$product->d_url_structure.'/'
										.$product->sc_url_structure
									;
									$img_front_pre = $pre_url.'/product_front/thumbs/';
									$img_back_pre = $pre_url.'/product_back/thumbs/';
									$img_side_pre = $pre_url.'/product_side/thumbs/';
									$color_icon_pre = $pre_url.'/product_coloricon//';
									// the image filename
									// the old ways dependent on category and folder structure
									$image = $product->prod_no.'_'.$product->color_code.'_3.jpg';
									// the color icon
									$color_icon = $product->prod_no.'_'.$product->color_code.'.jpg';

									// the new way relating records with media library
									$new_pre_url =
										$this->config->item('PROD_IMG_URL')
										.$product->media_path
										.$product->prod_no.'_'.$product->color_code
									;
									$img_front_new = $new_pre_url.'_f3.jpg';
									$img_back_new = $new_pre_url.'_b3.jpg';
									$img_side_new = $new_pre_url.'_s3.jpg';
									$img_coloricon = $new_pre_url.'_c.jpg';

									if ($icol == 6)
									{
										$icol = 1;
										echo '</tr><tr>';
									}
									?>

								<td style="vertical-align:top;width:154px">
									<a href="<?php echo $access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html'; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:140px;height:210px;">
											<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" width="140" style="width:140px;">
										</div>
									</a>
									<div style="margin:3px 0 0;">
										<img src="<?php echo ($product->primary_img ? $img_coloricon : $color_icon_pre.$color_icon); ?>" width="10" height="10">
									</div>

									<div style="width:140px;">
										<span style="font-size:10px;"><?php echo $product->prod_no; ?></span>
										<?php if ($w_prices == 'Y') { ?>
										<br />
										<span style="font-size:10px;">
											$ <?php echo number_format($price, 2); ?>
										</span>
										<?php } ?>
									</div>
								</td>

									<?php
									$icol++;
									$ii++;

									// finish iteration at 15 items max
									if ($ii == 15)
									{
										$load_more = TRUE;
										break;
									}
									else $load_more = FALSE;
								}

								// let us finish the columns to 5 if less than 5 on the last item
								for($icol; $icol <= 5; $icol++)
								{
									echo '<td style="vertical-align:top;width:154px"></td>';
								}
								?>
							</tr>
							<?php
							// show load more for items more than 15
							if ($load_more)
							{
								echo '<tr><td colspan="5" style="padding-top:20px;padding-right:14px;"><a href="'.($access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html').'"><button type="button" style="width:100%;height:50px;padding:20px auto;text-align:center;cursor:pointer;">LOAD MORE</button></a></td></tr>';
							}
							?>
						</tbody>
					</table>

					<br style="clear:both;">
				</td>
			</tr>
			<tr height="20">
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>

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
		To opt out from product updates, please click <a href="<?php echo base_url(); ?>wholesale/optout/index/<?php echo md5($email); ?>" target="_blank">here</a>.
	]</span>
	<br>
	<span style="color:gray;font-size:0.6em;">[
		You are receiving this email of recent designs from us because your registeration has just been activated.
	]</span>
	<br>

</body>
</html>
