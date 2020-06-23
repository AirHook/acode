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

	<img src="<?php echo base_url(); ?>assets/images/logo/logo-shop7thavenue.png" alt="logo" style="height:35px;" class="logo" />

	<br><br>
	<br><br>

	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td width="50%" style="vertical-align:bottom;padding-bottom:10px;text-align:left;">

				Sales Order Date: &nbsp; <?php echo $so_details->so_date; ?> <br />
				<hr style="width:80%;text-align:left;margin:5px;" />
				Sales Order Number: &nbsp; <?php echo $so_number; ?> <br />
				<hr style="width:80%;text-align:left;margin:5px;" />
				Customer Purchase Order Number (if any): &nbsp; <?php echo @$so_options['ref_cust_po_no']; ?> <br />
				<hr style="width:80%;text-align:left;margin:5px;" />
				Ship By Date: &nbsp; <?php echo $so_details->delivery_date; ?> <br />

			</td>
			<td width="50%" style="background-color:#e9edef;padding:20px 30px;">

					<strong> SHIP TO </strong>

					<br /><br />

					<?php echo @$store_details->store_name; ?> <br />
					<?php echo @$store_details->address1; ?> <br />
					<?php echo @$store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
					<?php echo @$store_details->city.', '.@$store_details->state.' '.@$store_details->zipcode; ?> <br />
					<?php echo @$store_details->country; ?> <br />
					<?php echo @$store_details->telephone; ?> <br />
					ATTN: <?php echo @$store_details->fname ? $store_details->fname.' '.@$store_details->lname : ''; ?> <?php echo @$store_details->email ? '('.$store_details->email.')': ''; ?>

			</td>
		</tr>
	</table>

	<br><br>

	Ship Method: &nbsp; <?php echo @$so_options['ship_via']; ?>

	<br><br>

	<table class="tbl1" cellpadding="0" cellspacing="0" border="1" style="width:100%;">
		<tr>
			<th width="35%" align="left" style="padding: 10px 0px 10px 5px;">ITEM ID</th>
			<th width="50%" align="left" style="padding: 10px 0px 10px 5px;">DESCRIPTION</th>
			<th width="15%" style="padding:10px 0px;">QUANTITY</th>
		</tr>

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
				$style_no = $item;
				$prod_no = $exp[0];
				$color_code = $exp[1];
				$temp_size_mode = 1; // default size mode

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

					// take any existing product's size mode
					$temp_size_mode = $product->size_mode;
				}
				else
				{
					$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
					$size_mode = $this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
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
			 * Item DI
			 */
			?>
			<td class="tbl1td" style="vertical-align:top;border:1px solid #ccc;height:24px;text-align:left;padding: 10px 5px;">

				Style No: &nbsp; <?php echo $item; ?><br />
				Product No: &nbsp; <?php echo $prod_no; ?><br />
				Color: &nbsp; <?php echo $color_name; ?><br />
				Size: &nbsp; <?php echo $s; ?><br />
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
							<img src="<?php echo $img_front_new; ?>" width="60" style="float:left;" />
						</td>
						<td style="vertical-align:top;">
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
					</tr>
				</table>
			</td>

			<?php
			/**********
			 * Quantity
			 */
			?>
			<td class="tbl1td" style="vertical-align:top;border:1px solid #ccc;height:24px;text-align:center;padding: 10px 5px;">
				<?php echo $qty[0]; ?>
			</td>

		</tr>

						<?php
					}

					$overall_qty += $this_size_qty;
					$overall_total += @$this_size_total;
				}

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
		www.<?php echo $this->webspace_details->site; ?>
	</div>

</body>
</html>
