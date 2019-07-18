                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">

								<!-- DOC: Remove "hide" class to enable -->
                                <div class="portlet-title hide">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> <?php echo $page_title; ?> Table</span>
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

                                <div class="portlet-body search-page" data-active_designer="<?php echo @$active_designer; ?>" data-active_category="<?php echo @$active_category; ?>">

									<?php
									/**********
									 * Notifications
									 */
									?>
                                    <div class="">
    									<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
    									<div class="alert alert-danger auto-remove">
    										<button class="close" data-close="alert"></button> There was an error with your request. Please try again.
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
    										<button class="close" data-close="alert"></button> New Product ADDED!
    									</div>
    									<?php } ?>
    									<?php if ($this->session->flashdata('success') == 'edit') { ?>
    									<div class="alert alert-success auto-remove">
    										<button class="close" data-close="alert"></button> Product information updated.
    									</div>
    									<?php } ?>
    									<?php if ($this->session->flashdata('success') == 'delete') { ?>
    									<div class="alert alert-success auto-remove">
    										<button class="close" data-close="alert"></button> Product permanently removed from records.
    									</div>
    									<?php } ?>
                                    </div>

									<!-- DOC: Must have search css at <head>-->
									<!-- DOC: Must add class "search-page" to parent div to enable css-->
									<div class="search-bar bordered">
										<div class="row">
											<!-- FORM =======================================================================-->
											<?php echo form_open(
												$this->config->slash_item('admin_folder').'search',
												array(
													'method'=>'POST',
													'id'=>'form-admin_search_page_search'
												)
											); ?>
											<div class="col-lg-8">
												<div class="input-group">
													<input type="text" class="form-control search_by_style" name="style_no" placeholder="Search for..." style="text-transform:uppercase;">
													<span class="input-group-btn">
														<button class="btn green-soft uppercase bold" type="submit">Search</button>
													</span>
												</div>
											</div>
											<div class="col-md-4">
												<p class="search-desc clearfix"> Go ahead and search for another item by typing on the search box at the left. </p>
											</div>
											</form>
											<!-- End FORM ===================================================================-->
											<!-- END FORM-->
										</div>
									</div>

									<h1><small><em>Search results for:</em></small> "<?php echo $search_string; ?>"</h1>
									<br />

									<?php //$this->load->view($this->config->slash_item('admin_folder').''.$this->config->slash_item('admin_template').$view_as);
									$this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'products_list_search', $this->data); ?>

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
			<!-- BULK PUBLISH -->
			<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-0" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">UNPublish!</h4>
						</div>
						<div class="modal-body"> Are you sure you want to UNPUBLISH multiple items? </div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

			<!-- BULK UNPUBLISH -->
			<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-1" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Public!</h4>
						</div>
						<div class="modal-body"> Publish PUBLIC multiple items? </div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

			<!-- BULK PRIVATE -->
			<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-2" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Private!</h4>
						</div>
						<div class="modal-body"> Publish PRIVATE multiple items? </div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
							<a href="javascript:$('#form_product_list_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
								<span class="ladda-label">Confirm?</span>
								<span class="ladda-spinner"></span>
							</a>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- END PAGE MODALS -->
