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
							color: #d39084;
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
									$this->uri->segment(2) == 'tops' OR 
									@$product->sc_folder == 'tops' OR
									@$sc_url_structure == 'tops'
								) echo ' class="active_11"'; ?>>
									<a accesskey="3" href="<?php echo site_url('apparel/tops'); ?>">
										Tops
									</a>
								</li> 
								<li<?php if (
									$this->uri->segment(2) == 'sweaters' OR 
									@$product->sc_folder == 'sweaters' OR
									@$sc_url_structure == 'sweaters'
								) echo ' class="active_11"'; ?>>
									<a accesskey="3" href="<?php echo site_url('apparel/sweaters'); ?>">
										Sweaters
									</a>
								</li> 
                                <li<?php if (
									$this->uri->segment(2) == 'dresses' OR 
									@$product->sc_folder == 'dresses' OR
									@$sc_url_structure == 'dresses'
								) echo ' class="active_11"'; ?>>
                                    <a href="<?php echo site_url('apparel/dresses'); ?>" accesskey="2">
                                        Dresses
                                    </a>
                                </li>
								<li<?php if (
									$this->uri->segment(2) == 'skirts' OR 
									@$product->sc_folder == 'skirts' OR
									@$sc_url_structure == 'skirts'
								) echo ' class="active_11"'; ?>>
									<a accesskey="3" href="<?php echo site_url('apparel/skirts'); ?>">
										Skirts
									</a>
								</li> 
								<li<?php if (
									$this->uri->segment(2) == 'outerwear' OR 
									@$product->sc_folder == 'outerwear' OR
									@$sc_url_structure == 'outerwear'
								) echo ' class="active_11"'; ?>>
									<a accesskey="3" href="<?php echo site_url('apparel/outerwear'); ?>">
										Outerwear
									</a>
								</li> 
								
								<li<?php if (@$_GET['availability'] == 'instock') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo site_url('shop/all').'?filter=&availability=instock'; ?>" style="color:red;">
										In Stock Items
									</a>
								</li>
								<li<?php if (@$_GET['availability'] == 'preorder') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo site_url('shop/all').'?filter=&availability=preorder'; ?>" style="color:red;">
										Pre Order Items
									</a>
								</li>
								
								<!--
								<li<?php if ($this->uri->uri_string() == 'events') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo site_url('events'); ?>">
										Events
									</a>
								</li>
								<li<?php if ($this->uri->uri_string() == 'press') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo site_url('press'); ?>">
										Press
									</a>
								</li>
								-->
								
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
								<a href="javascript:void(0);"> </a>
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
								<li class="nav-item<?php echo $this->uri->uri_string() === 'press' ? ' active current' : ''; ?>">
									<a href="<?php echo site_url('press'); ?>">Press </a> 
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
								
								<li class="navigation-item">
									<a href="<?php echo site_url('apparel/tops'); ?>" title="Tops">
										Tops
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url('apparel/sweaters'); ?>" title="Sweaters">
										Sweaters
									</a>
								</li>
                                <li class="navigation-item">
                                    <a href="<?php echo site_url('apparel/dresses'); ?>" title="Dresses">
                                        Dresses
                                    </a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '75', '5', ''), 'styles', 'cocktail-dresses'); // (facet, subcat, des, filter) ?>
									
                                </li>
								<li class="navigation-item">
									<a href="<?php echo site_url('apparel/skirts'); ?>" title="Skirts">
										Skirts
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url('apparel/outerwear'); ?>" title="Outerwear">
										Outerwear
									</a>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/all').'?filter=&availability=instock'; ?>" style="color:red;">
										In Stock Items
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/all').'?filter=&availability=preorder'; ?>" style="color:red;">
										Pre Order Items
									</a>
								</li>
								
								<li class="navigation-item">
									<a accesskey="7" href="<?php echo site_url('evetns'); ?>" title="Events">
										Upcoming Events
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url('press'); ?>" title="Press">
										Press
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url('wholesale/signin'); ?>" title="Retailer Login">
										Retailer Login
									</a>
								</li>
								
								<?php endif; ?>
							</ul>
						</div><!-- #nav-mobile -->

						<?php
						$this->load->view($this->config->slash_item('template').'template_header_breadcrumb');
						$this->load->view($this->config->slash_item('template').'template_header_banner_part');
						?>
						
