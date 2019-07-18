								<div class="select-designer-categories">

									<ul class="list-unstyled nested-nav ">

										<?php
										// show the designer label, then the designer subcats
										if (
											(
												$designer->url_structure !== 'instylenewyork'
												OR $designer->url_structure !== 'shop7thavenue'
											)
											&& $designer->with_products == '1'
										)
										{
											?>

										<li class="designer_list <?php echo $designer->des_id; ?>" data-des_id="<?php echo $designer->des_id; ?>" data-designer_slug="<?php echo $designer->url_structure; ?>" data-designer_name="<?php echo $designer->name; ?>">
											<a href="javascript:;" style="font-size:0.8em;<?php echo $this->uri->uri_string() == 'admin/inventory/'.$this->uri->segment(3).'/index/'.$designer->url_structure ? 'color:#23527c;text-decoration:underline;' : ''; ?>">
												<?php echo '<strong>'.$designer->name.'</strong>'; ?>
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
												 * Let us use a metronic helper to load category tree
												 */
												?>

												<?php
												// let's grab the uri segments
												$this->data['url_segs'] = explode('/', $this->uri->uri_string());

												// let's remove the first 2 segments (admin/products) from the resulting array
												array_shift($this->data['url_segs']); // admin
												array_shift($this->data['url_segs']); // purchase_orders
												array_shift($this->data['url_segs']); // create
												array_shift($this->data['url_segs']); // step2

												// resulting segments
												//$res_seg = array_merge(array($designer->url_structure), $this->data['url_segs']);
												echo create_admin_po_create_sidebar_category_list(
													$des_subcats,
													$this->data['url_segs'], //$res_seg,
													$des_number_of_categories
												);
												?>
												<!-- END LIST UNSTYLED -->

										</li>

											<?php
										} ?>

									</ul>

								</div>
