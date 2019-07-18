                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/sales/bulk_actions',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-sales_users_bulk_actions'
                        )
                    ); ?>

                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div>
                        <?php if ($this->session->flashdata('success') == 'add') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> New User ADDED!
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'edit') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> User information updated.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'delete') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> User permanently removed from records.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> An error occured. Please try again.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'user_not_found') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> User not found.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'del_super_sales_not_allowed') { ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button> Deleting of super sales is not allowed. Please try again.
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
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/add'); ?>" class="btn sbold blue"> Add a New User
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
                    </style>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-users_sales">
                        <thead>
                            <tr>
                                <th class="hidden-xs hidden-sm"> <!-- counter --> </th>
                                <th class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-users_sales .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th> Username </th>
                                <th> Email </th>
                                <th> Designer </th>
                                <th> Level </th>
                                <th> Status </th>
                                <th> Actions </th>
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
                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $user->admin_sales_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> <?php echo ucwords(strtolower($user->admin_sales_user.' '.$user->admin_sales_lname)); ?> </td>
                                <td>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/edit/index/'.$user->admin_sales_id); ?>"> <?php echo $user->admin_sales_email; ?> </a>
                                    <?php if ($user->admin_sales_id == '1') { ?>
                                    <em style="color:grey;font-size:0.8em;"> (super sales)</em>
                                    <?php } ?>
                                    &nbsp;
                                    <a class="hidden_first_edit_link" style="display:none;" href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/edit/index/'.$user->admin_sales_id); ?>"><small><cite>edit</cite></small></a>
                                </td>
                                <td class="center">
                                    <?php
                                    foreach ($designers as $designer)
                                    {
                                        if (
                                            $user->admin_sales_designer == $designer->domain_name
                                            OR $user->admin_sales_designer == $designer->url_structure
                                        )
                                        {
                                            echo $designer->designer;
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="center"> <?php echo $user->access_level; ?> </td>
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
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/edit/index/'.$user->admin_sales_id); ?>">
                                                    <i class="icon-pencil"></i> Edit </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#<?php echo $user->is_active == '1' ? 'suspend': 'activate'; ?>-<?php echo $user->admin_sales_id; ?>">
                                                    <i class="icon-<?php echo $user->is_active == '1' ? 'ban': 'check'; ?>"></i> <?php echo $user->is_active == '1' ? 'Suspend': 'Activate'; ?> </a>
                                            </li>
                                            <?php if ($user->admin_sales_id !== '1') { ?>
                                            <li>
                                                <a data-toggle="modal" href="#delete-<?php echo $user->admin_sales_id; ?>">
                                                    <i class="icon-trash"></i> Delete </a>
                                            </li>
                                            <?php } ?>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/add'); ?>">
                                                    <i class="fa fa-cubes"></i> Add User </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- ITEM SUSPEND -->
                                    <div class="modal fade bs-modal-sm" id="suspend-<?php echo $user->admin_sales_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> Are you sure you want to SUSPEND user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/suspend/index/'.$user->admin_sales_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <div class="modal fade bs-modal-sm" id="activate-<?php echo $user->admin_sales_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> ACTIVATE user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/activate/index/'.$user->admin_sales_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $user->admin_sales_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Warning!</h4>
                                                </div>
                                                <div class="modal-body"> DELETE user? <br /> This cannot be undone! </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/delete/index/'.$user->admin_sales_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-sales_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-sales_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-sales_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
