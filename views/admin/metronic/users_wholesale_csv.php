                    <div class="row ">
                        <div class="col-md-12">

                            <div class="m-heading-1 border-green m-bordered">
                                <h3>CSV Manage Wholesale User</h3>
                                <strong>NOTES:</strong>
                                <ol>
                                    <li>Scroll the bottom horizontal scroll bar of table to access all fields as well as cacel/delete button.</li>
                                    <li>CSV Tools are available via the drop down button to the right.</li>
                                </ol>
                            </div>

                            <?php
                            /***********
                             * Noification area
                             */
                            ?>
                            <div class="notifications">
                                <div id="an_error_occured" class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> An error occured. Please try again. </div>
                                <div id="new_user_added" class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> New User ADDED! </div>
                                <div id="information_updated" class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Information updated </div>
                                <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                                <div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button> An error occured. Please try again.
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') == 'csv_headers_error') { ?>
                                <div class="alert alert-danger ">
                                    <button class="close" data-close="alert"></button> CSV File was not authenticated properly. Please download a fresh CSV File before editing file.
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'csv_update') { ?>
                                <div class="alert alert-success ">
                                    <button class="close" data-close="alert"></button> CSV File being updated in the background. Come back again after a while to download file.
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'csv_upload_update') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> CSV File uploaded and records have been updated.
                                </div>
                                <?php } ?>
                            </div>

                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <button id="add_new_user" class="btn sbold blue"> Add a New User
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button id="cancel_edit_user" class="btn sbold red-flamingo display-hide"> Cancel Edit
                                                <i class="fa fa-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="btn-group pull-right">
                                            <button class="btn green btn-solid dropdown-toggle" data-toggle="dropdown" aria-expanded="false">CSV Tools
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right tooltips" data-container="body" data-placement="left" data-original-title="Always update CSV file before downloading to ensure getting most recent information">
                                                <li>
                                                    <a href="<?php echo site_url('admin/users/wholesale/csv/update_csv_file'); ?>" onclick="$('#loading').modal('show');">
                                                        <i class="fa fa-save"></i> Update CSV File </a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>csv/users/users_wholesale_shop7thavenue_hub_site.php">
                                                        <i class="fa fa-download"></i> Download CSV File </a>
                                                </li>
                                                <li>
                                                    <a href="#modal-csv_upload" data-toggle="modal">
                                                        <i class="fa fa-upload"></i> Upload CSV File </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                            <table class="table table-striped table-condensed table-bordered table-hover dataTable" width="100%" id="tbl-users_wholesale_csv">
                                <thead>
                                    <tr>
                                        <th class="all"> Edit </th>
                                        <th class="none"> User ID </th>
                                        <th class="none"> First Name </th> <!-- fname + lname -->
                                        <th class="none"> Last Name </th> <!-- fname + lname -->
                                        <th class="all"> Store Name </th>
                                        <th class="min-tablet"> Email </th>
                                        <th class="min-tablet hidden-xs"> Designer </th>
                                        <th class="none"> Sales </th> <!-- fname + lname -->
                                        <th> Address1 </th>
                                        <th> Address2 </th>
                                        <th> City </th>
                                        <th> State </th>
                                        <th> Country </th>
                                        <th> Zip Code </th>
                                        <th> Telephone </th>
                                        <th> Fax </th>
                                        <th> Fed Tax Id </th>
                                        <th> Comments </th>
                                        <th class="min-tablet hidden-xs"> Status </th>
                                        <th class="all"> Del </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($users)
                                    {
                                        $i = 1;
                                        foreach ($users as $user)
                                        { ?>

                                    <tr class="odd gradeX ">
                                        <td> <a class="edit" href="javascript:;">Edit</a> </td>
                                        <td class="text-center"> <?php echo $user->user_id; ?> </td>
                                        <td> <?php echo ucwords(strtolower($user->firstname)); ?> </td>
                                        <td> <?php echo ucwords(strtolower($user->lastname)); ?> </td>
                                        <td> <?php echo $user->store_name; ?> </td>
                                        <td> <?php echo $user->email; ?> </td>
                                        <td class="popovers" data-trigger="focus" data-placement="top" data-container="body" data-original-title="Reference Active Designer Options:" data-content="<?php foreach($designers as $designer){ echo $designer->url_structure.', '; }?>"> <?php echo $user->reference_designer; ?> </td>
                                        <td class="popovers" data-trigger="focus" data-placement="top" data-container="body" data-original-title="Active Sales User Options:" data-content="<?php foreach($sales_users as $sales_user){ echo $sales_user->admin_sales_email.', '; }?>"> <?php echo $user->admin_sales_email; ?> </td>
                                        <td> <?php echo $user->address1; ?> </td>
                                        <td> <?php echo $user->address2; ?> </td>
                                        <td> <?php echo $user->city; ?> </td>
                                        <td> <?php echo $user->state; ?> </td>
                                        <td> <?php echo $user->country; ?> </td>
                                        <td> <?php echo $user->zipcode; ?> </td>
                                        <td> <?php echo $user->telephone; ?> </td>
                                        <td> <?php echo $user->fax; ?> </td>
                                        <td> <?php echo $user->fed_tax_id; ?> </td>
                                        <td> <?php echo $user->comments; ?> </td>
                                        <td class="popovers" data-trigger="focus" data-placement="top" data-container="body" data-original-title="Status Options:" data-content="1 - active, 0 and 2 are both inactive/suspended"> <?php echo $user->is_active; ?> </td>
                                        <td> <a class="delete" href="javascript:;">Delete</a> </td>
                                    </tr>

                                            <?php
                                            $i++;
                                        }
                                    } ?>

                                </tbody>
                            </table>

                        </div>
					</div>

					<!-- CSV FILE UPLOAD -->
					<div class="modal fade bs-modal-lg" id="modal-csv_upload" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg" id="modal-csv_upload-modal-dialog">
							<div class="modal-content" id="modal-csv_upload-modal-content">

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open(
									$this->config->slash_item('admin_folder').'users/wholesale/csv/upload_csv_file',
									array(
										'method'=>'POST',
										'enctype'=>'multipart/form-data',
										'class'=>'form-horizontal',
										'id'=>'form-wholesale_users_upload_csv'
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
										<li>CSV File Upload is to update records only. No data from server will be deleted. If it is a must to delete records, go to the regular Wholesale User List <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/wholesale'); ?>">here</a> and do a bulk action delete instead.</li>
										<li>The system will update existing record per 'User ID'.</li>
										<li>For NEW USERs, please ensure that User ID column is empty, then record will be added creating a new User ID.</li>
										<li>CSV file headers will be cross checked againts set record fields and validated accordingly. If header differences are found, file will not be uploaded. Download updated CSV file instead, and then, do the edits again.</li>
									</ol>
									<div class="note note-success">
										<h4 class="block">Notorioius EXEL behaviour</h4>
										<p> Exel has an inherent way of changing data especially numbers like turning telephone numbers to scientific notations. It is best to edit the data directly here on this CSV Manage User page as oppose to editing CSV files via Exel. </p>
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
