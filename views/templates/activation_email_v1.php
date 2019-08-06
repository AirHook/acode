<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Wholesale Activation Email</title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />

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

                                            <br />
                                            <span style="font-size:0.8em;line-height:24px;">
                                                Can't see the images in this email? &nbsp;
                                                <a href="<?php echo site_url('wholesale/activation_email/index/'.@$user_id); ?>" style="color:black;">
                                                    View in browser
                                                </a>
                                            </span>
                                            <br />

                                            <img src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo @$reference_designer ?: 'shop7thavenue'; ?>.png" width="300" style="margin-top:10px;margin-bottom:5px;" />

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
						 * Welcom test and user access details
						 */
						-->
						<tr>
							<td class="" bgcolor="#f9ece6" style="padding:10px;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr bgcolor="white">
										<td width="10">
											&nbsp;
										</td>
										<td width="630">

											<table width="630">
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
                                                        	<?php if ($this->config->item('site_slug') == 'tempoparis') { ?>
                                                        		Welcome to the wholesale order system for <?php echo $this->config->item('site_name'); ?><br />
                                                        	<?php } else { ?>
                                                        		<?php if ($this->config->item('site_slug') !== 'instylenewyork') { ?>
                                                        		Welcome to the new online order system for <?php echo @$designer ?: 'Basix Black Label'; ?>. <br />
                                                        		<?php } ?>
                                                        	<?php } ?>

                                                        	<br><br>

                                                        	To access the wholesale resource, click below:

                                                        	<br><br>

                                                        	<a href="https://www.<?php echo @$this->webspace_details->site; ?>/wholesale/signin.html">
                                                        		https://www.<?php echo @$this->webspace_details->site; ?>/wholesale/signin.html
                                                        	</a>

                                                        	<br><br>

                                                        	Username: <?php echo @$email ?: '<cite>email</cite>'; ?>
                                                        	<br>
                                                            <?php // must show password... ?>
                                                        	Password: <?php echo @$password ?: '*******'; ?>

                                                        	<br><br>

                                                        	For Login Assistance or Tech Support, call us at <?php echo @$designer_phone ?: '212.840.0846'; ?>

                                                        	<br><br>
                                                        	<br><br>
                                                        	<br><br>

                                                        	<?php echo @$sales_rep ?: 'Joe Taveras'; ?>

                                                        	<br><br>

                                                        	<?php echo @$designer ?: 'Shpop 7th Avenue'; ?> <br>
                                                        	<?php echo @$designer_address1 ?: '230 West 38th Street'; ?> <br>
                                                        	<?php echo @$designer_address2 ?: 'New York NY'; ?> <br>
                                                        	<?php echo @$designer_phone ?: '212.840.0846'; ?> <br>

                                                        	<br><br>

                                                        	<?php if (@$reference_designer != 'tempoparis') { ?>
                                                        	TERMS OF SALE
                                                        	<br><br>
                                                        	<span style="font-size:0.80em;">
                                                        		First order minimum 7 pieces of any style/color combination
                                                        		<br>
                                                        		After first order we send 1 by 1 as ordered
                                                        		<br>
                                                        		All production orders require 30% deposit to begin Balance prior to shipping
                                                        		<br>
                                                        		All production orders take 14 weeks to produce from date of deposit
                                                        	</span>
                                                        	<?php } ?>

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

                        <!--
						/***********
						 * CONTENT BODY Row 2
						 * IN STOCK Product Thumbs
						 */
						-->
                        <?php if (@$instock_products)
                        { ?>
						<tr>
							<td class="" bgcolor="" style="padding-top:40px;padding-bottom:50px;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr bgcolor="white">
                                        <td align="center" colspan="4" style="padding:30px 50px;font-family:Arial;font-size:12px;color:black;">
                                            <span style="font-size:1.6em;color:red;">VIEW / ORDER IN STOCK ITEMS</span>
                                        </td>
                                    </tr>
									<tr bgcolor="white" style="">

                                            <?php
            								// generalized accesslink
                                            $access_link =
                                                base_url()
                                                .'shop/womens_apparel.html?filter=&availability=instock'
                                                .'&act='.time()
                                                .'&ws='.(@$user_id ?: '6854')
                                            ;

            								$icol = 1; // count the number of columns (5 for 5 thumbs per row)
            								$irow = 1; // counter for number of rows upto 2 rows for 5 items each row
            								$ii = 0; // items count
                                            if (@$instock_products)
                                            {
                								foreach($instock_products as $item)
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

                									if ($icol == 5)
                									{
                										$icol = 1;
                										echo '</tr><tr>';
                									}
                									?>

                								<td align="center" style="vertical-align:top;padding-bottom:10px;" data-item="<?php echo $item; ?>">

                                                    <!-- BEGIN IMAGE -->
                									<a href="<?php echo @$access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html'; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
                										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:140px;height:210px;">
                											<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" width="140" style="width:140px;">
                										</div>
                									</a>
                                                    <!-- END IMAGE -->

                                                    <!-- BEGIN PRODUCT INFO -->
                									<div style="margin:3px 0 0;text-align:left;padding-left:13px;">
                										<img src="<?php echo ($product->primary_img ? $img_coloricon : $color_icon_pre.$color_icon); ?>" width="10" height="10">
                									</div>

                									<div style="text-align:left;padding-left:13px;">
                										<span style="font-size:10px;">
                                                            <?php echo $product->prod_no.' ('.$product->color_name.')'; ?>
                                                        </span>
                                                        <br />
                                                        <span style="font-size:10px;text-decoration:">
                											$ <?php echo number_format($product->wholesale_price, 2); ?>
                										</span>
                									</div>
                                                    <!-- END PRODUCT INFO -->

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

                								// let us finish the columns to 5 if less than 5 on the last item
                								for($icol; $icol <= 4; $icol++)
                								{
                									echo '<td style="vertical-align:top;"></td>';
                								}
                                            } ?>

									</tr>
								</table>

							</td>
						</tr>
                            <?php
                        } ?>

                        <!--
						/***********
						 * CONTENT BODY Row 3
						 * PRE ORDER Product Thumbs
						 */
						-->
                        <?php if (@$preorder_products)
                        { ?>
						<tr>
							<td class="" bgcolor="" style="padding-bottom:50px;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr bgcolor="white">
                                        <td align="center" colspan="4" style="padding:30px 50px;font-family:Arial;font-size:12px;color:black;">
                                            <span style="font-size:1.6em;color:red;">VIEW / ORDER PRE ORDER ITEMS</span>
                                        </td>
                                    </tr>
									<tr bgcolor="white" style="">

                                            <?php
                                            // generalized accesslink
                                            $access_link =
                                                base_url()
                                                .'shop/womens_apparel.html?filter=&availability=preorder'
                                                .'&act='.time()
                                                .'&ws='.(@$user_id ?: '6854')
                                            ;

            								$icol = 1; // count the number of columns (5 for 5 thumbs per row)
            								$irow = 1; // counter for number of rows upto 2 rows for 5 items each row
            								$ii = 0; // items count
                                            if (@$preorder_products)
                                            {
                								foreach($preorder_products as $item)
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

                									$options_array =
                										$this->session->sa_options
                										? json_decode($this->session->sa_options, TRUE)
                										: array()
                									;
                									$price = @$options_array['e_prices'][$item] ?: $product->wholesale_price;

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

                									if ($icol == 5)
                									{
                										$icol = 1;
                										echo '</tr><tr>';
                									}
                									?>

                								<td align="center" style="vertical-align:top;padding-bottom:10px;" data-item="<?php echo $item; ?>">

                                                    <!-- BEGIN IMAGE -->
                									<a href="<?php echo @$access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html'; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
                										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:140px;height:210px;">
                											<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" width="140" style="width:140px;">
                										</div>
                									</a>
                                                    <!-- END IMAGE -->

                                                    <!-- BEGIN PRODUCT INFO -->
                									<div style="margin:3px 0 0;text-align:left;padding-left:13px;">
                										<img src="<?php echo ($product->primary_img ? $img_coloricon : $color_icon_pre.$color_icon); ?>" width="10" height="10">
                									</div>

                									<div style="text-align:left;padding-left:13px;">
                										<span style="font-size:10px;">
                                                            <?php echo $product->prod_no.' ('.$product->color_name.')'; ?>
                                                        </span>
                										<br />
                                                        <span style="font-size:10px;text-decoration:">
                											$ <?php echo number_format($product->wholesale_price, 2); ?>
                										</span>
                									</div>
                                                    <!-- END PRODUCT INFO -->

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

                								// let us finish the columns to 5 if less than 5 on the last item
                								for($icol; $icol <= 4; $icol++)
                								{
                									echo '<td style="vertical-align:top;"></td>';
                								}
            								} ?>

									</tr>
								</table>

							</td>
						</tr>
                            <?php
                        } ?>

                        <!--
						/***********
						 * CONTENT BODY Row 4
						 * ON SALE Product Thumbs
						 */
						-->
                        <?php if (@$onsale_products)
                        { ?>
						<tr>
							<td class="" bgcolor="" style="padding-bottom:50px;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr bgcolor="white">
                                        <td align="center" colspan="4" style="padding:30px 50px;font-family:Arial;font-size:12px;color:black;">
                                            <span style="font-size:1.6em;color:red;">VIEW / ORDER OFF PRICE ITEMS</span>
                                        </td>
                                    </tr>
									<tr bgcolor="white" style="">

                                            <?php
                                            // generalized accesslink
                                            $access_link =
                                                base_url()
                                                .'shop/womens_apparel.html?filter=&availability=onsale'
                                                .'&act='.time()
                                                .'&ws='.(@$user_id ?: '6854')
                                            ;

            								$icol = 1; // count the number of columns (5 for 5 thumbs per row)
            								$irow = 1; // counter for number of rows upto 2 rows for 5 items each row
            								$ii = 0; // items count
                                            if (@$onsale_products)
                                            {
                								foreach($onsale_products as $item)
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

                									$options_array =
                										$this->session->sa_options
                										? json_decode($this->session->sa_options, TRUE)
                										: array()
                									;
                									$price = @$options_array['e_prices'][$item] ?: $product->wholesale_price;

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

                									if ($icol == 5)
                									{
                										$icol = 1;
                										echo '</tr><tr>';
                									}
                									?>

                								<td align="center" style="vertical-align:top;padding-bottom:10px;" data-item="<?php echo $item; ?>">

                                                    <!-- BEGIN IMAGE -->
                									<a href="<?php echo @$access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html'; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
                										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:140px;height:210px;">
                											<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" width="140" style="width:140px;">
                										</div>
                									</a>
                                                    <!-- END IMAGE -->

                                                    <!-- BEGIN PRODUCT INFO -->
                									<div style="margin:3px 0 0;text-align:left;padding-left:13px;">
                										<img src="<?php echo ($product->primary_img ? $img_coloricon : $color_icon_pre.$color_icon); ?>" width="10" height="10">
                									</div>

                									<div style="text-align:left;padding-left:13px;">
                										<span style="font-size:10px;">
                                                            <?php echo $product->prod_no.' ('.$product->color_name.')'; ?>
                                                        </span>
                										<br />
                										<span style="font-size:10px;text-decoration:line-through;position:relative;top:-3px;">
                											<span style="position:relative;top:3px;">$ <?php echo number_format($product->wholesale_price, 2); ?></span>
                										</span>
                                                        <br />
                										<span style="font-size:10px;color:red;">
                                                            <?php
                                                            $price = ceil($product->wholesale_price / 2);
                                                            ?>
                											Now $ <?php echo number_format($price, 2); ?>
                										</span>
                									</div>
                                                    <!-- END PRODUCT INFO -->

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

                								// let us finish the columns to 5 if less than 5 on the last item
                								for($icol; $icol <= 4; $icol++)
                								{
                									echo '<td style="vertical-align:top;"></td>';
                								}
            								} ?>

									</tr>
								</table>

							</td>
						</tr>
                            <?php
                        } ?>

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

                                            <span>Don't miss an email! Add us to your address book: <?php echo safe_mailto(@$this->webspace_details->info_email, @$this->webspace_details->info_email, array('style'=>'color:#aaa;')); ?></span>

                                            <br /><br />

                                            <a href="javascript:;" style="color:#aaa;">
                                                UNSUBSCRIBE
                                            </a>

                                            <br /><br />

                                            <div style="widt:100%;text-align:left;">
                                                <?php echo @$privacy_policy; ?>
                                            </div>

										</td>

									</tr>
								</table>

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
