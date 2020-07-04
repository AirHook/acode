<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Order Confirmation Email | New</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!--
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	-->

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

		body {
			font-family: "Open Sans", sans-serif;
		}

		 * On mobile, it's ideal if the whole button is a link, not just the text,
		 * because it's much harder to target a tiny text link with your finger.
		 */
		?>
		@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
			body[yahoo] .buttonwrapper {background-color: transparent!important;}
			body[yahoo] .button a {background-color: #fff; padding: 15px 15px 13px!important; display: block!important;}

			/* Unsubscribe footer button only on mobile devices */
			body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #fff; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
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
<body yahoo bgcolor="#fff" style="margin: 0;padding: 0; min-width: 100% !important; font-size: 10px;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="625px" style="border-collapse: collapse;">
					<tr>
						<td>

							<?php
							/***********
							 * Header
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:30px 0px 20px;">

								<?php
								/***********
								 * Logo
								 */
								?>
								<tr>
									<td style="text-align:center;padding-bottom:30px;">

										<?php
										$logo =
											@$logo
											?: base_url().'assets/images/logo/logo-shop7thavenue.png'
										;
										?>

										<img src="<?php echo $logo; ?>" alt="logo" style="height:35px;" class="logo" />

									</td>
								</tr>
								<tr>
									<td>
										<strong>
											<?php echo $this->order_details->c == 'ws' ? 'WHOLESALE ' : 'CONSUMER'; ?>ORDER #<?php echo (@$order_details->order_id ?: '10301800').(@$order_details->options['sales_order'] ? ' '.$order_details->options['sales_order'] : ''); ?> <br />
											<small> Date: <?php echo @@$order_details->order_date ?: '2020-06-01'; ?> </small>
										</strong>

										<br /><br />

										<?php echo @$company_name ?: 'D&amp;I Fashion Group'; ?> <br />
										<?php echo @$company_address1 ? $company_address1.' '.@$company_address2: '230 West 38th Street'; ?> <br />
										<?php echo @$company_city ? $company_city.', '.@@$company_state.' '.@$company_zipcode: 'New York, NY 10018'; ?> <br />
										<?php echo @$company_country ?: 'United States'; ?> <br />
										<?php echo @$company_telephone ?: '212.840.0846'; ?>
									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td>

							<?php
							/***********
							 * Address Details
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;vertical-align:top;">
								<tr>
									<td width="50%" valign="top" style="vertical-align:top;padding-bottom:10px;">

										<strong> Bill To </strong>

										<br /><br />

										<?php echo @$user_details->store_name ? $user_details->store_name.'<br />' : (@$user_details->fname ? $user_details->fname.' '.@$user_details->lname.'<br />' : 'Rey Millares<br />'); ?>
										<?php echo @$user_details->address1 ? $user_details->address1.' '.@$user_details->address2 : '230 West 38th Street'; ?> <br />
										<?php echo @$user_details->city ? $user_details->city.', '.@@$user_details->state.' '.@$user_details->zipcode : 'New York, NY 10018'; ?> <br />
										<?php echo @$user_details->country ?: 'United States'; ?> <br />
										<?php echo @$user_details->telephone ?: '212.840.0846'; ?> <br />

										ATTN: <?php echo @$user_details->fname ? $user_details->fname.' '.@$user_details->lname : 'Rey Millares'; ?> <?php echo @$user_details->email ? '('.$user_details->email.')' : '(help@rcpixel.com)'; ?>

									</td>
									<td width="50%" valign="top" style="vertical-align:top;padding-bottom:10px;">

										<strong> Ship To </strong>

										<br /><br />

										<?php echo @$user_details->store_name ? $user_details->store_name.'<br />' : (@$user_details->fname ? $user_details->fname.' '.@$user_details->lname.'<br />' : 'Rey Millares<br />'); ?>
										<?php echo @$user_details->address1 ? $user_details->address1.' '.@$user_details->address2: '230 West 38th Street'; ?> <br />
										<?php echo @$user_details->city ? $user_details->city.', '.@@$user_details->state.' '.@$user_details->zipcode: 'New York, NY 10018'; ?> <br />
										<?php echo @$user_details->country ?: 'United States'; ?> <br />
										<?php echo @$user_details->telephone ?: '212.840.0846'; ?> <br />

										ATTN: <?php echo @$user_details->fname ? $user_details->fname.' '.@$user_details->lname : 'Rey Millares'; ?> <?php echo @$user_details->email ? '('.$user_details->email.')' : '(help@rcpixel.com)'; ?>

									</td>
								</tr>
							</table>

							<br><br>

							<?php
							/***********
							 * Author
							 */
							?>
							<?php if (@$order_details->options['sales_order'])
							{ ?>

							<strong> Ordered by: </strong> <?php echo @$author->author_name ?: ''; ?> <?php echo $po_details->author_email ? '('.$po_details->author_email.')' : ''; ?>
							<br><br>

								<?php
							} ?>

							<?php
							/***********
							 * Ship Method
							 */
							?>
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:20px 0px;">
								<tr>
									<td>
										<strong> Ship Method: </strong>
										&nbsp;
										<?php
										if (@$order_details->courier == 'TBD')
										{
											// the TBD is taken only from Create Sales Order via sales user my account
											// and the options['shipmethod_text']
											echo @$order_details->options['shipmethod_text'] ?: $order_details->courier;
										}
										else
										{
											// this is normally used via the frontend checkout process
											echo @$order_details->courier ?: 'TBD';
										}
										?>
									</td>
								</tr>
							</table>

							<?php
							/***********
							 * Assign Sales User for WS
							 */
							if ($this->order_details->c == 'ws')
							{ ?>

							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:20px 0px;">
								<tr>
									<td>
										<strong> Assigned Sales Representative: </strong>
										&nbsp;
										<?php
										echo $user_details->admin_sales_user.' '.$user_details->admin_sales_lname.' ('.$user_details->admin_sales_email.')';
										?>
									</td>
								</tr>
							</table>

								<?php
							} ?>

							<?php
							/***********
							 * Order Details
							 */
							?>
							<table cellpadding="0" cellspacing="0" style="width:100%;">

								<thead>
									<tr style="background-color:#e9edef;">
										<th align="left" style="padding:0px 5px 8px;">
											Items (<?php echo @$order_items ? count($order_items) : '0'; ?>) Details
										</th>
										<th align="left" style="padding:0 5px 8px;"> Prod No </th>
										<th align="center" style="padding:0 5px 8px;"> Size </th>
										<th align="left" style="padding:0 5px 8px;"> Color </th>
										<th align="center" style="padding:0 5px 8px;"> Qty </th>
										<th align="center" style="width:12%;padding:0 5px 8px;border-left:1px solid #ccc;"> Regular<br />Price </th>
										<th align="center" style="width:12%;padding:0 5px 8px;border-right:1px solid #ccc;"> Discounted<br />Price </th>
										<th align="right" style="width:12%;padding:0 5px 8px;"> Extended<br />Price </th>
									</tr>
								</thead>

								<tbody>
									<tr><td colspan="8" style="border-bottom:1px solid #ccc;"> <td></tr>
									<tr><td colspan="8" style="height:10px;"> <td></tr>

										<?php
										if (@$order_details->order_items)
										{
											$overall_qty = 0;
											$overall_total = 0;
											$this_size_qty = 0;
											$i = 1;
											foreach ($order_details->order_items as $item)
											{
												// just a catch all error suppression
												if ( ! $item) continue;

												// get product details
												// NOTE: some items may not be in product list
												$exp = explode('_', $item->prod_sku);
												$product = $this->product_details->initialize(
													array(
														'tbl_product.prod_no' => $exp[0],
														'color_code' => $exp[1]
													)
												);

												// set image paths
												$prod_no = $exp[0];
												$color_code = $exp[1];

												if ($product)
												{
													$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$item->prod_sku.'_f1.jpg';
												}
												else
												{
													$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_1.jpg';
												}

												// get size label
												$size = $item->size;
												$size_names = $this->size_names->get_size_names($product->size_mode);
												$size_label = array_search($size, $size_names);

												// set original price in case options['orig_price'] is not set
												// set $price
												$orig_price = $this->order_details->c == 'ws' ? $product->wholesale_price : $product->retail_price;
												$price = $item->unit_price;

												// get items options
												$options = $item->options ? json_decode($item->options, TRUE) : array();
												?>

									<tr>

										<?php
										/**********
										 * IMAGE and info
										 */
										?>
										<td style="vertical-align:top;padding:0 5px 20px 0">
											<a href="javascript:;" style="float:left;">
												<img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL'); ?>images/instylelnylogo_3.jpg');" />
											</a>
											<!--
											<div class="shop-cart-item-details" style="margin-left:65px;display:none;">
												<h4 style="margin:0px;">
													<?php echo $prod_no; ?>
												</h4>
												<p style="margin:0px;">
													Color: &nbsp; <?php echo $item->color; ?><br />
													<span style="color:#999;">Style#:&nbsp;<?php echo $item->prod_sku; ?></span>
													<?php echo @$product->designer_name ? '<br /><cite style="font-size:75%;">'.$product->designer_name.'</cite>' : ''; ?>
													<?php echo @$product->category_names ? ' <cite style="font-size:75%;">('.end($product->category_names).')</cite>' : ''; ?>
												</p>
											</div>
											-->
										</td>

										<?php
										/**********
										 * Prod No
										 */
										?>
										<td style="vertical-align:top;padding:0 5px;">
											<?php echo $item->prod_no; ?>
											<?php echo $item->custom_order == '3' ? '<br /><em style="color:red;font-size:75%;">On Sale</em>' : ''; ?>
										</td>

										<?php
										/**********
										 * Size
										 */
										?>
										<td align="center" style="vertical-align:top;padding:0 5px;">
											<?php echo $item->size; ?>
										</td>

										<?php
										/**********
										 * Color
										 */
										?>
										<td align="left" style="vertical-align:top;padding:0 5px;">
											<?php echo $item->color; ?>
										</td>

										<?php
										/**********
										 * Qty
										 */
										?>
										<td align="center" style="vertical-align:top;padding:0 5px;">
											<?php echo $item->qty; ?>
										</td>

										<?php
										/**********
										 * Unit Regular Price
										 */
										?>
										<td align="right" style="vertical-align:top;padding:0 5px;<?php echo $orig_price == $price ?: 'text-decoration:line-through;'; ?>">
											<?php echo $orig_price ? '$ '.number_format($orig_price, 2) : '--'; ?>
										</td>

										<?php
										/**********
										 * Unit Discounted Price
										 */
										?>
										<td align="right" style="vertical-align:top;padding:0 5px;<?php echo $orig_price == $price ?: 'color:red;'; ?>">
											<?php echo $orig_price == $price ? '--' : '$ '.number_format($price, 2); ?>
										</td>

										<?php
										/**********
										 * Extended
										 */
										?>
										<td align="right" style="vertical-align:top;padding:0 0 0 5px;">
											<?php
											$this_size_total = $price * $item->qty;
											echo $this_size_total ? '$ '.number_format($this_size_total, 2) : '$0.00';
											?>
										</td>

									</tr>

												<?php
												$i++;
												$overall_qty += $item->qty;
												$overall_total += $this_size_total;
											}
										} ?>

									<tr><td colspan="8" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
									<tr><td colspan="8" style="height:20px;"> <td></tr>

									<tr>
										<td colspan="5" rowspan="5" align="left" style="vertical-align:top;">
											Remarks/Instructions:<br /><br />
										</td>
										<td colspan="2" align="right" style="vertical-align:top;height:24px;"> Sub Total </td>
										<td align="right" style="vertical-align:top;height:24px;">
											<?php echo @$overall_total ? '$ '.number_format($overall_total, 2) : '$ 0.00'; ?>
										</td>
									</tr>

									<tr>
										<td colspan="2" align="right" style="vertical-align:top;height:24px;">
											Shipping &amp; Handling
											<?php
											if (@$order_details->shipping_fee === '0')
											{
												echo '<br /><cite style="font-size:75%;">(For countries other than United States, you will be contacted by customer service for shipping fees)</cite>';
											}
											?>
										</td>
										<td align="right" style="vertical-align:top;height:24px;">
											<?php echo @$order_details->shipping_fee != '0' ? '$ '.number_format($order_details->shipping_fee, 2) : '--'; ?>
										</td>
									</tr>

									<tr><td colspan="3" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
									<tr><td colspan="3" style="height:10px;"> <td></tr>

									<tr>
										<td colspan="2" align="right" style="vertical-align:top;height:24px;font-weight:bold;"> Grand Total </td>
										<td align="right" style="vertical-align:top;height:24px;font-weight:bold;">
											$ <?php echo @number_format(($overall_total + $order_details->shipping_fee), 2); ?>
										</td>
									</tr>
								</tbody>

							</table>

							<br /><br />

						</td>
					</tr>
					<tr>
						<td>

							<?php
							// payment details shows for consumer users orders
							// and wholesale user 'add a card' option
							// for 'send to admin' copy
							if (@$sending_to_admin)
							{ ?>

							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:30px 0px 20px;">

								<?php
								/***********
								 * Payment Details
								 */
								?>
								<tr>
									<td>
										<strong>
											Payment Details:
										</strong>

										<br /><br />

										<?php
										if (
											$order_details->c == 'cs'
											OR $order_details->c == 'guest'
											OR @$order_details->options['ws_payment_options'] == '2'
										)
										{
											echo @$order_details->options['ws_payment_options'] == '2' ? 'Add a card:<br />' : '';
											?>

										Card Type: <?php echo $this->session->flashdata('cc_type') ?: '<cite>Card type</cite>'; ?><br />
										Card Holder: <?php echo @$user_details->fname ? $user_details->fname.' '.@$user_details->lname : '<cite>Card holder name</cite>'; ?><br />
										Card Number: <?php echo $this->session->flashdata('cc_number') ?: '<cite>Card number of user</cite>'; ?><br />
										Expiration: <?php echo ($this->session->flashdata('cc_expmo').'/'.$this->session->flashdata('cc_expyy')) ?: '<cite>Card expiry date</cite>'; ?><br />
										CSC: <?php echo $this->session->flashdata('cc_code') ?: '<cite>CSC</cite>'; ?>

											<?php
										}
										else
										{
											// this options will always be present for ws order inquiries hence forth
											switch (@$order_details->options['ws_payment_options'])
											{
												case '1':
													echo 'Use my card on file.';
												break;
												case '3':
													echo 'Send Paypal Invoice.';
												break;
												case '4':
													echo 'Bill My Account.';
												break;
												case '5':
													echo 'Send Wire Request.';
												break;
											}
										}
										?>

									</td>
								</tr>
							</table>

								<?php
							} ?>

						</td>
					</tr>
					<tr>
						<td>

							<?php
							/***********
							 * Footer
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:30px 0px 20px;">

								<tr>
									<td style="text-align:center;padding-bottom:10px;">

										<?php
										if ($order_details->c == 'ws')
										{
											//$delivery_notice = 'Your order inquiry was received and will be researched for availability on product.';
											$delivery_notice = 'THIS IS NOT A CONFIRMATION OF ORDER ACCEPTANCE. YOUR SALES REPRESENTATIVE WILL CONTACT YOU TO FINALIZE YOUR ORDER AND SEND YOU A FORMAL INVOICE.';
										}
										else
										{
											if (@$custom_order)
											{
												$delivery_notice = 'You have a Custom Order item in your order. Delivery is approximately 14-16 weeks from order.';
											}
											else
											{
												$delivery_notice = 'Your order was received and will be researched for availability on product.';
											}
										}
										if ($order_details->shipping_fee === '0')
										{ ?>

										<span style="font-size:85%;">
											<sup>*</sup>NOTE: <?php echo $delivery_notice; ?>
										</span>

											<?php
										}
										?>

									</td>
								</tr>

								<tr>
									<td>
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
														Purchaser agrees to abide by the <?php echo $this->webspace_details->slug; ?>.com <a href="http://www.<?php echo $this->webspace_details->slug; ?>.com/return_policy.html">Return Policy</a>.
													</font>
												</td>
											</tr>
												<?php
											} ?>
										</table>
									</td>
								</tr>

							</table>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
