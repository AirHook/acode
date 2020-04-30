                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/sales/add',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_sales_add'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_sales_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                                    <select class="form-control bs-select" name="is_active">
                                        <option value="1" <?php echo set_select('is_active', '1', TRUE); ?>>Active</option>
                                        <option value="0" <?php echo set_select('is_active', '0'); ?>>Inactive</option>
                                    </select>
                                    <cite class="help-block small font-red-mint"> <?php echo form_error('is_active'); ?> </cite>
                                    <cite class="help-block small"> By default, new user is always active. </cite>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Reference Designer
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="admin_sales_designer">
                                        <option value="">Select...</option>
                                        <?php if ($designers) { ?>
                                        <?php foreach ($designers as $designer) { ?>
                                        <option value="<?php echo $designer->url_structure; ?>" <?php echo set_select('admin_sales_designer', $designer->url_structure); ?> data-designer="<?php echo $designer->designer; ?>"><?php echo $designer->designer; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
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
                                        <input type="email" name="admin_sales_email" class="form-control" value="<?php echo set_value('admin_sales_email'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Name</label>
                                <div class="col-md-4">
                                    <input name="admin_sales_user" type="text" class="form-control" value="<?php echo set_value('admin_sales_user'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-4">
                                    <input name="admin_sales_lname" type="text" class="form-control" value="<?php echo set_value('admin_sales_lname'); ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Access Level
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="access_level">
                                        <option value="">Select...</option>
                                        <option value="0" <?php echo set_select('access_level', '0'); ?>>0</option>
                                        <option value="1" <?php echo set_select('access_level', '1'); ?>>1</option>
                                        <option value="2" <?php echo set_select('access_level', '2'); ?>>2</option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="admin_sales_password" name="admin_sales_password" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
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
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/sales'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips " onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_sales_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
