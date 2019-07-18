                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/vendor/bulk_actions',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-vendor_users_bulk_actions'
                        )
                    ); ?>

                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="notifications">
                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> New Vendor ADDED!
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'edit') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Vendor information updated.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'delete') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Vendor permanently removed from records.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> An error occured. Please try again.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'post_data_error') { ?>
                        <div class="alert alert-danger ">
                            <button class="close" data-close="alert"></button> An error occured in posting data. Error - <br />
                            <?php echo $this->session->flashdata('error_value'); ?>
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'user_not_found') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> Vendor not found.
                        </div>
                        <?php } ?>
                    </div>

                    <div class="table-toolbar">

                        <?php
                        // available only on hub sites for now
                        if ($this->webspace_details->options['site_type'] == 'hub_site')
                        { ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/add'); ?>" class="btn sbold blue">
                                        Add a New Vendor
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                        <br />

                            <?php
                        } ?>

                        <div class="row">

                            <div class="col-lg-3 col-md-4">
                                <select class="bs-select form-control selectpicker" id="bulk_actions_select" name="bulk_action" disabled>
                                    <option value="" selected="selected">Bulk Actions</option>
                                    <option value="ac">Activate</option>
                                    <option value="su">Suspend</option>
                                    <option value="del">Permanently Delete</option>
                                </select>
                            </div>
                            <button class="btn green hidden-sm hidden-xs" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

                        </div>
                        <button class="btn green hidden-lg hidden-md" id="apply_bulk_actions" data-toggle="modal" href="#confirm_bulk_actions" disabled> Apply </button>

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
                        table.dataTable > tbody > tr.child span.dtr-title {
                            min-width: 125px;
                        }
                    </style>
                    <table class="table table-striped table-bordered table-hover order-column dt-responsive" width="100%" id="tbl-users_vendor">
                        <thead>
                            <tr>
                                <th class="min-tablet hidden-xs hidden-sm"> <!-- counter --> </th>
                                <th class="all text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-users_vendor .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th class="all"> Vendor Name </th>
                                <th class="all"> Code </th>
                                <th class="min-tablet"> Main Email </th>
                                <th class="min-tablet"> Vendor Type </th>
                                <th class="min-tablet"> Ref Designer </th>
                                <th class="min-tablet"> Country </th>
                                <th class="none"> Contact1 </th>
                                <th class="none"> Contact Email1 </th>
                                <th class="none"> Contact2 </th>
                                <th class="none"> Contact Email2 </th>
                                <th class="none"> Contact3 </th>
                                <th class="none"> Contact Email3 </th>
                                <th> Status </th>
                                <th class="all"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($users)
                            {
                                $i = 1;
                                foreach ($users as $user)
                                { ?>

                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs hidden-sm">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $user->vendor_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> <?php echo $user->vendor_name; ?>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/edit/index/'.$user->vendor_id); ?>" class="small"> <cite> edit </cite> </a>
                                </td>
                                <td> <?php echo $user->vendor_code; ?> </td>
                                <td> <?php echo $user->vendor_email; ?> </td>
                                <td> <?php echo $user->type; ?> </td>
                                <td> <?php echo $user->designer; ?> </td>
                                <td> <?php echo $user->country; ?> </td>
                                <td> <?php echo $user->contact_1; ?> </td>
                                <td> <?php echo $user->contact_email_1; ?> </td>
                                <td> <?php echo $user->contact_2; ?> </td>
                                <td> <?php echo $user->contact_email_2; ?> </td>
                                <td> <?php echo $user->contact_2; ?> </td>
                                <td> <?php echo $user->contact_email_3; ?> </td>
                                <td>
                                    <span class="label label-sm label-<?php echo $user->is_active == '1' ? 'success': 'danger'; ?>"> <?php echo $user->is_active == '1' ? 'Active': 'Suspended'; ?> </span>
                                </td>
                                <td class="dropdown-wrap dropdown-fix">
                                    <div class="btn-group" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/edit/index/'.$user->vendor_id); ?>">
                                                    <i class="icon-pencil"></i> Edit </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#<?php echo $user->is_active == '1' ? 'suspend': 'activate'; ?>-<?php echo $user->vendor_id; ?>">
                                                    <i class="icon-<?php echo $user->is_active == '1' ? 'ban': 'check'; ?>"></i> <?php echo $user->is_active == '1' ? 'Suspend': 'Activate'; ?> </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#delete-<?php echo $user->vendor_id; ?>">
                                                    <i class="icon-trash"></i> Delete </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/add'); ?>">
                                                    <i class="fa fa-plus"></i> Add User </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- ITEM SUSPEND -->
                                    <div class="modal fade bs-modal-sm" id="suspend-<?php echo $user->vendor_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> Are you sure you want to SUSPEND user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/suspend/index/'.$user->vendor_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <!-- ITEM ACTIVATE -->
                                    <div class="modal fade bs-modal-sm" id="activate-<?php echo $user->vendor_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> ACTIVATE user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/activate/index/'.$user->vendor_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <!-- ITEM DELETE -->
                                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $user->vendor_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Warning!</h4>
                                                </div>
                                                <div class="modal-body"> DELETE user? <br /> This cannot be undone! </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/delete/index/'.$user->vendor_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                </td>
                            </tr>

                                    <?php
                                    $i++;
                                }
                            } ?>

                        </tbody>
                    </table>

                    </form>
                    <!-- End FORM =======================================================================-->
                    <!-- END FORM-->

					<!-- BULK ACTIVATE -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-ac" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Activate!</h4>
								</div>
								<div class="modal-body"> Activate multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-vendor_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- BULK SUSPEND -->
					<div class="modal fade bs-modal-sm" id="confirm_bulk_actions-su" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Suspend!</h4>
								</div>
								<div class="modal-body"> Suspend or Deactivate multiple items? </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button onclick="$('#form-vendor_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
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
									<button onclick="$('#form-vendor_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- NO DEFAUL SALES PACKAGE -->
					<div class="modal fade bs-modal-sm" id="no_default_sales_package" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Uh Oh!</h4>
								</div>
								<div class="modal-body"> There is no set defaul Sales Package? <br /> Please set one <a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package'); ?>">here</a>. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
