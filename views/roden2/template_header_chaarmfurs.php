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
						
						<script src="<?php echo assets_url(); ?>js/dd-menu.js"></script>
						
						<?php
						/**********
						 * Main Menu Navigation
						 */
						?>
						<nav id="nav-primary" class="nav nav-primary" role="navigation">
                            <ul>
								
								<?php
								/**********
								 * Special Sale Top Nav
								 */
								?>
								<?php if ($this->uri->segment(1) === 'special_sale' AND @$left_nav_sql->num_rows() > 0) { ?>
								
									<?php foreach($left_nav_sql->result_array() as $item): // ---> foreach subcategory ?>
									
									<?php
									/**********
									 * Subcats of all designers for special sale
									 */
									?>
								<li<?php if (
									$this->uri->segment(2) == $item['sc_url_structure'] OR 
									@$product->sc_folder == $item['sc_url_structure'] OR
									@$sc_url_structure == $item['sc_url_structure']
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo site_url('special_sale/'.$item['c_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['subcat_name']?> </a>
								</li>
									
									<?php endforeach; ?>
								
								<li>
									<a href="<?php echo site_url('apparel'); ?>">Back To Main Page</a>
								</li>
									
								<?php
								/**********
								 * Regular site top nav
								 */
								?>
								<?php } else { ?>
								
								<!--
								<li<?php if ($this->uri->segment(1) === 'designers') echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('designers')); ?>" onmouseover="showObj('sub-menu-01', this);" onmouseout="closetime();" style="cursor:default;">
										Designers
									</a>
									
									<ul id="sub-menu-01" onmouseover="cancelclosetime();" onmouseout="closetime();">
									
										<?php if ($designer_list): ?>
										
											<?php foreach ($designer_list as $designer): ?>
										
										<li>
											<a href="<?php echo str_replace('https', 'http', site_url($designer->url_structure)); ?>">
												<?php echo ucwords($designer->designer); ?>
											</a>
										</li>
										
											<?php endforeach; ?>
										
										<?php endif; ?>
										
									</ul>
									
								</li>
								-->
								<li<?php if (
									$this->uri->segment(2) == 'coats' OR 
									@$product->sc_folder == 'coats' OR
									@$sc_url_structure == 'coats'
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/coats')); ?>">
										Coats
									</a>
								</li>
								<li<?php if (
									$this->uri->segment(2) == 'jackets' OR 
									@$product->sc_folder == 'jackets' OR
									@$sc_url_structure == 'jackets'
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/jackets')); ?>">
										Jackets
									</a>
									<!--
									<ul id="sub-menu-jackets" onmouseover="cancelclosetime();" onmouseout="closetime();">
										<li>
											<a href="<?php echo str_replace('https', 'http', site_url('apparel/novelty_sweaters')); ?>">
												Novelty Sweaters
											</a>
										</li>
										<li>
											<a href="<?php echo str_replace('https', 'http', site_url('apparel/animal_sweaters')); ?>">
												Animal Sweaters
											</a>
										</li>
										<li>
											<a href="<?php echo str_replace('https', 'http', site_url('apparel/holiday_sweaters')); ?>">
												Holiday Sweaters
											</a>
										</li>
									</ul>
									-->
								</li> 
								<li<?php if (
									$this->uri->segment(2) == 'shawls' OR 
									@$product->sc_folder == 'shawls' OR 
									@$sc_url_structure == 'shawls'
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/shawls')); ?>">
										Shawls
									</a>
								</li>
								<li<?php if (
									$this->uri->segment(2) == 'accessories' OR 
									@$product->sc_folder == 'accessories' OR
									@$sc_url_structure == 'accessories'
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/accessories')); ?>">
										Accessories
									</a>
								</li>
								<li<?php if ($this->uri->uri_string() == 'events') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('events')); ?>">
										Events
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
								<li<?php if ($this->uri->uri_string() == 'press') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('press')); ?>">
										Press
									</a>
								</li>
								
								<li>
									<a href="<?php echo site_url('special_sale'); ?>" style="color:red;">
									
										<?php if ($this->session->userdata('user_loggedin')): ?>
										
										Clearance
										
										<?php else: ?>
										
										On Sale
										
										<?php endif; ?>
										
									</a>
								</li>
								-->
									
								<?php } ?>
								
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
							
									<a href="<?php echo str_replace('https', 'http', site_url('apparel')); ?>" title="Shop By Category">
										<strong>Shop By Category</strong>
									</a>

								<a class="icon icon--close fa fa-times" href="#wl-page-wrap" data-nav-close='' > <span class="visually-hidden">Close</span></a>
								
							</div>
							<ul>
								<?php if (@$file == 'page'): ?>
								
                                <li class="nav-mobile__continue-shopping">
                                    <a href="<?php echo str_replace('https', 'http', site_url()); ?>">
                                        Continue Shopping
                                    </a>
                                </li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'ordering' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('ordering')); ?>">Ordering </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'shipping' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('shipping')); ?>">Shipping </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'privacy_notice' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('privacy_notice')); ?>">Privacy </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'faq' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('faq')); ?>">FAQ </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'sitemap' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('sitemap')); ?>">Sitemap </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'press' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('press')); ?>">Press </a> 
								</li>
								
								<?php else: ?>
								
								<?php
								/**********
								 * This navigation is hard coded so that other pages like index and none
								 * product pages will display this correctly. Must change in future.
								 * INCLUDING the styles facet dropdown
								 */
								?>
								
									<?php
									/**********
									 * Special Sale Top Nav
									 */
									?>
									<?php if ($this->uri->segment(1) === 'special_sale' AND @$left_nav_sql->num_rows() > 0): ?>
									
										<?php foreach($left_nav_sql->result_array() as $item): // ---> foreach subcategory ?>
										
										<?php
										/**********
										 * Subcats of all designers for special sale
										 */
										?>
								<li<?php if (
									$this->uri->segment(2) == $item['sc_url_structure'] OR 
									@$product->sc_folder == $item['sc_url_structure'] OR
									@$sc_url_structure == $item['sc_url_structure']
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo site_url('special_sale/'.$item['c_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['subcat_name']?> </a>
								</li>
									
										<?php endforeach; ?>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel')); ?>" title="Regular Items">
										<strong>Back To Main Page</strong>
									</a>
								</li>
									
									<?php else: ?>
								
										<?php if ($this->config->item('hub_site') && $this->mobile_slideout_subcats->num_rows() > 0): ?>
										
											<?php foreach($this->mobile_slideout_subcats->result_array() as $item): // ---> foreach subcategory ?>
									
											<?php
											/**********
											 * Subcats of all designers
											 */
											?>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/'.$item['sc_url_structure'])); ?>" title="<?php echo $item['subcat_name']; ?>">
										<?php echo $item['subcat_name']; ?>
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '87', '5', ''), 'styles', 'evening-dresses'); // (facet, subcat, des, filter) ?>
									
								</li>
										
											<?php endforeach; ?>
									
										<?php else: ?>
									
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/coats')); ?>" title="Coats">
										Coats
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/jackets')); ?>" title="Jackets">
										Jackets
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/shawls')); ?>" title="Shawls">
										Shawls
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/accessories')); ?>" title="Accessories">
										Accessories
									</a>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/all').'?filter=&availability=instock'; ?>" style="color:red;">
										Shop In Stock Items
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/all').'?filter=&availability=preorder'; ?>" style="color:red;">
										Pre Order Items
									</a>
								</li>
								
								
										<?php endif; ?>
								<!--
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('designers')); ?>" title="Shop By Designer">
										<strong>Shop By Designer</strong>
									</a>
									<ul>
									
										<?php if ($designer_list): ?>
										
											<?php foreach ($designer_list as $designer): ?>
										
										<li class="navigation-item sub-navigation-item">
											<a href="<?php echo str_replace('https', 'http', site_url($designer->url_structure)); ?>">
												<?php echo ucwords($designer->designer); ?>
											</a>
											
												<?php
												/**********
												 * Designer subcats
												 */
												$slideout_des_subcats = $this->query_category->get_subcat_new('apparel', str_replace(array(' ','/'), array('_','.'), $designer->url_structure));
												?>
												
												<?php if ($slideout_des_subcats->num_rows() > 0): ?>
												
											<ul>
											
													<?php foreach($slideout_des_subcats->result_array() as $item): // ---> foreach subcategory ?>

												<li class="navigation-item sub-navigation-item">
													<a href="<?php echo site_url($item['d_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['subcat_name']?> </a>
													
												</li>
										
													<?php endforeach; ?>
												
											</ul>
											
												<?php endif; ?>
											
										</li>
										
											<?php endforeach; ?>
										
										<?php endif; ?>
										
									</ul>
								</li>

								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('special_sale')); ?>" title="Special Sale" style="color:red;">
									
										<?php if ($this->session->userdata('user_loggedin')): ?>
										
										<strong>Clearance</strong>
										
										<?php else: ?>
										
										<strong>On Sale</strong>
										
										<?php endif; ?>
										
									</a>
								</li>
								-->
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('wholesale/signin')); ?>" title="Retailer Login">
										<strong>Retailer Login</strong>
									</a>
								</li>
								
								<li class="navigation-item">
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('events')); ?>" title="Upcoming Events">
										<strong>Upcoming Events</strong>
									</a>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('press')); ?>" title="Press">
										<strong>Press</strong>
									</a>
								</li>
								
									<?php endif; ?>
									
								<?php endif; ?>
									
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url(($this->uri->segment(1) == 'special_sale' ? 'special_sale/' : '').'contact')); ?>" title="Contact">
										<strong>Contact</strong>
									</a>
								</li>
								
							</ul>
							
						</div><!-- #nav-mobile -->

						<?php
						$this->load->view($this->config->slash_item('template').'template_header_breadcrumb');
						$this->load->view($this->config->slash_item('template').'template_header_banner_part');
						?>
						
