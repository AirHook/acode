                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">

                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> <?php echo $page_title; ?> Table</span>
                                    </div>
                                </div>
                                <div class="portlet-body">

									<!-- FORM =======================================================================-->
									<?php echo form_open(
										$this->config->slash_item('admin_folder').'campaigns/sales_package/bulk_actions',
										array(
											'class'=>'form-horizontal',
											'id'=>'form-sales_package_list_bulk_action'
										)
									); ?>

									<?php
									/***********
									 * Noification area
									 */
									?>
									<div>
										<?php if ($this->session->flashdata('success') == 'add') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> New Sales Package CREATED!
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Sales Package information updated.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'delete') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Sales Package permanently removed from records.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> An error occured. Please try again.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'del_system_sales_package') { ?>
										<div class="alert alert-danger ">
											<button class="close" data-close="alert"></button> Unable to delete system generated sales packages. Please try again.
										</div>
										<?php } ?>
									</div>

                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <a href="#modal_create_sales_package" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Create a Sales Package
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
										<br />
                                        <div class="row hidden-xs hidden-sm">

											<div class="col-lg-3 col-md-4">
												<select class="bs-select form-control bs-select" id="bulk_actions_select" name="bulk_action" disabled>
													<option value="" selected="selected">Bulk Actions</option>
													<option value="del">Permanently Delete</option>
												</select>
											</div>
											<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

										</div>

                                    </div>
									<?php
									/*********
									 * This style a fix to the dropdown menu inside table-responsive table-scrollable
									 * datatables. Setting position to relative allows the main dropdown button to
									 * follow cell during responsive mode. A jquery is also needed on the button to
									 * toggle class to change back position to absolute so that the dropdown menu
									 * shows even on overflow
									 */
									?>
									<style>
										.dropdown-fix {
											position: relative;
										}
									</style>

                                    <style>
                                        .thumb-tiles {
                                            position: relative;
                                            margin-right: -10px;
                                        }
                                        .thumb-tiles .thumb-tile {
                                            display: block;
                                            float: left;
                                            height: 210px;
                                            width: 140px !important;
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
                                            margin: 0 10px 10px 0;
                                        }
                                        .thumb-tiles .package {
                                            width: 80px !important;
                                            height: 120px;
                                        }
                                        .thumb-tiles .thumb-tile.selected .corner::after {
                                            content: "";
                                            display: inline-block;
                                            border-left: 40px solid transparent;
                                            border-bottom: 40px solid transparent;
                                            border-right: 40px solid #ccc;
                                            position: absolute;
                                            top: -3px;
                                            right: -3px;
                                            z-index: 100;
                                        }
                                        .thumb-tiles .thumb-tile.selected .check::after {
                                            font-family: FontAwesome;
                                            font-size: 13px;
                                            content: "\f00c";
                                            color: red;
                                            position: absolute;
                                            top: 2px;
                                            right: 2px;
                                            z-index: 101;
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
                                            margin-bottom: 10px;
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
                                            min-height: 30px;
                                            background-color: transparent;
                                        }
                                        .thumb-tiles .thumb-tile .tile-object > .name {
                                            position: absolute;
                                            bottom: 0;
                                            left: 0;
                                            margin-bottom: 5px;
                                            margin-left: 10px;
                                            margin-right: 15px;
                                            font-weight: 400;
                                            font-size: 13px;
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

                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-sales_packages" data-items_count="<?php echo $sa_items_count; ?>">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs hidden-sm"> <!-- counter --> </th>
                                                <th class="text-center hidden-xs hidden-sm">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-sales_packages .checkboxes" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th> Sales Package </th>
                                                <th class="hidden-xs hidden-sm"> Author </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
											if ($packages)
											{
												$i = 1;
												foreach ($packages as $package)
												{
                                                    if ($package->sales_package_id == '1') $i -= 1;
                                                    if (
                                                        $this->uri->segment(1) == 'sales'
                                                        && $package->sales_package_id != '1'
                                                    )
                                                    { ?>

                                            <tr class="odd gradeX " onmouseover="//$(this).find('.hidden_first_edit_link').show();" onmouseout="//$(this).find('.hidden_first_edit_link').hide();">

                                                <td class="hidden-xs hidden-sm">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="text-center hidden-xs hidden-sm">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="checkboxes" name="<?php echo $package->set_as_default == '1' ? 'default_checkbox': 'checkbox[]'; ?>" value="<?php echo $package->sales_package_id; ?>" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>

                                                    <a href="javascript:;" data-link="<?php echo site_url('sales/sales_package/view/index/'.$package->sales_package_id); ?>" class="list-edit-sales-package">
														<?php echo $package->sales_package_name; ?>
                                                    </a>

													<!-- DOC: Show notice if package has empty items -->
													<?php if ($package->sales_package_items == '') { ?>
													&nbsp;
                                                    <br class="hidden-md hidden-lg" />
													<a class="text-danger" href="<?php echo site_url('sales/sales_package/view/index/'.$package->sales_package_id); ?>"><small><cite>Select items first for this package</cite></small></a>
													<?php } ?>
													<!-- -->
													&nbsp;

													<a class="hidden_first_edit_link list-edit-sales-package" href="javascript:;" data-link="<?php echo site_url('sales/sales_package/view/index/'.$package->sales_package_id); ?>">
														<small><cite>view/edit</cite></small>
                                                    </a>

                                                    <br /><br />

                                                    <?php
                    								/***********
                    								 * Sales Package Items Thumbs
                    								 */
                    								?>
                									<div class="thumb-tiles sales-package clearfix">

                										<?php
                										if ($package->sales_package_items)
                										{
                                                            $items = json_decode($package->sales_package_items, TRUE);
                											foreach ($items as $item)
                											{
                                                                // get product details
                            									$exp = explode('_', $item);
                            									if (count($exp) == 2)
                            									{
                            										$params = array(
                            											'tbl_product.prod_no'=>$exp[0],
                            											'color_code'=>$exp[1]
                            										);
                            									}
                            									else $params = array('tbl_product.prod_no'=>$exp[0]);
                            									$product = $this->product_details->initialize($params);

                												// the image filename
                												// the old ways dependent on category and folder structure
                                                                $style_no = $product->prod_no.'_'.$product->color_code;
                												$image = $style_no.'_3.jpg';
                												// the new way relating records with media library
                												$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                												$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
                												?>

                											<div class="thumb-tile package image bg-blue-hoki <?php echo $style_no; ?> selected" data-sku="<?php echo $style_no; ?>" data-prod_no="<?php echo $product->prod_no; ?>" data-prod_id="<?php echo $product->prod_id; ?>">

                												<div class="corner"> </div>
                												<div class="check"> </div>
                												<div class="tile-body">
                													<img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
                													<img class="img-a" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
                												</div>
                												<div class="tile-object">
                													<div class="name"> <?php echo $product->public == 'N' ? '<span style="color:#ed6b75;"> Private </span> <br />' : ''; ?> <?php echo $product->prod_no; ?> </div>
                												</div>

                											</div>

                										<?php
                											}
                										}
                										else
                                                        { ?>
                                                            <h3><cite> Select items first for this package... </cite></h3>
                                                            <?php
                                                            echo '<input type="hidden" id="items_count" name="items_count" value="0" />';
                                                        }
                										?>

                									</div>

												</td>
                                                <td class="hidden-xs hidden-sm">
													<?php if ($package->sales_package_id == '1' OR $package->sales_package_id == '2') { ?>
													<small class="text-info"> <cite> system generated </cite></small>
													<?php } else if ($package->sales_user == '1') { ?>
													<small class="text-info"> <cite> admin </cite></small>
													<?php } else { ?>
                                                    <?php echo ucwords($package->admin_sales_user.' '.$package->admin_sales_lname); ?> - <small class="text-info"> <cite> sales </cite></small>
													<?php } ?>
                                                </td>
                                                <td class="dropdown-wrap dropdown-fix">
                                                    <div class="btn-group" >
                                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
														<!-- DOC: Remove "pull-right" class to default to left alignment -->
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
																<?php if ($package->sales_package_id == '2') { ?>
                                                                <a href="#modal-select_designer_for_designer_recent_sales_package" data-toggle="modal">
																<?php } else { ?>
                                                                <a href="javascript:;" data-link="<?php echo site_url('sales/sales_package/view/index/'.$package->sales_package_id); ?>" class="list-edit-sales-package">
																<?php } ?>
                                                                    <i class="icon-pencil"></i> Edit </a>
                                                            </li>
															<?php if (
																$package->sales_package_id !== '1'
																&& $package->sales_package_id !== '2'
																&& $package->author !== 'system'
															) { ?>
                                                            <li>
																<?php if ($package->set_as_default == '1') { ?>
                                                                <a data-toggle="modal" href="#nocando-default_sales_pacakge">
																<?php } else { ?>
                                                                <a data-toggle="modal" href="#delete-<?php echo $package->sales_package_id; ?>">
																<?php } ?>
                                                                    <i class="icon-trash"></i> Delete </a>
                                                            </li>
															<?php } ?>
                                                            <li class="divider"> </li>
                                                            <li>
																<a href="javascript:;" data-link="<?php echo site_url('sales/create/step1/womens_apparel'); ?>" class="list-create-sales-package">
                                                                    <i class="fa fa-plus"></i> Create Sales Package </a>
                                                            </li>
                                                        </ul>
                                                    </div>
													<!-- DELETE ITEM -->
													<div class="modal fade bs-modal-sm" id="delete-<?php echo $package->sales_package_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Warning!</h4>
																</div>
																<div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/delete/index/'.$package->sales_package_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                </td>
                                            </tr>

                                                        <?php
                                                    }
													$i++;
												}
											} ?>

                                        </tbody>
                                    </table>

									</form>
									<!-- End FORM =======================================================================-->
									<!-- END FORM-->

									<br />
									<div class="m-heading-1 border-blue m-bordered">
										<h3>NOTE:</h3>
										<p> System generated sales pacakges and sales packages that are set as default cannot be deleted. </p>
									</div>
									<div class="m-heading-1 border-green m-bordered">
										<h3>Sales Package</h3>
										<p> Here you can create sales packages for sending to wholesale users, etc... </p>
										<p> For more info please check out
											<a class="btn red btn-outline" href="javascript:;" target="">the official documentation</a>
										</p>
									</div>
                                </div>

                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
