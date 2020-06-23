                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="checkout-wrapper">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												'checkout/payment',
												array(
													'class' => 'form-vertical',
													'id' => 'form-checkout_payment'
												)
											); ?>

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
													<?php if (validation_errors()) { ?>
													<div class="alert alert-danger">
														<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
													</div>
													<?php } ?>
												</div>

												<div class="col-sm-8 checkout-summary-addresses clearfix">

													<div class="row">
														<div class="col-sm-12">
															<h4> Payment Method</h4>
														</div>

														<?php $this->load->view('metronic/checkout_summary_addresses'); ?>

														<div class="form-horizontal col-sm-12 clearfix">

															<h5> <i class="fa fa-truck"></i> Choose options for payment method</h5>

                                                            <?php
            												/***********
            												 * Wholesale User Payment Options
            												 */
                                                            if ($this->session->user_role == 'wholesale')
                                                            { ?>

                                                            <div class="well clearfix">

																<div class="form-group">
																	<div class="col-md-7 col-md-offset-2">
																		<h4> Select Option </h4>
																	</div>
																</div>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label"></label>
                                                                    <div class="col-md-4">
                                                                        <div class="mt-radio-list" data-error-container="use_shipmethod_error">

                                                                            <label class="mt-radio mt-radio-outline">
                                                                                Use my card on file
                                                                                <input value="1" name="ws_payment_options" type="radio" />
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio mt-radio-outline hide">
                                                                                Add a Credit Card
                                                                                <input value="2" name="ws_payment_options" type="radio" />
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio mt-radio-outline">
                                                                                Send me Paypal Invoice
                                                                                <input value="3" name="ws_payment_options" type="radio" />
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio mt-radio-outline">
                                                                                Bill My Account
                                                                                <input value="4" name="ws_payment_options" type="radio" />
                                                                                <span></span>
                                                                            </label>
                                                                            <label class="mt-radio mt-radio-outline">
                                                                                Send me Wire Request
                                                                                <input value="5" name="ws_payment_options" type="radio" />
                                                                                <span></span>
                                                                            </label>

                                                                        </div>
                                                                        <div id="use_shipmethod_error"> </div>
                                                                    </div>
                                                                </div>

															</div>

                                                                <?php
                                                            } ?>

                                                            <?php
            												/***********
            												 * Regular Payment Options
                                                             * (usually for consumers and the general public)
            												 */
            												?>
															<div class="well cc-info clearfix <?php echo $this->session->user_role == 'wholesale' ? 'display-none' : ''; ?>">

																<div class="form-group">
																	<div class="col-md-7 col-md-offset-2">
																		<h4> Credit Card</h4>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-2 control-label">Card Type</label>
																	<div class="col-md-4">
																		<select class="form-control bs-select" name="creditCardType" required="required" data-error-container="#cc_type_error">
																			<option value="">Select</option>
																			<option value="MC">Master Card</option>
																			<option value="VISA">Visa</option>
																			<option value="DISCOVER">Discover</option>
																			<option value="AMEX">American Express</option>
																		</select>
																		<div id="cc_type_error"> </div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-2 control-label">Card Number</label>
																	<div class="col-md-7">
																		<input type="text" class="form-control" name="creditCardNumber" />
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-2 control-label"> </label>
																	<div class="col-md-9">
																		<div style="width:153px;height:24px;overflow:hidden;">
																			<img style="width:216px;height:24px;" src="<?php echo base_url(); ?>images/credit-card-graphic.gif" />
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-2 control-label">Expiration</label>
																	<div class="col-md-7">
																		<div class="row">
																			<div class="col-md-7">
																				<select class="form-control bs-select" name="creditCardExpirationMonth" required="required" data-size="7" data-error-container="#cc_expmo_error">
																					<option value="">Month</option>
																					<option value="01">01 (Jan)</option>
																					<option value="02">02 (Feb)</option>
																					<option value="03">03 (Mar)</option>
																					<option value="04">04 (Apr)</option>
																					<option value="05">05 (May)</option>
																					<option value="06">06 (Jun)</option>
																					<option value="07">07 (Jul)</option>
																					<option value="08">08 (Aug)</option>
																					<option value="09">09 (Sep)</option>
																					<option value="10">10 (Oct)</option>
																					<option value="11">11 (Nov)</option>
																					<option value="12">12 (Dec)</option>
																				</select>
																				<div id="cc_expmo_error"> </div>
																			</div>
																			<div class="col-md-3">
																				<select class="form-control bs-select" name="creditCardExpirationYear" required="required" data-size="7" data-error-container="#cc_expyy_error">
																					<option value="">Year</option>
																					<?php
																					$now = time();
																					for ($i = 0; $i < 10; $i++)
																					{
																						$yyyy = date('Y', strtotime('+'.$i.' year'));
																						$yy = date('y', strtotime('+'.$i.' year'));
																						?>
																					<option value="<?php echo $yy; ?>"><?php echo $yyyy; ?></option>
																						<?php
																					}
																					?>
																				</select>
																				<div id="cc_expyy_error"> </div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-2 control-label">Security Code</label>
																	<div class="col-md-9">
																		<div class="input-group">
																			<input type="text" class="form-control input-small" name="creditCardSecurityCode" style="display:inline;" /> <label class="control-label"><span style="margin:0 10px;">What's this</span> <i class="fa fa-info-circle tooltips" data-original-title="A 3 or 4 digit verification number found at the back of your credit card" style="cursor:pointer;"></i></label>
																		</div>
																	</div>
																</div>

															</div>

														</div>
													</div>

												</div>

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
