                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open($this->config->slash_item('admin_folder').'settings/general', array('class'=>'form-horizontal', 'id'=>'form-settings_general')); ?>

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
                                    <button class="close" data-close="alert"></button> New Webspace ADDED! Continue edit new webspace below now...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> Webspace information updated...
                                </div>
                                <?php } ?>
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <h3>General Info</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Webspace Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="webspace_name" data-required="1" class="form-control" value="<?php echo $this->webspace_details->name; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Site Domain
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            www.
                                        </span>
                                        <input type="text" id="domain_name" name="domain_name" data-required="1" class="form-control" value="<?php echo $this->webspace_details->site; ?>" onkeyup="autofillSlug();" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Slug
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" id="webspace_slug" name="webspace_slug" data-required="1" class="form-control" value="<?php echo $this->webspace_details->slug; ?>" readonly tabindex="-1" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Info Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="info_email" data-required="1" class="form-control" value="<?php echo $this->webspace_details->info_email; ?>"> </div>
                                </div>
                            </div>
                            <hr /> <!---------------------------->
                            <h3>Account Details</h3>
                            <?php if ( ! $this->webspace_details->has_account) { ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">Account Information
                                </label>
                                <div class="col-md-9">
                                    <span class="help-block text-danger">This webspace is currently not assign to any account or owner.<br />Either add a new accounn and assign to this webspace, or, select from existing accounts.</span>
                                    <div class="row">
                                    <div class="col-md-3">
                                        <div class="btn-group btn-block">
                                            <a href="#modal-add_account" class="btn sbold blue btn-block" data-toggle="modal"> Add a New Account
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#modal-select_account" class="btn default btn-block" data-toggle="modal"> Select Account
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Name
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_name" type="text" class="form-control" value="<?php echo $this->webspace_details->owner; ?>" disabled /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Email
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_email" type="email" class="form-control" value="<?php echo $this->webspace_details->owner_email; ?>" disabled /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Account/Company Name
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="company_name" data-required="1" class="form-control" value="<?php echo $this->webspace_details->company; ?>" disabled /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="address1" type="text" class="form-control" value="<?php echo $this->webspace_details->address1; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address 2
                                </label>
                                <div class="col-md-4">
                                    <input name="address2" type="text" class="form-control" value="<?php echo $this->webspace_details->address2; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="city" type="text" class="form-control" value="<?php echo $this->webspace_details->city; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">State
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control" data-live-search="true" data-size="8" tabindex="-98" name="state">
                                        <option value="">Select...</option>
                                        <?php foreach (list_states() as $state) { ?>
                                        <option value="<?php echo $state->abb; ?>" <?php echo $this->webspace_details->state === $state->abb ? 'selected="selected"' : ''; ?>><?php echo $state->state_name.' ('.$state->abb.')'; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Country
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="bootstrap-select bs-select form-control" data-live-search="true" data-size="8" tabindex="-98" name="country">
                                        <option value="">Select...</option>
                                        <?php foreach (list_countries() as $country) { ?>
                                        <option value="<?php echo $country->countries_name; ?>" <?php echo $this->webspace_details->country === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="zip" type="text" class="form-control" value="<?php echo $this->webspace_details->zip; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="phone" type="text" class="form-control" value="<?php echo $this->webspace_details->phone; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <div class="note note-info">
                                        <h4 class="block">NOTES:</h4>
                                        <p>
                                            The owner/company's address and phone here is used at front end for contact details purposes. Changing address information here will change the account information as well.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-offset-3 col-md-2">
                                    <button type="submit" class="btn red-flamingo btn-block">Update</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- END FORM ===================================================================-->
                    <!-- END FORM-->

                    <!-- ADD ACCOUNT -->
                    <div class="modal fade bs-modal-lg" id="modal-add_account" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open($this->config->slash_item('admin_folder').'webspaces/account/add/'.$this->webspace_details->id, array('class'=>'form-horizontal', 'id'=>'form-webspace_account_add')); ?>

                                    <input type="hidden" name="account_add_from" value="settings" />

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Add New Account and Assign to <?php echo $this->webspace_details->name; ?>!</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-body">

                                            <?php
                                            /***********
                                             * Noification area
                                             */
                                            ?>
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                            <?php if (validation_errors()) { ?>
                                            <div class="alert alert-danger">
                                                <button class="close" data-close="alert"></button> There were errors in the form. Please try again...
                                            </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Status
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control bs-select" name="account_status">
                                                        <option value="1" <?php echo set_select('account_status', '1', TRUE); ?>>Active</option>
                                                        <option value="0" <?php echo set_select('account_status', '0'); ?>>Inactive</option>
                                                    </select>
                                                    <span class="help-block"> By default, new account is always active. </span>
                                                </div>
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
                                                    <input type="password" name="passconf" class="form-control" /> </div>
                                                    <span class="help-block"> Re-type your password here </span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
                                            <span class="ladda-label">Add and Assign?</span>
                                            <span class="ladda-spinner"></span>
                                        </a>
                                    </div>

                                </form>
                                <!-- END FORM ===================================================================-->
                                <!-- END FORM-->

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-md" id="modal-select_account" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">

                                <!-- BEGIN FORM-->
                                <!-- FORM =======================================================================-->
                                <?php echo form_open($this->config->slash_item('admin_folder').'webspaces/account/linkme/'.$this->webspace_details->id, array('class'=>'form-horizontal', 'id'=>'form-webspace_account_link')); ?>

                                <input type="hidden" name="account_link_from" value="settings" />

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Select an Account and assign to <?php echo $this->webspace_details->name; ?>!</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Select Account
                                                <span class="required"> * </span>
                                            </label>
                                            <div class="col-md-9">
                                                <select class="form-control bs-select" name="account_id" data-live-search="true" data-size="8" tabindex="-98">
                                                    <option value="">Select...</option>
                                                    <?php foreach ($accounts_list as $account) { ?>
                                                    <option value="<?php echo $account->account_id; ?>" <?php echo set_select('account_id', $account->account_id); ?>><?php echo $account->company_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <cite class="help-block small">This Account will server as the owner of the webspace</cite>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
                                        <span class="ladda-label">Link Account?</span>
                                        <span class="ladda-spinner"></span>
                                    </a>
                                </div>

                                </form>
                                <!-- END FORM ===================================================================-->
                                <!-- END FORM-->

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
