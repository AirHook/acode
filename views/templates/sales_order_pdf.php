<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Sales Order Confirmation Email</title>

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

	<br>

	<strong style="font-size:12px;"> SALES ORDER INVOICE#<?php echo $so_number; ?> <?php echo @$so_details->rev ? '<small><b>rev</b></small>'.$so_details->rev : ''; ?> </strong><br />
	<small> Date: <?php echo @$so_details->so_date ?: $so_date; ?> </small>

	<br><br>

	<?php echo $company_name; ?> <br />
	<?php echo $company_address1; ?><br />
	<?php echo $company_address2 ? $company_address2.'<br />' : ''; ?>
	<?php echo $company_city.', '.$company_state.' '.$company_zipcode; ?><br />
	<?php echo $company_country; ?><br />
	<?php echo $company_telephone; ?>

	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;vertical-align:top;">
		<tr>
			<td width="50%">

				<strong> BILLING ADDRESS </strong>

				<br /><br />

				<?php echo $store_details->store_name; ?> <br />
				<?php echo $store_details->address1; ?> <br />
				<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
				<?php echo $store_details->city.', '.$store_details->state.' '.$store_details->zipcode; ?> <br />
				<?php echo $store_details->country; ?> <br />
				<?php echo $store_details->telephone; ?> <br />

			</td>
			<td width="50%">

				<strong> SHIPING ADDRESS </strong>

				<br /><br />

				<?php echo $store_details->store_name; ?> <br />
				<?php echo $store_details->address1; ?> <br />
				<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
				<?php echo $store_details->city.', '.$store_details->state.' '.$store_details->zipcode; ?> <br />
				<?php echo $store_details->country; ?> <br />
				<?php echo $store_details->telephone; ?> <br />
				ATTN: <?php echo $store_details->fname ? $store_details->fname.' '.$store_details->lname : ''; ?> <?php echo $store_details->email ? '('.$store_details->email.')': ''; ?>

			</td>
		</tr>
	</table>

	<br><br>

	<span style="font-size:0.8em;">Sales Person:</span> &nbsp;<?php echo $this->session->admin_loggedin ? 'IN-HOUSE' : @$author->fname.' '.@$author->lname.' &nbsp;('.@$author->email.')'; ?>

	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td width="33%" style="font-size:0.8em;"> Shipping Method </td>
			<td width="33%" style="font-size:0.8em;"> Shipping Terms </td>
			<td width="33%" style="font-size:0.8em;"> Payment Terms </td>
		</tr>
		<tr>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['ship_via']; ?>
			</td>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['fob']; ?>
			</td>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['terms']; ?>
			</td>
		</tr>
		<tr>
			<td width="33%" style="font-size:0.8em;"> Purchase Order Reference </td>
			<td width="33%" style="font-size:0.8em;"> Order Date </td>
			<td width="33%" style="font-size:0.8em;"> Our Order </td>
		</tr>
		<tr>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['reference_po']; ?>
			</td>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['reference_po_date']; ?>
			</td>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['our_order']; ?>
			</td>
		</tr>
	</table>

	<br><br>

	<strong> Details: </strong>

	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;vertical-align:top;">

		<tr>
			<th style="8%" align="left"> Qty<br />Req'd </th>
			<th style="8%" align="left"> Qty<br />Ship'd </th>
			<th style="8%" align="left"> B.O. </th>
			<td width="18%" style="font-weight:bold;"> Items </td>
			<td width="11%" style="font-weight:bold;"> Description </td>
			<td width="23%"></td>
			<td width="12%" align="right" style="font-weight:bold;"> Unit Price </td>
			<td width="12%" align="right" style="font-weight:bold;"> Extended </td>
		</tr>

		<tr><td colspan="8" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
		<tr><td colspan="8" style="height:10px;"> <td></tr>

			<?php
			if ( ! @empty($so_items))
			{
				$overall_qty = 0;
				$overall_total = 0;
				//$this_size_qty = 0;
				$i = 1;
				foreach ($so_items as $item => $size_qty)
				{
					// get product details
					$exp = explode('_', $item);
					$product = $this->product_details->initialize(
						array(
							'tbl_product.prod_no' => $exp[0],
							'color_code' => $exp[1]
						)
					);

					// this is like a catch all error...
					//if ( ! $product) continue;

					// set image paths
					// the new way relating records with media library
					$style_no = $product->prod_no.'_'.$product->color_code;
					$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';

					// and other items
					$color_name = $product->color_name;
					$size_mode = $product->size_mode;
					$vendor_price = @$size_qty['vendor_price'] ?: $product->vendor_price;
					$size_names = $this->size_names->get_size_names($size_mode);

					$this_size_qty = 0;
					foreach ($size_qty as $size_label => $qty)
					{
						$this_size_qty += $qty;
						$s = $size_names[$size_label];

						if (
							isset($so_items[$item][$size_label])
							&& $s != 'XXL' && $s != 'XL1' && $s != 'XL2' && $s != '22'
						)
						{
							?>

		<tr>

			<?php
			/**********
			 * Quantities
			 */
			?>
			<td style="vertical-align:top;"><?php echo $qty; ?></td>
			<td style="vertical-align:top;"><?php echo $qty; ?></td>
			<td style="vertical-align:top;">0</td>

			<?php
			/**********
			 * Item Number
			 */
			?>
			<td style="vertical-align:top;">
				<?php echo $item; ?><br />
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
			<td style="vertical-align:top" class=" <?php echo $product->media_path.$style_no; ?> <?php echo $img_front_new; ?> ">
				<strong> <?php echo $product->prod_no; ?> </strong> <br />
				<span style="color:#999;">Style#: <?php echo $item; ?></span><br />
				Color: &nbsp; <?php echo $color_name; ?>
				<?php echo @$product->category_names ? '<br /><cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
			</td>

			<?php
			/**********
			 * Unit Price
			 */
			?>
			<td align="right">
				$ <?php echo number_format(@$product->wholesale_price, 2); ?>
			</td>

			<?php
			/**********
			 * Subtotal
			 */
			?>
			<td align="right">
				<?php
				$this_size_total = @$this_size_qty * @$product->wholesale_price;
				?>
				$ <?php echo number_format($this_size_total, 2); ?>
			</td>

		</tr>

							<?php
						}
					}

					$i++;
					$overall_qty += $this_size_qty;
					$overall_total += $this_size_total;
				}
			} ?>

		<tr><td colspan="8" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
		<tr><td colspan="8" style="height:20px;"> <td></tr>

		<tr>
			<td colspan="5" rowspan="4" align="left">
				<?php
				if(@$so_details->remarks)
				{
					echo 'Remarks/Instructions:<br /><br />';
					echo $so_details->remarks;
				}
				else
				{
					echo $remarks ? 'Remarks/Instructions:<br /><br />'.$remarks : '';
				}
				?>
			</td>
			<td colspan="2" align="right" style="height:24px;"> Quantity Total </td>
			<td width="16%" align="right" style="height:24px;"> <?php echo $overall_qty; ?> </td>
		</tr>

		<tr>
			<td colspan="2" align="right" style="height:24px;"> Order Total </td>
			<td width="16%" align="right" style="height:24px;;"> $ <?php echo @number_format($overall_total, 2); ?> </td>
		</tr>

		<tr>
			<td colspan="2" align="right" style="height:24px;"> Tax Due </td>
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
			<td colspan="2" align="right" style="height:24px;font-weight:bold;"> Order Grand Total </td>
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

</body>
</html>
