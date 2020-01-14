					<?php if (
						$this->webspace_details->options['site_type'] == 'hub_site'
						&& @$role != 'sales'
					)
					{ ?>

					<div class="table-toolbar">

						<div class="row">

							<div class="col-lg-3 col-md-4">
								<select class="bs-select form-control" id="filter_by_designer_select" name="des_slug" data-live-search="true" data-size="5" data-show-subtext="true">
									<option class="option-placeholder" value="">Select Designer...</option>
									<option value="all">All Designers</option>
									<?php if ($this->webspace_details->options['site_type'] == 'hub_site') { ?>
									<option value="<?php echo $this->webspace_details->slug; ?>" data-subtext="<em>Mixed Designers</em>" data-des_slug="<?php echo $this->webspace_details->slug; ?>" data-des_id="<?php echo $this->webspace_details->id; ?>" <?php echo $this->webspace_details->slug === @$des_slug ? 'selected="selected"' : ''; ?>>
										<?php echo $this->webspace_details->name; ?>
									</options>
									<?php } ?>
									<?php
									if (@$designers)
									{
										foreach ($designers as $designer)
										{
											if ($this->webspace_details->slug != $designer->url_structure)
											{ ?>

									<option value="<?php echo $designer->url_structure; ?>" data-subtext="<em></em>" data-des_slug="<?php echo $designer->url_structure; ?>" data-des_id="<?php echo $designer->des_id; ?>" <?php echo $designer->url_structure === @$des_slug ? 'selected="selected"' : ''; ?>>
										<?php echo ucwords(strtolower($designer->designer)); ?>
									</option>

												<?php
											}
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

					<!-- BEGIN FORM-->
					<!-- FORM =======================================================================-->
					<?php
					$url_pre = @$role == 'sales' ? 'my_account/sales' : 'admin';

					echo form_open(
						$url_pre.'/purchase_orders/bulk_actions',
						array(
							'class'=>'form-horizontal',
							'id'=>'form-purchase_orders_bulk_actions'
						)
					);

					/*********
					 * Notification area
					 */
					?>
					<div class="notifications">
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
							<li class="<?php echo strpos( $this->uri->uri_string(), 'purchase_orders/all') === FALSE ? '' : 'active'; ?>">
                                <a href="<?php echo site_url('admin/purchase_orders/all'); ?>">
                                    All Purchase Orders
                                </a>
                            </li>
							<li class="<?php echo $this->uri->segment(3) == 'onorder' ? 'active' : ''; ?>">
								<a href="javascript:;" class="tooltips" data-original-title="Currently under construction">
									Pending PO
								</a>
							</li>
							<li class="<?php echo $this->uri->segment(3) == 'onorder' ? 'active' : ''; ?>">
								<a href="javascript:;" class="tooltips" data-original-title="Currently under construction">
									Completed PO
								</a>
							</li>
                            <?php
                            // available only on hub sites for now
                            if ($this->webspace_details->options['site_type'] == 'hub_site')
                            { ?>
                            <li>
                                <a href="<?php echo site_url($url_pre.'/purchase_orders/create'); ?>">
                                    Add New Purchase Order <i class="fa fa-plus"></i>
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

                        <div class="row">

							<div class="col-lg-3 col-md-4">
								<select class="bs-select form-control" id="bulk_actions_select" name="bulk_action" disabled>
									<option value="">Bulk Actions</option>
									<!--<option value="pe">Set as Pending</option>-->
									<option value="co">Set selected PO's as Complete</option>
									<option value="ca">Calcal Selected PO's</option>
									<!--
									<option value="ho">Set as On Hold</option>
									<option value="it">Set as In-Transit</option>
									<option value="del">Permanently Delete</option>
									-->
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
                    <?php if ( ! @$search) { ?>
                    <div class="row margin-bottom-10">
                        <div class="col-md-12 text-justify pull-right">
                            <span style="<?php echo $this->pagination->create_links() ? 'position:relative;top:15px;' : ''; ?>">
                                <?php if ($count_all == 0) { ?>
                                Showing 0 records
                                <?php } else { ?>
                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
                                <?php } ?>
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
                                <th style="width:80px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

							<?php
							if ($orders)
							{
								$i = 1;
								foreach ($orders as $order)
								{
									$edit_link = site_url($url_pre.'/purchase_orders/details/index/'.$order->po_id);
                                    ?>

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
                                <td>
									<a href="<?php echo $edit_link; ?>">
										<?php
										$po_number = $order->po_number;
										for($c = strlen($po_number);$c < 6;$c++)
										{
											$po_number = '0'.$po_number;
										}
										echo $po_number;
										?>
									</a>
									<a href="<?php echo $edit_link; ?>" class="hidden_first_edit_link_" style="font-size:0.7em;display:inline-block;">
                                        <cite>view details</cite>
                                    </a>
								</td>
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
									if (count($items) > 1) echo ' <a href="'.$edit_link.'"><i class="fa fa-plus text-success tooltips" data-original-title="...more items"></i></a>';
									?>
								</td>
                                <td> <?php echo $order->store_name; ?> </td>
                                <td> <?php echo $order->designer; ?> </td>
                                <td> <?php echo $order->vendor_code; ?> </td>
                                <td>
									<?php
									switch ($order->status)
									{
										case '0':
											$label = 'info';
											$text = 'Pending';
										break;
										case '4':
											$label = 'info';
											$text = 'In Transit';
										break;
										case '5':
											$label = 'success';
											$text = 'Complete';
										break;
										case '6':
											$label = 'danger';
											$text = 'On Hold';
										break;
                                        case '7':
											$label = 'warning';
											$text = 'Cancelled';
										break;
										case '1':
										case '2':
										case '3':
										default:
											$label = 'info';
											$text = 'Vendor Action';
									}
									?>
                                    <span class="label label-sm label-<?php echo $label; ?>"> <?php echo $text; ?> </span>
                                </td>
                                <td class="dropdown-wrap dropdown-fix">

									<!-- Close PO -->
                                    <a data-toggle="modal" href="#complete-<?php echo $order->po_id; ?>" class="tooltips" data-original-title="Close PO">
                                        <i class="fa fa-close"></i>
                                    </a>
									<!-- Cancel PO -->
                                    <a data-toggle="modal" href="#cancel-<?php echo $order->po_id; ?>" class="tooltips" data-original-title="Cancel PO">
                                        <i class="fa fa-ban"></i>
                                    </a>

                                    <div class="btn-group hide" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
										<!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
											<?php if ($order->status != '5')
											{ ?>
                                            <li>
                                                <a data-toggle="modal" href="#pending-<?php echo $order->po_id; ?>">
                                                    <i class="fa fa-<?php echo in_array($order->status, array('0','1','2','3','4')) ? 'check': 'ellipsis-h'; ?>"></i> Pending </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#on_hold-<?php echo $order->po_id; ?>">
                                                    <i class="fa fa-<?php echo $order->status == '4' ? 'check': 'ellipsis-h'; ?>"></i> In Transit </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#complete-<?php echo $order->po_id; ?>">
                                                    <i class="fa fa-<?php echo $order->status == '5' ? 'check': 'ellipsis-h'; ?>"></i> Complete </a>
                                            </li>
											<li>
                                                <a data-toggle="modal" href="#on_hold-<?php echo $order->po_id; ?>">
                                                    <i class="fa fa-<?php echo $order->status == '6' ? 'check': 'ellipsis-h'; ?>"></i> On Hold </a>
                                            </li>
											<li>
                                                <a data-toggle="modal" href="#cancel-<?php echo $order->po_id; ?>">
                                                    <i class="fa fa-<?php echo $order->status == '7' ? 'check': 'ellipsis-h'; ?>"></i> Cancel </a>
                                            </li>
												<?php
											} ?>
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
													<a href="<?php echo $url_pre.'/purchase_orders/status/update/'.$order->po_id.'/0'; ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<!-- IN-TRANSIT -->
									<div class="modal fade bs-modal-sm" id="on_hold-<?php echo $order->po_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Update Order Info</h4>
												</div>
												<div class="modal-body"> Set order as IN-TRANSIT? </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo $url_pre.'/purchase_orders/status/update/'.$order->po_id.'/4'; ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
													<a href="<?php echo $url_pre.'/purchase_orders/status/update/'.$order->po_id.'/5'; ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
													<a href="<?php echo $url_pre.'/purchase_orders/status/update/'.$order->po_id.'/6'; ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<!-- CANCELLED -->
									<div class="modal fade bs-modal-sm" id="cancel-<?php echo $order->po_id?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title">Update Order Info</h4>
												</div>
												<div class="modal-body"> Set order as CANCELLED? </div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<a href="<?php echo $url_pre.'/purchase_orders/status/update/'.$order->po_id.'/7'; ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
													<a href="<?php echo $url_pre.'/purchase_orders/delete/index/'.$order->po_id; ?>" type="button" class="btn green mt-ladda-btn ladda-button hide" data-style="expand-left">
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
