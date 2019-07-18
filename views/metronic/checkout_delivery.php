                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="checkout-wrapper">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												'checkout/delivery',
												array(
													'class' => 'form-vertical',
													'id' => 'form-checkout_delivery'
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
															<h4> Delivery Method</h4>
														</div>

														<?php $this->load->view('metronic/checkout_summary_addresses'); ?>

														<div class="col-sm-12 clearfix">

															<h5> <i class="fa fa-truck"></i> Choose options for delivery method</h5>

															<div class="well well-sm clearfix">
                                                                <?php
                                                                if ($this->session->user_cat == 'wholesale')
                                                                { ?>

                                                                <div class="col-sm-8 clearfix">
																	<p>
																		You will be contacted for shipping details.
																	</p>
                                                                    <input value="0" name="shipmethod" type="hidden" />
																</div>
                                                                    <?php
                                                                }
                                                                else
                                                                { ?>

																<div class="col-sm-6 clearfix">
																	<p>
																		<div class="form-group">
																			<label>USA Only</label>
																			<div class="mt-radio-list" data-error-container="use_shipmethod_error">

																				<?php
																				if ($ship_methods)
																				{
																					foreach ($ship_methods as $shipmethod)
																					{ ?>

																				<label class="mt-radio mt-radio-outline <?php echo $this->session->b_country != 'United States' ? 'tooltips' : ''; ?>" <?php echo $this->session->b_country != 'United States' ? 'data-original-title="USA Shipments Only"' : ''; ?>>
																					<?php echo $shipmethod->ship_id.' - '.$shipmethod->courier.' ('.$shipmethod->fee.')'; ?>
																					<input value="<?php echo $shipmethod->ship_id; ?>" name="shipmethod" type="radio" <?php echo $this->session->shipmethod === $shipmethod->ship_id ? 'checked' : set_select('shipmethod', $shipmethod->ship_id); ?> data-amount="<?php echo $shipmethod->fix_fee; ?>" data-courier="<?php echo $shipmethod->courier; ?>" <?php echo $this->session->b_country == 'United States' ? '' : 'disabled'; ?> />
																					<span></span>
																				</label>
																						<?php
																					}
																				} ?>

																			</div>
																			<div id="use_shipmethod_error"> </div>
																		</div>
																	</p>
																</div>
																<div class="col-sm-6 clearfix">
																	<p>
																		International
																		<br /><br />
																		We only use DHL to ship for countries other than USA. You will be contacted by customer service for respective shipping fees.
																		<div class="form-group">
																			<div class="mt-radio-list" data-error-container="use_shipmethod_error">
																				<label class="mt-radio mt-radio-outline ">
																					DHL - International
																					<input value="0" name="shipmethod" type="radio" <?php echo $this->session->shipmethod === '0' ? 'checked' : set_select('shipmethod', '0'); ?> data-amount="<?php echo '0'; ?>" data-courier="DHL International" />
																					<span></span>
																				</label>
																			</div>
																			<div id="use_shipmethod_error"> </div>
																		</div>
																	</p>
																</div>
                                                                    <?php
                                                                } ?>
                                                                <input type="hidden" name="courier" value="<?php echo $this->session->courier; ?>" />
                                                                <input type="hidden" name="fix_fee" value="<?php echo $this->session->fix_fee; ?>" />
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
