							<?php
							/**********
							 * Side Nav
							 */
							?>
                            <div id="aside" class="aside  content-grid__navigation" role="complementary">
								<div class="nav">
									<ul class="nav-secondary nav-content">
										<li class="nav-item<?php echo $sc_url_structure === 'bridal_dresses' ? ' active' : ''; echo $this->uri->uri_string() === 'apparel/bridal_dresses' ? ' current' : ''; ?>">
											<a href="<?php echo site_url('apparel/bridal_dresses'); ?>">Wedding Dresses </a>
											
											<!-- Place the resulting style facets here -->
											<?php //if ($sc_url_structure === 'bridal_dresses') echo @$this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $sc_url_structure); ?>
											
										</li>
										<li class="nav-item<?php echo $sc_url_structure === 'bridesmaids_dresses' ? ' active' : ''; echo $this->uri->uri_string() === 'apparel/bridesmaids_dresses' ? ' current' : ''; ?>">
											<a href="<?php echo site_url('apparel/bridesmaids_dresses'); ?>">Bridesmaids </a> 
											
											<!-- Place the resulting style facets here -->
											<?php //if ($sc_url_structure === 'bridesmaids_dresses') echo @$this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $sc_url_structure); ?>
											
										</li>
										<li class="nav-item<?php echo $sc_url_structure === 'maid_of_honor_dresses' ? ' active' : ''; echo $this->uri->uri_string() === 'apparel/maid_of_honor_dresses' ? ' current' : ''; ?>">
											<a href="<?php echo site_url('apparel/maid_of_honor_dresses'); ?>">Maid Of Honor </a> 
											
											<!-- Place the resulting style facets here -->
											<?php //if ($sc_url_structure === 'maid_of_honor_dresses') echo @$this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $sc_url_structure); ?>
											
										</li>
										<li class="nav-item<?php echo $sc_url_structure === 'mother_of_bride_groom_dresses' ? ' active' : ''; echo $this->uri->uri_string() === 'apparel/mother_of_bride_groom_dresses' ? ' current' : ''; ?>">
											<a href="<?php echo site_url('apparel/mother_of_bride_groom_dresses'); ?>">Mother Of The Bride </a> 
											
											<!-- Place the resulting style facets here -->
											<?php //if ($sc_url_structure === 'mother_of_bride_groom_dresses') echo @$this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $sc_url_structure); ?>
											
										</li>
									</ul>
								</div>
                            </div><!-- end ASIDE -->
					
	<?php
	/***************
	 *	COMMENTS:
	 
		as of 20161003, side bar nav facets are removed and put as a drop down filter on the thumbs
		commenting the facets sub nav items temporarily
	 */