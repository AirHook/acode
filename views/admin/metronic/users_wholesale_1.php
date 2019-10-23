                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        (
                            $this->uri->segment(1) === 'sales'
                            ? 'sales/wholesale/bulk_actions'
                            : $this->config->slash_item('admin_folder').'users/wholesale/bulk_actions'
                        ),
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-wholesale_users_bulk_actions'
                        )
                    ); ?>

                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="nortifications">
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
                        <?php if ($this->session->flashdata('success') == 'pacakge_sent') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Sales pacakge was sent via email.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('success') == 'acivation_email_sent') { ?>
                        <div class="alert alert-success auto-remove">
                            <button class="close" data-close="alert"></button> Activation email sent successfully.
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
                        <?php if ($this->session->flashdata('error') == 'error_sending_package') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> There was an error sending sales pacakge.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'recent_item_needs_updating') { ?>
                        <div class="alert alert-danger ">
                            <button class="close" data-close="alert"></button> The Recent Items Sales Package is outdated. Please update the Recent Items Sales Package <a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/index/1'); ?>">here</a>.
                        </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error') == 'error_sending_activation_email') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> There was an error sending the activation email.<br /><?php echo $this->session->flashdata('error_message'); ?>
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
                                    <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale/add') : site_url($this->config->slash_item('admin_folder').'users/wholesale/add'); ?>" class="btn sbold blue"> Add a New User
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
                                    <?php if ($this->uri->segment(1) == 'sales')
                                    { ?>
                                        <option value="ac" disabled>Send Pre Orer Package</option>
                                        <option value="su" disabled>Send In Stock Package</option>
                                        <option value="ac" disabled>Send Best Seller Package</option>
                                        <option value="su" disabled>Send Off Price Package</option>
                                        <?php
                                    } ?>
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
                    <table class="table table-striped table-bordered table-hover order-column dt-responsive" width="100%" id="tbl-users_wholesale">
                        <thead>
                            <tr>
                                <th class="min-tablet hidden-xs hidden-sm"> <!-- counter --> </th>
                                <th class="all text-center hidden-xs hidden-sm">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-users_wholesale .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th class="none"> Username </th> <!-- fname + lname -->
                                <th class="all"> Store Name </th>
                                <th class="min-tablet"> Email </th>
                                <th class="min-tablet"> Designer </th>
                                <th class="none"> Sales </th> <!-- fname + lname -->
                                <th class="none"> Create Date </th>
                                <th class="min-tablet hidden-xs hidden-sm"> Last Login </th>
                                <th class="min-tablet hidden-xs hidden-sm"> Visits </th>
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
                                {
                                    $edit_link =
                                        $this->uri->segment(1) === 'sales'
                                        ? site_url('sales/wholesale/edit/index/'.$user->user_id)
                                        : site_url($this->config->slash_item('admin_folder').'users/wholesale/edit/index/'.$user->user_id)
                                    ; ?>

                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs hidden-sm">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center hidden-xs hidden-sm">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $user->user_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> <?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)); ?> </td>
                                <td> <?php echo $user->store_name; ?> </td>
                                <td>
                                    <a href="<?php echo $edit_link; ?>"><?php echo $user->email; ?></a>
                                    &nbsp;
                                    <a class="hidden_first_edit_link" style="display:none;" href="<?php echo $edit_link; ?>"><small><cite>edit</cite></small></a>
                                </td>
                                <td> <?php echo $user->designer; ?> </td>
                                <td> <?php echo ucwords(strtolower($user->admin_sales_user.' '.$user->admin_sales_lname)); ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->create_date; ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->xdate; ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->visits_after_activation; ?> </td>
                                <td>
                                    <span class="label label-sm label-<?php echo $user->is_active == '1' ? 'success': (($user->is_active == '0' && $user->comments == 'Optout') ? 'warning' : 'danger'); ?>"> <?php echo $user->is_active == '1' ? 'Active' : (($user->is_active == '0' && $user->comments == 'Optout') ? 'Optout' : 'Suspended'); ?> </span>
                                    <!--
                                    <span class="label label-sm label-<?php echo $user->is_active == '1' ? 'success' : (($user->is_active == '0' && $user->comments == 'Optout') ? 'warning' : 'danger'); ?>">
                                        <?php echo $user->is_active == '1' ? '<i class="fa fa-check"></i>' : (($user->is_active == '0' && $user->comments == 'Optout') ? '<i class="fa fa-ban"></i>' : '<i class="fa fa-close"></i>'); ?>
                                    </span>
                                -->
                                </td>
                                <!-- ACTIONS column -->
                                <td class="dropdown-wrap dropdown-fix">
                                    <div class="btn-group" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="<?php echo $edit_link; ?>">
                                                    <i class="icon-pencil"></i> Edit </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#<?php echo $user->is_active == '1' ? 'suspend': 'activate'; ?>-<?php echo $user->user_id; ?>">
                                                    <i class="icon-<?php echo $user->is_active == '1' ? 'ban': 'check'; ?>"></i> <?php echo $user->is_active == '1' ? 'Suspend': 'Activate'; ?> </a>
                                            </li>
                                            <?php if ($user->is_active == '1') { ?>
                                            <li>
                                                <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale/send_activation_email/index/'.$user->user_id) : site_url($this->config->slash_item('admin_folder').'users/wholesale/send_activation_email/index/'.$user->user_id); ?>" onclick="$('#loading .modal-title').html('Sending activation email...');$('#loading').modal('show');">
                                                    <i class="icon-envelope"></i> Send Activation Email </a>
                                            </li>
                                            <?php } ?>
                                            <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                                            { ?>
                                            <li>
                                                <?php if ($default_sales_package) { ?>
                                                <a data-toggle="modal" href="#send_recent-<?php echo $user->user_id?>">
                                                <?php } else { ?>
                                                <a data-toggle="modal" href="#no_default_sales_package">
                                                <?php  } ?>
                                                    <i class="icon-envelope"></i> Send Recent Items Sales Package </a>
                                            </li>
                                                <?php
                                            } ?>
                                            <?php if ($this->uri->segment(1) == 'sales')
                                            { ?>
                                            <li>
                                                <a data-toggle="modal" href="#sales_package_not_yet_available">
                                                    <i class="icon-envelope"></i> Send Pre Orer Package
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#sales_package_not_yet_available">
                                                    <i class="icon-envelope"></i> Send In Stock Package
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#sales_package_not_yet_available">
                                                    <i class="icon-envelope"></i> Send Best Seller Package
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#sales_package_not_yet_available">
                                                    <i class="icon-envelope"></i> Send Off Price Package
                                                </a>
                                            </li>
                                                <?php
                                            } ?>
                                            <li>
                                                <a data-toggle="modal" href="#delete-<?php echo $user->user_id; ?>">
                                                    <i class="icon-trash"></i> Delete </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale/add') : site_url($this->config->slash_item('admin_folder').'users/wholesale/add'); ?>">
                                                    <i class="fa fa-plus"></i> Add User </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- ITEM CONFIRM SEND RECENT ITEMS -->
                                    <div class="modal fade bs-modal-sm" id="send_recent-<?php echo $user->user_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Send Recent Items</h4>
                                                </div>
                                                <div class="modal-body"> You are about to send to user recent 30 items from designer:<br /><br /><?php echo $user->designer; ?> </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                                                    <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale/send_package/index/'.$user->user_id) : site_url($this->config->slash_item('admin_folder').'users/wholesale/send_package/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
                                                        <span class="ladda-label">Continue...</span>
                                                        <span class="ladda-spinner"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <!-- ITEM SUSPEND -->
                                    <div class="modal fade bs-modal-sm" id="suspend-<?php echo $user->user_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> Are you sure you want to SUSPEND user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale/suspend/index/'.$user->user_id) : site_url($this->config->slash_item('admin_folder').'users/wholesale/suspend/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <div class="modal fade bs-modal-sm" id="activate-<?php echo $user->user_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> ACTIVATE user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale/activate/index/'.$user->user_id) : site_url($this->config->slash_item('admin_folder').'users/wholesale/activate/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $user->user_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Warning!</h4>
                                                </div>
                                                <div class="modal-body"> DELETE user? <br /> This cannot be undone! </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale/delete/index/'.$user->user_id) : site_url($this->config->slash_item('admin_folder').'users/wholesale/delete/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-wholesale_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-wholesale_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-wholesale_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- SALES PACKAGE NOT YET AVAILABLE -->
					<div class="modal fade bs-modal-sm" id="sales_package_not_yet_available" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Uh Oh!</h4>
								</div>
								<div class="modal-body"> Ooops... Sales Package not yet availble. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
