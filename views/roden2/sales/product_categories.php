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
							$this->load->view($this->config->slash_item('template').'sales/product_thumbs_sidebar_'.$this->config->item('site_slug'));
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

												<?php if ($view_pane_sql->num_rows() > 0): $i = 1; ?>
												
													<?php 
													foreach ($view_pane_sql->result_array() as $item): 
													
													// let's get the correct icon image
															$linked_designers = explode(',', $item['c_d_url_structure']);
															$icon_images = explode(',', $item['c_icon_image']);
															$descriptions = explode('|', $item['c_description']);
															
															// get the designer key index
															$key = array_search($item['d_url_structure'], $linked_designers);
															
															// get the pertinent info
															$image = $icon_images[$key];
															$description = $descriptions[$key];
													?>
												
												<div class="listing-grid__cell  listing-grid__cell--article" data-info="<?php echo $i == 1 ? 'first' : ''; ?>">
													<article class="listing" data-info="story medium" itemscope itemtype="http://schema.org/Article">

														<!-- icon -->
														<div class="listing__media">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(uri_string().'/'.$item['sc_url_structure']); ?>">
																<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $image; ?>" alt="<?php echo $item['subcat_name']; ?>" />
															</a>
														</div>
														
														<!-- name -->
														<h1 class="listing__title">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(uri_string().'/'.$item['sc_url_structure']); ?>">
																<span itemprop="headline"><?php echo $item['subcat_name']; ?></span>
															</a>
														</h1>
														
														<!-- desc -->
														<div class="listing__subtitle">
															<?php echo $item['description']; ?>
														</div>
													</article>
												</div>
												
													<?php endforeach; ?>
											
												<?php else: ?>
												
													<h1>Categories are unavailable at this time</h1>
												
												<?php endif; ?>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>