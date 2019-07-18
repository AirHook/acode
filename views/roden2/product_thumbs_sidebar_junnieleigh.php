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
										
											<?php foreach($left_nav_sql->result_array() as $item): // ---> foreach subcategory ?>
										
										<li class="nav-item<?php echo $item['sc_url_structure'] === $sc_url_structure ? ' active' : ''; echo $this->uri->uri_string() === $item['c_url_structure'].'/'.$item['sc_url_structure'] ? ' current' : ''; ?>">
											<a href="<?php echo site_url($item['c_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['category_name']?> </a>
											
											<!-- Place the resulting style facets here -->
											<?php //if ($item['sc_url_structure'] === $sc_url_structure) echo $this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $item['sc_url_structure']); ?>
											
										</li>
										
											<?php endforeach; ?>
										
										<?php else: ?>
										
										<li class="nav-item">
											<a name="#">Customer Services</a>
										</li>
										<li class="nav-item<?php echo $this->uri->uri_string() === 'ordering' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('ordering'); ?>">Ordering </a> 
										</li>
										<li class="nav-item<?php echo $this->uri->uri_string() === 'shipping' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('shipping'); ?>">Shipping </a> 
										</li>
										<li class="nav-item<?php echo $this->uri->uri_string() === 'privacy_notice' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('privacy_notice'); ?>">Privacy </a> 
										</li>
										<li class="nav-item<?php echo $this->uri->uri_string() === 'faq' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('faq'); ?>">FAQ </a> 
										</li>
										<li class="nav-item<?php echo $this->uri->uri_string() === 'sitemap' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('sitemap'); ?>">Sitemap </a> 
										</li>
										<li class="nav-item<?php echo $this->uri->uri_string() === 'contact' ? ' active current' : ''; ?>">
											<a href="<?php echo site_url('contact'); ?>">Contact </a> 
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