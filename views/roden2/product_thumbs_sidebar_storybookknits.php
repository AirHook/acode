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
										<?php if (@$left_nav_sql->num_rows() > 0): ?>
										
											<?php
											/**********
											 * HUB Site Sidebar
											 */
											?>
											<?php if ($this->config->item('hub_site')): ?>
											
												<?php
												/**********
												 * Browse by Category
												 */
												?>
										<li class="nav-item header-nav-item <?php echo $left_nav === 'sidebar_browse_by_category' ? 'active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'apparel'); ?>" title="Shop By Category" style="cursor:pointer;"><strong>SHOP BY CATEGORY</strong></a>
											<a class="mm-next <?php echo $left_nav === 'sidebar_browse_by_category' ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="$(this).toggleClass('nav-collapse');$('.category-nav-item').toggle();"></a>
										</li>
										
												<?php foreach($left_nav_sql->result_array() as $item): // ---> foreach subcategory ?>
											
													<?php
													/**********
													 * Subcats of all designers
													 */
													?>
										<li class="nav-item main-nav-item category-nav-item<?php echo (($this->uri->segment(1) == 'apparel' OR $this->uri->segment(1) === 'special_sale') AND $item['sc_url_structure'] === $sc_url_structure) ? ' active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_category' ? '': 'hidden'; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').$item['c_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['category_name']?> </a>
										</li>
										
												<?php endforeach; ?>
										
												<?php
												/**********
												 * Browse by Designer
												 */
												?>
										<li class="nav-item header-nav-item <?php echo $left_nav === 'sidebar_browse_by_designer' ? 'active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'designers'); ?>" title="Shop By Designer" style="cursor:pointer;"><strong>SHOP BY DESIGNER</strong></a>
											<a class="mm-next <?php echo $left_nav === 'sidebar_browse_by_designer' ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="$(this).toggleClass('nav-collapse');$('.designer-nav-item').toggle();$('.designer-category-nav-item.open.shown').toggle();"></a>
										</li>
										
												<?php foreach ($this->designers_ary as $designer): ?>
												
													<?php if ($designer !== 'instylenewyork'): ?>
												
													<?php
													/**********
													 * Designers
													 */
													?>
										<li class="nav-item main-nav-item designer-nav-item<?php echo ($this->uri->segment(1) == str_replace(array(' ','/'), array('_','.'), $designer) OR $this->uri->segment(2) == str_replace(array(' ','/'), array('_','.'), $designer)) ? ' active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_designer' ? '': 'hidden'; ?>">
											<a href="<?php echo str_replace('https', 'http', site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').$designer)); ?>">
												<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer)); ?>
											</a>
											<a class="mm-next <?php echo ($this->uri->segment(1) == str_replace(array(' ','/'), array('_','.'), $designer) OR $this->uri->segment(2) == str_replace(array(' ','/'), array('_','.'), $designer)) ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="$(this).toggleClass('nav-collapse');$('.designer-<?php echo $designer; ?>-nav-item').toggle();$('.designer-<?php echo $designer; ?>-nav-item').toggleClass('open');$('.designer-<?php echo $designer; ?>-nav-item').toggleClass('shown');"></a>
										</li>
										
														<?php
														/**********
														 * Designer subcats
														 */
														if ($this->uri->segment(1) === 'special_sale')
														{
															$des_subcats = $this->query_category->get_special_sale_subcats_with_products(str_replace(array(' ','/'), array('_','.'), $designer));
														}
														else
														{
															$des_subcats = $this->query_category->get_subcat_new($c_url_structure, str_replace(array(' ','/'), array('_','.'), $designer));
														}
														?>
														
														<?php foreach($des_subcats->result_array() as $item): // ---> foreach subcategory ?>
															
										<li class="nav-item sub-navigation-item designer-category-nav-item designer-<?php echo $designer; ?>-nav-item <?php echo (($this->uri->segment(1) === $designer OR $this->uri->segment(2) === $designer) AND $item['sc_url_structure'] === $sc_url_structure) ? 'active current' : ''; ?> <?php echo ($this->uri->segment(1) === $item['d_url_structure'] OR $this->uri->segment(2) === $item['d_url_structure']) ? 'open shown': 'close hidden'; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').$item['d_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['category_name']; ?> </a>
										</li>
											
														<?php endforeach; ?>
												
													<?php endif; ?>
													
												<?php endforeach; ?>
									
												<?php
												/**********
												 * On Sale / Back To Main Page
												 */
												?>
										<li class="nav-item header-nav-item">
											
												<?php if ($this->uri->segment(1) !== 'special_sale'): ?>
											
											<a href="<?php echo site_url('special_sale/apparel'); ?>" title="Special Sale" style="cursor:pointer;color:red;">
												
													<?php if ($this->session->userdata('user_loggedin')): ?>
													
													<strong>CLEARANCE</strong>
													
													<?php else: ?>
													
													<strong>ON SALE</strong>
													
													<?php endif; ?>
													
											</a>
											
												<?php else: ?>
											
											<a href="<?php echo site_url('apparel'); ?>" title="Back To Main Page" style="cursor:pointer;"><strong>BACK TO MAIN PAGE</strong></a>
											
												<?php endif; ?>
											
										</li>
										
											<?php else: ?>
											
											<?php
											/**********
											 * Satellite Site Sidebar
											 */
											?>
												<?php foreach($left_nav_sql->result_array() as $item): // ---> foreach subcategory ?>
										
												<?php
												/**********
												 * Subcats of all designers
												 */
												?>
										<li class="nav-item header-nav-item <?php echo (($this->uri->segment(1) == 'apparel' OR $this->uri->segment(1) === 'special_sale') AND $item['sc_url_structure'] === $sc_url_structure) ? 'active' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').$item['c_url_structure'].'/'.$item['sc_url_structure']); ?>">
												<?php echo $item['category_name']; ?>
											</a>
										</li>
										
												<?php endforeach; ?>
													
											<?php endif; ?>
										
										<?php else: ?>
										
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
										
											<?php if ($this->uri->segment(1) !== 'special_sale'): ?>
										
										<li class="nav-item<?php echo $this->uri->uri_string() === 'sitemap' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'sitemap'); ?>">Sitemap </a> 
										</li>
										
											<?php endif; ?>
										
										<li class="nav-item<?php echo ($this->uri->uri_string() === 'contact' OR $this->uri->uri_string() === 'special_sale/contact') ? ' active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'contact'); ?>">Contact </a> 
										</li>
										
										<?php endif; ?>
										
									</ul>
								</div>
                            </div><!-- end ASIDE -->
							
	<?php
	/***************
	 *	COMMENTS:
	 
		as of 20161003, side bar nav facets are removed and put as a drop down filter on the thumbs
		commenting the facets sub nav items temporarily
	 */