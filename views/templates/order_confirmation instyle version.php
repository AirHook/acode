<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Order Confirmatino Email</title>

		<!--
		/***********
		 * For editing purposes, css are placed here initially
		 * Transfer all styles inline because some clients, such as Gmail,
		 * will ignore or strip out your <style> tag contents, or ignore them.
		 */
		-->
        <style type="text/css">
		<!--
		/***********
		 * On mobile, it\'s ideal if the whole button is a link, not just the text,
		 * because it\'s much harder to target a tiny text link with your finger.
		 */
		-->
		@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
			body[yahoo] .buttonwrapper {background-color: transparent!important;}
			body[yahoo] .button a {background-color: red; padding: 15px 15px 13px!important; display: block!important;}

			/* Unsubscribe footer button only on mobile devices */
			body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
			body[yahoo] .hide {display: none!important;}
		}

		<!--
		/***********
		 * A Fix for Apple Mail
		 * Weirdly, Apple Mail (normally a very progressive email client)
		 * doesn\'t support the max-width property either.
		 * It does support media queries though, so we can add one that tells
		 * it to set a width on our \'content\' class table, as long as the viewport
		 * can display the whole 600px.
		 */
		-->
		@media only screen and (min-device-width: 626px) {
			.content {width: 625px !important;}
			.col380 {width: 400px !important;}
			.col280 {width: 280px !important;}
		}
        </style>

    </head>

	<!--
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
	-->
    <body yahoo style="margin: 10px 0 0;padding: 0; min-width: 100% !important;">

        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td>
					<!--
					/***********
					 * Overcoming the Lack of Max-Width Support
					 * Unfortunately, max-width is not supported by all email clients.
					 * we need to wrap each table in some conditional code which creates
					 * a table with a set width to hold everything in.
					 */
					-->
					<!--[if (gte mso 9)|(IE)]>
					<table width="650" align="center" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<![endif]-->
					<table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 650px;">
						<tbody>

						<!--
						/***********
						 * HEADER
						 */
						-->
                        <tr>
                            <td class="header" bgcolor="" style="padding: 0;">

								<!--
								/***********
								 * Outlook will automatically stack your tables if there isn\'t at
								 * least 25px to spare on any given row. Allow at least 25px of
								 * breathing room to stop Outlook from stacking your tables.
								 */
								-->
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr bgcolor="#efefef">
										<td width="10">
											<img src="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/top_left.jpg">
										</td>
										<td background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/top_bg.jpg" width="630" height="92">

											<table width="630" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/top_bg.jpg">
												<tbody>
													<tr>
														<td width="514">
															<font color="#333333" style="font-family:Tahoma;font-size:12px;">
																<b>
																<?php
																if ($this->session->userdata('user_cat') === 'wholesale')
																{
																	echo 'WHOLESALE ORDER INQUIRY';
																}
																else
																{
																	echo 'ORDER SUMMARY';
																}
																?>
																</b> &nbsp; &nbsp;
															</font>
															<font color="#333333" style="font-family:Tahoma;font-size:10px;">
																[ DATE: <?php echo @date('Y-m-d',time()); ?> ]
															</font>
														</td>
														<td width="104" align="right">
															<font color="#333333" style="font-family:Tahoma;font-size:12px;">
																<b>ORDER#:</b>
															</font>
															<font color="#333333" style="font-family:Tahoma;font-size:10px;">
																<?php echo @$order_log_id ?: '<cite>order id here</cite>'; ?>
															</font>
														</td>
													</tr>
												</tbody>
											</table>

										</td>
										<td width="10">
											<img src="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/top_right.jpg">
										</td>
									</tr>
								</table>

                            </td>
                        </tr>

						<!--
						/***********
						 * CONTENT BODY Row 1
						 * Shipping and User details
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" bgcolor="" style="padding: 0;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr bgcolor="#efefef">
										<td width="10">
											&nbsp;
										</td>
										<td width="630">

											<table width="630">
												<tbody>

                                                    <tr>
														<td colspan="2" height="35" bgcolor="#767676" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg">
															<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">
                                                                &nbsp;<b>DESIGNERS:</b>
                                                                <?php  ?>
                                                            </font>
														</td>
													</tr>

													<tr>
														<td colspan="2" height="35" bgcolor="#767676" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg">
															<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">
															&nbsp;<b>SHIPPING DETAILS</b></font>
														</td>
													</tr>
													<tr>
														<td width="200">&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Name :</b></font></td>
														<td width="422">
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_first_name ? @$p_first_name.' '.@$p_last_name : (@$test ? '<cite>User name</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<?php
													if ($this->session->userdata('user_cat') === 'wholesale')
													{
														?>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Store Name :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_store_name ? : (@$test ? '<cite>User store name</cite>' : ''); ?>
															</font>
														</td>
													</tr>
														<?php
													}
													?>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Address :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$sh_address1 ? @$sh_address1.' '.@$sh_address2 : (@$test ? '<cite>User address</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>City :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$sh_city ?: (@$test ? '<cite>User city</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>State :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$sh_state ?: (@$test ? '<cite>User state</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Country :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$sh_country ?: (@$test ? '<cite>User country</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Zip :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$sh_zipcode ?: (@$test ? '<cite>User zipcode</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Phone :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_telephone ?: (@$test ? '<cite>User phone</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Email :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<a href="<?php echo @$p_email ? 'mailto:'.$p_email : 'javascript:;'; ?>">
																	<?php echo @$p_email ?: (@$test ? '<cite>User email</cite>' : ''); ?>
																</a>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Courier :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$shipping_courier ?: (@$test ? '<cite>User shipping courier</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<?php
													if ($this->session->userdata('user_cat') === 'wholesale')
													{
														?>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Assigned Sales Representative :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo $this->wholesale_user_details->admin_sales_user.' '.$this->wholesale_user_details->admin_sales_lname.' <cite>&lt;'.$this->wholesale_user_details->admin_sales_email.'&gt;</cite>'; ?>
															</font>
														</td>
													</tr>
														<?php
													}
													?>

												</tbody>
											</table>

											<br />

										</td>
										<td width="10">
											&nbsp;
										</td>
									</tr>
								</table>

							</td>
						</tr>

						<?php
						// payment details shows for consumer users
						if ($this->session->userdata('user_cat') != 'wholesale')
						{
						?>

						<!--
						/***********
						 * CONTENT BODY Row 2
						 * Payment details
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" bgcolor="" style="padding: 0;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr bgcolor="#efefef">
										<td width="10">
											&nbsp;
										</td>
										<td width="630">

											<table width="630">
												<tbody>

													<tr>
														<td colspan="2" height="35" bgcolor="#767676" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg">
															<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">
															&nbsp;<b>PAYMENT DETAILS</b></font>
														</td>
													</tr>
													<tr>
														<td width="170">&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Type :</b></font></td>
														<td width="452">
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_card_type ?: (@$test ? '<cite>Card type</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Holder :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_first_name ? @$p_first_name.' '.@$p_last_name : (@$test ? '<cite>Card holder name</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Number :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_card_num ?: (@$test ? '<cite>Card number of user</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Expiration :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_exp_date ?: (@$test ? '<cite>Card expiry date</cite>' : ''); ?>
															</font>
														</td>
													</tr>
													<tr>
														<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>CSC :</b></font></td>
														<td>
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo @$p_card_code ?: (@$test ? '<cite>CSC</cite>' : ''); ?>
															</font>
														</td>
													</tr>

												</tbody>
											</table>

											<br />

										</td>
										<td width="10">
											&nbsp;
										</td>
									</tr>
								</table>

							</td>
						</tr>

							<?php
						} ?>

						<!--
						/***********
						 * CONTENT BODY Row 3
						 * Shop Cart Items
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" bgcolor="" style="padding: 0;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr bgcolor="#efefef">
										<td width="10">
											&nbsp;
										</td>
										<td width="630">

											<table width="630" cellpadding="2">
												<tbody>
													<!--
													/***********
													 * Heading
													 */
													-->
													<tr>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Thumb</b></font></td>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Item</b></font></td>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Style Number</b></font></td>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Size</b></font></td>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Color</b></font></td>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Quantity</b></font></td>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Price</b></font></td>
														<td align="center" background="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Subtotal</b></font></td>
													</tr>

													<!--
													/***********
													 * Items
													 */
													-->
													<?php
													foreach($this->cart->contents() as $items)
													{
														// incorporate new image url system
														if (
															isset($items['options']['prod_image_url'])
															&& ! empty($items['options']['prod_image_url'])
														)
														{
															$href_text = str_replace('_f2', '_f3', $items['options']['prod_image_url']);
														}
														else
														{
															$href_text = str_replace('_2', '_3', $items['options']['prod_image']);
														}
														?>

													<tr>
														<td align="center">
															<font style="font-family:Tahoma;font-size:10px;">
																<?php echo $this->session->userdata('user_cat') != 'wholesale' ? '<a href="'.$items['options']['current_url'].'">' : ''; ?>
																	<img src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" width="60" height="90" border="0">
																<?php echo $this->session->userdata('user_cat') != 'wholesale' ? '</a>' : '';  ?>
															</font>
														</td>
														<td align="center"><font style="font-family:Tahoma;font-size:10px;"><?php echo $items['name']; ?></font></td>
														<td align="center"><font style="font-family:Tahoma;font-size:10px;"><?php echo $items['options']['prod_no']; ?></font></td>
														<td align="center"><font style="font-family:Tahoma;font-size:10px;"><?php echo $items['options']['size']; ?></font></td>
														<td align="center"><font style="font-family:Tahoma;font-size:10px;"><?php echo $items['options']['color'].($items['options']['custom_order'] == '3' ? '<br /><em style="color:red;">On Special Sale</em>' : ''); ?></font></td>
														<td align="center"><font style="font-family:Tahoma;font-size:10px;"><?php echo $items['qty']; ?></font></td>
														<td align="center"><font style="font-family:Tahoma;font-size:10px;">$ <?php echo $items['price']; ?></font></td>
														<td align="center"><font style="font-family:Tahoma;font-size:10px;">$ <?php echo $items['qty'] * $items['price']; ?></font></td>
													</tr>

														<?php
														// Since custom order (or Pre Order) is now based on quantity that is zero
														// we check the option 'custom_order' from cart item as this determine if size
														// is on pre-order (zero stock) or not
														if ($items['options']['custom_order'] == '1') $custom_order = TRUE;
														elseif (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
														else $custom_order = FALSE;
													}
													?>

													<?php if (@$ship_method) { ?>
													<tr>
														<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:10px;"><?php echo $shipping_method; ?> : </font></td>
														<td align="right"><font style="font-family:Tahoma;font-size:10px;">$ <?php echo $shipping_fee; ?></font></td>
													</tr>
													<?php } ?>

													<?php if (@$add_ny_sales_tax) { ?>
													<tr>
														<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:10px;">NY Sales Tax : </font></td>
														<td align="right"><font style="font-family:Tahoma;font-size:10px;">$ <?php echo $add_ny_sales_tax; ?></font></td>
													</tr>
													<?php } ?>

													<tr height="10"><td colspan="8">&nbsp;</td></tr>

													<!--
													/***********
													 * Totals and notices
													 */
													-->
													<tr>
														<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:12px;">Grand-Total : </font></td>
														<td align="right"><font style="font-family:Tahoma;font-size:12px;">$ <?php echo @$grand_total ?: '<cite>Grand total</cite>'; ?></font></td>
													</tr>

													<?php if (@$sh_country <> 'United States') { ?>
													<tr>
														<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:9px;">( For countries other than United State, you will be contacted by customer service for shipping fees ) &nbsp; </font></td>
														<td align="center"></td>
													</tr>
													<?php } ?>

													<?php
													if ($this->session->userdata('user_cat') == 'wholesale')
													{
														$delivery_notice = 'Your order inquiry was received and will be researched for availability on product.';
													}
													else
													{
														if ($custom_order)
														{
															$delivery_notice = 'You have a Custom Order item in your order. Delivery is approximately 14-16 weeks from order.';
														}
														else
														{
															$delivery_notice = 'Your order was received and will be researched for availability on product.';
														}
													}
													?>
													<tr>
														<td colspan="8" align="center"><font style="color:red;font-family:Tahoma;font-size:9px;"><br /><br />* NOTE: <?php echo $delivery_notice; ?> &nbsp; </font><br /></td>
													</tr>

												</tbody>
											</table>

											<br />

										</td>
										<td width="10">
											&nbsp;
										</td>
									</tr>
								</table>

							</td>
						</tr>

						<!--
						/***********
						 * FOOTER
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" bgcolor="" style="padding: 0;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr bgcolor="#efefef">
										<td width="10">
											&nbsp;
										</td>
										<td width="630">

											<table width="630" align="center" style="border-top:1px solid black;">
												<tr>
													<td width="630" align="center">
														<font color="#333333" style="font-family:Tahoma;font-size:10px;">
															<?php echo $this->webspace_details->name; ?>
															<?php echo $this->webspace_details->address1; ?>
															<?php echo $this->webspace_details->address2; ?>
															<br />EMAIL <a href="mailto:<?php echo $this->webspace_details->info_email; ?>"><?php echo $this->webspace_details->info_email; ?></a>
														</font>
													</td>
												</tr>
												<?php
												if ($this->session->userdata('user_cat') !== 'wholesale')
												{ ?>
												<tr>
													<td width="630" align="center">
														<font color="#333333" style="font-family:Tahoma;font-size:10px;">
															Purchaser agrees to abide by the <?php echo $this->webspace_details->slug; ?>.com <a href="http://www.<?php echo $this->webspace_details->slug; ?>.com/page/return_policy.html">Return Policy</a>.
														</font>
													</td>
												</tr>
													<?php
												} ?>
											</table>

										</td>
										<td width="10">
											&nbsp;
										</td>
									</tr>
									<tr>
										<td><img src="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bottom_left.jpg"></td>
										<td><img src="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bottom_bg.jpg"></td>
										<td><img src="http://www.<?php echo $this->webspace_details->slug; ?>.com/images/newsletter/bottom_right.jpg"></td>
									</tr>
								</table>

								<br /><br />

							</td>
						</tr>

						</tbody>
                    </table>
								<!--[if (gte mso 9)|(IE)]>
							</td>
						</tr>
					</table>
					<![endif]-->
                </td>
            </tr>
        </table>
    </body>
</html>
