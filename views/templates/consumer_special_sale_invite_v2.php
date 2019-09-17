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
    <body yahoo bgcolor="#f6f8f1" style="margin: 10px 0 0;padding: 0; min-width: 100% !important;">
	
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
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
						 * HEADER
						 */
						-->
                        <tr>
                            <td class="header" bgcolor="" style="padding: 0;">
							
								<!--
								/***********
								 * Outlook will automatically stack your tables if there isn\'t at 
								 * least 25px to spare on any given row. Allow at least 25px of 
								 * breathing room to stop Outlook from stacking your tables.
								 */
								-->
								<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="center" style="padding: 0;">
											<a href="<?php echo $link; ?>" target="_blank">
												<img src="<?php echo base_url(); ?>assets/images/uploads/2018/01/header-image.jpg" width="100%" border="0" alt="" />
											</a>
										</td>
									</tr>
								</table>

                            </td>
                        </tr>
						
						<!--
						/***********
						 * CONTENT BODY Row 1
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
                                            <!--span style="font-size:1.6em;color:red;">VIEW / ORDER OFF PRICE ITEMS</span -->
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

                									if ($icol == 4)
                									{
                										$icol = 1;
                										echo '</tr><tr bgcolor="white" style="">'; 
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
                								for($icol; $icol <= 3; $icol++)
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
						 * FOOTER
						 */
						-->
						<tr>
							<td class="footer" bgcolor="#44525f" style="padding: 20px 30px 25px 30px;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="center" class="footercopy" style="font-family: sans-serif; font-size: 14px; color: #ffffff;">
											&copy; Instylenewyork <?php echo @date('Y', @time()); ?><br/>
											
											<a href="<?php echo $unsublink; ?>" class="unsubscribe" style="color: #ffffff; text-decoration: underline;">
												<font color="#ffffff">Unsubscribe</font>
											</a>
											<span class="hide">from this newsletter instantly</span>

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