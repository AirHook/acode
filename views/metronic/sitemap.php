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
			<div style="min-height:460px;padding: 0px 0 30px;">
			
				<?php 
				if ($designers) 
				{ 
					foreach ($designers as $item) 
					{
						// Just the designers
						if (
							(
								$item->url_structure !== 'instylenewyork' 
								OR $item->url_structure !== 'shop7thavenue' 
							)
							&& $item->with_products != '0'
						)
						{
							// if hub site
							if (
								$this->config->item('hub_site') === TRUE 
								OR @$this->webspace_details->options['site_type'] == 'hub_site'
							)
							{ ?>
				
				<!-- Designer Title Heading -->
				<h3 class="form-section" data-d_url_structure="<?php echo $item->url_structure; ?>" style="padding-bottom:5px;border-bottom:1px solid #e7ecf1;margin:50px 0 20px;">
					<?php echo $item->designer; ?> &nbsp; <small class="small"> <?php echo $item->description; ?> </small>
				</h3>
				
								<?php
								/**********
								 * Designer subcats
								 */
								$des_subcats = $this->categories_tree->treelist(
									array(
										'd_url_structure'=>$item->url_structure
									)
								);

								// ---> foreach subcategory 
								$iz = 1; 
								foreach($des_subcats as $subitem)
								{
								
									// let us process the linked_designers, icon_images, and descriptions
									//$linked_designers = explode(',', $subitem->d_url_structure);
									//$icon_images = explode(',', $subitem->icon_image);
									//$descriptions = explode('|', $subitem->description);
									$ld = json_decode($subitem->d_url_structure , TRUE);
									$linked_designers = 
										json_last_error() === JSON_ERROR_NONE 
										? $ld 
										: explode(',', $subitem->d_url_structure)
									;
									$ii = json_decode($subitem->icon_image , TRUE);
									$icon_images = 
										json_last_error() === JSON_ERROR_NONE 
										? $ii
										:	explode(',', $subitem->icon_image)
									;
									$desc = json_decode($subitem->description , TRUE);
									$descriptions = 
										json_last_error() === JSON_ERROR_NONE 
										? $desc
										: explode('|', $subitem->description)
									;
									
									// get the designer key index
									$key = array_search($item->url_structure, $linked_designers) + 1;
									
									// get the pertinent info
									@$image = array_key_exists($key, $icon_images) ? $icon_images[$key] : $icon_images[$item->url_structure];
									@$description = array_key_exists($key, $descriptions) ? $descriptions[$key] : $descriptions[$item->url_structure];
									
									if ($iz == 1) echo '<div class="row margin-bottom-10">';
									if (fmod($iz, 6) == 1) echo '</div><div class="row margin-bottom-10">';
									
									if ($subitem->with_products > 0)
									{ ?>
							
				<div class="col-xs-6 col-sm-3 col-md-2">
					<article class="listing" data-info="story medium" itemscope itemtype="">

						<!-- icon -->
						<div class="listing__media">
							<a class="" href="<?php echo site_url('shop/'.$item->url_structure.'/apparel/'.$subitem->category_slug); ?>">
								<img src="<?php echo $image ? $this->config->slash_item('PROD_IMG_URL').'images/subcategory_icon/thumb/'.$image : base_url().'images/subcategory_icon/thumb/default-designer-icon.jpg'; ?>" alt="<?php echo $subitem->category_name; ?>" style="width:100%;" /> 
							</a>
						</div>
						
						<!-- name -->
						<h5>
							<a class="" href="<?php echo site_url('shop/'.$item->url_structure.'/apparel/'.$subitem->category_slug); ?>" style="color:black;">
								<?php echo $subitem->category_name; ?>
							</a>
						</h5>
						
						<!-- desc -->
						<div class="listing__subtitle" style="max-height:none;">
							<?php echo $description; ?>
						</div>
						
					</article>
				</div>
										<?php
										$iz++;
									}
								}
								// ensuer to close the div "row"
								echo '</div>';
							}
							elseif (@$this->webspace_details->options['site_type'] == 'sat_site') // for satellite sites
							{ 
								// Just the specific designer
								if ($item->url_structure === $this->webspace_details->slug)
								{ ?>
								
				<!-- Designer Title Heading -->
				<h3 class="form-section" data-d_url_structure="<?php echo $item->url_structure; ?>" style="padding-bottom:5px;border-bottom:1px solid #e7ecf1;margin:50px 0 20px;">
					<?php echo $item->designer; ?> &nbsp; <small class="small"> <?php echo $item->description; ?> </small>
				</h3>
				
									<?php
									/**********
									 * Designer subcats
									 */
									$des_subcats = $this->categories_tree->treelist(
										array(
											'd_url_structure'=>$item->url_structure
										)
									);
									
									// ---> foreach subcategory 
									$iz = 1;
									foreach($des_subcats as $subitem)
									{
										// let us process the linked_designers, icon_images, and descriptions
										//$linked_designers = explode(',', $subitem->d_url_structure);
										//$icon_images = explode(',', $subitem->icon_image);
										//$descriptions = explode('|', $subitem->description);
									$ld = json_decode($subitem->d_url_structure , TRUE);
									$linked_designers = 
										json_last_error() === JSON_ERROR_NONE 
										? $ld 
										: explode(',', $subitem->d_url_structure)
									;
									$ii = json_decode($subitem->icon_image , TRUE);
									$icon_images = 
										json_last_error() === JSON_ERROR_NONE 
										? $ii
										:	explode(',', $subitem->icon_image)
									;
									$desc = json_decode($subitem->description , TRUE);
									$descriptions = 
										json_last_error() === JSON_ERROR_NONE 
										? $desc
										: explode('|', $subitem->description)
									;
									
									// get the designer key index
									$key = array_search($item->url_structure, $linked_designers) + 1;
									
									// get the pertinent info
									@$image = array_key_exists($key, $icon_images) ? $icon_images[$key] : $icon_images[$item->url_structure];
									@$description = array_key_exists($key, $descriptions) ? $descriptions[$key] : $descriptions[$item->url_structure];
									
										if ($iz == 1) echo '<div class="row margin-bottom-10">';
										if (fmod($iz, 6) == 1) echo '</div><div class="row margin-bottom-10">';
										
										if ($subitem->with_products > 0)
										{ ?>
								
				<div class="col-xs-6 col-sm-3 col-md-2">
					<article class="listing" data-info="story medium" itemscope itemtype="">

						<!-- icon -->
						<div class="listing__media">
							<a class="" href="<?php echo site_url('shop/'.$item->url_structure.'/apparel/'.$subitem->category_slug); ?>">
								<img src="<?php echo $image ? $this->config->slash_item('PROD_IMG_URL').'images/subcategory_icon/thumb/'.$image : base_url().'images/subcategory_icon/thumb/default-designer-icon.jpg'; ?>" alt="<?php echo $subitem->category_name; ?>" style="width:100%;" /> 
							</a>
						</div>
						
						<!-- name -->
						<h5>
							<a class="" href="<?php echo site_url('shop/'.$item->url_structure.'/apparel/'.$subitem->category_slug); ?>" style="color:black;">
								<?php echo $subitem->category_name; ?>
							</a>
						</h5>
						
						<!-- desc -->
						<div class="listing__subtitle" style="max-height:none;">
							<?php echo $description; ?>
						</div>
						
					</article>
				</div>
											<?php
											$iz++;
										}
									}
									// ensuer to close the div "row"
									echo '</div>';
								}
							}
						}
					}
				} 
				else 
				{ ?>
			
				<h1>Categories are unavailable at this time</h1>
			
					<?php 
				} ?>
				
			</div>
			
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Site map by other pages
			*/
			?>
			<div style="min-height:160px;padding:0px 0 15px 1px;">
			
				<!-- Designer Title Heading -->
				<h3 class="form-section" data-d_url_structure="<?php echo $item->url_structure; ?>" style="padding-bottom:5px;border-bottom:1px solid #e7ecf1;margin:50px 0 20px;">
					Customer Services Pages
				</h3>
				
				<?php
				// not using user_cat = wholesale
				if ($this->session->userdata('user_cat') == 'wholesale')
				{ ?>
				
				<div class="row margin-bottom-10">
				
					<!-- Oredering -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_ordering'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_ordering->icon_image; ?>" alt="Ordering" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top;10px">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_ordering'); ?>" style="color:black;">
									<span itemprop="headline">Ordering</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $wholesale_ordering->description; ?>
							</div>
						</article>
					</div>
					
					<!-- Shipping -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_shipping'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_shipping->icon_image; ?>" alt="Shipping" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_shipping'); ?>" style="color:black;">
									<span itemprop="headline">Shipping</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $wholesale_shipping->description; ?>
							</div>
						</article>
					</div>
					
					<!-- Returns -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_return_policy'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_return_policy->icon_image; ?>" alt="Returns" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_return_policy'); ?>" style="color:black;">
									<span itemprop="headline">Returns</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $wholesale_return_policy->description; ?>
							</div>
						</article>
					</div>
					
					<!-- Privacy -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_privacy_notice'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_privacy_notice->icon_image; ?>" alt="Privacy" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_privacy_notice'); ?>" style="color:black;">
									<span itemprop="headline">Privacy</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $wholesale_privacy_notice->description; ?>
							</div>
						</article>
					</div>

					<!-- Order Status -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_order_status'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_order_status->icon_image; ?>" alt="Order Status" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_order_status'); ?>" style="color:black;">
									<span itemprop="headline">Order Status</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $wholesale_order_status->description; ?>
							</div>
						</article>
					</div>

					<!-- FAQ -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_faq'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$wholesale_faq->icon_image; ?>" alt="FAQ" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('wholesale_faq'); ?>" style="color:black;">
									<span itemprop="headline">FAQ</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $wholesale_faq->description; ?>
							</div>
						</article>
					</div>
				
				</div>
				
					<?php 
				}
				else
				{ ?>
				
				<div class="row margin-bottom-10">

					<!-- Oredering -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('ordering'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$ordering->icon_image; ?>" alt="Ordering" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('ordering'); ?>" style="color:black;">
									<span itemprop="headline">Ordering</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $ordering->description; ?>
							</div>
						</article>
					</div>
					
					<!-- Shipping -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('shipping'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$shipping->icon_image; ?>" alt="Shipping" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('shipping'); ?>" style="color:black;">
									<span itemprop="headline">Shipping</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $shipping->description; ?>
							</div>
						</article>
					</div>
					
					<!-- Returns -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('return_policy'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$returns->icon_image; ?>" alt="Returns" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('return_policy'); ?>" style="color:black;">
									<span itemprop="headline">Returns</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $returns->description; ?>
							</div>
						</article>
					</div>
					
					<!-- Privacy -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('privacy_notice'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$privacy->icon_image; ?>" alt="Privacy" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('privacy_notice'); ?>" style="color:black;">
									<span itemprop="headline">Privacy</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $privacy->description; ?>
							</div>
						</article>
					</div>
					
					<!-- FAQ -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('faq'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$faq->icon_image; ?>" alt="FAQ" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('faq'); ?>" style="color:black;">
									<span itemprop="headline">FAQ</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $faq->description; ?>
							</div>
						</article>
					</div>
					
				</div>
				
					<?php 
				} ?>
	
				<div class="row margin-bottom-10">
				
					<!-- Press -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('press'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$press->icon_image; ?>" alt="Press" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('press'); ?>" style="color:black;">
									<span itemprop="headline">Press</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $press->description; ?>
							</div>
						</article>
					</div>

					<!-- Terms Of Use -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('terms_of_use'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$terms_of_use->icon_image; ?>" alt="Terms Of Use" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('terms_of_use'); ?>" style="color:black;">
									<span itemprop="headline">Terms Of Use</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $terms_of_use->description; ?>
							</div>
						</article>
					</div>

					<!-- Contact -->
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">
						
							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('contact'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$contact->icon_image; ?>" alt="Contact" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('contact'); ?>" style="color:black;">
									<span itemprop="headline">Contact</span>
								</a>
							</h5>
							
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
					)
					{ ?>
					
					<div class="col-xs-6 col-sm-3 col-md-2">
						<article class="listing" data-info="story medium" itemscope itemtype="">

							<!-- icon -->
							<div class="listing__media">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('made_to_order'); ?>">
									<img class="img-block listing__square-img" itemprop="image" src="<?php echo $this->config->item('PROD_IMG_URL').'images/pages/'.$made_to_order->icon_image; ?>" alt="Made To Order" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/pages/default-subcat-icon.jpg'; ?>')" style="width:100%;" />
								</a>
							</div>
							
							<!-- name -->
							<h5 class="listing__title" style="margin-top:10px;">
								<a class="listing__link" itemprop="url" href="<?php echo site_url('made_to_order'); ?>" style="color:black;">
									<span itemprop="headline">Made To Order</span>
								</a>
							</h5>
							
							<!-- desc -->
							<div class="listing__subtitle" style="max-height:none;">
								<?php echo $made_to_order->description; ?>
							</div>
						</article>
					</div>
					
						<?php 
					} ?>
					
				</div>
			
			</div>
			
