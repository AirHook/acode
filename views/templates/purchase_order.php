<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Purchase Order Confirmation Email</title>
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
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="625px" style="border-collapse: collapse;">
					<tr>
						<td>

							<?php
							/***********
							 * PO Letter Head
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin-top:30px;">
								<tr>
									<td>
										<strong style="font-size:12px;"> PURCHASE ORDER #<?php echo $po_details->po_number; ?> <?php echo $po_details->rev ? '<small><b>rev</b></small>'.$po_details->rev : ''; ?> </strong><br />
										<small> Date: <?php echo $po_details->po_date; ?> </small>

										<br><br>

										D&I Fashion Group <br />
										230 West 38th Street <br />
										New York, NY 10018 <br />
										United States <br />
										212.840.0846 <br />
									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td>

							<?php
							/***********
							 * PO Address Details
							 */
							?>
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;vertical-align:top;">
								<tr>
									<td width="50%" valign="top" style="vertical-align:top;">

										<strong> To (Vendor Details) </strong>

										<br /><br />

										<?php echo $vendor_details->vendor_name ?: 'VENDOR NAME'; ?> <br />
										<?php echo $vendor_details->address1 ?: '(vendor details here)'; ?> <br />
										<?php echo $vendor_details->address2 ? $vendor_details->address2.'<br />' : ''; ?>
										<?php echo $vendor_details->city ? $vendor_details->city.',' : ''; ?> <?php echo $vendor_details->state ?: ''; ?> <br />
										<?php echo $vendor_details->country ?: ''; ?> <br />
										<?php echo $vendor_details->telephone ?: ''; ?> <br />
										ATTN: <?php echo $vendor_details->contact_1; ?> <?php echo $vendor_details->vendor_email ? '('.$vendor_details->vendor_email.')' : ''; ?>

									</td>
									<td width="50%" valign="top" style="vertical-align:top;">

										<strong> Ship To </strong>

										<br /><br />

										<?php echo @$store_details->store_name ?: 'D&I Fashion Group'; ?> <br />
										<?php echo @$store_details->address1 ?: '230 West 38th Street'; ?> <br />
										<?php echo @$store_details->address2 ? @$store_details->address2.'<br />' : ''; ?>
										<?php echo @$store_details->city ? @$store_details->city.',': 'New York,'; ?> <?php echo @$store_details->state ?: 'NY'; ?> <?php echo @$store_details->zipcode ?: '10018'; ?> <br />
										<?php echo @$store_details->country ?: 'United States'; ?> <br />
										<?php echo @$store_details->telephone ?: '212.840.0846'; ?> <br />
										ATTN: <?php echo @$store_details->fname ? @$store_details->fname.' '.@$store_details->lname : 'Joe Taveras'; ?> <?php echo @$store_details->email ? '('.@$store_details->email.')' : '(help@shop7thavenue.com)'; ?>

									</td>
								</tr>
							</table>

							<br><br>

							<?php
							/***********
							 * Author
							 */
							?>
							<strong> Ordered by: </strong> <?php echo $po_details->author_name ?: ''; ?> <?php echo $po_details->author_email ? '('.$po_details->author_email.')' : ''; ?>

							<br><br>

							<?php
							/***********
							 * PO Conditions
							 */
							?>
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
								<tr>
									<td width="16.66%"> Start Date </td>
									<td width="16.66%"> Cancel Date </td>
									<td width="16.66%"> Delivery Date </td>
									<td width="16.66%"> Ship Via </td>
									<td width="16.66%"> FOB </td>
									<td width="16.66%"> Terms </td>
								</tr>
								<tr>
									<td style="border:1px solid #ccc;height:24px;"> <?php echo $po_options['start_date']; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;"> <?php echo $po_options['cancel_date']; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;"> <?php echo $po_details->delivery_date; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;"> <?php echo @$po_options['ship_via']; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;"> <?php echo @$po_options['fob']; ?>
									</td>
									<td style="border:1px solid #ccc;height:24px;"> <?php echo @$po_options['terms']; ?>
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
									<td width="18%" style="font-weight:bold;"> Items (<?php echo count($po_items); ?>) </td>
									<td width="50%" style="font-weight:bold;"> Size and Quantity </td>
									<td width="16%" align="right" style="font-weight:bold;"> Vendor Price </td>
									<td width="16%" align="right" style="font-weight:bold;"> Subtotal </td>
								</tr>

								<tr><td colspan="4" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
								<tr><td colspan="4" style="height:10px;"> <td></tr>

									<?php
									if ( ! @empty($po_items))
									{
										$overall_qty = 0;
										$overall_total = 0;
										$this_size_qty = 0;
										$i = 1;
										foreach ($po_items as $item => $size_qty)
										{
											// get product details
											$product = $this->product_details->initialize(
												array(
													'tbl_product.prod_no' => $item
												)
											);

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

											// set image paths
											// the new way relating records with media library
											$style_no = $product->prod_no.'_'.$product->color_code;
											$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';

											// and other items
											$color_name = $product->color_name;
											$size_mode = $product->size_mode;
											$vendor_price = @$size_qty['vendor_price'] ?: $product->vendor_price;
											?>

								<tr>

									<?php
									/**********
									 * IMAGE and info
									 */
									?>
									<td style="padding-bottom:20px;">
										<img src="<?php echo $img_front_new; ?>" width="60" /> <br />
										<strong> <?php echo $item; ?> </strong> <br />
										Color: &nbsp; <?php echo $color_name; ?>
									</td>

									<?php
									/**********
									 * Size and Qty
									 */
									?>
									<td>

										<table cellpadding="0" cellspacing="0" style="width:100%;">
											<tr>

												<?php if ($size_mode == 1)
												{
													for ($s=0;$s<23;$s=$s+2)
													{ ?>

												<td width="7.2%" style="font-size:8px;"> <?php echo $s; ?> </td>

														<?php
													}
												} ?>

												<td width="4.2%"></td>
												<td width="9.4%" align="right" style="font-size:8px;"> Total </td>

											</tr>
											<tr>

												<?php if ($size_mode == 1)
												{
													$this_size_qty = 0;
													for ($s=0;$s<23;$s=$s+2)
													{
														$size_label = 'size_'.$s;
														$s_qty =
															isset($size_qty[$size_label])
															? $size_qty[$size_label]
															: 0
														;
														$this_size_qty += $s_qty;
														?>

												<td style="border:1px solid #ccc;height:18px;font-size:8px;text-align:center;">
													<?php echo $s_qty ?: ''; ?>
												</td>

														<?php
													}
												} ?>

												<td align="center">=</td>
												<td align="right"> <?php echo $this_size_qty; ?> </td>

											</tr>
										</table>

									</td>

									<?php
									/**********
									 * Unit Vendor Price
									 */
									?>
									<td align="right">
										<?php
										$v_price = @$po_options['show_vendor_price'] == '1' ? $vendor_price : 0;
										?>
										$ <?php echo number_format($v_price, 2); ?>
									</td>

									<?php
									/**********
									 * Subtotal
									 */
									?>
									<td align="right">
										<?php
										$this_size_total = @$this_size_qty * $v_price;
										?>
										$ <?php echo number_format($this_size_total, 2); ?>
									</td>

								</tr>

											<?php
											$i++;
											$overall_qty += $this_size_qty;
											$overall_total += $this_size_total;
										}
									} ?>

								<tr><td colspan="4" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
								<tr><td colspan="4" style="height:20px;"> <td></tr>

								<tr>
									<td colspan="2" rowspan="2" align="left">
										<?php
										if($po_details->remarks)
										{
											echo 'Remarks/Instructions:<br /><br />';
											echo $po_details->remarks;
										}
										?>
									</td>
									<td colspan="1" align="right" style="height:24px;"> Quantity Total </td>
									<td width="16%" align="right" style="height:24px;"> <?php echo $overall_qty; ?> </td>
								</tr>

								<tr>
									<td colspan="1" align="right" style="height:24px;font-weight:bold;"> Order Grand Total </td>
									<td width="16%" align="right" style="height:24px;font-weight:bold;"> $ <?php echo @number_format($overall_total, 2); ?> </td>
								</tr>

							</table>

							<br><br>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
