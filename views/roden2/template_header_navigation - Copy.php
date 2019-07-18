					<?php
					/**********
					 * HEADER
					 */
					?>
					<div id="header" class="header clearfix" role="banner">
					
						<?php
						/**********
						 * Primary Navigation
						 */
						?>
						<div>
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
							.mega_menu_wrapper {
								max-width: 100%;
								position: relative;
								top: -4px;
								visibility: hidden;
							}
							.mega_menu {
								position: absolute;
								display: block;
								border: 1px solid grey;
								background: white;
								z-index: 2500;
								width: 100%;
								padding: 20px;
							}
							.mega_menu a {
								display: inline-block;
								padding: 8px 15px;
								font-size: 12px;
								text-transform: uppercase;
								color: #666;
							}
							.mega_menu a:hover {
								color: #846921;;
								text-decoration: underline;
							}
							.active.current {
								text-decoration: underline;
								font-weight: bold;
								color: #846921;;
							}
							.col-table {
								display: table-cell;
							}
							.cat_level_1 a {
								padding-left: 30px;
							}
							.cat_level_2 a {
								text-transform: none;
								padding: 5px 15px 5px 45px;
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
									 *
									 * FOR DEPRACATION
									 */
									?>
									<?php if ($this->uri->segment(1) === 'special_sale' AND @$categories): ?>
									
										<?php foreach($categories as $item) { // ---> foreach subcategory ?>
										
											<?php
											/**********
											 * Subcats of all designers for special sale
											 */
											?>
									<li<?php if (
										$this->uri->segment(2) == $item->category_slug OR 
										@$product->sc_folder == $item->sc_url_structure OR
										@$sc_url_structure == $item->sc_url_structure
									) echo ' class="active_11"'; ?>>
										<a href="<?php echo site_url('special_sale/apparel/'.$item->sc_url_structure); ?>"><?php echo $item->category_name?> </a>
									</li>
										
										<?php } ?>
									
									<li>
										<a href="<?php echo site_url('apparel'); ?>">Back To Main Page</a>
									</li>
									
									<?php elseif (@$this->webspace_details->options['site_type'] !== 'hub_site'): ?>
									
									<?php
									/**********
									 * Satellite site nav
									 */
									?>
										<?php foreach($categories as $item) { // ---> foreach subcategory ?>
										
											<?php if ($item->category_id != '1') { // ---> do not show 'apparel' ?>
											
												<?php 
												// --> identify categories linked to designer for satellite sites
												if (
													strpos($item->d_url_structure, $this->webspace_details->slug) !== FALSE // --> avoid catching '0' strpos as false
												) 
												{ 
												?>
										
											<?php
											/**********
											 * Designer specific subcats
											 */
											?>
									<li<?php if (
										$this->uri->segment(2) == $item->category_slug OR 
										@$product->sc_folder == $item->category_slug OR
										@$sc_url_structure == $item->category_slug
									) echo ' class="active_11"'; ?>>
										<a href="<?php echo site_url('shop/apparel/'.$item->category_slug); ?>"><?php echo $item->category_name?> </a>
									</li>
									
												<?php } ?>	
											<?php } ?>
										<?php } ?>
									
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
									
									<li>
										<a href="<?php echo site_url('shop/all').'?filter=&availability=onsale'; ?>" style="color:red;">
										
											<?php if ($this->session->userdata('user_loggedin')): ?>
											
											Clearance
											
											<?php else: ?>
											
											On Sale
											
											<?php endif; ?>
											
										</a>
									</li>
									
									<?php
									/**********
									 * Default site top nav (hub sites)
									 */
									?>
									<?php else: ?>
									
									<?php
									/**********
									 * ALL DESIGNERS
									 */
									?>
									<li class="<?php echo $this->uri->segment(1) === 'designers' ? 'active_11' : ''; ?>">
										<a href="<?php echo site_url('shop/designers'); ?>" onmouseover="showObj('sub-menu-01', this);" onmouseout="closetime();" style="cursor:default;">
											All Designers
										</a>
										
										<ul id="sub-menu-01" onmouseover="cancelclosetime();" onmouseout="closetime();">
										
											<?php foreach ($designers as $designer): ?>
											
												<?php if ($designer->url_structure !== 'instylenewyork' && $designer->with_products == '1'): ?>
												
											<li>
												<a href="<?php echo site_url('shop/designers/'.$designer->url_structure); ?>">
													<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer->designer)); ?>
												</a>
											</li>
											
											<?php endif; endforeach; ?>
											
										</ul>
										
									</li>
									
									<?php
									/**********
									 * WOMENS APPAREL
									 */
									?>
									<li class="<?php echo $this->uri->segment(1) === 'designers' ? 'active_11' : ''; ?>">
										<a href="<?php echo site_url('shop/apparel'); ?>" onmouseover="showObj('sub-menu-02', this);" onmouseout="closetime();" style="cursor:default;">
											Womens Apparel
										</a>
									</li>
									
										<?php
										/**********
										 * Top Nav Based on Browse By Designer 
										 */
										?>
										<?php if (isset($left_nav) && $left_nav === 'sidebar_browse_by_designer_'): ?>
										
											<?php
											/**********
											 * Designer subcats
											 */
											//$des_subcats = $this->query_category->get_subcat_new('apparel', str_replace(array(' ','/'), array('_','.'), $this->uri->segment(1)));
											$des_subcats = $this->categories->treelist(array('d_url_structure'=>$designer->url_structure));
											?>
											<?php foreach($des_subcats->result_array() as $item): // ---> foreach subcategory ?>
											
									<li class="">
										<a href="<?php echo site_url('shop/'.$item['d_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['category_name']; ?> </a>
									</li>
										
											<?php endforeach; ?>
											
										<?php else: ?>
										
										<?php
										/**********
										 * Default Top Nav
										 */
										?>
									<li<?php if ($this->uri->segment(1) === 'designers') echo ' class="active_11"'; ?>>
										<a onmouseover="showObj('sub-menu-dresses', this);" onmouseout="closetime();" style="cursor:default;">
											Dresses
										</a>
										
										<ul id="sub-menu-dresses" onmouseover="cancelclosetime();" onmouseout="closetime();">

											<li<?php if (
												$this->uri->segment(2) == 'evening-dresses' OR 
												@$product->sc_folder == 'evening-dresses' OR
												@$sc_url_structure == 'evening-dresses'
											) echo ' class="active_11"'; ?>>
												<a accesskey="3" href="<?php echo site_url('shop/apparel/evening-dresses'); ?>">
													Evening Dresses
												</a>
											</li>
											<li<?php if (
												$this->uri->segment(2) == 'cocktail-dresses' OR 
												@$product->sc_folder == 'cocktail-dresses' OR
												@$sc_url_structure == 'cocktail-dresses'
											) echo ' class="active_11"'; ?>>
												<a href="<?php echo site_url('shop/apparel/cocktail-dresses'); ?>" accesskey="2">
													Cocktail Dresses
												</a>
											</li>
											<li<?php if (
												$this->uri->segment(2) == 'bridal_dresses' OR 
												@$product->sc_folder == 'bridal_dresses' OR
												@$sc_url_structure == 'bridal_dresses'
											) echo ' class="active_11"'; ?>>
												<a href="<?php echo site_url('shop/apparel/bridal_dresses'); ?>" accesskey="2">
													Wedding Dresses
												</a>
											</li>

										</ul>

									</li>
									
									<li<?php if (
										$this->uri->segment(2) == 'tops' OR 
										@$product->sc_folder == 'tops' OR
										@$sc_url_structure == 'tops'
									) echo ' class="active_11"'; ?>>
										<a accesskey="4" href="<?php echo site_url('shop/apparel/tops'); ?>">
											Tops
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
												<a accesskey="5" href="<?php echo site_url('shop/apparel/skirts'); ?>">
													Skirts
												</a>
											</li>
											<li<?php if (
												@$this->uri->segment(2) == 'shorts' OR 
												@$product->sc_folder == 'shorts' OR
												@$sc_url_structure == 'shorts'
											) echo ' class="active_11"'; ?>>
												<a accesskey="5" href="<?php echo site_url('shop/apparel/shorts'); ?>">
													Shorts
												</a>
											</li>
											<li<?php if (
												$this->uri->segment(2) == 'pants' OR 
												@$product->sc_folder == 'pants' OR
												@$sc_url_structure == 'pants'
											) echo ' class="active_11"'; ?>>
												<a accesskey="5" href="<?php echo site_url('shop/apparel/pants'); ?>">
													Pants
												</a>
											</li>

										</ul>

									</li>
									
									<li<?php if (
										$this->uri->segment(2) == 'jumpsuits' OR 
										@$product->sc_folder == 'jumpsuits' OR
										@$sc_url_structure == 'jumpsuits'
									) echo ' class="active_11"'; ?>>
										<a accesskey="5" href="<?php echo site_url('shop/apparel/jumpsuits'); ?>">
											Jumpsuits
										</a>
									</li>
								
										<?php endif; ?>
										
										<?php //if ( ! $this->session->userdata('user_loggedin') OR $this->session->userdata('user_cat') != 'wholesale'): ?>
										
									<!--
									<li<?php if ($this->uri->uri_string() == 'made_to_order') echo ' class="active_1"'; ?>>
										<a accesskey="7" href="<?php echo site_url('made_to_order'); ?>">
											Made To Order
										</a>
									</li>
									-->
									
										<?php //endif; ?>
									
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
									
									<li>
										<a href="<?php echo site_url('shop/all').'?filter=&availability=onsale'; ?>" style="color:red;" onmouseover="showObj_('sub-menu-sale', this);" onmouseout="closetime();" style="cursor:default;">
										
											SPECIAL SALE
										
											<?php 
											/*
											 *
											if ($this->session->userdata('user_loggedin'))
											{
												echo 'Clearance';
											}
											else
											{
												echo 'On Sale';
												
											}
											// */
											?>
											
										</a>
										
										<ul id="sub-menu-sale" class="pan-right" onmouseover="cancelclosetime();" onmouseout="closetime();">
										
											<li>
												<a href="<?php echo site_url('special_sale/apparel/evening-dresses'); ?>">Evening Dresses </a>
											</li>
											<li>
												<a href="<?php echo site_url('special_sale/apparel/cocktail-dresses'); ?>">Cocktail Dresses </a>
											</li>
											
										</ul>
										
									</li>
									
									<?php endif;?>
									
									<!--
									<li<?php if ($this->uri->uri_string() == 'contact') echo ' class="active_11"'; ?>>
										<a accesskey="7" href="<?php echo site_url('contact'); ?>">
											Contact
										</a>
									</li>
									-->
								</ul>
								
								<div class="nav-primary-dropdown" style="width">
									This is a drop down nav
								</div>
								
							</nav><!-- #nav-primary -->

							<div class="mega_menu_wrapper">
								<div id="sub-menu-02" class="mega_menu" onmouseover="cancelclosetime();" onmouseout="closetime();">
								
									<?php
									/**********
									 * Dynamic header mega menu navigatioin
									 */
									?>
									<?php if ($categories) 
									{
										// let's grabe the url string segments to check for categories
										// during iterations
										$url_seg = explode('/', $this->uri->uri_string());
										
										$cat_level_1 = 'close';
										foreach ($categories as $item) // ---> start category tree
										{
											//echo $item->category_slug.' ('.$item->category_level.')<br />';
											
											// set url segments by category level.
											// if the same level, overwrite segment
											// if greater level, just add index
											$link_seg[$item->category_level] = $item->category_slug;
											
											// set class 'active current' accordingly
											$active_current = 
												in_array($item->category_slug, $url_seg) 
												? 'active current'
												: ''
											;
											// set category level 'cat_level_#' class accordingly
											$cat_level =  
												$item->category_level > 1 
												? 'cat_level_2'
												: ($item->category_level > 0 ? 'cat_level_1 col-table' : 'cat_level_0') 
											;
											
											// do an iteration to unset the link segment for next upper level category
											if (@$prev_level)
											{
												for ($deep = $prev_level - $item->category_level; $deep > 0; $deep--)
												{
													unset($link_seg[$deep + 1]);
												}
											} 
											
											// let's do top level category
											if ($item->category_level == 0)
											{
												?>
									<div class="<?php echo $cat_level; ?>">
										<a href="<?php echo site_url('shop/'.implode('/',$link_seg)); ?>" class="<?php echo $active_current; ?>">
											<?php echo $item->category_name; ?>
										</a>
									</div>
												<?php 
											}
											
											// closing category level 1 ul and div
											// to ensure that only previous set category level 1 ul and div are closed,
											// we use a less than '<' condition to set it allowing the next 
											// category level 1 to start over again.
											if ($item->category_level == 1 && $cat_level_1 == 'open')
											{
												?>
										</ul>
									</div>
												<?php
												$cat_level_1 = 'close';
											}
											
											// let's do level 1 category
											if ($item->category_level == 1)
											{
												?>
									<div class="<?php echo $cat_level; ?>" style="width:200px;">
										<a href="<?php echo site_url('shop/'.implode('/',$link_seg)); ?>" class="<?php echo $active_current; ?>">
											<?php echo $item->category_name; ?>
										</a>
										<ul class="cat_level_2">
												<?php 
												$cat_level_1 = 'open';
											}
											
											// level 2 category
											if ($item->category_level >= 2)
											{
												?>
											<li>
												<a href="<?php echo site_url('shop/'.implode('/',$link_seg)); ?>" class="<?php echo $active_current; ?>">
													<?php echo $item->category_name; ?>
												</a>
											</li>
												<?php
											}
											
											$prev_level = $item->category_level;
										}
										
										unset($link_seg);
										unset($url_seg);
									} ?>
									
								</div>
							</div>
							
						</div>
						<!-- END Primary Navigation -->
						
						<?php
						/**********
						 * Mobile Navigation
						 */
						?>
						<div id="nav-mobile" class="nav-mobile">
							<div class="mobile-nav-top">
							
									<a href="<?php echo site_url('shop/categories'); ?>" title="Shop By Category">
										<strong>Shop By Category</strong>
									</a>

								<a class="icon icon--close fa fa-times" href="#wl-page-wrap" data-nav-close='' > <span class="visually-hidden">Close</span></a>
								
							</div>
							<ul>
								
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/apparel'); ?>" title="">
										<strong>Womens Apparel</strong>
									</a>
									<ul>
									
										<?php foreach ($designers as $designer): ?>
										
											<?php if ($designer->url_structure !== 'instylenewyork' && $designer->with_products == '1'): ?>
											
										<li class="navigation-item sub-navigation-item">
											<a href="<?php echo site_url('shop/designers/'.$designer->url_structure); ?>">
												<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer->designer)); ?>
											</a>
											
												<?php
												/**********
												 * Designer subcats
												 */
												$des_categories = $this->categories_tree->treelist(array('d_url_structure'=>$designer->url_structure));
												?>
												
												<?php if ($des_categories) { ?>
												
											<ul>
											
													<?php foreach($des_categories as $item) { // ---> foreach subcategory ?>

												<li class="navigation-item sub-navigation-item">
													<a href="<?php echo site_url('shop/'.$designer->url_structure.'/'.$item->category_slug); ?>"><?php echo $item->category_name; ?> </a>
													
												</li>
										
													<?php } ?>
												
											</ul>
											
												<?php } ?>
											
										</li>
										
										<?php endif; endforeach; ?>
										
									</ul>
								</li>
																
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
									<a href="<?php echo site_url('shop/categories'); ?>" title="Regular Items">
										<strong>Back To Main Page</strong>
									</a>
								</li>
									
									<?php elseif (@$this->webspace_details->options['site_type'] !== 'hub_site'): ?>
								
								<?php
								/**********
								 * Satellite site nav
								 */
								?>
										<?php
										/**********
										 * Designer subcats
										 */
										$des_categories = $this->categories_tree->treelist(array('d_url_structure'=>$this->webspace_details->slug));
										?>
										
										<?php if ($des_categories) { ?>
										
											<?php foreach($des_categories as $item) { // ---> foreach subcategory ?>
											
												<?php if ($item->category_id != '1') { ?>
											
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/apparel/'.$item->category_slug); ?>" title="<?php echo $item->category_name; ?>">
										<?php echo $item->category_name; ?> 
									</a>
								</li>
								
												<?php } ?>
								
											<?php } ?>
											
										<?php } ?>
										
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/all').'?filter=&availability=onsale'; ?>" style="color:red;">
										SPECIAL SALE
									</a>
								</li>
								
									<?php else: ?>
									
										<?php foreach ($categories as $category) { ?>
										
											<?php if ($category->category_id != '1') { ?>
										
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/apparel/'.$category->category_slug); ?>" title="<?php echo $category->category_name; ?>">
										<?php echo $category->category_name; ?>
									</a>
								</li>
								
											<?php } ?>
										<?php } ?>
								
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
									<a href="<?php echo site_url('shop/all').'?filter=&availability=onsale'; ?>" style="color:red;">
										SPECIAL SALE
									</a>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo site_url('shop/designers'); ?>" title="Shop By Designer">
										<strong>Shop By Designer</strong>
									</a>
									<ul>
									
										<?php foreach ($designers as $designer): ?>
										
											<?php if ($designer->url_structure !== 'instylenewyork' && $designer->with_products == '1'): ?>
											
										<li class="navigation-item sub-navigation-item">
											<a href="<?php echo site_url('shop/designers/'.$designer->url_structure); ?>">
												<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer->designer)); ?>
											</a>
											
												<?php
												/**********
												 * Designer subcats
												 */
												$des_categories = $this->categories_tree->treelist(array('d_url_structure'=>$designer->url_structure));
												?>
												
												<?php if ($des_categories) { ?>
												
											<ul>
											
													<?php foreach($des_categories as $item) { // ---> foreach subcategory ?>

												<li class="navigation-item sub-navigation-item">
													<a href="<?php echo site_url('shop/'.$designer->url_structure.'/'.$item->category_slug); ?>"><?php echo $item->category_name; ?> </a>
													
												</li>
										
													<?php } ?>
												
											</ul>
											
												<?php } ?>
											
										</li>
										
										<?php endif; endforeach; ?>
										
									</ul>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo site_url('wholesale/signin'); ?>" title="Retailer Login">
										Retailer Login
									</a>
								</li>
								
								<li class="navigation-item">
									<a accesskey="7" href="<?php echo site_url('events'); ?>" title="Upcoming Events">
										Upcoming Events
									</a>
								</li>
								
								<li class="navigation-item">
									<a href="<?php echo site_url('press'); ?>" title="Press">
										Press
									</a>
								</li>
								
										<?php if ($this->session->userdata('user_loggedin')): ?>
								
								<li class="navigation-item">
									<a href="<?php echo site_url('special_sale'); ?>" title="Special Sale" style="color:red;">
									
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
									<a href="<?php echo site_url('ordering'); ?>">Ordering </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'shipping' ? ' active current' : ''; ?>">
									<a href="<?php echo site_url('shipping'); ?>">Shipping </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'return_policy' ? ' active current' : ''; ?>">
									<a href="<?php echo site_url('return_policy'); ?>">Returns </a> 
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
								<li class="nav-item<?php echo $this->uri->uri_string() === 'terms_of_use' ? ' active current' : ''; ?>">
									<a href="<?php echo site_url('terms_of_use'); ?>">Terms of Use </a> 
								</li>
								<li class="nav-item<?php echo $this->uri->uri_string() === 'contact' ? ' active current' : ''; ?>">
									<a href="<?php echo site_url('contact'); ?>">Contact </a> 
								</li>
								
							</ul>
							
						</div><!-- #nav-mobile -->
						<!-- END Mobile Navigation -->

						<?php
						$this->load->view('roden2/template_header_breadcrumb');
						$this->load->view('roden2/template_header_banner_part');
						?>
						
