							<?php
							/**********
							 * Side Nav
							 */
							?>
                            <div id="aside" class="aside  content-grid__navigation" role="complementary">
								<div class="nav">
									<ul class="nav-secondary nav-content">
									
										<?php
										/**********
										 * Dynamic sidebar navigatioin
										 */
										?>
										<?php if (@$left_nav_sql->num_rows() > 0): ?>
										
										<?php
										/**********
										 * Browse by Category
										 */
										?>
										<li class="nav-item header-nav-item <?php echo $left_nav === 'sidebar_browse_by_category' ? 'active current' : ''; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'sa/apparel'); ?>" title="Shop By Category" style="cursor:pointer;"><strong>SELECT CATEGORY</strong></a>
											<a class="mm-next <?php echo $left_nav === 'sidebar_browse_by_category' ? 'nav-collapse' : ''; ?>" href="javascript:void(0);" data-target="#mm-1" style="height: 47px;" onclick="$(this).toggleClass('nav-collapse');$('.category-nav-item').toggle();"></a>
										</li>
										
											<?php foreach($left_nav_sql->result_array() as $item): // ---> foreach subcategory ?>
										
											<?php
											/**********
											 * Subcats of all designers
											 */
											?>
										<li class="nav-item main-nav-item category-nav-item<?php echo (($this->uri->segment(1) == 'apparel' OR $this->uri->segment(1) === 'special_sale') AND $item['sc_url_structure'] === $sc_url_structure) ? ' active current' : ''; ?> <?php echo $left_nav === 'sidebar_browse_by_category' ? '': 'hidden'; ?>">
											<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'sa/'.$item['c_url_structure'].'/'.$item['sc_url_structure']); ?>"><?php echo $item['subcat_name']?> </a>
											
												<?php
												/**********
												 * Facets
												 */
												?>
											<!-- Place the resulting style facets here -->
											<?php //if ($item['sc_url_structure'] === $sc_url_structure) echo $this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $item['sc_url_structure'], $item['c_url_structure']); ?>
											
										</li>
										
											<?php endforeach; ?>
										
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