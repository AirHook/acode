                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/vendor/edit/index/'.$this->vendor_user_details->vendor_id,
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_vendor_edit'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/add'); ?>" class="btn sbold blue"> Add a New Vendor
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
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
                            <div>
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                <?php if ($this->session->flashdata('success') == 'add') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> New vendor added. Continue editing...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> Vendor information updated...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') == 'post_data_error') { ?>
                                <div class="alert alert-danger ">
                                    <button class="close" data-close="alert"></button> An error occured in posting data. Error - <br />
                                    <?php echo $this->session->flashdata('error_value'); ?>
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
                                        <option value="1" <?php echo $this->vendor_user_details->status === '1' ? 'selected="selected"' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $this->vendor_user_details->status === '0' ? 'selected="selected"' : ''; ?>>Inactive</option>
                                    </select>
                                    <?php if (form_error('is_active')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('is_active'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="reference_designer" data-reference_designer="<?php echo $this->vendor_user_details->reference_designer; ?>">
                                        <option value="">Select...</option>
                                        <?php if ($designers) { ?>
                                        <?php foreach ($designers as $designer) { ?>
                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo ($this->vendor_user_details->reference_designer == $designer->url_structure) ? 'selected="selected"' : ''; ?>><?php echo $designer->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <?php if (form_error('reference_designer')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('reference_designer'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Vendor Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" id="vendor_type_id" name="vendor_type_id">
                                        <option value="">Select...</option>
                                        <?php if ($vendor_types) { ?>
                                        <?php foreach ($vendor_types as $vendor_type) { ?>
                                        <option value="<?php echo $vendor_type->id; ?>" <?php echo $vendor_type->id == $this->vendor_user_details->vendor_type_id ? 'selected="selected"' : ''; ?>> <?php echo $vendor_type->type; ?> </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="type" name="type" value="<?php echo $this->vendor_user_details->vendor_type; ?>" />
                                    <?php if (form_error('vendor_type_id')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('vendor_type_id'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Vendor Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="vendor_name" type="text" class="form-control" value="<?php echo $this->vendor_user_details->vendor_name; ?>" />
                                    <?php if (form_error('vendor_name')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('vendor_name'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Main Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="vendor_email" class="form-control" value="<?php echo $this->vendor_user_details->vendor_email; ?>" />
                                    </div>
                                    <?php if (form_error('vendor_email')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('vendor_email'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Vendor Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="vendor_code" type="text" class="form-control" value="<?php echo $this->vendor_user_details->vendor_code; ?>" style="text-transform:uppercase" readonly />
                                    <span class="help-block small"><em> Must be only up to 4 characters max. Just letters and numbers and no spaces. </em></span>
                                    <?php if (form_error('vendor_code')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('vendor_code'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="contact_1" type="text" class="form-control" value="<?php echo $this->vendor_user_details->contact_1; ?>" />
                                    <?php if (form_error('contact_1')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('contact_1'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact Email 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="contact_email_1" class="form-control" value="<?php echo $this->vendor_user_details->contact_email_1; ?>" />
                                    </div>
                                    <?php if (form_error('contact_email_1')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('contact_email_1'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact 2
                                </label>
                                <div class="col-md-4">
                                    <input name="contact_2" type="text" class="form-control" value="<?php echo $this->vendor_user_details->contact_2; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact Email 2
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="contact_email_2" class="form-control" value="<?php echo $this->vendor_user_details->contact_email_2; ?>" />
                                    </div>
                                    <?php if (form_error('contact_email_2')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('contact_email_2'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact 3
                                </label>
                                <div class="col-md-4">
                                    <input name="contact_3" type="text" class="form-control" value="<?php echo $this->vendor_user_details->contact_3; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact Email 3
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="contact_email_3" class="form-control" value="<?php echo $this->vendor_user_details->contact_email_3; ?>" />
                                    </div>
                                    <?php if (form_error('contact_email_3')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('contact_email_3'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="address1" type="text" class="form-control" value="<?php echo $this->vendor_user_details->address1; ?>" />
                                    <?php if (form_error('address1')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('address1'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 2
                                </label>
                                <div class="col-md-4">
                                    <input name="address2" type="text" class="form-control" value="<?php echo $this->vendor_user_details->address2; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="city" type="text" class="form-control" value="<?php echo $this->vendor_user_details->city; ?>" />
                                    <?php if (form_error('city')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('city'); ?> </cite>
                                    <?php } ?>
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
                                        <option value="<?php echo $state->state_name; ?>" <?php echo $this->vendor_user_details->state === $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if (form_error('state')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('state'); ?> </cite>
                                    <?php } ?>
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
                                        <option value="<?php echo $country->countries_name; ?>" <?php echo $this->vendor_user_details->country === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if (form_error('country')) { ?>
                                    <cite class="help-block small font-red-,mint"> <?php echo form_error('country'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Zip Code
                                </label>
                                <div class="col-md-4">
                                    <input name="zipcode" type="text" class="form-control" value="<?php echo $this->vendor_user_details->zipcode; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Telephone
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="telephone" type="text" class="form-control" value="<?php echo $this->vendor_user_details->telephone; ?>" />
                                    <?php if (form_error('telephone')) { ?>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('telephone'); ?> </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Fax
                                </label>
                                <div class="col-md-4">
                                    <input name="fax" type="text" class="form-control" value="<?php echo $this->vendor_user_details->fax; ?>" />
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
                                    <input type="password" id="password" name="password" class="form-control input-password" disabled value="<?php echo $this->vendor_user_details->password; ?>" />
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
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/add'); ?>" class="btn sbold blue" tabindex="-98"> Add a New Vendor
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                                <div class="col-md-offset-3 col-md-9">
                                    <br />
                                    <a data-toggle="modal" href="#delete-<?php echo $this->vendor_user_details->vendor_id; ?>"><em>Delete Permanently</em></a>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- END FORM-->

                    <!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $this->vendor_user_details->vendor_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Warning!</h4>
                                </div>
                                <div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor/delete/index/'.$this->vendor_user_details->vendor_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
