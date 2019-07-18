                    <!-- BEGIN PAGE CONTENT BODY -->

					<div class="row">
						<div class="col-md-12">
						<div class="portlet ">
							<div class="portlet-title">

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div>
									<?php if ($this->session->flashdata('success') == 'sales_package_sent') { ?>
									<div class="alert alert-success">
										<button class="close" data-close="alert"></button> Sales Package sent successfully.
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('error') == 'error_sending_package') { ?>
									<div class="alert alert-danger ">
										<button class="close" data-close="alert"></button> There was an error in sending sales package.
									</div>
									<?php } ?>
								</div>

								<div class="actions btn-set">
									<a class="btn btn-secondary-outline" href="<?php echo site_url('sales/dashboard'); ?>">
										<i class="fa fa-reply"></i> Back to Dashboard</a>
									<a href="#modal_create_sales_package" class="btn sbold blue hide" data-toggle="modal" data-backdrop="static" data-keyboard="false">
										<i class="fa fa-plus"></i> Create Sales Package </a>
								</div>
							</div>
						</div>
					</div>
					</div>

					<?php
					/***********
					 * Sales Package Info
					 */
					?>
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN PORTLET-->
							<div class="portlet box blue-hoki">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-info"></i><?php echo ($this->sales_user_details->access_level == '1' OR @$linesheet_sending_only) ? 'Linesheet': 'Sales Package'; ?> Information </div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Save </a>
									</div>
								</div>
								<div class="portlet-body">

									<div class="row">

										<div class="col-md-4">

											<!-- BEGIN FORM-->
											<!-- FORM =======================================================================-->
											<?php echo form_open(
												'sales/create/send',
												array(
													'id' => 'form-send_sales_package'
												)
											); ?>

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
													<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
												</div>
												<?php } ?>
											</div>

											<?php $this->load->view('metronic/sales/sales_package_view_v1_info'); ?>
											<?php $this->load->view('metronic/sales/sales_package_view_v1_users'); ?>

											<input type="hidden" name="sales_package_id" value="<?php echo $this->session->sa_id ?: 0; ?>" />

											<div class="btn-set">
												<button type="button" class="btn dark btn-lg btn-block <?php echo $this->session->sa_id ? 'mt-bootbox-existing' : 'mt-bootbox-new'; ?>">
													Send <?php echo @$linesheet_sending_only ? 'Linesheet' : 'Package'; ?>
												</button>
											</div>

											<?php echo form_close(); ?>
											<!-- End FORM ===================================================================-->
											<!-- END FORM-->

										</div>
										<div class="col-md-8">
											<?php $this->load->view('metronic/sales/sales_package_view_v1_thumbs'); ?>
										</div>

									</div>

								</div>
							</div>
							<!-- END \PORTLET-->
						</div>
					</div>
