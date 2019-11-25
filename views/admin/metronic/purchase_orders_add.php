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
                                            ? 'sales/purchase_orders/create'
										    : $this->config->slash_item('admin_folder').'purchase_orders/create'
                                        ),
										array(
											'class'=>'form-horizontal',
											'id'=>'form-purchase_orders_create'
										)
									); ?>
										<div class="form-actions top">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<button type="submit" class="btn red-flamingo">Create</button>
													<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders') : site_url($this->config->slash_item('admin_folder').'purchase_orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
													<button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-purchase_orders_create').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
													<button class="close" data-close="alert"></button> New Purchase Order CREATED!
												</div>
												<?php } ?>
												<?php if ($this->session->flashdata('success') == 'edit') { ?>
												<div class="alert alert-success auto-remove">
													<button class="close" data-close="alert"></button> Purchase Order information updated...
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
													<div class="form-group">
														<label class="control-label col-md-3"> <span class="bold">PO#:</span>
														</label>
														<div class="col-md-9">
															<input type="text" name="po_no" data-required="1" class="form-control" value="<?php echo $des_code.$po_number; ?>" readonly tabindex="-1" />
															<input type="hidden" name="des_code" value="<?php echo $des_code; ?>" />
															<input type="hidden" name="po_number" value="<?php echo $po_number; ?>" />
															<cite class="help-block small"> This is automatically generated and will only be used upon submit. </cite>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3"> <span class="bold">PO Date:</span>
														</label>
														<div class="col-md-9">
															<input type="text" id="po_date" name="po_date" data-required="1" class="form-control" value="<?php echo date('Y-m-d', time()); ?>" readonly tabindex="-1" />
															<cite class="help-block small"> This is automatically generated. </cite>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label col-md-3">Designer
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">
															<select class="bs-select form-control" name="des_id" data-live-search="true" data-size="5">
																<option value="" data-content="<em>Select a designer..</em>"></option>
																<?php if ($designers) { ?>
																<?php foreach ($designers as $designer) { ?>
																<option value="<?php echo $designer->des_id; ?>" data-d_url_structure="<?php echo $designer->url_structure; ?>">
																	<?php echo $designer->designer; ?>
																</option>
																<?php } ?>
																<?php } ?>
															</select>
															<cite class="help-block small"> &nbsp; </cite>
															<input type="hidden" name="designer_slug" value="" />
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-3">Vendor
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">
															<select class="bs-select form-control" name="vendor_id" data-live-search="true" data-size="5">
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
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label col-md-3">Store Name
															<span class="required"> * </span>
														</label>
														<div class="col-md-9">
															<select class="bs-select form-control" name="user_id" data-live-search="true" data-size="5">
																<option value="" data-content="<em>Select a store name..</em>"></option>
																<?php if ($users) { ?>
																<?php foreach ($users as $user) { ?>
																<option value="<?php echo $user->user_id; ?>" data-subtext="<?php echo $user->email; ?>" data-store_name="<?php echo $user->store_name; ?>">
																	<?php echo $user->store_name; ?>
																</option>
																<?php } ?>
																<?php } ?>
															</select>
															<cite class="help-block small"> &nbsp; </cite>
															<input type="hidden" name="store_name" value="" />
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label col-md-3"> Delivery Date
															<span class="required"> * </span>
														</label>
														<div class="col-md-4">
															<div class="input-group input-medium delivery_date date date-picker" data-date-start-date="+0d" data-date="+0d">
																<input type="text" class="form-control" name="delivery_date" />
																<span class="input-group-btn">
																	<button class="btn default" type="button">
																		<i class="fa fa-calendar"></i>
																	</button>
																</span>
															</div>
															<!-- /input-group -->
															<cite class="help-block small">
																Select/Type date <br /> format: yyyy-mm-dd <br />
																<a class="publish_date" name="refresh_date" onclick="$('.delivery_date.date-picker').datepicker('setDate', '+0d');"><cite>refresh date</cite></a>
															</cite>
														</div>
													</div>
												</div>
											</div>
											<hr /> <!--------------------------------->
											<div class="row">
												<div class="col-md-12 mt-repeater">
													<div data-repeater-list="items">
														<div data-repeater-item class="mt-repeater-item">
															<!-- jQuery Repeater Container -->
															<div class="mt-repeater-input">
																<label class="control-label">Style#</label>
																<br />
																<input type="text" name="prod_no" class="form-control search_prod_no" value="" style="text-transform:uppercase;color:black;min-width:115px;" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Color</label>
																<br/>
																<select class="color_code form-control" name="color_code" data-live-search="true" data-size="5">
																	<option value="" data-content="<em>Select...</em>"></option>
																	<?php if ($colors) { ?>
																	<?php foreach ($colors as $color) { ?>
																	<option value="<?php echo $color->color_code; ?>" data-color_name="<?php echo $color->color_name; ?>" data-subtext="<em class='small'><?php echo $color->color_code; ?></em>">
																		<?php echo $color->color_name; ?>
																	</option>
																	<?php } ?>
																	<?php } ?>
																</select>
																<input type="hidden" name="color_name" class="form-control color_name" value="1" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 0</label>
																<br/>
																<input type="text" name="size_0" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 2</label>
																<br/>
																<input type="text" name="size_2" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 4</label>
																<br/>
																<input type="text" name="size_4" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 6</label>
																<br/>
																<input type="text" name="size_6" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 8</label>
																<br/>
																<input type="text" name="size_8" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 10</label>
																<br/>
																<input type="text" name="size_10" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 12</label>
																<br/>
																<input type="text" name="size_12" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 14</label>
																<br/>
																<input type="text" name="size_14" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 16</label>
																<br/>
																<input type="text" name="size_16" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 18</label>
																<br/>
																<input type="text" name="size_18" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 20</label>
																<br/>
																<input type="text" name="size_20" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<label class="control-label">Size 22</label>
																<br/>
																<input type="text" name="size_22" class="form-control" value="" />
															</div>
															<div class="mt-repeater-input">
																<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																	<i class="fa fa-close"></i> Delete</a>
															</div>
														</div>
													</div>
													<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
														<i class="fa fa-plus"></i> Add another line</a>
												</div>
											</div>
										</div>

 										<div class="form-actions bottom">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<button type="submit" class="btn red-flamingo">Create</button>
													<a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders') : site_url($this->config->slash_item('admin_folder').'purchase_orders'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
													<button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-purchase_orders_create').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
            <!-- END CONTENT -->
