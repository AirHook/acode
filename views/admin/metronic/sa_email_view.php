	<?php
	/***********
	 * setup $USER here
	 */
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
								foreach($sa_items as $item)
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

									$price = @$sa_options['e_prices'][$item] ?: $product->wholesale_price;

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
									<a href="<?php echo $access_link; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:140px;height:210px;">
											<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" width="140" style="width:140px;">
										</div>
									</a>
									<div style="margin:3px 0 0;">
										<img src="<?php echo ($product->primary_img ? $img_coloricon : $color_icon_pre.$color_icon); ?>" width="10" height="10">
									</div>

									<div style="width:140px;">
										<span style="font-size:10px;"><?php echo $product->prod_no; ?></span>
										<?php if (@$sa_options['w_prices'] == 'Y') { ?>
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

	<br><br>
	<?php echo $author_name; ?> <br>
	<?php echo @$sales_ref_designer; ?> <br>
	230 West 38th Street <br>
	New York , NY 10018 <br>
	212-840-9811 <br>

	<br><br>
