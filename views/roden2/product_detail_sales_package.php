					<?php
					/**********
					 * Let us first get the available colors
					 */
					//$get_color_list = $this->query_category->get_available_colors($this->product_details->prod_no, ($this->uri->segment(1) === 'special_sale' ? TRUE : FALSE));
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
					
					$img_large			= $PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg';
					$img_thumb			= $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_3.jpg';
					$img_video_flv		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.flv';
					$img_video_mp4		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.mp4';
					$img_video_ogv		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.ogv';
					$img_video_webm		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.webm';

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
										 * Let's start the form to submit to cart here
										 * Let's make the form encompassing the entire product package page
										 */
										?>
										<!--bof form========================================================================-->
										<?php
										echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/add_cart', array('name'=>'frmCart', 'method'=>'POST'));
										?>
											<input type="hidden" name="wholesale_order" value="1" />
											<input type="hidden" name="package_details" value="0" />
											<input type="hidden" name="special_sale_prefix" value="<?php echo $this->uri->segment(1) === 'special_sale' ? '1' : '0'; ?>" />
											
											<input type="hidden" name="cat_id" value="<?php echo $this->product_details->cat_id; ?>" />
											<input type="hidden" name="subcat_id" value="<?php echo $this->product_details->subcat_id; ?>" />
											<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
											<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
											<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
											<input type="hidden" name="price" value="<?php echo $this->product_details->custom_order === '3' ? number_format($this->product_details->wholesale_price_clearance, 2) : number_format($this->product_details->wholesale_price, 2); ?>" />
											<input type="hidden" name="label_designer" value="<?php echo $this->product_details->designer_name; ?>" />
											
											<input type="hidden" name="color_code" value="<?php echo $this->product_details->color_code; ?>" />
											<input type="hidden" name="prod_sku" value="<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>" />
											<input type="hidden" name="label_color" value="<?php echo $this->product_details->color_name; ?>" />
											
											<input type="hidden" name="size_mode" value="<?php echo $this->product_details->size_mode; ?>" />
											
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
													
													<video class="other-main-views" id="main-video-<?php echo $this->product_details->prod_no?>" width="425" height="637.5" style="display:inline;" autoplay loop>
														<source src="<?php echo $img_video_mp4; ?>" type="video/mp4" onerror="$(this).closest('video').hide();">
														Your browser does not support the video tag.
													</video> 
													
													<div style="display:none;margin-top:10px;"> <!-- hidden -->
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
										
											<?php echo $this->session->flashdata('flashMsg'); ?>
											
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
												$price = number_format($this->product_details->wholesale_price,2);
												?>
													<?php if ($this->product_details->custom_order !== '3'): ?>
													
												<span itemprop="price">[WHOLESALE PRICE] &nbsp; <?php echo $this->config->item('currency').' '.$price; ?></span>
													
													<?php 
													else: 
													$price = number_format($this->product_details->wholesale_price_clearance, 2); // --> clearance price
													?>
												
												<span itemprop="price" style="text-decoration:line-through;">[WHOLESALE PRICE] &nbsp; <?php echo $this->config->item('currency').' '.number_format($this->product_details->wholesale_price,2); ?></span> &nbsp; 
												<span itemprop="price" style="color:red;">
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
												//$price = number_format($this->product_details->less_discount, 2); // --> retail price
												?>
												
												<span itemprop="price" style="text-decoration:line-through;">
													<?php echo $this->config->item('currency').' '.number_format($this->product_details->less_discount, 2); ?>
												</span> &nbsp; 
												<span itemprop="price" style="color:red;">
													[ON SALE] &nbsp; <?php echo $this->config->item('currency').' '.$price; ?>
												</span>
												
												<?php 
												else: 
												/**********
												 * Retail price
												 */
												$price = number_format($this->product_details->less_discount, 2); // --> retail price
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
										<div class="prdname product-form__label" style="margin-top: 0px;margin-bottom: 5px;">
										
											COLOR: &nbsp; &nbsp;
											
											<span class="style1">
											
												<?php
												$url	   = explode('/',$this->uri->uri_string());
												$uri_count = count($url)-2;
												
												for ($i = 0; $i < $uri_count; $i++)
												{
													@$new_url .= $url[$i].'/';
												}
												?>
												
												<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($this->product_details->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name))); ?>" class="pdp--color-name">
													<?php echo $this->product_details->color_name; ?>
												</a>
												
											</span>
										</div>
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Color Swatch
										*/
										?>
										<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($this->product_details->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name))); ?>">
											<img src="<?php echo $PROD_IMG_URL.$img_path.'product_coloricon/'.$this->product_details->prod_no.'_'.$this->product_details->color_code.'.jpg'; ?>" width="20" style="border:1px solid #333;padding:2px;" />
										</a>
										
										<br />
										
										<?php
										/**********
										 * Let's start the form to submit to cart here
										 * Let's make the form encompassing the entire product package page
										 
										<!--bof form========================================================================-->
										<?php
										echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/add_cart', array('name'=>'frmCart', 'method'=>'POST'));
										?>
											<input type="hidden" name="package_details" value="0" />
											<input type="hidden" name="special_sale_prefix" value="<?php echo $this->uri->segment(1) === 'special_sale' ? '1' : '0'; ?>" />
											
											<input type="hidden" name="cat_id" value="<?php echo $this->product_details->cat_id; ?>" />
											<input type="hidden" name="subcat_id" value="<?php echo $this->product_details->subcat_id; ?>" />
											<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
											<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
											<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
											<input type="hidden" name="price" value="<?php echo $price; ?>" />
											<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />
											<input type="hidden" name="label_designer" value="<?php echo $this->product_details->designer_name; ?>" />
											
											<input type="hidden" name="color_code" value="<?php echo $this->product_details->color_code; ?>" />
											<input type="hidden" name="prod_sku" value="<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>" />
											<input type="hidden" name="prod_image" value="<?php echo $img_path.'product_front/thumbs/'.$img_name.'_2.jpg'; ?>" />
											<input type="hidden" name="label_color" value="<?php echo $this->product_details->color_name; ?>" />
										 */
										?>
										
											<?php
											/**********
											 * Will need each colors prod_image url
											 
											<input type="hidden" name="current_url[<?php echo $this->product_details->color_code; ?>]" value="<?php echo current_url(); ?>" />
											 */
											?>
											<input type="hidden" name="prod_image[<?php echo $this->product_details->color_code; ?>]" value="<?php echo $img_path.'product_front/thumbs/'.$this->product_details->prod_no.'_'.$this->product_details->color_code.'_2.jpg'; ?>" />
											<?php echo form_hidden('current_url['.$this->product_details->color_code.']', current_url()); ?>
											
											<?php if ($this->product_details->size_mode == '1'): ?>
											
											<?php
											/**********
											 * Size input box - hidden
											 * Currently not utilized at wholesale pages
											 */
											?>
											<input type="hidden" id="size-<?php echo $this->product_details->color_code; ?>" name="size" value="" />
											
											<?php endif; ?>
											
											<style>
											.details.unavailable {
												display: none;
												position: absolute;
												left: 30px;
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
												
												<?php if ($this->product_details->size_mode == '1' OR $this->product_details->size_mode == '0'): ?>
												
												top: 30px;
												width: 110px;
												
												<?php else: ?>
												
												bottom: 0px;
												
												<?php endif; ?>
											}
											.diagonal-line {
												width: 42px;
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
												display: block;
												width: <?php echo ($this->product_details->size_mode == '1' OR $this->product_details->size_mode == '0') ? '230px': '300px'; ?>;
											}
											.product-form__list-item a {
												width: 25px;
											}
											.product-form__quantity-input {
												margin-top: 0px;
												/*float: right;*/
											}
											.product-form__quantity-input-wholesale {
												left: 95px;
											}
											.product-form__list-item label.error {
												display: none;
											}
											
											<?php if ($this->product_details->size_mode == '1' OR $this->product_details->size_mode == '0'): ?>
											
											.product-form__heading-size-qty {
												position: relative;
												margin-top: 10px;
												width: 230px;
											}
											
											<?php endif; ?>
											
											</style>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Size (selected item)
											*/
											?>
											
											<?php if ($this->product_details->size_mode == '10'): ?>
											
											<span class="prdname product-form__label available-sizes" style="margin-top:10px;"><span class="key  product-form__label  product-form__label--alt uppercase span-quantity-label">quantity:</span><strong>AVAILABLE SIZES:</strong> </span>
											
											<?php
											/**********
											 * Size input box - hidden
											 */
											?>
											<input type="hidden" id="size-<?php echo $this->product_details->color_code; ?>" name="size" value="" />
											
											<div class="product-form__sizes  display-dependency clearfix wholesale">
												<ul class="product-form__list">
													
											<?php endif; ?>
											
													<?php
													/**********
													 * Let's get the sizes and it's availablity through stock qty
													 * according to size mode system
													 
													$get_size = $this->query_category->get_size_by_mode($this->product_details->cat_id, $this->product_details->size_mode);
													$check_stock = $this->query_product->check_stock($this->product_details->prod_no, $this->product_details->color_name);
													 */
													$get_size = $this->get_sizes_by_mode->get_sizes($this->product_details->size_mode);
													$check_stock = $this->get_product_stocks->get_stocks($this->product_details->prod_no, $this->product_details->color_name);
													
													if ($get_size):
													
														$o = 1; $s = 1;
														foreach ($get_size as $size):
														
															if($size->size_name == 'S' || $size->size_name == 'M' || $size->size_name == 'L' || $size->size_name == 'XL' || $size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2')
															{
																$size_stock = 'size_s'.strtolower($size->size_name);
															}
															else
															{
																$size_stock = 'size_'.$size->size_name;
															}
															
															if ($size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2') $hide_size_xxl_xl2 = 'display:none;';
															else $hide_size_xxl_xl2 = '';
															
															if ($size_stock != 'size_fs')
															{
																if ($check_stock[$size_stock] > 0)
																{
																	// remove class 'parent-select' from $a_class to unbind click event from built in site.js
																	$a_class = 'input-control product-form__product-size instock';
																	$availability = 'availability--instock';
																}
																else
																{
																	// remove class 'parent-select' from $a_class to unbind click event from built in site.js
																	$a_class = 'input-control product-form__product-size unavailable product-form__product-size--out-of-stock';
																	$availability = 'availability--preorder';
																}
																
																if ($this->uri->segment(1) !== 'special_sale' OR $check_stock[$size_stock] != 0):
													?>
																	<?php if (($this->product_details->size_mode == '1' OR $this->product_details->size_mode == '0') && $o == 1): ?>
																	
											<div class="product-form__sizes  display-dependency <?php echo $s == 9 ? 'clearfix' : ''; ?> wholesale" style="width:45%;display:inline;">
											
												<ul class="product-form__list">
													
													<li class="<?php echo $s > 1 ? 'hidden-on-mobile' : ''; ?>" style="text-align:left;">
														<div class="product-form__heading-size-qty"  style="<?php echo $hide_size_xxl_xl2; ?>">
															<span class="key  product-form__label  product-form__label--alt uppercase span-quantity-label" style="float:right;">quantity:</span><strong><?php echo $this->webspace_details->slug == 'tempoparis' ? 'AVAILABLE' : ''; ?> SIZES:</strong> 
														</div>
													</li>
													
																	<?php endif; ?>
													
													<?php
													/**********
													<!-- DOC: set element to position relative -->
													 */
													?>
													<li class="hoverable product-form__list-item <?php echo $this->product_details->color_code; ?> <?php echo $check_stock[$size_stock] == 0 ? 'pre-order' : 'in-stock'; ?>" style="position:relative;<?php echo $hide_size_xxl_xl2; ?>">
													
														<?php
														/**********
														 * QTY input box
														 original roden consumer
														 qty-<?php echo $product->color_code.'-'.$size->size_name; ?>
														 roden wholesale based on old defaul wholesale
														 c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? '0' : 's'.strtolower($size->size_name); ?>
														 
														<input class="product-form__quantity-input product-form__quantity-input-wholesale" id="c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" name="c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" min="0" max="30" value="0" type="number" />
														 */
														?>
														<input class="product-form__quantity-input product-form__quantity-input-wholesale" id="c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" name="<?php echo $this->product_details->color_code; ?>[<?php echo $check_stock[$size_stock] == 0 ? 'pre-order' : 'in-stock'; ?>][<?php echo $size->size_name; ?>]" min="0" max="30" value="0" type="number" />
														
														<?php
														/**********
														 * Size box
														 */
														?>
														<a href="javascript:void();" class="main-size-box <?php echo $a_class; ?>" style="z-index:10;" onmouseover="$('#<?php echo $this->product_details->color_code.'-'.$size_stock; ?>.details.unavailable').show();$('span#diagonal-line-<?php echo $this->product_details->color_code.'-'.$size_stock; ?>').hide();" onmouseout="$('#<?php echo $this->product_details->color_code.'-'.$size_stock; ?>.details.unavailable').hide();$('span#diagonal-line-<?php echo $this->product_details->color_code.'-'.$size_stock; ?>').show();" data-color_code="<?php echo $this->product_details->color_code; ?>" data-availability="<?php echo $availability; ?>" data-cart_button="<?php echo $check_stock[$size_stock] == 0 ? 'preorder' : 'add-to-bag'; ?>" data-size_name="<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" data-custom_order="<?php echo $check_stock[$size_stock] == 0 ? '1' : $this->product_details->custom_order; ?>" onclick="">
															<span><?php echo $size->size_name; ?></span>
														</a>
														<span class="ico"></span>
														
														<?php
														/**********
														 * Tooltips
														 */
														?>
														<?php if ($check_stock[$size_stock] == 0): ?>
														
														<span id="diagonal-line-<?php echo $this->product_details->color_code.'-'.$size_stock; ?>" class="diagonal-line"></span>
														<span id="<?php echo $this->product_details->color_code.'-'.$size_stock; ?>" class="details unavailable">
															<span class="pointer"></span>
															Pre-Order<br />
															Size Not In-Stock<br />
															Delivery is <?php echo @$product_stock_status ? $product_stock_status : '14-16'; ?> Weeks<br />
															From Order Date
														</span>
														
														<?php endif; ?>
														
													</li>
													
																	<?php if ($this->product_details->size_mode == '1' && $o == 4): ?>
													
												</ul>
												
												<?php
												/**********
												 * This is set to zero by default indicating that item is in-stock
												 * Sciprt on click of size box changes this to 1 for pre-order sies
												 */
												if ($s == 12):
												?>
												<input type="hidden" id="custom_order-<?php echo $this->product_details->color_code; ?>" name="custom_order" value="0" />
												
												<?php endif; ?>

											</div>
											
																	<?php 
																	endif;
													
																endif;
															}
															
															$o++; $s++; if ($o == 5) $o = 1;
															
														endforeach;
													endif;
													
													if ($this->product_details->size_mode == '0'): ?>
													
												</ul>
												
												<?php
												/**********
												 * This is set to zero by default indicating that item is in-stock
												 * Sciprt on click of size box changes this to 1 for pre-order sies
												 */
												?>
												<input type="hidden" id="custom_order-<?php echo $this->product_details->color_code; ?>" name="custom_order" value="0" />

											</div>
											
													<?php endif; ?>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Quantity
												removing class="vProduct-packageProductsForm-quantity-0-1" 
											<div class="product-form__qty" style="width:100px;">
												<span class="key  product-form__label  product-form__label--alt  uppercase">quantity:</span>
												<input id="qty-<?php echo $this->product_details->color_code; ?>" class="this->product_details-form__quantity-input" name="qty" min="1" max="30" required="required" value="0" type="number">
											</div>
											*/
											?>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Availability
											*/
											?>
											<span class="product-form__label <?php echo $this->product_details->color_code; ?>" style="margin-top:30px;">
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
											
											<div class="<?php echo $this->product_details->color_code; ?> cart-button cart-button-add-to-bag">
												<input type="submit" class="button button--small--text hidden-on-desktop button--<?php echo $this->webspace_details->slug; ?>" value="Add Item To Bag" onclick="return checkSizeQty<?php echo $this->product_details->color_code; ?>();" />
												<input type="submit" class="button button--small--text hidden-on-mobile button--<?php echo $this->webspace_details->slug; ?>" value="Add Item To Bag" onclick="return checkSizeQty<?php echo $this->product_details->color_code; ?>();" />
											</div>

											<div class="<?php echo $this->product_details->color_code; ?> cart-button cart-button-preorder" style="display:none;">
												<input type="submit" class="button button--small--text hidden-on-desktop button--<?php echo $this->webspace_details->slug; ?> pre-order" value="Pre Order" onclick="return checkSizeQty<?php echo $this->product_details->color_code; ?>();" />
												<input type="submit" class="button button--small--text hidden-on-mobile button--<?php echo $this->webspace_details->slug; ?> pre-order" value="Pre Order" onclick="return checkSizeQty(<?php echo $this->product_details->color_code; ?>);" />
											</div>
											
											<script>
												// size box scripts
												$('.main-size-box').click(function(){
													// toggle parent <li> 'selected' class attribute
													$(this).closest('li').toggleClass('selected');
													// get data
													var color_code = $(this).data('color_code');
													var availability = $(this).data('availability');
													var cart_button = $(this).data('cart_button');
													var size_name = $(this).data('size_name');
													var custom_order = $(this).data('custom_order');
													// suppose to store the size name that is selected
													//$('input#size-<?php echo $this->product_details->color_code; ?>').val('<?php echo $size->size_name; ?>');
													// change the quantity from zero to at least 1
													if ($(this).closest('li').hasClass('selected')) {
														$('#c_<?php echo $this->product_details->prod_no; ?>_' + color_code + '_s_' + size_name).val('1');
													} else {
														$('#c_<?php echo $this->product_details->prod_no; ?>_' + color_code + '_s_' + size_name).val('0');
													}
													// check if any li has pre-order status
													$('li.' + color_code).each(function(){
														if ($(this).hasClass('pre-order') && $(this).hasClass('selected')){
															// toggle respective availability notice
															$('span.' + color_code + ' span.availability').hide();
															$('span.' + color_code + ' span.availability.availability--preorder').show();
															// toggle cart button properties
															$('.' + color_code + '.cart-button').hide();
															$('.' + color_code + '.cart-button-preorder').show();
															return false;
														}else{
															// toggle respective availability notice
															$('span.' + color_code + ' span.availability').hide();
															$('span.' + color_code + ' span.availability.availability--instock').show();
															// toggle cart button properties
															$('.' + color_code + '.cart-button').hide();
															$('.' + color_code + '.cart-button-add-to-bag').show();
														}
													});
													// toggle custom order value for pre-order sizes
													$('#custom_order-' + color_code).val(custom_order);
												});
												
												// cart button check if size and quantity is selected properly
												function checkSizeQty<?php echo $this->product_details->color_code; ?>(){
													
													<?php if ($this->product_details->size_mode == '1'): ?>
													
													var qty1 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_0').value;
													var qty2 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_2').value;
													var qty3 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_4').value;
													var qty4 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_6').value;
													var qty5 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_8').value;
													var qty6 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_10').value;
													var qty7 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_12').value;
													var qty8 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_14').value;
													var qty9 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_16').value;
													var qty10 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_18').value;
													var qty11 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_20').value;
													var qty12 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_22').value;
													
													if (qty1 == 0 && qty2 == 0 && qty3 == 0 && qty4 == 0 && qty5 == 0 && qty6 == 0 && qty7 == 0 && qty8 == 0 && qty9 == 0 && qty10 == 0 && qty11 == 0 && qty12 == 0){
														alert('At least one size quantity must be more than 1.');
														return false;
													}
													
													<?php else: ?>
													
													var qty1 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_ss').value;
													var qty2 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_sm').value;
													var qty3 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_sl').value;
													var qty4 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_sxl').value;
													
													if (qty1 == 0 && qty2 == 0 && qty3 == 0 && qty4 == 0){
														alert('At least one size quantity must be more than 1.');
														return false;
													}
													
													<?php endif; ?>
													
													return true;
												}
											</script>
											
										<?php
										//echo form_close();
										?>
										<!--eof form========================================================================-->
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Product Description
										*/
										?>
										<div class="accordion js-toggleactive clearfix" style="display:none;"><!-- hidden -->

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
							
							<?php
							/**********
							 * For each other COLOR item
							 */
							?>
							<?php //foreach ($get_color_list->result() as $color): ?>
							<?php foreach ($get_color_list as $color): ?>
							
								<?php if ($color->color_name !== $this->product_details->color_name): ?>
								
									<?php
									/**********
									 * Let us first set the images
									 */
									$color_code = $color->color_code;
									
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
									
									$img_large			= $PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg';
									$img_thumb			= $PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_3.jpg';
									$img_video_flv		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.flv';
									$img_video_mp4		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.mp4';
									$img_video_ogv		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.ogv';
									$img_video_webm		= $PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.webm';

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
									?>
							
							<br /><br /><br /><br />
							
							<?php
							/**********
							 * MAIN Image
							 */
							?>
							<div id="product_details_content_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" class="pdp has-fitguide js-set-height  v-product-detailpagetemplate clearfix" data-style-number="<?php echo $this->product_details->prod_no; ?>">
							
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
													
													<a href="<?php echo $img_front_large; ?>" id="zoom-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" class="cloud-zoom" rel="zoomWidth:800,zoomHeight:637,adjustX:0,adjustY:0">
														<img alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_thumb; ?>" />
													</a>
													
													<?php
													/**********
													 * These image are hidden and only shown when mouse hovers
													 * thumbs images on other views
													 */
													?>
													<img class="other-main-views" id="main-front-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" src="<?php echo $img_front_thumb; ?>" />
													<img class="other-main-views" id="main-back-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" src="<?php echo $img_back_thumb; ?>" />
													<img class="other-main-views" id="main-side-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" src="<?php echo $img_side_thumb; ?>" />
													
													<video class="other-main-views" id="main-video-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" width="425" height="637.5" style="display:inline;" autoplay loop>
														<source src="<?php echo $img_video_mp4; ?>" type="video/mp4" onerror="$(this).closest('video').hide();">
														Your browser does not support the video tag.
													</video> 
													
													<div style="display:none;margin-top:10px;"> <!-- hidden -->
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
															
															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_front_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_front_thumb; ?>?$pdpmain$" onerror="$(this).closest('p').hide();" />
																</a>
															</p>
															
															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_back_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_back_thumb; ?>?$pdpmain$" onerror="$(this).closest('p').hide();" />
																</a>
															</p>

															<p class="slick-slide__slide" style="width:450px;">
																<a class="" href="<?php echo $img_side_large; ?>">
																   <img class="img-block" alt="<?php echo $this->product_details->prod_no.' | '.$this->product_details->prod_name; ?> | <?php echo $this->config->item('site_name'); ?> " src="<?php echo $img_side_thumb; ?>?$pdpmain$" onerror="$(this).closest('p').hide();" />
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
										
											<?php echo $this->session->flashdata('flashMsg'); ?>
											
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
												$price = number_format($this->product_details->wholesale_price,2);
												?>
													<?php if ($color->custom_order !== '3'): ?>
													
												<span itemprop="price">[WHOLESALE PRICE] &nbsp; <?php echo $this->config->item('currency').' '.$price; ?></span>
													
													<?php 
													else: 
													$price = number_format($this->product_details->wholesale_price_clearance, 2); // --> clearance price
													?>
												
												<span itemprop="price" style="text-decoration:line-through;">[WHOLESALE PRICE] &nbsp; <?php echo $this->config->item('currency').' '.number_format($this->product_details->wholesale_price,2); ?></span> &nbsp; 
												<span itemprop="price" style="color:red;">
													[CLEARANCE] &nbsp; <?php echo $this->config->item('currency').' '.$price; ?>
												</span>
													
													<?php endif; ?>
												
												<?php 
												elseif ($color->custom_order === '3'): 
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
												//$price = number_format($this->product_details->less_discount, 2); // --> retail price
												?>
												
												<span itemprop="price" style="text-decoration:line-through;">
													<?php echo $this->config->item('currency').' '.number_format($this->product_details->less_discount, 2); ?>
												</span> &nbsp; 
												<span itemprop="price" style="color:red;">
													[ON SALE] &nbsp; <?php echo $this->config->item('currency').' '.$price; ?>
												</span>
												
												<?php 
												else: 
												/**********
												 * Retail price
												 */
												$price = number_format($this->product_details->less_discount, 2); // --> retail price
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
										<div class="prdname product-form__label" style="margin-top: 0px;margin-bottom: 5px;">
										
											COLOR: &nbsp; &nbsp;
											
											<span class="style1">
											
												<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name))); ?>" class="pdp--color-name">
													<?php echo $color->color_name; ?>
												</a>
												
											</span>
										</div>
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Color Swatch
										*/
										?>
										<a href="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name))); ?>">
											<img src="<?php echo $PROD_IMG_URL.$img_path.'product_coloricon/'.$this->product_details->prod_no.'_'.$color->color_code.'.jpg'; ?>" width="20" style="border:1px solid #333;padding:2px;" />
										</a>
										
										<br />
										
										<?php
										/**********
										 * Let's start the form to submit to cart here
										 
										<!--bof form========================================================================-->
										<?php
										echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/add_cart', array('name'=>'frmCart', 'method'=>'POST'));
										?>
											<input type="hidden" name="package_details" value="0" />
											<input type="hidden" name="special_sale_prefix" value="<?php echo $this->uri->segment(1) === 'special_sale' ? '1' : '0'; ?>" />
											
											<input type="hidden" name="cat_id" value="<?php echo $this->product_details->cat_id; ?>" />
											<input type="hidden" name="subcat_id" value="<?php echo $this->product_details->subcat_id; ?>" />
											<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
											<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
											<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
											<input type="hidden" name="price" value="<?php echo $price; ?>" />
											<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />
											<input type="hidden" name="label_designer" value="<?php echo $this->product_details->designer_name; ?>" />
											
											<input type="hidden" name="color_code" value="<?php echo $color->color_code; ?>" />
											<input type="hidden" name="prod_sku" value="<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>" />
											<input type="hidden" name="prod_image" value="<?php echo $img_path.'product_front/thumbs/'.$img_name.'_2.jpg'; ?>" />
											<input type="hidden" name="label_color" value="<?php echo $color->color_name; ?>" />
										 */
										?>
											
											<?php
											/**********
											 * Will need each colors prod_image url
											 
											<input type="hidden" name="current_url[<?php echo $color->color_code; ?>]" value="<?php echo site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name))); ?>" />
											 */
											?>
											<input type="hidden" name="prod_image[<?php echo $color->color_code; ?>]" value="<?php echo $img_path.'product_front/thumbs/'.$this->product_details->prod_no.'_'.$color->color_code.'_2.jpg'; ?>" />
											<?php echo form_hidden('current_url['.$color->color_code.']', site_url($new_url.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.str_replace('/','-',str_replace(' ','-',$this->product_details->prod_name)))); ?>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Size (other items)
											*/
											?>
											
											<?php if ($this->product_details->size_mode == '0'): ?>
											
											<span class="prdname product-form__label available-sizes" style="margin-top:10px;"><span class="key  product-form__label  product-form__label--alt uppercase span-quantity-label">quantity:</span><strong>AVAILABLE SIZES:</strong> </span>
											
											<?php endif; ?>
											
											<input type="hidden" id="size-<?php echo $color->color_code; ?>" name="size" value="" />
											
											<?php
											/**********
											 * Inline styles to customize diagonal-line, tooltip.deatils.unavailable,
											 * and some of the items in the product list item.
											 * In wholesale, this stylesheet is already in the first product color item.
											 * We don't need this here within the loop anymore...
											 */
											?>
											<style>
											</style>
											
											<?php if ($this->product_details->size_mode == '0'): ?>
											
											<div class="product-form__sizes  display-dependency clearfix">
												<ul class="product-form__list">
												
											<?php endif; ?>
													
													<?php
													/**********
													 * Let's get the sizes and it's availablity through stock qty
													 * according to size mode system
													 
													$get_size = $this->query_category->get_size_by_mode($this->product_details->cat_id, $this->product_details->size_mode);
													$check_stock = $this->query_product->check_stock($this->product_details->prod_no, $color->color_name);
													 */
													$get_size = $this->get_sizes_by_mode->get_sizes($this->product_details->size_mode);
													$check_stock = $this->get_product_stocks->get_stocks($this->product_details->prod_no, $color->color_name);
													
													if ($get_size)
													{
														$o = 1; $s = 1;
														foreach ($get_size as $size)
														{
															if($size->size_name == 'S' || $size->size_name == 'M' || $size->size_name == 'L' || $size->size_name == 'XL' || $size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2')
															{
																$size_stock = 'size_s'.strtolower($size->size_name);
															}
															else
															{
																$size_stock = 'size_'.$size->size_name;
															}
														
															if ($size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2') $hide_size_xxl_xl2 = 'display:none;';
															else $hide_size_xxl_xl2 = '';
															
															if ($size_stock != 'size_fs')
															{
																if ($check_stock[$size_stock] > 0)
																{
																	// remove class 'parent-select' from $a_class 
																	$a_class = 'input-control product-form__product-size instock';
																	$availability = 'availability--instock';
																}
																else
																{
																	// remove class 'parent-select' from $a_class 
																	$a_class = 'input-control product-form__product-size unavailable product-form__product-size--out-of-stock';
																	$availability = 'availability--preorder';
																}
																
																if ($this->uri->segment(1) !== 'special_sale' OR $check_stock[$size_stock] != 0):
													?>
																	<?php if ($this->product_details->size_mode == '1' && $o == 1): ?>
													
											<div class="product-form__sizes  display-dependency <?php echo $s == 9 ? 'clearfix' : ''; ?> wholesale" style="width:45%;display:inline;">
											
												<ul class="product-form__list">
													
													<li class="<?php echo $s > 1 ? 'hidden-on-mobile' : ''; ?>" style="text-align:left;">
														<div class="product-form__heading-size-qty">
															<span class="key  product-form__label  product-form__label--alt uppercase span-quantity-label">quantity:</span><strong><?php echo $this->webspace_details->slug == 'tempoparis' ? 'AVAILABLE' : ''; ?> SIZES:</strong> 
														</div>
													</li>
													
																	<?php endif; ?>
													
													<li class="hoverable product-form__list-item <?php echo $color->color_code; ?> <?php echo $check_stock[$size_stock] == 0 ? 'pre-order' : 'in-stock'; ?>" style="position:relative;<?php echo $hide_size_xxl_xl2; ?>">
													
														<?php
														/**********
														 * QTY input box
														 original roden consumer
														 qty-<?php echo $product->color_code.'-'.$size->size_name; ?>
														 roden wholesale based on old defaul wholesale
														 c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? '0' : 's'.strtolower($size->size_name); ?>
														 
														<input class="product-form__quantity-input product-form__quantity-input-wholesale" id="c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" name="c_<?php echo $this->product_details->prod_no.'_'.$this->product_details->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" min="0" max="30" value="0" type="number" />
														 */
														?>
														<input class="product-form__quantity-input product-form__quantity-input-wholesale" id="c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" name="<?php echo $color->color_code; ?>[<?php echo $check_stock[$size_stock] == 0 ? 'pre-order' : 'in-stock'; ?>][<?php echo $size->size_name; ?>]" min="0" max="30" value="0" type="number" />
														
														<?php
														/**********
														 * Size box
														 */
														?>
														<a href="javascript:void();" class="sub-size-box <?php echo $a_class; ?>" style="z-index:10;" onmouseover="$('#<?php echo $color->color_code.'-'.$size_stock; ?>.details.unavailable').show();$('span#diagonal-line-<?php echo $color->color_code.'-'.$size_stock; ?>').hide();" onmouseout="$('#<?php echo $color->color_code.'-'.$size_stock; ?>.details.unavailable').hide();$('span#diagonal-line-<?php echo $color->color_code.'-'.$size_stock; ?>').show();" data-color_code="<?php echo $color->color_code; ?>" data-availability="<?php echo $availability; ?>" data-cart_button="<?php echo $check_stock[$size_stock] == 0 ? 'preorder' : 'add-to-bag'; ?>" data-size_name="<?php echo $this->product_details->size_mode == '1' ? $size->size_name : 's'.strtolower($size->size_name); ?>" data-custom_order="<?php echo $check_stock[$size_stock] == 0 ? '1' : $color->custom_order; ?>" onclick="">
															<span><?php echo $size->size_name; ?></span>
														</a>
														<span class="ico"></span>
														
														<?php
														/**********
														 * Tooltips
														 */
														?>
														<?php if ($check_stock[$size_stock] == 0): ?>
														<span id="diagonal-line-<?php echo $color->color_code.'-'.$size_stock; ?>" class="diagonal-line"></span>
														<span id="<?php echo $color->color_code.'-'.$size_stock; ?>" class="details unavailable">
															<span class="pointer"></span>
															Pre-Order<br />
															Size Not In-Stock<br />
															Delivery is <?php echo @$product_stock_status ? $product_stock_status : '12'; ?> Weeks<br />
															From Order Date
														</span>
														<?php endif; ?>
														
													</li>
													
																	<?php if ($this->product_details->size_mode == '1' && $o == 4): ?>
																	
												</ul>
												
												<?php
												/**********
												 * This is set to zero by default indicating that item is in-stock
												 * Sciprt on click of size box changes this to 1 for pre-order sies
												 */
												if ($s == 12):
												?>
												<input type="hidden" id="custom_order-<?php echo $this->product_details->color_code; ?>" name="custom_order" value="0" />
												
												<?php endif; ?>

											</div>
											
																	<?php 
																	endif;
													
																endif;
															}
															
															$o++; $s++; if ($o == 5) $o = 1;
														}
													}
													?>
											
													<?php if ($this->product_details->size_mode == '0'): ?>
													
												</ul>
												
												<?php
												/**********
												 * This is set to zero by default indicating that item is in-stock
												 * Sciprt on click of size box changes this to 1 for pre-order sies
												 */
												?>
												<input type="hidden" id="custom_order-<?php echo $color->color_code; ?>" name="custom_order" value="0" />

											</div>
											
													<?php endif; ?>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Quantity
											<div class="product-form__qty" style="width:100px;">
												<span class="key  product-form__label  product-form__label--alt  uppercase">quantity:</span>
												<input id="qty-<?php echo $color->color_code; ?>" class="product-form__quantity-input" name="qty" min="1" max="30" required="required" value="0" type="number">
											</div>
											*/
											?>
											
											<?php
											/*
											| ------------------------------------------------------------------------------------
											| Availability
											*/
											?>
											<span class="product-form__label <?php echo $color->color_code; ?>" style="margin-top:30px;">
												<strong>AVAILABILITY:</strong>
												<br class="hidden-on-desktop"/>&nbsp;
												<span class="availability availability--default">
													SELECT YOUR SIZE FOR SHIPPING AVAILABILITY
												</span>
												<span class="availability availability--instock" style="display:none;">
													SHIPS WITHIN 5-7 BUSINESS DAYS
												</span>
												<span class="availability availability--preorder" style="display:none;color:red;">
													Item ships approximately 12 weeks from date of order
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
											
											<div class="<?php echo $color->color_code; ?> cart-button cart-button-add-to-bag">
												<input type="submit" class="button button--small--text hidden-on-desktop button--<?php echo $this->webspace_details->slug; ?>" value="Add Item To Bag" onclick="return checkSizeQty<?php echo $color->color_code; ?>();" />
												<input type="submit" class="button button--small--text hidden-on-mobile button--<?php echo $this->webspace_details->slug; ?>" value="Add Item To Bag" onclick="return checkSizeQty<?php echo $color->color_code; ?>();" />
											</div>

											<div class="<?php echo $color->color_code; ?> cart-button cart-button-preorder" style="display:none;">
												<input type="submit" class="button button--small--text hidden-on-desktop button--<?php echo $this->webspace_details->slug; ?> pre-order" value="Pre Order" onclick="return checkSizeQty<?php echo $color->color_code; ?>();" />
												<input type="submit" class="button button--small--text hidden-on-mobile button--<?php echo $this->webspace_details->slug; ?> pre-order" value="Pre Order" onclick="return checkSizeQty<?php echo $color->color_code; ?>();" />
											</div>
											
											<script>
												// cart button check if size and quantity is selected properly
												function checkSizeQty<?php echo $color->color_code; ?>(){

													<?php if ($this->product_details->size_mode == '1'): ?>
													
													var qty1 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_0').value;
													var qty2 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_2').value;
													var qty3 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_4').value;
													var qty4 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_6').value;
													var qty5 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_8').value;
													var qty6 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_10').value;
													var qty7 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_12').value;
													var qty8 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_14').value;
													var qty9 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_16').value;
													var qty10 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_18').value;
													var qty11 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_20').value;
													var qty12 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_22').value;
													
													if (qty1 == 0 && qty2 == 0 && qty3 == 0 && qty4 == 0 && qty5 == 0 && qty6 == 0 && qty7 == 0 && qty8 == 0 && qty9 == 0 && qty10 == 0 && qty11 == 0 && qty12 == 0){
														alert('At least one size quantity must be more than 1.');
														return false;
													}
													
													<?php else: ?>
													
													var qty1 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_ss').value;
													var qty2 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_sm').value;
													var qty3 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_sl').value;
													var qty4 = document.getElementById('c_<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>_s_sxl').value;
													
													if (qty1 == 0 && qty2 == 0 && qty3 == 0 && qty4 == 0){
														alert('At least one size quantity must be more than 1.');
														return false;
													}
													
													<?php endif; ?>
													
													return true;
												}
											</script>
											
										<?php
										//echo form_close();
										?>
										<!--eof form========================================================================-->
										
										<?php
										/*
										| ------------------------------------------------------------------------------------
										| Product Description
										*/
										?>
										<div class="accordion js-toggleactive clearfix" style="display:none;"><!-- hidden -->

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
												<a href='<?php echo $img_front_large; ?>' class="cloud-zoom-gallery" title="Front view" rel="useZoom: 'zoom-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>', smallImage: '<?php echo $img_front_thumb; ?>'" onmouseover="showObj('main-front-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>').remove();">
													<img src="<?php echo $img_front; ?>" alt="Front View" style="border:1px solid #333;" onerror="$(this).closest('div').hide();" />
												</a>
											</div>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_back_large; ?>' class="cloud-zoom-gallery" title="Back view" rel="useZoom: 'zoom-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>', smallImage: '<?php echo $img_back_thumb; ?>'" onmouseover="showObj('main-back-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>').remove();">
													<img src="<?php echo $img_back; ?>" alt="Back View" style="border:1px solid #333;" onerror="$(this).closest('div').hide();" />
												</a>
											</div>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;">
												<a href='<?php echo $img_side_large; ?>' class="cloud-zoom-gallery" title="Side view" rel="useZoom: 'zoom-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>', smallImage: '<?php echo $img_side_thumb; ?>'" onmouseover="showObj('main-side-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>', this)" onmouseout="closetime()" onclick="$('#the-product_video-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>').remove();">
													<img src="<?php echo $img_side; ?>" alt="Side View" style="border:1px solid #333;" onerror="$(this).closest('div').hide();" />
												</a>
											</div>
											
											<div style="display:inline-block;width:60px;height:90px;text-align:center;vertical-align:middle;" onmouseover="showObj('main-video-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>', this)" onmouseout="closetime()" onclick="$('#zoom-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>').append('<video width=\'425\' height=\'637.5\' id=\'the-product_video-<?php echo $this->product_details->prod_no.'_'.$color->color_code; ?>\' style=\'border:1px solid #333;background:black;display:inline;position:absolute;top:0px;\' autoplay loop ><source src=\'<?php echo $img_video_mp4; ?>\' type=\'video/mp4\'>Your browser does not support the video tag.</video>');">
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
							
								<?php endif; ?>
							
							<?php endforeach; ?>
							
							<script>
							// size box scripts
							$('.sub-size-box').click(function(){
								// toggle parent <li> 'selected' class attribute
								$(this).closest('li').toggleClass('selected');
								// get data
								var color_code = $(this).data('color_code');
								var availability = $(this).data('availability');
								var cart_button = $(this).data('cart_button');
								var size_name = $(this).data('size_name');
								var custom_order = $(this).data('custom_order');
								// suppose to store the size name that is selected
								//$('input#size-<?php echo $this->product_details->color_code; ?>').val('<?php echo $size->size_name; ?>');
								// change the quantity from zero to at least 1
								if ($(this).closest('li').hasClass('selected')) {
									$('#c_<?php echo $this->product_details->prod_no; ?>_' + color_code + '_s_' + size_name).val('1');
								} else {
									$('#c_<?php echo $this->product_details->prod_no; ?>_' + color_code + '_s_' + size_name).val('0');
								}
								// check if any li has pre-order status
								$('li.' + color_code).each(function(){
									if ($(this).hasClass('pre-order') && $(this).hasClass('selected')){
										// toggle respective availability notice
										$('span.' + color_code + ' span.availability').hide();
										$('span.' + color_code + ' span.availability.availability--preorder').show();
										// toggle cart button properties
										$('.' + color_code + '.cart-button').hide();
										$('.' + color_code + '.cart-button-preorder').show();
										return false;
									}else{
										// toggle respective availability notice
										$('span.' + color_code + ' span.availability').hide();
										$('span.' + color_code + ' span.availability.availability--instock').show();
										// toggle cart button properties
										$('.' + color_code + '.cart-button').hide();
										$('.' + color_code + '.cart-button-add-to-bag').show();
									}
								});
								// toggle custom order value for pre-order sizes
								$('#custom_order-' + color_code).val(custom_order);
							});
							</script>
							
										<?php
										echo form_close();
										?>
										<!--eof form========================================================================-->
										
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->
