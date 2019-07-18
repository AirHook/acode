									<div class="row">

										<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
										<div class="admin_product_thumbs_sidebar col col-md-3" data-active_designer="<?php echo $active_designer; ?>" data-active_category="<?php echo $active_category; ?>">

											<?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'products_csv_sidebar'); ?>

										</div>
										<!-- END PRODUCT THUMGS SIDEBAR -->

										<!-- BEGIN PRODUCT LIST -->
										<div class="col col-md-9">

											<?php
											/*********
											 * This style a fix to the dropdown menu inside table-responsive table-scrollable
											 * datatables. Setting position to relative allows the main dropdown button to
											 * follow cell during responsive mode. A jquery is also needed on the button to
											 * toggle class to change back position to absolute so that the dropdown menu
											 * shows even on overflow.
											 */
											?>
											<style>
												.dropdown-fix {
													position: relative;
												}
											</style>

		                                    <?php
											/**********
											 * Datatable
											 */
											?>
		                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-product_list_csv" data-product_count="<?php echo @$products_count; ?>" data-number_of_colums="<?php echo @$size_mode == '1' ? '45' : '40'; ?>" data-size_mode="<?php echo @$size_mode; ?>" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

		                                        <!-- THEAD -->
		                                        <thead>
		                                            <tr>
		                                                <th> Edit </th>
		                                                <th> Prod ID </th>
		                                                <th> Prod No </th>
		                                                <th> Prod Name </th>
		                                                <th> <div style="width:250px;">Prod Desc</div> </th>
															<th> Prod Date </th>
		                                                <th> Seque </th>
		                                                <th> Public/Private </th>
		                                                <th> Publish </th>
		                                                <th> Publish Date </th>
															<th> Size Mode </th>
		                                                <th> Categories </th>
															<th> Cat </th>
															<th> Subcat </th>
		                                                <th> Retail Price </th>
															<th> On Sale Price </th>
		                                                <th> Wholesale Price </th>
		                                                <th> Clearance Price </th>
		                                                <th> Designer </th>
		                                                <th> Vendor </th>
															<th> Vendor Code </th>
		                                                <th> Vendor Type </th>
		                                                <th> <div style="width:250px;">Styles Facet</div> </th>
		                                                <th> <div style="width:250px;">Events Facet</div> </th>
		                                                <th> <div style="width:250px;">Materials Facet</div> </th>
															<th> <div style="width:250px;">Trends Facet</div> </th>
		                                                <th> <div style="width:250px;">Color Facet</div> </th>
		                                                <th> Clearance </th>
		                                                <th> Stock ID </th>
		                                                <th> Color Name </th>
															<th> Color Publish </th>
		                                                <th> Primary Color </th>
		                                                <th> Stock Date </th> <!-- index 32 -->
														<?php if (@$size_mode == '1') { ?>
		                                                <th> Size 0 </th>
		                                                <th> Size 2 </th>
		                                                <th> Size 4 </th>
		                                                <th> Size 6 </th>
		                                                <th> Size 8 </th>
		                                                <th> Size 10 </th>
		                                                <th> Size 12 </th>
		                                                <th> Size 14 </th>
		                                                <th> Size 16 </th>
		                                                <th> Size 18 </th>
		                                                <th> Size 20 </th>
		                                                <th> Size 22 </th>
														<?php } ?>
														<?php if (@$size_mode == '0') { ?>
		                                                <th> Size S </th>
		                                                <th> Size M </th>
		                                                <th> Size L </th>
		                                                <th> Size XL </th>
		                                                <th> Size XXL </th>
		                                                <th> Size XL1 </th>
		                                                <th> Size XL2 </th>
														<?php } ?>
		                                                <th> Del </th>
		                                            </tr>
		                                        </thead>

		                                        <!-- TBODY -->
		                                        <tbody>

													<?php
													if ($products)
													{
														$i = 1;
														foreach ($products as $product)
														{
															?>

		                                            <tr class="odd gradeX" data-size_mod="<?php echo $product->size_mode; ?>">
		                                                <td> <a class="edit" href="javascript:;" data-counter="<?php echo $i; ?>">Edit</a> </td>
		                                                <td class="text-center"> <?php echo $product->prod_id; ?> </td>
		                                                <td> <?php echo $product->prod_no; ?> </td>
		                                                <td> <?php echo $product->prod_name; ?> </td>
		                                                <td> <?php echo $product->prod_desc; ?> </td>
		                                                <td> <?php echo $product->prod_date; ?> </td>
		                                                <td> <?php echo $product->seque; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Public Options:" data-content="Y-Public, N-Private">
															<?php echo $product->public; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Publish Options:" data-content="1-Publish, 11-Publish at hub, 12-Publish at satellite site, 2-Private, 0-Unpublish">
															<?php echo $product->publish; ?> </td>
		                                                <td> <?php echo $product->publish_date; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Size Mode Options:" data-content="1-(0,2,4,6...22), 0-(S,M,L,XL...)">
															<?php echo $product->size_mode; ?> </td>
														<td>
															<?php
															/**********
															 * Categories - process to get slugs
															 */
															?>
															<?php
															$the_categories = json_decode($product->categories, TRUE);
															foreach($categories as $category)
															{
																if (in_array($category->category_id, $the_categories)) echo $category->category_slug.',';
															}
															?>
														</td>
		                                                <td> <?php echo $product->c_url_structure; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Subcat Options:" data-content="<?php foreach($categories as $category) { echo $category->category_id != '1' ? $category->category_slug.', ' : ''; }?>">
															<?php echo $product->sc_url_structure; ?> </td>
		                                                <td> <?php echo $product->less_discount; ?> </td>
		                                                <td> <?php echo $product->catalogue_price; ?> </td>
		                                                <td> <?php echo $product->wholesale_price; ?> </td>
		                                                <td> <?php echo $product->wholesale_price_clearance; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Designer Options:" data-content="<?php foreach($designers as $designer){ echo $designer->url_structure.', '; }?>"> <?php echo $product->d_url_structure; ?> </td>
		                                                <td> <?php echo $product->vendor_name; ?> </td>
		                                                <td> <?php echo $product->vendor_code; ?> </td>
		                                                <td> <?php echo $product->type; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Styles Facet"> <?php echo $product->styles; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Events Facet"> <?php echo $product->events; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Materials Facet"> <?php echo $product->materials; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Trends Facet"> <?php echo $product->trends; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Options:" data-content="Hyphenated (-) Colors Facet"> <?php echo $product->color_facets; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Clearance Options:" data-content="1-On Clearance, 0-Regular Sale">
															<?php echo $product->clearance; ?> </td>
		                                                <td> <?php echo $product->st_id; ?> </td>
		                                                <td> <?php echo $product->color_name; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Per Color Publish Options:" data-content="1-Publish, 11-Publish at hub, 12-Publish at satellite site, 2-Private, 0-Unpublish">
															<?php echo $product->new_color_publish; ?> </td>
		                                                <td class="popovers" data-trigger="hover" data-placement="top" data-container="body" data-original-title="Per Color Publish Options:" data-content="1-Primary, 0-Non primary">
															<?php echo $product->primary_color; ?> </td>
		                                                <td> <?php echo $product->stock_date; ?> </td>
														<?php if ($product->size_mode == '1') { ?>
		                                                <td> <?php echo $product->size_0; ?> </td>
		                                                <td> <?php echo $product->size_2; ?> </td>
		                                                <td> <?php echo $product->size_4; ?> </td>
		                                                <td> <?php echo $product->size_6; ?> </td>
		                                                <td> <?php echo $product->size_8; ?> </td>
		                                                <td> <?php echo $product->size_10; ?> </td>
		                                                <td> <?php echo $product->size_12; ?> </td>
		                                                <td> <?php echo $product->size_14; ?> </td>
		                                                <td> <?php echo $product->size_16; ?> </td>
		                                                <td> <?php echo $product->size_18; ?> </td>
		                                                <td> <?php echo $product->size_20; ?> </td>
		                                                <td> <?php echo $product->size_22; ?> </td>
														<?php } ?>
														<?php if ($product->size_mode == '0') { ?>
		                                                <td> <?php echo $product->size_ss; ?> </td>
		                                                <td> <?php echo $product->size_sm; ?> </td>
		                                                <td> <?php echo $product->size_sl; ?> </td>
		                                                <td> <?php echo $product->size_sxl; ?> </td>
		                                                <td> <?php echo $product->size_sxxl; ?> </td>
		                                                <td> <?php echo $product->size_sxl1; ?> </td>
		                                                <td> <?php echo $product->size_sxl2; ?> </td>
														<?php } ?>
		                                                <td> <a class="edit" href="javascript:;" data-counter="<?php echo $i; ?>">Edit</a> / <a class="delete" href="javascript:;">Delete</a> </td>
		                                            </tr>

															<?php
															$i++;
														}
													} ?>

		                                        </tbody>
		                                    </table>

										</div>
										<!-- END PRODUCT LIST -->

									</div>
