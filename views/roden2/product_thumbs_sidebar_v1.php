							<?php
							/**********
							 * Side Nav
							 */
							?>
                            <div id="aside" class="aside  content-grid__navigation" role="complementary">
								<div class="nav">
									<ul class="nav-secondary nav-content">
									
										<li class="nav-item <?php echo ($this->uri->uri_string() != '' && strpos('shop/all', $this->uri->uri_string()) !== FALSE) ? 'active current' : ''; ?>">
											<a href="<?php echo site_url('shop/all'); ?>">All Products</a>
										</li>
										
										<?php
										/**********
										 * Dynamic sidebar navigatioin
										 */
										?>
										<?php if ($categories) 
										{ 
											// let's grabe the url string segments to check for categories
											// during iterations
											$link_seg = explode('/', $this->uri->uri_string());
											?>
										
											<?php
											/**********
											 * Browse by Category
											 * Category Tree is provided by controller. Just show it here.
											 * Controller should take care of checking for hub or satellite site configs
											 */
											?>
										<!-- MAIN top tier button -->
										<li class="nav-item header-nav-item <?php echo $left_nav === 'sidebar_browse_by_category' ? 'active current' : ''; ?>">
											<a href="<?php echo site_url('shop/categories'); ?>" title="Shop By Category" style="cursor:pointer;"><strong>SHOP BY CATEGORY</strong></a>
											<a class="mm-next <?php echo $left_nav === 'sidebar_browse_by_category' ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="
												$(this).toggleClass('nav-collapse');
												$('.header_category_item').toggle();
												$('.main_category_item').toggle();
												$('.sub_category_item.open.shown').toggle();
											"></a>
										</li>
										
											<?php 
											$url_seg = array();
											$rw = 0;
											foreach ($categories as $item) // ---> start category tree
											{ 
												// set url segments by category level.
												// if the same level, overwrite segment
												// if greater level, just add index
												$url_seg[$item->category_level] = $item->category_slug;
												
												// hidden on respective browse by
												$hide_on_browse_by = 
													$left_nav === 'sidebar_browse_by_category' 
													? ''
													: 'hidden'
												;
												
												// set class 'active current' accordingly
												$active_current = 
													($left_nav === 'sidebar_browse_by_category' && in_array($item->category_slug, $link_seg)) 
													? 'active current'
													: ''
												;
												// set class 'nav-collapse' accordingly
												$nav_collapse = 
													($left_nav === 'sidebar_browse_by_category' OR in_array($item->category_slug, $link_seg)) 
													? 'nav-collapse'
													: ''
												;
												// set class 'open shown' or 'close hidden' accordingly
												$open_show = 
													($left_nav === 'sidebar_browse_by_category' OR in_array($item->category_slug, $link_seg)) 
													? 'open shown'
													: 'close hidden'
												;
												
												// has children?
												$has_children = $item->with_children > 0 ? TRUE : FALSE;
												
												// <li>' classes
												// set class 'header', 'main' or 'sub' nav item accordingly
												$main_sub_nav_item = 
													($item->category_level > 1) 
													? 'sub-navigation-item sub_category_item '.$open_show
													: ($item->category_level > 0 ? 'main-nav-item main_category_item' : 'header-nav-item header_category_item') 
												;
												$class_name = 'category_nav_item_'.$item->category_level;
												// class indentifyer to toggle on click of '+/-' sign
												$children_identifyer = 
													$item->category_id != $item->parent_category 
													? 'category_has_parent_'.$item->parent_category 
													: ''
												;
												// class child indentifyer selector
												$cat_children = 'category_has_parent_'.$item->category_id;
												
												// next lower level category (only do this once $prev_level is already set)
												// NOTE: lower level is not necessarily just by 1 level difference
												// can be as deep as the max category level
												if (@$prev_level)
												{
													for ($deep = $prev_level - $item->category_level; $deep > 0; $deep--)
													{
														unset($url_seg[$deep + 1]);
													}
												} ?>
												
										<li class="nav-item <?php echo $main_sub_nav_item.' '.$class_name.' '.$children_identifyer; ?> <?php echo $active_current.' '.$hide_on_browse_by; ?>">
										
											<a href="<?php echo site_url('shop/'.implode('/',$url_seg)); ?>">
												<?php echo $item->category_name?> 
											</a>
											
											<?php if ($has_children) 
											{ ?>
											<a class="mm-next mm_next_item_<?php echo $item->category_level; ?> <?php echo $nav_collapse; ?>" href="javascript:void(0);" data-target="#mm_<?php echo ($item->category_level + 1); ?>" style="height: 47px;" onclick="
												$(this).toggleClass('nav-collapse');
												$('.<?php echo $cat_children; ?>').toggle();
												$('.<?php echo $cat_children; ?>').toggleClass('open');
												$('.<?php echo $cat_children; ?>').toggleClass('shown');
												<?php echo $item->category_level == 0 ? "$('.sub_category_item.open.shown').toggle();" : ''; ?>
											"></a>
												<?php
											} ?>
										</li>
												<?php
												// save as category level as previous levl
												$prev_level = $item->category_level;
											}

											unset($url_seg);
											?>
										
											<?php
											/**********
											 * SPECIAL SALE menu item
											 */
											?>
										<li class="nav-item main-nav-item category-nav-item <?php echo ($this->uri->uri_string() == site_url('shop/all').'?filter=&availability=onsale') ? 'active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_category' ? '': 'hidden'; ?>">
											<a href="<?php echo site_url('shop/all'); ?>?filter=&availability=onsale"> <span style="color:red;">SPECIAL SALE</span> </a>
										</li>
										
											<?php if (@$this->webspace_details->options['site_type'] == 'hub_site') 
											{ ?>
										
											<?php
											/**********
											 * Browse by Designer
											 * While Designer List Tree is provided by controller, we will need to
											 * get the designer category tree here as we iterate through designers
											 */
											?>
										<!-- MAIN top tier button -->
										<li class="nav-item header-nav-item <?php echo $left_nav === 'sidebar_browse_by_designer' ? 'active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/designers'); ?>" title="Shop By Designer" style="cursor:pointer;"><strong>SHOP BY DESIGNER</strong></a>
											<a class="mm-next <?php echo $left_nav === 'sidebar_browse_by_designer' ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="
												$(this).toggleClass('nav-collapse');
												$('.designer-nav-item').toggle();
												$('.designer-category-nav-item.open.shown').toggle();
											"></a>
										</li>
										
												<?php foreach ($designers as $designer) 
												{ 
													if (
														// this is for backwards compatibility, for depracation
														$designer->url_structure !== 'instylenewyork'
														// we need this filter as $designer is global at Frontend_Controller
														// getting entire list
														&& $designer->with_products != '0' 
													)
													{ ?>
												
														<?php
														/**********
														 * Designers
														 */
														?>
										<li class="nav-item header-nav-item designer-nav-item <?php echo $this->uri->segment(3) == $designer->url_structure ? ' active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_designer' ? '': 'hidden'; ?>">
											<a href="<?php echo str_replace('https', 'http', site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shop/designers/'.$designer->url_structure)); ?>">
												<?php echo ucwords(str_replace(array('_','-'), array(' ',' '), $designer->designer)); ?>
											</a>
											<a class="mm-next <?php echo $this->uri->segment(3) == $designer->url_structure ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="
												$(this).toggleClass('nav-collapse');
												$('.designer_<?php echo $designer->url_structure; ?>_nav_item_0').toggle();
												$('.designer_<?php echo $designer->url_structure; ?>_nav_item_0').toggleClass('open');
												$('.designer_<?php echo $designer->url_structure; ?>_nav_item_0').toggleClass('shown');
												<?php echo $item->category_level == 0 ? "$('.designer_sub_category_item.open.shown').toggle();" : ''; ?>
											"></a>
										</li>
										
														<?php
														/**********
														 * Designer subcats
														 */
														?>
														<?php 
														// get designer subcats
														$des_subcats = $this->categories_tree->treelist(
															array(
																'd_url_structure'=>$designer->url_structure,
																'with_products'=>TRUE
															)
														);
														
														foreach($des_subcats as $item) 
														{ 
															// set url segments by category level.
															// if the same level, overwrite segment
															// if greater level, just add index
															$url_seg[$item->category_level] = $item->category_slug;
															
															// hidden on respective browse by
															$hide_on_browse_by = 'hidden';
															
															// set class 'active current' accordingly
															$active_current = 
																($left_nav === 'sidebar_browse_by_designer' && in_array($item->category_slug, $link_seg)) 
																? 'active current'
																: ''
															;
															// set class 'nav-collapse' accordingly
															$nav_collapse = 
																($left_nav === 'sidebar_browse_by_designer' OR in_array($item->category_slug, $link_seg)) 
																? 'nav-collapse'
																: ''
															;
															// set class 'open shown' or 'close hidden' accordingly
															$open_show = 
																($left_nav === 'sidebar_browse_by_designer' OR in_array($item->category_slug, $link_seg)) 
																? 'close hidden'//'open shown'
																: 'close hidden'
															;
															
															// has children?
															$has_children = $item->with_children > 0 ? TRUE : FALSE;
															
															// <li>' classes
															// set class 'header', 'main' or 'sub' nav item accordingly
															$main_sub_nav_item = 
																($item->category_level > 1) 
																? 'sub-navigation-item designer_sub_category_item designer_'.$designer->url_structure.'_sub_category_item '.$open_show
																: ($item->category_level > 0 ? 'main-nav-item designer_main_category_item' : 'header-nav-item designer_header_category_item') 
															;
															$class_name = 'designer-category-nav-item designer_'.$designer->url_structure.'_nav_item_'.$item->category_level;
															// class indentifyer to toggle on click of '+/-' sign
															$children_identifyer = 
																$item->category_id != $item->parent_category 
																? 'designer_'.$designer->url_structure.'_category_has_parent_'.$item->parent_category 
																: ''
															;
															// class child indentifyer selector
															$cat_children = 'designer_'.$designer->url_structure.'_category_has_parent_'.$item->category_id;
															
															// next lower level category (only do this once $prev_level is already set)
															// NOTE: lower level is not necessarily just by 1 level difference
															// can be as deep as the max category level
															if (@$prev_level)
															{
																for ($deep = $prev_level - $item->category_level; $deep > 0; $deep--)
																{
																	unset($url_seg[$deep + 1]);
																}
															} ?>
													
												<li class="nav-item <?php echo $main_sub_nav_item.' '.$class_name.' '.$children_identifyer; ?> <?php echo $active_current.' '.$hide_on_browse_by; ?>">
												
													<a href="<?php echo site_url('shop/'.$designer->url_structure.'/'.implode('/',$url_seg)); ?>">
														<?php echo $item->category_name?> 
													</a>
													
													<?php if ($has_children) 
													{ ?>
													<a class="mm-next mmd_next_item_<?php echo $item->category_level; ?> <?php echo $nav_collapse; ?>" href="javascript:void(0);" data-target="#mm_<?php echo ($item->category_level + 1); ?>" style="height: 47px;" onclick="
														$(this).toggleClass('nav-collapse');
														$('.<?php echo $cat_children; ?>').toggle();
														$('.<?php echo $cat_children; ?>').toggleClass('open');
														$('.<?php echo $cat_children; ?>').toggleClass('shown');
														<?php echo $item->category_level == 0 ? "$('.designer_".$designer->url_structure."_sub_category_item.open.shown').toggle();" : ''; ?>
													"></a>
														<?php
													} ?>
												</li>
															<?php 
															// save as category level as previous levl
															$prev_level = $item->category_level;
														}

														unset($url_seg); ?>
											
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
