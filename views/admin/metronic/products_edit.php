                    <!-- BEGIN PAGE CONTENT BODY -->
					<style>
					.img-absolute { position:absolute; }
					</style>

                    <div class="row ">

						<!-- BEGIN FORM-->
						<!-- FORM =======================================================================-->
						<?php echo form_open(
							$this->config->slash_item('admin_folder').'products/edit/index/'.$this->product_details->prod_id,
							array(
								'class'=>'form-horizontal',
								'id'=>'form-products_edit'
							)
						); ?>

                        <div class="col-md-12">
							<div class="portlet ">
								<div class="portlet-title">

									<?php
									/***********
									 * Noification area
									 */
									?>
									<div>
										<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> There was an error with your request. Please try again.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'add') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> New Product ADDED! Continue edit new product now...
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Product item updated...
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'database_update') { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> There was a problem updating database. Please contact your webmaster on this error...
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'post_data_error') { ?>
										<div class="alert alert-danger ">
											<button class="close" data-close="alert"></button> An error occured in posting data. Error - <br />
											<?php echo $this->session->flashdata('error_value') ?: 'Unknown'; ?>
										</div>
										<?php } ?>
										<?php if (validation_errors()) { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
										</div>
										<?php } ?>
									</div>

									<div class="caption">
										<i class="fa fa-leaf"></i><?php echo $this->product_details->prod_no ?: 'Product Number'; ?>
									</div>
									<div class="actions btn-set">
										<a class="btn btn-secondary-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'products'); ?>">
											<i class="fa fa-reply"></i> Back to product list</a>
										<a class="btn blue <?php echo $this->webspace_details->options['site_type'] == 'sat_site' ? 'hide' : ''; ?>" href="<?php echo site_url($this->config->slash_item('admin_folder').'products/add'); ?>">
											<i class="fa fa-plus"></i> Add New Product </a>
									</div>
								</div>
							</div>
                        </div>

						<div class="col-lg-3 col-md-4 col-xs-12 pull-right" data-st_id="<?php echo $this->product_details->onorder_st_id; ?>">
							<!-- BEGIN Portlet PORTLET-->
							<div class="portlet box blue form">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-bullhorn"></i> Publish Options </div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Save </a>
									</div>
								</div>
								<div class="portlet-body">

									<?php
									/***********
									 * Noification area
									 */
									?>
									<?php if ($this->product_details->pending) { ?>
									<div class="alert alert-danger ">
										<i class="fa fa-warning fa-2x"></i> <br /> This product is pending public view until PUBLISH DATE is current!
									</div>
									<?php } ?>
									<?php if (@$inc_general OR @$inc_colors OR @$inc_images) { ?>
									<div class="alert alert-danger margin-bottom-10">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
										<i class="fa fa-warning fa-2x"></i> <br /> Please update missing items in the product information box.
									</div>
									<?php } ?>

									<div class="form-body">
										<div class="row">

											<div class="form-group">
												<label class="col-md-4 control-label">Publish:
												</label>
												<div class="col-md-8">
                                                    <select class="bs-select form-control" data-show-subtext="true" id="publish" name="publish" tabindex="-98" data-orignial_publish="<?php echo $this->product_details->publish; ?>" <?php echo $this->product_details->publish === '3' ? 'disabled' : ''; ?>>

														<?php
														if (
															$this->product_details->publish === '1'
															OR $this->product_details->publish === '11'
															OR $this->product_details->publish === '12'
															OR $this->product_details->view_status === 'Y'
															OR $this->product_details->view_status === 'Y1'
															OR $this->product_details->view_status === 'Y2'
														)
														{
															$publish_selected = 'selected';
														}
														else $publish_selected = '';
														?>

                                                        <option value="1" id="publish-publish" onclick="$('#publish-at').show();$('#private-at').hide();" <?php echo $publish_selected; ?> <?php echo ($inc_general OR @$inc_colors  OR $inc_images) ? 'data-subtext="incomplete"': ''; ?>>
															Publish
														</option>
                                                        <option value="2" id="publish-private" onclick="$('#publish-at').hide();$('#private-at').show();" <?php echo ($this->product_details->publish === '2') ? 'selected': ''; ?> <?php echo ($inc_general OR @$inc_colors  OR $inc_images) ? 'data-subtext="incomplete"': ''; ?>>
															Private
														</option>
                                                        <option value="0" id="publish-unpublish" onclick="$('#publish-at, #private-at').hide();" <?php echo ($this->product_details->publish === '0') ? 'selected': ''; ?>>
															Unpublish
														</option>

                                                    </select>
													<span class="help-block <?php echo ($this->product_details->publish === '2') ?: 'display-none'; ?>" id="private-at"> for admin and wholesale users view only </span>
													<span class="help-block <?php echo ($this->product_details->publish === '3') ?: 'display-none'; ?>" id="pending-at" style="color:red;"> publishing pending publish date below </span>
												</div>
											</div>

											<?php if (@$this->webspace_details->options['site_type'] == 'hub_site') { ?>
                                            <div class="form-group" id="publish-at" <?php echo ($this->product_details->publish === '0' OR $this->product_details->publish === '2' OR $this->product_details->view_status === 'N') ? 'style="display:none;"': ''; ?>>
                                                <div class="col-md-8 col-md-offset-4">
                                                    <div class="mt-checkbox-list">
                                                        <label class="mt-checkbox mt-checkbox-outline">
                                                            <input type="checkbox" class="publish_at" id="publish_at_hub" name="publish_at_hub" value="1" <?php echo ($this->product_details->publish === '1' OR $this->product_details->publish === '11') ? 'checked' : ''; ?>> at this hub site
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox mt-checkbox-outline">
                                                            <input type="checkbox" class="publish_at" id="publish_at_satellite" name="publish_at_satellite" value="1" <?php echo ($this->product_details->publish === '1' OR $this->product_details->publish === '12') ? 'checked' : ''; ?>> at satellite site
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
											<?php } ?>

											<?php
											/***********
											 * Date to Publish
											 */
											?>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Date to Publish:
												</label>
                                                <div class="col-md-8">
													<?php if (@$inc_general OR @$inc_colors  OR @$inc_images) { ?>
													<input type="hidden" name="publish_date" value="<?php echo $this->product_details->publish_date ?: $this->product_details->create_date; ?>" data-initial_value="<?php echo $this->product_details->publish_date ?: $this->product_details->create_date; ?>" />
													<?php } ?>
                                                    <input class="form-control form-control-inline publish_date date-picker" type="text" id="publish_date" name="publish_date" value="<?php echo $this->product_details->publish_date ?: $this->product_details->create_date; ?>" <?php echo ($inc_general OR @$inc_colors  OR $inc_images) ? 'disabled': ''; ?> data-initial_value="<?php echo $this->product_details->publish_date ?: $this->product_details->create_date; ?>" />
                                                    <span class="help-block">
														Select/Type date <br /> format: yyyy-mm-dd <br />
														<small><a class="publish_date" name="refresh_date" onclick="$('.publish_date.date-picker').datepicker('setDate', '<?php echo $this->product_details->publish_date ?: $this->product_details->create_date; ?>');"><cite>refresh date</cite></a></small>
													</span>
													<?php if (@$inc_general OR @$inc_colors  OR @$inc_images) { ?>
                                                    <span class="help-block">
														Unable to edit publish date while product information is incomplete
													</span>
													<?php } else { ?>
                                                    <span class="help-block">
														Set date to future to make Publish in Pending mode. Set to present or past to publish immediately.
													</span>
													<?php } ?>
                                                </div>
                                            </div>

											<div class="form-group" style="margin-bottom:0px;">
												<label class="control-label col-md-4">On Sale:</label>
												<div class="col-md-8">
													<div class="mt-checkbox-inline">
														<label class="mt-checkbox mt-checkbox-outline">
															<input type="checkbox" name="clearance" value="3" <?php echo $this->product_details->clearance == '3' ? 'checked="checked"' : ''; ?> /> Yes
															<span></span>
														</label>
														<span class="help-block hide"> Sets entire product (all colors) to clearance </span>
														<input type="hidden" name="clearance_old" value="<?php echo $this->product_details->clearance; ?>" />
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-4">Sequence:</label>
												<div class="col-md-4">
													<input type="text" class="form-control" name="seque" value="<?php echo $this->product_details->seque; ?>" />
												</div>
											</div>

											<div class="actions btn-set">
												<button type="submit" class="btn blue btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left" onclick="$('#loading .modal-title').html('Updating...');$('#loading').modal('show');">
													<span class="ladda-label">Update</span>
													<span class="ladda-spinner"></span>
												</button>
											</div>

											<!-- DOC: Add "hide" class to disable -->
											<div class="col " style="margin-top:30px;">
												<a data-toggle="modal" href="#delete-<?php echo $this->product_details->prod_id; ?>"><em> Delete Permanently </em></a><br />
												<cite class="small font-red-flamingo"> (This will delete item including all colors) </cite>
											</div>

										</div>
									</div>
								</div>
							</div>
							<!-- END Portlet PORTLET-->
						</div>

						<div class="col-lg-9 col-md-8 col-xs-12 pull-left general_info">
							<!-- BEGIN Portlet PORTLET-->
							<div class="portlet box blue form">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-cog"></i> General Product Info
									</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"> </a>
									</div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Update </a>
									</div>
								</div>
								<div class="portlet-body">

									<?php $this->load->view($this->config->slash_item('admin_folder').'metronic/products_edit_general'); ?>

								</div>
							</div>
							<!-- END Portlet PORTLET-->
						</div>

						<div class="col-lg-9 col-md-8 col-xs-12 pull-left meta_into">
							<!-- BEGIN Portlet PORTLET-->
							<div class="portlet box blue-hoki form">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-info"></i> Meta Info
									</div>
									<div class="tools">
										<a href="javascript:;" class="expand"> </a>
									</div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Update </a>
									</div>
								</div>
								<div class="portlet-body portlet-collapsed">

									<?php $this->load->view($this->config->slash_item('admin_folder').'metronic/products_edit_meta'); ?>

								</div>
							</div>
							<!-- END Portlet PORTLET-->
						</div>

						<div class="col-lg-9 col-md-8 col-xs-12 pull-left product_variants">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet box green-jungle form">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-tags"></i> Product Variants (Colors and Images)
									</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"> </a>
									</div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Save </a>
									</div>
								</div>
								<div class="portlet-body">
									<div class="tabbable-bordered">

										<div class="note note-success">
											<p> This box contains the different product variants and respective options. Each color variant is boxed separately with the top yellow box as the primary color, and the rest in grey box. Switch primary between color items as needed. </p>
											<p> Primary colors are UN-DELETE-able. To DELETE a primary color, set a new primary color first, then delete the old color. </p>
										</div>

										<?php $this->load->view($this->config->slash_item('admin_folder').'metronic/products_edit_images'); ?>

									</div>
								</div>
                            </div>
                            <!-- END \PORTLET-->
						</div>

						<div class="col-lg-9 col-md-8 col-xs-12 pull-left hide options">
							<!-- BEGIN Portlet PORTLET-->
							<div class="portlet box blue-hoki form">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-wrench"></i> Options
									</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"> </a>
									</div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Update </a>
									</div>
								</div>
								<div class="portlet-body">

									<?php $this->load->view($this->config->slash_item('admin_folder').'metronic/products_edit_options'); ?>

								</div>
							</div>
							<!-- END Portlet PORTLET-->
						</div>

						<div class="col-lg-9 col-md-8 col-xs-12 pull-left facets">
							<!-- BEGIN Portlet PORTLET-->
							<div class="portlet box blue-hoki form">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-tags"></i> Facets
									</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"> </a>
									</div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Update </a>
									</div>
								</div>
								<div class="portlet-body">

									<?php $this->load->view($this->config->slash_item('admin_folder').'metronic/products_edit_facets'); ?>

								</div>
							</div>
							<!-- END Portlet PORTLET-->
						</div>

						<div class="floatbar display-hide">
							<div class="actions btn-set">
								<button type="submit" class="btn blue btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left" onclick="$('#loading .modal-title').html('Updating...');$('#loading').modal('show');">
									<span class="ladda-label">Update <?php echo $this->product_details->prod_no ? '&nbsp; <i class="fa fa-leaf"></i> '.$this->product_details->prod_no : ''; ?></span>
									<span class="ladda-spinner"></span>
								</button>
							</div>
						</div>

						</form>
						<!-- End FORM =======================================================================-->
						<!-- END FORM-->

                    </div>
                    <!-- END PAGE CONTENT BODY -->

					<!-- Alert -->
					<div class="modal fade bs-modal-sm" id="alert" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Notice!</h4>
								</div>
								<div class="modal-body">
									<p> </p>
								</div>
								<div class="modal-footer">
									<button class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
									<button class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Continue</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- DELETE ITEM -->
					<div class="modal fade bs-modal-sm" id="delete-<?php echo $this->product_details->prod_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Warning!</h4>
								</div>
								<div class="modal-body">
									Permanently DELETE item? <br /> This cannot be undone!
									<div class="note note-danger">
										<h4 class="block">Danger! </h4>
										<p> This action will delete the entire product item including its color variants. Please ensure you know what you are doing before proceeding. </p>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/delete/index/'.$this->product_details->prod_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- UPDATE STOCK -->
					<div class="modal fade bs-modal-md" id="update_stock" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open($this->config->slash_item('admin_folder').'products/update_stocks/index/'.$this->product_details->prod_id, array('class'=>'form-horizontal', 'id'=>'form_products_edit_update_stocks')); ?>

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Update STOCK</h4>
								</div>
								<div class="modal-body" style="text-align:center;">

									<input type="hidden" id="st_id" name="st_id" value="" />
									<input type="hidden" id="color_name" name="color_name" value="" />
									<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
									<input type="hidden" name="prod_id" value="<?php echo $this->product_details->prod_id; ?>" />
									<input type="hidden" name="designer_slug" value="<?php echo $this->product_details->d_url_structure; ?>" />

									<table class="table-stocks" data-toggle="table" data-card-view="true" style="margin:0 auto;">

										<thead>
											<?php $size_cnt = count($size_names); ?>
											<tr>
												<th colspan="<?php echo $size_cnt; ?>">
													Size
												</th>
											</tr>

											<tr>
												<?php
												foreach ($size_names as $size_label => $s)
												{ ?>

												<th> <?php echo $s; ?> </th>

													<?php
												} ?>
											</tr>
										</thead>

										<tbody>
											<tr>

												<?php
												foreach ($size_names as $size_label => $s)
												{ ?>

												<td> <input type="text" size="2" id="<?php echo $size_label; ?>" name="<?php echo $size_label; ?>" value="" /> </td>

													<?php
												} ?>

											</tr>
										</tbody>

									</table>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">UPDATE</span>
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

					<!-- UPDATE AMDIN STOCK -->
					<div class="modal fade bs-modal-md" id="update_admin_stock" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open($this->config->slash_item('admin_folder').'products/update_stocks/admin/'.$this->product_details->prod_id, array('class'=>'form-horizontal', 'id'=>'form_products_edit_update_stocks')); ?>

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Update ADMIN STOCK only</h4>
								</div>
								<div class="modal-body" style="text-align:center;">

									<input type="hidden" id="admin_st_id" name="st_id" value="" />

									<table class="table-admin-stocks" data-toggle="table" data-card-view="true" style="margin:0 auto;">

										<thead>
											<?php $size_cnt = count($size_names); ?>
											<tr>
												<th colspan="<?php echo $size_cnt; ?>">
													Size
												</th>
											</tr>

											<tr>
												<?php
												foreach ($size_names as $size_label => $s)
												{ ?>

												<th> <?php echo $s; ?> </th>

													<?php
												} ?>
											</tr>
										</thead>

										<tbody>
											<tr>

												<?php
												foreach ($size_names as $size_label => $s)
												{ ?>

												<td> <input type="text" size="2" id="<?php echo str_replace('size', 'admin_physical', $size_label); ?>" name="<?php echo $size_label; ?>" value="" /> </td>

													<?php
												} ?>

											</tr>
										</tbody>

									</table>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">UPDATE</span>
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

					<!-- ADD COLOR -->
					<div class="modal fade bs-modal-md" id="modal-add-color" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open(
									$this->config->slash_item('admin_folder').'products/add_color/index/'.$this->product_details->prod_id,
									array(
										'class'=>'form-horizontal',
										'id'=>'form_products_add_color',
										'role'=>'form'
									)
								); ?>

								<input type="hidden" name="stock_date" value="<?php echo $this->product_details->publish_date; ?>" />
								<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
								<input type="hidden" id="color_name" name="color_name" value="" />


								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Add Color</h4>
								</div>
								<div class="modal-body">
									<div class="form-body">
										<div class="alert alert-danger display-hide">
											<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
										<div class="alert alert-success display-hide">
											<button class="close" data-close="alert"></button> Your form validation is successful! </div>
										<div class="form-group clearfix">
											<label class="col-md-3 control-label">Select a color:
												<span class="required"> * </span>
											</label>
											<div class="col-md-9">
												<select class="bs-select form-control selectpicker" id="color_code" name="color_code" data-live-search="true" data-size="8">
													<option value="" selected disabled> - Select a color - </option>
													<?php if ($colors) { ?>
													<?php foreach ($colors as $color) { ?>
													<option value="<?php echo $color->color_code; ?>"> <?php echo $color->color_name; ?> </option>
													<?php } } ?>
												</select>
												<span class="help-block">&nbsp;</span>
											</div>
										</div>
										<?php if ( ! $this->product_details->primary_img_id) { ?>
										<input type="hidden" value="1" name="primary_color" />
										<?php } else { ?>
										<div class="form-group">
											<div class="col-md-9 col-md-offset-3">
												<label class="mt-checkbox mt-checkbox-outline"> Set as Primary Color
													<input type="checkbox" value="1" name="primary_color" />
													<span></span>
												</label>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Add Color?</span>
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

					<!-- UPLOAD IMAGES -->
					<div class="modal fade bs-modal-md" id="modal-upload_images" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
									<h4 class="modal-title">Upload images</h4>
								</div>
								<div class="modal-body">

									<div class="m-heading-1 border-green m-bordered">
										<p> Files are uploaded automatically after full progress and check appears. </p>
									</div>

									<div class="row margin-bottom-10">
										<div class="col col-md-6">
											<?php echo form_open(
												//$this->config->slash_item('admin_folder').'products/upload_images',
												$this->config->slash_item('admin_folder').'products/uploads',
												array(
													'class'=>'dropzone dropzone-file-area',
													'id'=>'my-dropzone-front',
													'enctype'=>'multipart/form-data'
												)
											); ?>
												<?php
												/***********
												 * st_id is passed to "upload_images_st_id" upon click of respective
												 * Upload Images button
												 */
												?>
												<input type="hidden" name="upload_images_st_id" value="" />
												<input type="hidden" name="product_view" value="front" />
												<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
												<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
												<input type="hidden" name="prod_date" value="<?php echo $this->product_details->create_date; ?>" />
												<input type="hidden" name="categories" value="<?php echo implode(',', $this->product_details->categories); ?>" />
												<input type="hidden" name="category_slugs" value="<?php echo $this->cat_slugs; ?>" />
												<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
												<input type="hidden" name="designer_slug" value="<?php echo $this->product_details->d_url_structure; ?>" />
												<input type="hidden" name="view_status" value="<?php echo $this->product_details->view_status; ?>" />
												<input type="hidden" name="public" value="<?php echo $this->product_details->public; ?>" />
												<input type="hidden" name="publish" value="<?php echo $this->product_details->publish; ?>" />
												<input type="hidden" name="new_color_publish" value="" />
												<input type="hidden" name="color_publish" value="" />
												<!--
												<input type="hidden" name="image_url" value="product_assets/WMANSAPREL/<?php echo $this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_front/'; ?>" />
												-->

												<h4 class="sbold"> Front Image </h4>
												<p>Drop files here or click to upload</p>
											</form>
										</div>
										<div class="col col-md-6">
											<?php echo form_open(
												//$this->config->slash_item('admin_folder').'products/upload_images',
												$this->config->slash_item('admin_folder').'products/uploads',
												array(
													'class'=>'dropzone dropzone-file-area',
													'id'=>'my-dropzone-back',
													'enctype'=>'multipart/form-data'
												)
											); ?>
												<?php
												/***********
												 * st_id is passed to "upload_images_st_id" upon click of respective
												 * Upload Images button
												 */
												?>
												<input type="hidden" name="upload_images_st_id" value="" />
												<input type="hidden" name="product_view" value="back" />
												<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
												<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
												<input type="hidden" name="prod_date" value="<?php echo $this->product_details->create_date; ?>" />
												<input type="hidden" name="categories" value="<?php echo implode(',', $this->product_details->categories); ?>" />
												<input type="hidden" name="category_slugs" value="<?php echo $this->cat_slugs; ?>" />
												<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
												<input type="hidden" name="designer_slug" value="<?php echo $this->product_details->d_url_structure; ?>" />
												<input type="hidden" name="view_status" value="<?php echo $this->product_details->view_status; ?>" />
												<input type="hidden" name="public" value="<?php echo $this->product_details->public; ?>" />
												<input type="hidden" name="publish" value="<?php echo $this->product_details->publish; ?>" />
												<input type="hidden" name="new_color_publish" value="" />
												<input type="hidden" name="color_publish" value="" />
												<!--
												<input type="hidden" name="image_url" value="product_assets/WMANSAPREL/<?php echo $this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_back/'; ?>" />
												-->

												<h4 class="sbold"> Back Image </h4>
												<p>Drop files here or click to upload</p>
											</form>
										</div>
									</div>
									<div class="row">
										<div class="col col-md-6">
											<?php echo form_open(
												//$this->config->slash_item('admin_folder').'products/upload_images',
												$this->config->slash_item('admin_folder').'products/uploads',
												array(
													'class'=>'dropzone dropzone-file-area',
													'id'=>'my-dropzone-side',
													'enctype'=>'multipart/form-data'
												)
											); ?>
												<?php
												/***********
												 * st_id is passed to "upload_images_st_id" upon click of respective
												 * Upload Images button
												 */
												?>
												<input type="hidden" name="upload_images_st_id" value="" />
												<input type="hidden" name="product_view" value="side" />
												<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
												<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
												<input type="hidden" name="prod_date" value="<?php echo $this->product_details->create_date; ?>" />
												<input type="hidden" name="categories" value="<?php echo implode(',', $this->product_details->categories); ?>" />
												<input type="hidden" name="category_slugs" value="<?php echo $this->cat_slugs; ?>" />
												<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
												<input type="hidden" name="designer_slug" value="<?php echo $this->product_details->d_url_structure; ?>" />
												<input type="hidden" name="view_status" value="<?php echo $this->product_details->view_status; ?>" />
												<input type="hidden" name="public" value="<?php echo $this->product_details->public; ?>" />
												<input type="hidden" name="publish" value="<?php echo $this->product_details->publish; ?>" />
												<input type="hidden" name="new_color_publish" value="" />
												<input type="hidden" name="color_publish" value="" />
												<!--
												<input type="hidden" name="image_url" value="product_assets/WMANSAPREL/<?php echo $this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_side/'; ?>" />
												-->

												<h4 class="sbold"> Side Image </h4>
												<p>Drop files here or click to upload</p>
											</form>
										</div>
										<div class="col col-md-6">
											<?php echo form_open(
												//$this->config->slash_item('admin_folder').'products/upload_images',
												$this->config->slash_item('admin_folder').'products/uploads',
												array(
													'class'=>'dropzone dropzone-file-area hide',
													'id'=>'my-dropzone-swatch',
													'enctype'=>'multipart/form-data'
												)
											); ?>
												<?php
												/***********
												 * st_id is passed to "upload_images_st_id" upon click of respective
												 * Upload Images button
												 */
												?>
												<input type="hidden" name="upload_images_st_id" value="" />
												<input type="hidden" name="product_view" value="coloricon" />
												<input type="hidden" name="prod_no" value="<?php echo $this->product_details->prod_no; ?>" />
												<input type="hidden" name="prod_name" value="<?php echo $this->product_details->prod_name; ?>" />
												<input type="hidden" name="prod_date" value="<?php echo $this->product_details->create_date; ?>" />
												<input type="hidden" name="categories" value="<?php echo implode(',', $this->product_details->categories); ?>" />
												<input type="hidden" name="category_slugs" value="<?php echo $this->cat_slugs; ?>" />
												<input type="hidden" name="des_id" value="<?php echo $this->product_details->des_id; ?>" />
												<input type="hidden" name="designer_slug" value="<?php echo $this->product_details->d_url_structure; ?>" />
												<input type="hidden" name="view_status" value="<?php echo $this->product_details->view_status; ?>" />
												<input type="hidden" name="public" value="<?php echo $this->product_details->public; ?>" />
												<input type="hidden" name="publish" value="<?php echo $this->product_details->publish; ?>" />
												<input type="hidden" name="new_color_publish" value="" />
												<input type="hidden" name="color_publish" value="" />
												<!--
												<input type="hidden" name="image_url" value="product_assets/WMANSAPREL/<?php echo $this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_coloricon/'; ?>" />
												-->

												<h4 class="sbold"> Color Icon </h4>
												<p>Drop files here or click to upload</p>
											</form>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline cancel-upload-image-modal-btn" data-dismiss="modal">Cancel</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$this->product_details->prod_id); ?>" class="btn green">Close</a>
								</div>

							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- ADD PRODUCT -->
					<div class="modal fade bs-modal-lg" id="modal_add_product" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open(
									$this->config->slash_item('admin_folder').'products/add',
									array(
										'class'=>'form-horizontal',
										'id'=>'form-products_add'
									)
								); ?>

								<input type="hidden" name="view_status" value="N" />
								<input type="hidden" name="public" value="N" />
								<input type="hidden" name="publish" value="0" />
								<input type="hidden" name="prod_date" value="<?php echo @date('Y-m-d', time()); ?>" />
								<input type="hidden" name="publish_date" value="<?php echo @date('Y-m-d', time()); ?>" />

								<div class="modal-header">
									<?php if ($this->uri->segment(3) === 'add') { ?>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products'); ?>" type="button" class="close">&nbsp;</a>
									<?php } else { ?>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<?php } ?>
									<h4 class="modal-title">Add Product!</h4>
								</div>
								<div class="modal-body">

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
										<?php if (validation_errors()) { ?>
										<div class="alert alert-danger">
											<button class="close" data-close="alert"></button> There was a problem with the form. Please check and try again. <br /> <?php echo validation_errors(); ?> </div>
										<?php } ?>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label">SKU (Prod No.):
											<span class="required"> * </span>
										</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="prod_no" placeholder=""> </div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Product Name:
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="prod_name" placeholder="">
											<span class="help-block">displayed in product listings and details page</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Designer:
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
												<option value=""> - select one - </option>
												<?php if ($designers) { ?>
												<?php foreach ($designers as $designer) { ?>
													<?php if ($this->webspace_details->options['site_type'] == 'hub_site') { // if hub site, show all designers ?>
														<?php if ($designer->url_structure !== $this->webspace_details->slug) { ?>
												<option value="<?php echo $designer->des_id; ?>" data-url_structure="<?php echo $designer->url_structure; ?>"> <?php echo $designer->designer; ?> </option>
														<?php } ?>
													<?php } else { // else show satellite site designer only ?>
														<?php if ($designer->url_structure == $this->webspace_details->slug) { ?>
												<option value="<?php echo $designer->des_id; ?>" data-url_structure="<?php echo $designer->url_structure; ?>"> <?php echo $designer->designer; ?> </option>
														<?php } ?>
													<?php } ?>
												<?php } ?>
												<?php } ?>
											</select>
											<input type="hidden" name="designer_slug" value="" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Categories:
											<span class="required"> * </span>
										</label>
										<div class="col-lg-9">
											<div class="form-control height-auto">
												<div class="category_treelist scroller" style="height:175px;" data-always-visible="1" data-handle-color="#637283">

											<?php
											/**********
											 * Let us use a metroni helper to load category tree
											 * Note the following that is neede:
											 * 		$categories (object)
											 *		$this->product_details->categories
											 *		$this->categories_tree->row_count
											 */
											?>

											<?php
											echo create_category_treelist(
												$categories,
												array(),
												$this->categories_tree->row_count
											);
											?>

												</div>
											</div>
											<span class="help-block small"><em> select categories </em></span>
											<?php
											/**********
											 * Poppulate the slugs on this hidden input
											 */
											$cat_slugs = '';
											foreach ($this->product_details->categories as $cat_id)
											{
												$c_slug = $this->categories_tree->get_slug($cat_id);
												$this->cat_slugs =
													$this->cat_slugs != ''
													? $this->cat_slugs.','.$c_slug
													: $c_slug
												;
											}
											?>
											<input type="hidden" name="category_slugs" value="<?php echo $this->cat_slugs; ?>" />
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<?php if ($this->uri->segment(3) === 'add') { ?>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products'); ?>" type="button" class="btn dark btn-outline">Cancel</a>
									<?php } else { ?>
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
									<?php } ?>
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
