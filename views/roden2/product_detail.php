					<?php
					/**********
					 * This is a roden (bhldn) product details page which no longer used on roden theme
					 *
					 * Let us first set the images
					 */
					//$get_color_list = $this->query_category->get_available_colors($this->product_details->prod_no);
					$get_color_list = $this->product_details->available_colors();
					
					if ($this->product_details->color_name == '')
					{
						$color_code = $this->product_details->primary_img_id;
					}
					else
					{
						$color_code = $this->product_details->color_code;
					}
					
					$img_path 			= 'product_assets/'.$this->product_details->c_folder.'/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/';
					$img_name 			= $this->product_details->prod_no.'_'.$color_code;
					
					// for testing purposes
					/*
					if (ENVIRONMENT == 'development')
					{
						$PROD_IMG_URL = base_url();
						$img_path = 'images/';
					}
					else $PROD_IMG_URL = PROD_IMG_URL;
					*/
					$PROD_IMG_URL = $this->config->item('PROD_IMG_URL');
					
					$img_large			= $PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg';
					$img_thumb			= $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_3.jpg';

					$img_inquiry		= $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_1.jpg';
					
					$img_front			= $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_2.jpg';
					$img_side			= $PROD_IMG_URL.$img_path.'product_side/thumbs/'.$img_name.'_2.jpg';
					$img_back			= $PROD_IMG_URL.$img_path.'product_back/thumbs/'.$img_name.'_2.jpg';
					
					$img_front_thumb	= $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_4.jpg';
					$img_side_thumb		= $PROD_IMG_URL.$img_path.'product_side/thumbs/'.$img_name.'_4.jpg';
					$img_back_thumb		= $PROD_IMG_URL.$img_path.'product_back/thumbs/'.$img_name.'_4.jpg';

					$img_front_large	= $PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg';
					$img_side_large		= $PROD_IMG_URL.$img_path.'product_side/'.$img_name.'.jpg';
					$img_back_large		= $PROD_IMG_URL.$img_path.'product_back/'.$img_name.'.jpg';
					
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
					
						<div id="main" class="content-grid  clearfix" role="main" data-view-pane="<?php echo $view_pane ?: 'normal'; ?>">
                        
							<?php
							/**********
							 * How to order content
							 */
							 
							// this holds the how to order form that is usually a popup on dektop view
							// this how to order page view shows on mobile instead of a popup
							
							if ($view_pane === 'how_to_order'):
							?>
							
							<div id="non-modal-how-to-order" class="col">
								
								<section class="equal-height-section">
									<div class="" style="float:left;width:50%;">
										<img alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_thumb; ?>" />
									</div>
									<div class="" style="float:right;width:50%;">
										<div class="product-heading  product-heading--only-mobile" style="margin-left:20px;">
										
											<?php echo $this->session->flashdata('flashMsg'); ?>
											
											<h1 class="prod_info_title" style="color:#666;font-size:1.125rem;"><?php echo $this->product_details->prod_no; ?></h1>
											<h3 class="prod_info_title" style="font-weight:normal;"><?php echo strtoupper($this->product_details->prod_name); ?></h3>
											<br />			
											<br />
										</div>
									</div>
									<div style="clear:both;"></div>
								</section>
							
								<section class="equal-height-section" style="padding-bottom:40px;">
			
									<div class="v-login-form section">
										<div class="header-subtext header-subtext--with-border center">
											<h4>Product Inquiry</h4>
										</div>
										
										<?php if ($this->session->flashdata('flashMsg')): ?>
										<div class="center" style="background:pink;padding:20px;">
											<?php echo $this->session->flashdata('flashMsg'); ?>
										</div>
										<?php endif; ?>
										
										<?php
										/*
										| --------------------------------------------------------------------------------
										| Some snipets to help prevent spam bots from spamming the form
										| $the_spinner makes the fields of the form hashed and sorta randomized every second of the day
										| Used a honeypot to identify bot spammers
										*/
										$the_spinner = time().'#'.$this->session->userdata('ip_address').'#'.$this->config->item('site_domain').'#'.$this->config->item('a_secret_1');
										?>
										
										<!--bof form===========================================================================-->
										<?php
										// --------------------------------------
										// Login area
										echo form_open('about_product/inquiry', array('onsubmit' => 'return check()'));
										echo form_hidden('site_referrer', $this->config->item('site_domain'));
										?>
										
											<input type="hidden" name="<?php echo md5('the_spinner'); ?>" value="<?php echo md5($the_spinner); ?>" />
											<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_time'); ?>" value="<?php echo time(); ?>" />
											<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_return_url'); ?>" value="<?php echo site_url($this->uri->uri_string()); ?>" />
											<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_prod_no'); ?>" value="<?php echo $this->product_details->prod_no; ?>" />
											<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_color_code'); ?>" value="<?php echo $this->product_details->color_code; ?>" />
											
											<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_image'); ?>" value="<?php echo $img_thumb; ?>" />
											
											<div class="v-login-fields clearfix">
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">
										
														<li class="pairing-username pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary" for="vLogin-fields-username-1">
																<span class="required">*</span>
																<span class="pairing-label">Name</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<input type="text" class="input-text" required="required" id="<?php echo md5(md5($the_spinner).'the_name'); ?>" name="<?php echo md5(md5($the_spinner).'the_name'); ?>" value="" />
																</div>
															</div>
														</li>
										
														<li class="pairing-username pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary" for="vLogin-fields-username-1">
																<span class="required">*</span>
																<span class="pairing-label">Dress Size</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<input type="text" class="input-text" required="required" id="<?php echo md5(md5($the_spinner).'the_dress_size'); ?>" name="<?php echo md5(md5($the_spinner).'the_dress_size'); ?>" value="" />
																</div>
															</div>
														</li>
										
														<li class="pairing-username pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary" for="vLogin-fields-username-1">
																<span class="required">*</span>
																<span class="pairing-label">Email</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<input type="email" class="input-text" required="required" id="<?php echo md5(md5($the_spinner).'the_email'); ?>" name="<?php echo md5(md5($the_spinner).'the_email'); ?>" value="" />
																</div>
															</div>
														</li>
										
														<li class="pairing-password pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary" for="vLogin-fields-password-1">
																<span class="required">*</span>
																<span class="pairing-label">User Type</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<input type="radio" class="input-radio" required="required" id="<?php echo md5(md5($the_spinner).'the_email'); ?>" name="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" value="Store" /> &nbsp; I am a Store
																	<br />
																	<em style="color:red;">(You will be taken to fill out wholesale form for verification)</em>
																	<br />
																	<input type="radio" class="input-radio" required="required" id="<?php echo md5(md5($the_spinner).'the_email'); ?>" name="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" value="Consumer" /> &nbsp; I am a Consumer
																	<br />
																	<em style="color:red;">(You will be taken to intylenewyork.com our shop site)</em>
																</div>
															</div>
														</li>
														
														<li class="pairing-username pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary" for="vLogin-fields-username-1">
																<span class="pairing-label">Message or Comments</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<textarea class="input-textarea" name="<?php echo md5(md5($the_spinner).'the_message'); ?>" id="<?php echo md5(md5($the_spinner).'the_message'); ?>" style="width:100%;padding:10px;"></textarea>
																</div>
															</div>
														</li>
										
													</ul>
												</div>
											</div>

											<button type="submit" class="button button--large button--center button--<?php echo $this->config->item('site_slug'); ?>" style="width:300px;">Send Inquiry</button>
											
										<?php echo form_close(); ?>
										<!--eof form===========================================================================-->
										
									</div>
									
									<p class="reqmsg">*<span class="screenreaderonly"> indicates </span> Required</p>

								</section>
							</div>
							
							<?php
							else:
							
							/**********
							 * Product Details Content
							 */
							 
							// the div with class "pdp" holds the entire product details page
							// there must be a script that generates the left column main image
							// i'm asking becuase the next div with class "produc product-main..."
							// is already the right info section
							?>
							
							<?php
							/**********
							 * MAIN Image
							 */
							?>
							<div id="product_details_content" class="pdp has-fitguide js-set-height  v-product-detailpagetemplate clearfix" data-style-number="<?php echo $this->product_details->prod_no; ?>">
							
								<?php
								/**********
								 * Right side info column
								 */
								?>
								<div class="product product-main product-main-1" itemscope itemtype="" style="min-height:637.5px;">
			
									<div class="info-main">
										<div class="col">
											
										</div>
									</div>
			
									<?php
									/**********
									 * Product Name and other info
									 */
									?>
									<div class="v-product-detailinfo">
									
										<?php
										/**********
										 * Taken from default theme
										 */
										?>
										<div class="product-heading  product-heading--only-mobile  center">
										
											<?php echo $this->session->flashdata('flashMsg'); ?>
											
											<h1 class="prod_info_title pdp-title" style="color:#666;font-size:1.125rem;"><?php echo $this->product_details->prod_no; ?></h1>
											<h3 class="prod_info_title pdp-title" style="font-weight:normal;"><?php echo strtoupper($this->product_details->prod_name); ?></h3>
											<h3 class="prod_info_title pdp-title" style="font-weight:normal;">PRICE: &nbsp;
												<?php
												/**********
												 * Popup only shows on desktop view
												 * The mobile view will land user to a new page instead of a popup
												 */
												?>
												<a id="send_inquiry" class="hidden-on-desktop" href="<?php echo site_url($this->uri->uri_string()).'?vw=how_to_order'; ?>" style="font-size:0.9em;"> 
													CLICK FOR PRICING
												</a>
												<a id="send_inquiry" class="hidden-on-mobile" href="javascript:void(0);" onclick="$('#modal-regular2').show();" style="font-size:0.9em;"> 
													CLICK FOR PRICING
												</a>
											</h3>
											<br />			
											<br />
										</div>
										
									</div>

									<?php
									/**********
									 * This DIV holds the Product Detail Images
									 */
									?>
									<div class="v-product-detailimages">
										<div class="pdp__left-col pdp__left-col--first">
										
											<?php
											/**********
											 * NOTE: have to remove the class "js-populate-carousels"
											 * as it somehow populates the image column with images
											 * from original site
											 */
											?>
											<div class="" data-product-videos='[]'>
											
												<?php
												/**********
												 * MAIN image
												 */
												?>
												
												<div class="product-image-cloud-zoom" style="width:425px;float:left;position:relative;">

													<?php
													/**********
													 * This is hidden on mobile browser
													 *
													 * MAIN image <a> tag container with cloud-zoom
													 */
													?>
													
													<a href="<?php echo $img_front_large; ?>" id="zoom1" class="cloud-zoom" rel="zoomWidth:800,zoomHeight:637,adjustX:0,adjustY:0">
														<img alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_thumb; ?>" />
													</a>
													
													<?php
													/**********
													 * These image are hidden and only shown when mouse hovers
													 * thumbs images on other views
													 */
													?>
													<img class="other-main-views" id="main-front-<?php echo $this->product_details->prod_no?>" src="<?php echo $img_front_thumb; ?>" />
													<img class="other-main-views" id="main-back-<?php echo $this->product_details->prod_no?>" src="<?php echo $img_back_thumb; ?>" />
													<img class="other-main-views" id="main-side-<?php echo $this->product_details->prod_no?>" src="<?php echo $img_side_thumb; ?>" />
														
													<div style="display:inline-block;margin-top:10px;">
														<a href="http://pinterest.com/" class="icon fa fa-3x fa-pinterest-square" target="_blank">
															<span class="text">Pinterest</span>
														</a>
													</div>

												</div>
												
												<?php
												/**********
												 * Hidden on desktop
												 */
												?>
												<div class="product-image-carousel hidden-on-desktop">
												
													<?php
													/**********
													 * This is for mobile browsing using slick carousel plugin
													 * Will need to hide this on desktop
													 */
													?>
													<div class="product-image-carousel__col-1of2">
													
														<div class="slide-carousel slick" data-options='{"slidesToShow": 1, "responsive": [{"breakpoint": 768, "settings": {"swipe": true, "swipeToSlide": true}}]}'>

															<?php
															/**********
															 * NOTE: Each <p> is a slide and the <a href=> value is the reference big
															 * image that will be shown in zoom window. Of coures, the img src is the 
															 * approriately size thumb image
															 *
															 * Only shown when image is available
															 */
															?>
															
															<?php
															$img = @GetImageSize($img_front_thumb);
															if ($img):
															?>
															
															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_front_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_thumb; ?>?$pdpmain$" />
																</a>
															</p>
															
															<?php
															endif;
															$img = @GetImageSize($img_back_thumb);
															if ($img):
															?>

															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_back_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_back_thumb; ?>?$pdpmain$" />
																</a>
															</p>

															<?php
															endif;
															$img = @GetImageSize($img_side_thumb);
															if ($img):
															?>

															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_side_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_side_thumb; ?>?$pdpmain$" />
																</a>
															</p>
															
															<?php endif; ?>

														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="productdetail product-form" style="margin-bottom:80px;">
									
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Color Name
										*/
										?>
										<div class="prdname product-form__label" style="margin-bottom: 10px;">
											AVAILABLE COLORS: &nbsp; &nbsp;
											<span class="style1">
												<?php
												//$url 	   = explode('/',get_full_breadcrumb_url());
												$url	   = explode('/',$this->uri->uri_string());
												$uri_count = count($url)-2;
												
												for ($i = 0; $i < $uri_count; $i++)
												{
													@$new_url .= $url[$i].'/';
												}
												
												//if ($get_color_list->num_rows() > 0)
												if (@$get_color_list)
												{
													$i = 0;
													//foreach ($get_color_list->result() as $color)
													foreach ($get_color_list as $color)
													{
														if ( ! $color->with_stocks)
														{
															$i++;
															continue;
														}
														
														$id2 = $this->product_details->prod_no.'_'.$color->color_code;
														$java3 = "showObj('".$id2."',this)";
														$java4 = "closetime()";
												
														$link_txt = $this->product_details->color_code == $color->color_code ? 'txt_page_black' : 'normal_txtn';
														if ($i != 0) echo '&nbsp; | &nbsp;';
														echo anchor($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)), $color->color_name,array('class'=>$link_txt,'onmouseover'=>$java3,'onmouseout'=>$java4));
														$i++;
													}
												}
												else
												{ ?>
													Out of Stock
													<?php
												} ?>
											</span>
										</div>
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Color Swatch
										*/
										?>
										<span class="midtxt">[ <span class="hide-on-mobile">Mouse over color icons to view colors / </span>Click any icon to change color ]</span>
										<br /><br />
										<?php
											//if ($get_color_list->num_rows() > 0)
											if ($get_color_list)
											{
												//foreach ($get_color_list->result() as $color)
												foreach ($get_color_list as $color)
												{
													if ( ! $color->with_stocks)
													{
														$i++;
														continue;
													}
													
													$id3 = $this->product_details->prod_no.'_'.$color->color_code;
													$java5 = "showObj('".$id3."',this)";
													$java6 = "closetime()";
												
													$swatch_style = $this->product_details->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';
													echo anchor($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)), img(array('src'=>$PROD_IMG_URL.$img_path.'product_coloricon/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg','width'=>'20','style'=>$swatch_style)),array('onmouseover'=>$java5,'onmouseout'=>$java6)).nbs(7);
												}
											}
										?>
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Color Swatch
										*/
										?>
										<span class="product-form__label" style="margin-top:40px;"><strong>AVAILABILITY:</strong> AS PER DELIVERY DATES </span>
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| HOW TO ORDER button
										*/
										?>
										<input type="submit" class="button button--wide hidden-on-desktop button--<?php echo $this->config->item('site_slug'); ?>" value="How To Order" onclick="window.location.href='<?php echo site_url($this->uri->uri_string()).'?vw=how_to_order'; ?>';" style="margin:15px 0px 75px 0px;width:250px;"/>

										<input type="submit" class="button button--wide hidden-on-mobile button--<?php echo $this->config->item('site_slug'); ?>" value="How To Order" onclick="$('#modal-regular2').show();" style="margin:15px 0px 75px 0px;width:250px;"/>
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Other Views Thumbs
										*/
										?>
										<div class="other-views hidden-on-mobile" style="position:absolute;bottom:0px;">
											
											<?php
											$img = @GetImageSize($img_front);
											if ($img):
											?>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_front_large; ?>' class="cloud-zoom-gallery" title="Front view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_front_thumb; ?>'" onmouseover="showObj('main-front-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()">
													<img src="<?php echo $img_front; ?>" alt="Front View" style="border:1px solid #333;" />
												</a>
											</div>
											
											<?php
											endif;
											$img = @GetImageSize($img_back);
											if ($img):
											?>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_back_large; ?>' class="cloud-zoom-gallery" title="Back view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_back_thumb; ?>'" onmouseover="showObj('main-back-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()">
													<img src="<?php echo $img_back; ?>" alt="Back View" style="border:1px solid #333;" />
												</a>
											</div>
											
											<?php
											endif;
											$img = @GetImageSize($img_side);
											if ($img):
											?>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_side_large; ?>' class="cloud-zoom-gallery" title="Side view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_side_thumb; ?>'" onmouseover="showObj('main-side-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()">
													<img src="<?php echo $img_side; ?>" alt="Side View" style="border:1px solid #333;" />
												</a>
											</div>
											
											<?php endif; ?>
										
										</div>
									</div>
								</div>
							</div>
							
							<?php endif; ?>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->

					<!-- Regular Modal 2 -->
					<div id="modal-regular2" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<span class="close" onclick="$('#modal-regular2').hide();"><span style="font-size:0.7em;">CLOSE</span> &times;</span>
									<h1 class="modal-title">Order Inquiry Form</h1>
								</div>
								<div class="modal-body">
									<?php
									$pass_data = array(
										'image' => $img_thumb,
										'img_inquiry' => $img_inquiry,
										'return_url' => $this->uri->uri_string(),
										'prod_no' => $this->product_details->prod_no,
										'color_code' => $this->product_details->color_code
									);
									//$this->load->view($this->config->slash_item('template').'about_this_product', $pass_data);
									$this->load->view($this->webspace_details->options['theme'].'/about_this_product', $pass_data);
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- END Regular Modal 2 -->
