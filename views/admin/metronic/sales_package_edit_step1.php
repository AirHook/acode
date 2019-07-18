                        <!-- BEGIN PAGE CONTENT BODY -->

                        <div class="hidden-sm hidden-xs">
                            <?php $this->load->view('admin/metronic/sales_package_steps_wizard'); ?>
                        </div>

                        <div class="row margin-bottom-30">

                            <div class="col-md-12">
    							<div class="portlet ">
    								<div class="portlet-title">
    									<div class="actions btn-set">
    										<a class="btn btn-secondary-outline" href="<?php echo site_url(($this->uri->segment(1) === 'sales' ? 'sales' : 'admin/campaigns').'/sales_package'); ?>">
    											<i class="fa fa-reply"></i> Back to package list</a>
    										<a href="#modal_create_sales_package" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    											<i class="fa fa-plus"></i> Create Another Sales Package </a>
    									</div>
    								</div>
    							</div>
                            </div>

                            <?php
        					/***********
        					 * Left Column Content
        					 */
        					?>
    						<div class="col-xs-12">
                                <!-- BEGIN PORTLET-->
                                <div class="portlet box blue-hoki">
    								<div class="portlet-title">
    									<div class="caption">
    										<i class="fa fa-info"></i>Sales Package Information </div>
    									<!-- DOC: Remove "hide" class to enable -->
    									<div class="actions hide">
    										<a href="javascript:;" class="btn btn-default btn-sm">
    											<i class="fa fa-check"></i> Save </a>
    									</div>
    								</div>
    								<div class="portlet-body">

    									<!-- BEGIN FORM-->
    									<!-- FORM =======================================================================-->
    									<?php echo form_open(
                                            ($this->uri->segment(1) === 'sales' ? 'sales' : 'admin/campaigns').'/sales_package/change_name/index/'.$this->sales_package_details->sales_package_id,
    										array(
    											'class'=>'form-horizontal',
    											'id'=>'form_products_edit'
    										)
    									); ?>

    									<div class="form-body">

    										<?php
    										/***********
    										 * Noification area
    										 */
    										?>
    										<div>
    											<div class="alert alert-danger display-hide">
    												<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
    											<div class="alert alert-success display-hide">
    												<button class="close" data-close="alert"></button> Your form validation is successful! </div>
    											<?php if (validation_errors()) { ?>
    											<div class="alert alert-danger">
    												<button class="close" data-close="alert"></button> There was a problem with the form. Please check and try again. <br />
                                                    <?php echo validation_errors(); ?>
                                                </div>
    											<?php } ?>
    											<?php if ($this->session->userdata('error') === 'recent_items_udpate') { ?>
    											<div class="alert alert-danger ">
    												<button class="close" data-close="alert"></button> There was an error updating the sales package. Please try again.<br />If this problem persists, please contact the administrator. </div>
    											<?php } ?>
    											<?php if ($this->session->userdata('success') === 'create_sales_package') { ?>
    											<div class="alert alert-success auto-remove">
    												<button class="close" data-close="alert"></button> Sales package created and saved. Edit information below and proceed to selecting images for the package. </div>
    											<?php } ?>

                                                <?php if ($this->session->flashdata('success') == 'add') { ?>
        										<div class="alert alert-success auto-remove">
        											<button class="close" data-close="alert"></button> New Product ADDED! Continue edit new product now...
        										</div>
        										<?php } ?>
        										<?php if ($this->session->flashdata('success') == 'recent_items_udpate') { ?>
        										<div class="alert alert-success auto-remove">
        											<button class="close" data-close="alert"></button> Recent Items Sales Package updated...
        										</div>
        										<?php } ?>
        										<?php if ($this->session->flashdata('success') == 'change_sales_package_name') { ?>
        										<div class="alert alert-success auto-remove">
        											<button class="close" data-close="alert"></button> Sales Package information updated
        										</div>
        										<?php } ?>
    										</div>

    										<div class="form-group">
    											<label class="control-label col-md-2">Package Name
    												<span class="required"> * </span>
    											</label>
    											<div class="col-md-9">
    												<input type="text" name="sales_package_name" data-required="1" class="form-control" value="<?php echo $this->sales_package_details->sales_package_name; ?>" <?php echo ($this->sales_package_details->sales_package_id == '1' OR $this->sales_package_details->sales_package_id == '2') ? 'readonly' : ''; ?>/>
                                                    <cite class="help-block small"> A a user friendly name to identify this package as reference. </cite>
    											</div>
    										</div>
    										<?php if (
    											$this->sales_package_details->sales_package_id == '1'
    											OR $this->sales_package_details->sales_package_id == '2'
    											OR $this->sales_package_details->author == 'system'
    										) { ?>
    										<div class="form-group">
    											<div class="col-md-9 col-md-offset-2">
    												<div class="note note-info">
    													<p> <strong>System Generated</strong> - This sales package is system generated. The items are populated based on newly added or popular products. </p>
    												</div>
    											</div>
    										</div>
    										<?php } ?>
    										<hr />
    										<div class="form-group">
    											<label class="control-label col-md-2">Email Subject
    												<span class="required"> * </span>
    											</label>
    											<div class="col-md-9">
    												<input type="text" name="email_subject" data-required="1" class="form-control" value="<?php echo $this->sales_package_details->email_subject; ?> <?php echo @$this->designer_details->name ? ' - '.strtoupper($this->designer_details->name) : ''; ?>" />
                                                    <cite class="help-block small"> Used as the subject for the email. </cite>
    											</div>
    										</div>
    										<div class="form-group">
    											<label class="control-label col-md-2">Message
    												<span class="required"> * </span>
    											</label>
    											<div class="col-md-9">
    												<textarea name="email_message" id="summernote_1"><?php echo $this->sales_package_details->email_message; ?></textarea>
                                                    <cite class="help-block small"> A short message to the users. </cite>
    											</div>
    										</div>

                                            <hr />

    										<div class="form-group">
    											<div class="col-md-9 col-md-offset-2">

    												<button type="submit" class="btn green" name="submit" value="step1" onclick="$('#loading .modal-title').html('Updating...');$('#loading').modal('show');">Update Package Info</button>

                                                    <button type="submit" class="btn default" name="submit" value="step2">Update and Continue to selecting images... <i class="fa fa-share"></i></button>

    												<?php if ($this->sales_package_details->sales_package_name == 'General Recent Items') { ?>
    												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/update_recent_items_sales_package'); ?>" class="btn blue pull-right" onclick="$('#loading .modal-title').html('Re-populating...');$('#loading').modal('show');">
    													Re-populate Recent Items</a>
    												<?php } ?>
    												<?php if ($this->sales_package_details->sales_package_name == 'Designer Recent Items') { ?>
    												<a href="#modal-select_designer_for_designer_recent_sales_package" data-toggle="modal" class="btn blue pull-right">
    													Select Items for another DESIGNER</a>
    												<?php } ?>
    												<?php if ($this->sales_package_details->sales_package_name == 'Popular Items') { ?>
    												<a href="javascript:;" class="btn blue pull-right">Re-populate Popular Items</a>
    												<?php } ?>

    											</div>
    										</div>
    									</div>

    									</form>
    									<!-- End FORM ===================================================================-->
    									<!-- END FORM-->

    								</div>
                                </div>
                                <!-- END \PORTLET-->
    						</div>

                        </div>

                        <!-- END PAGE CONTENT BODY -->
