                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="checkout-wrapper">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												'checkout/address',
												array(
													'class' => 'form-vertical',
													'id' => 'form-checkout_address'
												)
											); ?>

											<input type="hidden" name="ny_tax" value="<?php echo ($ny_tax ?: ''); ?>" />

											<div class="row margin-top-10 margin-bottom-30">
												<div class="col-sm-12 clearfix">

													<?php $this->load->view('metronic/checkout_steps'); ?>

												</div>
											</div>
											<div class="row">

												<?php
												/***********
												 * Noification area
												 */
												?>
												<div class="col-sm-12 clearfix">
													<div class="alert alert-danger display-hide">
														<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
													<div class="alert alert-success display-hide">
														<button class="close" data-close="alert"></button> Your form validation is successful! </div>
													<?php if ($this->session->flashdata('error') == 'missing_user_details') { ?>
													<div class="alert alert-danger">
														<button class="close" data-close="alert"></button> An error occured. Please try again.
													</div>
													<?php } ?>
													<?php if (validation_errors()) { ?>
													<div class="alert alert-danger">
														<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
													</div>
													<?php } ?>
												</div>

                                                <?php
                                                // default (general public)
                                                $b_add_col = $this->session->same_shipping_address === '0' ? '4' : '8';
                                                $sh_add_display = $this->session->same_shipping_address === '0' ? '' : 'display-none';

                                                // set to 2 columns for wholesale user editing shipping address
                                                if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
                                                {
                                                    $b_add_col = '4';
                                                    $sh_add_display = '';
                                                }
                                                ?>

												<div class="col-sm-<?php echo $b_add_col; ?> checkout-billing-addres">

													<?php $this->load->view('metronic/checkout_address_billing'); ?>

												</div>
												<div class="col-sm-4 checkout-shipping-address <?php echo $sh_add_display; ?>">

													<?php $this->load->view('metronic/checkout_address_shipping'); ?>

												</div>

                                                <?php
												/***********
												 * Summary Section
												 */
												?>
												<div class="col-sm-4">

													<?php $this->load->view('metronic/checkout_summary_product'); ?>

													<button class="btn dark btn-block">CONTINUE &raquo;</button>

                                                    <?php $this->load->view('metronic/checkout_summary_policy'); ?>

												</div>
											</div>

											</form>
											<!-- END FORM =======================================================-->

										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
