													<hr class="hidden-xs" style="margin:30px 30px 10px 0;" />

													<div class="product_thumbs_sidebar boom">

														<!-- BEGIN LIST UNSTYLED -->
														<?php
														/**********
														 * Let us use a metronic helper to load category tree
														 * Note the following that is neede:
														 * 		$categories (object) // the list of categories to list in a tree like manner
														 *		$this->product_details->categories // links or attached to categories
														 *		$this->categories_tree->row_count
														 *		$show_uncategorized = FALSE
														 */
														?>

														<?php
														if (
															$this->webspace_details->options['site_type'] == 'hub_site'
															&& $this->browse_by == 'sidebar_browse_by_designer'
														)
														{
															$sidebar_categories = $this->categories_tree->treelist(
																array(
																	'd_url_structure' => $this->uri->segment(2),
																	'view_status' => '1',
																	'with_products' => TRUE
																)
															);
															$d_slug = $this->uri->segment(2);
														}
														else
														{
															$sidebar_categories = $categories;
															$d_slug = '';
														}

														echo create_product_sidebar_category_list(
															$sidebar_categories,
															$this->uri->segment_array(),
															$number_of_categories,
															$d_slug
														);
														?>
														<!-- END LIST UNSTYLED -->

													</div>
													<div class="hide">Slug is <?php echo $d_slug; ?>.</div>
