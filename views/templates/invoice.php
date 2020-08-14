<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Invoice | PDF</title>
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
						<td bgcolor="#f9ece6" style="padding:10px;">

							<table width="100%" style="background:white;">
								<tbody>
									<tr>
										<td style="padding:30px 50px;font-family:Arial;font-size:12px;color:black;font-family:sans-serif;font-size:10px;">

											Hello <?php echo @$user_details->fname.' '.@$user_details->lname; ?>
											<br /><br />
											Enclosed and attached is the invoice for your order #<?php echo $order_details->order_id; ?>.<br />
											Please let us know your option for payment by clicking on the link below:
											<br /><br />
											<a href="javascript:;">PAYMENT OPTIONS</a>
											<br /><br />
											<br /><br />
											Thanks and best regards.

										</td>
									</tr>

								</tbody>
							</table>

						</td>
					</tr>
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
									<td colspan="2" style="text-align:center;padding-bottom:30px;">

										<?php
										$logo =
											@$logo
											?: base_url().'assets/images/logo/logo-shop7thavenue.png'
										;

										if (
											@$order_details->options['sales_order']
											&& $order_details->designer_group == 'Mixed Designers'
										)
										{ ?>

										<img src="<?php echo base_url().'assets/images/logo/logo-shop7thavenue.png'; ?>" alt="logo" style="height:25px;" class="logo" />
										&nbsp; <span style="position:relative;bottom:5px;font-size:25px;">-</span> &nbsp;
										<img src="<?php echo $logo; ?>" alt="logo" style="height:25px;" class="logo" />

											<?php
										}
										else
										{ ?>

										<img src="<?php echo $logo; ?>" alt="logo" style="height:35px;" class="logo" />

											<?php
										} ?>


									</td>
								</tr>

								<?php
								/***********
								 * Letter Head
								 */
								?>
								<tr>
									<td width="50%" valign="top" style="vertical-align:top;padding-bottom:10px;font-family:sans-serif;font-size:10px;">
										<strong>
											<?php echo $this->webspace_details->name; ?>
										</strong>
										<br />
										<?php echo $this->webspace_details->address1; ?> <br />
										<?php echo $this->webspace_details->address2 ? $this->webspace_details->address2.'<br />' : ''; ?>
										<?php echo $this->webspace_details->city.', '.$this->webspace_details->state.' '.$this->webspace_details->zipcode; ?> <br />
										<?php echo $this->webspace_details->country; ?> <br />
										<?php echo $this->webspace_details->phone; ?> <br />
									</td>
									<td width="50%" valign="top" style="vertical-align:top;padding-bottom:10px;font-family:sans-serif;font-size:10px;">
										<strong>
											INVOICE #<?php echo (@$order_details->invoice_id ?: '97104'); ?>
										</strong>
										<br />
										<small>
											Customer: #<?php echo @$order_details->user_id ?: '--'; ?>
											<br />
											Date: <?php echo date('F j, Y', strtotime(@$order_details->order_date)) ?: '2020-06-01'; ?>
										</small>
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
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;vertical-align:top;margin-bottom:20px;">
								<tr>
									<td width="50%" valign="top" style="vertical-align:top;padding-bottom:10px;font-family:sans-serif;font-size:10px;">

										<strong> Bill To </strong>

										<br /><br />

										<?php
										$store_name = @$user_details->store_name ? $user_details->store_name.'<br />' : '';
										$name = @$user_details->fname ? $user_details->fname.' '.@$user_details->lname.'<br />' : 'Your Name<br />';
										$address1 = @$user_details->address1 ? $user_details->address1.'<br />' : 'Street Address<br />';
										$address2 = @$user_details->address2 ? $user_details->address2.'<br />' : '';
										$csz = @$user_details->city ? $user_details->city.', '.@$user_details->state.' '.@$user_details->zipcode.'<br />' : 'City State Zipcode<br />';
										$country = @$user_details->country ? $user_details->country.'<br />' : 'Country<br />';
										$telephone = @$user_details->telephone ? @$user_details->telephone.'<br />' : '212.840.0846<br />';
										?>

										<?php echo $store_name ?: ''; ?>
										<?php echo $name ?: ''; ?>
										<?php echo $address1 ?: ''; ?>
										<?php echo $address2 ?: ''; ?>
										<?php echo $csz ?: ''; ?>
										<?php echo $country ?: ''; ?>
										<?php echo $telephone ?: ''; ?>
										ATTN: <?php echo @$user_details->fname ? $user_details->fname.' '.@$user_details->lname : 'Your Name'; ?> <?php echo @$user_details->email ? '('.$user_details->email.')' : '(your-email@domain.com)'; ?>

									</td>
									<td width="50%" valign="top" style="vertical-align:top;padding-bottom:10px;font-family:sans-serif;font-size:10px;">

										<strong> Ship To </strong>

										<br /><br />

										<?php echo $order_details->store_name ? $order_details->store_name.'<br />' : ($store_name ?: ''); ?>
										<?php echo $order_details->firstname ? $order_details->firstname.' '.$order_details->lastname.'<br />' : ($name ?: ''); ?>
										<?php echo $order_details->ship_address1 ? $order_details->ship_address1.'<br />' : ($address1 ?: ''); ?>
										<?php echo $order_details->ship_address2 ? $order_details->ship_address2.'<br />' : ($address2 ?: ''); ?>
										<?php echo $order_details->ship_city ? $order_details->ship_city.', '.$order_details->ship_state.' '.$order_details->ship_zipcode.'<br />' : ($csz ?: ''); ?>
										<?php echo $order_details->ship_country ? $order_details->ship_country.'<br />' : ($country ?: ''); ?>
										<?php echo $order_details->telephone ? $order_details->telephone.'<br />' : ($telephone ?: ''); ?>
										ATTN: <?php echo $order_details->firstname ? $order_details->firstname.' '.$order_details->lastname : $name; ?> <?php echo @$order_details->email ? '('.$order_details->email.')' : ($user_details->email ?: '(help@rcpixel.com)'); ?>

									</td>
								</tr>
							</table>

							<?php
							/***********
							 * Ship Method
							 */
							?>
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin-bottom:10px;font-family:sans-serif;font-size:10px;">
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

							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:10px 0 20px;font-family:sans-serif;font-size:10px;">
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
							<table cellpadding="0" cellspacing="0" style="width:100%;border:1px solid #ccc;">

								<thead>
									<tr style="background-color:#e9edef;font-family:sans-serif;font-size:10px;">
										<th align="center" style="width:7%;vertical-align:bottom;padding:5px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;"> Qty<br />Reqd </th>
										<th align="center" style="width:7%;vertical-align:bottom;padding:5px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;"> Qty<br />Shipd </th>
										<th align="center" style="width:7%;vertical-align:bottom;padding:5px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;"> Qty<br />Bal </th>
										<th align="left" style="width:12%;vertical-align:bottom;padding:5px;border-bottom:1px solid #ccc;">
											Item No.
										</th>
										<th align="left" style="vertical-align:bottom;padding:5px;border-bottom:1px solid #ccc;"> Description </th>
										<th align="right" style="width:12%;vertical-align:bottom;padding:5px;border-left:1px solid #ccc;border-bottom:1px solid #ccc;"> Regular<br />Price </th>
										<th align="right" style="width:12%;vertical-align:bottom;padding:5px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;"> Discounted<br />Price </th>
										<th align="right" style="width:12%;vertical-align:bottom;padding:5px;border-bottom:1px solid #ccc;"> Extended<br />Price </th>
									</tr>
								</thead>

								<tbody>
									<tr><td colspan="8" style="height:20px;"> <td></tr>

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

												// get items options
												$options = $item->options ? json_decode($item->options, TRUE) : array();

												// set original price in case options['orig_price'] is not set
												// set $price
												$orig_price =
													@$options['orig_price']
													?: (
														$this->order_details->c == 'ws'
														? $product->wholesale_price
														: $product->retail_price
													)
												;
												$price = $item->unit_price;
												?>

									<tr style="font-family:sans-serif;font-size:10px;">

										<td align="center" style="vertical-align:top;"> <?php echo $item->qty; ?> </td>
										<td align="center" style="vertical-align:top;"> <?php echo @$item->shipped ?: '0'; ?> </td>
										<td align="center" style="vertical-align:top;"> <?php echo $item->qty; ?> </td>

										<?php
										/**********
										 * IMAGE and info
										 *
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
										</td>

										<?php
										/**********
										 * Description Size
										 */
										?>
										<td style="vertical-align:top;padding:0 5px 10px;">
											<?php echo 'Size: '.$item->size; ?>, <?php echo $item->color; ?>
											<?php echo $item->custom_order == '3' ? '<br /><em style="color:red;font-size:75%;">On Sale</em>' : ''; ?>
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
										<td align="right" style="vertical-align:top;padding:0 5px;">
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

									<tr style="font-family:sans-serif;font-size:10px;">
										<td colspan="5" rowspan="6" align="left" style="vertical-align:top;padding-left:5px;">
											Remarks/Instructions:<br /><br />
										</td>
										<td colspan="2" align="right" style="vertical-align:top;height:24px;"> Sub Total </td>
										<td align="right" style="vertical-align:top;height:24px;padding-right:5px;">
											<?php echo @$overall_total ? '$ '.number_format($overall_total, 2) : '$ 0.00'; ?>
										</td>
									</tr>

									<?php if (@$order_details->options['discount'])
									{
										$discount = $overall_total * ($order_details->options['discount'] / 100);
										?>

									<!-- Discount -->
									<tr style="font-family:sans-serif;font-size:10px;">
										<td colspan="2" align="right" style="vertical-align:top;height:24px;">
											Discount <?php echo @$order_details->options['discount'] ? '@'.$order_details->options['discount'].'%' : ''; ?>
										</td>
										<td align="right" style="vertical-align:top;height:24px;padding-right:5px;">
											($ <?php echo number_format($discount, 2); ?>)
										</td>
									</tr>

										<?php
									}
									else $discount = 0; ?>

									<tr style="font-family:sans-serif;font-size:10px;">
										<td colspan="2" align="right" style="vertical-align:top;height:24px;">
											Shipping &amp; Handling
											<?php
											if (@$order_details->shipping_fee === '0')
											{
												echo '<br /><cite style="font-size:75%;">(For countries other than United States, you will be contacted by customer service for shipping fees)</cite>';
											}
											?>
										</td>
										<td align="right" style="vertical-align:top;height:24px;padding-right:5px;">
											<?php echo @$order_details->shipping_fee != '0' ? '$ '.number_format($order_details->shipping_fee, 2) : '--'; ?>
										</td>
									</tr>

									<tr><td colspan="3" style="height:10px;border-bottom:1px solid #ccc;"> </td></tr>
									<tr><td colspan="3" style="height:10px;"> </td></tr>

									<tr style="font-family:sans-serif;font-size:10px;">
										<td colspan="2" align="right" style="vertical-align:top;height:24px;font-weight:bold;"> Grand Total </td>
										<td align="right" style="vertical-align:top;height:24px;font-weight:bold;padding-right:5px;">
											$ <?php echo @number_format((($overall_total - $discount) + $order_details->shipping_fee), 2); ?>
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
							/***********
							 * Footer
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:30px 0px 20px;">

								<tr>
									<td>
										<table width="630" align="center" style="border-top:1px solid #ccc;">
											<tr>
												<td width="630" align="center">
													<font color="#333333" style="font-family:sans-serif;font-size:10px;">
														<?php echo $this->webspace_details->name; ?>
														<?php echo $this->webspace_details->address1; ?>
														<?php echo $this->webspace_details->address2; ?>
														<br />EMAIL <a href="mailto:<?php echo $this->webspace_details->info_email; ?>"><?php echo $this->webspace_details->info_email; ?></a>
													</font>
												</td>
											</tr>
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
