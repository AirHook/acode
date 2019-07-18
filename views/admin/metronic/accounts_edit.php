                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open($this->config->slash_item('admin_folder').'accounts/edit/index/'.$this->account_details->id, array('class'=>'form-horizontal', 'id'=>'form-accounts_edit')); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <label class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts/add'); ?>" class="btn sbold blue"> Add a New Account
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <!-- DOC: Remove "hide" class to enable the reset button -->
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-accounts_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                    <div class="btn-group">
                                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <ul class="dropdown-menu">

                                            <?php if ($accounts) { ?>

                                            <li>
                                                <a href="javascript:;"> Switch accounts...
                                                </a>
                                            </li>
                                            <li class="divider"> </li>

                                                <?php foreach ($accounts as $account) {
                                                    if ($account->account_id !== $this->account_details->id) { ?>

                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts/edit/index/'.$account->account_id); ?>">
                                                <?php echo $account->company_name; ?></a>
                                            </li>

                                                    <?php } } } else { ?>

                                            <li>
                                                <a href="javascript:;"> No other accounts...
                                                </a>
                                            </li>

                                            <?php } ?>

                                        </ul>
                                    </div>
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
                                    <button class="close" data-close="alert"></button> New Account ADDED! Continue edit new account below now...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> Account information updated...
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
                                    <select class="form-control bs-select" name="account_status">
                                        <option value="1" <?php echo $this->account_details->status === '1' ? 'selected="selected"' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $this->account_details->status === '0' ? 'selected="selected"' : ''; ?>>Inactive</option>
                                    </select>
                                    <cite class="help-block small"> By default, new account is always active. </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Indutry
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="industry">
                                        <option value="fashion" <?php echo $this->account_details->industry === 'fashion' ? 'selected="selected"' : ''; ?>>
                                            Fashion</option>
                                        <option value="home" <?php echo $this->account_details->industry === 'home' ? 'selected="selected"' : ''; ?>>
                                            Home</option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Account/Company Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="company_name" data-required="1" class="form-control" value="<?php echo $this->account_details->name; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_name" type="text" data-require="1" class="form-control" value="<?php echo $this->account_details->owner; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Owner Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="owner_email" type="email" data-required="1" class="form-control" value="<?php echo $this->account_details->owner_email; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="address1" type="text" class="form-control" value="<?php echo $this->account_details->address1; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address 2
                                </label>
                                <div class="col-md-4">
                                    <input name="address2" type="text" class="form-control" value="<?php echo $this->account_details->address2; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="city" type="text" class="form-control" value="<?php echo $this->account_details->city; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">State
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control" data-live-search="true" data-size="8" tabindex="-98" name="state">
                                        <option value="">Select...</option>
                                        <?php foreach (list_states() as $state) { ?>
                                        <option value="<?php echo $state->abb; ?>" <?php echo $this->account_details->state === $state->abb ? 'selected="selected"' : ''; ?>><?php echo $state->state_name.' ('.$state->abb.')'; ?></option>
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
                                        <option value="<?php echo $country->countries_name; ?>" <?php echo $this->account_details->country === $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="zip" type="text" class="form-control" value="<?php echo $this->account_details->zip; ?>" /> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="phone" type="text" class="form-control" value="<?php echo $this->account_details->phone; ?>" /> </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="password" name="password" class="form-control" />
                                    <cite class="help-block small"> Leave blank to not change </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" name="passconf" class="form-control" /> </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-actions bottom">
                            <div class="row">
                                <label class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="#modal-add_account" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Add a New Account
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <!-- DOC: Remove "hide" class to enable the reset button -->
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-accounts_edit').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                    <div class="btn-group dropup">
                                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <ul class="dropdown-menu">

                                            <?php if ($accounts) { ?>

                                            <li>
                                                <a href="javascript:;"> Switch accounts...
                                                </a>
                                            </li>
                                            <li class="divider"> </li>

                                                <?php foreach ($accounts as $account) {
                                                    if ($account->account_id !== $this->account_details->id) { ?>

                                            <li>
                                                <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts/edit/index/'.$account->account_id); ?>">
                                                <?php echo $account->company_name; ?></a>
                                            </li>

                                                    <?php } } } else { ?>

                                            <li>
                                                <a href="javascript:;"> No other accounts...
                                                </a>
                                            </li>

                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-offset-3 col-md-9">
                                    <br />
                                    <a data-toggle="modal" href="#delete-<?php echo $this->account_details->id; ?>"><em>Delete Permanently</em></a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->

                    <!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $this->account_details->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Warning!</h4>
                                </div>
                                <div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'accounts/delete/'.$this->account_details->id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
