<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Special Sale Email Invite</title>

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
    <body yahoo bgcolor="" style="margin: 10px 0 0;padding: 0; min-width: 100% !important;">

        <?php
        /***********
         * Open email tracker image
         <img src="<?php echo base_url(); ?>link/open.html?id=<?php echo @$emailtracker_id; ?>" alt="" />
         */
        ?>

        <table width="100%" bgcolor="" border="0" cellpadding="0" cellspacing="0">
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
					<table width="625" align="center" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<![endif]-->
					<table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 625px;">

						<!--
						/***********
						 * CONTENT BODY Row 1
						 * Single Column Text Row
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" style="padding: 30px 0; border-bottom: 1px solid #f2eeed;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="h2" style="color: #153643; font-family: sans-serif; padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;">
											Hello %recipient_name%,
										</td>
									</tr>
									<tr>
										<td class="bodycopy" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
											Up to 70% Off On Special Occasion, Prom and Evening Dresses.
										</td>
									</tr>
								</table>
							</td>
						</tr>

                        <!--
						/***********
						 * CONTENT BODY Row 2
						 * ON SALE Product Thumbs
						 */
						-->
                        <?php if (@$onsale_products)
                        { ?>
						<tr>
							<td class="" bgcolor="" style="padding-bottom:50px;">

								<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr bgcolor="white">
                                        <td align="center" colspan="3" style="padding-top:30px;font-family:Arial;font-size:12px;color:black;">
                                        </td>
                                    </tr>
									<tr bgcolor="white" style="">

                                            <?php
            								$icol = 1; // count the number of columns (5 for 5 thumbs per row)
            								//$irow = 1; // counter for number of rows upto 2 rows for 5 items each row
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

                                                    // this email template is for wholesale users only
                                                    // hence, wholesale user prices
                                                    $orig_price = @$product->wholesale_price ?: 0;
                                                    $price =
                                                        @$product->custom_order == '3'
                                                        ? (@$product->wholesale_price_clearance ?: 0)
                                                        : $orig_price
                                                    ;

                									// set image paths
                                                    // get style no
                                                    $style_no = $product->prod_no.'_'.$product->color_code;
                									// the new way relating records with media library
                									$new_pre_url =
                										$this->config->item('PROD_IMG_URL')
                										.$product->media_path
                										.$style_no
                									;
                									$img_front_new = $new_pre_url.'_f3.jpg';
                									$img_back_new = $new_pre_url.'_b3.jpg';
                									$img_side_new = $new_pre_url.'_s3.jpg';
                									$img_coloricon = $new_pre_url.'_c.jpg';

                									if ($icol == 4)
                									{
                										$icol = 1;
                										echo '</tr><tr>';
                									}

                                                    // we need to embed the $access_link direct on the <a> tag to be able to capture the
                                                    // %recipient_email% variable fro mailgun
                                                    $product_link =
                                                        base_url()
                                                        .'link/email.html?id='
                                                        .(@$emailtracker_id ?: 0)
                                                        .'&item='
                                                        .$style_no
                                                    ;
                                                    // set access link
                                            		$access_link = site_url(
                                            			'sales_package/link/index/'
                                            			.'X/' // --> supposedly sales_package_id for saved sa via Sales_package_sending.php
                                            			.@$this->wholesale_user_details->user_id.'/'
                                            			.$tc
                                            		);
                                                    $access_link = base_url().'shop/basixblacklabel/womens_apparel/dresses.html?filter=&availability=onsale'
                									?>

                								<td align="center" style="width:33%;vertical-align:top;padding-bottom:10px;" data-item="<?php echo $item; ?>">

                                                    <!-- BEGIN IMAGE -->
                									<a href="<?php echo base_url(); ?>sales_package/link/index/X/0/<?php echo $tc; ?>.html?email=%recipient_email%&items_csv=<?php echo $items_csv; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
                										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:194px;height:auto;">
                											<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" width="194" style="width:194px;height:auto;">
                										</div>
                									</a>
                                                    <!-- END IMAGE -->

                                                    <!-- BEGIN PRODUCT INFO -->
                									<div style="margin:3px 0 0;text-align:left;padding-left:7px;">
                										<span style="font-size:10px;">
                                                            <?php echo $product->prod_no; ?>
                                                        </span>
                										<br />
                                                        <span style="font-size:10px;">
                                                            <?php echo $product->color_name; ?>
                                                        </span>
                                                        <br />
                                                        <span style="font-size:10px;">
                                                            <span style="<?php echo $orig_price == $price ?: 'text-decoration:line-through;'; ?>">
                                                                $ <?php echo number_format($product->wholesale_price, 2); ?>
                                                            </span>
                                                            <?php if ($orig_price != $price)
                                                            { ?>
                                                            &nbsp;
                                                            <span style="color:red;">
                                                                $ <?php echo number_format($price, 2); ?>
                                                            </span>
                                                                <?php
                                                            } ?>
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

                								// let us finish the columns max colspan
                								for($icol; $icol <= 3; $icol++)
                								{
                									echo '<td style="width:33%;vertical-align:top;"></td>';
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
						 * FOOTER
						 */
						-->
						<tr>
							<td class="footer" style="padding: 20px 0;">

                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr bgcolor="">

										<td width="100%" height="92" align="center" style="font-family:Tahoma;font-size:8px;color:#aaa;vertical-align:top;">

                                            <hr style="border-top:1px solid black;border-bottom:none;"/>
                                            <br />

                                            <!--
                                            <span>Don't miss an email! Add us to your address book: <?php echo safe_mailto(@$this->webspace_details->info_email, @$this->webspace_details->info_email, array('style'=>'color:#aaa;')); ?></span>

                                            <br /><br />

                                            <a href="%tag_unsubscribe_url%" target="_blank" style="color:#aaa;">
                                                UNSUBSCRIBE
                                            </a>

                                            <br /><br />
                                            -->

                                            <style>
                                            .policy a {
                                                text-decoration: none;
                                                color: inherit;
                                            }
                                            </style>

                                            <div class="policy" style="widt:100%;text-align:left;">
                                                <?php echo @$privacy_policy; ?>
                                            </div>

                                            <br /><br />

									</td>

									</tr>
								</table>

							</td>
						</tr>

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
