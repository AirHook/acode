							<?php
							/**********
							 * Side Nav
							 */
							?>
                            <div id="aside" class="aside  content-grid__navigation" role="complementary">
								<div class="nav">
									<ul class="nav-secondary nav-content">
									
										<li class="nav-item<?php echo ($this->uri->uri_string() != '' && strpos('shop/all', $this->uri->uri_string()) !== FALSE) ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('shop/all'); ?>">All Products</a>
										</li>
										
										<?php
										/**********
										 * Dynamic sidebar navigatioin
										 */
										?>
										<?php if ($categories) { ?>
										
										<?php
										/**********
										 * Browse by Category
										 */
										?>
										<li class="nav-item header-nav-item <?php echo $left_nav === 'sidebar_browse_by_category' ? 'active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/categories'); ?>" title="Shop By Category" style="cursor:pointer;"><strong>SHOP BY CATEGORY</strong></a>
											<a class="mm-next <?php echo ($left_nav === 'sidebar_browse_by_category' OR @$this->webspace_details->options['site_type'] == 'sat_site') ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="$(this).toggleClass('nav-collapse');$('.category-nav-item').toggle();"></a>
										</li>
										
											<?php foreach($categories as $item) { // ---> foreach subcategory ?>
												<?php if ($item->category_id != '1') { ?>
												
													<?php if (@$this->webspace_details->options['site_type'] == 'hub_site') { ?>
													
											<?php
											/**********
											 * Subcats of all designers
											 */
											?>
										<li class="nav-item main-nav-item category-nav-item<?php echo ($left_nav === 'sidebar_browse_by_category' && $item->category_slug === $sc_url_structure) ? ' active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_category' ? '': 'hidden'; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/apparel/'.$item->category_slug); ?>"><?php echo $item->category_name?> </a>
										</li>
										
													<?php } else { ?>
												
														<?php 
														// --> identify categories linked to designer for satellite sites
														if (
															strpos($item->d_url_structure, $this->webspace_details->slug) !== FALSE // --> avoid catching '0' strpos as false
														) 
														{ 
														?>
										
											<?php
											/**********
											 * Subcats of satellite designer
											 */
											?>
										<li class="nav-item main-nav-item category-nav-item<?php echo ($left_nav === 'sidebar_browse_by_category' && $item->category_slug === $sc_url_structure) ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/apparel/'.$item->category_slug); ?>"><?php echo $item->category_name?> </a>
										</li>
										
														<?php } ?>
													
													<?php } ?>
													
												<?php } ?>
											<?php } ?>
											
											<?php
											/**********
											 * SPECIAL SALE menu item
											 */
											?>
										<li class="nav-item main-nav-item category-nav-item<?php echo ($this->uri->uri_string() == site_url('shop/all').'?filter=&availability=onsale') ? ' active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_category' ? '': 'hidden'; ?>">
											<a href="<?php echo site_url('shop/all'); ?>?filter=&availability=onsale"> <span style="color:red;">SPECIAL SALE</span> </a>
										</li>
										
											<?php if (@$this->webspace_details->options['site_type'] == 'hub_site') { ?>
										
											<?php
											/**********
											 * Browse by Designer
											 */
											?>
										<li class="nav-item header-nav-item <?php echo $left_nav === 'sidebar_browse_by_designer' ? 'active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/designers'); ?>" title="Shop By Designer" style="cursor:pointer;"><strong>SHOP BY DESIGNER</strong></a>
											<a class="mm-next <?php echo $left_nav === 'sidebar_browse_by_designer' ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="$(this).toggleClass('nav-collapse');$('.designer-nav-item').toggle();$('.designer-category-nav-item.open.shown').toggle();"></a>
										</li>
										
												<?php foreach ($designers as $designer) { ?>
											
													<?php 
													if (
														$designer->url_structure !== 'instylenewyork'
														&& $designer->with_products != '0'
													)
													{ ?>
												
														<?php
														/**********
														 * Designers
														 */
														?>
										<li class="nav-item main-nav-item designer-nav-item<?php echo $this->uri->segment(3) == $designer->url_structure ? ' active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_designer' ? '': 'hidden'; ?>">
											<a href="<?php echo str_replace('https', 'http', site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/designers/'.$designer->url_structure)); ?>">
												<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer->designer)); ?>
											</a>
											<a class="mm-next <?php echo $this->uri->segment(3) == $designer->url_structure ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="$(this).toggleClass('nav-collapse');$('.designer-<?php echo $designer->url_structure; ?>-nav-item').toggle();$('.designer-<?php echo $designer->url_structure; ?>-nav-item').toggleClass('open');$('.designer-<?php echo $designer->url_structure; ?>-nav-item').toggleClass('shown');"></a>
										</li>
										
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
															//$des_subcats = $this->query_category->get_subcat_new('apparel', str_replace(array(' ','/'), array('_','.'), $designer->url_structure));
															$des_subcats = $this->categories_tree->treelist(array('d_url_structure'=>$designer->url_structure,'with_products'=>TRUE));
														}
														?>
														
														<?php foreach($des_subcats as $item) { // ---> foreach subcategory ?>
															<?php if ($item->category_id != '1') { ?>
													
											<li class="nav-item sub-navigation-item designer-category-nav-item designer-<?php echo $designer->url_structure; ?>-nav-item <?php echo (($this->uri->segment(2) === $designer->url_structure OR $this->uri->segment(3) === $designer->url_structure) AND $item->category_slug === $sc_url_structure) ? 'active current' : ''; ?> <?php echo ((in_array($this->uri->segment(2), explode(',', $item->d_url_structure)) OR in_array($this->uri->segment(3), explode(',', $item->d_url_structure))) && ($designer->url_structure == $this->uri->segment(2) OR $designer->url_structure == $this->uri->segment(3))) ? 'open shown': 'close hidden'; ?>">
												<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/'.$designer->url_structure.'/apparel/'.$item->category_slug); ?>"><?php echo $item->category_name; ?> </a>
											</li>
											
															<?php } ?>
														<?php } ?>
											
													<?php } ?>
												
												<?php } ?>
											
											<?php } ?>
								
										<?php
										/**********
										 * On Sale / Back To Main Page
										 */
										?>
										<li class="nav-item header-nav-item hidden">
											
											<?php if ($this->uri->segment(1) !== 'special_sale') { ?>
											
											<a href="<?php echo site_url('special_sale/apparel'); ?>" title="Special Sale" style="cursor:pointer;color:red;">
												
												<?php if ($this->session->userdata('user_loggedin')) { ?>
												
												<strong>CLEARANCE ITEMS</strong>
												
												<?php } else { ?>
												
												<strong>ON SALE ITEMS</strong>
												
												<?php } ?>
												
											</a>
											
											<?php } else { ?>
											
											<a href="<?php echo site_url('apparel'); ?>" title="Back To Main Page" style="cursor:pointer;"><strong>REGULAR ITEMS PAGES</strong></a>
											
											<?php } ?>
											
										</li>
										
										<?php } else { ?>
										
										<?php
										/**********
										 * Static sidebar navigatioin
										 * For static pages such as Contact Us, etc...
										 */
										?>
										<li class="nav-item">
											<a name="#">Customer Services</a>
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'ordering' OR $this->uri->uri_string() === 'special_sale/ordering') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'ordering'); ?>">Ordering </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'shipping' OR $this->uri->uri_string() === 'special_sale/shipping') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shipping'); ?>">Shipping </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'privacy_notice' OR $this->uri->uri_string() === 'special_sale/privacy_notice') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'privacy_notice'); ?>">Privacy </a> 
										</li>
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'faq' OR $this->uri->uri_string() === 'special_sale/faq') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'faq'); ?>">FAQ </a> 
										</li>
										
											<?php if ($this->uri->segment(1) !== 'special_sale') { ?>
										
										<li class="nav-item<?php echo $this->uri->uri_string() === 'sitemap' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'sitemap'); ?>">Sitemap </a> 
										</li>
										
											<?php } ?>
										
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'contact' OR $this->uri->uri_string() === 'special_sale/contact') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'contact'); ?>">Contact </a> 
										</li>
										
										<?php } ?>
										
									</ul>
								</div>
                            </div><!-- end ASIDE -->
