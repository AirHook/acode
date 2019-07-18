                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">

                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> <?php echo $page_title; ?></span>
                                    </div>
									<div class="actions btn-set">
										<a class="btn btn-secondary-outline" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders') : site_url($this->config->slash_item('admin_folder').'sales_orders'); ?>">
											<i class="fa fa-reply"></i> Back to Sales Order list</a>
										<a class="btn blue" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/create') : site_url($this->config->slash_item('admin_folder').'sales_orders/create'); ?>">
											<i class="fa fa-plus"></i> Create New Sales Order </a>
									</div>
                                </div>

								<div class="portlet-body form">

									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
										(
                                            $this->uri->segment(1) === 'sales'
                                            ? 'sales/sales_orders/create'
                                            : $this->config->slash_item('admin_folder').'sales_orders/create'
                                        ),
										array(
											'class'=>'form-horizontal',
											'id'=>'form-sales_orders_create'
										)
									); ?>

										<div class="form-body">
											<?php
											/***********
											 * Noification area
											 */
											?>
											<div>
												<div class="alert alert-danger display-hide">
													<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
												<div class="alert alert-success display-hide">
													<button class="close" data-close="alert"></button> Your form validation is successful! </div>
												<?php if ($this->session->flashdata('success') == 'add') { ?>
												<div class="alert alert-success auto-remove">
													<button class="close" data-close="alert"></button> New Sales Order CREATED!
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('success') == 'edit') { ?>
												<div class="alert alert-success auto-remove">
													<button class="close" data-close="alert"></button> Sales Order information updated...
												</div>
												<?php } ?>
												<?php if (validation_errors()) { ?>
												<div class="alert alert-danger">
													<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
												</div>
												<?php } ?>
											</div>

											<div class="row">
												<div class="col-md-6 pull-right">
													<div class="form-group" data-site_section="<?php echo $this->uri->segment(1); ?>" data-object_data='{"sales_order_id":"<?php echo $this->sales_order_details->sales_order_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
														<label class="control-label col-md-3">Status</label>
														<div class="col-md-9">
															<div class="margin-bottom-10">
																<input id="option4" type="radio" name="status" value="4" class="make-switch switch-status" data-size="mini" data-on-text="<i class='icon-plus'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '4' ? 'checked' : ''; ?> />
																<label for="option4">Open/Pending</label>
															</div>
															<div class="margin-bottom-10">
																<input id="option3" type="radio" name="status" value="3" class="make-switch switch-status" data-size="mini" data-on-color="warning" data-on-text="<i class='icon-energy'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '3' ? 'checked' : ''; ?> />
																<label for="option3">Return</label>
															</div>
															<div class="margin-bottom-10">
																<input id="option2" type="radio" name="status" value="2" class="make-switch switch-status" data-size="mini" data-on-color="danger" data-on-text="<i class='icon-ban'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '2' ? 'checked' : ''; ?> />
																<label for="option2">On HOLD</label>
															</div>
															<div class="margin-bottom-10">
																<input id="option1" type="radio" name="status" value="1" class="make-switch switch-status" data-size="mini" data-on-color="success" data-on-text="<i class='icon-check'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '1' ? 'checked' : ''; ?> />
																<label for="option1">Complete/Delivery</label>
															</div>
															<cite class="help-block small"> Changing the PO Status will update the PO almost immediately.<br />Be sure you know what you are doing. </cite>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label col-md-3"> <span class="bold">Sales Order #:</span>
														</label>
														<div class="col-md-9">
															<input type="text" name="sales_order_number" data-required="1" class="form-control" value="<?php echo $this->sales_order_details->sales_order_number; ?>" readonly tabindex="-1" />
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3"> <span class="bold">Sales Order Date:</span>
														</label>
														<div class="col-md-9">
															<input type="text" id="sales_order_date" name="sales_order_date" data-required="1" class="form-control" value="<?php echo $this->sales_order_details->sales_order_date; ?>" readonly tabindex="-1" />
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="form-body">

											<div class="row">
												<div class="col-md-6">
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
																<div class="col-md-4 name"> Store Name: </div>
																<div class="col-md-8 value ci-store_name"> <?php echo $this->sales_order_details->store_name; ?> </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Customer Name: </div>
																<div class="col-md-8 value ci-customer_name">  <?php echo $this->sales_order_details->firstname.' '.$this->sales_order_details->lastname; ?>  </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Email: </div>
																<div class="col-md-8 value ci-email"> <?php echo $this->sales_order_details->email; ?> </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Phone Number: </div>
																<div class="col-md-8 value ci-telephone"> <?php echo $this->sales_order_details->telephone; ?> </div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="portlet yellow-crusta box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-cogs"></i>Misc. Information </div>
															<div class="actions hide">
																<a href="javascript:;" class="btn btn-default btn-sm">
																	<i class="fa fa-pencil"></i> Edit </a>
															</div>
														</div>
														<div class="portlet-body">
															<div class="row static-info">
																<div class="col-md-4 name"> Sales User: </div>
																<div class="col-md-8 value si-admin_sales_user"> <?php echo $this->sales_order_details->admin_sales_user.' '.$this->sales_order_details->admin_sales_lname; ?> <cite class="small"><?php echo $this->sales_order_details->admin_sales_email; ?></cite> </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Designer: </div>
																<div class="col-md-8 value si-designer"> <?php echo $this->sales_order_details->designer; ?> </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Vendor: </div>
																<div class="col-md-8 value si-vendor"> <?php echo $this->sales_order_details->vendor_code; ?> <cite class="small"><?php echo $this->sales_order_details->vendor_name; ?></cite> </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Shipmethod: </div>
																<div class="col-md-8 value si-courier"> <?php echo $this->sales_order_details->courier; ?> <cite class="small"><?php echo $this->sales_order_details->shipping_fee; ?></cite> </div>
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
																<div class="col-md-12 value ci-bill_to">
																	<?php
																	echo $this->sales_order_details->firstname.' '.$this->sales_order_details->lastname.'<br />'
																	.$this->sales_order_details->bill_address1.'<br />'
																	.($this->sales_order_details->bill_address2 ? $this->sales_order_details->bill_address2.'<br />' : '')
																	.$this->sales_order_details->bill_city.'<br />'
																	.$this->sales_order_details->bill_zipcode.' '.$this->sales_order_details->bill_state.'<br />'
																	.$this->sales_order_details->bill_country.'<br />';
																	?>
																</div>
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
																<div class="col-md-12 value ci-ship_to">
																	<?php
																	echo $this->sales_order_details->firstname.' '.$this->sales_order_details->lastname.'<br />'
																	.$this->sales_order_details->ship_address1.'<br />'
																	.($this->sales_order_details->ship_address2 ? $this->sales_order_details->ship_address2.'<br />' : '')
																	.$this->sales_order_details->ship_city.'<br />'
																	.$this->sales_order_details->ship_zipcode.' '.$this->sales_order_details->ship_state.'<br />'
																	.$this->sales_order_details->ship_country.'<br />';
																	?>
																</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<h2>The Items</h2>
											<hr /> <!--------------------------------->
											<div class="row">
												<div class="col-md-12 mt-repeater">

													<?php foreach ($this->sales_order_details->items as $key => $val) { ?>

													<div data-repeater-list="items">
														<div data-repeater-item class="mt-repeater-item">
															<!-- jQuery Repeater Container -->
															<div class="mt-repeater-input">
																<label class="control-label">Style#</label>
																<br />
																<input type="text" name="prod_no" class="form-control search_prod_no" value="<?php echo $val['prod_no']; ?>" readonly />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Color</label>
																<br/>
																<input type="text" name="color_name" class="form-control color_name" value="<?php echo $val['color_name']; ?>" readonly />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size</label>
																<br/>
																<input type="text" name="size" class="form-control color_name" value="<?php echo $val['size']; ?>" readonly />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Qty</label>
																<br/>
																<input type="text" name="qty" class="form-control" value="<?php echo $val['qty']; ?>" readonly />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Unit Price</label>
																<br/>
																<input type="text" name="wholesale_price" class="form-control" value="<?php echo $val['wholesale_price']; ?>" readonly />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Extanded Price</label>
																<br/>
																<input type="text" name="wholesale_price" class="form-control" value="<?php echo number_format($val['wholesale_price'] * $val['qty'], 2); ?>" readonly />
															</div>
														</div>
													</div>

													<?php } ?>

												</div>
											</div>
										</div>

									</form>
									<!-- END FORM-->
								</div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- EN
