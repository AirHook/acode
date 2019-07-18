					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content with-side-container clearfix">
						<div id="main" class="content-grid  clearfix" role="main">
						
							<?php
							/**********
							 * Side Nav
							 */
							//$this->load->view($this->config->slash_item('template').'product_thumbs_sidebar_'.$this->config->item('site_slug'));
							$this->load->view($this->webspace_details->options['theme'].'/product_thumbs_sidebar_v1');
							?>
							
							<div data-source="v-article-template featured">
								<div class=" clearfix">
								<!-- 158 is the number of characters the empty nav has // This is temp -->
									<div class="">
										<div data-source="v-article-browse">
    
											<div class="listing-grid">
											
												<div class="order-summary__header clearfix hidden"><!-- hidden (in case a title is needed) -->
													<h6 class='section-heading'>Subcats</h6>
												</div>

												<?php //if ($view_pane_sql->num_rows() > 0) { $i = 1; ?>
												<?php if ($categories) { $i = 1; ?>
												
													<?php 
													foreach ($categories as $item) 
													{ 
														if ($item->category_id != '1') 
														{
															// get the slugs to set link
															$link_seg[$item->category_level] = $item->category_slug;
															
															// let's get the correct icon image
															// grab linked designers and respective icon images and descriptions
															/*
															$linked_designers = explode(',', $item['c_d_url_structure']);
															$icon_images = explode(',', $item['c_icon_image']);
															$descriptions = explode('|', $item['c_description']);
															*/
															$linked_designers = explode(',', $item->d_url_structure);
															$icon_images = explode(',', $item->icon_image);
															$descriptions = explode('|', $item->description);
															
															// get the designer key index if not hub sites
															if (
																@$this->webspace_details->options['site_type'] != 'hub_site'
															)
															{
																$key = array_search($this->webspace_details->slug, $linked_designers);
															}
															else $key = 0;
															
															// get the pertinent info
															// key index 0 is the item for general designers 
															@$image = $icon_images[$key + 1];
															@$description = $descriptions[$key + 1];
															
															// do an iteration to unset the link segment for next upper level category
															if (@$prev_level)
															{
																for ($deep = $prev_level - $item->category_level; $deep > 0; $deep--)
																{
																	unset($link_seg[$deep + 1]);
																}
															} 
															
															if (@$this->webspace_details->options['site_type'] == 'hub_site')
															{ 
																?>
														
												<div class="listing-grid__cell  listing-grid__cell--article" data-info="<?php echo $i == 1 ? 'first' : ''; ?>">
													<article class="listing" data-info="story medium" itemscope itemtype="http://schema.org/Article">

														<!-- icon -->
														<div class="listing__media">
															<a class="listing__link" itemprop="url" href="<?php echo site_url('shop/'.implode('/', $link_seg)); ?>">
																<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $image; ?>" alt="<?php echo $item->category_name; ?>" />
															</a>
														</div>
														
														<!-- name -->
														<h1 class="listing__title">
															<a class="listing__link" itemprop="url" href="<?php echo site_url('shop/'.implode('/', $link_seg)); ?>">
																<span itemprop="headline"><?php echo $item->category_name; ?></span>
															</a>
														</h1>
														
														<!-- desc -->
														<div class="listing__subtitle">
															<?php echo $description; ?>
														</div>
													</article>
												</div>
												
																<?php 
															} 
															else 
															{ 
																?>
															
																<?php
																// --> identify categories linked to designer for satellite sites
																if (
																	strpos($item->d_url_structure, $this->webspace_details->slug) !== FALSE // --> avoid catching '0' strpos as false
																) 
																{ 
																	?>
												
												<div class="listing-grid__cell  listing-grid__cell--article" data-info="<?php echo $i == 1 ? 'first' : ''; ?>">
													<article class="listing" data-info="story medium" itemscope itemtype="http://schema.org/Article">

														<!-- icon -->
														<div class="listing__media">
															<a class="listing__link" itemprop="url" href="<?php echo site_url('shop/'.implode('/', $link_seg)); ?>">
																<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $image; ?>" alt="<?php echo $item->category_name; ?>" />
															</a>
														</div>
														
														<!-- name -->
														<h1 class="listing__title">
															<a class="listing__link" itemprop="url" href="<?php echo site_url('shop/'.implode('/', $link_seg)); ?>">
																<span itemprop="headline"><?php echo $item->category_name; ?></span>
															</a>
														</h1>
														
														<!-- desc -->
														<div class="listing__subtitle">
															<?php echo $description; ?>
														</div>
													</article>
												</div>
												
																<?php } ?>
																
																<?php 
															} ?>
															
															<?php 
														} // end condition if not category_id == 1 ?>
											
														<?php 
														$prev_level = $item->category_level;
														
													} // end foreach category item 
													
													unset($link_seg); ?>
											
												<div class="listing-grid__cell  listing-grid__cell--article" data-info="">
													<article class="listing" data-info="story medium" itemscope itemtype="http://schema.org/Article">

														<!-- icon -->
														<div class="listing__media">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/all'); ?>?filter=&availability=onsale">
																<img class="img-block listing__square-img" itemprop="image" src="<?php echo base_url(); ?>assets/images/icons/special_sale_icon.jpg" alt="SPECIAL SALE" />
															</a>
														</div>
														
														<!-- name -->
														<h1 class="listing__title">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/all'); ?>?filter=&availability=onsale">
																<span itemprop="headline">SPECIAL SALE</span>
															</a>
														</h1>
														
														<!-- desc -->
														<div class="listing__subtitle">
															Items on special sale for as low as 50% off.
														</div>
													</article>
												</div>
												
												<?php } else { ?>
												
													<h1>Categories are not available at this time</h1>
												
												<?php } ?>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>