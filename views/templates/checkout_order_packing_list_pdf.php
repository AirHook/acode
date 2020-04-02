<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Sales Order PDF</title>

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

		table.tbl1 {
			border-collapse: collapse;
		}
		table.tbl1, table.tbl1 td.tbl1td, table.tbl1 th {
			border: 1px solid #ccc;
		}
		table.tbl1 th {
			background-color: #e9edef;
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

	<img src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo $this->order_details->designer_slug; ?>.png" alt="logo" style="height:35px;" class="logo" />

	<br><br>
	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td width="50%" style="vertical-align:bottom;padding-bottom:10px;text-align:left;">

				Order Number: &nbsp; <?php echo $order_number; ?> <br />
				<hr style="width:80%;text-align:left;margin:5px;" />
				Order Date: &nbsp; <?php echo $order_date; ?> <br />

			</td>
			<td width="50%" style="background-color:#e9edef;padding:20px 30px;">

					<strong> SHIP TO </strong>

					<br /><br />

					<?php echo @$this->order_details->store_name ?: @$this->order_details->firstname.' '.@$this->order_details->lastname; ?> <br />
					<?php echo @$this->order_details->ship_address1; ?> <br />
					<?php echo @$this->order_details->ship_address2 ? $this->order_details->ship_address2.'<br />' : ''; ?>
					<?php echo @$this->order_details->ship_city.', '.@$this->order_details->ship_state.' '.@$this->order_details->ship_zipcode; ?> <br />
					<?php echo @$this->order_details->ship_country; ?> <br />
					<?php echo @$this->order_details->telephone ? '<br >T: '.$this->order_details->telephone : ''; ?> <br />
					ATTN: <?php echo @$this->order_details->firstname ? $this->order_details->firstname.' '.@$this->order_details->lastname : ''; ?> <?php echo @$this->order_details->email ? '('.$this->order_details->email.')': ''; ?>

			</td>
		</tr>
	</table>

	<br><br>

	Ship Method: &nbsp; <?php echo @$order_details->courier; ?>

	<br><br>

	<table class="tbl1" cellpadding="0" cellspacing="0" border="1" style="width:100%;">
		<tr>
			<th width="35%" align="left" style="padding: 10px 0px 10px 5px;">ITEM ID</th>
			<th width="50%" align="left" style="padding: 10px 0px 10px 5px;">DESCRIPTION</th>
			<th width="15%" style="padding:10px 0px;">QUANTITY</th>
		</tr>

		<?php
		if ( ! @empty($order_items))
		{
			$overall_qty = 0;
			$overall_total = 0;
			$i = 1;
			foreach ($order_items as $item)
			{
				// just a catch all error suppression
				if ( ! $item) continue;

				// get product details
				$exp = explode('_', $item->prod_sku);
				$product = $this->product_details->initialize(
					array(
						'tbl_product.prod_no' => $exp[0],
						'color_code' => $exp[1]
					)
				);

				// get size label
				$size = $item->size;
				$size_names = $this->size_names->get_size_names($product->size_mode);
				$size_label = array_search($size, $size_names);
				$exp = explode('_', $size_label);
				$size_suffix = $exp[1];
				?>

		<tr>

			<?php
			/**********
			 * Item DI
			 */
			?>
			<td class="tbl1td" style="vertical-align:top;border:1px solid #ccc;height:24px;text-align:left;padding: 10px 5px;">

				Style No: &nbsp; <?php echo $item->prod_sku; ?><br />
				Product No: &nbsp; <?php echo $item->prod_no; ?><br />
				Color: &nbsp; <?php echo $item->color; ?><br />
				Size: &nbsp; <?php echo $item->size; ?><br />
				<?php
				if (@$product->st_id)
				{
					$upcfg['st_id'] = $product->prod_no;
					$upcfg['st_id'] = $product->st_id;
					$upcfg['size_label'] = $size_label;
					$this->upc_barcodes->initialize($upcfg);
					echo 'UPC: &nbsp; '.$this->upc_barcodes->generate();
				} ?>

			</td>

			<?php
			/**********
			 * Description
			 */
			?>
			<td class="tbl1td" style="vertical-align:top;height:24px;text-align:left;padding: 10px 5px;">
				<table border="0">
					<tr>
						<td style="vertical-align:top;">
							<img src="<?php echo $this->config->item('PROD_IMG_URL').(str_replace('_f2', '_f3', $item->image)); ?>" width="60" style="float:left;" />
						</td>
						<td style="vertical-align:top;">
							<strong> <?php echo $item->prod_no; ?> </strong> <br />
							<span style="color:#999;">Style#: <?php echo $item->prod_sku; ?></span><br />
							Color: &nbsp; <?php echo $item->color; ?>
							<?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
							<?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
						</td>
					</tr>
				</table>
			</td>

			<?php
			/**********
			 * Quantity
			 */
			?>
			<td class="tbl1td" style="vertical-align:top;border:1px solid #ccc;height:24px;text-align:center;padding: 10px 5px;">
				<?php echo $item->qty; ?>
			</td>

		</tr>

						<?php

				$i++;
			}
		} ?>

	</table>

	<br><br>

	<table class="tbl1" cellpadding="0" cellspacing="0" border="1" style="width:100%;">
		<tr>
			<th align="left" style="padding:10px 5px;">RETURNS &amp; EXCHANGES</th>
		</tr>
	</table>

	<br>

	<table class="tbl1" cellpadding="0" cellspacing="0" border="1" style="width:100%;">
		<tr>
			<td align="left" style="border:1px solid #ccc;padding:10px 5px;">
				Returns &amp; Exchagnes text here...
			</th>
		</tr>
	</table>

	<br><br>
	<br><br>
	<br><br>

	<div style="text-align:center;">
		www.<?php echo $this->order_details->designer_slug; ?>.com
	</div>

</body>
</html>
