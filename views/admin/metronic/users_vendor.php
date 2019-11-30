                    <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                    { ?>

                    <div class="table-toolbar">

                        <div class="row">

                            <div class="col-lg-3 col-md-4">
                                <select class="bs-select form-control" id="filter_by_designer_select" name="des_slug" data-live-search="true" data-size="5" data-show-subtext="true">
                                    <option class="option-placeholder" value="">Select Designer...</option>
                                    <option value="all">All Designers</option>
                                    <?php if ($this->webspace_details->options['site_type'] == 'hub_site_') { ?>
                                    <option value="<?php echo $this->webspace_details->slug; ?>" data-subtext="<em>Mixed Designers</em>" data-des_slug="<?php echo $this->webspace_details->slug; ?>" data-des_id="<?php echo $this->webspace_details->id; ?>" <?php echo $this->webspace_details->slug === @$des_slug ? 'selected="selected"' : ''; ?>>
                                        <?php echo $this->webspace_details->name; ?>
                                    </options>
                                    <?php } ?>
                                    <?php
                                    if (@$designers)
                                    {
                                        foreach ($designers as $designer)
                                        {
                                            if ($this->webspace_details->slug != $designer->url_structure)
                                            { ?>

                                    <option value="<?php echo $designer->url_structure; ?>" data-subtext="<em></em>" data-des_slug="<?php echo $designer->url_structure; ?>" data-des_id="<?php echo $designer->des_id; ?>" <?php echo $designer->url_structure === @$des_slug ? 'selected="selected"' : ''; ?>>
                                        <?php echo ucwords(strtolower($designer->designer)); ?>
                                    </option>

                                                <?php
                                            }
                                        }
                                    } ?>
                                </select>
                            </div>
                            <button class="apply_filer_by_designer btn dark hidden-sm hidden-xs" data-page_param="<?php echo $this->uri->segment(4); ?>"> Filter </button>

                        </div>
                        <button class="apply_filer_by_designer btn dark btn-block margin-top-10 hidden-lg hidden-md" data-page_param="<?php echo $this->uri->segment(4); ?>"> Filter </button>

                    </div>

                        <?php
                    } ?>

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

                        <style>
                            .nav > li > a {
                                padding: 8px 15px;
                                background-color: #eee;
                                color: #555;
                            }
                            .nav-tabs > li > a {
                                font-size: 12px;
                            }
                            .nav-tabs > li > a:hover {
                                background-color: #333;
                                color: #eee;
                            }
                        </style>

                        <ul class="nav nav-tabs">
                            <li class="<?php echo $this->uri->segment(4) == 'active' ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/users/vendor/active'); ?>">
                                    <?php echo $this->uri->segment(4) != 'active' ? 'Show' : ''; ?> Active User List
                                </a>
                            </li>
                            <li class="<?php echo $this->uri->segment(4) == 'inactive' ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/users/vendor/inactive'); ?>">
                                    <?php echo $this->uri->segment(4) != 'inactive' ? 'Show' : ''; ?> Inactive User List
                                </a>
                            </li>
                            <li class="<?php echo $this->uri->segment(4) == 'suspended' ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/users/vendor/suspended'); ?>">
                                    <?php echo $this->uri->segment(4) != 'suspended' ? 'Show' : ''; ?> Suspended Users
                                </a>
                            </li>
                            <?php
                            // available only on hub sites for now
                            if (
                                $this->webspace_details->options['site_type'] == 'hub_site'
                                OR $this->webspace_details->slug == 'tempoparis'
                            )
                            { ?>
                            <li>
                                <a href="<?php echo site_url('admin/users/vendor/add'); ?>">
                                    Add New User <i class="fa fa-plus"></i>
                                </a>
                            </li>
                                <?php
                            } ?>
                        </ul>

                        <br />

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
                    /***********
                     * Top Pagination
                     */
                    ?>
                    <?php if ( ! @$search) { ?>
                    <div class="row margin-bottom-10">
                        <div class="col-md-12 text-justify pull-right">
                            <span style="<?php echo $this->pagination->create_links() ? 'position:relative;top:15px;' : ''; ?>">
                                <?php if ($count_all == 0) { ?>
                                Showing 0 records
                                <?php } else { ?>
                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
                                <?php } ?>
                            </span>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                    <?php } ?>

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
                    <table class="table table-striped table-bordered table-hover order-column dt-responsive" width="100%" id="tbl-users_vendor_">
                        <thead>
                            <tr>
                                <th class="min-tablet hidden-xs hidden-sm" style="width:40px;"> <!-- counter --> </th>
                                <th class="all text-center" style="width:40px;">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-users_vendor_ .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th class="all"> Vendor Name </th>
                                <th class="all"> Code </th>
                                <th class="min-tablet"> Primary Email </th>
                                <th class="none"> Primary Contact </th>
                                <th class="min-tablet"> Vendor Type </th>
                                <th class="min-tablet"> Ref Designer </th>
                                <th class="min-tablet"> Country </th>
                                <th style="width:100px;"> Status </th>
                                <th class="all" style="width:80px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($users)
                            {
                                $i = 1;
                                foreach ($users as $user)
                                {
                                    $edit_link = site_url('admin/users/vendor/edit/index/'.$user->vendor_id);
                                    ?>

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
                                <td>
                                    <a href="<?php echo $edit_link; ?>">
                                        <?php echo $user->vendor_name; ?>
                                    </a>
                                </td>
                                <td> <?php echo $user->vendor_code; ?> </td>
                                <td> <?php echo $user->vendor_email; ?> </td>
                                <td> <?php echo $user->contact_1; ?> </td>
                                <td> <?php echo $user->type; ?> </td>
                                <td> <?php echo $user->designer; ?> </td>
                                <td> <?php echo $user->country; ?> </td>
                                <td>
                                    <?php if ($user->is_active == '1') { ?>
                                    <span class="label label-sm label-success"> Active </span>
                                    <?php } ?>
                                    <?php if ($user->is_active == '0') { ?>
                                    <span class="label label-sm label-danger"> Inactive </span>
                                    <?php } ?>
                                    <?php if ($user->is_active == '2') { ?>
                                    <span class="label label-sm label-warning"> Suspended </span>
                                    <?php } ?>
                                </td>
                                <td class="dropdown-wrap dropdown-fix">

                                    <!-- Edit -->
                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="Edit">
                                        <i class="fa fa-pencil font-dark"></i>
                                    </a>
                                    <?php if ($user->is_active == '0' OR $user->is_active == '2') { ?>
                                    <!-- Activate -->
                                    <a data-toggle="modal" href="#activate-<?php echo $user->vendor_id; ?>" class="tooltips" data-original-title="Activate">
                                        <i class="fa fa-check font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($user->is_active == '1' OR $user->is_active == '2') { ?>
                                    <!-- Set Inactive -->
                                    <a data-toggle="modal" href="#set-inactive-<?php echo $user->vendor_id; ?>" class="tooltips" data-original-title="Set Inactive">
                                        <i class="fa fa-ban font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($user->is_active == '0' OR $user->is_active == '1') { ?>
                                    <!-- Suspend -->
                                    <a data-toggle="modal" href="#suspend-<?php echo $user->vendor_id; ?>" class="tooltips" data-original-title="Suspend">
                                        <i class="fa fa-dot-circle-o font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <!-- Delete -->
                                    <a data-toggle="modal" href="#delete-<?php echo $user->vendor_id; ?>" class="tooltips" data-original-title="Delete">
                                        <i class="fa fa-trash font-dark"></i>
                                    </a>

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
                                                    <a href="<?php echo site_url('admin/users/vendor/suspend/index/'.$user->vendor_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <!-- ITEM SET INACTIVATE -->
                                    <div class="modal fade bs-modal-sm" id="set-inactive-<?php echo $user->vendor_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> Set INACTIVATE user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url('admin/users/vendor/deactivate/index/'.$user->vendor_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo site_url('admin/users/vendor/activate/index/'.$user->vendor_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/delete/index/'.$user->vendor_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                            }
							else
							{ ?>

							<tr><td colspan="11" align="center">No records found.</td></tr>

								<?php
                            } ?>

                        </tbody>
                    </table>

                    <?php
                    /***********
                     * Bottom Pagination
                     */
                    ?>
                    <?php if ( ! $search) { ?>
                    <div class="row margin-bottom-10">
                        <div class="col-md-12 text-justify pull-right">
                            <span>
                                <?php if ($count_all == 0) { ?>
                                Showing 0 records
                                <?php } else { ?>
                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
                                <?php } ?>
                            </span>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                    <?php } ?>

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
