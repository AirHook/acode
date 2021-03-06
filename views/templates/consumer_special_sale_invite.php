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
						 * Splash Header Image
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

                                            <?php
                                            // generalized accesslink
                                            $access_link =
                                                base_url()
                                                .'shop/womens_apparel.html?filter=&availability=onsale'
                                                .'&act='.time()
                                                .'&cs='.(@$user_id ?: '75806')
                                            ;
                                            ?>

											<a href="<?php echo $access_link; ?>" target="_blank">
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
						 * Single Column Text Row
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" style="padding: 30px 0; border-bottom: 1px solid #f2eeed;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="h2" style="color: #153643; font-family: sans-serif; padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;">
											Hello <?php echo @$username ?: 'Guest'; ?>
										</td>
									</tr>
									<tr>
										<td class="bodycopy" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
											The <?php echo strtoupper(@$designer) ?: 'SHOP 7TH AVENUE'; ?> special sale is open. Save big on fabulous evening and cocktail dresses for the upcoming holidays. 50% off on items.
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<!--
						/***********
						 * CONTENT BODY Row 2
						 * Double Column Article
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" style="padding: 0 0 30px; border-bottom: 1px solid #f2eeed;display:none;">
								<table width="300" align="left" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td style="padding: 0;">
											<a href="<?php echo $access_link; ?>" target="_blank">
												<img src="<?php echo base_url(); ?>assets/images/uploads/2018/01/evening-dresses.jpg" width="100%" border="0" alt="" />
											</a>
										</td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
									<table width="300" align="left" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td>
								<![endif]-->
								<table class="col280" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 280px;">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="bodycopy" align="center" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
														<h3 style="margin:5px 0 5px;">50% OFF<br />ENTIRE PURCHASE</h3>
														&nbsp;
													</td>
												</tr>
												<tr>
													<td style="padding: 10px 0 0;">
														<table class="buttonwrapper" align="center" bgcolor="red" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td class="button" height="45" style="text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;">
																	<a href="<?php echo $access_link; ?>" target="_blank" style="color: #ffffff; text-decoration: none;">
																		Shop Now!
																	</a>
																</td>
															</tr>
														</table>
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

						<!--
						/***********
						 * CONTENT BODY Row 3
						 * Single Column Image

						 There is an issue with images
						 Somohow, MSO uses the image actual size

						<tr>
							<td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px; border-bottom: 1px solid #f2eeed;">
								<img class="singlecolumnimage" src="<?php //echo base_url(); ?>images/map_ups_ground.gif" width="100%" border="0" alt="" style="height: auto;" />
							</td>
						</tr>
						 */
						-->

						<!--
						/***********
						 * CONTENT BODY Row 4
						 * Final Plain Text Row
						 */
						-->
						<tr>
							<td class="innerpadding borderbottom" style="padding: 0 30px 10px 30px; border-bottom: 1px solid #f2eeed; display:none;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="bodycopy" align="center" style="color: #153643; font-family: sans-serif; font-size: 14px; line-height: 22px;">
											230 West 38th Street | New York, NY 10018 | 1-212-840-0846
										</td>
									</tr>
								</table>

							</td>
						</tr>

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

                                            <span>Don't miss an email! Add us to your address book: <?php echo safe_mailto(@$this->webspace_details->info_email, @$this->webspace_details->info_email, array('style'=>'color:#aaa;')); ?></span>

                                            <br /><br />

                                            <a href="<?php echo @$emailtracker_id ? base_url().'link/unsubscribe.html?id='.$emailtracker_id : 'javascript:;'; ?>" target="_blank" style="color:#aaa;">
                                                UNSUBSCRIBE
                                            </a>

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
