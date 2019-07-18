<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>A Simple Responsive HTML Email</title>
		
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
			body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important; display: block!important;}
			
			/* Unsubscribe footer button only on mobile devices */
			body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
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
    <body yahoo bgcolor="#f6f8f1" style="margin: 0;padding: 0; min-width: 100% !important;">
	
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
					<?php
					/***********
					 * Overcoming the Lack of Max-Width Support
					 * Unfortunately, max-width is not supported by all email clients.
					 * we need to wrap each table in some conditional code which creates 
					 * a table with a set width to hold everything in.
					 */
					?>
					<!--[if (gte mso 9)|(IE)]>
					<table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<![endif]-->
					<table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 800px;">
					
						<?php
						/***********
						 * HEADER
						 */
						?>
                        <tr>
                            <td class="header" bgcolor="#c7d8a7" style="padding: 25px 0 20px 0;">
							
								<?php
								/***********
								 * Outlook will automatically stack your tables if there isn't at 
								 * least 25px to spare on any given row. Allow at least 25px of 
								 * breathing room to stop Outlook from stacking your tables.
								 */
								?>
								<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="center" style="padding: 0 20px 20px 20px;">
											<img src="<?php echo base_url(); ?>roden_assets/images/logo-instylenewyork.png" width="100%" border="0" alt="" style="max-width: 400px;" />
										</td>
										<tr>
											<td align="center" class="subhead" style="padding: 0 0 0 3px;font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;">
												SPECIAL OFFER
											</td>
										</tr>
									</tr>
								</table>

                            </td>
                        </tr>
						
						<?php
						/***********
						 * CONTENT BODY Row 1
						 * Single Column Text Row
						 */
						?>
						<tr>
							<td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px; border-bottom: 1px solid #f2eeed;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="h2" style="color: #153643; font-family: sans-serif; padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;">
											Welcome to our special offer for you!
										</td>
									</tr>
									<tr>
										<td class="bodycopy" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
											Thank you for visiting our site and your interests in our products.  You have last inquired about the dress below in the size you like.
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						<?php
						/***********
						 * CONTENT BODY Row 2
						 * Double Column Article
						 */
						?>
						<tr>
							<td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px; border-bottom: 1px solid #f2eeed;">
								<table width="140" align="left" border="0" cellpadding="0" cellspacing="0">  
									<tr>
										<td height="140" style="padding: 0 20px 20px 0;">
											<img src="http://products.instylenewyork.com/product_assets/WMANSAPREL/basixblacklabel/shorts/product_front/thumbs/SH5954_BLAC1_3.jpg" width="120" height="180" border="0" alt="" />
										</td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
									<table width="400" align="left" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td>
								<![endif]-->
								<table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 400px;">  
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="bodycopy" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
														SH5954<br /><br />
														Product description here<br />
														Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis.
													</td>
												</tr>
												<tr>
													<td style="padding: 20px 0 0 0;">
														<table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td class="button" height="45" style="text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;">
																	<a href="#" style="color: #ffffff; text-decoration: none;">
																		Claim yours!
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
						
						<?php
						/***********
						 * CONTENT BODY Row 3
						 * Single Column Image
						 
						 There is an issue with images
						 Somohow, MSO uses the image actual size
						 
						<tr>
							<td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px; border-bottom: 1px solid #f2eeed;">
								<img class="singlecolumnimage" src="<?php echo base_url(); ?>images/map_ups_ground.gif" width="100%" border="0" alt="" style="height: auto;" />
							</td>
						</tr>
						 */
						?>
						
						<?php
						/***********
						 * CONTENT BODY Row 4
						 * Final Plain Text Row
						 */
						?>
						<tr>
							<td class="innerpadding borderbottom" style="padding: 30px 30px 30px 30px; border-bottom: 1px solid #f2eeed;">
							
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td class="bodycopy" style="color: #153643; font-family: sans-serif; font-size: 16px; line-height: 22px;">
											We also have other items in the same dress size for you in special sale just for you
										</td>
									</tr>
									<tr>
										<td align="center" style="padding: 20px 0 0 0;">
											<table class="buttonwrapper" width="100%" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="button" height="45" style="text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;">
														<a href="#" style="display: block; color: #ffffff; text-decoration: none;">
															See and take advantage!
														</a>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>
						
						<?php
						/***********
						 * FOOTER
						 */
						?>
						<tr>
							<td class="footer" bgcolor="#44525f" style="padding: 20px 30px 25px 30px;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td align="center" class="footercopy" style="font-family: sans-serif; font-size: 14px; color: #ffffff;">
											&copy; Instylenewyork <?php echo date('Y', time()); ?><br/>
											
											<a href="#" class="unsubscribe" style="color: #ffffff; text-decoration: underline;">
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