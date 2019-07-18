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
						.nav-primary ul ul.pan-right {
							position: absolute;
							display: block;
							border: 1px solid grey;
							background: white;
							z-index: 2500;
							width: 450px;
							padding: 20px;
							right: 0px;
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
						
						<script src="<?php echo base_url('assets/themes/roden2/custom'); ?>/jscript/dd-menu.js"></script>
						
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
								 *
								 * This nav is for special sale section only. However, as of 20170128
								 * We are making the special sale section a part of the normal website's
								 * top nav. Hidding this for now...
								 */
								?>
								<?php if ($this->uri->segment(1) === 'special_sale' AND @$left_nav_sql->num_rows() > 0): ?>
								
									<?php foreach($left_nav_sql->result_array() as $item) { // ---> foreach subcategory ?>
									
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
									<a href="<?php echo site_url('special_sale/'.$item['c_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['category_name']?> </a>
								</li>
									
									<?php } ?>
								
								<li>
									<a href="<?php echo site_url('apparel'); ?>">Back To Main Page</a>
								</li>
									
								<?php
								/**********
								 * Regular site top nav
								 */
								?>
								<?php else: ?>
								
								<li<?php if ($this->uri->segment(1) === 'designers') echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('designers')); ?>" onmouseover="showObj('sub-menu-01', this);" onmouseout="closetime();" style="cursor:default;">
										All Designers
									</a>
									
									<ul id="sub-menu-01" onmouseover="cancelclosetime();" onmouseout="closetime();">
									
										<?php foreach ($designer_list as $designer): ?>
										
											<?php if ($designer->url_structure !== 'instylenewyork' && $designer->with_products == '1'): ?>
											
										<li>
											<a href="<?php echo str_replace('https', 'http', site_url($designer->url_structure)); ?>">
												<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer->designer)); ?>
											</a>
										</li>
										
										<?php endif; endforeach; ?>
										
									</ul>
									
								</li>
								
									<?php
									/**********
									 * Top Nav Based on Browse By Designer 
									 */
									?>
									<?php if (isset($left_nav) && $left_nav === 'sidebar_browse_by_designer'): ?>
									
										<?php
										/**********
										 * Designer subcats
										 */
										$des_subcats = $this->query_category->get_subcat_new('apparel', str_replace(array(' ','/'), array('_','.'), $this->uri->segment(1)));
										?>
										<?php foreach($des_subcats->result_array() as $item): // ---> foreach subcategory ?>
										
								<li class="">
									<a href="<?php echo site_url($item['d_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['category_name']; ?> </a>
									
										<?php
										/**********
										 * Facets
										 */
										?>
									<!-- Place the resulting style facets here -->
									<?php //if ($item['sc_url_structure'] === $sc_url_structure) echo $this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $item['sc_url_structure'], $item['d_url_structure']); ?>
									
								</li>
									
										<?php endforeach; ?>
										
									<?php else: ?>
									
									<?php
									/**********
									 * Default Top Nav
									 */
									?>
								<li<?php if (
									$this->uri->segment(2) == 'evening-dresses' OR 
									@$product->sc_folder == 'evening-dresses' OR
									@$sc_url_structure == 'evening-dresses'
								) echo ' class="active_11"'; ?>>
									<a accesskey="3" href="<?php echo str_replace('https', 'http', site_url('apparel/evening-dresses')); ?>">
										Evening Dresses
									</a>
								</li>
								<li<?php if (
									$this->uri->segment(2) == 'cocktail-dresses' OR 
									@$product->sc_folder == 'cocktail-dresses' OR
									@$sc_url_structure == 'cocktail-dresses'
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/cocktail-dresses')); ?>" accesskey="2">
										Cocktail Dresses
									</a>
								</li>
								<li<?php if (
									$this->uri->segment(2) == 'bridal_dresses' OR 
									@$product->sc_folder == 'bridal_dresses' OR
									@$sc_url_structure == 'bridal_dresses'
								) echo ' class="active_11"'; ?>>
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/bridal_dresses')); ?>" accesskey="2">
										Wedding Dresses
									</a>
								</li>
								<li<?php if (
									$this->uri->segment(2) == 'tops' OR 
									@$product->sc_folder == 'tops' OR
									@$sc_url_structure == 'tops'
								) echo ' class="active_11"'; ?>>
									<a accesskey="4" href="<?php echo str_replace('https', 'http', site_url('apparel/tops')); ?>">
										Tops
									</a>
								</li> 
								
								<li<?php if (
									$this->uri->segment(2) == 'jumpsuits' OR 
									@$product->sc_folder == 'jumpsuits' OR
									@$sc_url_structure == 'jumpsuits'
								) echo ' class="active_11"'; ?>>
									<a accesskey="5" href="<?php echo str_replace('https', 'http', site_url('apparel/jumpsuits')); ?>">
										Jumpsuits
									</a>
								</li>
							
								<li<?php if ($this->uri->segment(1) === 'designers') echo ' class="active_11"'; ?>>
									<a onmouseover="showObj('sub-menu-bottoms', this);" onmouseout="closetime();" style="cursor:default;">
										Bottoms
									</a>
									
									<ul id="sub-menu-bottoms" onmouseover="cancelclosetime();" onmouseout="closetime();">

										<li<?php if (
											$this->uri->segment(2) == 'skirts' OR 
											@$product->sc_folder == 'skirts' OR 
											@$sc_url_structure == 'skirts'
										) echo ' class="active_11"'; ?>>
											<a accesskey="5" href="<?php echo str_replace('https', 'http', site_url('apparel/skirts')); ?>">
												Skirts
											</a>
										</li>
										<li<?php if (
											@$this->uri->segment(2) == 'shorts' OR 
											@$product->sc_folder == 'shorts' OR
											@$sc_url_structure == 'shorts'
										) echo ' class="active_11"'; ?>>
											<a accesskey="5" href="<?php echo str_replace('https', 'http', site_url('apparel/shorts')); ?>">
												Shorts
											</a>
										</li>
										<li<?php if (
											$this->uri->segment(2) == 'pants' OR 
											@$product->sc_folder == 'pants' OR
											@$sc_url_structure == 'pants'
										) echo ' class="active_11"'; ?>>
											<a accesskey="5" href="<?php echo str_replace('https', 'http', site_url('apparel/pants')); ?>">
												Pants
											</a>
										</li>

									</ul>

								</li>
								
									<?php endif; ?>
									
									<?php //if ( ! $this->session->userdata('user_loggedin') OR $this->session->userdata('user_cat') != 'wholesale'): ?>
									
								<!--
								<li<?php if ($this->uri->uri_string() == 'made_to_order') echo ' class="active_1"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('made_to_order')); ?>">
										Made To Order
									</a>
								</li>
								-->
								
									<?php //endif; ?>
								
								<li<?php if (@$_GET['availability'] == 'instock') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('shop/all')).'?filter=&availability=instock'; ?>" style="color:red;">
										In Stock Items
									</a>
								</li>
								<li<?php if (@$_GET['availability'] == 'preorder') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('shop/all')).'?filter=&availability=preorder'; ?>" style="color:red;">
										Pre Order Items
									</a>
								</li>
								
								<!--
								<li<?php if ($this->uri->uri_string() == 'events') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('events')); ?>">
										Events
									</a>
								</li>
								<li<?php if ($this->uri->uri_string() == 'press') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('press')); ?>">
										Press
									</a>
								</li>
								-->
								
								<li>
									<a href="<?php echo str_replace('https', 'http', site_url('shop/all')).'?filter=&availability=onsale'; ?>" style="color:red;" onmouseover="showObj_('sub-menu-sale', this);" onmouseout="closetime();" style="cursor:default;">
									
										<?php if ($this->session->userdata('user_loggedin')): ?>
										
										Clearance
										
										<?php else: ?>
										
										On Sale
										
										<?php endif; ?>
										
									</a>
									
									<ul id="sub-menu-sale" class="pan-right" onmouseover="cancelclosetime();" onmouseout="closetime();">
									
										<li>
											<a href="<?php echo str_replace('https', 'http', site_url('special_sale/apparel/evening-dresses')); ?>">Evening Dresses </a>
										</li>
										<li>
											<a href="<?php echo str_replace('https', 'http', site_url('special_sale/apparel/cocktail-dresses')); ?>">Cocktail Dresses </a>
										</li>
										
									</ul>
									
								</li>
								
								<?php endif;?>
								
								<!--
								<li<?php if ($this->uri->uri_string() == 'contact') echo ' class="active_11"'; ?>>
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('contact')); ?>">
										Contact
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
							
									<a href="<?php echo str_replace('https', 'http', site_url('apparel')); ?>" title="Shop By Category">
										<strong>Shop By Category</strong>
									</a>

								<a class="icon icon--close fa fa-times" href="#wl-page-wrap" data-nav-close='' > <span class="visually-hidden">Close</span></a>
								
							</div>
							<ul>
								
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
									<a href="<?php echo site_url('special_sale/'.$item['c_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['category_name']?> </a>
								</li>
									
										<?php endforeach; ?>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel')); ?>" title="Regular Items">
										<strong>Back To Main Page</strong>
									</a>
								</li>
									
									<?php else: ?>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/evening-dresses')); ?>" title="Evening Dresses">
										Evening Dresses
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '87', '5', ''), 'styles', 'evening-dresses'); // (facet, subcat, des, filter) ?>
									
								</li>
                                <li class="navigation-item">
                                    <a href="<?php echo str_replace('https', 'http', site_url('apparel/cocktail-dresses')); ?>" title="Cocktail Dresses">
                                        Cocktail Dresses
                                    </a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '75', '5', ''), 'styles', 'cocktail-dresses'); // (facet, subcat, des, filter) ?>
									
                                </li>
                                <li class="navigation-item">
                                    <a href="<?php echo str_replace('https', 'http', site_url('apparel/bridal_dresses')); ?>" title="Wedding Dresses">
                                        Wedding Dresses
                                    </a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '75', '5', ''), 'styles', 'bridal_dresses'); // (facet, subcat, des, filter) ?>
									
                                </li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/tops')); ?>" title="Tops">
										Tops
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '133', '5', ''), 'styles', 'tops'); // (facet, subcat, des, filter) ?>
									
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/skirts')); ?>" title="Skirts">
										Skirts
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '91', '5', ''), 'styles', 'skirts'); // (facet, subcat, des, filter) ?>
									
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/shorts')); ?>" title="Shorts">
										Shorts
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '129', '5', ''), 'styles', 'shorts'); // (facet, subcat, des, filter) ?>
									
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/pants')); ?>" title="Pants">
										Pants
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '132', '5', ''), 'styles', 'pants'); // (facet, subcat, des, filter) ?>
									
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('apparel/jumpsuits')); ?>" title="Jumpsuits">
										Jumpsuits
									</a>
									
									<!-- Place the resulting style facets here -->
									<?php //echo $this->facets->show_roden_sidebar_styles_facets($this->set->get_facets('styles', '130', '5', ''), 'styles', 'jumpsuits'); // (facet, subcat, des, filter) ?>
									
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('shop/all')).'?filter=&availability=instock'; ?>" style="color:red;">
										In Stock Items
									</a>
								</li>
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('shop/all')).'?filter=&availability=preorder'; ?>" style="color:red;">
										Pre Order Items
									</a>
								</li>
								
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('designers')); ?>" title="Shop By Designer">
										<strong>Shop By Designer</strong>
									</a>
									<ul>
									
										<?php foreach ($this->designers_ary as $designer): ?>
										
											<?php if ($designer !== 'instylenewyork'): ?>
											
										<li class="navigation-item sub-navigation-item">
											<a href="<?php echo str_replace('https', 'http', site_url($designer)); ?>">
												<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer)); ?>
											</a>
											
												<?php
												/**********
												 * Designer subcats
												 */
												$des_categories = $this->categories->treelist(array('d_url_structure'=>$designer->url_structure));
												?>
												
												<?php if ($des_categories) { ?>
												
											<ul>
											
													<?php foreach($des_categories as $item) { // ---> foreach subcategory ?>

												<li class="navigation-item sub-navigation-item">
													<a href="<?php echo site_url($item->d_url_structure.'/'.$item->category_slug); ?>"><?php echo $item->category_name; ?> </a>
													
												</li>
										
													<?php } ?>
												
											</ul>
											
												<?php } ?>
											
										</li>
										
										<?php endif; endforeach; ?>
										
									</ul>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('wholesale/signin')); ?>" title="Retailer Login">
										Retailer Login
									</a>
								</li>
								
								<li class="navigation-item">
									<a accesskey="7" href="<?php echo str_replace('https', 'http', site_url('events')); ?>" title="Upcoming Events">
										Upcoming Events
									</a>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('press')); ?>" title="Press">
										Press
									</a>
								</li>
								
										<?php if ($this->session->userdata('user_loggedin')): ?>
								
								<li class="navigation-item">
									<a href="<?php echo str_replace('https', 'http', site_url('special_sale')); ?>" title="Special Sale" style="color:red;">
									
											<?php if ($this->session->userdata('user_loggedin')): ?>
										
										<strong>Clearance</strong>
										
											<?php else: ?>
										
										<strong>On Sale</strong>
										
											<?php endif; ?>
										
									</a>
								</li>
								
										<?php endif; ?>
								
									<?php endif; ?>
									
								<li class="nav-item<?php echo $this->uri->uri_string() === 'ordering' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('ordering')); ?>">Ordering </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'shipping' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('shipping')); ?>">Shipping </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'return_policy' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('return_policy')); ?>">Returns </a> 
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
								<li class="nav-item<?php echo $this->uri->uri_string() === 'terms_of_use' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('terms_of_use')); ?>">Terms of Use </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'contact' ? ' active current' : ''; ?>">
									<a href="<?php echo str_replace('https', 'http', site_url('contact')); ?>">Contact </a> 
								</li>
								
							</ul>
							
						</div><!-- #nav-mobile -->

						<?php
						$this->load->view('roden2/template_header_breadcrumb');
						$this->load->view('roden2/template_header_banner_part');
						?>
						
