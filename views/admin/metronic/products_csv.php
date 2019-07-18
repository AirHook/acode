                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">

                                <div class="portlet-title">
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

                                <div class="portlet-body">

									<?php
									/**********
									 * Notifications
									 */
									?>
                                    <div class="row">
									    <div class="col-md-12">

                                            <div class="note note-warning">
                                                <h4 class="block">Datatable Editing</h4>
                                                <p> Table is expanded as far to the right to accomodate as many columns as possible. SCROLL to the right to see more columns. </p>
                                                <p> EDIT / SAVE can be found at both ends of the row. DELETE a row however is located at end of the row only. </p>
                                            </div>
                                            <div class="note note-warning">
                                                <h4 class="block">Size Mode Limit</h4>
                                                <p> Due to the possibilities of different size mode per designer, we are limiting this product listing to categories per designer basis. No generalized categories listings included. </p>
                                            </div>

    										<div id="an_error_occured" class="alert alert-danger display-hide">
    											<button class="close" data-close="alert"></button> An error occured. Please try again. </div>
    										<div id="new_user_added" class="alert alert-success display-hide">
    											<button class="close" data-close="alert"></button> New User ADDED! </div>
    										<div id="information_updated" class="alert alert-success display-hide">
    											<button class="close" data-close="alert"></button> Information updated </div>
    										<?php if ($this->session->flashdata('error') == 'csv_headers_error') { ?>
    										<div class="alert alert-danger ">
    											<button class="close" data-close="alert"></button> CSV File was not authenticated properly. Please download a fresh CSV File before editing file.
    										</div>
    										<?php } ?>
    										<?php if ($this->session->flashdata('success') == 'csv_update') { ?>
    										<div class="alert alert-success ">
    											<button class="close" data-close="alert"></button> CSV File being updated.
    										</div>
    										<?php } ?>
    										<?php if ($this->session->flashdata('success') == 'csv_upload_update') { ?>
    										<div class="alert alert-success auto-remove">
    											<button class="close" data-close="alert"></button> CSV File uploaded and records have been updated.
    										</div>
    										<?php } ?>
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
									</div>

                                    <!-- TOOLBAR -->
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
													<button id="add_new_product" class="btn sbold blue"> Add New Product
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="btn-group">
													<button id="cancel_edit" class="btn sbold red-flamingo display-hide"> Cancel Edit
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
												<div class="btn-group pull-right">
													<button class="btn green btn-solid dropdown-toggle" data-toggle="dropdown" aria-expanded="false">CSV Tools
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu pull-right tooltips " data-container="body" data-placement="left" data-original-title="Always update CSV file to enable download and to ensure getting most recent information. It is recommended to minimize selected categories especially to only 1 category on the filter before updating and downloading csv file.">
														<li>
															<a href="<?php echo site_url('admin/products/csv/update_csv_file'); ?>" onclick="$('#loading').modal('show');">
																<i class="fa fa-save"></i> Update CSV File </a>
														</li>
														<li class="divider"> </li>
														<li>
															<?php if ($csv_filename) { ?>
															<a href="<?php echo base_url(); ?>csv/products/<?php echo $csv_filename; ?>.php">
															<?php } else { ?>
															<a href="javascript:;" class="disabled-link disable-target">
															<?php } ?>
																<i class="fa fa-download"></i> Download CSV File </a>
														</li>
														<li>
															<a href="javascript:;" class="disabled-link disable-target">
															<!--<a href="#modal-csv_upload" data-toggle="modal">-->
																<i class="fa fa-upload"></i> Upload CSV File </a>
														</li>
													</ul>
												</div>
											</div>
                                        </div>
                                    </div>

                                    <?php
									/**********
									 * Editabe Datable
									 */
									?>
                                    <?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'products_csv_table'); ?>

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
			<!-- CSV FILE UPLOAD -->
			<div class="modal fade bs-modal-lg" id="modal-csv_upload" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" id="modal-csv_upload-modal-dialog">
					<div class="modal-content" id="modal-csv_upload-modal-content">

						<!-- BEGIN FORM-->
						<!-- FORM =======================================================================-->
						<?php echo form_open(
							$this->config->slash_item('admin_folder').'products/csv/upload_csv_file',
							array(
								'method'=>'POST',
								'enctype'=>'multipart/form-data',
								'class'=>'form-horizontal',
								'id'=>'form-products_upload_csv'
							)
						); ?>

						<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url(); ?>" />

						<div class="modal-header">
							<button type="button" class="close modal-close_btn" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Upload Wholesale User CSV File</h4>
						</div>
						<div class="modal-body">
							<strong>NOTES:</strong>
							<ol>
								<li>Data from CSV file will overwrite data on record.</li>
								<li>CSV File Upload is to update records only. No data from server will be deleted. If it is a must to delete records, go to the regular Product List <a href="<?php echo site_url($this->config->slash_item('admin_folder').'products'); ?>">here</a> and do a bulk action delete instead.</li>
								<li>The system will update existing record per 'Product ID'.</li>
								<li>For NEW PRODUCTs, please ensure that Product ID column is empty, then record will be added creating a new Product ID.</li>
								<li>CSV file headers will be cross checked againts set record fields and validated accordingly. If header differences are found, file will not be uploaded. Download updated CSV file instead, and then, do the edits again.</li>
							</ol>
							<div class="note note-success">
								<h4 class="block">Notorioius EXEL behaviour</h4>
								<p> Exel has an inherent way of changing data especially numbers like turning rather large regular numbers to scientific notations. It is best to edit the data directly here on this CSV Manage Products page as oppose to editing CSV files via Exel. </p>
							</div>
							<br /><br />
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="input-group input-large">
									<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
										<i class="fa fa-file fileinput-exists"></i>&nbsp;
										<span class="fileinput-filename"> </span>
									</div>
									<span class="input-group-addon btn default btn-file">
										<span class="fileinput-new"> Select file </span>
										<span class="fileinput-exists"> Change </span>
										<input type="file" name="file"> </span>
									<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
								</div>
							</div>
							<br /><br />
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline modal-close_btn" data-dismiss="modal">Close</button>
							<button type="sbumit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left" disabled id="btn-csv_upload">
								<span class="ladda-label">Upload</span>
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
			<!-- END PAGE MODALS -->
