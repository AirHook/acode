<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Sales Order Confirmation Email</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

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
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="625px" style="border-collapse:collapse;margin-top:30px;">
					<tr>
						<td>

							<?php
							/***********
							 * PO Letter Head
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin-bottom:10px;">
								<tr>
									<td>
										<strong> SALES ORDER #<?php echo $so_number; ?> </strong> <?php echo @$this->sales_order_details->rev ? '<small><b>rev</b></small><strong>'.@$this->sales_order_details->rev.'</strong>' : ''; ?> <br />
										<small> Date: <?php echo $so_date; ?> </small>

										<br><br>

									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td>

							<?php
							/***********
							 * SO Address Details
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;vertical-align:top;margin-bottom:10px;">
								<tr>
									<td width="50%" valign="top" style="vertical-align:top;">

										<strong> BILLING ADDRESS </strong>

										<br /><br />

										<?php echo $store_details->store_name; ?> <br />
										<?php echo $store_details->address1; ?> <br />
										<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
										<?php echo $store_details->city.', '.$store_details->state.' '.$store_details->zipcode; ?> <br />
										<?php echo $store_details->country; ?> <br />
										<?php echo $store_details->telephone; ?> <br />

									</td>
									<td width="50%" valign="top" style="vertical-align:top;">

										<strong> SHIPPING ADDRESS </strong>

										<br /><br />

										<?php echo $store_details->store_name; ?> <br />
										<?php echo $store_details->address1; ?> <br />
										<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
										<?php echo $store_details->city.', '.$store_details->state.' '.$store_details->zipcode; ?> <br />
										<?php echo $store_details->country; ?> <br />
										<?php echo $store_details->telephone; ?> <br />
										ATTN: <?php echo $store_details->fname ? $store_details->fname.' '.$store_details->lname : ''; ?> <?php echo $store_details->email ? '('.$store_details->email.')': ''; ?>

										<br><br>

									</td>
								</tr>
							</table>

							<br><br>

							<?php
							/***********
							 * Author
							 */
							?>
							<strong> Sales Person: </strong>  &nbsp;<?php echo $this->sales_order_details->author == '1' ? 'IN-HOUSE' : @$author->fname.' '.@$author->lname.' ('.@$author->email.')'; ?>

							<br><br>

							<?php
							/***********
							 * PO Conditions
							 */
							?>
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
								<tr>
									<td width="25%" style="font-size:0.8em;"> Ref Check Out Order# </td>
									<td colspan="3"></td>
								</tr>
								<tr>
									<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$this->sales_order_details->options['ref_checkout_no']; ?>
									</td>
									<td colspan="3"></td>
								</tr>
								<tr><td style="height:10px;"></td></tr>
								<tr>
									<td width="25%" style="font-size:0.8em;"> Ship By Date </td>
									<td width="25%" style="font-size:0.8em;"> Shipping Method </td>
									<td width="25%" style="font-size:0.8em;"> Shipping Terms </td>
									<td width="25%" style="font-size:0.8em;"> Payment Terms </td>
								</tr>
								<tr>
									<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo $this->sales_order_details->delivery_date; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$this->sales_order_details->options['ship_via']; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$this->sales_order_details->options['fob']; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$this->sales_order_details->options['terms']; ?>
									</td>
								</tr>
							</table>

							<br><br>

							<strong> Details: </strong>

							<br><br>

							<?php
							/***********
							 * PO Details
							 */
							?>
							<table cellpadding="0" cellspacing="0" style="width:100%;vertical-align:top;">

								<tr>
									<th colspan="3" align="center" style="border-right:1px solid #ccc;"> Quantities </th>
									<th colspan="6"></th>
								</tr>
								<tr>
									<th width="6%" align="left" style="font-weight:bold;vertical-align:top;"> Req'd </th>
									<th width="6%" align="left" style="font-weight:bold;vertical-align:top;"> Shi'd </th>
									<th width="6%" align="left" style="font-weight:bold;vertical-align:top;border-right:1px solid #ccc;"> B.O. </th>
									<th width="20%" align="left" style="font-weight:bold;vertical-align:top;padding-left:10px;"> Items </th>
									<th width="10%" align="left" style="font-weight:bold;vertical-align:top;"> Description </th>
									<td width="11%"></td>
									<th width="15%" align="right" style="font-weight:bold;vertical-align:top;"> Unit Price </th>
									<th width="12%" align="right" style="font-weight:bold;vertical-align:top;"> Dsic </th>
									<th width="12%" align="right" style="font-weight:bold;vertical-align:top;"> Extended </th>
								</tr>

								<tr><td colspan="9" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
								<tr><td colspan="9" style="height:10px;"> <td></tr>

									<?php
									if ( ! @empty($so_items))
									{
										$overall_qty = 0;
										$overall_total = 0;
										$i = 1;
										foreach ($so_items as $item => $size_qty)
										{
											// just a catch all error suppression
											if ( ! $item) continue;

											// get product details
											$exp = explode('_', $item);
											$product = $this->product_details->initialize(
												array(
													'tbl_product.prod_no' => $exp[0],
													'color_code' => $exp[1]
												)
											);

											// set image paths
											// the new way relating records with media library
											$style_no = $item;
											$prod_no = $exp[0];
											$color_code = $exp[1];

											// take any existing product's size mode
											// '1' for default size mode
											$temp_size_mode = @$designer_details->webspace_options['size_mode'] ?: '1';

											// price can be...
											// onsale price (retail_sale_price or wholesale_price_clearance)
											// regular price (retail_price or wholesale_price)
											if (@$product->custom_order == '3')
											{
												$price =
													$this->session->admin_so_user_cat == 'ws'
													? (@$product->wholesale_price_clearance ?: 0)
													: (@$product->retail_sale_price ?: 0)
												;
											}
											else
											{
												$price =
													$this->session->admin_so_user_cat == 'ws'
													? (@$product->wholesale_price ?: 0)
													: (@$product->retail_price ?: 0)
												;
											}

											if ($product)
											{
												$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
												$size_mode = $product->size_mode;
												$color_name = $product->color_name;
											}
											else
											{
												$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
												$size_mode = $designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
												$color_name = $this->product_details->get_color_name($color_code);
											}

											// get size names
											$size_names = $this->size_names->get_size_names($size_mode);
											foreach ($size_qty as $size_label => $qty)
											{
												if ($size_label == 'discount') continue;

												$this_size_qty = $qty[0];
												$s = $size_names[$size_label];

												// calculate stocks
												// and check for on sale items
												if ($product)
												{
													if ($product->$size_label == '0')
													{
														$preorder = TRUE;
														$partial_stock = FALSE;
													}
													elseif ($qty[0] <= $product->$size_label)
													{
														$preorder = FALSE;
														$partial_stock = FALSE;
													}
													elseif ($qty[0] > $product->$size_label)
													{
														$preorder = TRUE;
														$partial_stock = TRUE;
													}
													else
													{
														$preorder = FALSE;
														$partial_stock = FALSE;
													}
													$onsale =
														$product->custom_order == '3'
														? TRUE
														: FALSE
													;
												}
												else
												{
													// item not in product list
													$preorder = FALSE;
													$partial_stock = FALSE;
													$onsale = FALSE;
												}

												if (
													isset($size_qty[$size_label])
													&& $s != 'XL1' && $s != 'XL2'
												)
												{
											?>

								<tr>

									<?php
									/**********
									 * Quantities
									 */
									?>
									<td style="vertical-align:top;"><?php echo $qty[0]; ?></td>
									<td style="vertical-align:top;"><?php echo $qty[1]; ?></td>
									<td style="vertical-align:top;border-right:1px solid #ccc;"><?php echo $qty[2]; ?></td>

									<?php
									/**********
									 * Item Number
									 */
									?>
									<td style="vertical-align:top;padding-left:10px;">
										<?php echo $prod_no; ?><br />
										<?php echo $color_name; ?><br />
										<?php echo 'Size '.$s; ?>
									</td>

									<?php
									/**********
									 * Image
									 */
									?>
									<td style="vertical-align:top;padding-bottom:10px;">
										<img src="<?php echo $img_front_new; ?>" width="60" style="float:left;" />
									</td>

									<?php
									/**********
									 * Description
									 */
									?>
									<td style="vertical-align:top" class="<?php echo $img_front_new; ?> ">
										<strong> <?php echo $prod_no; ?> </strong> <br />
										<span style="color:#999;">Style#: <?php echo $item; ?></span><br />
										Color: &nbsp; <?php echo $color_name; ?>
										<?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
										<?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
										<br />
										<?php if ($onsale) { ?>
										<span class="badge bg-red-mint badge-roundless display-block"> On Sale </span>
										<?php } ?>
										<?php if ($preorder) { ?>
										<span class="badge badge-danger badge-roundless display-block"> Pre Order </span>
										<?php } ?>
										<?php if ($partial_stock) { ?>
										<span class="badge badge-warning badge-roundless display-block"> Parial Stock </span>
										<?php } ?>
									</td>

									<?php
									/**********
									 * Unit Price
									 */
									?>
									<td align="right" style="vertical-align:top;">
										$ <?php echo number_format($price, 2); ?>
									</td>

									<?php
									/**********
									 * Discount
									 */
									?>
									<td align="right" style="vertical-align:top;">
										<?php
										$disc = @$size_qty['discount'] ?: 0;
										if ($disc == '0') echo '-';
										else echo number_format($disc, 2);
										?>
									</td>

									<?php
									/**********
									 * Subtotal
									 */
									?>
									<td align="right" style="vertical-align:top;">
										<?php
										$this_size_total = $this_size_qty * ($price - $disc);
										?>
										$ <?php echo number_format($this_size_total, 2); ?>
									</td>

								</tr>

													<?php
												}

												$overall_qty += $this_size_qty;
												$overall_total += $this_size_total;
											}

											$i++;
										}
									} ?>

								<tr><td colspan="9" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
								<tr><td colspan="9" style="height:20px;"> <td></tr>

								<tr>
									<td colspan="7" rowspan="4" align="left" style="vertical-align:top;">
										<?php
										if($so_details->remarks)
										{
											echo 'Remarks/Instructions:<br /><br />';
											echo $so_details->remarks;
										}
										?>
									</td>
									<td colspan="1" align="right" style="height:24px;"> Quantity Total </td>
									<td width="16%" align="right" style="height:24px;"> <?php echo $overall_qty; ?> </td>
								</tr>

								<tr>
									<td colspan="1" align="right" style="height:24px;"> Order Total </td>
									<td width="16%" align="right" style="height:24px;"> $ <?php echo @number_format($overall_total, 2); ?> </td>
								</tr>

								<tr>
									<td colspan="1" align="right" style="height:24px;"> Tax Due </td>
									<td width="16%" align="right" style="height:24px;;">
										<?php
										$fed_tax_id =
											is_numeric(@$store_details->fed_tax_id)
											? floatval(@$store_details->fed_tax_id)
											: 0
										;
										$tax_due =
											$fed_tax_id
											? '$ '.number_format($fed_tax_id, 2)
											: '-'
										;
										echo $tax_due;
										?>
									</td>
								</tr>

								<tr>
									<td colspan="1" align="right" style="height:24px;font-weight:bold;"> Order Grand Total </td>
									<td width="16%" align="right" style="height:24px;font-weight:bold;">
										<?php
										$grand_total =
											$fed_tax_id
											? $overall_total * $fed_tax_id
											: $overall_total
										;
										echo '$ '.number_format($grand_total, 2);
										?>
									</td>
								</tr>

							</table>

							<br><br>

						</td>
					</tr>

					<tr>
						<td style="padding-top:30px;">
							Regards,<br />
							<?php echo $this->webspace_details->name; ?><br />
							<?php echo $this->webspace_details->address1; ?><br />
							<?php echo $this->webspace_details->address2 ? $this->webspace_details->address2.'<br />' : ''; ?>
							<?php echo $this->webspace_details->city.', '.$this->webspace_details->state.' '.$this->webspace_details->zipcode; ?><br />
							<?php echo $this->webspace_details->country; ?><br />
							<?php echo $this->webspace_details->phone; ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
