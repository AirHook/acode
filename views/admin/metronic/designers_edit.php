                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'designers/edit/index/'.$this->designer_details->des_id,
                        array(
                            'class'=>'form-horizontal',
                            'id'=>'form-designer_edit'
                        )
                    ); ?>

                        <div class="form-actions top">
                            <div class="row">
                                <label class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a class="btn sbold blue" href="<?php echo site_url('admin/designers/add'); ?>">
											<i class="fa fa-plus"></i> Add New Designer
                                        </a>
                                    </div>
                                </label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a class="btn default tooltips" href="<?php echo site_url($this->config->slash_item('admin_folder').'designers'); ?>" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
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
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button> New Designer ADDED! Continue editing new designer...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'edit') { ?>
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button> Designer information updated...
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success') == 'image_upload_success') { ?>
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button> Image upload successful
                                </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') == 'image_upload_error') { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> ERROR on image upload: <?php echo $this->session->flashdata('error_message'); ?>
                                </div>
                                <?php } ?>
                                <?php if (validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
                                </div>
                                <?php } ?>

                                <?php if ( ! $this->designer_details->complete_info_status) { ?>
                                <div class="alert alert-danger margin-bottom-10">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <i class="fa fa-warning fa-2x"></i> <br /> Will be UNALBE to publish item in future if information is incomplete. <br /> Please update missing items in the information box.
                                </div>
                                <div class="alert alert-danger margin-bottom-10 hide">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <i class="fa fa-warning fa-2x"></i> Unable to publish item. <br /> Update missing items in the information box to be able to publish item.
                                </div>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control" data-show-subtext="true" id="view_status" name="view_status" tabindex="-98">
                                        <option value="Y" <?php echo ($this->designer_details->view_status == 'Y' OR $this->designer_details->view_status == 'Y1' OR $this->designer_details->view_status == 'Y2') ? 'selected="selected"': ''; ?>>
                                            Active
                                        </option>
                                        <option value="N" <?php echo $this->designer_details->view_status == 'N' ? 'selected="selected"': ''; ?>>
                                            Suspended
                                        </option>
                                    </select>
                                    <cite class="help-block font-red-mint small"> <?php echo form_error('view_status'); ?> </cite>
                                </div>
                            </div>
                            <?php if (@$this->designer_details->webspace_options['site_type'] == 'hub_site') { ?>
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <div id="where_active" class="mt-checkbox-list" <?php echo $this->designer_details->view_status == 'N' ? 'style="display:none;"': ''; ?>>
                                        <?php if (@$this->designer_details->webspace_options['site_type'] == 'hub_site') { ?>
                                        <span class="help-block text-danger">
                                            <em>These options are temporarily disabled.</em>
                                        </span>
                                        <label class="mt-checkbox mt-checkbox-outline disabled-link disable-target">
                                            <input type="checkbox" class="checkboxes where_active" name="publish_at_hub" value="1" <?php echo $this->designer_details->view_status == 'Y1' ? 'checked': 'checked'; ?> disabled> at this hub site
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox mt-checkbox-outline disabled-link disable-target">
                                            <input type="checkbox" class="checkboxes where_active" name="publish_at_satellite" value="2" <?php echo $this->designer_details->view_status == 'Y2' ? 'checked': 'checked'; ?> disabled> at satellite site
                                            <span></span>
                                        </label>
                                    <?php } ?>
                                    </div>
                                    <?php if ($this->designer_details->view_status == 'N') { ?>
                                    <cite class="help-block small">
                                        Suspended means it is inactive and not public on both hub and satellite sites.
                                    </cite>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>

                            <hr />

                            <div class="form-group">
                                <label class="col-md-3 control-label">Desiger Name:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer" value="<?php echo $this->designer_details->name; ?>"> </div>
                            </div>
                            <div class="form-group <?php echo ! $this->designer_details->webspace_id ? 'has-error': ''; ?>">
                                <label class="col-md-3 control-label">Webspace:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon input-left">
                                            www.
                                        </span>
                                        <select class="bs-select form-control" data-show-subtext="true" id="webspace_id" name="webspace_id" tabindex="-98">
                                            <option value=""></option>
                                            <?php if ($webspaces) { ?>
                                            <?php foreach ($webspaces as $webspace) { ?>
                                            <option value="<?php echo $webspace->webspace_id; ?>" <?php echo ($this->designer_details->webspace_id == $webspace->webspace_id) ? 'selected="selected"': ''; ?>>
                                                <?php echo $webspace->domain_name; ?>
                                            </option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="webspace_domain_name" value="" />
                                    </div>
                                    <?php if ( ! $this->designer_details->webspace_id) { ?>
                                    <span class="help-block text-danger">
                                        Please select a webspace for the designer
                                    </span>
                                    <?php } ?>
                                </div>
                            </div>

                            <hr />
                            <h3 class="form-section">Images</h3>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Logo (Default):
                                </label>
                                <div class="col-md-9">
                                    <div class="m-grid m-grid-responsive-md">
                                        <div class="thumbnail m-grid-row" style="display:inline-block;margin-bottom:10px;">
                                            <div id="icon-thumbnail-placeholder" class="m-grid-col m-grid-col-middle m-grid-col-center" style="position:relative;width:300px;height:50px;background-color:#eee;">
                                                <span id="click_to_upload_logo_notice" class="upload_images" href="#modal-upload_images" data-toggle="modal" data-field="logo" style="display:none;cursor:pointer;opacity:0.4;">Click to Upload image</span>
                                                <img src="<?php echo base_url().$this->designer_details->logo; ?>" width="300" height="50" class="upload_images" href="#modal-upload_images" data-toggle="modal" data-field="logo" onerror="this.onerror=null;this.style.display='none';document.getElementById('click_to_upload_logo_notice').style.display='block';" onload="document.getElementById('icon-thumbnail-placeholder').style.background='transparent';" />
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn blue upload_images" id="upload_logo" href="#modal-upload_images" data-toggle="modal" data-field="logo">
                                        <i class="fa fa-upload"></i> Upload Logo </a>
                                    <a class="btn red remove_images" href="#modal-remove_image" data-toggle="modal" data-field="Logo">
                                        <i class="fa fa-remove"></i> Remove </a>
                                    <span class="help-block text-danger small">
                                        <em>Recommended logo size is 300 x 50 pixels</em>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Logo (Light - <cite class="small">for dark background</cite>):
                                </label>
                                <div class="col-md-9">
                                    <div class="m-grid m-grid-responsive-md">
                                        <div class="thumbnail m-grid-row" style="display:inline-block;margin-bottom:10px;">
                                            <div id="logo-light-thumbnail-placeholder" class="m-grid-col m-grid-col-middle m-grid-col-center" style="position:relative;width:300px;height:50px;background-color:#eee;">
                                                <span id="click_to_upload_logo_light_notice" class="upload_images" href="#modal-upload_images" data-toggle="modal" data-field="logo_light" style="display:none;cursor:pointer;opacity:0.4;">Cilck to Upload image</span>
                                                <img src="<?php echo base_url().$this->designer_details->logo_light; ?>" width="300" height="50" class="upload_images" href="#modal-upload_images" data-toggle="modal" data-field="logo_light" onerror="this.onerror=null;this.style.display='none';document.getElementById('click_to_upload_logo_light_notice').style.display='block';" onload="document.getElementById('icon-thumbnail-placeholder').style.background='transparent';" />
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn blue upload_images" id="upload_logo" href="#modal-upload_images" data-toggle="modal" data-field="logo_light">
                                        <i class="fa fa-upload"></i> Upload Logo </a>
                                    <a class="btn red remove_images" href="#modal-remove_image" data-toggle="modal" data-field="Logo">
                                        <i class="fa fa-remove"></i> Remove </a>
                                    <span class="help-block text-danger small">
                                        <em>Recommended logo size is 300 x 50 pixels</em>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Icon:
                                </label>
                                <div class="col-md-9">
                                    <div class="m-grid m-grid-responsive-md">
                                        <div class="thumbnail m-grid-row" style="display:inline-block;margin-bottom:10px;">
                                            <div class="m-grid-col m-grid-col-middle m-grid-col-center" style="position:relative;width:180px;height:180px;background-color:#eee;">
                                                <span id="click_to_upload_icon_notice" class="upload_images" href="#modal-upload_images" data-toggle="modal" data-field="icon" style="display:none;cursor:pointer;opacity:0.4;">Click to Upload image</span>
                                                <img src="<?php echo base_url().$this->designer_details->icon; ?>" width="180" class="upload_images" href="#modal-upload_images" data-toggle="modal" data-field="icon" onerror="this.onerror=null;this.style.display='none';document.getElementById('click_to_upload_icon_notice').style.display='block';" />
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn blue upload_images" id="upload_icon" href="#modal-upload_images" data-toggle="modal" data-field="icon">
                                        <i class="fa fa-upload"></i> Upload Icon </a>
                                    <a class="btn red remove_images" href="#modal-remove_image" data-toggle="modal" data-field="Icon" data-des_id="<?php echo $this->designer_details->des_id; ?>">
                                        <i class="fa fa-remove"></i> Remove </a>
                                    <span class="help-block text-danger small">
                                        <em>Recommended icon size is 300 x 300 pixels</em>
                                    </span>
                                </div>
                            </div>

                            <hr />
                            <h3 class="form-section">Other Info</h3>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address1:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_address1" value="<?php echo $this->designer_details->address1; ?>"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address2:
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_address2" value="<?php echo $this->designer_details->address2; ?>"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_phone" value="<?php echo $this->designer_details->phone; ?>"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Info Email:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_info_email" value="<?php echo $this->designer_details->info_email; ?>"> </div>
                            </div>
                            <hr />
                            <h3 class="form-section">Meta Info</h3>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Title:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" value="<?php echo $this->designer_details->title; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Description:</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" ><?php echo $this->designer_details->description; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Keywords:</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="keyword" rows="6"><?php echo $this->designer_details->keyword; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Alt Tag:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="alttags" value="<?php echo $this->designer_details->alttags; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Footer:</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="footer"><?php echo $this->designer_details->footer; ?></textarea>
                                </div>
                            </div>

                        </div>

                        <hr />
                        <div class="form-actions bottom">
                            <div class="row">
                                <label class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <a class="btn sbold blue" href="<?php echo site_url('admin/designers/add'); ?>">
											<i class="fa fa-plus"></i> Add New Designer
                                        </a>
                                    </div>
                                </label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn red-flamingo">Update</button>
                                    <a class="btn default tooltips" href="<?php echo site_url($this->config->slash_item('admin_folder').'designers'); ?>" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
                                    <button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
                                </div>
                                <div class="col-md-offset-3 col-md-9">
                                    <br />
                                    <a data-toggle="modal" href="#delete-<?php echo $this->designer_details->des_id; ?>"><em>Delete Permanently</em></a>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- END FORM-->

					<!-- DELETE ITEM -->
                    <div class="modal fade bs-modal-sm" id="delete-<?php echo $this->designer_details->des_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Warning!</h4>
								</div>
								<div class="modal-body"> Permanently DELETE item? <br /> This cannot be undone! </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'designers/delete/index/'.$this->designer_details->des_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
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

					<!-- UPLOAD IMAGES -->
					<div class="modal fade bs-modal-sm" id="modal-upload_images" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Upload images</h4>
								</div>
								<div class="modal-body">

									<div class="m-heading-1 border-green m-bordered">
										<p> Files are uploaded automatically after full progress. A CHECK will appear after upload. </p>
									</div>

									<div class="row margin-bottom-10">
										<div class="col col-md-12">

                                            <style>
                                                .dropzone .dz-preview.dz-image-preview { background-color: #efefef; }
                                            </style>

											<!-- BEGIN FORM-->
											<!-- FORM =======================================================================-->
											<?php echo form_open($this->config->slash_item('admin_folder').'designers/upload_images/index/'.$this->designer_details->des_id, array(
												'class'=>'dropzone dropzone-file-area',
												'id'=>'my-dropzone-designers',
												'enctype'=>'multipart/form-data'
											)); ?>
												<input type="hidden" name="des_id" value="<?php echo $this->designer_details->des_id; ?>" />
												<input type="hidden" name="field" id="field" value="" />
												<h4 class="sbold dropzone-form-title"> Image Thumb </h4>

											</form>
											<!-- End FORM =======================================================================-->
											<!-- END FORM-->
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button id="upload_image_cancel" type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
									<a id="upload_image_done" href="<?php echo site_url($this->uri->uri_string()); ?>" class="btn green" style="display:none;">Done</a>
								</div>

							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
