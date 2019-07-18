                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/vendor/add',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_vendor_add'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_vendor_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                                    <select class="form-control select2me" id="is_active" name="is_active" data-base_url="<?php echo base_url(); ?>" data-token="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <option value="1" <?php echo set_select('is_active', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('is_active', '0'); ?>>Suspended</option>
                                    </select>
                                    <p class="help-block small"><em> By default, new vendor is always active. </em></p>
                                    <?php if (form_error('is_active')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('is_active'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" id="reference_designer" name="reference_designer">
                                        <option value="">Select...</option>
                                        <?php if ($designers) { ?>
                                        <?php foreach ($designers as $designer) { ?>
                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo set_select('reference_designer', $designer->url_structure); ?>><?php echo $designer->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <?php if (form_error('reference_designer')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('reference_designer'); ?> </em></span>
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
                                        <option value="<?php echo $vendor_type->id; ?>" <?php echo set_select('vendor_type_id', $vendor_type->id); ?>> <?php echo $vendor_type->type; ?> </option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="type" name="type" value="" />
                                    <?php if (form_error('vendor_type_id')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('vendor_type_id'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Vendor Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input id="vendor_name" name="vendor_name" type="text" class="form-control" value="<?php echo set_value('vendor_name'); ?>" />
                                    <?php if (form_error('vendor_name')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('vendor_name'); ?> </em></span>
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
                                        <input type="email" id="vendor_email" name="vendor_email" class="form-control" value="<?php echo set_value('vendor_email'); ?>" />
                                    </div>
                                    <?php if (form_error('vendor_email')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('vendor_email'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Vendor Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input id="vendor_code" name="vendor_code" type="text" class="form-control" value="<?php echo set_value('vendor_code'); ?>" style="text-transform:uppercase" />
                                    <span class="help-block small"><em> Must be only up to 4 characters max Just letters and numbers and no spaces. </em></span>
                                    <?php if (form_error('vendor_code')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('vendor_code'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input id="contact_1" name="contact_1" type="text" class="form-control" value="<?php echo set_value('contact_1'); ?>" />
                                    <?php if (form_error('contact_1')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('contact_1'); ?> </em></span>
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
                                        <input type="email" id="contact_email_1" name="contact_email_1" class="form-control" value="<?php echo set_value('contact_email_1'); ?>" />
                                    </div>
                                    <?php if (form_error('contact_email_1')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('contact_email_1'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact 2
                                </label>
                                <div class="col-md-4">
                                    <input id="contact_2" name="contact_2" type="text" class="form-control" value="<?php echo set_value('contact_2'); ?>" />
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
                                        <input type="email" id="contact_email_2" name="contact_email_2" class="form-control" value="<?php echo set_value('contact_email_2'); ?>" />
                                    </div>
                                    <?php if (form_error('contact_email_2')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('contact_email_2'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact 3
                                </label>
                                <div class="col-md-4">
                                    <input id="contact_3" name="contact_3" type="text" class="form-control" value="<?php echo set_value('contact_3'); ?>" />
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
                                        <input type="email" id="contact_email_3" name="contact_email_3" class="form-control" value="<?php echo set_value('contact_email_3'); ?>" />
                                    </div>
                                    <?php if (form_error('contact_email_3')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('contact_email_3'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input id="address1" name="address1" type="text" class="form-control" value="<?php echo set_value('address1'); ?>" />
                                    <?php if (form_error('address1')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('address1'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 2
                                </label>
                                <div class="col-md-4">
                                    <input id="address2" name="address2" type="text" class="form-control" value="<?php echo set_value('address2'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input id="city" name="city" type="text" class="form-control" value="<?php echo set_value('city'); ?>" />
                                    <?php if (form_error('city')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('city'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">State
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" id="state" name="state">
                                        <option value="">Select...</option>
                                        <?php foreach (list_states() as $state) { ?>
                                        <option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if (form_error('state')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('state'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Country
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" id="country" name="country">
                                        <option value="">Select...</option>
                                        <?php foreach (list_countries() as $country) { ?>
                                        <option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php if (form_error('country')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('country'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Zip Code
                                </label>
                                <div class="col-md-4">
                                    <input id="zipcode" name="zipcode" type="text" class="form-control" value="<?php echo set_value('zipcode'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Telephone
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input id="telephone" name="telephone" type="text" class="form-control" value="<?php echo set_value('telephone'); ?>" />
                                    <?php if (form_error('telephone')) { ?>
                                    <span class="help-block small" style="color:red;"><em> <?php echo form_error('telephone'); ?> </em></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Fax
                                </label>
                                <div class="col-md-4">
                                    <input id="fax" name="fax" type="text" class="form-control" value="<?php echo set_value('fax'); ?>" />
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/vendor'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_vendor_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
