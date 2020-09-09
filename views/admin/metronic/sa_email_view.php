<table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:650px;">
	<tbody>

	<!--
	/***********
	 * HEADER
	 */
	-->
	<tr>
		<td class="header" bgcolor="" style="padding:0;">

			<!--
			/***********
			 * Outlook will automatically stack your tables if there isn\'t at
			 * least 25px to spare on any given row. Allow at least 25px of
			 * breathing room to stop Outlook from stacking your tables.
			 */
			-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr bgcolor="">

					<td width="100%" height="92" align="center" style="font-family:Tahoma;font-size:12px;color:black;vertical-align:top;">

						<?php if ($this->webspace_details->slug != 'tempoparis') { ?>
						<br />
						<span style="font-size:0.8em;line-height:24px;display:none;">
							Can't see the images in this email? &nbsp;
							<a href="<?php echo site_url('wholesale/activation_email/index/'.@$user_id); ?>" style="color:black;">
								View in browser
							</a>
						</span>
						<?php } ?>
						<br />

						<?php
						$logo =
							@$logo
							?: base_url().'assets/images/logo/logo-shop7thavenue.png'
						;
						?>

						<img src="<?php echo $logo; ?>" alt="logo" style="width:300px;margin-top:10px;margin-bottom:5px;" class="logo" />

						<br />

						<hr style="border-top:1px solid black;border-bottom:none;"/>

					</td>

				</tr>
			</table>

		</td>
	</tr>

	<!--
	/***********
	 * CONTENT BODY Row 1
	 * Welcom text
	 */
	-->
	<tr>
		<td class="" bgcolor="#f9ece6" style="padding:10px;">

			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr bgcolor="white">
					<td width="100%">

						<table width="100%">
							<tbody>
								<tr>
									<td style="padding:30px 50px;font-family:Arial;font-size:12px;color:black;">

										<br>

										Hello <?php echo @$username ?: 'Guest'; ?>,

										<br><br>

										<?php
										/***********
										 * setup $email_message here
										 */
										?>
										<?php if ($email_message)
										{
											echo $email_message;
											echo '<br><br>';
										} ?>

										View Our sales package offer below with several new designs for your review.<br />
										Please respond with items of interest for your stores by sending in a Inquiry Order.

									</td>
								</tr>

							</tbody>
						</table>

						<br />

					</td>
				</tr>
			</table>

		</td>
	</tr>

	<!--
	/***********
	 * CONTENT BODY Row 2
	 * Sales Package Items
	 */
	-->
	<tr>
		<td class="" bgcolor="" style="padding-top:40px;padding-bottom:50px;">

			<table width="100%" border="0" cellpadding="0" cellspacing="0">

				<tr bgcolor="white" style="">

						<?php
						$icol = 1; // count the number of columns (3 for 3 thumbs per row)
						//$irow = 1; // counter for number of rows upto 2 rows for 3 items each row
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

							// get options
							$options_array =
								$this->session->sa_options
								? json_decode($this->session->sa_options, TRUE)
								: array()
							;

							// sales package email is for wholesale users only
							// hence, wholesale user prices
							$orig_price = @$product->wholesale_price ?: 0;
							$price =
								@$options_array['e_prices'][$item]
								?: (
									@$product->custom_order == '3'
									? (@$product->wholesale_price_clearance ?: 0)
									: $orig_price
								)
							;

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

							if ($icol == 4)
							{
								$icol = 1;
								echo '</tr><tr>';
							}

							switch ($icol)
							{
								case 1:
									$align = "text-align:left;";
									$divalign = "margin-left:0px;";
								break;
								case 2:
									$align = "text-align:center;";
									$divalign = "margin:auto;";
								break;
								case 3:
									$align = "text-align:right;";
									$divalign = "float:right;";
								break;
							}
							?>

						<td style="vertical-align:top;padding-bottom:10px;width:33%;<?php echo $align; ?>" data-item="<?php echo $item; ?>">

							<div style="width:97%;<?php echo $divalign; ?>">

								<!-- BEGIN IMAGE -->
								<a href="<?php echo @$access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html'; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
									<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:100%;height:auto;">
										<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" style="width:100%;height:auto;">
									</div>
								</a>
								<!-- END IMAGE -->

								<div style="text-align:left;padding-left:0px;margin-top:3px;">
									<span style="font-size:10px;">
										<?php echo $product->prod_no; ?>
									</span>
									<br />
									<span style="font-size:10px;">
										<?php echo $product->color_name; ?>
									</span>
									<br />
									<span style="font-size:10px;">
										<span style="<?php echo $orig_price == $price ?: 'text-decoration:line-through;'; ?>">
											$ <?php echo number_format($product->wholesale_price, 2); ?>
										</span>
										&nbsp;
										<span style="color:red;<?php echo $orig_price == $price ? 'display:none;' : ''; ?>">
											$ <?php echo number_format($price, 2); ?>
										</span>
									</span>
								</div>
								<!-- END PRODUCT INFO -->

							</div>

						</td>

							<?php
							$icol++;
							$ii++;

							// finish iteration at 15 items max
							/*
							if ($ii == 15)
							{
								$load_more = TRUE;
								break;
							}
							else $load_more = FALSE;
							*/
						}

						// let us finish the columns on the last item
						for($icol; $icol <= 3; $icol++)
						{
							echo '<td style="vertical-align:top;width:33%;;"></td>';
						}
						?>

				</tr>
			</table>

		</td>
	</tr>

	<!--
	/***********
	 * CONTENT BODY Row 5
	 * Privacy Policy and Terms and Conditions
	 */
	-->
	<tr>
		<td class="header" bgcolor="" style="padding:0;">

			<!--
			/***********
			 * Outlook will automatically stack your tables if there isn\'t at
			 * least 25px to spare on any given row. Allow at least 25px of
			 * breathing room to stop Outlook from stacking your tables.
			 */
			-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr bgcolor="">

					<td width="100%" height="92" align="center" style="font-family:Tahoma;font-size:8px;color:#aaa;vertical-align:top;">

						<hr style="border-top:1px solid black;border-bottom:none;"/>
						<br />

					</td>

				</tr>
			</table>

		</td>
	</tr>

	</tbody>
</table>
