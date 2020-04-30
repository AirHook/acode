                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        (
                            @$role === 'sales'
                            ? 'my_account/sales/users/wholesale/edit/index/'.$this->wholesale_user_details->user_id
                            : $this->config->slash_item('admin_folder').'users/wholesale/edit/index/'.$this->wholesale_user_details->user_id
                        ),
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_wholesale_edit'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo @$role == 'sales' ? site_url('my_account/sales/users/wholesale/add') : site_url('admin/users/wholesale/add'); ?>" class="btn sbold blue"> Add a New User
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale') : site_url('admin/users/wholesale'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                                    <select class="form-control select2me" name="is_active">
                                        <option value="1" <?php echo $this->wholesale_user_details->status === '1' ? 'selected="selected"' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $this->wholesale_user_details->status === '0' ? 'selected="selected"' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="reference_designer" data-reference_designer="<?php echo $this->wholesale_user_details->reference_designer; ?>" <?php echo (@$role == 'sales' OR @$this->sales_user_details->access_level == '2') ? 'disabled' : ''; ?>>
                                        <option value="">Select...</option>
                                        <?php if ($designers) { ?>
                                        <?php foreach ($designers as $designer) { ?>
                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo ($this->wholesale_user_details->reference_designer == $designer->url_structure OR $this->wholesale_user_details->reference_designer == $designer->folder) ? 'selected="selected"' : ''; ?>><?php echo $designer->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if ( ! $this->wholesale_user_details->user_id) { ?>
                                <cite class="help-block small"> By default, current site is reference designer. </cite>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Sales User Association
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="admin_sales_email" <?php echo (@$role == 'sales' OR @$this->sales_user_details->access_level == '2') ? 'disabled' : ''; ?>>
                                        <option value="">Select...</option>
                                        <?php if ($sales) { ?>
                                        <?php foreach ($sales as $sale) { ?>
                                        <option value="<?php echo $sale->admin_sales_email; ?>" <?php echo ($this->wholesale_user_details->admin_sales_email === $sale->admin_sales_email OR ( ! $this->wholesale_user_details->user_id && $sale->admin_sales_id === '1')) ? 'selected="selected"' : ''; ?>><?php echo ucwords(strtolower($sale->admin_sales_user.' '.$sale->admin_sales_lname)).'&nbsp; &nbsp;('.$sale->admin_sales_email.')&nbsp; &nbsp;'.$sale->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if ( ! $this->wholesale_user_details->user_id) { ?>
                                <cite class="help-block small"> By default, system sales admin is sales user associated. </cite>
                                <?php } ?>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Primary Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control" value="<?php echo $this->wholesale_user_details->email; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email 2
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email2" class="form-control" value="<?php echo $this->wholesale_user_details->email2; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="firstname" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->fname; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="lastname" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->lname; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Store Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="store_name" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->store_name; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Website
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            www.
                                        </span>
                                        <input type="text" name="website" class="form-control" value="<?php echo $this->wholesale_user_details->website; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Fed Tax ID
                                </label>
                                <div class="col-md-4">
                                    <input name="fed_tax_id" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->fed_tax_id; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Telephone
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="telephone" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->telephone; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="address1" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->address1; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 2
                                </label>
                                <div class="col-md-4">
                                    <input name="address2" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->address2; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="city" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->city; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">State
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="state">
                                        <option value="">Select...</option>
                                        <?php foreach (list_states() as $state) { ?>
                                        <option value="<?php echo $state->state_name; ?>" <?php echo $this->wholesale_user_details->state === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Country
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="country">
                                        <option value="">Select...</option>
                                        <?php foreach (list_countries() as $country) { ?>
                                        <option value="<?php echo $country->countries_name; ?>" <?php echo $this->wholesale_user_details->country === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="zipcode" type="text" class="form-control" value="<?php echo $this->wholesale_user_details->zipcode; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Comments
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="comments"><?php echo $this->wholesale_user_details->comments; ?></textarea>
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
                                    <input type="password" id="pword" name="pword" class="form-control input-password" disabled value="<?php echo $this->wholesale_user_details->password; ?>" />
                                    <input type="checkbox" class="show-password" tabindex="-1" /> Show password
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('pword'); ?> </cite>
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
                        <div class="form-actions bottom margin-bottom-30">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo @$role == 'sales' ? site_url('my_account/sales/users/wholesale/add') : site_url('admin/users/wholesale/add'); ?>" class="btn sbold blue" tabindex="-98"> Add a New User
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale') : site_url('admin/users/wholesale'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>

                                <?php
                                // do not show to level 2 sales users
                                if (@$role != 'sales' OR @$this->sales_user_details->access_level == '0')
                                { ?>

                                <div class="col-md-offset-3 col-md-9">
                                    <br />
                                    <a data-toggle="modal" href="#delete-<?php echo $this->wholesale_user_details->user_id; ?>"><em>Delete Permanently</em></a>
                                </div>

                                    <?php
                                } ?>

                            </div>
                        </div>

                    </form>
                    <!-- END FORM-->

                    <!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $this->wholesale_user_details->user_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Warning!</h4>
                                </div>
                                <div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <a href="<?php echo @$role == 'sales' ? site_url('my_account/sales/users/wholesale/delete/index/'.$this->wholesale_user_details->user_id) : site_url('admin/users/wholesale/delete/index/'.$this->wholesale_user_details->user_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
