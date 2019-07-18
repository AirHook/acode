                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'users/admin/edit/index/'.$this->admin_user_details->admin_id,
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-users_edit'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/admin/add'); ?>" class="btn sbold blue"> Add a New User
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/admin'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
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
                                <?php if ($this->session->flashdata('success') == 'add') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> New user added. Continue editing...
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
                                        <option value="1" <?php echo $this->admin_user_details->status == '1' ? 'selected="selected"' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $this->admin_user_details->status == '0' ? 'selected="selected"' : ''; ?>>Suspended</option>
                                    </select>
                                    <cite class="help-block font-red-mint small"> <?php echo form_error('is_active'); ?> </cite>
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

                                        <option value="<?php echo $designer->webspace_id; ?>" <?php echo $designer->webspace_id == $this->admin_user_details->webspace_id ? 'selected="selected"' : ''; ?> data-account_id="<?php echo $designer->account_id; ?>">
                                            <?php echo $designer->designer; ?>
                                        </option>

                                                <?php
                                            }
                                        } ?>

                                    </select>
                                    <cite class="help-block small"> Only for designer admin users. </cite>
                                    <input type="hidden" name="account_id" value="<?php echo $this->admin_user_details->account_id; ?>" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <label class="control-label col-md-3">Username
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" id="admin_name" name="admin_name" class="form-control" value="<?php echo $this->admin_user_details->username; ?>" />
                                    <span class="help-block font-red-mint"><cite> <?php echo form_error('admin_name'); ?> </cite></span>
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
                                        <input type="email" name="admin_email" class="form-control" value="<?php echo $this->admin_user_details->email; ?>">
                                    </div>
                                    <span class="help-block font-red-mint"><cite> <?php echo form_error('admin_email'); ?> </cite></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Name</label>
                                <div class="col-md-4">
                                    <input name="fname" type="text" class="form-control" value="<?php echo $this->admin_user_details->fname; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Last Name</label>
                                <div class="col-md-4">
                                    <input name="lname" type="text" class="form-control" value="<?php echo $this->admin_user_details->lname; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Access Level
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select" name="access_level">
                                        <option value="">Select...</option>
                                        <option value="0" <?php echo $this->admin_user_details->access_level == '0' ? 'selected="selected"' : ''; ?>>0</option>
                                        <option value="1" <?php echo $this->admin_user_details->access_level == '1' ? 'selected="selected"' : ''; ?>>1</option>
                                        <option value="2" <?php echo $this->admin_user_details->access_level == '2' ? 'selected="selected"' : ''; ?>>2</option>
                                    </select>
                                    <span class="help-block font-red-mint"><cite> <?php echo form_error('access_level'); ?> </cite></span>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-4">
                                    <input type="checkbox" class="change-password" tabindex="-1" /> Change password
                                </div>
                            </div>
                            <div class="form-group hide-password" style="display:none;">
                                <label class="control-label col-md-3">Password
                                </label>
                                <div class="col-md-4">
                                    <input type="password" id="admin_password" name="admin_password" class="form-control input-password" disabled value="<?php echo $this->admin_user_details->password; ?>" />
                                    <input type="checkbox" class="show-password" tabindex="-1" /> Show password
                                    <span class="help-block font-red-mint"><cite> <?php echo form_error('admin_password'); ?> </cite></span>
                                </div>
                            </div>
                            <div class="form-group hide-password" style="display:none;">
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
                                        <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/admin/add'); ?>" class="btn sbold blue" tabindex="-98"> Add a New User
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/admin'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                                <div class="col-md-offset-3 col-md-9">
                                    <br />
                                    <a data-toggle="modal" href="#delete-<?php echo $this->admin_user_details->admin_id; ?>"><em>Delete Permanently</em></a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->

					<!-- DELETE ITEM -->
					<div class="modal fade bs-modal-sm" id="delete-<?php echo $this->admin_user_details->admin_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Warning!</h4>
								</div>
								<div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'users/admin/delete/index/'.$this->admin_user_details->admin_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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
