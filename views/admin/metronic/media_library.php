                    <!-- BEGIN PAGE CONTENT BODY -->
					
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box blue">
							
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> <?php echo $page_title; ?> </span>
                                    </div>
									<!-- DOC: Remove "hide" class to enable -->
                                    <div class="actions hide">
                                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                                <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                            <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="portlet-body">
								
									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
										$this->config->slash_item('admin_folder').'media_library/products', 
										array(
											'id'=>'form-admin_media_library_products_filters'
										)
									); ?>
									
									<div class="row margin-bottom-30">
										<div class="alert alert-danger display-hide">
											<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
										<div class="col-xs-12 col-sm-3">
											<div class="form-group">
												<select class="bs-select form-control" id="media_date" name="media_date" data-live-search="true" data-size="5">
													<option value="all" <?php echo $media_date == 'all' ? 'selected="selected"' : ''; ?>>
														All dates
													</option>
													<?php if (@$year_months) { ?>
													<?php foreach (@$year_months as $date) { ?>
													<option value="<?php echo $date; ?>" <?php echo $media_date == $date ? 'selected="selected"' : ''; ?>>
														<?php echo $date; ?>
													</option>
													<?php } ?>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-xs-12 col-sm-3">
											<input class="btn btn-primary" type="submit" name="filter_proucts" value="Apply Filter" />
										</div>
									</div>
									
									</form>
									<!-- End FORM ===================================================================-->
									<!-- END FORM-->
								
									<?php
									/**********
									 * Notifications
									 */
									?>
									<div>
										<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> There was an error with your request. Please try again.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'zero_search_result') { ?>
										<div class="alert alert-danger">
											<button class="close" data-close="alert"></button> There were no records of the search.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'post_data_error') { ?>
										<div class="alert alert-danger ">
											<button class="close" data-close="alert"></button> An error occured in posting data. Error - <br />
											<?php echo $this->session->flashdata('error_value') ?: 'Unknown'; ?>
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'add') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> New Product Media ADDED!
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Product Media information updated.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'delete') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Product Media deleted from records.
										</div>
										<?php } ?>
									</div>
                                    
									<?php
									/**********
									 * Table Toolbar
									 */
									?>
									<div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <a href="javascript:;" class="btn sbold blue disabled-link disable-target"> Add New Media
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="btn-group pull-right hide">
												
													<!-- FORM =======================================================================-->
													<?php echo form_open($this->config->slash_item('admin_folder').'products/set_active_designer_category', array('id'=>'form-product_list_view_as')); ?>
													
													<input type="hidden" id="view_as" name="view_as" value="products_list" />
													
													<a class="btn btn-link" style="color:black;text-decoration:none;cursor:default;" disabled>
														View as:
													</a>
                                                    <button class="btn blue btn-<?php echo $view_as == 'media_products_list' ? 'blue' : 'outline'; ?> tooltips" data-container="body" data-placement="top" data-original-title="List" onclick="$('#loading').modal('show');return $('#view_as').val('products_list');">
                                                        <i class="glyphicon glyphicon-list"></i>
                                                    </button>
                                                    <button class="btn blue btn-<?php echo $view_as == 'media_products_grid' ? 'blue' : 'outline'; ?> tooltips" data-container="body" data-placement="top" data-original-title="Grid" onclick="$('#loading').modal('show');return $('#view_as').val('products_grid');">
                                                        <i class="glyphicon glyphicon-th"></i>
                                                    </button>
													
													</form>
													<!-- End FORM ===================================================================-->
													<!-- END FORM-->
												
                                                </div>
                                            </div>
                                        </div>
									</div>
									
									<?php
									$this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').$view_as, $this->data); 
									?>

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

			<!-- BEGIN PAGE MODALS -->
			<!-- PRODUCT MEDIA PROPERTIES -->
			<div class="modal fade bs-modal-full" id="modal-product_media_properties" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-full">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Image Properties</h4>
						</div>
						<div class="modal-body"> 
							<div class="col-md-4" style="height:100%;">
								<img id="img-src" src="https://www.shop7thavenue.com/uploads/products/2018/07/TOD001_BLAC1_f.jpg" style="max-width:100%;max-height:100%;" />
							</div>
							<div class="col-md-8">
								File name: &nbsp; <span id="media_filename"></span> <br />
								Uploaded on: &nbsp; <span id="media_timestamp"></span> <br />
								Dimensions: &nbsp; <span id="media_dimensions"></span> <br />
								<br />
								File location URL: &nbsp; <span id="media_location"></span>
								<hr />
								URL (of Main Image View used on frontend): 
								<input class="form-control" type="text" readonly id="main_view" value="" /> <br />
								<hr />
								Attached to: &nbsp; <em><a href="" target="_blank" id="attached_to"></a></em>
								<br />
								<br />
								<hr />
								<em><a href="#delete-media" data-toggle="modal">Delect Permanently</a></em>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark green" data-dismiss="modal">Close</button>
							<a href="javascript:;" type="button" class="btn green mt-ladda-btn ladda-button hide" data-style="expand-left">
								<span class="ladda-label">Ok</span>
								<span class="ladda-spinner"></span>
							</a>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- DELETE ITEM -->
			<div class="modal fade bs-modal-md" id="delete-media" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Warning!</h4>
						</div>
						<div class="modal-body"> 
							Permanently DELETE item? <br /> This cannot be undone! 
							<div class="note note-danger">
								<h4 class="block">Danger! </h4>
								<p> Please ensure that the media is not attached to any product item. </p>
								<br />
								<p> This action will delete the entire product media items - main and thumbs of all views, and linesheets. </p>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<a href="javascript:;" type="button" class="btn green mt-ladda-btn ladda-button delete-media-modal" data-style="expand-left">
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
			
			
			<!-- END PAGE MODALS -->
			