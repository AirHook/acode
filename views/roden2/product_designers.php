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
							
							<?php
							/**********
							 * Icons 
							 */
							?>
							<div class="product-designers" data-source="v-article-template featured">
								<div class=" clearfix">
								<!-- 158 is the number of characters the empty nav has // This is temp -->
									<div class="">
										<div data-source="v-article-browse">
										
											<?php //if ($designer_list): $i = 1; // designer_list is new library ?>
											<?php if ($designers): $i = 1; ?>
											
												<?php foreach ($designers as $designer): ?>
												
													<?php 
													if (
														$designer->url_structure != 'instylenewyork'
														&& $designer->with_products != '0'
													) 
													{ 
													?>
											
														<?php 
														/**********
														 * All Designers
														 */
														if (
															! $d_url_structure
														) 
														{ 
														?>
											
											<div class="listing-grid">
											
												<div class="listing-grid-header order-summary__header clearfix">
													<h3 class='section-heading'>
														<span class="the-heading">
															<?php echo $designer->designer; ?>
														</span>
														<span class="heading-description" style=""> 
															<?php echo $designer->description; ?>
														</span>
													</h3>
												</div>

															<?php
															/**********
															 * Designer subcats
															 */
															if ($this->uri->segment(1) === 'special_sale')
															{
																$des_subcats = $this->query_category->get_special_sale_subcats_with_products(str_replace(array(' ','/'), array('_','.'), $designer->url_structure));
															}
															else
															{
																//$des_subcats = $this->query_category->get_subcat_new($c_url_structure, str_replace(array(' ','/'), array('_','.'), $designer->url_structure));
																$des_subcats = $this->categories_tree->treelist(array('d_url_structure'=>$designer->url_structure));
															}
															?>
															
															<?php 
															foreach($des_subcats as $subitem): // ---> foreach subcategory 
															
																// let us process the linked_designers, icon_images, and descriptions
																$linked_designers = explode(',', $subitem->d_url_structure);
																$icon_images = explode(',', $subitem->icon_image);
																$descriptions = explode('|', $subitem->description);
																
																// get the designer key index
																//$key = array_search($designer->url_structure, $linked_designers);
																if (
																	$this->webspace_details->options['site_type'] != 'hub_site'
																)
																{
																	$key = array_search($this->webspace_details->slug, $linked_designers);
																}
																else
																{
																	$key = array_search($designer->url_structure, $linked_designers);
																}

																
																// get the pertinent info
																@$image = $icon_images[$key + 1];
																@$description = $descriptions[$key + 1];
																
																if ($subitem->category_id != '1') {
																?>
														
												<div class="listing-grid__cell  listing-grid__cell--article" data-info="<?php echo $i == 1 ? 'first' : ''; ?>">
													<article class="listing" data-info="story medium" itemscope itemtype="http://schema.org/Article">

														<!-- icon -->
														<div class="listing__media">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$designer->url_structure.'/apparel/'.$subitem->category_slug); ?>">
																<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $image; ?>" alt="<?php echo $subitem->category_name; ?>" />
															</a>
														</div>
														
														<!-- name -->
														<h1 class="listing__title">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$designer->url_structure.'/apparel/'.$subitem->category_slug); ?>">
																<span itemprop="headline"><?php echo $subitem->category_name; ?></span>
															</a>
														</h1>
														
														<!-- desc -->
														<div class="listing__subtitle">
															<?php echo $description; ?>
														</div>
													</article>
												</div>
												
																<?php } ?>
															<?php endforeach; ?>
											</div>
												
														<?php } 
														/**********
														 * Single Designer
														 */
														elseif (
															$d_url_structure == $designer->url_structure
														)
														{ ?>
														
											<div class="listing-grid">
											
												<div class="listing-grid-header order-summary__header clearfix">
													<h3 class='section-heading'>
														<span class="the-heading">
															<?php echo $designer->designer; ?>
														</span>
														<span class="heading-description" style=""> 
															<?php echo $designer->description; ?>
														</span>
													</h3>
												</div>

															<?php
															/**********
															 * Designer subcats
															 */
															if ($this->uri->segment(1) === 'special_sale')
															{
																$des_subcats = $this->query_category->get_special_sale_subcats_with_products(str_replace(array(' ','/'), array('_','.'), $designer->url_structure));
															}
															else
															{
																//$des_subcats = $this->query_category->get_subcat_new($c_url_structure, str_replace(array(' ','/'), array('_','.'), $designer->url_structure));
																$des_subcats = $this->categories_tree->treelist(array('d_url_structure'=>$designer->url_structure));
															}
															?>
															
															<?php 
															foreach($des_subcats as $subitem): // ---> foreach subcategory 
														
																// let us process the linked_designers, icon_images, and descriptions
																$linked_designers = explode(',', $subitem->d_url_structure);
																$icon_images = explode(',', $subitem->icon_image);
																$descriptions = explode('|', $subitem->description);
																
																// get the designer key index
																//$key = array_search($designer->url_structure, $linked_designers);
																if (
																	$this->webspace_details->options['site_type'] != 'hub_site'
																)
																{
																	$key = array_search($this->webspace_details->slug, $linked_designers);
																}
																else
																{
																	$key = array_search($designer->url_structure, $linked_designers);
																}
																
																// get the pertinent info
																$image = @$icon_images[$key + 1];
																$description = @$descriptions[$key + 1];
																
																if ($subitem->category_id != '1') {
																?>
														
												<div class="listing-grid__cell  listing-grid__cell--article" data-info="<?php echo $i == 1 ? 'first' : ''; ?>">
													<article class="listing" data-info="story medium" itemscope itemtype="http://schema.org/Article">

														<!-- icon -->
														<div class="listing__media">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$designer->url_structure.'/apparel/'.$subitem->category_slug); ?>">
																<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $image; ?>" alt="<?php echo $subitem->category_name; ?>" />
															</a>
														</div>
														
														<!-- name -->
														<h1 class="listing__title">
															<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$designer->url_structure.'/apparel/'.$subitem->category_slug); ?>">
																<span itemprop="headline"><?php echo $subitem->category_name; ?></span>
															</a>
														</h1>
														
														<!-- desc -->
														<div class="listing__subtitle">
															<?php echo $description; ?>
														</div>
													</article>
												</div>
												
																<?php } ?>
															<?php endforeach; ?>
											</div>
												
														<?php } ?>
														
													<?php } ?>
											
												<?php endforeach; ?>
										
											<?php else: ?>
										
											<h1>Designers are unavailable at this time</h1>
										
											<?php endif; ?>
											
										</div>
									</div>
								</div>
							</div>
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>