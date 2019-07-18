					<?php
					/**********
					 * HEADER
					 */
					?>
					<div id="header" class="header clearfix" role="banner">
					
						<?php
						/**********
						 * Primary Navigation
						 *
						 * Had to add the facets query for each subcat menu item for the dropdown
						 * menu item. This feature includes having to add styles below and includ
						 * the javascript for some functions to show dropdown menus. The feature
						 * also involved globally loading library MyFacets which is done at
						 * Frontend_Controller.php class construct. Employed the usual facet query
						 * which is copied from the show_subcat_products2() function as well as
						 * other functions.
						 
						 * NOTE: currently the dropdown menu is not used... as on 20160127
						 */
						?>
						<style>
						.nav-primary ul ul {
							position: absolute;
							display: block;
							border: 1px solid grey;
							background: white;
							z-index: 2500;
							width: 450px;
							padding: 20px;
							visibility: hidden;
						}
						.nav-primary ul ul li {
							display: block;
							text-align: left;
						}
						.nav-primary ul li.active_1 > a {
							color: #846921;
						}
						</style>
						
						<script src="<?php echo assets_url('assets'); ?>/js/jstools.js"></script>
						
						<?php
						/**********
						 * Main Menu Navigation
						 */
						?>
						<nav id="nav-primary" class="nav nav-primary" role="navigation">
                            <ul>
                                <li<?php if (
									$this->uri->segment(2) == 'evening_prom_dresses' OR 
									@$product->sc_folder == 'evening_prom_dresses' OR
									@$sc_url_structure == 'evening_prom_dresses'
								) echo ' class="active_1"'; ?>>
                                    <a href="http://www.instylenewyork.com/basix-black-label/evening_prom_dresses.html" accesskey="2">
                                        Evening Prom Dresses
                                    </a>
                                </li>
								<li<?php if (
									$this->uri->segment(2) == 'cocktail_prom_dresses' OR 
									@$product->sc_folder == 'cocktail_prom_dresses' OR
									@$sc_url_structure == 'cocktail_prom_dresses'
								) echo ' class="active_1"'; ?>>
                                    <a href="http://www.instylenewyork.com/basix-black-label/cocktail_prom_dresses.html" accesskey="2">
										Cocktail Prom Dresses
									</a>
								</li> 
								<li<?php if ($this->uri->uri_string() == 'made_to_order') echo ' class="active_1"'; ?>>
									<a accesskey="6" href="<?php echo site_url('made_to_order'); ?>">
										Made To Order
									</a>
								</li>
								<li<?php if ($this->uri->uri_string() == 'events') echo ' class="active_1"'; ?>>
									<a accesskey="7" href="<?php echo site_url('events'); ?>">
										Shows &amp; Events
									</a>
								</li>
                            </ul>
							
							<div class="nav-primary-dropdown" style="width">
								This is a drop down nav
							</div>
							
						</nav><!-- #nav-primary -->

						<?php
						/**********
						 * Mobile Navigation
						 */
						?>
						<div id="nav-mobile" class="nav-mobile">
							<div class="mobile-nav-top">
								<a class="icon icon--close fa fa-times" href="#wl-page-wrap" data-nav-close='' > <span class="visually-hidden">Close</span></a>
							</div>
							<ul>
								<?php if (@$file == 'page'): ?>
								
                                <li class="nav-mobile__continue-shopping">
                                    <a href="<?php echo site_url(); ?>">
                                        Continue Shopping
                                    </a>
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
								
								<?php else: ?>
								
								<?php
								/**********
								 * This navigation is hard coded so that other pages like index and none
								 * product pages will display this correctly. Must change in future.
								 * INCLUDING the styles facet dropdown
								 */
								?>
								
                                <li id="book-an-appointment">
                                    <a href="http://www.instylenewyork.com/basix-black-label/evening_prom_dresses.html" title="Evening Prom Dresses">
                                        Evening Prom Dresses
                                    </a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo @$this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '159', '58', ''), 'styles', 'evening_prom_dresses'); // (facet, subcat, des, filter) ?>
									
                                </li>
								<li class="navigation-item">
                                    <a href="http://www.instylenewyork.com/basix-black-label/cocktail_prom_dresses.html" title="Cocktail Prom Dresses">
										Bridesmaids
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo @$this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '160', '58', ''), 'styles', 'cocktail_prom_dresses'); // (facet, subcat, des, filter) ?>
									
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url(); ?>" title="Made To Order">
										Made To Order
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url(); ?>" title="Shows &amp; Events">
										Shows &amp; Events
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url('wholesale/signin'); ?>" title="Retailer Login">
										Store Login
									</a>
								</li>
								
								<?php endif; ?>
							</ul>
						</div><!-- #nav-mobile -->

						<?php
						$this->load->view($this->config->slash_item('template').'template_header_breadcrumb');
						$this->load->view($this->config->slash_item('template').'template_header_banner_part');
						?>
						
