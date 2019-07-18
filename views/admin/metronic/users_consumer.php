                    <div class="table-toolbar">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="note note-info">
                                    <h4 class="block">NOTES:</h4>
                                    <p> There is a very large quantity of users on record that we are breaking it down to manageable quantities with each record set currently containing 3000 records. Use the pagination on the right side to navigate through each record set. </p>
                                    <p> Use the "<strong>search for email...</strong>" to search for specific users accross entire record. </p>
                                    <p> <strong>Search/Filter box and bottom pagination</strong> are for the current record set in the table. </p>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open($this->config->slash_item('admin_folder').'users/consumer', array('class'=>'form-horizontal', 'id'=>'form-consumer_users_search_email')); ?>

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

                            <div class="col-md-6 text-right">
                                <ul class="pagination" style="margin:0;">
                                    <li>
                                        <a href="<?php echo $this->input->get('set') ? base_url().$this->config->slash_item('admin_folder').'users/consumer.html?set='.($this->input->get('set') - 1) : 'javascript:;'; ?>" <?php echo $this->input->get('set') ? 'onclick="$(\'#loading\').modal(\'show\');"' : 'class="disabled-link disable-target"'; ?>>
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="<?php echo $this->input->get('set') ? '' : ($search ? '' : 'active'); ?>">
                                        <a href="<?php echo ($this->input->get('set') OR $search) ? site_url($this->config->slash_item('admin_folder').'users/consumer') : 'javascript:;'; ?>" <?php echo $this->input->get('set') ? 'onclick="$(\'#loading\').modal(\'show\');"' : ''; ?>> 1 </a>
                                    </li>

                                    <?php for($i = 2; $i <= ceil($record_sets); $i++) { ?>

                                    <li class="<?php echo $this->input->get('set') == $i ? 'active' : ''; ?>">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer'); ?>?set=<?php echo $i; ?>" <?php echo $this->input->get('set') != $i ? 'onclick="$(\'#loading\').modal(\'show\');"' : ''; ?>> <?php echo $i; ?> </a>
                                    </li>

                                    <?php } ?>

                                    <li>
                                        <a href="<?php echo $this->input->get('set') == ceil($record_sets) ? 'javascript:;' : base_url().$this->config->slash_item('admin_folder').'users/consumer.html?set='.($this->input->get('set') ? $this->input->get('set') + 1 : '2'); ?>" <?php echo $this->input->get('set') == ceil($record_sets) ? 'class="disabled-link disable-target"' : 'onclick="$(\'#loading\').modal(\'show\');"'; ?>>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                                <cite class="help-block small">Pagination for record sets</cite>
                            </div>
                        </div>
                    </div>

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
                        <?php if ($search) { ?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button> Search results for: <?php echo $this->input->post('email'); ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/add'); ?>" class="btn sbold blue"> Add a New User
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                        <br />
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
                    <table class="table table-striped table-bordered table-hover order-column dt-responsive" width="100%" id="tbl-users_consumer">
                        <thead>
                            <tr>
                                <th class="min-tablet hidden-xs hidden-sm"> <!-- counter --> </th>
                                <th class="all text-center">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" id="heading_checkbox" class="group-checkable" data-set="#tbl-users_consumer .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th class="all"> Username </th> <!-- fname + lname -->
                                <th class="min-tablet"> Email </th>
                                <th class="min-tablet"> Product Items </th>
                                <th class="min-tablet"> Dress Size </th>
                                <th class="none"> Ref Designer </th> <!-- fname + lname -->
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
                                $i = 1;
                                foreach ($users as $user)
                                {
                                    $options = json_decode($user->options, TRUE);
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
                                    <?php if (@$options['special_sale_invite']) { ?>
                                    <span class="badge badge-success pull-right tooltips" data-original-title="Special sale invite last sent: <?php echo @date('Y-m-d', $options['special_sale_invite']); ?>"><i class="fa fa-envelope-o"></i></span>
                                    <?php } ?>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/edit/index/'.$user->user_id); ?>"><?php echo $user->email; ?></a>
                                    &nbsp;
                                    <a class="hidden_first_edit_link" style="display:none;" href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/edit/index/'.$user->user_id); ?>"><small><cite>edit</cite></small></a>
                                </td>
                                <td>
                                    <?php if (@$options['product_item_invite']) { ?>
                                    <span class="badge badge-success pull-right tooltips" data-original-title="Product item invite last sent: <?php echo @date('Y-m-d', $options['product_item_invite']); ?>"><i class="fa fa-globe"></i></span>
                                    <?php } ?>
                                    <div style="<?php echo @$options['product_item_invite'] ? 'margin-right:30px;': ''; ?>"> <?php echo $user->product_items; ?> </div>
                                </td>
                                <td> <?php echo $user->dresssize ? 'size-'.$user->dresssize : ''; ?> </td>
                                <td> <?php echo ucwords(strtolower($user->designer)); ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->create_date; ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->active_date; ?> </td>
                                <td class="hidden-xs hidden-sm"> <?php echo $user->xdate; ?> </td>
                                <td>
                                    <span class="label label-sm label-<?php echo $user->is_active == '1' ? 'success': 'danger'; ?>"> <?php echo $user->is_active == '1' ? 'Active': 'Opted Out'; ?> </span>
                                </td>
                                <td class="dropdown-wrap dropdown-fix">
                                    <div class="btn-group" >
                                        <button class="btn btn-xs red-flamingo dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" onclick="$('.dropdown-wrap').toggleClass('dropdown-fix');" > Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <!-- DOC: Remove "pull-right" class to default to left alignment -->
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/edit/index/'.$user->user_id); ?>">
                                                    <i class="icon-pencil"></i> Edit </a>
                                            </li>
                                            <li>
                                                <a data-toggle="modal" href="#<?php echo $user->is_active == '1' ? 'suspend': 'activate'; ?>-<?php echo $user->user_id; ?>">
                                                    <i class="icon-<?php echo $user->is_active == '1' ? 'ban': 'check'; ?>"></i> <?php echo $user->is_active == '1' ? 'Move to Opt Out': 'Activate'; ?> </a>
                                            </li>
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
                                            <li>
                                                <a data-toggle="modal" href="#delete-<?php echo $user->user_id; ?>">
                                                    <i class="icon-trash"></i> Delete </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/add'); ?>">
                                                    <i class="fa fa-plus"></i> Add User </a>
                                            </li>
                                        </ul>
                                    </div>

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
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/suspend/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/activate/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
                                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer/delete/index/'.$user->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
