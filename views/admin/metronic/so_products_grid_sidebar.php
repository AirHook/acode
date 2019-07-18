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
											<a href="javascript:;" style="font-size:0.9em;color:#23527c;">
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
												$config['base_url'] = $this->uri->segment(1).'/sales_orders/create/step1/';
												//$config['url_segments'] = ''; // use default
												$config['categories'] = $des_subcats;
												$config['categories_count'] = $this->categories_tree->row_count;
												$config['a_styles'] = 'font-size:0.9em;color:#23527c;line-height:20px;';
												//$config['ul_classes'] = '';
												$config['sub_ul_margin'] = 'margin-left:10px;';
												//$config['li_classes'] = '';
												//$config['li_styles'] = '';
												$this->sidebar_categories->initialize($config);
												echo $this->sidebar_categories->create_list();
												?>
												<!-- END LIST UNSTYLED -->

										</li>

											<?php
										} ?>

									</ul>

								</div>
