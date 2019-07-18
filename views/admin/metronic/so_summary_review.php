                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="col-sm-12 page-content-inner">

										<div class="checkout-wrapper">

											<div class="row">

												<?php
												/***********
												 * Noification area
												 */
												?>
												<div class="col-sm-12 clearfix">
													<div class="alert alert-danger display-hide" data-test="test">
														<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
													<div class="alert alert-success display-hide">
														<button class="close" data-close="alert"></button> Your form validation is successful! </div>
													<?php if (validation_errors()) { ?>
													<div class="alert alert-danger">
														<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
													</div>
													<?php } ?>
                                                    <?php if ($this->session->flashdata('success') == 'add') { ?>
            										<div class="alert alert-success ">
            											<button class="close" data-close="alert"></button> Purchase Order successfully sent
            										</div>
            										<?php } ?>
												</div>

												<div class="col-sm-8 po-summary-company clearfix">
													<div class="row">
														<div class="col-sm-12">
                                                            <div class="well">

                                                                Review purchase order below and send when ready.

															</div>
														</div>
                                                    </div>
												</div>

											</div>

                                            <?php
                                    		/**
                                    		 * SO Summary Form
                                    		 */
                                    		?>
                                            <?php $this->load->view('admin/metronic/so_details_form'); ?>

                                            <?php
                                    		/**
                                    		 * SALES ORDER Modals
                                    		 */
                                    		?>
                                    		<!-- EDIT SHIP TO -->
                                    		<div class="modal fade" id="modal-edit_ship_to" tabindex="-1" role="basic" aria-hidden="true">
                                    			<div class="modal-dialog">
                                    				<div class="modal-content">
                                    					<div class="modal-header">
                                    						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    						<h4 class="modal-title"> Edit Shipt To Address </h4>
                                    					</div>

                                    					<!-- BEGIN FORM-->
                                    					<!-- FORM =======================================================================-->
                                    					<?php echo form_open(
                                    						'admin/purchase_orders/edit_ship_to',
                                    						array(
                                    							'id'=>'form-seletc_user'
                                    						)
                                    					); ?>

                                    					<div class="modal-body">

                                    						<div class="form margin-bottom-30">

                                    							<div class="form-body">
                                    								<div class="form-group">
                                    									<div class="btn-group btn-group-justified">
                                    										<a href="javascript:;" class="btn dark select-user" data-user="new_user"> NEW STORE USER </a>
                                    										<a href="javascript:;" class="btn dark btn-outline select-user" data-user="current_user"> CURRENT STORE USER </a>
                                    									</div>
                                    								</div>
                                    							</div>

                                    							<?php $this->load->view('metronic/sales/summary_view_send_to_new_user'); ?>

                                    							<?php $this->load->view('metronic/sales/summary_view_send_to_current_user'); ?>
                                    						</div>

                                    					</div>
                                    					<div class="modal-footer">
                                    						<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                    						<button type="submit" class="btn dark confirm-select_user"> Submit </button>
                                    					</div>

                                    					</form>
                                    					<!-- END FORM ===================================================================-->
                                    					<!-- END FORM-->

                                    				</div>
                                    				<!-- /.modal-content -->
                                    			</div>
                                    			<!-- /.modal-dialog -->
                                    		</div>
                                    		<!-- /.modal -->

										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
