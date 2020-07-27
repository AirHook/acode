											<!-- BEGIN PRODUCT INVENTORY SIDEBAR -->
											<div class="panel-group accordion physical-inventory-sidebar" id="accordion3">

												<?php
												/**********
												 * Inventory List is always By Designer Categories
												 */
												?>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<!-- DOC: Apply class "collapsed" to initially hide panel -->
															<a class="accordion-toggle accordion-toggle-styled " data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> Select Categories </a>
														</h4>
													</div>
													<!-- DOC: Apply class "collapse" to initially hide panel -->
													<div id="collapse_3_1" class="panel-collapse ">
														<!-- DOC: Apply style="height:200px; overflow-y:auto;" to set height to start scrolling -->
														<div class="panel-body">

															<div class="select-designer-categories">

																<ul class="list-unstyled nested-nav ">

																	<?php
																	if (@$designers)
																	{
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
																		<a href="<?php echo site_url('admin/inventory/'.$this->uri->segment(3).'/index/'.$designer->url_structure); ?>" style="<?php echo $this->uri->uri_string() == 'admin/inventory/'.$this->uri->segment(3).'/index/'.$designer->url_structure ? 'color:#23527c;text-decoration:underline;' : ''; ?>">
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
																			 * Do category tree
																			 */
																			?>

																			<?php
																			/**********
																			 * Let us use a metronic helper to load category tree
																			 */
																			?>

																			<?php
																			$temp_url_segs = $url_segs;
																			if (@$active_designer) array_shift($temp_url_segs);
																			$res_seg = array_merge(array($designer->url_structure), $temp_url_segs);
																			echo create_admin_inventory_physical_sidebar_category_list(
																				$des_subcats,
																				$res_seg,
																				$des_number_of_categories
																			);
																			?>
																			<!-- END LIST UNSTYLED -->

																	</li>

																			<?php
																			}
																		}
																	} ?>

																</ul>

															</div>

														</div>
													</div>
												</div>

											</div>
											<!-- END PRODUCT INVENTORY SIDEBAR -->
