                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">

                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> Select a Vendor </span>
                                    </div>
                                </div>

								<div class="portlet-body form">

									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
                                        'sales/purchase_orders/create/step1',
                                        array(
                                            'class'=>'form-horizontal',
                                            'id'=>'form-select_vendor'
                                        )
                                    ); ?>

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
                                                <?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
        										<div class="alert alert-danger ">
        											<button class="close" data-close="alert"></button> There was an error creating PO. Please try again
        										</div>
        										<?php } ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Vendor
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control select2me step1-select-vendor" name="vendor_id">
														<option value="">Select...</option>

														<?php
                                                        if ($vendors)
                                                        {
                                                            foreach ($vendors as $vendor)
                                                            { ?>

														<option value="<?php echo $vendor->vendor_id; ?>" <?php echo set_select('vendor_id', $vendor->vendor_id, ($vendor->vendor_id === $this->session->po_vendor_id)); ?> data-url_structure="<?php echo $vendor->url_structure; ?>">
                                                            <?php echo ucwords(strtolower($vendor->vendor_name)).'&nbsp; &nbsp;('.$vendor->vendor_code.')&nbsp; &nbsp;'.$vendor->designer; ?>
                                                        </option>

                                                                <?php
                                                            }
                                                        } ?>

                                                    </select>
													<span class="help-block">  </span>
                                                    <input type="hidden" name="url_structure" value="<?php echo $this->session->po_des_url_structure ?: ''; ?>" />
                                                </div>
                                            </div>
                                        </div>

 										<div class="form-actions top">
											<div class="row">
												<div class="col-md-offset-3 col-md-4">
                                                    <button type="submit" class="btn dark btn-block"> SELECT VENDOR </button>
												</div>
											</div>
										</div>

									</form>
                                    <!-- END FORM ===================================================================-->
									<!-- END FORM-->

								</div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
