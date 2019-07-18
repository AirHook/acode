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
											'id'=>'form-sales_orders_create'
										)
									); ?>
										<div class="form-actions top hide">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders') : site_url($this->config->slash_item('admin_folder').'sales_orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
													<button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-sales_orders_create').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
												</div>
											</div>
										</div>
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
													<div class="form-group row">
														<label class="control-label col-md-3"> <span class="bold">Sales Order #:</span>
														</label>
														<div class="col-md-9">
															<input type="text" name="sales_order_number" data-required="1" class="form-control" value="<?php echo $sales_order_number; ?>" readonly tabindex="-1" />
															<cite class="help-block small"> This is automatically generated and will only be used upon submit. </cite>
														</div>
													</div>
													<div class="form-group row">
														<label class="control-label col-md-3"> <span class="bold">Sales Order Date:</span>
														</label>
														<div class="col-md-9">
															<input type="text" id="sales_order_date" name="sales_order_date" data-required="1" class="form-control" value="<?php echo date('Y-m-d', time()); ?>" readonly tabindex="-1" />
															<cite class="help-block small"> This is automatically generated. </cite>
														</div>
													</div>
													<div class="form-group row">
														<label class="control-label col-md-3">Sales User
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">

															<select class="bs-select form-control" name="admin_sales_id" data-live-search="<?php echo count(@$sales) > 1 ? 'true' : 'false'; ?>" data-show-subtext="true" data-size="5">

																<?php if ($sales)
                                                                {
                                                                    if (count($sales) > 1) echo '<option value="" data-content="<em>Select sales user..</em>"></option>';
                                                                    foreach ($sales as $salesuser)
                                                                    { ?>

																<option value="<?php echo $salesuser->admin_sales_id; ?>" data-subtext="<?php echo $salesuser->admin_sales_email; ?>" data-admin_sales_user="<?php echo $salesuser->admin_sales_user.' '.$salesuser->admin_sales_lname; ?>" <?php echo $salesuser->admin_sales_id == $active_sales_user ? 'selected="selected"' : ''; ?>>
																	<?php echo $salesuser->admin_sales_user.' '.$salesuser->admin_sales_lname; ?>
																</option>

        																<?php
                                                                    }
                                                                } ?>

															</select>
															<cite class="help-block small"> &nbsp; </cite>

                                                            <input type="hidden" name="admin_sales_email" value="<?php echo $this->sales_user_details->email; ?>" />

														</div>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group row">
														<label class="control-label col-md-3">Designer
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">

															<select class="bs-select form-control" name="des_id" data-live-search="<?php echo count(@$designers) > 1 ? 'true' : 'false'; ?>" data-show-subtext="true" data-size="5">

																<?php if ($designers)
                                                                {
                                                                    if (count($designers) > 1) echo '<option value="" data-content="<em>Select a designer..</em>"></option>';
                                                                    foreach ($designers as $designer)
                                                                    { ?>

																<option value="<?php echo $designer->des_id; ?>" data-d_url_structure="<?php echo $designer->url_structure; ?>" <?php echo $designer->des_id != '5' ? ($this->uri->segment(1) === 'sales' ? 'selected' : 'disabled') : 'selected'; ?>>
																	<?php echo $designer->designer; ?>
																</option>

            															<?php
                                                                    }
                                                                } ?>

															</select>
															<cite class="help-block small">
                                                                <?php
                                                                if ($this->uri->segment(1) === 'sales')
                                                                {
                                                                    echo '&nbsp;';
                                                                }
                                                                else
                                                                {
                                                                    echo 'Currently defaulted to Basix Black Label only.';
                                                                }
                                                                ?>
                                                            </cite>

															<input type="hidden" name="designer_slug" value="basixblacklabel" />

														</div>
													</div>
													<!--
													<div class="form-group row hide">
														<label class="control-label col-md-3">Vendor
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">
															<select class="bs-select form-control" name="vendor_id" data-live-search="true" data-show-subtext="true" data-size="5">
																<option value="" data-content="<em>Select a vendor..</em>"></option>
																<?php if ($vendors) { ?>
																<?php foreach ($vendors as $vendor) { ?>
																<option value="<?php echo $vendor->vendor_id; ?>" data-subtext="<?php echo $vendor->vendor_name; ?>" data-vendor_code="<?php echo $vendor->vendor_code; ?>">
																	<?php echo $vendor->vendor_code; ?>
																</option>
																<?php } ?>
																<?php } ?>
															</select>
															<cite class="help-block small"> &nbsp; </cite>
															<input type="hidden" name="vendor_name" value="" />
															<input type="hidden" name="vendor_code" value="" />
														</div>
													</div>
													-->
													<div class="form-group row">
														<label class="control-label col-md-3">Store Name
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">
															<select class="bs-select form-control" name="user_id" data-live-search="true" data-show-subtext="true" data-size="5">
																<option value="" data-content="<em>Select a store name..</em>"></option>
																<?php if ($users)
																{
																	foreach ($users as $user)
																	{ ?>
																<option value="<?php echo $user->user_id; ?>" data-subtext="<?php echo $user->email; ?>" data-store_name="<?php echo $user->store_name; ?>" data-customer_name="<?php echo $user->firstname.' '.$user->lastname; ?>" data-firstname="<?php echo $user->firstname; ?>" data-lastname="<?php echo $user->lastname; ?>" data-telephone="<?php echo $user->telephone; ?>" data-ship_bill_to="<?php echo $user->firstname.' '.$user->lastname.'<br />'.$user->address1.'<br />'.($user->address2 ? $user->address2.'<br />' : '').$user->city.'<br />'.$user->zipcode.' '.$user->state.'<br />'.$user->country.'<br />'; ?>" data-address1="<?php echo $user->address1; ?>" data-address2="<?php echo $user->address2; ?>" data-city="<?php echo $user->city; ?>" data-state="<?php echo $user->state; ?>" data-country="<?php echo $user->country; ?>" data-zipcode="<?php echo $user->zipcode; ?>" >
																	<?php echo $user->store_name; ?>
																</option>
																		<?php
																	}
																} ?>
															</select>
															<cite class="help-block small"> &nbsp; </cite>
															<input type="hidden" name="store_name" value="" />
															<input type="hidden" name="firstname" value="" />
															<input type="hidden" name="lastname" value="" />
															<input type="hidden" name="email" value="" />
															<input type="hidden" name="telephone" value="" />
														</div>
													</div>
													<div class="form-group row">
														<label class="control-label col-md-3">Courier
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">
															<select class="bs-select form-control" name="courier" data-live-search="true" data-show-subtext="true" data-size="5">
																<option value="" data-content="<em>Select courier..</em>"></option>
																<option value="UPS">UPS</option>
																<option value="FEDEX">FEDEX</option>
																<option value="DHL">DHL</option>
																<option value="Others">Others</option>
															</select>
															<cite class="help-block small"> &nbsp; </cite>
														</div>
													</div>
												</div>
											</div>
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
																<div class="col-md-8 value ci-store_name">  </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Customer Name: </div>
																<div class="col-md-8 value ci-customer_name">  </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Email: </div>
																<div class="col-md-8 value ci-email">  </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Phone Number: </div>
																<div class="col-md-8 value ci-telephone">  </div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="portlet yellow-crusta box">
														<div class="portlet-title">
															<div class="caption">
																<i class="fa fa-cogs"></i>Sales User Information </div>
															<div class="actions hide">
																<a href="javascript:;" class="btn btn-default btn-sm">
																	<i class="fa fa-pencil"></i> Edit </a>
															</div>
														</div>
														<div class="portlet-body">
															<div class="row static-info">
																<div class="col-md-4 name"> Sales User Name: </div>
																<div class="col-md-8 value si-admin_sales_user"> <?php echo $this->sales_user_details->fname.' '.$this->sales_user_details->lname; ?> </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> Email: </div>
																<div class="col-md-8 value si-admin_sales_email"> <?php echo $this->sales_user_details->email; ?> </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> &nbsp; </div>
																<div class="col-md-8 value"> &nbsp; </div>
															</div>
															<div class="row static-info">
																<div class="col-md-4 name"> &nbsp; </div>
																<div class="col-md-8 value"> &nbsp; </div>
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
																<div class="col-md-12 value ci-bill_to"> &nbsp;<br />&nbsp;<br />&nbsp;<br /> </div>
																<input type="hidden" name="bill_address1" value="" />
																<input type="hidden" name="bill_address2" value="" />
																<input type="hidden" name="bill_city" value="" />
																<input type="hidden" name="bill_state" value="" />
																<input type="hidden" name="bill_country" value="" />
																<input type="hidden" name="bill_zipcode" value="" />
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
																<div class="col-md-12 value ci-ship_to"> &nbsp;<br />&nbsp;<br />&nbsp;<br /> </div>
																<input type="hidden" name="ship_address1" value="" />
																<input type="hidden" name="ship_address2" value="" />
																<input type="hidden" name="ship_city" value="" />
																<input type="hidden" name="ship_state" value="" />
																<input type="hidden" name="ship_country" value="" />
																<input type="hidden" name="ship_zipcode" value="" />
															</div>
														</div>
													</div>
												</div>
											</div>
											<h2>Add Products For This Order</h2>
											<hr /> <!--------------------------------->

											<div class="section my-repeater">
												<div class="row my-repeater-row">

													<div class="col-md-2">
														<div class="form-group">
															<label>Style#</label>
															<input type="text" name="prod_no[]" class="form-control search_prod_no prod_no" value="" style="text-transform:uppercase;color:black;" />
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label>Image</label>
															<br />
															<a class="" href="javascript:;" target="_blank">
																<img class="thumb-icon" src="https://www.shop7thavenue.com/assets/images/icons/shop7-emblem.jpg" width="70" height="105" />
															</a>
															<input type="hidden" name="image_url_path[]" value="" />
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group color-select-actual" style="display:none;">
															<label>Color</label>
															<select class="bs-select form-control color_code" name="color_code[]" data-live-search="true" data-size="8">
																<option value="" data-content="<em>Select...</em>"></option>
																<?php if ($colors) { ?>
																<?php foreach ($colors as $color) { ?>
																<option value="<?php echo $color->color_code; ?>" data-color_name="<?php echo $color->color_name; ?>" data-subtext="<em class='small'><?php echo $color->color_code; ?></em>">
																	<?php echo $color->color_name; ?>
																</option>
																<?php } ?>
																<?php } ?>
															</select>
														</div>
														<div class="form-group color-select-notification">
															<label>Color</label>
															<input type="text" placeholder="Select Prod No First..." class="form-control" readonly />
														</div>
														<input type="hidden" name="color_name[]" value="" />
													</div>
													<div class="col-md-1">
														<div class="form-group size-select">
															<label>Size</label>
															<select class="bs-select form-control size" name="size[]" data-live-search="true" data-size="5">
																<option value="" data-content="<em>...</em>"></option>
																<?php if ($sizes) { ?>
																<?php foreach ($sizes as $size) { ?>
																<?php if ($size->size_name !== 'fs') { ?>
																<option value="<?php echo 'size_'.$size->size_name; ?>">
																	<?php echo $size->size_name; ?>
																</option>
																<?php } ?>
																<?php } ?>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label>Qty</label>
															<input type="text" name="qty[]" class="form-control qty" value="" />
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label>Unit Price</label>
															<input type="text" name="wholesale_price[]" class="form-control unit_price" value="..." readonly />
														</div>
													</div>
													<div class="col-md-1">
														<div class="form-group">
															<label>Ext Price</label>
															<input type="text" name="ext_price[]" class="form-control ext_price" placeholder="..." readonly />
														</div>
													</div>
													<div class="col-md-2">
														<div class="form-group">
															<label> &nbsp; </label><br />
															<a href="javascript:;" class="btn btn-danger my-repeater-delete">
																<i class="fa fa-close"></i> Delete Line
															</a>
														</div>
													</div>

												</div>

												<a href="javascript:;" class="btn btn-success my-repeater-add">
													<i class="fa fa-plus"></i> Add a product
												</a>
											</div>

										</div>

 										<div class="form-actions bottom">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<button type="submit" class="btn red-flamingo">Generate Order</button>
													<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders') : site_url($this->config->slash_item('admin_folder').'sales_orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
													<button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-sales_orders_create').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
