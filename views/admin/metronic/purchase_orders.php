                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row ">
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

									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
                                        (
                                            $this->uri->segment(1) === 'sales'
                                            ? 'sales/purchase_orders/bulk_actions'
                                            : $this->config->slash_item('admin_folder').'purchase_orders/bulk_actions'
                                        ),
										array(
											'class'=>'form-horizontal',
											'id'=>'form-purchase_orders_bulk_actions'
										)
									); ?>

									<?php
									/*********
									 * Notification area
									 */
									?>
									<div>
										<?php if ($this->session->flashdata('success') == 'add') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> New Purshase Order ADDED!
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Purshase Order information updated.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'delete') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Purshase Order permanently removed from records.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'order_details_sent') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Purshase Order details sent via email.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> An error occured. Please try again.
										</div>
										<?php } ?>
									</div>

                                    <div class="table-toolbar">
                                        <div class="row ">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders/create') : site_url($this->config->slash_item('admin_folder').'purchase_orders/create'); ?>" class="btn sbold blue"> Create a New PO
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                        </div>
										<br />
                                        <div class="row">

											<div class="col-lg-3 col-md-4">
												<select class="bs-select form-control" id="bulk_actions_select" name="bulk_action" disabled>
													<option value="" selected="selected">Bulk Actions</option>
													<option value="pe">Set as Pending</option>
													<option value="ho">Set as On Hold</option>
													<option value="co">Set as Complete</option>
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
                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-orders" data-orders_count="<?php echo $this->purchase_orders_list->row_count; ?>">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs hidden-sm" style="width:30px"> <!-- counter --> </th>
                                                <th class="text-center" style="width:30px">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-orders .checkboxes" />
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th> PO<br />Number </th>
                                                <th> PO<br />Date </th>
                                                <th> Product<br />Items </th>
                                                <th> Store<br />Name </th>
                                                <th> Designer </th>
                                                <th> Vendor </th>
                                                <th style="width:100px;"> Status </th>
                                                <th style="width:100px;"> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
											if ($orders)
											{
												$i = 1;
												foreach ($orders as $order)
												{
                                                    $edit_link =
                                                        $this->uri->segment(1) === 'sales'
                                                        ? site_url('sales/purchase_orders/details/index/'.$order->po_id)
                                                        : site_url($this->config->slash_item('admin_folder').'purchase_orders/details/index/'.$order->po_id)
                                                    ; ?>

                                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                                <td class="hidden-xs hidden-sm">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="text-center">
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $order->po_id; ?>" />
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td> <?php echo $order->des_code.$order->po_number; ?> </td>
                                                <td>
													<?php
													$date = @date('Y-m-d', $order->po_date);
													echo $date;
													?>
												</td>
                                                <td>
													<?php
													$items = json_decode($order->items, TRUE);
													foreach ($items as $key => $val)
													{
														//echo $val['prod_no'];
                                                        echo $key;
														if (count($items) > 1) break;
													}
													?>
													<br />
                                                    <cite><?php echo count($items) > 1 ? '<i class="fa fa-plus text-success tooltips" data-original-title="...more items"></i>' : ''; ?> <small><a href="<?php echo $edit_link; ?>">View Details
													</a></small></cite>
												</td>
                                                <td> <?php echo $order->store_name; ?> </td>
                                                <td> <?php echo $order->designer; ?> </td>
                                                <td> <?php echo $order->vendor_code; ?> </td>
                                                <td>
													<?php
													switch ($order->status)
													{
														case '5':
															$label = 'success';
															$text = 'Complete';
														break;
                                                        case '2':
															$label = 'warning';
															$text = 'Cancelled';
														break;
														case '1':
															$label = 'danger';
															$text = 'On Hold';
														break;
														case '0':
														default:
															$label = 'info';
															$text = 'Pending';
													}
													?>
                                                    <span class="label label-sm label-<?php echo $label; ?>"> <?php echo $text; ?> </span>
                                                </td>
                                                <td class="dropdown-wrap dropdown-fix">
                                                    <div class="btn-group" >
                                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
														<!-- DOC: Remove "pull-right" class to default to left alignment -->
                                                        <ul class="dropdown-menu pull-right">
                                                            <li>
                                                                <a data-toggle="modal" href="#pending-<?php echo $order->po_id; ?>">
                                                                    <i class="fa fa-<?php echo $order->status == '0' ? 'check': 'ellipsis-h'; ?>"></i> Pending </a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="modal" href="#on_hold-<?php echo $order->po_id; ?>">
                                                                    <i class="fa fa-<?php echo $order->status == '1' ? 'check': 'ellipsis-h'; ?>"></i> On Hold </a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle="modal" href="#complete-<?php echo $order->po_id; ?>">
                                                                    <i class="fa fa-<?php echo $order->status == '5' ? 'check': 'ellipsis-h'; ?>"></i> Complete </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li>
                                                                <a href="<?php echo $edit_link; ?>">
                                                                    <i class="icon-pencil"></i> View Details </a>
                                                            </li>
                                                        </ul>
                                                    </div>
													<!-- PENDING -->
													<div class="modal fade bs-modal-sm" id="pending-<?php echo $order->po_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Update Order Info</h4>
																</div>
																<div class="modal-body"> Set order as PENDING? </div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders/status/update/'.$order->po_id.'/0') : site_url($this->config->slash_item('admin_folder').'purchase_orders/status/update/'.$order->po_id.'/0'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
													<div class="modal fade bs-modal-sm" id="on_hold-<?php echo $order->po_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Update Order Info</h4>
																</div>
																<div class="modal-body"> Set order as ON HOLD? </div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders/status/update/'.$order->po_id.'/1') : site_url($this->config->slash_item('admin_folder').'purchase_orders/status/update/'.$order->po_id.'/1'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
													<div class="modal fade bs-modal-sm" id="complete-<?php echo $order->po_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Update Order Info</h4>
																</div>
																<div class="modal-body"> Set order as COMPLETE? </div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders/status/update/'.$order->po_id.'/5') : site_url($this->config->slash_item('admin_folder').'purchase_orders/status/update/'.$order->po_id.'/5'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
													<div class="modal fade bs-modal-sm" id="delete-<?php echo $order->po_id?>" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Warning!</h4>
																</div>
																<div class="modal-body"> Deleting PO's is not an option at the moment. Please contact your administrator if it is necessary to delete a certain PO. </div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																	<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders/delete/index/'.$order->po_id) : site_url($this->config->slash_item('admin_folder').'purchase_orders/delete/index/'.$order->po_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button hide" data-style="expand-left">
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

								</div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
					</div>
                    <!-- END PAGE CONTENT BODY -->

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
									<button onclick="$('#form-purchase_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-purchase_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
								<div class="modal-body"> Set multiple items as COMPLETE? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-purchase_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<h4 class="modal-title">NOTICE!</h4>
								</div>
								<div class="modal-body"> Deleting PO's is not an option at the moment. Please contact your administrator if it is necessary to delete a certain PO. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-purchase_orders_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button hide" data-style="expand-left">
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
