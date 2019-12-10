													<hr class="hidden-xs" style="margin:30px 30px 10px 0;" />

													<div class="product_thumbs_sidebar boom">

														<ul class="list-unstyled nested-nav" style="margin-right:30px;" data-row_count="25">
															<li class="category_list 1" data-category_id="1" data-parent_category="1" data-category_slug="womens_apparel" data-category_name="Womens Apparel" data-category_level="0" active="">
																<a href="http://localhost/~admin1/acode/shop/womens_apparel.html">
																	<strong>WOMENS APPAREL</strong>
																</a>
															</li>
														</ul>

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

														<!-- BEGIN SHOP BY DESIGNER -->

														<ul class="list-unstyled nested-nav" style="margin-right:30px;" data-row_count="25">
															<li class="category_list 1" data-category_id="1" data-parent_category="1" data-category_slug="womens_apparel" data-category_name="Womens Apparel" data-category_level="0" active="">
																<a class="expand collapse-marker" href="" data-original-title="Collapse/Expand" title="" style="position:relative;top:5px;"></a>
																<a href="http://localhost/~admin1/acode/shop/womens_apparel.html">
																	<strong>SHOP BY DESIGNERS</strong>
																</a>
																<ul class="list-unstyled ul-first-level display-none">
																	<li class="category_list 161" data-category_id="161" data-parent_category="1" data-category_slug="dresses" data-category_name="Dresses" data-category_level="1" active="">
																		<a href="http://localhost/~admin1/acode/shop/womens_apparel/dresses.html">
																			<strong>Dresses</strong>
																		</a>
																		<ul class="list-unstyled ">
																			<li class="category_list 195" data-category_id="195" data-parent_category="161" data-category_slug="evening_dresses" data-category_name="Evening Dresses" data-category_level="2" active="">
																				<a href="http://localhost/~admin1/acode/shop/womens_apparel/dresses/evening_dresses.html">
																					<strong>Evening Dresses</strong>
																				</a>
																			</li>
																			<li class="category_list 196 " data-category_id="196" data-parent_category="161" data-category_slug="cocktail_dresses" data-category_name="Cocktail Dresses" data-category_level="2">
																				<a href="http://localhost/~admin1/acode/shop/womens_apparel/dresses/cocktail_dresses.html">
																					Cocktail Dresses
																				</a>
																			</li>
																			<li class="category_list 197 " data-category_id="197" data-parent_category="161" data-category_slug="wedding_dresses" data-category_name="Wedding Dresses" data-category_level="2">
																				<a href="http://localhost/~admin1/acode/shop/womens_apparel/dresses/wedding_dresses.html">
																					Wedding Dresses
																				</a>
																			</li>
																			<li class="category_list 198 " data-category_id="198" data-parent_category="161" data-category_slug="mother_of_bride_dresses" data-category_name="MOB Gowns" data-category_level="2">
																				<a href="http://localhost/~admin1/acode/shop/womens_apparel/dresses/mother_of_bride_dresses.html">
																					MOB Gowns
																				</a>
																			</li>
																			<li class="category_list 199 " data-category_id="199" data-parent_category="161" data-category_slug="daywear_dresses" data-category_name="Daywear Dresses" data-category_level="2">
																				<a href="http://localhost/~admin1/acode/shop/womens_apparel/dresses/daywear_dresses.html">
																					Daywear Dresses
																				</a>
																			</li>
																		</ul>
																	</li>
																</ul>
															</li>
														</ul>

														<!-- END SHOP BY DESIGNER -->

													</div>
													<div class="hide">Slug is <?php echo $d_slug; ?>.</div>
