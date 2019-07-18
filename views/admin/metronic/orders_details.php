                    <!-- BEGIN PAGE CONTENT BODY -->
					<style>
					.img-absolute { position:absolute; }
					</style>

                    <div class="row ">
					
						<!-- BEGIN FORM-->
						<!-- FORM =======================================================================-->
						<!--<form class="form-horizontal form-row-seperated" action="#">-->
						<?php echo form_open($this->config->slash_item('admin_folder').'orders/details/index/'.$this->order_details->order_id, array('class'=>'form-horizontal', 'id'=>'form-orders_details')); ?>
						
                        <div class="col-md-12">
							<div class="portlet light portlet-fit portlet-datatable bordered">
								<div class="portlet-title">
								
									<?php
									/***********
									 * Noification area
									 */
									?>
									<?php if ($this->session->flashdata('success') == 'add') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> New Product ADDED! Continue edit new product now...
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('success') == 'edit') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> Order status updated...
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'database_update') { ?>
									<div class="alert alert-danger auto-remove">
										<button class="close" data-close="alert"></button> There was a problem updating database. Please contact your webmaster on this error...
									</div>
									<?php } ?>
									<?php if (validation_errors()) { ?>
									<div class="alert alert-danger auto-remove">
										<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
									</div>
									<?php } ?>
									
									<div class="caption">
										<i class="icon-settings font-dark"></i>
										<span class="caption-subject font-dark sbold uppercase"> Order #<?php echo $this->order_details->order_id; ?>
											<span class="hidden-xs">| <?php echo $this->order_details->order_date; ?> </span>
										</span>
									</div>
									<div class="actions">
										<div class="btn-group btn-group-devided">
											<a class="btn btn-secondary-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'orders'); ?>">
												<i class="fa fa-reply"></i> Back to order list</a>
											<?php
											if ($this->order_details->remarks != '0' && $this->order_details->remarks != '') $return = TRUE;
											else $return = FALSE;
											?>
											<label class="btn btn-transparent blue btn-outline btn-circle btn-sm <?php echo ( ! $return && $this->order_details->status == '0') ? 'active': 'tooltips'; ?>" <?php echo ( ! $return && $this->order_details->status == '0') ? '': 'data-toggle="modal" data-target="#modal-pending" data-container="body" data-original-title="Set as Pending"'; ?>>
												Pending</label>
											<label class="btn btn-transparent red btn-outline btn-circle btn-sm <?php echo ( ! $return && $this->order_details->status == '2') ? 'active': 'tooltips'; ?>" <?php echo ( ! $return && $this->order_details->status == '2') ? '': 'data-toggle="modal" data-target="#modal-on_hold" data-container="body" data-original-title="Set as On Hold"'; ?>>
												On Hold</label>
											<label class="btn btn-transparent green btn-outline btn-circle btn-sm <?php echo ( ! $return && $this->order_details->status == '1') ? 'active': 'tooltips'; ?>" <?php echo ( ! $return && $this->order_details->status == '1') ? '': 'data-toggle="modal" data-target="#modal-complete" data-container="body" data-original-title="Set as Complete"'; ?>>
												Complete</label>
										</div>
										<div class="btn-group">
											<a class="btn btn-warning btn-outline btn-circle <?php echo ($this->order_details->remarks != '0' && $this->order_details->remarks != '') ? 'active': ''; ?>" href="javascript:;" data-toggle="dropdown">
												<i class="fa fa-share"></i>
												<span class="hidden-xs"> Return </span>
												<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu pull-right">
												<li>
													<a data-toggle="modal" href="#modal-return_exchange"> 
														<i class="fa fa-<?php echo $this->order_details->remarks == '1' ? 'check': 'ellipsis-h'; ?>"></i> Return for exchange </a>
												</li>
												<li>
													<a data-toggle="modal" href="#modal-return_scredit"> 
														<i class="fa fa-<?php echo $this->order_details->remarks == '2' ? 'check': 'ellipsis-h'; ?>"></i> Return for store credit </a>
												</li>
												<li>
													<a data-toggle="modal" href="#modal-return_refund"> 
														<i class="fa fa-<?php echo $this->order_details->remarks == '3' ? 'check': 'ellipsis-h'; ?>"></i> Return for refund </a>
												</li>
												<li>
													<a data-toggle="modal" href="#modal-return_others"> 
														<i class="fa fa-<?php echo $this->order_details->remarks == '4' ? 'check': 'ellipsis-h'; ?>"></i> 
														Return for other reasons<br />
														<i class="fa fa-minus" style="color:white;"></i> <small><cite>(see comment box at bottom)</cite></small> </a>
												</li>
												<li class="divider"> </li>
												<li class="hide">
													<a href="javascript:;"> Print Invoices </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
									
								<div class="portlet-body">
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<div class="portlet yellow-crusta box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Order Details </div>
													<div class="actions hide">
														<a href="javascript:;" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row static-info">
														<div class="col-md-5 name"> Order #: </div>
														<div class="col-md-7 value"> <?php echo $this->order_details->order_id; ?>
															<span class="label label-info label-sm"> Email confirmation was sent </span>
														</div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 name"> Order Date &amp; Time: </div>
														<div class="col-md-7 value"> <?php echo $this->order_details->order_date; ?> </div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 name"> Order Status: </div>
														<div class="col-md-7 value">
															<?php if ($this->order_details->remarks != '0' && $this->order_details->remarks != '') { ?>
															<span class="label label-warning"> Return </span>
															<?php } else { ?>
																<?php if ($this->order_details->status == '1') { ?>
																<span class="label label-success"> Closed </span>
																<?php } ?>
																<?php if ($this->order_details->status == '0') { ?>
																<span class="label label-info"> Pending </span>
																<?php } ?>
																<?php if ($this->order_details->status == '2') { ?>
																<span class="label label-danger"> On Hold </span>
																<?php } ?>
															<?php } ?>
														</div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 name"> Grand Total: </div>
														<div class="col-md-7 value"> <?php echo '$'.number_format($this->order_details->order_amount, 2); ?> </div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 name"> Payment Information: </div>
														<div class="col-md-7 value"> Credit Card </div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="portlet blue-hoki box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Customer Information </div>
													<div class="actions hide">
														<a href="javascript:;" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row static-info">
														<div class="col-md-5 name"> Customer Name: </div>
														<div class="col-md-7 value"> <?php echo $this->order_details->firstname.' '.$this->order_details->lastname; ?> </div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 name"> Email: </div>
														<div class="col-md-7 value"> <?php echo $this->order_details->email; ?> </div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 name"> State: </div>
														<div class="col-md-7 value"> <?php echo $this->order_details->ship_state; ?> </div>
													</div>
													<div class="row static-info">
														<div class="col-md-5 name"> Phone Number: </div>
														<div class="col-md-7 value"> <?php echo $this->order_details->telephone; ?> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<div class="portlet green-meadow box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Billing Address </div>
													<div class="actions hide">
														<a href="javascript:;" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row static-info">
														<div class="col-md-12 value"> <?php echo $this->order_details->firstname.' '.$this->order_details->lastname; ?>
															<br> <?php echo $this->order_details->ship_address1; ?>
															<?php echo $this->order_details->ship_address2 ? '<br>'.$this->order_details->ship_address2 : ''; ?>
															<br> <?php echo $this->order_details->ship_city; ?>
															<br> <?php echo $this->order_details->ship_zipcode.' '.$this->order_details->ship_state; ?>
															<br> <?php echo $this->order_details->ship_country; ?>
															<?php echo $this->order_details->telephone ? '<br >T: '.$this->order_details->telephone : ''; ?>
															<br> </div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="portlet red-sunglo box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Shipping Address </div>
													<div class="actions hide">
														<a href="javascript:;" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>
													</div>
												</div>
												<div class="portlet-body">
													<div class="row static-info">
														<div class="col-md-12 value"> <?php echo $this->order_details->firstname.' '.$this->order_details->lastname; ?>
															<br> <?php echo $this->order_details->ship_address1; ?>
															<?php echo $this->order_details->ship_address2 ? '<br>'.$this->order_details->ship_address2 : ''; ?>
															<br> <?php echo $this->order_details->ship_city; ?>
															<br> <?php echo $this->order_details->ship_zipcode.' '.$this->order_details->ship_state; ?>
															<br> <?php echo $this->order_details->ship_country; ?>
															<?php echo $this->order_details->telephone ? '<br >T: '.$this->order_details->telephone : ''; ?>
															<br> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="portlet grey-cascade box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Shopping Cart </div>
													<div class="actions hide">
														<a href="javascript:;" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>
													</div>
												</div>
												<div class="portlet-body">
												
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
														.thumb-tiles {
															position: relative;
															margin-right: -10px;
														}
														.thumb-tiles .thumb-tile {
															display: block;
															float: left;
															height: 135px;
															width: 90px !important;
															cursor: default;
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
													</style>

													<div class="table-responsive">
														<table class="table table-hover table-bordered table-striped">
															<thead>
																<tr>
																	<th class="hidden-xs hidden-sm"> <!-- counter --> </th>
																	<th> Image </th>
																	<th> Item Name </th> 
																	<th> Product No </th>
																	<th> Designer </th>
																	<th> Size </th>
																	<th> Color </th>
																	<th> Qty </th>
																	<th> Unit Price </th>
																	<th> Sub Total </th>
																</tr>
															</thead>
															<tbody>
															
																<?php 
																if ($this->order_details->items()) 
																{
																	$i = 1;
																	foreach ($this->order_details->items() as $item) 
																	{ ?>
																	
																<tr class="odd gradeX" onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
																	<td class="hidden-xs hidden-sm text-center">
																		<?php echo $i; ?>
																	</td>
																	<td class="text-center"> <!-- Images -->
																		<div class="thumb-tiles">
																			<div class="thumb-tile image bg-blue-hoki">
																				<div class="tile-body">
																					<img class="" src="<?php echo $this->config->item('PROD_IMG_URL').$item->image; ?>" alt=""> 
																				</div>
																				<div class="tile-object">
																					<div class="name"> <?php echo $item->prod_no; ?> </div>
																				</div>
																			</div>
																		</div>
																	</td>
																	<td> <?php echo $item->prod_name; ?> </td>
																	<td> <?php echo $item->prod_no; ?> </td>
																	<td> <?php echo $item->designer; ?> </td>
																	<td> <?php echo $item->size; ?> </td>
																	<td> <?php echo $item->color; ?> </td>
																	<td> <?php echo $item->qty; ?> </td>
																	<td> <?php echo '$'.number_format($item->unit_price, 2); ?> </td>
																	<td> <?php echo '$'.number_format($item->subtotal, 2); ?> </td>
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
													</div>
													
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6"> 
											<?php if ($this->order_details->remarks == '4') { ?>
											<div class="well well-sm">
												<p class="block">Comments:</p>
												<p>
													<?php echo $this->order_details->comments; ?>
												</p>
											</div>
											<?php } ?>
										</div>
										<div class="col-md-6">
											<div class="well">
												<div class="row static-info align-reverse">
													<div class="col-md-8 name"> Sub Total: </div>
													<div class="col-md-3 value"> $<?php echo number_format($this->order_details->order_amount, 2); ?> </div>
												</div>
												<div class="row static-info align-reverse">
													<div class="col-md-8 name"> Shipping: </div>
													<div class="col-md-3 value"> $<?php echo number_format($this->order_details->shipping_fee, 2); ?> </div>
												</div>
												<div class="row static-info align-reverse">
													<div class="col-md-8 name"> Grand Total: </div>
													<div class="col-md-3 value"> $<?php echo number_format(($this->order_details->order_amount + $this->order_details->shipping_fee), 2); ?> </div>
												</div>
												<!--
												<div class="row static-info align-reverse">
													<div class="col-md-8 name"> Total Paid: </div>
													<div class="col-md-3 value"> $1,260.00 </div>
												</div>
												<div class="row static-info align-reverse">
													<div class="col-md-8 name"> Total Refunded: </div>
													<div class="col-md-3 value"> $0.00 </div>
												</div>
												<div class="row static-info align-reverse">
													<div class="col-md-8 name"> Total Due: </div>
													<div class="col-md-3 value"> $1,124.50 </div>
												</div>
												-->
											</div>
										</div>
									</div>
								</div>
								
							</div>
                        </div>

						</form>
						<!-- End FORM =======================================================================-->
						<!-- END FORM-->
						
                    </div>
                    <!-- END PAGE CONTENT BODY -->
					
					<!-- PENDING ITEM -->
					<div class="modal fade bs-modal-sm" id="modal-pending" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Status Update</h4>
								</div>
								<div class="modal-body"> Set order staus to PENDING! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$this->order_details->order_id.'/pending'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
					
					<!-- ON HOLD ITEM -->
					<div class="modal fade bs-modal-sm" id="modal-on_hold" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Status Update</h4>
								</div>
								<div class="modal-body"> Set order staus to ON HOLD! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$this->order_details->order_id.'/on_hold'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
					
					<!-- COMPLETE ITEM -->
					<div class="modal fade bs-modal-sm" id="modal-complete" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Status Update</h4>
								</div>
								<div class="modal-body"> Set order staus to COMPLETE! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$this->order_details->order_id.'/complete'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
					
					<!-- RETURN FOR EXCHANGE ITEM -->
					<div class="modal fade bs-modal-sm" id="modal-return_exchange" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Return Item Remarks</h4>
								</div>
								<div class="modal-body"> Set order as "Items returned for EXCHANGE"! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/exchange'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
					
					<!-- RETURN FOR STORE CREDIT ITEM -->
					<div class="modal fade bs-modal-sm" id="modal-return_scredit" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Return Item Remarks</h4>
								</div>
								<div class="modal-body"> Set order as "Items returned for STORE CREDIT"! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/scredit'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
					
					<!-- RETURN FOR REFUND ITEM -->
					<div class="modal fade bs-modal-sm" id="modal-return_refund" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Return Item Remarks</h4>
								</div>
								<div class="modal-body"> Set order as "Items returned for REFUND"! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/refund'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
					
					<!-- RETURN FOR OTHER REASONS ITEM -->
					<div class="modal fade bs-modal-md" id="modal-return_others" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Return Item Remarks</h4>
								</div>
									<!-- FORM =======================================================================-->
									<?php echo form_open($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/others', array('class'=>'form-horizontal', 'id'=>'form-returns_others')); ?>
								<div class="modal-body"> 
									<div class="form-body">
										<div class="form-group">
											<div class="col-md-offset-2 col-md-10">
												Set order as "Items returned for OTHER REASONS"! 
											</div>
										</div>
									</div>
									<div class="form-body">
										<div class="form-group">
											<label class="col-lg-2 control-label">Comments:</label>
											<div class="col-lg-10">
												<textarea class="form-control" rows="5" name="comments"></textarea>
												<span class="help-block"> Remarks about other reasons for returning item </span>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
									</form>
									<!-- End FORM =======================================================================-->
									<!-- END FORM-->
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal --> 
					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
