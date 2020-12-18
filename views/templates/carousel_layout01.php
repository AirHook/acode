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
									Hello <?php echo $this->webspace_details->slug == 'tempoparis' ? '%recipient.store_name%' : '%recipient_name%'; ?>,
								</td>
							</tr>
							<tr>
								<td class="bodycopy" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
                                    <?php
                                    if (@$message)
                                    {
                                        echo $message;
                                    }
                                    else
                                    {
                                        echo 'Up to 70% Off On Special Occasion, Prom and Evening Dresses. You message will be placed here...';
                                    }
                                    ?>
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
                <?php if (@$products)
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
                                    if (@$products['mixed'])
                                    {
        								foreach($products['mixed'] as $item)
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

                                            //$access_link = base_url().'shop/basixblacklabel/womens_apparel/dresses.html?filter=&availability=onsale';
                                            $access_link = base_url().'sales_package/link/index/X/0/'.$tc.'.html?email=%recipient_email%&items_csv='.$items_csv['mixed'];
        									?>

        								<td align="center" style="width:33%;vertical-align:top;padding-bottom:10px;" data-item="<?php echo $item; ?>">

                                            <!-- BEGIN IMAGE -->
        									<a href="<?php echo @$access_link ?: $this->config->item('PROD_IMG_URL').'wholesale/signin.html'; ?>" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
        										<div id="spthumbdiv_<?php echo $item; ?>" class="fadehover" style="width:194px;height:auto;">
        											<img src="<?php echo $product->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $product->prod_no; ?>" title="<?php echo $product->prod_no; ?>" border="0" style="width:194px;height:auto;">
        										</div>
        									</a>
                                            <!-- END IMAGE -->

                                            <!-- BEGIN PRODUCT INFO -->
        									<div style="margin:3px 0 0;text-align:left;padding-left:7px;">
        										<span style="font-size:10px;">
                                                    <?php echo $product->prod_no.' ('.$product->color_name.')'; ?>
                                                </span>
                                                <?php if ($product->custom_order == '3')
                                                { ?>
                                                    <br />
                                                    <span style="font-size:10px;position:relative;top:-3px;text-decoration:line-through;">
            											<span style="position:relative;top:3px;">$ <?php echo number_format($product->retail_price, 2); ?></span>
            										</span>
                                                    <br />
            										<span style="font-size:10px;color:red;">
            											Now $ <?php echo number_format($product->retail_sale_price, 2); ?>
            										</span>
                                                    <?php
                                                }
                                                else
                                                { ?>
                                                    <br />
                                                    <span style="font-size:10px;position:relative;top:-3px;">
            											<span style="position:relative;top:3px;">$ <?php echo number_format($product->retail_price, 2); ?></span>
            										</span>
                                                    <?php
                                                } ?>
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
                }
                else
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
								$icol = 1; // count the number of columns
								//$irow = 1; // counter for number of rows
								$ii = 0; // items count
								for ($i = 1;$i <= 30;$i++)
								{
									if ($icol == 4)
									{
										$icol = 1;
										echo '</tr><tr>';
									}
									?>

								<td align="center" style="width:33%;vertical-align:top;padding-bottom:10px;" data-item="">

                                    <!-- BEGIN IMAGE -->
									<a href="javascript:;" style="text-decoration:none;margin:0;padding:0;color:inherit;display:inline-block;">
										<div id="spthumbdiv_<?php echo $i; ?>" class="fadehover" style="width:165px;height:auto;">
											<img src="<?php echo base_url(); ?>images/shop7-emblem.jpg" alt="Product Thumb" title="Product Thumb>" border="0" style="width:165px;height:auto;border:1px solid #ccc;">
										</div>
									</a>
                                    <!-- END IMAGE -->

                                    <!-- BEGIN PRODUCT INFO -->
									<div style="margin:3px 0 0;text-align:left;padding-left:7px;">
										<span style="font-size:10px;">
                                            PROD ITEM NO
                                        </span>
										<br />
										<span style="font-size:10px;text-decoration:line-through;position:relative;top:-3px;">
											<span style="position:relative;top:3px;">$ 100.00</span>
										</span>
                                        <br />
										<span style="font-size:10px;color:red;">
                                            <?php
                                            //$price = ceil($product->retail_price / 2);
                                            ?>
											Now $ 50.00
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
                                        <?php echo @$privacy_policy ?: 'Privacy Policy here...'; ?>
                                    </div>

                                    <br /><br />

                                </td>

							</tr>
                            <tr>
                                <td>
                                    <div class="unsubscribe">
                                        <br /><br />
                                        <br /><br />
                                        Do not want to receive emails. Please unsubscribe here.
                                    </div>
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
