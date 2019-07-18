										<div class="panel-group accordion" id="accordion3">

											<div class="panel panel-default">
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
																	<a href="<?php echo site_url('admin/products/csv/index/'.$designer->url_structure); ?>" style="<?php echo $this->uri->uri_string() == 'admin/products/csv/index/'.$designer->url_structure ? 'color:#23527c;text-decoration:underline;' : ''; ?>">
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
																		 */
																		?>

																		<?php
																		if ($active_designer) array_shift($url_segs);
																		$des_seg = array($designer->url_structure);
																		$res_seg = array_merge($des_seg, $url_segs);
																		echo create_admin_product_csv_sidebar_category_list(
																			$des_subcats,
																			$res_seg,
																			$des_number_of_categories
																		);
																		?>
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

										</div>
