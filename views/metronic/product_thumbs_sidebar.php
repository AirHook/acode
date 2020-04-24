													<hr class="hidden-xs" style="margin:30px 30px 10px 0;" />

													<div class="product_thumbs_sidebar boom">

														<ul class="list-unstyled nested-nav" style="margin-right:30px;" data-row_count="25">
															<li class="category_list 1" data-category_id="1" data-parent_category="1" data-category_slug="womens_apparel" data-category_name="Womens Apparel" data-category_level="0" active="">
																<a href="<?php echo site_url('shop/womens_apparel'); ?>">
																	<strong>WOMENS APPAREL</strong>
																</a>
															</li>
														</ul>

														<!-- BEGIN SHOP BY CATEGORIES -->
														<?php
														$sidebar_categories = $categories;
														$uri_segments = $this->uri->segment_array();

														// some defaults
														if (
															$this->browse_by == 'sidebar_browse_by_category'
															OR $this->webspace_details->options['site_type'] != 'hub_site'
														)
														{
															$by_categories_collapse = 'collapse';
															$by_categories_display = '';
														}
														else
														{
															$by_categories_collapse = 'expand';
															$by_categories_display = 'display-none';
														}
														?>
														<ul class="list-unstyled nested-nav" style="margin-right:30px;" data-row_count="<?php echo @$number_of_categories; ?>">

															<?php
															// get the 'dresses' category and its level
															// for the hard coded facets menu
															$dresses = 'dresses';
															$li_a_link = array();
															$ic = 1;
															foreach ($sidebar_categories as $category)
															{
																/**********
																 * Hardcoding Facets for Dresses
																 * And hiding PROM DRESSES above
																 * This will provide a link to all dresses that has PROM facets
																 * via the PROM facet link
																 */
																// since this is hard coded, we set level of 'dresses' manually
																$dresses_level = '1';
																// if past 'dresses', check for same category level
																// if so, we then squeeze in the facets menu
																if (
																	$dresses == 'dresses'
																	&& $category->category_slug != $dresses
																	&& $dresses_level == $category->category_level
																)
																{
																	$draw_facet_menu = TRUE;
																}
																// and remove category 'prom_dresses'
																if ($category->category_slug == 'prom_dresses') continue;
																/**********/

																// set select if category is already active
																$active = in_array($category->category_slug, $uri_segments) ? 'active': '';

																// let do first row...
																if ($ic == 1)
																{
																	// create link
																	$li_a_link = array($category->category_slug);

																	// first row is usually the top main category...
																	echo '<li class="category_list '
																		.$active
																		.'">'
																		.'<a href="javascript:;" class="category-list-heading-'
																		.$by_categories_collapse
																		.'"> <strong>SHOP BY CATEGORIES</strong> </a>'
																		.'<a class="'
																		.$by_categories_collapse
																		.' collapse-marker" href="" data-original-title="Collapse/Expand" title="" style="position:relative;top:5px;"></a>'
																	;

																	// save as previous level
																	$prev_level = $category->category_level;

																	$ic++;
																	continue;
																}

																// if same category level, close previous </li> and open another one
																if ($category->category_level == $prev_level)
																{
																	// create new link
																	$pop = array_pop($li_a_link);
																	array_push($li_a_link, $category->category_slug);

																	echo '</li><li class="category_list '
																		.$category->category_id
																		.' " data-category_id="'
																		.$category->category_id
																		.'" data-parent_category="'
																		.$category->parent_category
																		.'" data-category_slug="'
																		.$category->category_slug
																		.'" data-category_name="'
																		.$category->category_name
																		.'" data-category_level="'
																		.$category->category_level
																		.'" '
																		.$active
																		.'><a href="'.site_url('shop/'.implode('/', $li_a_link))
																		.'"> '
																		.(($active OR $category->category_level == '1') ? '<strong>' : '')
																		.$category->category_name
																		.(($active OR $category->category_level == '1') ? '</strong>' : '')
																		.' </a>';
																}

																// NOTE: next greater level is always greater by only 1 level
																// if so, create new open list <ul>
																if ($category->category_level == $prev_level + 1)
																{
																	// append to previous link
																	array_push($li_a_link, $category->category_slug);

																	echo '<ul class="list-unstyled '
																		.($category->category_level == '1' ? 'ul-first-level ' : ' ')
																		.($category->category_level == '1' ? $by_categories_display : '')
																		.'"><li class="category_list '
																		.$category->category_id
																		.'" data-category_id="'
																		.$category->category_id
																		.'" data-parent_category="'
																		.$category->parent_category
																		.'" data-category_slug="'
																		.$category->category_slug
																		.'" data-category_name="'
																		.$category->category_name
																		.'" data-category_level="'
																		.$category->category_level
																		.'" '
																		.$active
																		.'><a href="'
																		.site_url('shop/'.implode('/', $li_a_link))
																		.'"> '
																		.(($active OR $category->category_level == '1') ? '<strong>' : '')
																		.$category->category_name
																		.(($active OR $category->category_level == '1') ? '</strong>' : '')
																		.' </a>';
																}

																// if next category level is lower, close previous </li></ul> and open another one
																// dont forget to count the depth of levels
																if ($category->category_level < $prev_level)
																{
																	/**********
																	 * Hardcoding Facets for Dresses
																	 * And hiding PROM DRESSES above
																	 * This will provide a link to all dresses that has PROM facets
																	 * via the PROM facet link
																	 */
																	if ($draw_facet_menu)
																	{
																		if ($this->webspace_details->slug != 'tempoparis')
																		{
																			foreach($occassion_ary as $occassion)
																			{
																				// set active

																				// draw facet
																				echo '</li><li class="'
																					.($this->input->get('occassion') == $occassion ? 'active' : '')
																					.'">'
																					.'<a href="'
																					.site_url('shop/womens_apparel/dresses')
																					.'?occassion='
																					.$occassion
																					.'">'
																					.($this->input->get('occassion') == $occassion ? '<strong>' : '')
																					.ucfirst($occassion)
																					.($this->input->get('occassion') == $occassion ? '</strong>' : '')
																					.'</a>';
																			}
																		}

																		$dresses = $category->category_slug;
																		$draw_facet_menu = FALSE;
																	}

																	for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
																	{
																		echo '</li></ul>';

																		// update link
																		$pop = array_pop($li_a_link);
																	}

																	// append to link
																	array_push($li_a_link, $category->category_slug);

																	echo '<ul class="list-unstyled '
																		.($category->category_level == '1' ? 'ul-first-level ' : ' ')
																		.($category->category_level == '1' ? $by_categories_display : '')
																		.'"><li class="category_list '
																		.$category->category_id
																		.'" data-category_id="'
																		.$category->category_id
																		.'" data-parent_category="'
																		.$category->parent_category
																		.'" data-category_slug="'
																		.$category->category_slug
																		.'" data-category_name="'
																		.$category->category_name
																		.'" data-category_level="'
																		.$category->category_level
																		.'" '.
																		$active
																		.'><a href="'
																		.site_url('shop/'.implode('/', $li_a_link))
																		.'"> '
																		.(($active OR $category->category_level == '1') ? '<strong>' : '')
																		.$category->category_name
																		.(($active OR $category->category_level == '1') ? '</strong>' : '')
																		.' </a>';
																}

																// if this is last row, close it
																// again, check coutn of depth of levels
																if ($ic == $number_of_categories)
																{
																	for ($deep = $category->category_level; $deep > 0; $deep--)
																	{
																		echo '</li data-row_count="'.$number_of_categories.'"></ul>';
																	}
																	echo '</li>';
																}

																$prev_level = $category->category_level;
																$ic++;
															} ?>

														</ul>
														<!-- END SHOP BY CATEGORIES -->

														<!-- BEGIN SHOP BY DESIGNER -->
														<?php
														if (
															$this->webspace_details->options['site_type'] == 'hub_site'
														)
														{
															// some defaults
															if ($this->browse_by == 'sidebar_browse_by_designer')
															{
																$by_designers_collapse = 'collapse';
																$by_designers_display = '';
															}
															else
															{
																$by_designers_collapse = 'expand';
																$by_designers_display = 'display-none';
															}
															?>
														<ul class="list-unstyled nested-nav" style="margin-right:30px;" data-row_count="">
															<li class="category_list 1" data-category_id="1" data-parent_category="1" data-category_slug="womens_apparel" data-category_name="Womens Apparel" data-category_level="0" active="">
																<a class="<?php echo $by_designers_collapse; ?> collapse-marker" href="" data-original-title="Collapse/Expand" title="" style="position:relative;top:5px;"></a>
																<a href="javascript::" class="category-list-heading-<?php echo $by_designers_collapse; ?>">
																	<strong>SHOP BY DESIGNERS</strong>
																</a>

																	<?php
																	foreach ($designers as $designer)
																	{
																		// for each of all designers...
																		// show the designer label, then the designer subcats
																		if (
																			(
																				$designer->url_structure !== 'instylenewyork'
																				OR $designer->url_structure !== 'shop7thavenue'
																			)
																			&& $designer->with_products == '1'
																		)
																		{
																			$des_active = in_array($designer->url_structure, $uri_segments) ? 'active': '';
																	?>

																<ul class="list-unstyled ul-first-level <?php echo $by_designers_display; ?>">
																	<li class="category_list <?php echo $designer->des_id; ?>" data-des_id="<?php echo $designer->des_id; ?>" data-designer_slug="<?php echo $designer->url_structure; ?>" data-designer_name="<?php echo $designer->designer; ?>">
																		<a href="<?php echo site_url('shop/'.$designer->url_structure); ?>">
																			<strong><?php echo $designer->designer; ?></strong>
																		</a>
																		<ul class="list-unstyled ">

																			<?php
																			$des_subcats = $this->categories_tree->treelist(
																				array(
																					'd_url_structure' => $designer->url_structure,
																					'with_products' => TRUE
																				)
																			);
																			$des_number_of_categories = $this->categories_tree->row_count;

																			$li_a_link = array();
																			$ic = 1;
																			foreach ($des_subcats as $subcat)
																			{
																				if ($des_active == 'active')
																				{
																					// set select if category is already active
																					$active = in_array($subcat->category_slug, $url_segs) ? 'active': '';
																				}
																				else $active = '';

																				// let do first row...
																				if ($ic == 1)
																				{
																					// create link
																					array_push($li_a_link, $subcat->category_slug);

																					// set link
																					$this_link = 'shop/'.$designer->url_structure.'/'.implode('/', $li_a_link);

																					// first row is usually the top main category...
																					echo '<li class="category_list '
																						.$subcat->category_id
																						.'" data-category_id="'
																						.$subcat->category_id
																						.'" data-parent_category="'
																						.$subcat->parent_category
																						.'" data-category_slug="'
																						.$subcat->category_slug
																						.'" data-category_name="'
																						.$subcat->category_name
																						.'" data-category_level="'
																						.$subcat->category_level
																						.'" '
																						.$active
																						.'><a href="'
																						.site_url($this_link)
																						.'"> '
																						.($active ? '<strong>' : '')
																						.$subcat->category_name
																						.($active ? '</strong>' : '')
																						.' </a>'
																					;

																					// save as previous level
																					$prev_level = $subcat->category_level;

																					$ic++;
																					continue;
																				}

																				// if same category level, close previous </li> and open another one
																				if ($subcat->category_level == $prev_level)
																				{
																					// create new link
																					$pop = array_pop($li_a_link);
																					array_push($li_a_link, $subcat->category_slug);

																					// set link
																					$this_link = 'shop/'.$designer->url_structure.'/'.implode('/', $li_a_link);

																					echo '</li><li class="category_list '
																						.$subcat->category_id
																						.' " data-category_id="'
																						.$subcat->category_id
																						.'" data-parent_category="'
																						.$subcat->parent_category
																						.'" data-category_slug="'
																						.$subcat->category_slug
																						.'" data-category_name="'
																						.$subcat->category_name
																						.'" data-category_level="'
																						.$subcat->category_level
																						.'" '
																						.$active
																						.'><a href="'
																						.site_url($this_link)
																						.'"> '
																						.($active ? '<strong>' : '')
																						.$subcat->category_name
																						.($active ? '</strong>' : '')
																						.' </a>'
																					;
																				}

																				// NOTE: next greater level is always greater by only 1 level
																				// if so, create new open list <ul>
																				if ($subcat->category_level == $prev_level + 1)
																				{
																					// append to previous link
																					array_push($li_a_link, $subcat->category_slug);

																					// set link
																					$this_link = 'shop/'.$designer->url_structure.'/'.implode('/', $li_a_link);

																					echo '<ul class="list-unstyled '
																						.($subcat->category_level == '1' ? 'ul-first-level' : '')
																						.'"><li class="category_list '
																						.$subcat->category_id
																						.'" data-category_id="'
																						.$subcat->category_id
																						.'" data-parent_category="'
																						.$subcat->parent_category
																						.'" data-category_slug="'
																						.$subcat->category_slug
																						.'" data-category_name="'
																						.$subcat->category_name
																						.'" data-category_level="'
																						.$subcat->category_level
																						.'" '
																						.$active
																						.'><a href="'
																						.site_url($this_link)
																						.'"> '
																						.($active ? '<strong>' : '')
																						.$subcat->category_name
																						.($active ? '</strong>' : '')
																						.' </a>'
																					;
																				}

																				// if next category level is lower, close previous </li></ul> and open another one
																				// dont forget to count the depth of levels
																				if ($subcat->category_level < $prev_level)
																				{
																					for ($deep = $prev_level - $subcat->category_level; $deep >= 0; $deep--)
																					{
																						echo '</li></ul>';

																						// update link
																						$pop = array_pop($li_a_link);
																					}

																					// append to link
																					array_push($li_a_link, $subcat->category_slug);

																					// set link
																					$this_link = 'shop/'.$designer->url_structure.'/'.implode('/', $li_a_link);

																					echo '<ul class="list-unstyled '
																						.($subcat->category_level == '1' ? 'ul-first-level' : '')
																						.'"><li class="category_list '
																						.$subcat->category_id
																						.'" data-category_id="'
																						.$subcat->category_id
																						.'" data-parent_category="'
																						.$subcat->parent_category
																						.'" data-category_slug="'
																						.$subcat->category_slug
																						.'" data-category_name="'
																						.$subcat->category_name
																						.'" data-category_level="'
																						.$subcat->category_level
																						.'" '
																						.$active
																						.'><a href="'
																						.site_url($this_link)
																						.'"> '
																						.($active ? '<strong>' : '')
																						.$subcat->category_name
																						.($active ? '</strong>' : '')
																						.' </a>'
																					;
																				}

																				// if this is last row, close it
																				// again, check coutn of depth of levels
																				if ($ic == $des_number_of_categories)
																				{
																					for ($deep = $subcat->category_level; $deep > 0; $deep--)
																					{
																						echo '</li data-row_count="'.$des_number_of_categories.'"></ul>';
																					}
																					echo '</li>';
																				}

																				$prev_level = $subcat->category_level;
																				$ic++;
																			}
																			?>

																		</ul>

																	</li>
																</ul>
																			<?php
																		}
																	}?>

															</li>
														</ul>
														<!-- END SHOP BY DESIGNER -->

															<?php
														} ?>

													</div>
													<div class="hide">Slug is <?php echo $d_slug; ?>.</div>
