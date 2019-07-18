<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Purchase Order Confirmation Email</title>

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

	<strong style="font-size:12px;"> SALES ORDER #<?php echo $so_details->so_number; ?> <?php echo $so_details->rev ? '<small><b>rev</b></small>'.$so_details->rev : ''; ?> </strong><br />
	<small> Date: <?php echo $so_details->so_date; ?> </small>

	<br><br>

	D&I Fashion Group <br />
	230 West 38th Street <br />
	New York, NY 10018 <br />
	United States <br />
	212.840.0846 <br />

	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;vertical-align:top;">
		<tr>
			<td width="50%">

				<strong> Bill To </strong>

				<br /><br />

				<?php echo $so_details->store_name ?: 'STORE NAME'; ?> <br />
				<?php echo $so_details->bill_address1 ?: 'Address1'; ?> <br />
				<?php echo $so_details->bill_address2 ? $so_details->bill_address2.'<br />' : ''; ?>
				<?php echo $so_details->bill_city ?: 'City'; ?>, <?php echo $so_details->bill_state ?: 'State'; ?> <?php echo $so_details->bill_zipcode ?: 'Zipcode' ?>  <br />
				<?php echo $so_details->bill_country ?: 'Country'; ?> <br />
				<?php echo $so_details->telephone ?: 'Telephone'; ?> <br />
				ATTN: <?php echo $so_details->firstname ? $so_details->firstname.' '.$so_details->lastname : 'Contact Name'; ?> <?php echo $so_details->email ? '('.safe_mailto($so_details->email).')': '(Email)'; ?>

			</td>
			<td width="50%">

				<strong> Ship To </strong>

				<br /><br />

				<?php echo $so_details->store_name ?: 'STORE NAME'; ?> <br />
				<?php echo $so_details->ship_address1 ?: $so_details->bill_address1; ?> <br />
				<?php echo $so_details->ship_address2 ? $so_details->ship_address2.'<br />' : ($so_details->bill_address2 ? $so_details->bill_address2.'<br />' : ''); ?>
				<?php echo $so_details->ship_city ?: $so_details->bill_city; ?>, <?php echo $so_details->ship_state ?: $so_details->bill_state; ?> <?php echo $so_details->ship_zipcode ?: $so_details->bill_zipcode; ?> <br />
				<?php echo $so_details->ship_country ?: $so_details->bill_country; ?> <br />
				<?php echo $so_details->telephone ?: 'Telephone'; ?> <br />
				ATTN: <?php echo $so_details->firstname ? $so_details->firstname.' '.$so_details->lastname : 'Contact Name'; ?> <?php echo $so_details->email ? '('.safe_mailto($so_details->email).')': '(Email)'; ?>

			</td>
		</tr>
	</table>

	<br><br>

	<strong>Ordered by:</strong> &nbsp;<?php echo $author->fname.' '.$author->lname ?: ''; ?> &nbsp; <cite class="small"><?php echo $author->email ? '('.$author->email.')' : ''; ?></cite>
	<br />
	<strong>Designer:</strong> &nbsp;<?php echo $so_details->designer ?: 'General Items'; ?>
	<br />
	<?php echo $so_details->vendor_name ? '<strong>Vendor:</strong> &nbsp;'.$so_details->vendor_name : '';?>

	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td width="25%"> Due Date </td>
			<td width="25%"> Shipping Method </td>
			<td width="25%"> Shipping Terms </td>
			<td width="25%"> Payment Terms </td>
		</tr>
		<tr>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_details->due_date; ?>
			</td>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['ship_via']; ?>
			</td>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['fob']; ?>
			</td>
			<td style="border:1px solid #ccc;height:24px;text-align:center;"> <?php echo @$so_options['terms']; ?>
			</td>
		</tr>
	</table>

	<br><br>

	<strong> Details: </strong>

	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;vertical-align:top;">

		<tr>
			<td width="18%" style="font-weight:bold;"> Items (<?php echo count($so_items); ?>) </td>
			<td width="50%" style="font-weight:bold;"> Size and Quantity </td>
			<td width="16%" align="right" style="font-weight:bold;"> Unit Price </td>
			<td width="16%" align="right" style="font-weight:bold;"> Extended </td>
		</tr>

		<tr><td colspan="4" style="height:10px;border-bottom:1px solid #ccc;"> <td></tr>
		<tr><td colspan="4" style="height:10px;"> <td></tr>

			<?php
			if ( ! @empty($so_items))
			{
				$overall_qty = 0;
				$overall_total = 0;
				$this_size_qty = 0;
				$i = 1;
				foreach ($so_items as $item => $size_qty)
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
					$size_names = $this->size_names->get_size_names($size_mode);
					?>

		<tr>

			<?php
			/**********
			 * IMAGE and info
			 */
			?>
			<td style="padding-bottom:20px;" class=" <?php echo $product->media_path.$style_no; ?> <?php echo $img_front_new; ?> ">
				<img src="<?php echo $img_front_new; ?>" width="60" /> <br />
				<strong> <?php echo $product->prod_no; ?> </strong> <br />
				<span style="color:#999;">Style#: <?php echo $item; ?></span><br />
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

						<?php
						foreach ($size_names as $size_label => $s)
						{
							if ($s != 'XL1' && $s != 'XL2')
							{
								?>

						<td width="7.69%" style="font-size:8px;"> <?php echo $s; ?> </td>

								<?php
							}
						} ?>

						<td width="7.69%" align="right"> Total </td>

					</tr>
					<tr>

						<?php
						$this_size_qty = 0;
						foreach ($size_names as $size_label => $s)
						{
							$s_qty =
								isset($size_qty[$size_label])
								? $size_qty[$size_label]
								: 0
							;
							$this_size_qty += $s_qty;

							if ($s != 'XL1' && $s != 'XL2')
							{ ?>

						<td style="border:1px solid #ccc;height:18px;font-size:8px;text-align:center;">
							<?php echo $s_qty ?: ''; ?>
						</td>

								<?php
							}
						} ?>

						<td align="right"> = <?php echo $this_size_qty; ?> </td>

					</tr>
				</table>

			</td>

			<?php
			/**********
			 * Unit Vendor Price
			 */
			?>
			<td align="right">
				$ <?php echo number_format($size_qty['wholesale_price'], 2); ?>
			</td>

			<?php
			/**********
			 * Subtotal
			 */
			?>
			<td align="right">
				<?php
				$this_size_total = @$this_size_qty * $size_qty['wholesale_price'];
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
			<td colspan="1" align="right" style="height:24px;font-weight:bold;"> Order Grand Total </td>
			<td width="16%" align="right" style="height:24px;font-weight:bold;"> $ <?php echo @number_format($overall_total, 2); ?> </td>
		</tr>

	</table>

	<br><br>

</body>
</html>
