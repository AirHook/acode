                    <div class="table-toolbar <?php echo @$role == 'sales' ? 'hide' : ''; ?>">
                        <div class="row">

                            <div class="col-md-6">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open('admin/users/wholesale/search', array('class'=>'form-horizontal', 'id'=>'form-wholesale_users_search_email')); ?>

                                <div class="input-group">
                                    <input class="form-control" placeholder="Search for Email or Store Name..." name="search_string" type="text">
                                    <span class="input-group-btn">
                                        <button class="btn blue uppercase bold" type="submit">Search</button>
                                    </span>
                                </div>

                                </form>
                                <!-- End FORM =======================================================================-->
                                <!-- END FORM-->

                                <cite class="help-block small">Search entire record</cite>
                            </div>

                        </div>
                    </div>

                    <?php if (
                        $this->webspace_details->options['site_type'] == 'hub_site'
                        && @$role != 'sales'
                    )
                    { ?>

                    <div class="table-toolbar">

                        <div class="row">

                            <div class="col-lg-3 col-md-4">
                                <select class="bs-select form-control" id="filter_by_designer_select" name="des_slug" data-live-search="true" data-size="5" data-show-subtext="true">
                                    <option class="option-placeholder" value="">Select Designer...</option>
                                    <option value="all">All Designers</option>
                                    <?php if ($this->webspace_details->options['site_type'] == 'hub_site') { ?>
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
                        (
                            @$role === 'sales'
                            ? 'my_account/sales/users/wholesale/bulk_actions'
                            : 'admin/users/wholesale/bulk_actions'
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
                            <li class="<?php echo ($this->uri->segment(4) == 'active' OR $this->uri->segment(5) == 'active') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url((@$role == 'sales' ? 'my_account/sales' : 'admin').'/users/wholesale/active'); ?>">
                                    <?php echo $this->uri->segment(4) != 'active' ? 'Show' : ''; ?> Active User List
                                </a>
                            </li>
                            <li class="<?php echo ($this->uri->segment(4) == 'inactive' OR $this->uri->segment(5) == 'inactive') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url((@$role == 'sales' ? 'my_account/sales' : 'admin').'/users/wholesale/inactive'); ?>">
                                    <?php echo $this->uri->segment(4) != 'inactive' ? 'Show' : ''; ?> Inactive User List
                                </a>
                            </li>
                            <li class="<?php echo ($this->uri->segment(4) == 'suspended' OR $this->uri->segment(5) == 'suspended') ? 'active' : ''; ?>">
                                <a href="<?php echo site_url((@$role == 'sales' ? 'my_account/sales' : 'admin').'/users/wholesale/suspended'); ?>">
                                    <?php echo $this->uri->segment(4) != 'suspended' ? 'Show' : ''; ?> Suspended Users
                                </a>
                            </li>
                            <?php
                            // available only on hub sites
                            // as well as when sales user is logged in via my_account
                            if (
                                $this->webspace_details->options['site_type'] == 'hub_site'
                                OR @$role == 'sales'
                            )
                            { ?>
                            <li>
                                <a href="<?php echo site_url((@$role == 'sales' ? 'my_account/sales' : 'admin').'/users/wholesale/add'); ?>">
                                    Add New User <i class="fa fa-plus"></i>
                                </a>
                            </li>
                                <?php
                            } ?>
                        </ul>

                        <br />

                        <?php if ($search) { ?>
                        <h1><small><em>Search results for:</em></small> "<?php echo $search_string; ?>"</h1>
                        <br />
                        <?php } ?>

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
                    <table class="table table-striped table-bordered table-hover order-column dt-responsive" width="100%" id="tbl-users_wholesale_">
                        <thead>
                            <tr>
                                <th class="min-tablet hidden-xs hidden-sm" style="width:40px;"> <!-- counter --> </th>
                                <th class="all text-center hidden-xs hidden-sm" style="width:40px;">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-users_wholesale_ .checkboxes" />
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
                                <th style="width:100px;"> Status </th>
                                <th class="all" style="width:100px;"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($users)
                            {
                                $i = @$page ? ($limit * $page) - ($limit - 1) : 1;
                                foreach ($users as $user)
                                {
                                    $edit_link =
                                        @$role === 'sales'
                                        ? site_url('my_account/sales/users/wholesale/edit/index/'.$user->user_id)
                                        : site_url('admin/users/wholesale/edit/index/'.$user->user_id)
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
                                <?php
                                /***********
                                 * User Name - shown on collapse of row
                                 */
                                ?>
                                <td> <?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)); ?> </td>
                                <?php
                                /***********
                                 * Store Name
                                 */
                                ?>
                                <td> <?php echo $user->store_name; ?> </td>
                                <?php
                                /***********
                                 * Email
                                 */
                                ?>
                                <td>
                                    <a href="<?php echo $edit_link; ?>"><?php echo $user->email; ?></a>
                                </td>
                                <?php
                                /***********
                                 * Reference Designer
                                 */
                                ?>
                                <td> <?php echo $user->designer; ?> </td>
                                <?php
                                /***********
                                 * Sales Rep - shown on collapse of row
                                 */
                                ?>
                                <td> <?php echo ucwords(strtolower($user->admin_sales_user.' '.$user->admin_sales_lname)); ?> </td>
                                <?php
                                /***********
                                 * Create Date - shown on collapse of row
                                 */
                                ?>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->create_date; ?> </td>
                                <?php
                                /***********
                                 * Last Login
                                 */
                                ?>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->xdate; ?> </td>
                                <?php
                                /***********
                                 * # of visits
                                 */
                                ?>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->visits_after_activation; ?> </td>
                                <?php
                                /***********
                                 * Status
                                 */
                                ?>
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
                                <!-- ACTIONS column -->
                                <td class="dropdown-wrap dropdown-fix">

                                    <!-- Edit -->
                                    <a href="<?php echo $edit_link; ?>" class="tooltips" data-original-title="Edit">
                                        <i class="fa fa-pencil font-dark"></i>
                                    </a>
                                    <?php if ($user->is_active == '0' OR $user->is_active == '2') { ?>
                                    <!-- Activate -->
                                    <a data-toggle="modal" href="#activate-<?php echo $user->user_id; ?>" class="tooltips" data-original-title="Activate">
                                        <i class="fa fa-check font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($user->is_active == '1' OR $user->is_active == '2') { ?>
                                    <!-- Set Inactive -->
                                    <a data-toggle="modal" href="#set-inactive-<?php echo $user->user_id; ?>" class="tooltips" data-original-title="Set Inactive">
                                        <i class="fa fa-ban font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($user->is_active == '0' OR $user->is_active == '1') { ?>
                                    <!-- Suspend -->
                                    <a data-toggle="modal" href="#suspend-<?php echo $user->user_id; ?>" class="tooltips" data-original-title="Suspend">
                                        <i class="fa fa-dot-circle-o font-dark"></i>
                                    </a>
                                    <?php } ?>
                                    <!-- Delete -->
                                    <a data-toggle="modal" href="#delete-<?php echo $user->user_id; ?>" class="tooltips" data-original-title="Delete">
                                        <i class="fa fa-trash font-dark"></i>
                                    </a>
                                    <!-- Send Activation Email -->
                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale/send_activation_email/index/'.$user->user_id) : site_url('admin/users/wholesale/send_activation_email/index/'.$user->user_id); ?>" onclick="$('#loading .modal-title').html('Sending activation email...');$('#loading').modal('show');" class="tooltips" data-original-title="Send Activation Email" <?php echo $i < 3 ? 'data-placement="bottom"' : '';?>>
                                        <i class="fa fa-envelope-o font-dark"></i>
                                    </a>
                                    <!-- Send Recent Items Sales Packaget -->
                                    <a data-toggle="modal" href="#send_recent-<?php echo $user->user_id?>" class="tooltips" data-original-title="Send Recent Items Sales Package" <?php echo $i < 3 ? 'data-placement="bottom"' : '';?>>
                                        <i class="fa fa-dropbox font-dark"></i>
                                    </a>

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
                                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale/send_package/index/'.$user->user_id.'/'.$this->uri->segment(5)) : site_url('admin/users/wholesale/send_package/index/'.$user->user_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale/suspend/index/'.$user->user_id.'/'.$this->uri->segment(5)) : site_url('admin/users/wholesale/suspend/index/'.$user->user_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <!-- ITEM DEACTIVATE -->
                                    <div class="modal fade bs-modal-sm" id="set-inactive-<?php echo $user->user_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> Are you sure you want to SET INACTIVE user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale/deactivate/index/'.$user->user_id.'/'.$this->uri->segment(5)) : site_url('admin/users/wholesale/deactivate/index/'.$user->user_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale/activate/index/'.$user->user_id.'/'.$this->uri->segment(5)) : site_url('admin/users/wholesale/activate/index/'.$user->user_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale/delete/index/'.$user->user_id.'/'.$this->uri->segment(5)) : site_url('admin/users/wholesale/delete/index/'.$user->user_id.'/'.$this->uri->segment(4)); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

							<tr><td colspan="12" align="center">No records found.</td></tr>

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

					<!-- NO DEFAULT SALES PACKAGE -->
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
