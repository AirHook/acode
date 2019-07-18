										<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
										<div class="admin_product_thumbs_sidebar col col-md-3">

											<div class="panel-group accordion" id="accordion3">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<!-- DOC: Apply class "collapsed" to initially hide panel -->
															<a class="accordion-toggle accordion-toggle-styled " data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2"> Select Categories </a>
														</h4>
													</div>
													<!-- DOC: Apply class "collapse" to initially hide panel -->
													<div id="collapse_3_2" class="panel-collapse in">
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
																 */
																?>

																<?php
																//if ($active_designer) array_shift($url_segs);
																echo create_sale_package_product_sidebar_category_list(
																	$categories,
																	$url_segs,
																	$number_of_categories
																);
																?>
																<!-- END LIST UNSTYLED -->

															</div>

														</div>
													</div>
												</div>
											</div>

										</div>
										<!-- END PRODUCT THUMGS SIDEBAR -->
