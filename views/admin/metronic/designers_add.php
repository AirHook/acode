                    <!-- BEGIN FORM-->
                    <!-- FORM =======================================================================-->
                    <?php echo form_open(
                        $this->config->slash_item('admin_folder').'designers/add',
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
                                    <button type="submit" class="btn dark">Submit</button>
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
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Status
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="bs-select form-control" data-show-subtext="true" id="view_status" name="view_status" tabindex="-98">
                                        <option value="Y" >
                                            Active
                                        </option>
                                        <option value="N" <?php echo set_select('view_status', 'N', TRUE); ?>>
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
                                    <input type="text" class="form-control" name="designer" value="<?php echo set_value('designer'); ?>"> </div>
                            </div>
                            <div class="form-group">
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
                                            <option value="-1"> - Override for now - </option>
                                            <?php if ($webspaces) { ?>
                                            <?php foreach ($webspaces as $webspace) { ?>
                                            <option value="<?php echo $webspace->webspace_id; ?>" <?php echo set_select('webspace_id', $webspace->webspace_id); ?>>
                                                <?php echo $webspace->domain_name; ?>
                                            </option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="webspace_domain_name" value="" />
                                    </div>
                                    <cite class="help-block text-danger small select_webpsace_id_notice">
                                        Please select a webspace for the designer
                                    </cite>
                                </div>
                            </div>

                            <hr />
                            <h3 class="form-section">Images</h3>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Logo (Default):
                                </label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new m-grid" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <div id="icon-thumbnail-placeholder" class="m-grid-col m-grid-col-middle m-grid-col-center" style="position:relative;width:300px;height:50px;background-color:#eee;">
                                                <span class="upload_images" style="/*display:none;cursor:pointer;*/opacity:0.4;">Upload image</span>
                                            </div>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 50px;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Select image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="logo">
                                            </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                    <span class="help-block text-danger small">
                                        <em>Recommended logo size is 300 x 50 pixels</em>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Logo (Light - <cite class="small">for dark background</cite>):
                                </label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new m-grid" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <div id="icon-thumbnail-placeholder" class="m-grid-col m-grid-col-middle m-grid-col-center" style="position:relative;width:300px;height:50px;background-color:#eee;">
                                                <span class="upload_images" style="/*display:none;cursor:pointer;*/opacity:0.4;">Upload image</span>
                                            </div>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:300px;max-height:50px;background-color:#eee;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Select image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="logo_light">
                                            </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                    <span class="help-block text-danger small">
                                        <em>Recommended logo size is 300 x 50 pixels</em>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Icon:
                                </label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new m-grid" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <div id="icon-thumbnail-placeholder" class="m-grid-col m-grid-col-middle m-grid-col-center" style="position:relative;width:180px;height:180px;background-color:#eee;">
                                                <span class="upload_images" style="/*display:none;cursor:pointer;*/opacity:0.4;">Upload image</span>
                                            </div>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 180px; max-height: 180px;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Select image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="icon">
                                            </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                    <span class="help-block text-danger small">
                                        <em>Recommended icon size is 300 x 300 pixels</em>
                                    </span>
                                    <div class="clearfix margin-top-10">
                                        <span class="label label-danger">NOTE!</span> Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead. </div>
                                </div>
                            </div>

                            <hr />
                            <h3 class="form-section">Other Info</h3>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address1:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_address1" value="<?php echo set_value('designer_address1'); ?>"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address2:
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_address2" value="<?php echo set_value('designer_address2'); ?>"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_phone" value="<?php echo set_value('designer_phone'); ?>"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Info Email:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="designer_info_email" value="<?php echo set_value('designer_info_email'); ?>"> </div>
                            </div>
                            <hr />
                            <h3 class="form-section">Meta Info</h3>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Title:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="title" value="<?php echo set_value('title'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Description:</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" ><?php echo set_value('description'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Keywords:</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="keyword" rows="6"><?php echo set_value('keyword'); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Alt Tag:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="alttags" value="<?php echo set_value('alttags'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Meta Footer:</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="footer"><?php echo set_value('footer'); ?></textarea>
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
                                    <button type="submit" class="btn dark">Submit</button>
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
