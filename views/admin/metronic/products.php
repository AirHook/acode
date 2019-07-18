					<?php
					/**********
					 * Notifications
					 */
					?>
					<div class="notifications">
						<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> There was an error with your request. Please try again.
						</div>
						<?php } ?>
						<?php if ($this->session->flashdata('error') == 'zero_search_result') { ?>
						<div class="alert alert-danger">
							<button class="close" data-close="alert"></button> There were no records of the search. Please try to browse through products listing below.
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

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group <?php echo $this->webspace_details->options['site_type'] == 'sat_site' ? 'hide' : ''; ?>">
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/add'); ?>" class="btn sbold blue"> Add New Product
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">

									<!-- FORM =======================================================================-->
									<?php echo form_open($this->config->slash_item('admin_folder').'products/set_active_designer_category', array('id'=>'form-product_list_view_as')); ?>

									<input type="hidden" id="view_as" name="view_as" value="products_list" />
									<input type="hidden" id="uri_string" name="uri_string" value="<?php echo $this->uri->uri_string(); ?>" />

									<a class="btn btn-link" style="color:black;text-decoration:none;cursor:default;" disabled>
										View as:
									</a>
                                    <button class="btn blue btn-<?php echo $view_as == 'products_list' ? 'blue' : 'outline'; ?> tooltips" data-container="body" data-placement="top" data-original-title="List" onclick="$('#loading').modal('show');return $('#view_as').val('products_list');">
                                        <i class="glyphicon glyphicon-list"></i>
                                    </button>
                                    <button class="btn blue btn-<?php echo $view_as == 'products_grid' ? 'blue' : 'outline'; ?> tooltips" data-container="body" data-placement="top" data-original-title="Grid" onclick="$('#loading').modal('show');return $('#view_as').val('products_grid');">
                                        <i class="glyphicon glyphicon-th"></i>
                                    </button>

									</form>
									<!-- End FORM ===================================================================-->
									<!-- END FORM-->

                                </div>
                            </div>
                        </div>
					</div>

					<?php //$this->load->view($this->config->slash_item('admin_folder').''.$this->config->slash_item('admin_template').$view_as);
					$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').$view_as, $this->data); ?>

					<?php if ($view_as == 'products_list') { ?>

					<!-- DOC: Remove "hide" class to enable the heading -->
                    <div class="m-heading-1 border-blue m-bordered">
                        <h3>Tips!</h3>
                        <p> <strong>Sortable</strong> - all columns is sortable either ascending or descending and it sorts out the entire record collection and not just the visible items on the apge </p>
                        <p> <strong>Searchable</strong> - Search searches on all columns and rows. It basically filters the entire record set with records that contain the search string. For example, by typing 'active' will show only records with the word active thereby filter the column 'Status' with records having active status only. And, vice versa for 'suspended'. The downside, if other columns has the string 'active', it will display it despite having 'suspended' status. However unlikely, it can still happen. Typing the full string like name or email will show records with exact string match. </p>
                        <p> <strong>Display Count</strong> - by default, initial page load will display 15 records. Select according to liking. </p>
                        <p> <strong>Responsive</strong> - The talbe is reponsive and removes certain columns for mobile devices. As the media screens gets smaller, the table will automatically scroll from left to right using a scrollbar at the bottom. It is recommended to have the list display count set to minimum to be able to see the scrollbar immediately. </p>
						<p> <strong>Sequencing</strong> - User can select the order in which items appear in catalog by entering number from 0-10000 </p>
                    </div>

					<?php } ?>

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
						<div class="modal-body">
							Delete multiple items? <br /> This cannot be undone!
							<div class="note note-danger">
								<h4 class="block">Danger! </h4>
								<p> This action will delete the entire product item including its color variants. Please ensure you know what you are doing before proceeding. </p>
							</div>
						</div>
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
