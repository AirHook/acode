                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/sales/edit/index/'.$this->sales_user_details->admin_sales_id,
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_sales_edit'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/add'); ?>" class="btn sbold blue"> Add a New User
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_sales_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-body">

                            <?php
                            /***********
                             * Noification area
                             */
                            ?>
                            <div class="notifications">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                <?php if ($this->session->flashdata('success') == 'add') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> New user added. Continue editing...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> User information updated...
                                </div>
                                <?php } ?>
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <?php if ($this->sales_user_details->admin_sales_id === '1') { ?>
                                    <input type="hidden" name="is_active" value="<?php echo $this->sales_user_details->status; ?>" data-required="1" />
                                    <?php } ?>
                                    <select class="form-control select2me" <?php echo $this->sales_user_details->admin_sales_id === '1' ? 'disabled=""' : 'name="is_active"'; ?>>
                                        <option value="1" <?php echo $this->sales_user_details->status === '1' ? 'selected="selected"' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $this->sales_user_details->status === '0' ? 'selected="selected"' : ''; ?>>Inactive</option>
                                    </select>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('is_active'); ?> </cite>
                                </div>
                            </div>
                            <hr /> <!--------------------------------->
                            <div class="form-group">
                                <label class="control-label col-md-3">User Level
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="access_level">
                                        <option value="">Select...</option>
                                        <option value="1" <?php echo $this->sales_user_details->access_level === '1' ? 'selected="selected"' : ''; ?>>Level 1</option>
                                        <option value="2" <?php echo $this->sales_user_details->access_level === '2' ? 'selected="selected"' : ''; ?>>Level 2</option>
                                    </select>
                                    <cite class="help-block small ">
                                        LEVEL 1: Access to INSTOCK, PREORDER, ONSALE, all sizes<br />
                                        LEVEL 2: Access to INSTOCK and ONSALE, available size only<br />
                                        * Sales users cannot see CS Clearance Items
                                    </cite>
                                </div>
                            </div>
                            <hr /> <!--------------------------------->
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <?php if ($this->sales_user_details->admin_sales_id === '1') { ?>
                                    <input type="hidden" name="admin_sales_designer" value="<?php echo $this->sales_user_details->designer; ?>" />
                                    <?php } ?>
                                    <select class="form-control select2me" <?php echo $this->sales_user_details->admin_sales_id === '1' ? 'disabled=""' : 'name="admin_sales_designer"'; ?> data-required="1" >
                                        <option value="">Select...</option>
                                        <?php if ($designers) { ?>
                                        <?php foreach ($designers as $designer) { ?>
                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo ($this->sales_user_details->designer === $designer->url_structure) ? 'selected="selected"' : ''; ?>><?php echo $designer->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('admin_sales_designer'); ?> </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="admin_sales_email" data-required="1" class="form-control" value="<?php echo $this->sales_user_details->email; ?>">
                                    </div>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('admin_sales_email'); ?> </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Name</label>
                                <div class="col-md-4">
                                    <input name="admin_sales_user" type="text" class="form-control" value="<?php echo $this->sales_user_details->fname; ?>" />
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('admin_sales_user'); ?> </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-4">
                                    <input name="admin_sales_lname" type="text" class="form-control" value="<?php echo $this->sales_user_details->lname; ?>" />
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('admin_sales_lname'); ?> </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Access Level
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="access_level" data-required="1" >
                                        <option value="">Select...</option>
                                        <option value="0" <?php echo $this->sales_user_details->access_level == '0' ? 'selected="selected"' : ''; ?>>0</option>
                                        <option value="1" <?php echo $this->sales_user_details->access_level == '1' ? 'selected="selected"' : ''; ?>>1</option>
                                        <option value="2" <?php echo $this->sales_user_details->access_level == '2' ? 'selected="selected"' : ''; ?>>2</option>
                                    </select>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('access_level'); ?> </cite>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-4">
                                    <input type="checkbox" class="change-password" name="change-password" value="1" tabindex="-1" /> Change password
                                </div>
                            </div>
                            <div class="form-group hide-password display-none">
                                <label class="control-label col-md-3">Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="admin_sales_password" name="admin_sales_password" class="form-control input-password" disabled value="<?php echo $this->sales_user_details->password; ?>" />
                                    <input type="checkbox" class="show-password" tabindex="-1" /> Show password
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('admin_sales_password'); ?> </cite>
                                </div>
                            </div>
                            <div class="form-group hide-password display-none">
                                <label class="control-label col-md-3">Confirm Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" name="passconf" class="form-control input-passconf" disabled />
                                    <cite class="help-block small"> Re-type your password here </cite>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('passconf'); ?> </cite>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-actions bottom">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/add'); ?>" class="btn sbold blue" tabindex="-98"> Add a New User
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_sales_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                                <div class="col-md-offset-3 col-md-9">
                                    <br />
                                    <a data-toggle="modal" href="#delete-<?php echo $this->sales_user_details->admin_sales_id; ?>"><em>Delete Permanently</em></a>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- END FORM-->


                    <!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $this->sales_user_details->admin_sales_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Warning!</h4>
                                </div>
                                <div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales/delete/index/'.$this->sales_user_details->admin_sales_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
