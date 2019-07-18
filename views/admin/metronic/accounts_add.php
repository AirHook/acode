                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open($this->config->slash_item('admin_folder').'accounts/add', array('class'=>'form-horizontal', 'id'=>'form-accounts_add')); ?>
                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to lsit</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-accounts_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                            <div class="notification">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                <?php if ($this->session->flashdata('success') == 'add') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> New Account ADDED! Continue edit new account now...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> Account information updated...
                                </div>
                                <?php } ?>
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> There were errors in the form. Please try again...
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="account_status">
                                        <option value="1" <?php echo set_select('account_status', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('account_status', '0'); ?>>Inactive</option>
                                    </select>
                                    <cite class="help-block small hidden-md hidden-lg"> By default, new account is always active. </cite>
                                </div>
                                <cite class="help-block small hidden-xs hidden-sm"> By default, new account is always active. </cite>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Industry
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="industry">
                                        <option value="fashion" <?php echo set_select('industry', 'fashion', TRUE); ?>>Fashion</option>
                                        <option value="home" <?php echo set_select('industry', 'home'); ?>>Home</option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Account/Company Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="company_name" data-required="1" class="form-control" value="<?php echo set_value('company_name'); ?>" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('company_name'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_name" type="text" data-require="1" class="form-control" value="<?php echo set_value('owner_name'); ?>" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('owner_name'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_email" type="email" data-required="1" class="form-control" value="<?php echo set_value('owner_email'); ?>" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('owner_email'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="address1" type="text" class="form-control" value="<?php echo set_value('address1'); ?>" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('address1'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address 2
                                </label>
                                <div class="col-md-4">
                                    <input name="address2" type="text" class="form-control" value="<?php echo set_value('address2'); ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="city" type="text" class="form-control" value="<?php echo set_value('city'); ?>" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('city'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">State
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control" data-live-search="true" data-size="8" tabindex="-98" name="state">
                                        <option value="">Select...</option>
                                        <?php foreach (list_states() as $state) { ?>
                                        <option value="<?php echo $state->abb; ?>" <?php echo set_select('state', $state->abb); ?>><?php echo $state->state_name.' ('.$state->abb.')'; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('state'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Country
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="bootstrap-select bs-select form-control" data-live-search="true" data-size="8" tabindex="-98" name="country">
                                        <option value="">Select...</option>
                                        <?php foreach (list_countries() as $country) { ?>
                                        <option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('country'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="zip" type="text" class="form-control" value="<?php echo set_value('zip'); ?>" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('zip'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="phone" type="text" class="form-control" value="<?php echo set_value('phone'); ?>" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('phone'); ?> </cite></span>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="password" name="password" class="form-control" />
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('password'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" name="passconf" class="form-control" />
                                    <cite class="help-block small hidden-md hidden-lg"> Re-type your password here </cite>
                                </div>
                                <cite class="help-block small hidden-xs hidden-sm"> Re-type your password here </cite>
                            </div>
                        </div>
                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-accounts_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
