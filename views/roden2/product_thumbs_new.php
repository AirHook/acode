					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content with-side-container clearfix" name="product_thumbs_faceted">
					
						<?php if ($this->session->flashdata('flashMsg') == 'zero_search_result') { ?>
					
						<div class="center notice" style="<?php echo $this->webspace_details->slug == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'border: 1px solid #999;background:pink;'; ?>padding:20px;margin-bottom:20px;">
							Search did not find anything. Please try searching from all products.
						</div>
						
						<?php } ?>
						
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<?php
							/**********
							 * Side Nav
							 */
							//$this->load->view($this->config->slash_item('template').'product_thumbs_sidebar_'.$this->config->item('site_slug'));
							$this->load->view($this->webspace_details->options['theme'].'/product_thumbs_sidebar_v1');
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
										
											<?php
											if ( ! @$search_result)
											{
												//if ($view_pane !== 'thumbs_list_sales_pacakge') $this->load->view($this->config->slash_item('template').'product_thumbs_filter');
												if ($view_pane !== 'thumbs_list_sales_pacakge') $this->load->view($this->webspace_details->options['theme'].'/product_thumbs_filter');
											}
											else
											{
												echo '<p style="margin:0 0 20px 5px;">Search results for: <strong>'.@$search_string.'</strong></p>';
											}
											?>
											
										</div>
										
										<style>
										.swatches .swatch-image {
											border-radius: 0;
										}
										</style>

										<?php
										/**********
										 * Product thumbnails section
										 */
										?>
										<div class="wl-browse-thumbs clearfix" data-source="v-product-thumbnails" data-count_all="<?php echo $this->products_list->count_all; ?>" data-items_per_page="<?php echo @$this->webspace_details->options['items_per_page']; ?>" data-row_count="<?php echo $this->products_list->row_count; ?>">
										
											<?php if ($this->products_list->row_count > 0) { ?>
											
											<div class="products-wrap products-large">
												<div class="products clearfix">
												
													<?php
													/**********
													 * The THUMB with hover effect
													 */
													?>
													<?php
													$i_thumb = 0;
													$i_prod_no = 0;
													foreach ($view_pane_sql as $thumb)
													{
														$subcat_name = $thumb->subcat_name;
														
														if (@$grouped_products)
														{
															// since thumbs are grouped by prod_no, we can now query available colors for 
															// swatches and hover effect
															//$colors = $this->query_category->get_available_colors($thumb->prod_no, '0');
															$this->product_details->initialize(array('tbl_product.prod_no'=>$thumb->prod_no));
															$colors = $this->product_details->available_colors();
															
															// let store current prod_no and check it with next current prod_no
															// if the same, continue with the loop
															if ($i_prod_no >= 1 && $temp_prod_no == $thumb->prod_no) continue;
															else $i_prod_no = 0;
															
															if ($i_prod_no == 0) 
															{
																$temp_prod_no = $thumb->prod_no;
															}
															$i_prod_no++;
														}
														else $colors = FALSE;
														
														// set image paths
														$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_front/thumbs/';
														$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_back/thumbs/';
														$color_icon_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_coloricon/';
														
														// the image filename 
														//if (@$grouped_products) $image = $thumb->prod_no.'_'.$thumb->color_code.'_3.jpg';
														//else $image = $thumb->prod_no.'_'.$thumb->color_code.'_3.jpg';
														$image = $thumb->prod_no.'_'.$thumb->color_code.'_3.jpg';
														
														// the item coloricon / swatch
														//if (@$grouped_products) $color_icon = $thumb->prod_no.'_'.$thumb->color_code.'.jpg';
														//else $color_icon = $thumb->prod_no.'_'.$thumb->color_code.'.jpg';
														$color_icon = $thumb->prod_no.'_'.$thumb->color_code.'.jpg';
														
														// the new image url system
														$img_front_new = $this->config->item('PROD_IMG_URL').$thumb->media_path.$thumb->media_name.'_f3.jpg';
														$img_back_new = $this->config->item('PROD_IMG_URL').$thumb->media_path.$thumb->media_name.'_b3.jpg';
														$img_coloricon = $this->config->item('PROD_IMG_URL').$thumb->media_path.$thumb->media_name.'_c.jpg';
														
														// set the link
														$seg = (($this->uri->segment(1) === 'special_sale') ? 'special_sale/' : 'shop/details/').$thumb->d_url_structure . '/' . $thumb->prod_no. '/' . str_replace(' ','-',strtolower(trim($thumb->color_name))).'/' . str_replace(' ','-',strtolower(trim($thumb->prod_name)));
													?>
													
													<style>
													.alt-image-<?php echo $thumb->prod_no.'_'.$thumb->color_code; ?> {
														opacity: 1;
														transition: opacity .25s ease-in-out;
														-moz-transition: opacity .25s ease-in-out;
														-webkit-transition: opacity .25s ease-in-out;
													}
													.alt-image-<?php echo $thumb->prod_no.'_'.$thumb->color_code; ?>:hover {
														opacity: 0;
													}
													</style>
													
													<div class="product hoverable">
													
														<!-- image <?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?> -->
														<!-- link <?php echo site_url($seg); ?> -->
														<div class="image" style="position:relative;">
														
															<!-- Just a font awesome icon of rotating dots to indicate loading -->
															<div class="loading">Loading&#8230;</div>
															
															<?php
															/**********
															 * This transparent image here is used to occupy the thumbs placeholder
															 * As such, only one image is loaded for all the placeholder
															 */
															?>
															<img src="<?php echo base_url().'images/instylelnylogo_3.png'; ?>" />
															
															<?php
															/**********
															 * Start of image thumbs
															 */
															?>
															<div class="primary" onmouseover="$('.alt_-image-<?php echo $thumb->prod_no.'_'.$thumb->color_code; ?>').hide();" onmouseout="$('.alt_-image-<?php echo $thumb->prod_no.'_'.$thumb->color_code; ?>').show();">
															
																<?php
																/**********
																 * Source Site used a class "js-use-rollovers" on the <a> tag
																 * to somehow initiate a script or css trick to apply a image switching
																 * on mouse over... since alt image is removed (commented), we need to
																 * remove the class item from the <a> tag
																 */
																?>
													
																<a href="<?php echo site_url($seg); ?>" title="<?php echo $thumb->prod_name; ?>" class="" data-alias="">
																
																	<?php
																	/**********
																	 * Due to some source template inherent script and css issues,
																	 * had to swap src="" of primary-img and alt-image for mouseove
																	 * to take effect. Mouse over effect is simply the javascript
																	 * on parent div tag class="primary"
																	 
																	<img class="primary-img" src="<?php echo $back; ?>" alt="<?php echo $thumb->prod_name; ?>" />
																	 */
																	?>
																	
																	<?php if ($this->agent->is_mobile()) { ?>
																	
																	<img class="primary-img" src="<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?>');" />
																	
																	<?php } else { ?>
																
																	<img class="primary-img" src="<?php echo $thumb->primary_img ? $img_back_new : $img_back_pre.$image; ?>" alt="<?php echo $thumb->prod_name; ?>" onerror="$(this).attr('src', '<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>');" />
																	
																	<?php
																	/**********
																	 * Removing the on hover alt image for faster page loading
																	 * not needed in faceted search products thumbs page
																	 
																	<img class="alt-image hidden" src="<?php echo $back; ?>" alt="<?php echo $thumb->prod_name; ?>" />
																	 */
																	?>
																	
																	<?php //if ( ! $search_result): ?>
																	
																	<?php
																	/**********
																		Taken from product_thumbs.php
																	 * Initially removed this alt image but had to bring it back
																	 * However, we are not using the "js-use-rollovers" as noted in 
																	 * the above comment but instead added an inline havascript
																	 * at the parent div with class="primary"
																	 */
																	?>
																	
																	<img class="alt-image alt-image-<?php echo $thumb->prod_no.'_'.$thumb->color_code; ?>" src="<?php echo $thumb->primary_img ? $img_front_new : $img_front_pre.$image; ?>" alt="<?php echo $thumb->prod_name; ?>" style="position:absolute;left:0;top:0;" />
																
																	<?php //endif; ?>
																	
																	<?php
																	/**********
																	 * Iterating through available colors in order to load other colors 
																	 * product thumbs for swatch mouse over effect
																	 */
																	?>
																	
																	<?php
																	if ($colors)
																	{
																		foreach($colors as $color)
																		{
																			if ($color->color_code != $thumb->primary_img_id)
																			{
																				// set image paths
																				$sub_img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_front/thumbs/';
																				$sub_img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_back/thumbs/';
																				$sub_color_icon_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$thumb->d_url_structure.'/'.$thumb->sc_url_structure.'/product_coloricon/';
																				// the image filename
																				$sub_image = $thumb->prod_no.'_'.$color->color_code.'_3.jpg';
																				// the item coloricon / swatch
																				$sub_color_icon = $thumb->prod_no.'_'.$color->color_code.'.jpg';
																				
																				// the new image url system
																				$sub_img_front_new = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_f3.jpg';
																				$sub_img_back_new = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_b3.jpg';
																				$sub_img_coloricon = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_c.jpg';
																				
																				$sub_seg = (($this->uri->segment(1) === 'special_sale') ? 'special_sale/' : 'shop/details/').$thumb->d_url_structure . '/' . $thumb->prod_no. '/' . str_replace(' ','-',strtolower(trim($thumb->color_name))).'/' . str_replace(' ','-',strtolower(trim($thumb->prod_name)));
																				?>
																		
																	<img class="alt-image" src="<?php echo $color->image_url_path ? $sub_img_front_new : $sub_img_front_pre.$sub_image; ?>" alt="<?php echo $thumb->prod_name; ?>" id="<?php echo $thumb->prod_no.'_'.$color->color_code; ?>" style="display:none;position:absolute;top:0;left:0;"/>
																	
																			<?php 
																			}
																		}
																	}
																	?>
																	
																	<?php } // else if not user agent is not mobile ?>
																	
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
															 * Used to be Price is hidden on satelite sites
															 * Now, it is enabled on webspace options
															 */
															$price_class = (
																@$this->webspace_details->options['show_product_price'] == '1'
																//$this->webspace_details->options['site_type'] === 'hub_site'
															) ? '' : 'hidden';
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
																		<img class="swatch-image" src="<?php echo ($thumb->primary_img ? $img_coloricon : $color_icon_pre.$color_icon); ?>">
																	</a>
																</li>
																
																	<?php
																	if ($colors)
																	{
																		foreach($colors as $color)
																		{
																			if (
																				@$_GET['availability'] == 'preorder' && $color->with_stocks > 0
																				OR @$_GET['availability'] == 'instock' && $color->with_stocks == 0
																				OR @$_GET['availability'] == 'onsale' && $color->custom_order != '3'
																			)
																			{
																				continue;
																			}
																			
																			if (
																				$color->color_code != $thumb->color_code
																			)
																			{
																				// the item coloricon / swatch
																				$sub_color_icon = $thumb->prod_no.'_'.$color->color_code.'.jpg';
																				// new image url system
																				$sub_img_coloricon = $this->config->item('PROD_IMG_URL').$color->media_path.$color->media_name.'_c.jpg';
																				
																				$sub_seg = (($this->uri->segment(1) === 'special_sale') ? 'special_sale/' : 'shop/details/').$thumb->d_url_structure . '/' . $thumb->prod_no. '/' . str_replace(' ','-',strtolower(trim($color->color_name))).'/' . str_replace(' ','-',strtolower(trim($thumb->prod_name)));
																				?>
																		
																<li class="swatch selected">
																	<a class="swatch-link parent-select" href="<?php echo site_url($sub_seg); ?>" title="<?php echo ucfirst(strtolower(trim($color->color_name))); ?>">
																		<img class="swatch-image" src="<?php echo ($color->image_url_path ? $sub_img_coloricon : $color_icon_pre.$sub_color_icon); ?>" onmouseover="$('#<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').show();" onmouseout="$('#<?php echo $thumb->prod_no.'_'.$color->color_code; ?>').hide();">
																	</a>
																</li>
																
																			<?php 
																			}
																		}
																	}
																	?>
																	
															</ul>
														</div>
													</div>
													
													<?php $i_thumb++; } ?>
													
													<input type="hidden" id="outfitState" value="false" data-total_thumbs="<?php echo $i_thumb; ?>" />
												</div>
											</div>
											
											<?php } else { ?>
										
											<h3 style="margin-left: 50px;"><u>No product result.</u></h3>
											
											<p style="margin: 50px 0 50px 50px;font-size:1rem;">
												Please try another category from the left sidebar.<br />
												<?php if (@$search_result) { ?>
												Or, search another item on the search box at the top bar.<br />
												<?php } ?>
												<?php if ($this->session->userdata('faceting')) { ?>
												Or, try another filter.<br />
												Or, clear all filters <a href="<?php echo site_url($this->uri->uri_string()); ?>">HERE</a>.
												<?php } ?>
											</p>
												
											<?php } ?>
			
										</div>

										<?php
										/**********
										 * Bottom options div
										 */
										?>
										<div class="browseoptions browseoptions-btm clearfix">
										
											<?php
											if ( ! @$search_result)
											{
												//if ($view_pane !== 'thumbs_list_sales_pacakge') $this->load->view($this->config->slash_item('template').'product_thumbs_filter');
												if ($view_pane !== 'thumbs_list_sales_pacakge') $this->load->view($this->webspace_details->options['theme'].'/product_thumbs_filter');
											}
											else
											{
												echo '<p style="margin:0 0 0 5px;">Search results for: <strong>'.@$search_string.'</strong></p>';
											}
											?>
											
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
										
										<?php if (@$footer_text): ?>
										
										<a href="#" class="toggle-story">
											<h1>
												<?php echo strtoupper(@$subcat_name); ?>
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
                
