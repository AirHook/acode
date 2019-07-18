					<?php
					/**********
					 * CONTENT
					 
							<style>
							@media screen and (max-width: 769px) {
								.browseoptions {
									display: none;
								}
							}
							</style>
					 */
					 
					// hiding filters on mobile devices using css
					?>
	
					<div id="content" class="content with-side-container clearfix" name="product_thumbs">
					
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<?php
							/**********
							 * Side Nav
							 */
							$this->load->view($this->config->slash_item('template').'product_thumbs_sidebar_'.$this->config->item('site_slug'));
							?>
							
							<?php
							/**********
							 * Right side content
							 */
							?>
                            <div class="wl-grid">
                                <div class="col col-12of12">
								
									<div class="v-product-browsepagetemplate">
									
										<?php
										/**********
										 * Top options div
										 */
										?>
										<div class="browseoptions browseoptions-top clearfix">
										
											<?php $this->load->view($this->config->slash_item('template').'product_thumbs_filter'); ?>
											
										</div>

										<?php
										/**********
										 * Product thumbnails section
										 */
										?>
										<div class="wl-browse-thumbs clearfix" data-source="v-product-thumbnails">
										
													<?php if ($view_pane_sql->num_rows() > 0): ?>
													
											<div class="products-wrap products-large">
												<div class="products clearfix">
												
													<?php
													/**********
													 * The THUMB with hover effect
													 */
													?>
													
														<?php
														$i_thumb = 1;
														foreach ($view_pane_sql->result() as $thumb):
														
															if ($thumb->with_stocks == '0')
															{
																$i_thumb++;
																continue;
															}
															
														/**********
														 * This section is taken from the old "default" theme
														 * and being reused here.
														 */
														// query the available colors
														$colors = $this->query_product->get_available_colors($thumb->prod_no, $custom_order);
														
														// assign the primary images
														$img_url		= 'product_assets/'.$thumb->cat_folder.'/'.$thumb->folder.'/'.$thumb->subcat_folder.'/';
														$set_color_code = $this->uri->segment(1) === 'special_sale' ? $thumb->color_code : $thumb->primary_img_id;
														
														$img_thumb 	    = $img_url.'product_front/thumbs/'.$thumb->prod_no.'_'.$set_color_code.'_4.jpg';
														//$img_thumb_back = $img_url.'product_back/thumbs/'.$thumb->prod_no.'_'.$set_color_code.'_4.jpg';
														//$img_thumb_side = $img_url.'product_side/thumbs/'.$thumb->prod_no.'_'.$set_color_code.'_4.jpg';
														//$img_video 		= $img_url.'product_video/'.$thumb->prod_no.'_'.$set_color_code.'.flv';

														// check images and set default logo where necessary
														$local_path = 'C:\Users\Bongbong\Documents\Websites\joetaveras\instylenewyork\httpdocs\\';
														$img = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$img_thumb)) : @GetImageSize($this->config->item('PROD_IMG_URL').$img_thumb);
														//$img2 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$img_thumb_back)) : @GetImageSize($this->config->item('PROD_IMG_URL').$img_thumb_back);
														//$img3 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$img_thumb_side)) : @GetImageSize($this->config->item('PROD_IMG_URL').$img_thumb_side);
														
														if ($img)
														{
															$thumbnail = $this->config->item('PROD_IMG_URL').$img_thumb;
															//if ($img2)
															//{
															//	$back = $this->config->item('PROD_IMG_URL').$img_thumb_back;
															//}
															//else
															//{
															//	if ($img3)
															//	{
															//		$back = $this->config->item('PROD_IMG_URL').$img_thumb_side;
															//	}
															//	else
															//	{
															//		$back = $this->config->item('PROD_IMG_URL').$img_thumb;
															//	}
															//}
														}
														else
														{
															$thumbnail  = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
															//$back  		= $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
														}
														
														$seg = ($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').$thumb->d_url_structure . '/' . $thumb->prod_no. '/' . str_replace(' ','-',strtolower(trim($thumb->color_name))).'/' . str_replace(' ','-',strtolower(trim($thumb->prod_name)));
														
														// the item coloricon / swatch
														$color_icon = $this->config->item('PROD_IMG_URL').$img_url.'product_coloricon/'.$thumb->prod_no.'_'.$set_color_code.'.jpg';
														?>
														
													<style>
													.swatches .swatch-image {
														border-radius: 0;
													}
													</style>
													
													<div class="product hoverable" data-with-stocks="<?php echo $thumb->with_stocks; ?>">
													
														<!-- image <?php echo $this->config->item('PROD_IMG_URL').$img_thumb; ?> -->
														<!-- image <?php echo site_url($seg); ?> -->
														<div class="image" style="position:relative;">
														
															<!-- Just a font awesome icon of rotating dots to indicate loading -->
															<div class="loading">Loading&#8230;</div>
															
															<?php
															/**********
															 * This transparent image here is used to occupy the thumbs placeholder
															 * As such, only one image is loaded for all the placeholder
															 */
															?>
															<img src="<?php echo $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.png'; ?>" />
															
															<?php
															/**********
															 * Start of image thumbs
															 */
															?>
															<div class="primary" onmouseover="$('.alt-image-<?php echo $thumb->prod_no.'_'.$thumb->primary_img_id; ?>').hide();" onmouseout="$('.alt-image-<?php echo $thumb->prod_no.'_'.$thumb->primary_img_id; ?>').show();">
															
																<?php
																/**********
																 * Source Site used a class "js-use-rollovers" on the <a> tag
																 * to somehow initiate a script or css trick to apply a image switching
																 * on mouse over... since alt image is removed (commented), we need to
																 * remove the class item from the <a> tag
																 */
																?>
													
																<a href="<?php echo site_url($seg); ?>" title="<?php echo $thumb->prod_name; ?>" class="">
																	
																	<?php
																	/**********
																	 * Due to some source template inherent script and css issues,
																	 * had to swap src="" of primary-img and alt-image for mouseove
																	 * to take effect. Mouse over effect is simply the javascript
																	 * on parent div tag class="primary"
																	 *
																	 * 20160929 - disablign lazy loading by renaming class 'lazy' to 'lazy__'
																	 * due to mid page reload error
																	 
																	<img class="primary-img" src="<?php echo $back; ?>" alt="<?php echo $thumb->prod_name; ?>" />
																	 */
																	?>
																	
																	<img class="primary-img" src="<?php echo $thumbnail; ?>" alt="<?php echo $thumb->prod_name; ?>" />
																	
																	<?php
																	/**********
																	 * Initially removed this alt image but had to bring it back
																	 * However, we are not using the "js-use-rollovers" as noted in 
																	 * the above comment but instead added an inline havascript
																	 * at the parent div with class="primary"
																	
																	<img class="alt-image alt-image-<?php echo $thumb->prod_no.'_'.$thumb->primary_img_id; ?>" src="<?php echo $thumbnail; ?>" alt="<?php echo $thumb->prod_name; ?>" style="position:absolute;left:0;top:0;" />
																	 */
																	?>
																
																	<?php
																	/**********
																	 * Iterating through available colors in order to load other colors 
																	 * product thumbs for swatch mouse over effect
																	 */
																	?>
																	
																	<?php /*
																	foreach($colors as $color)
																	{
																		if ($color->color_code != $thumb->primary_img_id)
																		{
																			// assign the primary images
																			$sub_img_thumb = $img_url.'product_front/thumbs/'.$thumb->prod_no.'_'.$color->color_code.'_4.jpg';
																			$sub_img_thumb_back = $img_url.'product_back/thumbs/'.$thumb->prod_no.'_'.$color->color_code.'_4.jpg';
																			$sub_img_thumb_side = $img_url.'product_side/thumbs/'.$thumb->prod_no.'_'.$color->color_code.'_4.jpg';
																			$sub_img_video = $img_url.'product_video/'.$thumb->prod_no.'_'.$color->color_code.'.flv';

																			// check images and set default logo where necessary
																			$sub_img = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$sub_img_thumb)) : @GetImageSize($this->config->item('PROD_IMG_URL').$sub_img_thumb);
																			$sub_img2 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$sub_img_thumb_back)) : @GetImageSize($this->config->item('PROD_IMG_URL').$sub_img_thumb_back);
																			$sub_img3 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$sub_img_thumb_side)) : @GetImageSize($this->config->item('PROD_IMG_URL').$sub_img_thumb_side);
																			
																			if ($sub_img)
																			{
																				$sub_thumbnail = $this->config->item('PROD_IMG_URL').$sub_img_thumb;
																				if ($sub_img2)
																				{
																					$sub_back = $this->config->item('PROD_IMG_URL').$sub_img_thumb_back;
																				}
																				else
																				{
																					if ($sub_img3)
																					{
																						$sub_back = $this->config->item('PROD_IMG_URL').$sub_img_thumb_side;
																					}
																					else
																					{
																						$sub_back = $this->config->item('PROD_IMG_URL').$sub_img_thumb;
																					}
																				}
																			}
																			else
																			{
																				$sub_thumbnail  = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
																				$sub_back  		= $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
																			}
																			?>
																		
																	<img class="alt-image hidden" src="<?php echo $sub_thumbnail; ?>" alt="<?php echo $thumb->prod_name; ?>" id="<?php echo $thumb->prod_no.'_'.$color->color_code; ?>" style="position:absolute;top:0;left:0;"/>
																	
																		<?php 
																		}
																	}*/
																	?>
																	
																</a>
																
															</div>
														</div>
														
												<?php
												/**********
												 * Product Details Info
												 * (under the thumb)
												 */
												?>
														<!-- Info -->
														<div class="info" style="margin-top:10px;">
															<?php
															/**********
															 * Product Name
															 */
															?>
															<h3 class="info-product-name">
																<a href="<?php echo site_url($seg); ?>" title="<?php echo $thumb->prod_name; ?>">
																	<?php echo $thumb->prod_name; ?>
																</a>
															</h3>
															<?php
															/**********
															 * Product No
															 */
															?>
															<h3 class="info-product-number">
																<?php echo $thumb->prod_no; ?>
															</h3>
															<?php
															/**********
															 * Price (hidden on satelite sites)
															 */
															$price_class = ($this->config->item('site_slug') === 'instylenewyork') ? '' : 'hidden';
															?>
															<div class="prices info-product-price <?php echo $price_class; ?>">
																<div class="price">
																	<span itemprop="price" <?php echo $thumb->custom_order === '3' ? 'style="text-decoration:line-through;"' : '';?>>
																		<!--&#36;<span>5</span>70.00-->
																		<?php
																		/**********
																		 * Wholeslae price
																		 */
																		if ($this->session->userdata('user_cat') == 'wholesale') $price = number_format($thumb->wholesale_price, 2);
																		/**********
																		 * Retail price
																		 */
																		else $price = number_format($thumb->less_discount, 2);
																		echo $this->config->item('currency').$price;
																		?>
																	</span>
																	<?php if ($thumb->custom_order === '3'): ?>
																	<br />
																	<span itemprop="price" style="color:red;">
																		<?php 
																		/**********
																		 * Wholeslae price clearance
																		 */
																		if ($this->session->userdata('user_cat') == 'wholesale') $price = number_format($thumb->wholesale_price_clearance, 2);
																		/**********
																		 * On Sale price consumer
																		 */
																		else $price = number_format($thumb->catalogue_price, 2);
																		echo $this->config->item('currency').$price; 
																		?>
																	<span>
																	<?php endif; ?>
																</div>
															</div>
															<?php
															/**********
															 * Color Swatches
															 * 
															 * Swatches - the first on the list is the default which is why only one list
															 * for other items with one color option only
															 * A click of the other swatches will change the image and data as per data
															 * attribute on the list item
															 *
															 * NOTE: an item thumb can only hold upto 5 color swatches with the 6th a plus
															 * '+' sign indicating that there are more colors available for the product 
															 * that can be seen on the product details page
															 *
															 * NOTE: For only one color item products, a <ul> class "swatches-hidden" is added
															 * hiding the swatches. Unhide for items with more than one color swatch
															 * 
															 * NOTE: First swatch is always the selected, hence, the <li> class
															 * "selected" is added.
															 <?php echo count($colors) == 1 ? 'swatches-hidden ' : ' '; ?>
															 */
															?>
															<ul class="swatches clearfix">
																<?php
																/**********
																 * If js is present, the data here overrides the info at the
																 * class="image" div tag
																 * data-url = the <a> href which leads to the product details page
																 * data-color-option-id = by roden adds the option to the data-url
																 * data-images = both front and hover image separated in comma
																 * other data - i'm not sure how it is being carried over
																 * we only use what we need
																 *
																 * NOTE that this is where the available colors is also shown and
																 * by script, a click on the swatch changes the image and the link
																 * 
																 * NOTE: First swatch is always the selected, hence, the <li> class
																 * "selected" is added.
																 *
																 * Original <li> tag with the different data attributes

																<li class="swatch selected">
																	<a class="swatch-link parent-select" href="" data-url="<?php echo base_url(); ?>" data-color-option-id="<?php echo $seg; ?>" data-images="<?php echo $thumbnail; ?>,<?php echo $back; ?>" data-price='' data-saleprice='' data-displayoriginalprice=''>
																		<img class="swatch-image" src="<?php echo $color_icon; ?>" alt="<?php echo $thumb->prod_no; ?> <?php echo ucfirst(strtolower(trim($thumb->color_name))); ?>">
																	</a>
																</li>
																
																 * Edit swatch below to allow click through to product details page
																 * site.js is also edited for this purpose
																 */
																?>
																<li class="swatch selected">
																	<a class="swatch-link parent-select" href="<?php echo site_url($seg); ?>" title="<?php echo ucfirst(strtolower(trim($thumb->color_name))); ?>">
																	
																		<?php if (@GetImageSize($color_icon)): ?>
																		
																		<img class="swatch-image" src="<?php echo $color_icon; ?>">
																		
																		<?php else: ?>
																		
																		<img class="swatch-image" src="<?php echo base_url('images/colorsample.jpg'); ?>">
																		
																		<?php endif; ?>
																		
																	</a>
																</li>
																
																<?php foreach($colors as $color): ?>
																
																	<?php if ($color->color_code != $set_color_code): ?>
																	
																		<?php
																		// assign the primary images
																		$sub_img_thumb = $img_url.'product_front/thumbs/'.$thumb->prod_no.'_'.$color->color_code.'_4.jpg';
																		$sub_img_thumb_back = $img_url.'product_back/thumbs/'.$thumb->prod_no.'_'.$color->color_code.'_4.jpg';
																		$sub_img_thumb_side = $img_url.'product_side/thumbs/'.$thumb->prod_no.'_'.$color->color_code.'_4.jpg';
																		$sub_img_video = $img_url.'product_video/'.$thumb->prod_no.'_'.$color->color_code.'.flv';

																		// check images and set default logo where necessary
																		$sub_img = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$sub_img_thumb)) : @GetImageSize($this->config->item('PROD_IMG_URL').$sub_img_thumb);
																		$sub_img2 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$sub_img_thumb_back)) : @GetImageSize($this->config->item('PROD_IMG_URL').$sub_img_thumb_back);
																		$sub_img3 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.str_replace('/','\\',$sub_img_thumb_side)) : @GetImageSize($this->config->item('PROD_IMG_URL').$sub_img_thumb_side);
																		
																		if ($sub_img)
																		{
																			$sub_thumbnail = $this->config->item('PROD_IMG_URL').$sub_img_thumb;
																			if ($sub_img2)
																			{
																				$sub_back = $this->config->item('PROD_IMG_URL').$sub_img_thumb_back;
																			}
																			else
																			{
																				if ($sub_img3)
																				{
																					$sub_back = $this->config->item('PROD_IMG_URL').$sub_img_thumb_side;
																				}
																				else
																				{
																					$sub_back = $this->config->item('PROD_IMG_URL').$sub_img_thumb;
																				}
																			}
																		}
																		else
																		{
																			$sub_thumbnail  = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
																			$sub_back  		= $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
																		}
																		
																		// the product details page link through
																		$sub_seg = $thumb->d_url_structure . '/' . $thumb->prod_no. '/' . str_replace(' ','-',strtolower(trim($color->color_name))).'/' . str_replace(' ','-',strtolower(trim($thumb->prod_name)));
																		
																		// the item coloricon / swatch
																		$sub_color_icon = $this->config->item('PROD_IMG_URL').$img_url.'product_coloricon/'.$thumb->prod_no.'_'.$color->color_code.'.jpg';
																		
																		/**************
																		 * Original <li> tag with the different data attributes on <a> tag
																		 
																<li class="swatch">
																	<a class="swatch-link parent-select" href="" data-url="<?php echo base_url(); ?>" data-color-option-id="<?php echo $sub_seg; ?>" data-images="<?php echo $sub_thumbnail; ?>,<?php echo $sub_back; ?>" data-price="" data-saleprice="" data-displayoriginalprice="">
																		<img class="swatch-image" src="<?php echo $sub_color_icon; ?>" alt="<?php echo $thumb->prod_no; ?> <?php echo ucfirst(strtolower(trim($color->color_name))); ?>">
																	</a>
																</li>
																		
																		 * Had to edit swatches to show the respective product thumb 
																		 * on mouse over
																		 */
																		?>
																	
																<li class="swatch">
																	<a class="swatch-link parent-select" href="<?php echo site_url($sub_seg); ?>" title="<?php echo ucfirst(strtolower(trim($color->color_name))); ?>">
																	
																		<?php if (@GetImageSize($sub_color_icon)): ?>
																		
																		<img class="swatch-image" src="<?php echo $sub_color_icon; ?>" alt="" onmouseover="document.getElementById('<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').style.display='block';" onmouseout="document.getElementById('<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').style.display='none';">
																		
																		<?php else: ?>
																		
																		<img class="swatch-image" src="<?php echo base_url('images/colorsample.jpg'); ?>" alt="" onmouseover="document.getElementById('<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').style.display='block';" onmouseout="document.getElementById('<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').style.display='none';">
																		
																		<?php endif; ?>
																		
																	</a>
																</li>
																	
																	<?php endif; ?>
																
																<?php endforeach; ?>
																
															</ul>
														</div>
													</div>
													
														<?php $i_thumb++; endforeach; ?>
													
													<input type="hidden" id="outfitState" value="false" />
												</div>
												
													<?php else: ?>
													
												<h3 style="margin-left: 50px;"><u>No product result.</u></h3>
												
													<?php endif; ?>
                        
											</div>
										</div>

										<?php
										/**********
										 * Bottom options div
										 */
										?>
										<div class="browseoptions browseoptions-btm clearfix">
										
											<?php $this->load->view($this->config->slash_item('template').'product_thumbs_filter'); ?>
											
										</div>
	
										<div class="ct ct-lowerbody clearfix">
										<!-- Add story URL for when JS is disabled -->
										</div>
										
										<br /><br />
										
										<?php
										/**********
										 * Bottom Footer Text Per Subcat
										 */
										?>
										
										<?php if ($footer_text): ?>
										
										<a href="#" class="toggle-story">
											<h1>
												<?php echo strtoupper($thumb->subcat_name); ?>
											</h1>
										</a><!-- [READ MORE ABOUT ...] -->
										
										<div class='readmore is-active'>
										
											<?php echo $footer_text; ?>
											
										</div>
										
										<?php //$this->load->view($this->config->slash_item('template').'product_thumbs_footer_text'); ?>
										
										<?php endif; ?>
										
									</div>

                                </div> 
                            </div><!-- .wl-grid -->
							<!-- end Right side content -->
                        
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>
                
