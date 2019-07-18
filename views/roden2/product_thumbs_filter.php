											<?php
											/**********
											 * Right side page view all or pagination
											 * - Using only pagination as per UIX experts says
											 */
											?>
											<div class="v-product-browsepagenavigation browse-controls clearfix">
												<div class="all"><!-- revmoving class 'viewall' -->
												
													<?php
													/**********
													 * Implementing CI inherent pagination with edits on config
													 * params on controller class function _include_pagination().
													 
													 * Following the <ul class="pagination hidden"> below for tags
													 * on the config section of the function
													 
													 * Hiding other html tags here so devs can see them for
													 * reference purposes
													 
													 * With additional custom styles
													 */
													switch ($this->webspace_details->slug)
													{
														case 'basix-black-label':
														case 'basixblacklabel':
														case 'basixbridal':
														case 'basixprom':
														case 'junnieleigh':
														case 'chaarmfurs':
														case 'instylenewyork':
														case 'issuenewyork':
														case 'issueny':
														case 'issueny':
														case 'andrewoutfitter':
														case 'storybookknits':
														case 'shop7thavenue':
														case 'salesuser':
															$li_bg_color = '#846921';	// --> goldish
														break;
														
														case 'tempoparis':
															$li_bg_color = '#a7a7a7';	// --> lightgray
														break;
														
														default:
															$li_bg_color = '#e0b2aa';	// --> pink (roden original)
													}
													?>
													<style>
													.pagination li.pages:hover {
														background-color: <?php echo $li_bg_color; ?>;
														color: white;
													}
													.pagination li.pages a:hover {
														color: white;
													}
													.browse-sort__dropdown {
														font-size: 14px;
													}
													.browse-sort__select {
														padding: 0 16px 0 8px;
														font-size: 14px;
													}
													.pagination .txt, .pagination a {
														font-size: 14px;
													}
													.pagination .prev, .pagination .next {
														width: auto;
														height: auto;
													}
													</style>
													
													<?php if ($view_pane !== 'thumbs_list_sales_pacakge') echo $this->pagination->create_links(); ?>
													
													

													<?php //if ( ! isset($_GET['showAll']) OR $_GET['showAll'] == '1'): ?>
													
													<a class="link-italic hidden link-italic--med" href="?page=1&amp;showAll=0" title="View products by page">
														View by Pages
													</a>
													
													<?php //else: ?>
													
													<a class="link-italic hidden link-italic--med" href="?showAll=1" title="View All Products">
														View All
													</a>
													
													<!-- pagination -->
													<ul class="pagination hidden">
														<?php
														/**********
														 * Hide li.prev on page 1
														 * an add goto page 2 and page 3 after li.current
														 */
														?>
														<li class="prev">
															<a href="?page=1" title="Go to Previous Page: 1">
																<span class="visually-hidden">Previous</span>
																<span class="prev-arrow"></span>
															</a>
														</li>
														
														<li>
															<span class="ico"></span>
															<a href="page=1" title="Go to Page: 1">1</a>
														</li>
														<li class="current">
															<span class="ico"></span>
															<span class="txt">2</span>
														</li>
														<li>
															<span class="ico"></span>
															<a href="?page=3" title="Go to Page: 3">3</a>
														</li>
														
														<li class="count">
															<span class="label">of</span>
															<a class="total" href="?page=5">5</a>
														</li>
														
														<li class="next">
															<a href="?page=2" title="Go to Next Page: 2">
																<span class="visually-hidden">Next</span>
																<span class="next-arrow"></span>
															</a>
														</li>
													</ul>
													
													<?php //endif; ?>
													
												</div>
											</div>
											
											<?php
											/**********
											 * Left side sort by price filter=&sortType=priceAsc
											 */
											?>
											<div class="v-product-browsepagedisplaypreferenceform clearfix">
											
												<?php
												/**********
												 * This FORM action is empty and method is GET and select tag has a class form-submit
												 * which when changed value, the form is submitted as per site.js line# 1621.
												 * Below is the original sort filter select of source site. Somehow, the Apply button
												 * is no longer needed. Leaving this form copy here for reference but is 'hidden'.
												 * Succeeding forms within this div are as per requirements. Just need to change the 
												 * select name attribute per filter and respective value that will be used during the
												 * GET process
												 */
												?>
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort hidden">
		
													<input type="hidden" name="filter" value="" />
													
													<div class="browse-sort__dropdown">
														<label for="vProduct-browsePageDisplayPreferenceForm-sortType-1" class="browse-sort__label">Sort By</label>
														<select id="vProduct-browsePageDisplayPreferenceForm-sortType-1" name="sortType" class="form-submit  browse-sort__select">
															<option value="">
																Sort By
															</option>
															<option value="priceAsc">
																Price: Low - High
															</option>
															<option value="priceDesc">
																Price: High - Low
															</option>
														</select>
													</div>
		
													<?php
													/**********
													 * At change of select, adds a query string "?filter=&sortType=priceAsc" for example
													 */
													?>
													<div class="actionlist clearfix" id="vProduct-browsePageDisplayPreferenceForm-actionList-1">
														<ul class="actions clearfix">
															<li class="action-primary action clearfix"> 
																<input type="submit" class="button button--small" value="Apply" />
															</li> 
														</ul>
													</div>
												</form>
												
												

												<span class="link-italic link-italic--med hidden" style="margin-left:10px;text-decoration:none;">Filter by:</span><!-- hidden -->
												
												<?php
												/**********
												 * DESIGNER
												 * this applicable for the hub sites like instyle
												 
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort hidden">
		
													<input type="hidden" name="filter" value="" />

													<div class="browse-sort__dropdown">
														<select id="vProduct-browsePageDisplayPreferenceForm-designer-1" name="designer" class="form-submit  browse-sort__select" style="min-width:100px;">
															<option value="">
																Designer
															</option>
															<option value="basixblacklabel">
																Basix Black Label
															</option>
															<option value="basixbridal">
																Basix Bridal
															</option>
															<option value="all">
																All
															</option>
														</select>
													</div>
		
												</form>
												 */
												?>

												<?php
												/**********
												 * SIZE
												 */
												// get the size facets in array
												if ($this->uri->segment(1) === 'special_sale')
												{
													$size_array = $this->facets->extract_facets($qry_size_facet, $facet_field_name_size);
												}
												else
												{
													$size_array = extract_facets($this->facets->get('size'), 'size');
												}
												
												if ($size_array AND count($size_array) > 0):
												?>
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort">
		
													<input type="hidden" name="filter" value="" />
													<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
													<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
													<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
													<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
													<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
													<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
													<?php endif; ?>

													<?php if (@$_GET['size'] != '' && @$_GET['size'] != 'all') { ?>
													<style>#filter-size::after {border-top: 4px solid white;}
													</style>
													<?php } ?>
													
													<div id="filter-size" class="browse-sort__dropdown" <?php echo (@$_GET['size'] != '' && @$_GET['size'] != 'all') ? 'style="background-color:#846921;"' : ''; ?>>
														<select id="vProduct-browsePageDisplayPreferenceForm-size-1" name="size" class="form-submit  browse-sort__select" style="min-width:100px;<?php echo (@$_GET['size'] != '' && @$_GET['size'] != 'all') ? 'color:white;' : ''; ?>">
															<option value="">
																Size
															</option>
															
															<?php foreach($size_array as $size): ?>
															
																<?php
																//set the selected if filtered
																if (@$_GET['size'] == $size)
																{
																	$selected = 'selected';
																}
																else $selected = '';
																?>
															
															<option value="<?php echo $size; ?>" <?php echo $selected; ?>>
																<?php echo $size; ?>
															</option>
															
															<?php endforeach; ?>
															
															<option value="all">
																All
															</option>
														</select>
													</div>
		
												</form>
												<?php endif; ?>

												<?php
												/**********
												 * COLOR
												 */
												// get the color facets in array
												if ($this->uri->segment(1) === 'special_sale')
												{
													$color_array = $this->facets->extract_facets($qry_color_facet, $facet_field_name_color);
												}
												else
												{
													$color_array = extract_facets($this->facets->get('color_facets'), 'color_facets');
												}
												
												if ($color_array AND count($color_array) > 0):
												?>
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort">
		
													<input type="hidden" name="filter" value="" />
													<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
													<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
													<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
													<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
													<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
													<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
													<?php endif; ?>
													
													<?php if (@$_GET['color'] != '' && @$_GET['color'] != 'all') { ?>
													<style>#filter-color::after {border-top: 4px solid white;}
													</style>
													<?php } ?>
													
													<div id="filter-color" class="browse-sort__dropdown" <?php echo (@$_GET['color'] != '' && @$_GET['color'] != 'all') ? 'style="background-color:#846921;"' : ''; ?>>
														<select id="vProduct-browsePageDisplayPreferenceForm-color-1" name="color" class="form-submit  browse-sort__select" style="min-width:100px;<?php echo (@$_GET['color'] != '' && @$_GET['color'] != 'all') ? 'color:white;' : ''; ?>">
															<option value="">
																Color
															</option>
															
															<?php foreach($color_array as $color): ?>
															
																<?php
																//set the selected if filtered
																if (@$_GET['color'] == $color)
																{
																	$selected = 'selected';
																}
																else $selected = '';
																?>
															
															<option value="<?php echo $color; ?>" <?php echo $selected; ?>>
																<?php echo $color; ?>
															</option>
															
															<?php endforeach; ?>
															
															<option value="all">
																All
															</option>
														</select>
													</div>
		
												</form>
												<?php endif; ?>

												<?php
												/**********
												 * OCCASION (this is the same as previous facet EVENTS)
												 * SEASONS (used by tempo)
												 * this applicable for the hub sites like instyle
												 */
												// get the color facets in array
												if ($this->uri->segment(1) === 'special_sale')
												{
													$occasion_array = $this->facets->extract_facets($qry_event_facet, $facet_field_name_event);
												}
												else
												{
													$occasion_array = extract_facets($this->facets->get('events'), 'events');
												}
												
												if ($occasion_array AND count($occasion_array) > 0):
												?>
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort">
		
													<input type="hidden" name="filter" value="" />
													<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
													<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
													<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
													<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
													<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
													<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
													<?php endif; ?>
													
													<?php if (@$_GET['occasion'] != '' && @$_GET['occasion'] != 'all') { ?>
													<style>#filter-occasion::after {border-top: 4px solid white;}
													</style>
													<?php } ?>
													
													<div id="filter-occasion" class="browse-sort__dropdown" <?php echo (@$_GET['occasion'] != '' && @$_GET['occasion'] != 'all') ? 'style="background-color:#846921;"' : ''; ?>>
														<select id="vProduct-browsePageDisplayPreferenceForm-occasion-1" name="occasion" class="form-submit  browse-sort__select" style="min-width:100px;<?php echo (@$_GET['occasion'] != '' && @$_GET['occasion'] != 'all') ? 'color:white;' : ''; ?>">
															<option value="">
																<?php echo $this->config->item('site_slug') == 'tempoparis' ? 'Seasons': 'Occasions'; ?>
															</option>
															
															<?php foreach($occasion_array as $occasion): ?>
															
																<?php
																//set the selected if filtered
																if (@$_GET['occasion'] == $occasion)
																{
																	$selected = 'selected';
																}
																else $selected = '';
																?>
															
															<option value="<?php echo $occasion; ?>" <?php echo $selected; ?>>
																<?php echo $occasion; ?>
															</option>
															
															<?php endforeach; ?>
															
															<option value="all">
																All
															</option>
														</select>
													</div>
		
												</form>
												<?php endif; ?>
												
												<?php
												/**********
												 * STYLES (this is the same as previous facet EVENTS / OCCASION)
												 * this applicable for the hub sites like instyle
												 */
												// get the color facets in array
												if ($this->uri->segment(1) === 'special_sale')
												{
													$styles_array = $this->facets->extract_facets($qry_style_facet, $facet_field_name_style);
												}
												else
												{
													$styles_array = extract_facets($this->facets->get('styles'), 'styles');
												}
												
												if ($styles_array AND count($styles_array) > 0):
												?>
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort">
		
													<input type="hidden" name="filter" value="" />
													<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
													<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
													<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
													<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
													<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
													<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
													<?php endif; ?>
													
													<?php if (@$_GET['style'] != '' && @$_GET['style'] != 'all') { ?>
													<style>#filter-style::after {border-top: 4px solid white;}
													</style>
													<?php } ?>
													
													<div id="filter-style" class="browse-sort__dropdown" <?php echo (@$_GET['style'] != '' && @$_GET['style'] != 'all') ? 'style="background-color:#846921;"' : ''; ?>>
														<select id="vProduct-browsePageDisplayPreferenceForm-style-1" name="style" class="form-submit  browse-sort__select" style="min-width:100px;<?php echo (@$_GET['style'] != '' && @$_GET['style'] != 'all') ? 'color:white;' : ''; ?>">
															<option value="">
																Styling
															</option>
															
															<?php foreach($styles_array as $style): ?>
															
																<?php
																//set the selected if filtered
																if (@$_GET['style'] == $style)
																{
																	$selected = 'selected';
																}
																else $selected = '';
																?>
															
															<option value="<?php echo $style; ?>" <?php echo $selected; ?>>
																<?php echo $style; ?>
															</option>
															
															<?php endforeach; ?>
															
															<option value="all">
																All
															</option>
														</select>
													</div>
		
												</form>

												<?php endif; ?>
												
												<?php
												/**********
												 * AVAILABILITY
												 * this applicable for the hub sites like instyle
												 */
												?>
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort">
		
													<input type="hidden" name="filter" value="" />
													<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
													<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
													<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
													<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
													<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['price'] AND $_GET['price'] !== 'default'): ?>
													<input type="hidden" name="price" value="<?php echo $_GET['price']; ?>" />
													<?php endif; ?>
													
													<?php if (@$_GET['availability'] != '' && @$_GET['availability'] != 'all') { ?>
													<style>#filter-availability::after {border-top: 4px solid white;}
													</style>
													<?php } ?>
													
													<div id="filter-availability" class="browse-sort__dropdown" <?php echo (@$_GET['availability'] != '' && @$_GET['availability'] != 'all') ? 'style="background-color:#846921;"' : ''; ?>>
														<select id="vProduct-browsePageDisplayPreferenceForm-availability-1" name="availability" class="form-submit  browse-sort__select" style="min-width:100px;<?php echo (@$_GET['availability'] != '' && @$_GET['availability'] != 'all') ? 'color:white;' : 'color:red;'; ?>">
															<option value="">
																Availability
															</option>
															<option value="instock" <?php echo @$_GET['availability'] == 'instock' ? 'selected': '';?> style="color:black;">
																In Stock
															</option>
															<option value="preorder" <?php echo @$_GET['availability'] == 'preorder' ? 'selected': '';?> style="color:black;">
																Pre Order
															</option>
															<?php if ($this->webspace_details->options['site_type'] == 'hub_site') { ?>
															<option value="onsale" <?php echo @$_GET['availability'] == 'onsale' ? 'selected': '';?> style="color:black;">
																On Sale
															</option>
															<?php } ?>
															<option value="all" style="color:black;">
																Default
															</option>
														</select>
													</div>
		
												</form>

												<?php
												/**********
												 * PRICE
												 * this applicable for the hub sites like instyle
												 
												<form id="vProduct-browsePageDisplayPreferenceForm-form-1" name="vProduct_browsePageDisplayPreferenceForm_form_1" action="" method="get" class="browse-sort hidden">
		
													<input type="hidden" name="filter" value="" />
													<?php if (@$_GET['size'] AND $_GET['size'] !== 'all'): ?>
													<input type="hidden" name="size" value="<?php echo $_GET['size']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['color'] AND $_GET['color'] !== 'all'): ?>
													<input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['occasion'] AND $_GET['occasion'] !== 'all'): ?>
													<input type="hidden" name="occasion" value="<?php echo $_GET['occasion']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['style'] AND $_GET['style'] !== 'all'): ?>
													<input type="hidden" name="style" value="<?php echo $_GET['style']; ?>" />
													<?php endif; ?>
													<?php if (@$_GET['availability'] AND $_GET['availability'] !== 'all'): ?>
													<input type="hidden" name="availability" value="<?php echo $_GET['availability']; ?>" />
													<?php endif; ?>
													
													<div class="browse-sort__dropdown" style="margin-left:20px;">
														<select id="vProduct-browsePageDisplayPreferenceForm-price-1" name="price" class="form-submit  browse-sort__select" style="min-width:100px;">
															<option value="">
																Sort By Price
															</option>
															<option value="ASC" <?php echo @$_GET['price'] == 'ASC' ? 'selected' : ''; ?>>
																Price: Low - High
															</option>
															<option value="DESC" <?php echo @$_GET['price'] == 'DESC' ? 'selected' : ''; ?>>
																Price: High - Low
															</option>
															<option value="default">
																Default
															</option>
														</select>
													</div>
		
												</form>
												 */
												?>

											</div>
