							<?php
							/**********
							 * Side Nav
							 */
							?>
                            <div id="aside" class="aside  content-grid__navigation" role="complementary">
								<div class="nav">
									<ul class="nav-secondary nav-content">
										<li class="nav-item<?php echo $sc_url_structure === 'evening_prom_dresses' ? ' active' : ''; echo $this->uri->uri_string() === 'apparel/evening_prom_dresses' ? ' current' : ''; ?>">
											<a href="<?php echo site_url('apparel/evening_prom_dresses'); ?>">Evening Prom Dresses </a>
											
											<!-- Place the resulting style facets here -->
											<?php if ($sc_url_structure === 'evening_prom_dresses') echo @$this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $sc_url_structure); ?>
											
										</li>
										<li class="nav-item<?php echo $sc_url_structure === 'cocktail_prom_dresses' ? ' active' : ''; echo $this->uri->uri_string() === 'apparel/cocktail_prom_dresses' ? ' current' : ''; ?>">
											<a href="<?php echo site_url('apparel/cocktail_prom_dresses'); ?>">Cocktail Prom Dresse </a> 
											
											<!-- Place the resulting style facets here -->
											<?php if ($sc_url_structure === 'cocktail_prom_dresses') echo @$this->facets->show_roden_sidebar_styles_facets($qry_style_facet, $facet_field_name_style, $sc_url_structure); ?>
											
										</li>
									</ul>
								</div>
                            </div><!-- end ASIDE -->
							