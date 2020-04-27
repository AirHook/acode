                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        'admin/task_manager/projects_edit/index/'.$project_details->project_id,
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-tm_edit_project'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url('admin/task_manager'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
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
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success auto-remove">
                                    <button class="close" data-close="alert"></button> Information updated...
                                </div>
                                <?php } ?>
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-group form-group-bs-select">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select show-tick" title="Select..." name="status">
                                        <option value="1" <?php echo $project_details->status == '1' ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $project_details->status == '0' ? 'selected' : ''; ?>>Inactive</option>
                                        <option value="2" <?php echo $project_details->status == '2' ? 'selected' : ''; ?>>Urgent</option>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group form-group-bs-select">
                                <label class="control-label col-md-3">Platform
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select show-tick" title="Select..." name="platform">
                                        <option value="rcpixel" <?php echo $project_details->platform == 'rcpixel' ? 'selected' : ''; ?>>RCPixel</option>
                                        <option value="shop7thavenue" <?php echo $project_details->platform == 'shop7thavenue' ? 'selected' : ''; ?>>Shop7</option>
                                        <option value="airhook" <?php echo $project_details->platform == 'airhook' ? 'selected' : ''; ?>>Airhook</option>
                                        <option value="instylenewyork" <?php echo $project_details->platform == 'instylenewyork' ? 'selected' : ''; ?>>Instyle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group-bs-select">
                                <label class="control-label col-md-3">Website
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control bs-select show-tick" title="Select..." name="webspace_id" data-live-search="true" data-size="5">
                                        <option value="0" <?php echo set_select('webspace_id', '0'); ?>>For All Sites</option>

                                        <?php if (@$webspaces)
                                        {
                                            foreach ($webspaces as $webspace)
                                            { ?>

                                        <option value="<?php echo $webspace->webspace_id; ?>"  <?php echo $project_details->webspace_id == $webspace->webspace_id ? 'selected' : ''; ?>>
                                            <?php echo 'www.'.$webspace->domain_name; ?>
                                        </option>

                                                <?php
                                            }
                                        } ?>

                                    </select>
                                </div>
                            </div>
                            <hr/ >
                            <div class="form-group">
								<label class="col-md-3 control-label">Project Name:
									<span class="required"> * </span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="name" placeholder="" value="<?php echo $project_details->name; ?>" />
                                    <span class="help-block">A friendly name for the project...</span>
								</div>
							</div>
                            <div class="form-group">
								<label class="col-md-3 control-label">Short Description:
								</label>
								<div class="col-md-7">
                                    <textarea class="form-control" name="description" rows="7"><?php echo $project_details->description; ?></textarea>
									<span class="help-block">A summary or a short description of the project...</span>
								</div>
							</div>
                        </div>

                        <hr />
                        <div class="form-actions bottom">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn red-flamingo">Submit</button>
                                    <a href="<?php echo site_url('admin/task_manager'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
