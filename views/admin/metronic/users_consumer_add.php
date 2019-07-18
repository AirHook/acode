                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open($this->config->slash_item('admin_folder').'users/consumer/add', array('class'=>'form-horizontal', 'id'=>'form-users_consumer_add')); ?>
                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_consumer_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="is_active">
                                        <option value="1" <?php echo set_select('is_active', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('is_active', '0'); ?>>Suspended / Opt Out</option>
                                    </select>
                                    <cite class="help-block small"> By default, new user is always active. </cite>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="reference_designer">
                                        <option value="">Select...</option>
                                        <?php if ($designers) { ?>
                                        <?php foreach ($designers as $designer) { ?>
                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo set_select('reference_designer', $designer->url_structure, ($this->config->item('site_slug') === $designer->url_structure)); ?>><?php echo $designer->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <cite class="help-block small"> By default, current site is reference designer. </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Sales User Association
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="admin_sales_email">
                                        <option value="">Select...</option>
                                        <?php if ($sales) { ?>
                                        <?php foreach ($sales as $sale) { ?>
                                        <option value="<?php echo $sale->admin_sales_email; ?>" <?php echo set_select('admin_sales_email', $sale->admin_sales_email, ($this->webspace_details->info_email === $sale->admin_sales_email)); ?>><?php echo ucwords(strtolower($sale->admin_sales_user.' '.$sale->admin_sales_lname)).'&nbsp; &nbsp;('.$sale->admin_sales_email.')&nbsp; &nbsp;'.$sale->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <cite class="help-block small"> By default, system sales admin is sales user associated. </cite>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email
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
                                <label class="col-md-3 control-label">Company
                                </label>
                                <div class="col-md-4">
                                    <input name="company" type="text" class="form-control" value="<?php echo set_value('company'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Telephone
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input name="telephone" type="text" class="form-control" value="<?php echo set_value('telephone'); ?>" />
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
                                    <select class="form-control select2me" name="state_province">
                                        <option value="">Select...</option>
                                        <?php foreach (list_states() as $state) { ?>
                                        <option value="<?php echo $state->state_name; ?>" <?php echo set_select('state_province', $state->state_name); ?>><?php echo $state->state_name; ?></option>
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
                                    <input name="zip_postcode" type="text" class="form-control" value="<?php echo set_value('zip_postcode'); ?>" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Password
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="password" name="password" class="form-control" />
                                    <span class="help-block">Leave blank to not change</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" name="passconf" class="form-control" />
                                    <cite class="help-block small"> Re-type your password here </cite>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-actions bottom">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/consumer'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_consumer_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
