									<div class="row">

										<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
										<div class="admin_product_thumbs_sidebar col col-md-2">
											<?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'products_list_sidebar', $this->data); ?>
										</div>
										<!-- END PRODUCT THUMGS SIDEBAR -->

										<!-- BEGIN PRODUCT THUMGS LIST -->
										<div class="col col-md-10">

											<!-- FORM =======================================================================-->
											<?php echo form_open(
												$this->config->slash_item('admin_folder').'products/bulk_actions',
												array(
													'class'=>'form-horizontal',
													'id'=>'form_product_list_bulk_actions'
												)
											); ?>

											<div class="table-toolbar">
												<div class="row">
													<div class="col-md-6 pull-right text-right">
						                                <div class="btn-group">

															<a class="btn btn-link" style="color:black;text-decoration:none;cursor:default;" disabled>
																View as:
															</a>
						                                    <button type="button" class="btn blue btn-<?php echo $view_as == 'products_list' ? 'blue' : 'outline'; ?> tooltips btn-listgrid" data-view_as="products_list" data-container="body" data-placement="top" data-original-title="List View" style="margin-right:3px;">
						                                        <i class="glyphicon glyphicon-list"></i>
						                                    </button>
						                                    <button type="button" class="btn blue btn-<?php echo $view_as == 'products_grid' ? 'blue' : 'outline'; ?> tooltips btn-listgrid" data-view_as="products_grid" data-container="body" data-placement="top" data-original-title="Grid View">
						                                        <i class="glyphicon glyphicon-th"></i>
						                                    </button>

						                                </div>
						                            </div>

													<div class="col-lg-3 col-md-4">
														<select class="bs-select form-control selectpicker" id="bulk_actions_select" name="bulk_action" disabled>
															<option value="" selected="selected">Bulk Actions</option>
															<option value="0">UnPublish</option>
															<option value="1">Publish Public</option>
															<option value="2">Publish Private</option>
															<option value="del">Permanently Delete</option>
														</select>
													</div>
													<button class="btn green hidden-sm hidden-xs apply_bulk_actions" id="apply_bulk_actions" disabled data-toggle="modal" href="#confirm_bulk_actions"> Apply </button>
												</div>
												<button class="btn green hidden-lg hidden-md apply_bulk_actions" id="apply_bulk_actions" disabled data-toggle="modal" href="#confirm_bulk_actions"> Apply </button>

											</div>

											<?php
						                    /***********
						                     * Top Pagination
						                     */
						                    ?>
						                    <?php if ( ! @$search) { ?>
						                    <div class="row margin-bottom-10">
						                        <div class="col-md-12 text-justify pull-right">
						                            <span style="<?php echo $count_all > 100 ? 'position:relative;top:15px;' : ''; ?>">
						                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all > 100 ? $limit * $page : $count_all; ?> of about <?php echo number_format($count_all); ?> records
						                            </span>
						                            <?php echo $this->pagination->create_links(); ?>
						                        </div>
						                    </div>
						                    <?php } ?>

											<?php
											/*********
											 * This style a fix to the dropdown menu inside table-responsive table-scrollable
											 * datatables. Setting position to relative allows the main dropdown button to
											 * follow cell during responsive mode. A jquery is also needed on the button to
											 * toggle class to change back position to absolute so that the dropdown menu
											 * shows even on overflow.
											 *
											 * And some image tile fixes
											 */
											?>
											<style>
												.dropdown-fix {
													position: relative;
												}
												.thumb-tiles {
													position: relative;
													margin-right: 5px;
													margin-bottom: 5px;
													float: left;
												}
												.thumb-tiles .thumb-tile {
													display: block;
													float: left;
														height: 60px; /*135px;*/
														width: 40px !important; /*90px !important;*/
													cursor: pointer;
													text-decoration: none;
													color: #fff;
													position: relative;
													font-weight: 300;
														font-size: 12px;
													letter-spacing: .02em;
													line-height: 20px;
													overflow: hidden;
													border: 4px solid transparent;
													/*margin: 0 10px 10px 0;*/
												}
												.thumb-tiles .thumb-tile.image .tile-body {
													padding: 0 !important;
												}
												.thumb-tiles .thumb-tile .tile-body {
													height: 100%;
													vertical-align: top;
													padding: 10px;
													overflow: hidden;
													position: relative;
													font-weight: 400;
														font-size: 12px;
													color: #fff;
													/*margin-bottom: 10px;*/
												}
												.thumb-tiles .thumb-tile.image .tile-body > img {
    													width: 100%;
    													height: auto;
													min-height: 100%;
													max-width: 100%;
												}
												.thumb-tiles .thumb-tile .tile-body img {
													margin-right: 10px;
												}
												.thumb-tiles .thumb-tile .tile-object {
													position: absolute;
													bottom: 0;
													left: 0;
													right: 0;
														min-height: 20px;
													background-color: transparent;
												}
												.thumb-tiles .thumb-tile .tile-object > .name {
													position: relative;
													bottom: 0;
													left: 0;
													margin: 0 auto;
													font-weight: 300;
														font-size: 10px;
													color: #fff;
												}
												.img-a {
													position: absolute;
													left: 0;
													top: 0;
												}
												.img-b {
													position: absolute;
													left: 0;
													top: 0;
												}
											</style>
											<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-product_list_" data-product_count="<?php echo @$products_count; ?>">
												<thead>
													<tr>
														<th class="hidden-xs hidden-sm"> <!-- counter --> </th>
														<th class="text-center">
															<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																<input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-product_list_ .checkboxes" />
																<span></span>
															</label>
														</th>
														<th> Seque </th>
														<th> Image </th>
                                                        <th> Status </th>
														<th> Prod No </th>
														<th> Designer </th>
                                                        <th> Vendor </th>
														<th> Actions </th>
													</tr>
												</thead>
												<tbody>

													<?php
													if ($products)
													{
														$i = @$page ? ($limit * $page) - ($limit - 1) : 1;
														$unveil = FALSE;
														foreach ($products as $product)
														{
															// set image paths
															$pre_url =
																$this->config->item('PROD_IMG_URL')
																.'product_assets/WMANSAPREL/'
																.$product->d_url_structure.'/'
																.$product->sc_url_structure
															;
															$img_front_pre = $pre_url.'/product_front/thumbs/';
															$img_back_pre = $pre_url.'/product_back/thumbs/';
															$img_side_pre = $pre_url.'/product_side/thumbs/';
															// the image filename
															// the old ways dependent on category and folder structure
															$image = $product->prod_no.'_'.$product->primary_img_id.'_1.jpg';
															// the new way relating records with media library
															$new_pre_url = $this->config->item('PROD_IMG_URL').$product->media_path.$product->media_name;
															$img_front_new = $new_pre_url.'_f1.jpg';
															$img_back_new = $new_pre_url.'_b1.jpg';
															$img_side_new = $new_pre_url.'_s1.jpg';

															// edit link
															$edit_link = site_url('admin/products/edit/index/'.$product->prod_id)

															// after the first batch, hide the images through unveil
															//if (($i / 25) > 1) $unveil = TRUE;
															?>

													<tr class="odd gradeX" onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
														<!-- Counter -->
														<td class="hidden-xs hidden-sm">
															<?php echo $i; ?>
														</td>
														<!-- Checkbox -->
														<td class="text-center">
															<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
																<input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $product->prod_id; ?>" />
																<span></span>
															</label>
														</td>
														<!-- Seque -->
														<td class="text-center seque">
                                                            <input type="text" class="form-control seque" name="seque" value="<?php echo $product->seque ?: 0; ?>" readonly="" style="width:50px;height:25px;font-size:10px;" data-prod_id="<?php echo $product->prod_id; ?>" />
															<span class="seque-label" style="color:transparent;"><?php echo $product->seque ?: 0; ?></span>
														</td>
														<!-- Images -->
														<td class="text-center">
															<?php
															/*********
															 * Original thumb tile with image hover commented out
															 */
															?>
															<div class="thumb-tiles">
																<div class="thumb-tile image bg-blue-hoki">
																	<a href="<?php echo $edit_link; ?>">
																		<div class="tile-body">
																			<!--
																			<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
																			-->
																			<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"' : 'src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'; ?> alt="">
																			<noscript>
																				<!--
																				<img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
																				-->
																				<img class=" " src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
																			</noscript>
																		</div>
																		<div class="tile-object">
																			<div class="name"> <?php //echo $product->prod_no; ?>Front </div>
																		</div>
																	</a>
																</div>
															</div>
															<div class="thumb-tiles">
																<div class="thumb-tile image bg-blue-hoki">
																	<a href="<?php echo $edit_link; ?>">
																		<div class="tile-body">
																			<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_side_new : $img_side_pre.$image).'"' : 'src="'.($product->primary_img ? $img_side_new : $img_side_pre.$image).'"'; ?> alt="">
																		</div>
																		<div class="tile-object">
																			<div class="name"> <?php //echo $product->prod_no; ?>Side </div>
																		</div>
																	</a>
																</div>
															</div>
															<div class="thumb-tiles">
																<div class="thumb-tile image bg-blue-hoki">
																	<a href="<?php echo $edit_link; ?>">
																		<div class="tile-body">
																			<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
																		</div>
																		<div class="tile-object">
																			<div class="name"> <?php //echo $product->prod_no; ?>Back </div>
																		</div>
																	</a>
																</div>
															</div>
														</td>
														<!-- Status -->
														<!-- DOC: Remove "disabled-link disable-target" classes to enable the element -->
														<td <?php echo (($product->publish == '0' OR $product->publish == '3') && $product->view_status == 'N') ? 'class="disabled-link disable-target"': ''; ?>> <!-- Publish -->
															<?php
															// if product listing is grouped, primary color simply represent the main data for the entire group
															// if per variant, each color represent itself
															// this use of tbl_color fields is most appropriate
															if (($product->new_color_publish == '1' OR $product->new_color_publish == '11' OR $product->new_color_publish == '12') AND $product->color_publish == 'Y')
															{
																$label = 'success';
																$label_text = 'Public';
															}
															elseif ($product->new_color_publish != '0' AND $product->color_publish == 'N')
															{
																$label = 'info';
																$label_text = 'Private';
															}
															elseif ($product->new_color_publish == '3')
															{
																$label = 'warning';
																$label_text = 'Pending';
															}
															else {
																$label = 'danger';
																$label_text = 'Unpublished';
															}
															/*
															switch ($product->new_color_publish)
															{
																case '1':
																case '11':
																case '12':
																	$label = 'success';
																	$label_text = 'Public';
																	break;
																case '2':
																	$label = 'info';
																	$label_text = 'Private';
																	break;
																case '3':
																	$label = 'warning';
																	$label_text = 'Pending';
																	break;
																case '0':
																default:
																	$label = 'danger';
																	$label_text = 'Unpublished';
															}
															*/
															?>
															<span class="label label-sm label-<?php echo $label; ?>" style="font-size:95%;"> <?php echo $label_text; ?> </span>

															<?php if (isset($product->with_stocks) && $product->with_stocks == '0') { ?>
															<span class="label label-sm label-danger" style="font-size:95%;margin-left:1px;"> Pre Order </span>
															<?php } ?>

															<?php
															if ($product->new_color_publish == '1') { $checked1 = 'checked="checked"'; $checked2 = 'checked="checked"'; }
															elseif ($product->new_color_publish == '11') { $checked1 = 'checked="checked"'; $checked2 = ''; }
															elseif ($product->new_color_publish == '12') { $checked1 = ''; $checked2 = 'checked="checked"'; }
															else { $checked1 = ''; $checked2 = ''; }

															//if ($label_text == 'Public') { $checked3 = 'checked="checked"'; $checked4 = ''; }
															if ($label_text == 'Private') { $checked3 = ''; $checked4 = 'checked="checked"'; }
															else { $checked3 = 'checked="checked"'; $checked4 = ''; }
															?>
															<div>
																<input name="pub3<?php echo $product->st_id; ?>" class="list_publish_button" id="public<?php echo $product->st_id; ?>" type="radio" value="1" <?php echo $checked3; ?> data-action="publish" data-prod_id="<?php echo $product->prod_id; ?>" />Public
																<br />
																<input name="pub3<?php echo $product->st_id; ?>" class="list_publish_button" id="public<?php echo $product->st_id; ?>" type="radio" value="2" <?php echo $checked4; ?> data-action="private" data-prod_id="<?php echo $product->prod_id; ?>" />Private
															</div>
															<div style="background-color:#E0E0E0;border-top:1px dashed gray;" <?php echo (($product->publish == '2' OR $product->view_status == 'Y') && $product->public == 'N') ? 'class="disabled-link disable-target"': ''; ?>>
																<input name="pub1<?php echo $product->prod_no.'_'.$product->color_code; ?>" id="pub1<?php echo $product->st_id; ?>" type="checkbox" value="1" <?php echo $checked1; ?> class="set_purblish_state" data-prod_id="<?php echo $product->prod_id; ?>" data-st_id="<?php echo $product->st_id; ?>" onchange="setPublishState('<?php echo $product->prod_id?>');" />at Shop7
																<br />
																<input name="pub2<?php echo $product->prod_no.'_'.$product->color_code; ?>" id="pub2<?php echo $product->st_id; ?>" type="checkbox" value="2" <?php echo $checked2; ?> class="set_purblish_state"  data-prod_id="<?php echo $product->prod_id; ?>" data-st_id="<?php echo $product->st_id; ?>" onchange="setPublishState('<?php echo $product->prod_id?>');" />at Designer
															</div>

														</td>
														<!-- Prod No -->
														<td>
															<a class="" href="<?php echo $edit_link; ?>">
																<?php
																echo $product->prod_no;
																echo '<br />';
																echo '<cite class="small">'.$product->color_name.'</cite>';
																if ($page_param == 'all' && @$product->clearance == '3')
																{
																	echo '<br /><cite class="small font-red"> On Sale </cite>';
																}
																if ($page_param == 'all' && @$product->clearance_consumer_only == '"1"')
																{
																	echo '<br /><cite class="small font-red"> Consumer Clearance </cite>';
																}
																?>
															</a>
														</td>
														<!-- Designer -->
														<td> <?php echo $product->designer; ?> </td>
														<!-- Vendor Code -->
                                                        <td> <?php echo $product->vendor_code; ?> </td>

														<!-- Actions -->
														<td class="dropdown-wrap dropdown-fix"> <!-- Actions -->

															<!-- Edit -->
						                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="Edit">
						                                        <i class="fa fa-pencil font-dark"></i>
						                                    </a>
															<!-- Delete -->
						                                    <a href="javascript:;" class="tooltips delete-item" data-original-title="Delete" data-prod_id="<?php echo $product->prod_id; ?>">
						                                        <i class="fa fa-trash font-dark"></i>
						                                    </a>

															<?php
															/*********
															 * Hiding this for now
															 *
															?>
															<div class="btn-group hide" >
																<button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');"> Actions
																	<i class="fa fa-angle-down"></i>
																</button>
																<!-- DOC: Remove "pull-right" class to default to left alignment -->
																<ul class="dropdown-menu pull-right" role="menu">
																	<li>
																		<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$product->prod_id); ?>">
																			<i class="icon-pencil"></i> Edit </a>
																	</li>
																	<li>
																		<a data-toggle="modal" href="#<?php echo ((($product->publish == '0' OR $product->publish == '3') && $product->view_status == 'N') OR ($product->publish == '2' && $product->view_status == 'Y' && $product->public == 'N')) ? 'publish': 'unpublish'; ?>-<?php echo $product->prod_id; ?>">
																			<i class="icon-<?php echo ((($product->publish == '0' OR $product->publish == '3') && $product->view_status == 'N') OR ($product->publish == '2' && $product->view_status == 'Y' && $product->public == 'N')) ? 'check': 'ban'; ?>"></i> <?php echo ((($product->publish == '0' OR $product->publish == '3') && $product->view_status == 'N') OR ($product->publish == '2' && $product->view_status == 'Y' && $product->public == 'N')) ? 'Publish': 'Unpublish'; ?> </a>
																	</li>
																	<li>
																		<a data-toggle="modal" href="#delete-<?php echo $product->prod_id; ?>">
																			<i class="icon-trash"></i> Delete Permanently </a>
																	</li>
																	<li class="divider"> </li>
																	<li>
																		<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/add'); ?>">
																			<i class="icon-star"></i> Add New Product </a>
																	</li>
																</ul>
															</div>
															<?php // */ ?>

															<!-- UNPUBLISH -->
															<div class="modal fade bs-modal-sm" id="unpublish-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true">
																<div class="modal-dialog modal-sm">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																			<h4 class="modal-title">Update Product Info</h4>
																		</div>
																		<div class="modal-body"> Are you sure you want to UNPUBLISH item? </div>
																		<div class="modal-footer">
																			<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																			<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/publish/index/0/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
																				<span class="ladda-label">Confirm?</span>
																				<span class="ladda-spinner"></span>
																			</a>
																		</div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															<!-- /.modal -->

															<!-- PUBLISH -->
															<div class="modal fade bs-modal-sm" id="publish-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true">
																<div class="modal-dialog modal-sm">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close dismiss-publish-modal" data-dismiss="modal" aria-hidden="true"></button>
																			<h4 class="modal-title">Update Product Info</h4>
																		</div>
																		<div class="modal-body"> PUBLISH item? </div>
																		<div class="modal-footer">
																			<button type="button" class="btn dark btn-outline dismiss-publish-modal" data-dismiss="modal">Close</button>
																			<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/publish/index/1/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
																				<span class="ladda-label">Confirm?</span>
																				<span class="ladda-spinner"></span>
																			</a>
																		</div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															<!-- /.modal -->

															<!-- PRIVATE -->
															<div class="modal fade bs-modal-sm" id="private-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true">
																<div class="modal-dialog modal-sm">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close dismiss-publish-modal" data-dismiss="modal" aria-hidden="true"></button>
																			<h4 class="modal-title">Update Product Info</h4>
																		</div>
																		<div class="modal-body"> Set item to PRIVATE? </div>
																		<div class="modal-footer">
																			<button type="button" class="btn dark btn-outline dismiss-publish-modal" data-dismiss="modal">Close</button>
																			<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/publish/index/2/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
																				<span class="ladda-label">Confirm?</span>
																				<span class="ladda-spinner"></span>
																			</a>
																		</div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															<!-- /.modal -->

															<!-- DELETE -->
															<div class="modal fade bs-modal-sm" id="delete-<?php echo $product->prod_id?>" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
																<div class="modal-dialog modal-sm">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																			<h4 class="modal-title">Warning!</h4>
																		</div>
																		<div class="modal-body">
																			DELETE item? <br /> This cannot be undone!
																			<div class="note note-danger">
																				<h4 class="block">Danger! </h4>
																				<p> This action will delete the entire product item including its color variants. Please ensure you know what you are doing before proceeding. </p>
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																			<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/delete/index/'.$product->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
																				<span class="ladda-label">Confirm?</span>
																				<span class="ladda-spinner"></span>
																			</a>
																		</div>
																	</div>
																	<!-- /.modal-content -->
																</div>
																<!-- /.modal-dialog -->
															</div>
															<!-- /.modal -->
															<!-- <?php if(isset($barcode_code) && $barcode_code){ ?>
		                                                        <a target="_blank" style="margin-top: 25px;" href="<?php echo site_url($this->config->slash_item('admin_folder').'products/barcodes/index/'.$product->st_id); ?>" class="btn btn-xs btn-info">Print Barcode</a>
		                                                    <?php } ?> -->
														</td>
													</tr>

															<?php
															$i++;
														}
													}
													else
													{ ?>

													<tr class="odd gradeX">
														<td colspan="9">No recods found.</td>
													</tr>

													<?php
													} ?>

												</tbody>
											</table>

											<?php
						                    /***********
						                     * Bottom Pagination
						                     */
						                    ?>
						                    <?php if ( ! @$search) { ?>
						                    <div class="row margin-bottom-10">
						                        <div class="col-md-12 text-justify pull-right">
						                            <span>
						                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all > 100 ? $limit * $page : $count_all; ?> of about <?php echo number_format($count_all); ?> records
						                            </span>
						                            <?php echo $this->pagination->create_links(); ?>
						                        </div>
						                    </div>
						                    <?php } ?>

											</form>
											<!-- End FORM =======================================================================-->
											<!-- END FORM-->

										</div>
										<!-- END PRODUCT THUMGS LIST -->

									</div>
