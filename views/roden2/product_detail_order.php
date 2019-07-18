					<?php
					/**********
					 * Let us first set the images
					 */
					//$get_color_list = $this->query_category->get_available_colors($product->prod_no, ($this->uri->segment(1) === 'special_sale' ? TRUE : FALSE));
					$get_color_list = $this->product_details->available_colors();
					
					/**********
					 * Let us first set the images
					 */
					if ($this->product_details->color_name == '')
					{
						$color_code = $this->product_details->primary_img_id;
					}
					else
					{
						$color_code = $this->product_details->color_code;
					}
					
					$img_path 			= 'product_assets/'.$this->product_details->c_folder.'/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/';
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
					
					$img_large			= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_f.jpg'
						: $PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg'
					;
					$img_thumb			= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_f3.jpg'
						: $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_3.jpg'
					;
					$img_video_flv		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.flv';
					$img_video_mp4		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.mp4';
					$img_video_ogv		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.ogv';
					$img_video_webm		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.webm';

					$img_inquiry		= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_f1.jpg'
						: $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_1.jpg'
					;
					
					$img_front			= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_f2.jpg'
						: $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_2.jpg'
					;
					$img_side			= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_s2.jpg'
						: $PROD_IMG_URL.$img_path.'product_side/thumbs/'.$img_name.'_2.jpg'
					;
					$img_back			= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_b2.jpg'
						: $PROD_IMG_URL.$img_path.'product_back/thumbs/'.$img_name.'_2.jpg'
					;
					
					$img_front_thumb	= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_f4.jpg'
						: $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_4.jpg'
					;
					$img_side_thumb		= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_s4.jpg'
						: $PROD_IMG_URL.$img_path.'product_side/thumbs/'.$img_name.'_4.jpg'
					;
					$img_back_thumb		= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_b4.jpg'
						: $PROD_IMG_URL.$img_path.'product_back/thumbs/'.$img_name.'_4.jpg'
					;

					$img_front_large	= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_f.jpg'
						: $PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg'
					;
					$img_side_large		= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_s.jpg'
						: $PROD_IMG_URL.$img_path.'product_side/'.$img_name.'.jpg'
					;
					$img_back_large		= 
						$this->product_details->primary_img
						? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_b.jpg'
						: $PROD_IMG_URL.$img_path.'product_back/'.$img_name.'.jpg'
					;
					
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
							
							if ($view_pane === 'how_to_order') { ?>
							
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
											<?php 
											/*
											<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_return_url'); ?>" value="<?php echo site_url($this->uri->uri_string()); ?>" />
											*/
											echo form_hidden(md5(md5($the_spinner).'the_return_url'), site_url($this->uri->uri_string())); 
											?>
											
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
																	<input type="radio" class="input-radio" required="required" id="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" name="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" value="Store" /> &nbsp; I am a Store
																	<br />
																	<em style="color:red;">(You will be taken to fill out wholesale form for verification)</em>
																	<br />
																	<input type="radio" class="input-radio" required="required" id="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" name="<?php echo md5(md5($the_spinner).'the_u_type'); ?>" value="Consumer" /> &nbsp; I am a Consumer
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
							} else { ?>
							
							<?php
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
												
												<div class="product-image-cloud-zoom" style="width:425px;float:left;position:relative;" onmouseover="$('article.accordion__tab').removeClass('js-toggleactive__toggle--active');">

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
													
													<?php //if ($get_color_list->num_rows() > 0): ?>
													<?php if ($get_color_list): ?>
													
														<?php //foreach ($get_color_list->result() as $color): ?>
														<?php foreach ($get_color_list as $color): ?>
														
															<?php
															/**********
															 * On regular pages...
															 * To avoid duplicity, the image name must not be the same current product number
															 * To avoid showing special sale, product custom_order !== '3'
															 */
															?>
															<?php if ($img_name !== $this->product_details->prod_no.'_'.$color->color_code): ?>
														
													<img class="other-main-views" id="<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" src="<?php echo $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$this->product_details->prod_no.'_'.$color->color_code.'_4.jpg';; ?>" />
														
															<?php endif; ?>
													
														<?php endforeach; ?>
													
													<?php endif; ?>
														
													<video class="other-main-views" id="main-video-<?php echo $this->product_details->prod_no; ?>" width="425" height="637.5" style="display:inline;" autoplay loop>
														<source src="<?php echo $img_video_mp4; ?>" type="video/mp4" onerror="$(this).closest('video').hide();">
														Your browser does not support the video tag.
													</video> 
													
													<div style="display:none;margin-top:10px;">
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
															 */
															?>
															
															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_front_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_thumb; ?>?$pdpmain$" onerror="$(this).hide();" />
																</a>
															</p>
															
															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_back_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_back_thumb; ?>?$pdpmain$" onerror="$(this).hide();" />
																</a>
															</p>

															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_side_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_side_thumb; ?>?$pdpmain$" onerror="$(this).hide();" />
																</a>
															</p>
															
														</div>
													</div>
												</div>
											</div>
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
										
											<?php
											/**********
											 * Notifications
											 */
											?>
											<?php if ($this->session->flashdata('error') == 'no_price') { ?>
											<div class="center" style="background:pink;padding:20px;">
												We are unable to add product to cart because it has no price at the moment. Would you like to inquire about the product instead? Click 
												<?php
												/**********
												 * Popup only shows on desktop view
												 * The mobile view will land user to a new page instead of a popup
												 */
												?>
												<a id="send_inquiry" class="hidden-on-desktop" href="<?php echo site_url($this->uri->uri_string()).'?vw=how_to_order'; ?>" style="font-size:0.9em;"> 
													HERE
												</a>
												<a id="send_inquiry" class="hidden-on-mobile" href="javascript:void(0);" onclick="$('#modal-regular2').show();" style="font-size:0.9em;"> 
													HERE
												</a>
											</div>
											<?php } else if ($this->session->flashdata('flashMsg')) { ?>
											<div class="center" style="background:pink;padding:20px;">
												<?php echo $this->session->flashdata('flashMsg'); ?>
											</div>
											<?php } ?>
											
											<h1 class="prod_info_title pdp-title"><?php echo $this->product_details->designer_name; ?></h1>
											<h1 class="prod_info_title pdp-title"><?php echo $this->product_details->prod_no; ?></h1>
											<h3 class="prod_info_title pdp-title pdp-subtitle"><?php echo strtoupper($this->product_details->prod_name); ?></h3>
											<h3 class="prod_info_title pdp-title pdp-subtitle">PRICE: &nbsp;
											
												<?php
												/**********
												 * The PRICE
												 */
												?>
												
												<?php 
												if( $this->session->userdata('user_cat') === 'wholesale'): 
												/**********
												 * Wholeslae price
												 */
												//$price = number_format($product->wholesale_price, 2); // --> wholesale price
												
												/**********
												 * If item is on SPEICAL SALE
												 * We stil need to show the wholesale price with strikethrough line
												 * and get the wholesale clearance price
												 */
												if ($this->product_details->custom_order === '3')
												$price = number_format($this->product_details->wholesale_price_clearance, 2); // --> retail price
												?>
												
												<span itemprop="price" <?php echo $this->product_details->custom_order === '3' ? 'style="text-decoration:line-through;"' : ''; ?>>[WHOLESALE PRICE] &nbsp; <?php echo $this->config->item('currency').' '.number_format($this->product_details->wholesale_price, 2); ?></span>&nbsp;
												
													<?php if ($this->product_details->custom_order === '3'): ?>
													
												&nbsp; <span itemprop="price" style="color:red;">
													[CLEARANCE] &nbsp; <?php echo $this->config->item('currency').' '.$price; ?>
												</span>
												
													<?php endif; ?>
												
												<?php 
												elseif ($this->product_details->custom_order === '3'): 
												/**********
												 * Sale price
												 *
												 * If item is on standard sale
												 * price is set OUR SALE PRICE (catalogue_price)
												 */
												$price = number_format($this->product_details->retail_sale_price, 2); // --> sale price
												
												/**********
												 * If item is on SPEICAL SALE
												 * We stil need to show the retail price with strikethrough line
												 */
												//$price = number_format($this->product_details->retail_price, 2); // --> retail price
												?>
												
												<span itemprop="price" style="text-decoration:line-through;">
													<?php echo $this->config->item('currency').' '.number_format($this->product_details->retail_price, 2); ?>
												</span> &nbsp; 
												<span itemprop="price" style="color:red;">
													[ON SALE] &nbsp; <?php echo $this->config->item('currency').' '.$price; ?>
												</span>
												
												<?php 
												else: 
												/**********
												 * Retail price
												 */
												$price = number_format($this->product_details->retail_price, 2); // --> retail price
												?>
												
												<span itemprop="price"><?php echo $this->config->item('currency').' '.$price; ?></span>
												
												<?php endif; ?>
												
											</h3>
											
										</div>
										
									</div>

									<div class="productdetail product-form" style="margin-bottom:80px;">
									
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Color Name
										*/
										?>
										<div class="prdname product-form__label" style="margin-top: 0px;">
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
												
												///if ($get_color_list->num_rows() > 0)
												if ($get_color_list)
												{
													$i = 0;
													//foreach ($get_color_list->result() as $color)
													foreach ($get_color_list as $color)
													{
														/*
														// hide items with no stocks at all
														if ( ! $color->with_stocks)
														{
															$i++;
															continue;
														}
														*/
														
														/**********
														 * On regular pages, show only regular items
														 */
														if (
															$this->uri->segment(1) !== 'special_sale' 
															OR $color->custom_order !== '3'
														):
														
															$id2 = $this->product_details->prod_no.'_'.$color->color_code;
															$java3 = "showObj('".$id2."',this)";
															$java4 = "closetime()";
													
															$link_txt = $this->product_details->color_code == $color->color_code ? 'txt_page_black' : 'normal_txtn';
															if ($i != 0) echo nbs().' | '.nbs();
															?>
															
																<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name))); ?>" class="pdp--color-name <?php echo $link_txt; ?>" onmouseover="<?php echo $java3; ?>" onmouseout="<?php echo $java4; ?>" data-with-stocks="<?php echo $color->with_stocks; ?>">
																	<?php echo $color->color_name; ?>
																</a>
																
															<?php
														/**********
														 * On special sale pages...
														 */
														else:
														
															$id2 = $this->product_details->prod_no.'_'.$color->color_code;
															$java3 = "showObj('".$id2."',this)";
															$java4 = "closetime()";
													
															$link_txt = $this->product_details->color_code == $color->color_code ? 'txt_page_black' : 'normal_txtn';
															if ($i != 0) echo nbs().' | '.nbs();
															?>
															
																<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name))); ?>" class="pdp--color-name <?php echo $link_txt; ?>" onmouseover="<?php echo $java3; ?>" onmouseout="<?php echo $java4; ?>">
																	<?php echo $color->color_name; ?>
																</a>
																
															<?php
														endif;
														
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
										
										<br style="margin-bottom:10px;"/>
										
										<?php
											//if ($get_color_list->num_rows() > 0)
											if ($get_color_list)
											{
												//foreach ($get_color_list->result() as $color)
												foreach ($get_color_list as $color)
												{
													/*
													// hide items with no stocks at all
													if ( ! $color->with_stocks)
													{
														continue;
													}
													*/
													
													/**********
													 * On regular pages, show only regular items
													 */
													if ($color->custom_order !== '3'):
													
													$id3 = $this->product_details->prod_no.'_'.$color->color_code;
													$java5 = "showObj('".$id3."',this)";
													$java6 = "closetime()";
												
													$swatch_style = $this->product_details->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';
													echo anchor(
														$new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)), 
														img(
															array(
																'src'=>(
																	$this->product_details->primary_img
																	? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_c.jpg'
																	: $PROD_IMG_URL.$img_path.'product_coloricon/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg'
																),
																'width'=>'20','style'=>$swatch_style
															)
														),
														array('onmouseover'=>$java5,'onmouseout'=>$java6)
													).nbs(7);
													
													/**********
													 * On special sale pages...
													 */
													else:
													
													$id3 = $this->product_details->prod_no.'_'.$color->color_code;
													$java5 = "showObj('".$id3."',this)";
													$java6 = "closetime()";
												
													$swatch_style = $this->product_details->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';
													echo anchor(
														$new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)), 
														img(
															array(
																'src'=>(
																	$this->product_details->primary_img
																	? $PROD_IMG_URL.$this->product_details->media_path.$this->product_details->media_name.'_c.jpg'
																	: $PROD_IMG_URL.$img_path.'product_coloricon/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg'
																),
																'width'=>'20','style'=>$swatch_style
															)
														),
														array('onmouseover'=>$java5,'onmouseout'=>$java6)
													).nbs(7);
													
													endif;
												}
											}
										?>
										
										<?php
										/**********
										 * Let's start the form to submit to cart here
										 */
										?>
										<!--bof form========================================================================-->
										<?php echo form_open('cart/add_cart', array('name'=>'frmCart', 'method'=>'POST')); ?>
										
											<input type="hidden" name="wholesale_order" value="0" />
											<input type="hidden" name="package_details" value="0" />
											<input type="hidden" name="special_sale_prefix" value="<?php echo $this->uri->segment(1) === 'special_sale' ? '1' : '0'; ?>" />
											
											<input type="hidden" name="cat_id" value="<?php echo $this->product_details->cat_id; ?>" />
											<input type="hidden" name="subcat_id" value="<?php echo $this->product_details->subcat_id; ?>" />
											<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
											<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
											<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
											<input type="hidden" name="price" value="<?php echo $price; ?>" />
											<input type="hidden" name="label_designer" value="<?php echo $this->product_details->designer_name; ?>" />
											
											<input type="hidden" name="color_code" value="<?php echo $this->product_details->color_code; ?>" />
											<input type="hidden" name="prod_sku" value="<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>" />
											<input type="hidden" name="label_color" value="<?php echo $this->product_details->color_name; ?>" />
											
											<?php 
											/*
											<input type="hidden" name="prod_image" value="<?php echo $img_path.'product_front/thumbs/'.$img_name.'_2.jpg'; ?>" />
											<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />
											*/
											echo form_hidden('prod_image', $img_path.'product_front/thumbs/'.$img_name.'_2.jpg'); 
											echo form_hidden('current_url', current_url()); 
											// new image url system
											echo form_hidden(
												'prod_image_url', 
												(
													$this->product_details->primary_img
													? $this->product_details->media_path.$this->product_details->media_name.'_f2.jpg'
													: ''
												)
											); 
											?>
											
											<input type="hidden" name="size_mode" value="<?php echo $this->product_details->size_mode; ?>" />
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Size
											*/
											?>
											<span class="prdname product-form__label" style="margin-top:5px;"><strong>AVAILABLE SIZES:</strong> </span>
											
											<input type="hidden" id="size" name="size" value="" />
											
											<style>
											.details.unavailable {
												display: none;
												position: absolute;
												left: 0;
												bottom: 30px;
												padding: 5px 3px 5px 3px;
												font-size: 9px;
												font-weight: bold;
												text-transform: uppercase;
												font-family: "Times New Roman",Times,serif;
												font-style: normal;
												text-align: center;
												color: #333;
												background: #fff;
												border: 1px solid #ccc;
												z-index: 2001;
												white-space: nowrap;
												opcaity: 0.75;
											}
											.diagonal-line {
												width: 130%;
												height: 100%;
												border-bottom: 3px solid #a6a6a6;
												-webkit-transform: rotate(-45deg);
												position: absolute;
												top: -10px;
												left: -15px;
												opacity: .5;
											}
											.product-form__list-item {
												margin-left: 0;
												margin-right: 8px;
												height: auto;
											}
											</style>
											
											<div class="product-form__sizes  display-dependency clearfix" style="margin-bottom:5px;">
												<ul class="product-form__list">
													
													<?php
													/**********
													 * Let's get the sizes and it's availablity through stock qty
													 * according to size mode system
													 
													$get_size = $this->query_category->get_size_by_mode($this->product_details->cat_id, $this->product_details->size_mode);
													$check_stock = $this->query_product->check_stock($this->product_details->prod_no, $this->product_details->color_name);
													 */
													$get_size = $this->get_sizes_by_mode->get_sizes($this->product_details->size_mode);
													$check_stock = $this->get_product_stocks->get_stocks($this->product_details->prod_no, $this->product_details->color_name);
													
													if ($get_size)
													{
														foreach ($get_size as $size)
														{
															if($size->size_name == 'S' || $size->size_name == 'M' || $size->size_name == 'L' || $size->size_name == 'XL' || $size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2' || $size->size_name == 'S-M' || $size->size_name == 'M-L' || $size->size_name == 'ONE-SIZE-FITS-ALL')
															{
																$size_stock = 'size_s'.strtolower($size->size_name);
															}
															else
															{
																$size_stock = 'size_'.$size->size_name;
															}
															
															if ($size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2') $hide_size_xxl_xl2 = 'style="display:none;"';
															else $hide_size_xxl_xl2 = '';
															
															if (
																$size_stock != 'size_fs' // for size mode 1
																&& $size_stock != 'size_ss-m' // for size mode 0
																&& $size_stock != 'size_sm-l'
																&& $size_stock != 'size_sone-size-fits-all'
															)
															{
																if ($check_stock[$size_stock] > 0)
																{
																	$a_class = 'input-control parent-select product-form__product-size instock';
																	$availability = 'availability--instock';
																}
																else
																{
																	$a_class = 'input-control parent-select product-form__product-size unavailable product-form__product-size--out-of-stock';
																	$availability = 'availability--preorder';
																}
																
																//if ($this->uri->segment(1) !== 'special_sale' OR $check_stock[$size_stock] != 0) // does not show zero stock sizes
																if ($this->uri->segment(1) !== 'special_sale')
																{
													?>
													
													<li class="hoverable product-form__list-item" <?php echo $hide_size_xxl_xl2; ?> onmouseover="$('#<?php echo $size_stock; ?>.details.unavailable').show();$('span#diagonal-line-<?php echo $size_stock; ?>').hide();" onmouseout="$('#<?php echo $size_stock; ?>.details.unavailable').hide();$('span#diagonal-line-<?php echo $size_stock; ?>').show();" onclick="
														$('span.availability').hide();
														$('span.availability.<?php echo $availability; ?>').show();
														$('.cart-button').hide();
														$('.cart-button-<?php echo $check_stock[$size_stock] == 0 ? 'preorder' : 'add-to-bag'; ?>').show();
														$('input#size').val('<?php echo $size->size_name; ?>');
														$('input[name=\'qty\']').attr('max', '<?php echo $check_stock[$size_stock] ?: '30'; ?>');
														$('input[name=\'qty\']').val('1');
														$('input[name=\'custom_order\']').val('<?php echo $check_stock[$size_stock] == 0 ? '1' : $this->product_details->custom_order; ?>');
													">
														<a href="javascript:void();" class="<?php echo $a_class; ?>" style="z-index:10;">
															<span><?php echo $size->size_name; ?></span>
														</a>
														<span class="ico"></span>
														
														<?php 
														if ($check_stock[$size_stock] == 0): 
														
															if ($this->product_details->d_folder === 'junnieleigh')
															{
																$product_stock_status = '5-12';
															}
														?>
														
														<span id="diagonal-line-<?php echo $size_stock; ?>" class="diagonal-line"></span>
														<span id="<?php echo $size_stock; ?>" class="details unavailable" style="text-align:left;color:red;">
															<span class="pointer"></span>
															Pre-Order<br />
															Size Not In-Stock<br />
															Delivery is <?php echo @$product_stock_status ? $product_stock_status : '14-16'; ?> Weeks<br />
															From Order Date
														</span>
														
														<?php endif; ?>
														
													</li>
													
													<?php
																}
															}
														}
													} else echo 'No available sizes';
													?>
													
												</ul>
												
												<?php
												/**********
												 * This is set to zero by default indicating that item is in-stock
												 * Script on click of size box changes this to 1 for pre-order sizes
												 */
												?>
												<input type="hidden" id="custom_order-<?php echo $this->product_details->color_code; ?>" name="custom_order" value="0" />

											</div>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Quantity
											*/
											?>
											<div class="product-form__qty" style="width:100px;">
												<span class="key  product-form__label  product-form__label--alt  uppercase">quantity:</span>
												<input id="vProduct-packageProductsForm-quantity-0-1" class="product-form__quantity-input" name="qty" min="1" max="30" required="required" value="0" type="number">
											</div>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Availability
											*/
											?>
											<span class="product-form__label" style="margin-top:5px;">
												<strong>AVAILABILITY:</strong>
												<br class="hidden-on-desktop"/>&nbsp;
												<span class="availability availability--default">
													SELECT YOUR SIZE FOR SHIPPING AVAILABILITY
												</span>
												<span class="availability availability--instock" style="display:none;">
													SHIPS WITHIN 5-7 BUSINESS DAYS
												</span>
												<span class="availability availability--preorder" style="display:none;color:red;">
													Item ships approximately 14-16 weeks from date of order
												</span>
												<br class="hidden-on-desktop"/>&nbsp;
												<span class="availability" style="color:red;">[We ship globally]</span>
											</span>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| ORDER button
											*/
											?>
											<style>
											.button.pre-order {
												background-color: black;
												border: 1px solid #fff;
												box-shadow: 0 0 0 5px black;
											}
											.button.pre-order:hover {
												color: grey;
											}
											</style>
											
											<div class="cart-button cart-button-add-to-bag">
												<input type="submit" class="button button--small--text hidden-on-desktop button--<?php echo $this->webspace_details->slug; ?>" value="Add To Bag" onclick="return checkSizeQty();" />
												<input type="submit" class="button button--small--text hidden-on-mobile button--<?php echo $this->webspace_details->slug; ?>" value="Add To Bag" onclick="return checkSizeQty();" />
											</div>

											<div class="cart-button cart-button-preorder" style="display:none;">
												<input type="submit" class="button button--small--text hidden-on-desktop button--<?php echo $this->webspace_details->slug; ?> pre-order" value="Pre Order" onclick="return checkSizeQty();" />
												<input type="submit" class="button button--small--text hidden-on-mobile button--<?php echo $this->webspace_details->slug; ?> pre-order" value="Pre Order" onclick="return checkSizeQty();" />
											</div>
											
											<script>
											function checkSizeQty(){
												var size = document.getElementById('size').value;
												var qty = document.getElementById('vProduct-packageProductsForm-quantity-0-1').value;
												if (size == ''){
													alert('Please select a size.');
													return false;
												}
												if (qty == 0){
													alert('Quantity must be more than 1.');
													return false;
												}
												return true;
											}
											</script>
											
										<?php
										echo form_close();
										?>
										<!--eof form========================================================================-->
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Product Description
										*/
										?>
										<div class="accordion js-toggleactive clearfix" style="margin-top:5px;">

											<article class="accordion__tab  js-add-height js-toggleactive__toggle  js-toggleactive__toggle" data-accordion-section="description">
												<h1 class="accordion__title  js-toggleactive__toggler">Description &amp; Details</h1>
												<div class="accordion__section js-toggleactive__content  accordion__section--padded  accordion__section--bordered">
												
													<div class="detail-section">
														<div class="desc-long" itemprop="description">
															<p>
																<?php echo $this->product_details->prod_desc; ?>
															</p>
														</div>
													</div>
													
												</div>
											</article>
											
											<article class="accordion__tab  js-add-height js-toggleactive__toggle  js-toggleactive__toggle" data-accordion-section="description">
												<h1 class="accordion__title  js-toggleactive__toggler">View Size Chart</h1>
												<div class="accordion__section js-toggleactive__content  accordion__section--padded  accordion__section--bordered">
												
													<div class="detail-section">
														<div class="desc-long" itemprop="description">
															<img src="<?php echo base_url('images/designer_icon/thumb/'.$this->product_details->size_chart); ?>" />
														</div>
													</div>
													
												</div>
											</article>
											
											<article class="accordion__tab  js-add-height js-toggleactive__toggle  js-toggleactive__toggle" data-accordion-section="description">
												<h1 class="accordion__title  js-toggleactive__toggler">Shipping &amp; Returns</h1>
												<div class="accordion__section js-toggleactive__content  accordion__section--padded  accordion__section--bordered">
												
													<div class="detail-section">
														<div class="desc-long" itemprop="description">
														
															<?php //$this->load->view($this->config->slash_item('template').'return_policy'); ?>
															<?php //$this->load->view($this->config->slash_item('template').'shipping'); ?>
															<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy'); ?>
															<?php $this->load->view($this->webspace_details->options['theme'].'/shipping'); ?>
								
														</div>
													</div>
													
												</div>
											</article>
											
										</div>
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Other Views Thumbs
										*/
										?>
										<div class="other-views hidden-on-mobile" style="position:absolute;bottom:0px;">
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_front_large; ?>' class="cloud-zoom-gallery" title="Front view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_front_thumb; ?>'" onmouseover="showObj('main-front-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
													<img src="<?php echo $img_front; ?>" alt="Front View" style="border:1px solid #333;" onerror="$(this).closest('div').hide();" />
												</a>
											</div>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_back_large; ?>' class="cloud-zoom-gallery" title="Back view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_back_thumb; ?>'" onmouseover="showObj('main-back-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
													<img src="<?php echo $img_back; ?>" alt="Back View" style="border:1px solid #333;" onerror="$(this).closest('div').hide();" />
												</a>
											</div>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_side_large; ?>' class="cloud-zoom-gallery" title="Side view" rel="useZoom: 'zoom1', smallImage: '<?php echo $img_side_thumb; ?>'" onmouseover="showObj('main-side-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video').remove();">
													<img src="<?php echo $img_side; ?>" alt="Side View" style="border:1px solid #333;" onerror="$(this).closest('div').hide();" />
												</a>
											</div>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;" onmouseover="showObj('main-video-<?php echo $this->product_details->prod_no; ?>', this)" onmouseout="closetime()" onclick="$('#zoom1').append('<video width=\'425\' height=\'637.5\' id=\'the-product_video\' style=\'border:1px solid #333;background:black;display:inline;position:absolute;top:0px;\' autoplay loop ><source src=\'<?php echo $img_video_mp4; ?>\' type=\'video/mp4\'>Your browser does not support the video tag.</video>');">
												<video width="60" height="90" style="border:1px solid #333;background:black;display:inline;" autoplay loop >
													<source src="<?php echo $img_video_mp4; ?>" type="video/mp4" onerror="$(this).closest('div').hide();">
													<!--
													<source src="<?php echo $img_video_ogv; ?>" type="video/ogg" onerror="$(this).closest('div').hide();">
													<source src="<?php echo $img_video_webm; ?>" type="video/webm" onerror="$(this).closest('div').hide();">
													-->
													Your browser does not support the video tag.
												</video> 
											</div>
											
										</div>
									</div>
									
								</div>
							</div>
							
							<?php } ?>

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

					<?php
					/**********
					 * Popup Dialog
					 * for Return Policy
					 */
					?>
					<!-- Desktop -->
					<div aria-labelledby="ui-dialog-title-1" id="this-dialog-shipping" role="dialog" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="display: none; z-index: 10001; outline: 0px none; height: auto; width: 800px; top: 250px; left: 50%; margin-left:-400px; margin-bottom: 100px;">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix bg-color-<?php echo $this->config->item('site_slug'); ?>" style="height:50px;">
							<span id="ui-dialog-title-1" class="ui-dialog-title">&nbsp;</span>
							<a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);" onclick="$('#this-dialog').hide();"><span class="ui-icon ui-icon-closethick"></span></a>
						</div>
						<div style="width: auto; min-height: 115px; height: auto;" class="ui-dialog-content ui-widget-content">
							<div class="v-checkout-shippingaddresstemplate clearfix">
								
								<?php //$this->load->view($this->config->slash_item('template').'shipping'); ?>
								<?php //$this->load->view($this->config->slash_item('template').'return_policy'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/shipping'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy'); ?>
								
							</div>
						</div>
					</div>
				
					<!-- Desktop -->
					<div aria-labelledby="ui-dialog-title-1" id="this-dialog-return" role="dialog" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="display: none; z-index: 10001; outline: 0px none; height: auto; width: 800px; top: 250px; left: 50%; margin-left:-400px; margin-bottom: 100px;">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix bg-color-<?php echo $this->config->item('site_slug'); ?>" style="height:50px;">
							<span id="ui-dialog-title-1" class="ui-dialog-title">&nbsp;</span>
							<a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);" onclick="$('#this-dialog-mobile').hide();$('div#policy-content').hide();$('#policy-toggle-switch').show();"><span class="ui-icon ui-icon-closethick" style="color:black;"></span></a>
						</div>
						<div style="width: auto; min-height: 115px; height: auto;" class="ui-dialog-content ui-widget-content">
							<div class="v-checkout-shippingaddresstemplate clearfix">
								
								<?php //$this->load->view($this->config->slash_item('template').'return_policy'); ?>
								<?php //$this->load->view($this->config->slash_item('template').'shipping'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/shipping'); ?>
								
							</div>
						</div>
					</div>
				
					<!-- Mobile -->
					<div aria-labelledby="ui-dialog-title-1" id="this-dialog-shipping-mobile" role="dialog" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="display: none; z-index: 10001; outline: 0px none; height: auto; width: 250px; top: 1150px; left: 50%; margin-left:-125px; margin-bottom: 100px;">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix bg-color-<?php echo $this->config->item('site_slug'); ?>" style="height:50px;">
							<span id="ui-dialog-title-1" class="ui-dialog-title">&nbsp;</span>
							<a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);" onclick="$('#this-dialog-shipping-mobile').hide();"><span class="ui-icon ui-icon-closethick"></span></a>
						</div>
						<div style="width: auto; min-height: 115px; height: auto;" class="ui-dialog-content ui-widget-content">
							<div class="v-checkout-shippingaddresstemplate clearfix">
								
								<?php //$this->load->view($this->config->slash_item('template').'shipping_mobile'); ?>
								<?php //$this->load->view($this->config->slash_item('template').'return_policy_mobile'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/shipping_mobile'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy_mobile'); ?>
								
							</div>
						</div>
					</div>
				
					<!-- Mobile -->
					<div aria-labelledby="ui-dialog-title-1" id="this-dialog-return-mobile" role="dialog" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="display: none; z-index: 10001; outline: 0px none; height: auto; width: 250px; top: 1150px; left: 50%; margin-left:-125px; margin-bottom: 100px;">
						<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix bg-color-<?php echo $this->config->item('site_slug'); ?>" style="height:50px;">
							<span id="ui-dialog-title-1" class="ui-dialog-title">&nbsp;</span>
							<a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);" onclick="$('#this-dialog-return-mobile').hide();"><span class="ui-icon ui-icon-closethick" style="color:black;"></span></a>
						</div>
						<div style="width: auto; min-height: 115px; height: auto;" class="ui-dialog-content ui-widget-content">
							<div class="v-checkout-shippingaddresstemplate clearfix">
								
								<?php //$this->load->view($this->config->slash_item('template').'return_policy_mobile'); ?>
								<?php //$this->load->view($this->config->slash_item('template').'shipping_mobile'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy_mobile'); ?>
								<?php $this->load->view($this->webspace_details->options['theme'].'/shipping_mobile'); ?>
								
							</div>
						</div>
					</div>
				
