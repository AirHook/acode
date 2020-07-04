                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        (
                            @$role === 'sales'
                            ? 'my_account/sales/users/wholesale/add'
                            : 'admin/users/wholesale/add'
                        ),
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_wholesale_add'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale') : site_url($this->config->slash_item('admin_folder').'users/wholesale'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') == 'error_sending_activation_email') { ?>
                                <div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button> There was an error sending the activation email.<br /><?php echo $this->session->flashdata('error_message'); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="is_active">
                                        <option value="1" <?php echo set_select('is_active', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('is_active', '0'); ?>>Inactive</option>
                                    </select>
                                    <cite class="help-block small"> By default, new user is always active. </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-3">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" name="send_activation_email" value="1" checked /> Send user the Activation Email
                                        <span></span>
                                    </label>
                                    <cite class="help-block small"> Checked by default, which this will send activation email to user on submit. </cite>
                                </div>
                            </div>
                            <hr /> <!--------------------------------->

                            <?php if (@$role != 'sales')
                            { ?>

                            <div class="form-group">
                                <label class="control-label col-md-3">User Level
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="access_level">
                                        <option value="">Select...</option>
                                        <option value="1" <?php echo set_select('access_level', '1'); ?>>Level 1</option>
                                        <option value="2" <?php echo set_select('access_level', '2'); ?>>Level 2</option>
                                    </select>
                                    <cite class="help-block small hide">
                                        LEVEL 1: Access to INSTOCK, PREORDER, ONSALE, all sizes<br />
                                        LEVEL 2: Access to INSTOCK and ONSALE, available size only<br />
                                        * Wholesale users cannot see CS Clearance Items
                                    </cite>
                                </div>
                            </div>
                            <hr /> <!--------------------------------->
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="reference_designer">
                                        <?php if ($this->session->admin_sales_loggedin && $this->uri->segment(1) === 'sales') { ?>
                                        <option value="<?php echo $this->sales_user_details->designer; ?>" selected="selected"><?php echo $this->sales_user_details->designer_name; ?></option>
                                        <?php } else { ?>
                                        <option value="">Select...</option>
                                        <?php if ($designers) { ?>
                                        <?php foreach ($designers as $designer) { ?>
                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo set_select('reference_designer', $designer->url_structure, ($this->config->item('site_slug') === $designer->url_structure)); ?>><?php echo $designer->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <cite class="help-block small"> By default, current site is reference designer. </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Sales User Association
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="admin_sales_email">
                                        <?php if ($this->session->admin_sales_loggedin && $this->uri->segment(1) === 'sales') { ?>
                                        <option value="<?php echo $this->sales_user_details->email; ?>" selected="selected"><?php echo ucwords(strtolower($this->sales_user_details->fname.' '.$this->sales_user_details->lname)).'&nbsp; &nbsp;('.$this->sales_user_details->email.')&nbsp; &nbsp;'.$this->sales_user_details->designer_name; ?></option>
                                        <?php } else { ?>
                                        <option value="">Select...</option>
                                        <?php if ($sales) { ?>
                                        <?php foreach ($sales as $sale) { ?>
                                        <option value="<?php echo $sale->admin_sales_email; ?>" <?php echo set_select('admin_sales_email', $sale->admin_sales_email, ($this->config->item('site_slug') === $sale->domain_name)); ?>><?php echo ucwords(strtolower($sale->admin_sales_user.' '.$sale->admin_sales_lname)).'&nbsp; &nbsp;('.$sale->admin_sales_email.')&nbsp; &nbsp;'.$sale->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <cite class="help-block small"> By default, system sales admin is sales user associated. </cite>
                                </div>
                            </div>
                            <hr /> <!--------------------------------->

                                <?php
                            }
                            else
                            { ?>

                            <input type="hidden" name="access_level" value="2" />
                            <input type="hidden" name="reference_designer" value="<?php echo $this->sales_user_details->designer; ?>" />
                            <input type="hidden" name="admin_sales_email" value="<?php echo $this->sales_user_details->email; ?>" />

                                <?php
                            } ?>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Primary Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" />
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
                                        <input type="email" name="email2" class="form-control" value="<?php echo set_value('email2'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email 3
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email3" class="form-control" value="<?php echo set_value('email3'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email 4
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email4" class="form-control" value="<?php echo set_value('email4'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email 5
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email5" class="form-control" value="<?php echo set_value('email5'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email 6
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email6" class="form-control" value="<?php echo set_value('email6'); ?>" />
                                    </div>
                                    <cite class="help-block small"> Any optional emails found invalid will not be saved. </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="firstname" type="text" class="form-control" value="<?php echo set_value('firstname'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="lastname" type="text" class="form-control" value="<?php echo set_value('lastname'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Store Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="store_name" type="text" class="form-control" value="<?php echo set_value('store_name'); ?>" />
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
                                        <input type="text" name="website" class="form-control" value="<?php echo set_value('website'); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Fed Tax ID
                                </label>
                                <div class="col-md-4">
                                    <input name="fed_tax_id" type="text" class="form-control" value="<?php echo set_value('fed_tax_id'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Main Contact Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="telephone" type="text" class="form-control" value="<?php echo set_value('telephone'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact Number 2
                                </label>
                                <div class="col-md-4">
                                    <input name="telephone2" type="text" class="form-control" value="<?php echo set_value('telephone2'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Contact Number 3
                                </label>
                                <div class="col-md-4">
                                    <input name="telephone3" type="text" class="form-control" value="<?php echo set_value('telephone3'); ?>" />
                                    <cite class="help-block small"> Contact numbers can be a landline or mobile number. </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 1
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="address1" type="text" class="form-control" value="<?php echo set_value('address1'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address 2
                                </label>
                                <div class="col-md-4">
                                    <input name="address2" type="text" class="form-control" value="<?php echo set_value('address2'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="city" type="text" class="form-control" value="<?php echo set_value('city'); ?>" />
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
                                        <option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
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
                                        <option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="zipcode" type="text" class="form-control" value="<?php echo set_value('zipcode'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Comments
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="comments"><?php echo set_value('comments'); ?></textarea>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Password
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="pword" name="pword" class="form-control input-password" />
                                    <input type="checkbox" class="show-password" /> Show password
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" name="passconf" class="form-control input-passconf" />
                                    <cite class="help-block small"> Re-type your password here </cite>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-actions bottom">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo @$role === 'sales' ? site_url('my_account/sales/users/wholesale') : site_url($this->config->slash_item('admin_folder').'users/wholesale'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- END FORM-->
