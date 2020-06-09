	<?php
	/***********
	 * setup $USER here
	 */
	if (@$ws_user_details)
	{
		$username = $ws_user_details->store_name;
	}
	?>
	Dear <?php echo @$username ?: 'Guest'; ?>,

	<br><br>

	<?php
	/***********
	 * setup $email_message here
	 */
	?>

	<?php if ($sa_details->email_message)
	{
		echo $sa_details->email_message;
		echo '<br>';
		if ($sa_options['w_images'] === 'Y' OR $sa_options['linesheets_only'] == 'Y') { ?>
		<br />
		See attached linesheets...	<br />
		<?php }
	}
	else
	{ ?>

		There are several brand new designs for your review.<br>
		Please respond with items of interest for your stores.<br>
		<br>
		<?php if ($sa_options['w_images'] === 'Y' OR $sa_options['linesheets_only'] == 'Y') { ?>
		See attached linesheets...	<br />
		<?php } ?>

		<?php
	}
	?>

	<br><br>

	<?php if ($sa_options['linesheets_only'] == 'N')
	{ ?>

	<?php
	/***********
	 * setup hash tag email for session and auto login
	 https://www.instylenewyork.com/wholesale/signin.html
	 */
	$access_link = 'javascript:;';
	?>
	<a href="<?php echo $access_link; ?>"><strong>CLICK HERE</strong></a> for more details of the package...

	<br><br>

	<?php
	/***********
	 * The IMAGES PARENT container
	 */

	// Set condition for the table width
	// Table width is set to 758px to accomodate max viewing width for emails
	// Condition is set for when the template is viewed on a browser via
	// admin view of sales package for sending to users
	?>
	<table cellspacing="0" cellpadding="0" border="0" style="<?php echo @$file == 'sa_send' ? '' : 'width:758px;'; ?>">
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
					<table cellspacing="0" cellpadding="0" border="0" style="margin-top:10px;<?php echo @$file == 'sa_send' ? '' : 'width:758px;'; ?>">
						<tbody>
							<tr>
								<?php
								// load library
								//$this->load->library('product_details');

								$icol = 1; // count the number of columns (5 for 5 thumbs per row)
								$irow = 1; // counter for number of rows upto 2 rows for 5 items each row
								$ii = 0; // items count
								foreach($sa_items as $item)
								{
									// get product details
									// either item is a prod_no only or the complete style number
									// consider both
									$product = $this->product_details->initialize(array('tbl_product.prod_no' => $item));
									if ( ! $product)
									{
										$exp = explode('_', $item);
										$product = $this->product_details->initialize(
											array(
												'tbl_product.prod_no' => $exp[0],
												'color_code' => $exp[1]
											)
										);
										$prod_no = $exp[0];
										$color_code = $exp[1];
									}
									else
									{
										$prod_no = $product->prod_no;
										$color_code = $product->color_code;
									}

									// set image paths
									// the new way relating records with media library
									$style_no = $prod_no.'_'.$color_code;

									// the image filename
									if ($product)
									{
										$image = $product->media_path.$style_no.'_f3.jpg';
										$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
										$img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
										$img_coloricon = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_c.jpg';
										$color_name = $product->color_name;
									}
									else
									{
										$image = 'images/instylelnylogo_3.jpg';
										$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$img_back_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$img_large = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$img_coloricon = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$color_name = $this->product_details->get_color_name($color_code);
									}

									// check stocks options for clearance cs only and pre-set price for on sale
									// even if on sale price is not used
									$stocks_options = @$product->stocks_options ?: array();
									$price = @$sa_options['e_prices'][$item] ?: $product->wholesale_price_clearance;

									// check if item is on sale
									if (
										@$product->clearance == '3'
										OR $product->custom_order == '3'
										OR $stocks_options['clearance_consumer_only'] == '1'
										OR @$sa_options['e_prices'][$item]
									)
									{
										$onsale = TRUE;
									}
									else
									{
										$onsale= FALSE;
									}

									if ($icol == 6)
									{
										$icol = 1;
										echo '</tr><tr>';
									}
									?>

								<td style="vertical-align:top;<?php echo @$file == 'sa_send' ? 'width:20%;padding-right:10px;' : 'width:154px;'; ?>">
									<!-- THUMB -->
									<a href="<?php echo $access_link; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="<?php echo @$file == 'sa_send' ? '' : 'width:140px;height:210px;'; ?>">
											<img src="<?php echo $img_front_new; ?>" alt="<?php echo $prod_no; ?>" title="<?php echo $prod_no; ?>" border="0" style="<?php echo @$file == 'sa_send' ? 'width:100%;' : 'width:140px;'; ?>">
										</div>
									</a>
									<!-- hiding the coloricon -->
									<div class="hide" style="margin:3px 0 0;font-size:10px;">
										<img src="<?php echo $img_coloricon; ?>" width="10" height="10">
									</div>
									<!-- detail -->
									<div style="<?php echo @$file == 'sa_send' ? '' : 'width:140px;'; ?>">
										<span style="font-size:10px;"><?php echo $prod_no; ?></span>
										<br />
										<span style="font-size:10px;"><?php echo $color_name; ?></span>
										<?php if (@$sa_options['w_prices'] == 'Y') { ?>
										<br />
										<span style="font-size:10px;<?php echo $onsale ? 'text-decoration:line-through;' : ''; ?>">
											$<?php echo number_format($product->wholesale_price, 2); ?>
										</span>
										<span style="font-size:10px;color:red;<?php echo $onsale ? '' : 'display:none;'; ?>">
											&nbsp;$<?php echo number_format($price, 2); ?>
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
								echo '<tr><td colspan="5" style="padding-top:20px;padding-right:14px;"><a href="'.$access_link.'"><button type="button" style="width:100%;height:50px;padding:20px auto;text-align:center;cursor:pointer;">LOAD MORE</button></a></td></tr>';
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

		<?php
	} ?>

	<br><br>
	<?php echo $author_name; ?> <br>
	<?php echo @$sales_ref_designer; ?> <br>
	230 West 38th Street <br>
	New York , NY 10018 <br>
	212-840-9811 <br>

	<br><br>
