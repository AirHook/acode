										<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
										<div class="panel-group accordion" id="accordion3">
											<div class="panel">
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
															 */
															?>

															<?php
															echo create_sale_package_sidebar_category_list(
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
										<!-- END PRODUCT THUMGS SIDEBAR -->
