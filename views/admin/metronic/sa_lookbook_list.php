					<?php
					// let's set the role for sales user my account
					$pre_link =
						@$role == 'sales'
						? 'my_account/sales'
						: 'admin/campaigns'
					;

					if (
						$this->webspace_details->options['site_type'] == 'hub_site'
						&& @$role != 'sales'
					)
					{ ?>

					<div class="table-toolbar">

						<div class="row">

							<div class="col-lg-3 col-md-4">
								<select class="bs-select form-control" id="filter_by_designer_select" name="des_slug" data-live-search="true" data-size="5" data-show-subtext="true">
									<option class="option-placeholder" value="">Select Designer...</option>
									<option value="all">All Lookbook</option>
									<?php
									if (@$designers)
									{
										foreach ($designers as $designer)
										{ ?>

									<option value="<?php echo $designer->url_structure; ?>" data-subtext="<em></em>" data-des_slug="<?php echo $designer->url_structure; ?>" data-des_id="<?php echo $designer->des_id; ?>" <?php echo $designer->url_structure === @$des_slug ? 'selected="selected"' : ''; ?>>
										<?php echo ucwords(strtolower($designer->designer)); ?>
									</option>

											<?php
										}
									} ?>
								</select>
							</div>
							<button class="apply_filer_by_designer btn dark hidden-sm hidden-xs" data-page_param="<?php echo $this->uri->segment(3); ?>"> Filter </button>

						</div>
						<button class="apply_filer_by_designer btn dark btn-block margin-top-10 hidden-lg hidden-md" data-page_param="<?php echo $this->uri->segment(3); ?>"> Filter </button>

					</div>

						<?php
					} ?>

					<!-- FORM =======================================================================-->
					<?php echo form_open(
						$pre_link.'/lookbook/bulk_actions',
						array(
							'class'=>'form-horizontal',
							'id'=>'form-lookbook_list_bulk_action'
						)
					); ?>

					<?php
					/***********
					 * Noification area
					 */
					?>
					<div class="notifications">
						<?php if ($this->session->flashdata('success') == 'send_product_clicks') { ?>
						<div class="alert alert-success ">
							<button class="close" data-close="alert"></button> Lookbook successfully sent
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'add') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> New Lookbook CREATED!
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'edit') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Lookbook information updated.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success') == 'delete') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Lookbook permanently removed from records.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'no_input_post') { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> An error occured with posting data. Please try again.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> An error occured. Please try again.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'session_expired') { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> Session has expired. Please try again.
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
                            <li class="<?php echo $this->uri->uri_string() == $pre_link.'/lookbook' ? 'active' : ''; ?>">
                                <a href="<?php echo site_url($pre_link.'/lookbook'); ?>">
                                    Lookbooks
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url($pre_link.'/lookbook/create'); ?>">
                                    Create New Lookbook <i class="fa fa-plus"></i>
                                </a>
                            </li>
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
								<select class="bs-select form-control bs-select" id="bulk_actions_select" name="bulk_action" disabled data-show-subtext="true">
									<option value="" selected="selected">Bulk Actions</option>
									<option value="del">Permanently Delete</option>
									<option value="send_to_current_user" disabled data-subtext="(not avaialable)">Send to Existing User/s</option>
									<option value="send_to_new_user" disabled data-subtext="(not avaialable)">Send to New Users</option>
									<option value="send_to_all_suers" disabled data-subtext="(not avaialable)">Send to All Users</option>
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

                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-lookbook">
                        <thead>
                            <tr>
                                <th class="hidden-xs hidden-sm"> <!-- counter --> </th>
                                <th class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-lookbook .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th> Lookbook Name </th>
                                <th> Items </th>
								<th> Author </th>
								<th> Designer </th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

							<?php
							if ($lookbooks)
							{
								$i = 1;
								foreach ($lookbooks as $lookbook)
								{
									$edit_link = site_url($pre_link.'/lookbook/modify/index/'.$lookbook->lookbook_id);

									$options = json_decode($lookbook->options, TRUE);
									?>

                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs hidden-sm">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $lookbook->lookbook_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td>
									<a class="" href="<?php echo $edit_link; ?>">
										<?php echo $lookbook->lookbook_name; ?>
									</a>
								</td>
                                <td>

                                    <?php
    								/***********
    								 * Selected Items Thumbs
    								 */
    								?>
									<div class="thumb-tiles sales-package clearfix">

										<?php
										if ($lookbook->items)
										{
                                            $items = json_decode($lookbook->items, TRUE);
											foreach ($items as $item => $options)
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
									<?php if ($lookbook->user_id == '1' OR $lookbook->user_role == 'admin') { ?>
									<small class="text-info"> <cite> admin </cite></small>
									<?php } else { ?>
                                    <?php echo ucwords(strtolower($lookbook->user_name)); ?> - <small class="text-info"> <cite> sales </cite></small>
									<?php } ?>
                                </td>
								<td class="hidden-xs hidden-sm">
									<?php echo $lookbook->designer != 'mixed' ? $this->designers_list->get_des_name(array('designer.url_structure'=>$lookbook->designer)) : 'Mixed Designers'; ?>
                                </td>
                                <td class="dropdown-wrap dropdown-fix">

									<!-- Edit -->
                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="View/Modify">
                                        <i class="fa fa-pencil font-dark"></i>
                                    </a>
									<!-- Send Lookbook -->
									<a href="<?php echo site_url($pre_link.'/lookbook/send/index/'.$lookbook->lookbook_id); ?>" class="tooltips" data-original-title="Send Lookbook">
                                        <i class="fa fa-envelope-o font-dark"></i>
                                    </a>
									<!-- Delete -->
                                    <a data-toggle="modal" href="#delete-<?php echo $lookbook->lookbook_id; ?>" class="tooltips" data-original-title="Delete">
                                        <i class="fa fa-trash font-dark"></i>
                                    </a>

									<!-- DELETE ITEM -->
									<div class="modal fade bs-modal-sm" id="delete-<?php echo $lookbook->lookbook_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Warning!</h4>
												</div>
												<div class="modal-body"> DELETE item? <br /> This cannot be undone! </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo site_url($pre_link.'/lookbook/delete/index/'.$lookbook->lookbook_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
							}
							else
							{ ?>

							<tr class="odd gradeX">
								<td colspan="7">No recods found.</td>
							</tr>

								<?php
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
									<a href="javascript:$('#form-lookbook_list_bulk_action').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- CONFIRM BULK SEND TO EXISTING USER ACTION -->
					<div class="modal fade bs-modal-md" id="confirm_bulk_actions-send_to_current_user" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Send To Exiting User</h4>
								</div>
								<div class="modal-body">
									<?php $this->load->view('admin/metronic/sa_send_to_current_user'); ?>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="javascript:$('#form-lookbook_list_bulk_action').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
