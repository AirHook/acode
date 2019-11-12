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
					<div class="notifications">
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

						<style>
                            .nav > li > a {
                                padding: 8px 15px;
                                background-color: #eee;
                                color: #555;
                            }
                            .nav-tabs > li > a {
                                font-size: 12px;
                            }
                            .nav-tabs > li > a:hover {
                                background-color: #333;
                                color: #eee;
                            }
                        </style>

                        <ul class="nav nav-tabs">
                            <li class="<?php echo $this->uri->uri_string() == 'admin/campaigns/sales_package' ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/campaigns/sales_package'); ?>">
                                    Sales Packages
                                </a>
                            </li>
							<li class="<?php echo $this->uri->segment(3) == 'onorder' ? 'active' : ''; ?>">
								<a href="javascript:;" class="tooltips" data-original-title="Currently under construction">
									Preset Sales Packages
								</a>
							</li>
                            <?php
                            // available only on hub sites for now
                            if ($this->webspace_details->options['site_type'] == 'hub_site')
                            { ?>
                            <li>
                                <a href="<?php echo site_url('admin/campaigns/sales_package/create'); ?>">
                                    Create New Sales Package <i class="fa fa-plus"></i>
                                </a>
                            </li>
                                <?php
                            } ?>
                        </ul>

                        <br />

                        <?php if (@$search) { ?>
                        <h1><small><em>Search results for:</em></small> "<?php echo @$search_string; ?>"</h1>
                        <br />
                        <?php } ?>

						<!-- --
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
						<!-- -->

                        <div class="row">

							<div class="col-lg-3 col-md-4">
								<select class="bs-select form-control bs-select" id="bulk_actions_select" name="bulk_action" disabled>
									<option value="" selected="selected">Bulk Actions</option>
									<option value="del">Permanently Delete</option>
								</select>
							</div>
							<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

						</div>
						<button class="btn green hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

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

                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-sales_packages">
                        <thead>
                            <tr>
                                <th class="hidden-xs hidden-sm"> <!-- counter --> </th>
                                <th class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-sales_packages .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th> Sales Package Name </th>
                                <th> Items </th>
								<th> Author </th>
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
									$edit_link = site_url('admin/campaigns/sales_package/modify/index/'.$package->sales_package_id);
									?>

                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs hidden-sm">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="<?php echo $package->set_as_default == '1' ? 'default_checkbox': 'checkbox[]'; ?>" value="<?php echo $package->sales_package_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td>
									<?php if ($package->sales_package_id == '2') { ?>
									<a href="#modal-select_designer_for_designer_recent_sales_package" data-toggle="modal">
									<?php } else { ?>
									<a href="<?php echo $edit_link; ?>">
									<?php } ?>
										<?php echo $package->sales_package_name; ?></a>
									<!-- DOC: Removing 'Set as Default' to avoid user confusion -->
									<?php if ($package->set_as_default == '1_') { ?>
									<small class="text-danger"> <cite> &nbsp; Set as Default </cite></small>
									<?php } ?>
									<!-- -->
									<!-- DOC: Show notice if package has empty items -->
									<?php if ($package->sales_package_items == '') { ?>
									&nbsp;
									<br />
									<a class="text-danger" href="<?php echo $edit_link; ?>">
										<small><cite>Select items first for this package</cite></small>
									</a>
									<?php } ?>
									<!-- -->
									&nbsp;
									<?php if ($package->sales_package_id == '2') { ?>
									<a class="hidden_first_edit_link" style="display:none;" href="#modal-select_designer_for_designer_recent_sales_package" data-toggle="modal">
									<?php } else { ?>
									<a class="hidden_first_edit_link" style="display:none;" href="<?php echo $edit_link; ?>">
									<?php } ?>
										<small class="hide"><cite>view/edit</cite></small></a>
                                        <br /><br />
									</td>
	                                <td>
                                        <?php
        								/***********
        								 * Selected Items Thumbs
        								 */
        								?>
    									<div class="thumb-tiles sales-package clearfix">

    										<?php
    										if ($package->sales_package_items)
    										{
                                                $items = json_decode($package->sales_package_items, TRUE);
    											foreach ($items as $item)
    											{
													// just a catch all error suppression
													if ( ! $item) continue;

													// get product details
													// NOTE: some items may not be in product list
													$product = $this->product_details->initialize(array('tbl_product.prod_no' => $item));
													if ( ! $product)
													{
														$exp = explode('_', $item);
														$product = $this->product_details->initialize(
															array(
																'tbl_product.prod_no' => $exp[0],
																'color_code' => $exp[1]
															)
														);
														$prod_no = $exp[0];
														$color_code = $exp[1];
													}
													else
													{
														$prod_no = $product->prod_no;
														$color_code = $product->color_code;
													}

													// set image paths
													$style_no = $item;

													if ($product)
													{
														$image_new = $product->media_path.$style_no.'_f3.jpg';
														$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
														$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
														$img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
														$img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
														$color_name = $product->color_name;
													}
													else
													{
														$image_new = 'images/instylelnylogo_3.jpg';
														$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
														$img_back_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
														$img_linesheet = '';
														$img_large = '';
														$color_name = $this->product_details->get_color_name($color_code);
													}

    												// set image paths
    												$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
    												$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
    												// the image filename
    												// the image filename
    												// the old ways dependent on category and folder structure
    												$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
    												// the new way relating records with media library
    												$img_front_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_f3.jpg';
    												$img_back_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_b3.jpg';
    												?>

    											<div class="thumb-tile package image bg-blue-hoki <?php echo $item; ?> selected" data-sku="<?php echo $item; ?>" data-prod_no="<?php echo $prod_no; ?>" data-prod_id="<?php echo @$product->prod_id; ?>">

    												<div class="corner"> </div>
    												<div class="check"> </div>
    												<div class="tile-body">
    													<img class="img-b" src="<?php echo (@$product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
    													<img class="img-a" src="<?php echo (@$product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
    												</div>
    												<div class="tile-object">
    													<div class="name"> <?php echo @$product->public == 'N' ? '<span style="color:#ed6b75;"> Private </span> <br />' : ''; ?> <?php echo @$product->prod_no; ?> </div>
    												</div>

    											</div>

    										<?php
    											}
    										}
    										else
                                            { ?>
                                                <h3><cite> Selected images will show up here... </cite></h3>
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

									<!-- Edit -->
                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="View/Modify">
                                        <i class="fa fa-pencil font-dark"></i>
                                    </a>
									<!-- Send Sales Packaget -->
									<a href="<?php echo site_url('admin/campaigns/sales_package/send/index/'.$package->sales_package_id); ?>" class="tooltips" data-original-title="Send Sales Package">
                                        <i class="fa fa-envelope-o font-dark"></i>
                                    </a>
									<!-- Delete -->
                                    <a data-toggle="modal" href="#delete-<?php echo $package->sales_package_id; ?>" class="tooltips" data-original-title="Delete">
                                        <i class="fa fa-trash font-dark"></i>
                                    </a>

                                    <div class="btn-group hide" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
										<!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
                                            <li>
												<?php if ($package->sales_package_id == '2') { ?>
                                                <a href="#modal-select_designer_for_designer_recent_sales_package" data-toggle="modal">
												<?php } else { ?>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/step1/'.$package->sales_package_id); ?>">
												<?php } ?>
                                                    <i class="icon-pencil"></i> View/Modify </a>
                                            </li>
											<?php if ($package->sales_package_items != '') { ?>
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/send/index/'.$package->sales_package_id); ?>">
                                                    <i class="icon-paper-plane"></i> Send </a>
                                            </li>
												<?php if ($package->set_as_default !== '1' && $package->sales_package_id !== '2') { ?>
                                            <li class="hide">
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/set_as_default/index/'.$package->sales_package_id); ?>">
                                                    <i class="icon-shield"></i> Set As Default </a>
                                            </li>
												<?php } ?>
											<?php } ?>
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
												<a href="#modal_create_sales_package" data-toggle="modal" data-backdrop="static" data-keyboard="false">
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
									$i++;
								}
							} ?>

                        </tbody>
                    </table>

					</form>
					<!-- End FORM =======================================================================-->
					<!-- END FORM-->

					<!-- CONFIRM BULK DELETE ACTION -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-del" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Delete!</h4>
								</div>
								<div class="modal-body"> Delete (multiple) items? <br /> This cannot be undone! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="javascript:$('#form-sales_package_list_bulk_action').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- CONFIRM BULK ACTION -->
					<div class="modal fade bs-modal-sm" id="nocando-default_sales_pacakge" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Notice!</h4>
								</div>
								<div class="modal-body"> DEFAULT sales pacakge. <br /> Unable to delete! <br /><br /> Please set a different sales package as default before deleting this sales pacakge. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
