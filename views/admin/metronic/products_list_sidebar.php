											<style>
											.admin_product_thumbs_sidebar .panel .panel-heading h4,
											.admin_product_thumbs_sidebar .panel .panel-collapse li a {
												font-size: 0.7em;
											}
											/* *
											.admin_product_thumbs_sidebar .panel .panel-collapse li {
												line-height: 0.85em;
												padding: 5px 0;
											}
											/* */
											.admin_product_thumbs_sidebar .panel .panel-collapse .list-unstyled li > .list-unstyled {
												margin-left: 15px;
											}
											</style>

											<div class="panel-group accordion" id="accordion3">

												<?php
												/**********
												 * By Designer
												 * Hide on satellite and stand alonw sites
												 */
												?>
												<?php
												if ($this->webspace_details->options['site_type'] == 'hub_site')
												{ ?>

												<div class="panel panel-default <?php echo @$role == 'sales' ? 'hide' : ''; ?>">
													<div class="panel-heading">
														<h4 class="panel-title">
															<!-- DOC: Apply class "collapsed" to initially hide panel -->
															<a class="accordion-toggle accordion-toggle-styled <?php echo $active_designer ? '' : 'collapsed'; ?>" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> By Designer Categories </a>
														</h4>
													</div>
													<!-- DOC: Apply class "collapse" to initially hide panel -->
													<div id="collapse_3_1" class="panel-collapse <?php echo $active_designer ? 'in' : 'collapse'; ?>">
														<!-- DOC: Apply style="height:200px; overflow-y:auto;" to set height to start scrolling -->
														<div class="panel-body">

															<div class="select-designer-categories">

																<ul class="list-unstyled nested-nav">

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
																			$des_active = in_array($designer->url_structure, $url_segs) ? 'active': '';
																			?>

																	<li class="designer_list <?php echo $designer->des_id; ?>" data-des_id="<?php echo $designer->des_id; ?>" data-designer_slug="<?php echo $designer->url_structure; ?>" data-designer_name="<?php echo $designer->designer; ?>">
																		<a href="<?php echo site_url($pre_link.'/'.$designer->url_structure); ?>" style="<?php echo $this->uri->uri_string() == $pre_link.'/'.$designer->url_structure ? 'color:#23527c;text-decoration:underline;' : ''; ?>">
																			<?php echo ($des_active ? '<strong>' : '').$designer->designer.($des_active ? '</strong>' : ''); ?>
																		</a>

																			<?php
																			$des_subcats = $this->categories_tree->treelist(
																				array(
																					'd_url_structure' => $designer->url_structure,
																					'with_products' => TRUE
																				)
																			);
																			$des_number_of_categories = $this->categories_tree->row_count;
																			?>

																			<!-- BEGIN LIST UNSTYLED -->
																			<?php
																			/**********
																			 * Let us use a metroni helper to load category tree
																			 * Note the following that is neede:
																			 * 		$categories (object) // the list of categories to list in a tree like manner
																			 *		$this->product_details->categories // links or attached to categories
																			 *		$this->categories_tree->row_count
																			 *		$show_uncategorized = FALSE
																			 *
																			if ($active_designer) array_shift($url_segs);
																			$des_seg = array($designer->url_structure);
																			$res_seg = array_merge($des_seg, $url_segs);
																			echo create_admin_product_sidebar_category_list(
																				$des_subcats,
																				$res_seg,
																				$des_number_of_categories
																			);
																			// */
																			?>

																			<ul class="list-unstyled nested-nav" style="" data-row_count="<?php echo $number_of_categories; ?>">

																				<?php
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
																						$this_link = $pre_link.'/'.$designer->url_structure.'/'.implode('/', $li_a_link);

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
																							.'" style="'
																							.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
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
																						$this_link = $pre_link.'/'.$designer->url_structure.'/'.implode('/', $li_a_link);

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
																							.'" style="'
																							.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
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
																						$this_link = $pre_link.'/'.$designer->url_structure.'/'.implode('/', $li_a_link);

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
																							.'" style="'
																							.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
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
																						$this_link = $pre_link.'/'.$designer->url_structure.'/'.implode('/', $li_a_link);

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
																							.'" style="'
																							.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
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
																				} ?>

																			</ul>
																			<!-- END LIST UNSTYLED -->

																	</li>

																		<?php
																		}
																	} ?>

																</ul>

															</div>

														</div>
													</div>
												</div>

													<?php
												} ?>

												<div class="panel panel-default ">
													<div class="panel-heading">
														<h4 class="panel-title">
															<!-- DOC: Apply class "collapsed" to initially hide panel -->
															<a class="accordion-toggle accordion-toggle-styled <?php echo ($this->webspace_details->options['site_type'] == 'hub_site' && $active_designer) ? 'collapsed' : ''; ?>" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2"> By <?php echo $this->webspace_details->options['site_type'] == 'hub_site' ? 'General' : ''; ?> Categories </a>
														</h4>
													</div>
													<!-- DOC: Apply class "collapse" to initially hide panel -->
													<div id="collapse_3_2" class="panel-collapse <?php echo ($this->webspace_details->options['site_type'] == 'hub_site' && $active_designer) ? 'collapse' : 'in'; ?>">
														<!-- DOC: Apply style="height:200px; overflow-y:auto;" to set height to start scrolling -->
														<div class="panel-body">

															<div class="select-categories">

																<!-- BEGIN LIST UNSTYLED -->
																<?php
																/**********
																 * Let us use a metroni helper to load category tree
																 * Note the following that is neede:
																 * 		$categories (object) // the list of categories to list in a tree like manner
																 *		$this->product_details->categories // links or attached to categories
																 *		$this->categories_tree->row_count
																 *		$show_uncategorized = FALSE
																 *

																if ($active_designer) array_shift($url_segs);
																echo create_admin_product_sidebar_category_list(
																	$categories,
																	$url_segs,
																	$number_of_categories
																);
																// */
																?>

																<ul class="list-unstyled nested-nav" style="" data-row_count="<?php echo $number_of_categories; ?>">

																	<?php
																	$li_a_link = array();
																	$ic = 1;
																	foreach ($categories as $category)
																	{
																		if ( ! $active_designer)
																		{
																			// set select if category is already active
																			$active = in_array($category->category_slug, $url_segs) ? 'active': '';
																		}
																		else $active = '';

																		// let do first row...
																		if ($ic == 1)
																		{
																			// create link
																			array_push($li_a_link, $category->category_slug);

																			// set link
																			$this_link = $pre_link.'/'.implode('/', $li_a_link);

																			// first row is usually the top main category...
																			echo '<li class="category_list '
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
																				.site_url($this_link)
																				.'" style="'
																				.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
																				.'"> '
																				.($active ? '<strong>' : '')
																				.$category->category_name
																				.($active ? '</strong>' : '')
																				.' </a>'
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

																			// set link
																			$this_link = $pre_link.'/'.implode('/', $li_a_link);

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
																				.'><a href="'
																				.site_url($this_link)
																				.'" style="'
																				.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
																				.'"> '
																				.($active ? '<strong>' : '')
																				.$category->category_name
																				.($active ? '</strong>' : '')
																				.' </a>'
																			;
																		}

																		// NOTE: next greater level is always greater by only 1 level
																		// if so, create new open list <ul>
																		if ($category->category_level == $prev_level + 1)
																		{
																			// append to previous link
																			array_push($li_a_link, $category->category_slug);

																			// set link
																			$this_link = $pre_link.'/'.implode('/', $li_a_link);

																			echo '<ul class="list-unstyled '
																				.($category->category_level == '1' ? 'ul-first-level' : '')
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
																				.site_url($this_link)
																				.'" style="'
																				.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
																				.'"> '
																				.($active ? '<strong>' : '')
																				.$category->category_name
																				.($active ? '</strong>' : '')
																				.' </a>'
																			;
																		}

																		// if next category level is lower, close previous </li></ul> and open another one
																		// dont forget to count the depth of levels
																		if ($category->category_level < $prev_level)
																		{
																			for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
																			{
																				echo '</li></ul>';

																				// update link
																				$pop = array_pop($li_a_link);
																			}

																			// append to link
																			array_push($li_a_link, $category->category_slug);

																			// set link
																			$this_link = $pre_link.'/'.implode('/', $li_a_link);

																			echo '<ul class="list-unstyled '
																				.($category->category_level == '1' ? 'ul-first-level' : '')
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
																				.site_url($this_link)
																				.'" style="'
																				.($this->uri->uri_string() == $this_link ? 'color:#23527c;text-decoration:underline;' : '')
																				.'"> '
																				.($active ? '<strong>' : '')
																				.$category->category_name
																				.($active ? '</strong>' : '')
																				.' </a>'
																			;
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
																<!-- END LIST UNSTYLED -->

															</div>

														</div>
													</div>
												</div>
											</div>
