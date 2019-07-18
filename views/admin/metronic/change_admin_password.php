                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'change_pass',
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-change_pass'
                        )
                    ); ?>

                        <div class="form-actions top hide">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/wholesale') : site_url($this->config->slash_item('admin_folder').'users/wholesale'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-users_wholesale_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                            </div>
                        </div>

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
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> Password successfully changed
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') == 'edit') { ?>
                                <div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button> There was an error. Please try again.
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3"> New Password
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="pword" name="admin_password" class="form-control input-password" />
                                    <input type="checkbox" class="show-password" tabindex="-1" /> Show password
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" name="passconf" class="form-control input-passconf" />
                                    <span class="help-block"> Re-type your password here </span>
                                </div>
                            </div>
                        </div>

                            <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'dashboard'); ?>" type="button" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- END FORM-->
