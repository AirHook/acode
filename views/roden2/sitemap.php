			<div>
				<h3><?php echo strtoupper($page_title); ?> SITEMAP</h3>
				<p>Use the links below to quickly find key areas of our Web site.</p>
			</div>
			
			<hr style="height:1px;border-width:0;color:#999999;background-color:#DFDFDF;margin:10px 0;"/>
	
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Site map by categories
			*/
			?>
			<div style="min-height: 160px;padding: 0px 0 15px 1px;">
			
				<div class=" clearfix">

					<div class="">
						<div data-source="v-article-browse">
						
							<?php if ($designers) { $i = 1; ?>
							
								<?php foreach ($designers as $item) { ?>
								
									<?php 
									// lets not iterate through 'instylenewyork'
									// Just the designers
									if (
										$item->url_structure !== 'instylenewyork' 
										&& $item->with_products != '0'
									)
									{ ?>
									
										<?php 
										// if hub site
										if (
											$this->config->item('hub_site') === TRUE 
											OR @$this->webspace_details->options['site_type'] == 'hub_site'
										)
										{ ?>
							
							<div class="listing-grid">
							
								
								<?php
								/**********
								 * Designer 
								 * Title Heading
								 */
								?>
								<div class="listing-grid-header order-summary__header clearfix">
									<h3 class='section-heading'>
										<span class="the-heading">
											<?php echo $item->designer; ?>
										</span>
										<span class="heading-description" style=""> 
											<?php echo $item->description; ?>
										</span>
									</h3>
								</div>

											<?php
											/**********
											 * Designer subcats
											 */
											if ($this->uri->segment(1) === 'special_sale')
											{
												$des_subcats = $this->query_category->get_special_sale_subcats_with_products(str_replace(array(' ','/'), array('_','.'), $item['url_structure']));
											}
											else
											{
												//$des_subcats = $this->query_category->get_subcat_new('apparel', str_replace(array(' ','/'), array('_','.'), $item['url_structure']));
												$des_subcats = $this->categories_tree->treelist(array('d_url_structure'=>$item->url_structure));
											}
											?>
											
											<?php 
											// ---> foreach subcategory 
											foreach($des_subcats as $subitem)
											{ 
											
												// let us process the linked_designers, icon_images, and descriptions
												$linked_designers = explode(',', $subitem->d_url_structure);
												$icon_images = explode(',', $subitem->icon_image);
												$descriptions = explode('|', $subitem->description);
												
												// get the designer key index
												//$key = array_search($item['url_structure'], $linked_designers);
												if (
													$this->webspace_details->options['site_type'] != 'hub_site'
												)
												{
													$key = array_search($this->webspace_details->slug, $linked_designers);
												}
												else $key = 0;
												
												// get the pertinent info
												$image = $icon_images[$key + 1];
												$description = $descriptions[$key + 1];
												
												if ($subitem->category_id != '1')
												{ ?>
										
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="<?php echo $i == 1 ? 'first' : ''; ?>">
									<article class="listing" data-info="story medium" itemscope itemtype="">

										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$item->url_structure.'/apparel/'.$subitem->category_slug); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $image; ?>" alt="<?php echo $subitem->category_name; ?>" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/subcategory_icon/thumb/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').$item->url_structure.'/apparel/'.$subitem->category_slug); ?>">
												<span itemprop="headline"><?php echo $subitem->category_name; ?></span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $description; ?>
										</div>
										
									</article>
								</div>
												<?php } ?>
									
											<?php } ?>
											
							</div>
								
										<?php 
										// for satellite sites
										} elseif (
											@$this->webspace_details->options['site_type'] == 'sat_site'
										)
										{ ?>
										
											<?php 
											// Just the specific designer
											if ($item->url_structure === $this->webspace_details->slug)
											{ ?>
											
							<div class="listing-grid">
							
								<div class="listing-grid-header order-summary__header clearfix">
									<h3 class='section-heading'>
										<span class="the-heading">
											<?php echo $item->designer; ?>
										</span>
										<span class="heading-description" style=""> 
											<?php echo $item->description; ?>
										</span>
									</h3>
								</div>

												<?php
												/**********
												 * Designer subcats
												 */
												if ($this->uri->segment(1) === 'special_sale')
												{
													$des_subcats = $this->query_category->get_special_sale_subcats_with_products(str_replace(array(' ','/'), array('_','.'), $item['url_structure']));
												}
												else
												{
													//$des_subcats = $this->query_category->get_subcat_new('apparel', str_replace(array(' ','/'), array('_','.'), $item['url_structure']));
													$des_subcats = $this->categories_tree->treelist(array('d_url_structure'=>$item->url_structure));
												}
												?>
												
												<?php 
												// ---> foreach subcategory 
												foreach($des_subcats as $subitem)
												{ 
											
													// let us process the linked_designers, icon_images, and descriptions
													$linked_designers = explode(',', $subitem->d_url_structure);
													$icon_images = explode(',', $subitem->icon_image);
													$descriptions = explode('|', $subitem->description);
													
													// get the designer key index
													//$key = array_search($item['url_structure'], $linked_designers);
													$key = array_search($this->webspace_details->slug, $linked_designers);
													
													// get the pertinent info
													$image = $icon_images[$key + 1];
													$description = $descriptions[$key + 1];
													
													if ($subitem->category_id != '1')
													{ ?>
											
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="<?php echo $i == 1 ? 'first' : ''; ?>">
									<article class="listing" data-info="story medium" itemscope itemtype="">

										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').'apparel/'.$subitem->category_slug); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL'); ?>images/subcategory_icon/thumb/<?php echo $image; ?>" alt="<?php echo $subitem->category_name; ?>" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px">
											<a class="listing__link" itemprop="url" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : 'shop/').'apparel/'.$subitem->category_slug); ?>">
												<span itemprop="headline"><?php echo $subitem->category_name; ?></span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $description; ?>
										</div>
									</article>
								</div>
								
													<?php } ?>
								
												<?php } ?>

							</div>
								
											<?php } ?>
							
										<?php } ?>
							
									<?php } ?>
							
								<?php } ?>
						
							<?php } else { ?>
						
							<h1>Categories are unavailable at this time</h1>
						
							<?php } ?>
							
						</div>
					</div>
				</div>
				
			</div>
			
			<hr style="height:1px;border-width:0;color:#999999;background-color:#DFDFDF;margin:20px 0;"/>
	
			<div>
				<h3>CUSTOMER SERVICES PAGES</h3>
			</div>
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Site map by other pages
			*/
			?>
			<div style="min-height:160px;padding:0px 0 15px 1px;">
			
				<div class=" clearfix">

					<div class="sitemap-other-pages">
						<div data-source="v-article-browse">
						
							<div class="listing-grid">
							
								<?php
								// not using user_cat = wholesale
								if ($this->session->userdata('user_cat') == 'wholesale'):
								?>
								
								<!-- Oredering -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_ordering'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_ordering->icon_image; ?>" alt="Ordering" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top;10px">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_ordering'); ?>">
												<span itemprop="headline">Ordering</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $wholesale_ordering->description; ?>
										</div>
									</article>
								</div>
								
								<!-- Shipping -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_shipping'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_shipping->icon_image; ?>" alt="Shipping" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_shipping'); ?>">
												<span itemprop="headline">Shipping</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $wholesale_shipping->description; ?>
										</div>
									</article>
								</div>
								
								<!-- Returns -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_return_policy'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_return_policy->icon_image; ?>" alt="Returns" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_return_policy'); ?>">
												<span itemprop="headline">Returns</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $wholesale_return_policy->description; ?>
										</div>
									</article>
								</div>
								
								<!-- Privacy -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_privacy_notice'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_privacy_notice->icon_image; ?>" alt="Privacy" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_privacy_notice'); ?>">
												<span itemprop="headline">Privacy</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $wholesale_privacy_notice->description; ?>
										</div>
									</article>
								</div>

								<!-- Order Status -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_order_status'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_order_status->icon_image; ?>" alt="Order Status" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_order_status'); ?>">
												<span itemprop="headline">Order Status</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $wholesale_order_status->description; ?>
										</div>
									</article>
								</div>

								<!-- FAQ -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_faq'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_faq->icon_image; ?>" alt="FAQ" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_faq'); ?>">
												<span itemprop="headline">FAQ</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $wholesale_faq->description; ?>
										</div>
									</article>
								</div>
								
								<?php else: ?>

								<!-- Oredering -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('ordering'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$ordering->icon_image; ?>" alt="Ordering" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('ordering'); ?>">
												<span itemprop="headline">Ordering</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $ordering->description; ?>
										</div>
									</article>
								</div>
								
								<!-- Shipping -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('shipping'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$shipping->icon_image; ?>" alt="Shipping" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('shipping'); ?>">
												<span itemprop="headline">Shipping</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $shipping->description; ?>
										</div>
									</article>
								</div>
								
								<!-- Returns -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('return_policy'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$returns->icon_image; ?>" alt="Returns" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('return_policy'); ?>">
												<span itemprop="headline">Returns</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $returns->description; ?>
										</div>
									</article>
								</div>
								
								<!-- Privacy -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('privacy_notice'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$privacy->icon_image; ?>" alt="Privacy" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('privacy_notice'); ?>">
												<span itemprop="headline">Privacy</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $privacy->description; ?>
										</div>
									</article>
								</div>
								
								<!-- FAQ -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('faq'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$faq->icon_image; ?>" alt="FAQ" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('faq'); ?>">
												<span itemprop="headline">FAQ</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $faq->description; ?>
										</div>
									</article>
								</div>
								
								<?php endif; ?>
					
								<!-- Press -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="first">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('press'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$press->icon_image; ?>" alt="Press" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('press'); ?>">
												<span itemprop="headline">Press</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $press->description; ?>
										</div>
									</article>
								</div>

								<!-- Terms Of Use -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('terms_of_use'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$terms_of_use->icon_image; ?>" alt="Terms Of Use" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('terms_of_use'); ?>">
												<span itemprop="headline">Terms Of Use</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $terms_of_use->description; ?>
										</div>
									</article>
								</div>

								<!-- Contact -->
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="">
									<article class="listing" data-info="story medium" itemscope itemtype="">
									
										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('contact'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$contact->icon_image; ?>" alt="Contact" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('contact'); ?>">
												<span itemprop="headline">Contact</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $contact->description; ?>
										</div>
									</article>
								</div>
								
												<?php
												// For Junnie Leigh and any other sites with made_to_order page
												if (
													$this->config->item('site_slug') === 'basixbridal' OR
													$this->config->item('site_slug') === 'basixprom' OR
													$this->config->item('site_slug') === 'junnieleigh'
												):
												?>
												
								<div class="listing-grid__cell  listing-grid__cell--article" data-info="">
									<article class="listing" data-info="story medium" itemscope itemtype="">

										<!-- icon -->
										<div class="listing__media">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('made_to_order'); ?>">
												<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$made_to_order->icon_image; ?>" alt="Made To Order" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" />
											</a>
										</div>
										
										<!-- name -->
										<h1 class="listing__title" style="margin-top:10px;">
											<a class="listing__link" itemprop="url" href="<?php echo site_url('made_to_order'); ?>">
												<span itemprop="headline">Made To Order</span>
											</a>
										</h1>
										
										<!-- desc -->
										<div class="listing__subtitle" style="max-height:none;">
											<?php echo $made_to_order->description; ?>
										</div>
									</article>
								</div>
								
												<?php endif; ?>
												
							</div>
							
						</div>
					</div>
				</div>
			</div>
			
