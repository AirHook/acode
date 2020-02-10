                    <div class="table-toolbar">
                        <div class="row">

                            <div class="col-md-6">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open('admin/users/consumer/search', array('class'=>'form-horizontal', 'id'=>'form-consumer_users_search_email')); ?>

                                <div class="input-group">
                                    <input class="form-control" placeholder="Search for email..." name="email" type="text">
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

                    <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                    { ?>

                    <div class="table-toolbar">

                        <div class="row">

                            <div class="col-lg-3 col-md-4">
                                <select class="bs-select form-control" id="filter_by_designer_select" name="des_slug" data-live-search="true" data-size="5" data-show-subtext="true">
                                    <option class="option-placeholder" value="">Select Designer...</option>
                                    <option value="all">All Users</option>
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
                        $this->config->slash_item('admin_folder').'users/consumer/bulk_actions',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-consumer_users_bulk_actions'
                        )
                    ); ?>

                    <?php
                    /***********
                     * Noification area
                     */
                    ?>
                    <div class="notification">
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
                            <button class="close" data-close="alert"></button> An error occurred. Please try again.
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
                        <?php if ($this->session->flashdata('error') == 'error_sending_activation_email') { ?>
                        <div class="alert alert-danger auto-remove">
                            <button class="close" data-close="alert"></button> There was an error sending the activation email.
                        </div>
                        <?php } ?>
                    </div>

                    <?php
                    /***********
                     * Page Toolbar and Tabs and Search Texts
                     */
                    ?>
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
                                <a href="<?php echo site_url('admin/users/consumer/active'); ?>">
                                    <?php echo $this->uri->segment(4) != 'active' ? 'Show' : ''; ?> Active User List
                                </a>
                            </li>
                            <li class="<?php echo $this->uri->segment(4) == 'inactive' ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/users/consumer/inactive'); ?>">
                                    <?php echo $this->uri->segment(4) != 'inactive' ? 'Show' : ''; ?> Inactive User List
                                </a>
                            </li>
                            <li class="<?php echo $this->uri->segment(4) == 'suspended' ? 'active' : ''; ?>">
                                <a href="<?php echo site_url('admin/users/consumer/suspended'); ?>">
                                    <?php echo $this->uri->segment(4) != 'suspended' ? 'Show' : ''; ?> Suspended Users
                                </a>
                            </li>
                            <?php
                            // available only on hub sites for now
                            if ($this->webspace_details->options['site_type'] == 'hub_site')
                            { ?>
                            <li>
                                <a href="<?php echo site_url('admin/users/consumer/add'); ?>">
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
                                    <option value="su">Suspend / Move to Opt Out</option>
                                    <option value="se">Send Special Sale Email Invite</option>
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
                    </style>
                    <table class="table table-striped table-bordered table-hover order-column dt-responsive" width="100%" id="tbl-users_consumer_">
                        <thead>
                            <tr>
                                <th class="min-tablet hidden-xs hidden-sm"> <!-- counter --> </th>
                                <th class="all text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-users_consumer_ .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th class="all"> Username </th> <!-- fname + lname -->
                                <th class="min-tablet"> Email <cite class="small">(click to edit user)</cite> </th>
                                <th class="min-tablet"> Product Items </th>
                                <th class="min-tablet"> Dress Size </th>
                                <th class="none"> Ref Designer </th> <!-- designer name -->
                                <th class="none"> Date Joined </th>
                                <th class="none"> Date Activated </th>
                                <th class="min-tablet hidden-xs hidden-sm"> Last Visit </th>
                                <th class="all"> Status </th>
                                <th class="all"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($users)
                            {
                                $i = @$page ? ($limit * $page) - ($limit - 1) : 1;
                                foreach ($users as $user)
                                {
                                    $options = json_decode($user->options, TRUE);

                                    $edit_link = site_url('admin/users/consumer/edit/index/'.$user->user_id);
                                    ?>

                            <tr class="odd gradeX " onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                <td class="hidden-xs hidden-sm">
                                    <?php echo $i; ?>
                                </td>
                                <td class="text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $user->user_id; ?>" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> <?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)); ?> </td>
                                <td>
                                    <?php
                                    /***********
                                     * Hiding this for now
                                     *
                                    ?>
                                    <?php if (@$options['special_sale_invite']) { ?>
                                    <span class="badge badge-success pull-right tooltips" data-original-title="Special sale invite last sent: <?php echo @date('Y-m-d', $options['special_sale_invite']); ?>"><i class="fa fa-envelope-o"></i></span>
                                    <?php } ?>
                                    <?php // */ ?>
                                    <a href="<?php echo $edit_link; ?>"><?php echo $user->email; ?></a>
                                    &nbsp;
                                    <a class="hidden_first_edit_link display-none hide" href="<?php echo $edit_link; ?>"><small><cite>edit</cite></small></a>
                                </td>
                                <td>
                                    <?php
                                    /***********
                                     * Hiding this for now
                                     *
                                    ?>
                                    <?php if (@$options['product_item_invite']) { ?>
                                    <span class="badge badge-success pull-right tooltips" data-original-title="Product item invite last sent: <?php echo @date('Y-m-d', $options['product_item_invite']); ?>"><i class="fa fa-globe"></i></span>
                                    <?php } ?>
                                    <?php // */ ?>
                                    <div style="<?php echo @$options['product_item_invite'] ? 'margin-right:30px;': ''; ?>"> <?php echo $user->product_items; ?> </div>
                                </td>
                                <td> <?php echo $user->dresssize ? 'size-'.$user->dresssize : ''; ?> </td>
                                <td> <?php echo ucwords(strtolower($user->designer)); ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->create_date; ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->active_date; ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->xdate; ?> </td>
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

                                    <?php
                                    /***********
                                     * Keeping this here for the email invite codes
                                     *
                                    ?>
                                    <div class="btn-group hide" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
                                            <?php if ($user->product_items != '') { ?>
                                            <li style="padding-right:30px;">
                                                <a data-toggle="modal" href="#send_product_item_email_invite-<?php echo $user->user_id; ?>" class="send_product_item_email_invite" data-username="<?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)); ?>" data-user_id="<?php echo $user->user_id; ?>">
                                                    <i class="icon-globe"></i> Send Product Item Email Invite
                                                    <?php if (@$options['product_item_invite']) { ?>
                                                    <span class="badge badge-success tooltips text-block" data-original-title="Product item invite last sent: <?php echo @date('Y-m-d', $options['product_item_invite']); ?>"><i class="fa fa-envelope-o"></i></span>
                                                    <?php } ?>
                                                </a>
                                            </li>
                                            <?php } ?>
                                            <li style="padding-right:30px;">
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/send_special_sale_invite/index/'.$user->user_id); ?>" onclick="$('#loading .modal-title').html('Sending special sale invite...');$('#loading').modal('show');">
                                                    <i class="icon-envelope"></i> Send Special Sale Email Invite
                                                    <?php if (@$options['special_sale_invite']) { ?>
                                                    <span class="badge badge-success tooltips text-block" data-original-title="Special sale invite last sent: <?php echo @date('Y-m-d', $options['special_sale_invite']); ?>"><i class="fa fa-envelope-o"></i></span>
                                                    <?php } ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php // */ ?>

                                    <?php if ($user->product_items != '') { ?>
                                    <!-- PRODUCT ITEM EMAIL INVITE -->
                                    <div class="modal fade bs-modal-lg" id="send_product_item_email_invite-<?php echo $user->user_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- BEGIN FORM-->
                                                <!-- FORM =======================================================================-->
                                                <?php echo form_open($this->config->slash_item('admin_folder').'users/consumer/send_product_item_invite', array('class'=>'form-horizontal', 'id'=>'form-send_product_item_email_invite')); ?>

                                                <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>" />
                                                <input type="hidden" name="style_no" value="<?php echo $user->product_items; ?>" />
                                                <input type="hidden" name="return_uri" value="<?php echo $this->uri->uri_string(); ?>" />

                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Product Item Email Invite</h4>
                                                </div>
                                                <div class="modal-body">
                                                    This will send the user an email with your message below and a link to the product details page of the reference product.
                                                    <hr /> <!--------------------------------->
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Dear:
                                                            </label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="username" id="username" data-required="1" class="form-control" value="<?php echo ucwords(strtolower($user->firstname.' '.$user->lastname)); ?>" />
                                                                <cite class="help-block small">Edit name box where necesssary</cite>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Short message:
                                                            </label>
                                                            <div class="col-md-7">
                                                                <textarea name="message" rows="2" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Product Item:
                                                            </label>
                                                            <div class="col-md-4" data-product_items="<?php echo $user->product_items; ?>">
                                                                <img src="<?php echo src_to_thumbs($user->product_items, '2'); ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
                                                        <span class="ladda-label">Send Email</span>
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
                                    <?php } ?>
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
                                                    <a href="<?php echo site_url('admin/users/consumer/suspend/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                    <div class="modal fade bs-modal-sm" id="set-inactive-<?php echo $user->user_id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Update User Info</h4>
                                                </div>
                                                <div class="modal-body"> Set INACTIVATE user? </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo site_url('admin/users/consumer/deactivate/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo site_url('admin/users/consumer/activate/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo site_url('admin/users/consumer/delete/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

                            <tr class="odd gradeX">
                                <td colspan="12" align="center">No recods found.</td>
                            </tr>

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
									<button onclick="$('#form-consumer_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-consumer_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
									<button onclick="$('#form-consumer_users_bulk_actions').submit();" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
