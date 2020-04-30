					<div class="m-grid page-file-wrapper" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
						<div class="m-grid-row">

							<style>
								.filter-options .bootstrap-select.btn-group .dropdown-toggle .filter-option {
									font-size: 0.8em;
								}
								.filter-options .mt-radio,
								.filter-options .mt-checkbox {
									margin-bottom: 5px;
									font-size: 11px;
									padding-left: 25px;
								}
								.filter-options .mt-radio > span,
								.filter-options .mt-checkbox > span {
									height: 14px;
									width: 14px;
								}
								.filter-options .mt-radio > span::after {
									left: 3px;
									top: 3px;
								}
								.filter-options .mt-checkbox > span::after {
									left: 3px;
									top: 0px;
								}
							</style>

							<div class="m-grid-col m-grid-col-md-2 filter-options" style="padding-right:15px;font-size:0.8em;">

								<h4>Filters</h4>

								<div class="form-group <?php echo @$role == 'sales' ? 'hide' : ''; ?>">
                                    <label>By Listing</label>
                                    <select class="bs-select form-control filter-options-field filter_by_listing_select input-sm" name="page_param" <?php echo $search ? 'disabled' : ''; ?>>
                                        <option value="all">
											All Orders
										</option>
										<?php if (@$this->webspace_details->slug != 'tempoparis')
										{ ?>
                                        <option value="ws" <?php echo strpos($this->uri->uri_string(), 'ws') !== FALSE ? 'selected="selected"' : ''; ?>>
											Wholesale Orders</option>
                                        <option value="cs" <?php echo strpos($this->uri->uri_string(), 'cs') !== FALSE ? 'selected="selected"' : ''; ?>>
											Retail Orders</option>
											<?php
										} ?>
                                    </select>
                                </div>

								<?php if ($this->webspace_details->options['site_type'] == 'hub_site')
								{ ?>

								<div class="form-group <?php echo @$role == 'sales' ? 'hide' : ''; ?>">
                                    <label>By Designer</label>
									<select class="bs-select form-control filter-options-field filter_by_designer_select input-sm" name="des_slug" data-live-search="true" data-size="5" data-show-subtext="true" <?php echo $search ? 'disabled' : ''; ?>>
										<option value="all">
											All Desginers
										</option>
										<?php if ($this->webspace_details->options['site_type'] == 'hub_site') { ?>
										<option value="<?php echo $this->webspace_details->slug; ?>" data-subtext="<em>Mixed Designers Order</em>" data-des_slug="<?php echo $this->webspace_details->slug; ?>" data-des_id="<?php echo $this->webspace_details->id; ?>" <?php echo $this->webspace_details->slug === @$des_slug ? 'selected="selected"' : ''; ?>>
											<?php echo $this->webspace_details->name; ?>
										</options>
										<?php } ?>
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

									<?php
								} ?>

								<div class="form-group">
									<label>By Date Range<br />From Date</label>
									<div class="input-group date date-picker from_date margin-bottom-5" data-date-format="yyyy-mm-dd">
										<input type="text" class="form-control date-date-picker input-sm" name="from_date" value="<?php echo @$from_date; ?>" <?php echo $search ? 'disabled' : ''; ?> />
										<span class="input-group-btn">
											<button class="btn btn-sm default" type="button" <?php echo $search ? 'disabled' : ''; ?>>
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
									<!-- /input-group -->

									<label>To Date</label>
									<div class="input-group date date-picker to_date margin-bottom-5" data-date-format="yyyy-mm-dd">
										<input type="text" class="form-control date-date-picker input-sm" name="to_date" value="<?php echo @$to_date; ?>" <?php echo $search ? 'disabled' : ''; ?> />
										<span class="input-group-btn">
											<button class="btn btn-sm default" type="button" <?php echo $search ? 'disabled' : ''; ?>>
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
									<!-- /input-group -->

									<a href="<?php echo site_url($this->uri->uri_string()); ?>">
										<cite class="">Remove Date Ranges</cite>
									</a>
								</div>

								<!--
								<div class="form-group hide">
                                    <label>
										Filter By Status &nbsp;
										<?php
										if (@$status)
										{
											$uri_array = $this->uri->segment_array();
											array_pop($uri_array);
											?>
										<a href="<?php echo site_url(implode('/', $uri_array)); ?>">
											<cite class="small">reset status to all</cite>
										</a>
											<?php
										} ?>
									</label>
                                    <div class="mt-radio-list" style="padding:0px;">
										<label class="mt-radio mt-radio-outline"> Pending
                                            <input type="radio" class="filter-options-field" value="pending" name="status" <?php echo @$status == 'pending' ? 'checked="checked"' : ''; ?> />
                                            <span></span>
                                        </label>
										<label class="mt-radio mt-radio-outline"> Complete
                                            <input type="radio" class="filter-options-field" value="complete" name="status" <?php echo @$status == 'complete' ? 'checked="checked"' : ''; ?> />
                                            <span></span>
                                        </label>
                                        <label class="mt-radio mt-radio-outline"> Cancelled
                                            <input type="radio" class="filter-options-field" value="cancelled" name="status" <?php echo @$status == 'cancelled' ? 'checked="checked"' : ''; ?>  />
                                            <span></span>
                                        </label>
										<label class="mt-radio mt-radio-outline"> Returned
                                            <input type="radio" class="filter-options-field" value="returned" name="status" <?php echo @$status == 'returned' ? 'checked="checked"' : ''; ?>  />
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

								<label class="hide">
									<a href="<?php echo site_url('admin/orders'); ?>">
										<cite class="">Reset to All Orders</cite>
									</a>
								</label>
								-->

								<hr style="margin:5px 0 15px;" />

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open(
									'admin/orders/search',
									array(
										'id'=>'form-orders_search'
									)
								); ?>

								<div class="form-group">
                                    <label>Search Order# or<br />Customer/Store Name</label>
                                    <input type="text" class="form-control" name="search_string" placeholder="Enter keywords..." />
								</div>

								<button class="btn dark btn-block uppercase bold" type="submit">Search</button>

								</form>
								<!-- End FORM =======================================================================-->
								<!-- END FORM-->

								<cite class="help-block small">Searches entire record</cite>
							</div>

							<div class="m-grid-col m-grid-col-md-10">

								<?php if (@$search) { ?>
		                        <h1><small><em>Search results for:</em></small> "<?php echo $search_string; ?>"</h1>
		                        <br />
		                        <?php } ?>

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open(
			                        $this->config->slash_item('admin_folder').'orders/bulk_actions',
			                        array(
			                            'class'=>'form-horizontal',
			                            'id'=>'form-orders_bulk_actions'
			                        )
			                    ); ?>

								<input type="hidden" name="page" value="<?php echo @$page; ?>" />
								<input type="hidden" name="status" value="<?php echo @$status; ?>" />

			                    <?php
			                    /***********
			                     * Noification area
			                     */
			                    ?>
								<div class="notifications">
									<?php if ($this->session->flashdata('success') == 'add') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> New Order ADDED!
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('success') == 'edit') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> Order information updated.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('success') == 'delete') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> Order permanently removed from records.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('success') == 'order_details_sent') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> Order details sent via email.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
									<div class="alert alert-danger auto-remove">
										<button class="close" data-close="alert"></button> An error occured. Please try again.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'error_sending_order_details') { ?>
									<div class="alert alert-danger auto-remove">
										<button class="close" data-close="alert"></button> There was an error sending sales pacakge.
									</div>
									<?php } ?>
			                    </div>

			                    <div class="table-toolbar">

									<!--
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

			                        <ul class="nav nav-tabs hide">
			                            <li class="<?php echo $this->uri->uri_string() == 'admin/orders/all' ? 'active' : ''; ?>">
			                                <a href="<?php echo site_url('admin/orders/all'); ?>">
			                                    <?php echo $this->uri->uri_string() != 'admin/orders/all' ? 'Show' : ''; ?> All Orders
			                                </a>
			                            </li>
										<?php if ($this->webspace_details->slug !== 'tempoparis') { ?>
			                            <li class="<?php echo $this->uri->segment(3) == 'wholesale' ? 'active' : ''; ?>">
			                                <a href="<?php echo site_url('admin/orders/wholesale'); ?>">
			                                    <?php echo $this->uri->segment(3) != 'wholesale' ? 'Show' : ''; ?> Wholesale Orders
			                                </a>
			                            </li>
										<li class="<?php echo $this->uri->segment(3) == 'retail' ? 'active' : ''; ?>">
			                                <a href="<?php echo site_url('admin/orders/retail'); ?>">
			                                    <?php echo $this->uri->segment(3) != 'retail' ? 'Show' : ''; ?> Retail Orders
			                                </a>
			                            </li>
										<?php } ?>
			                        </ul>

			                        <br />
									-->

			                        <div class="row">

										<div class="col-lg-3 col-md-4">
											<select class="bs-select form-control" id="bulk_actions_select" name="bulk_action" disabled>
												<option value="" selected="selected">Bulk Actions</option>
												<option class="hide" value="ho">Set as On Hold</option>
												<?php if ($status == 'new_orders') { ?>
												<option class="" value="ac">Acknowledge Orders</option>
												<option class="" value="ca">Cancel Orders</option>
												<?php } ?>
												<?php if ($status == 'shipment_pending') { ?>
												<option class="" value="co">Set as Complete</option>
												<option class="" value="ca">Cancel Orders</option>
												<?php } ?>
												<?php if ($this->webspace_details->options['site_type'] == 'hub_site_') { ?>
												<option class="" value="del">Permanently Delete</option>
												<?php } ?>
											</select>
										</div>
										<button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

									</div>
									<button class="btn green btn-block margin-top-10 hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

			                    </div>

								<?php
			                    /***********
			                     * Top Pagination
			                     */
			                    ?>
			                    <?php if ( ! $search) { ?>
			                    <div class="row margin-bottom-10">
			                        <div class="col-md-12 text-justify pull-right">
			                            <span style="<?php echo $this->pagination->create_links() ? 'position:relative;top:15px;' : ''; ?>">
			                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
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
								 * shows even on overflow
								 */
								?>
								<style>
									.dropdown-fix {
										position: relative;
									}
								</style>
			                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-orders_" data-orders_count="<?php echo $this->orders_list->row_count; ?>">
			                        <thead>
			                            <tr>
			                                <th class="hidden-xs hidden-sm" style="width:30px;"> <!-- counter --> </th>
			                                <th class="text-center" style="width:30px">
			                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
			                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-orders_ .checkboxes" />
			                                        <span></span>
			                                    </label>
			                                </th>
			                                <th style="width:90px;"> Order # </th>
			                                <th style="width:70px;"> Order Date </th>
			                                <th> Items </th>
			                                <th style="width:40px;"> Order<br />Qty </th>
			                                <th style="width:75px;"> Order<br />Amount </th>
			                                <th> Customer </th>
											<th style="width:130px;"> Designer </th>
			                                <th style="width:40px;"> Role </th>
											<th class="hide" style="width:80px;"> Ref SO# </th>
			                                <th style="width:70px;"> Actions </th>
			                            </tr>
			                        </thead>
			                        <tbody>

										<?php
										if ($orders)
										{
											$i = 1;
											foreach ($orders as $order)
											{
												$edit_link = site_url('admin/orders/details/index/'.$order->order_id);

												// for wholesale only site like tempoparis, show only wholesale orders
												// for now, we use this condition to remove consuemr orders
												//if ($order->store_name)
												//{
												?>

			                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
											<!-- # -->
			                                <td class="hidden-xs hidden-sm">
			                                    <?php echo $i; ?>
			                                </td>
											<!-- checkboxes -->
			                                <td class="text-center">
			                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
			                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $order->order_id; ?>" />
			                                        <span></span>
			                                    </label>
			                                </td>
											<!-- Order# -->
			                                <td>
												<a href="<?php echo $edit_link; ?>">
													<?php echo $order->order_id.'-'.strtoupper(substr(($order->designer_group == 'Mixed Designers' ? 'Shop 7th Avenue' : $order->designer_group),0,3)); ?>
												</a>
											</td>
											<!-- Date -->
			                                <td>
												<?php
												// using order_date timestamp
												$date = str_replace('-', '',str_replace(',',' ',$order->date_ordered));
												$date = @strtotime($date);
												//$date = @date('d-m-Y H:i',$date);
												$date = @date('Y-m-d',$date);
												//echo $date;
												echo date('Y-m-d',$order->order_date);
												?>
											</td>
											<!-- Items -->
			                                <td>
												<?php
												echo $order->prod_no;
												if ($order->number_of_orders > 1) echo ' <i class="fa fa-plus text-success tooltips" data-original-title="...more items"></i>';
												?>
											</td>
											<!-- Order Qty -->
			                                <td class="text-center"> <?php echo $order->order_qty; ?> </td>
											<!-- Purchase Amount -->
			                                <td class="text-right"> <?php echo '$ '.number_format($order->order_amount, 2); ?> </td>
											<!-- Customer Info -->
			                                <td>
												<?php
												if ($order->store_name)
												{
													echo $order->store_name;
													echo '<br /><small><cite>('.ucwords(strtolower($order->firstname.' '.$order->lastname)).')</cite></small>';
												}
												else echo ucwords(strtolower($order->firstname.' '.$order->lastname));
												?>
											</td>
											<!-- Designer Group -->
			                                <td> <?php echo trim($order->designer_group); ?> </td>
											<!-- Role -->
			                                <td class="text-center"> <small><cite><?php echo $order->c == 'guest' ? 'cs' : $order->c; ?></cite></small> </td>
											<!-- Ref SO# -->
			                                <td class="hide"> <?php echo @$order->sales_order_number; ?> </td>
											<!-- Status --
			                                <td>
												<?php
												if ($order->remarks != '0' && $order->remarks != '')
												{
													$label = 'warning';
													$text = 'Return';
												}
												else
												{
													switch ($order->status)
													{
														case '1':
															$label = 'success';
															$text = 'Complete';
														break;
														case '2':
															$label = 'danger';
															$text = 'On Hold';
														break;
														case '3':
															$label = 'danger';
															$text = 'Cancelled';
														break;
														case '4':
															$label = 'warning';
															$text = 'Returned';
														break;
														case '0':
														default:
															$label = 'info';
															$text = 'Pending';
													}
												}
												?>
			                                    <span class="label label-sm label-<?php echo $label; ?> small"> <?php echo $text; ?> </span>
			                                </td>
											<!-- Actions -->
			                                <td class="dropdown-wrap dropdown-fix" data-status="<?php echo $order->status; ?>">

												<!-- Edit -->
			                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="View Details">
			                                        <i class="fa fa-eye font-dark"></i>
			                                    </a>

			                                    <?php if ($order->status == '0') { // for new orders ?>
			                                    <!-- Acknowledge -->
			                                    <a data-toggle="modal" href="#acknowledge-<?php echo $order->order_id; ?>" class="tooltips" data-original-title="Acknowledge Order">
			                                        <i class="fa fa-check font-dark"></i>
			                                    </a>
												<?php } ?>

												<?php if ($order->status == '5') { ?>
												<!-- Complete -->
			                                    <a data-toggle="modal" href="#complete-<?php echo $order->order_id; ?>" class="tooltips" data-original-title="Complete Order">
			                                        <i class="fa fa-check font-dark"></i>
			                                    </a>
												<?php } ?>

												<?php if ($order->status == '0' OR $order->status == '5') { ?>
												<!-- Cancel -->
			                                    <a data-toggle="modal" href="#cancel-<?php echo $order->order_id; ?>" class="tooltips" data-original-title="Cancel Order">
			                                        <i class="fa fa-ban font-dark"></i>
			                                    </a>
												<?php } ?>

												<?php if ($order->status == '1') { ?>
												<!-- Return / Refund -->
			                                    <a data-toggle="modal" href="#return-<?php echo $order->order_id; ?>" class="tooltips" data-original-title="Refund Order">
			                                        <i class="fa fa-undo font-dark"></i>
			                                    </a>
												<!-- Store Credit -->
			                                    <a data-toggle="modal" href="#store_credit-<?php echo $order->order_id; ?>" class="tooltips" data-original-title="For Store Credit">
			                                        <i class="fa fa-credit-card font-dark"></i>
			                                    </a>
												<?php } ?>

												<?php if ($this->webspace_details->options['site_type'] == 'hub_site_' OR $order->status == '3') { ?>
			                                    <!-- Delete -->
			                                    <a data-toggle="modal" href="#delete-<?php echo $order->order_id; ?>" class="tooltips" data-original-title="Delete">
			                                        <i class="fa fa-trash font-dark"></i>
			                                    </a>
												<?php } ?>

												<!-- STORE CREDIT -->
												<div class="modal fade bs-modal-sm" id="store_credit-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Update Order Info</h4>
															</div>
															<div class="modal-body"> Acknowledge Order? </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url('admin/orders/status/index/'.$order->order_id.'/store_credit/'.$status); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												<!-- ACKNOWLEDEGE -->
												<div class="modal fade bs-modal-sm" id="acknowledge-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Update Order Info</h4>
															</div>
															<div class="modal-body"> Acknowledge Order? </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url('admin/orders/status/index/'.$order->order_id.'/acknowledge/'.$status); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												<!-- PENDING -->
												<div class="modal fade bs-modal-sm" id="pending-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Update Order Info</h4>
															</div>
															<div class="modal-body"> Set order as PENDING? </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$order->order_id.'/pending/'.$status); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												<!-- ON HOLD -->
												<div class="modal fade bs-modal-sm" id="on_hold-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Update Order Info</h4>
															</div>
															<div class="modal-body"> Set order as ON HOLD? </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$order->order_id.'/on_hold/'.$status); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												<!-- CANCEL -->
												<div class="modal fade bs-modal-sm" id="cancel-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Update Order Info</h4>
															</div>
															<div class="modal-body"> Cancel Order? </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$order->order_id.'/cancel/'.$status); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												<!-- COMPLETE -->
												<div class="modal fade bs-modal-sm" id="complete-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Update Order Info</h4>
															</div>
															<div class="modal-body"> Set order as COMPLETE and SHIPPED? </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$order->order_id.'/complete/'.$status); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												<!-- RETURN -->
												<div class="modal fade bs-modal-sm" id="return-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Update Order Info</h4>
															</div>
															<div class="modal-body"> Set order as RETURNED? </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$order->order_id.'/return/'.$status); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												<!-- ITEM DELETE -->
												<div class="modal fade bs-modal-sm" id="delete-<?php echo $order->order_id?>" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Warning!</h4>
															</div>
															<div class="modal-body"> DELETE order? <br /> This cannot be undone! </div>
															<div class="modal-footer">
																<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/delete/index/'.$order->order_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
												//}
											}
										}
										else
										{ ?>

										<tr><td colspan="13">No records found.</td></tr>

											<?php
										} ?>

			                        </tbody>
			                    </table>

								<?php
			                    /***********
			                     * Bottom Pagination
			                     */
			                    ?>
			                    <?php if ( ! $search) { ?>
			                    <div class="row margin-bottom-10">
			                        <div class="col-md-12 text-justify pull-right">
			                            <span>
			                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
			                            </span>
			                            <?php echo $this->pagination->create_links(); ?>
			                        </div>
			                    </div>
			                    <?php } ?>

								</form>
								<!-- End FORM =======================================================================-->
								<!-- END FORM-->
							</div>
						</div>
					</div>

					<!-- BULK PENDING -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-pe" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Pending!</h4>
								</div>
								<div class="modal-body"> Set multiple items as PENDING? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- BULK ON HOLD -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-ho" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">On Hold!</h4>
								</div>
								<div class="modal-body"> Set multiple items as ON HOLD? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- BULK CANCEL -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-ca" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Cancel!</h4>
								</div>
								<div class="modal-body">
									Set multiple items as CANCELLED? <br />
									<cite class="small">NOTE: only Pending orders will be cancelled.</cite>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- BULK ACKNOLEDGE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-ac" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Acknowledge!</h4>
								</div>
								<div class="modal-body">
									Acknowledge multiple items and set as SHIPMENT PENDING?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- BULK COMPLETE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-co" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Complete!</h4>
								</div>
								<div class="modal-body">
									Set multiple items as COMPLETE? <br />
									<cite class="small">NOTE: only Pending orders will be set to complete.</cite>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- BULK RETURN -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-re" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Return!</h4>
								</div>
								<div class="modal-body">
									Set multiple items as RETURNED? <br />
									<cite class="small">NOTE: only Completed orders will be set to returned.</cite>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- BULK DELETE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-del" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Delete!</h4>
								</div>
								<div class="modal-body"> Delete multiple items? <br /> This cannot be undone! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
