                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/admin/add',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_add'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/admin'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                                    <button class="close" data-close="alert"></button> New User ADDED! Continue edit new user below now...
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
                                    <select class="form-control bs-select" name="is_active">
                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">Suspended</option>
                                    </select>
                                    <cite class="help-block small"> By default, new user is always active. </cite>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control select2me" name="webspace_id">
                                        <option value="" data-account_id="0">Select...</option>

                                        <?php if ($designers)
                                        {
                                            foreach ($designers as $designer)
                                            { ?>

                                        <option value="<?php echo $designer->webspace_id; ?>" <?php echo set_select('webspace_id', $designer->webspace_id); ?> data-account_id="<?php echo $designer->account_id; ?>">
                                            <?php echo $designer->designer; ?>
                                        </option>

                                                <?php
                                            }
                                        } ?>

                                    </select>
                                    <cite class="help-block small"> Only for designer admin users. </cite>
                                    <input type="hidden" name="account_id" value="0" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Username
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" id="admin_name" name="admin_name" class="form-control" value="" />
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
                                        <input type="email" name="admin_email" class="form-control" value=""> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Name</label>
                                <div class="col-md-4">
                                    <input name="fname" type="text" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-4">
                                    <input name="lname" type="text" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Access Level
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="access_level">
                                        <option value="">Select...</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Password
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="admin_password" name="admin_password" class="form-control input-password" />
                                    <input type="checkbox" class="show-password" tabindex="-1" /> Show password
                                </div>
                                <span class="help-block font-red-mint"><cite> <?php echo form_error('admin_password'); ?> </cite></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
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
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/admin/add'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
