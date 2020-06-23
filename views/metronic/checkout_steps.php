													<!-- BEGIN CHECKOUT STEPS -->
													<ul class="cu-multi-steps hidden-sm hidden-xs">
														<li style="width:8.33333%;min-width:75px;">
															<div class="start-bg"></div>
															<div class="end-bg <?php echo $step == 'address' ? 'end' : ''; ?>"></div>
															<a href="<?php echo site_url('cart'); ?>">
																<i class="icon icon-basket-loaded"></i>
																<span class="badge badge-dark">
																	<?php echo $this->cart->total_items() ?: '0'; ?>
																</span>
															</a>
														</li>
														<li class="<?php echo $step == 'address' ? 'current' : ''; ?>" style="width:18.33333%;">
															<div class="end-bg <?php echo $step == 'address' ? 'current' : ''; ?><?php echo $step == 'delivery' ? 'end' : ''; ?>"></div>
															<?php if ($this->session->user_cat == 'wholesale') { ?>
															<a href="#modal-checkout_address_ws_notice" data-toggle="modal">
															<?php } else { ?>
															<a href="<?php echo $stepi <= 1 ? 'javascript:;' : site_url('checkout/address'); ?>">
															<?php } ?>
																<i class="fa fa-<?php echo $stepi > 1 ? 'check' : 'envelope-o'; ?>"></i> Address
															</a>
														</li>
														<li class="<?php echo $step == 'delivery' ? 'current' : ''; ?>" style="width:18.33333%;">
															<div class="end-bg <?php echo $step == 'delivery' ? 'current' : ''; ?><?php echo $step == 'payment' ? 'end' : ''; ?>"></div>
															<a href="<?php echo $stepi <= 2 ? 'javascript:;' : site_url('checkout/delivery'); ?>">
																<i class="fa fa-<?php echo $stepi > 2 ? 'check' : 'truck'; ?>"></i> Delivery
															</a>
														</li>
														<li class="<?php echo $step == 'payment' ? 'current' : ''; ?>" style="width:18.33333%;">
															<div class="end-bg <?php echo $step == 'payment' ? 'current' : ''; ?><?php echo $step == 'review' ? 'end' : ''; ?>"></div>
															<?php if ($this->session->user_cat == 'wholesale') { ?>
															<a href="#modal-checkout_payment_ws_notice" data-toggle="modal">
															<?php } else { ?>
															<a href="<?php echo $stepi <= 3 ? 'javascript:;' : site_url('checkout/payment'); ?>">
															<?php } ?>
																<i class="fa fa-<?php echo $stepi > 3 ? 'check' : 'credit-card'; ?>"></i>
																<?php
																if ($this->session->user_role == 'wholesale')
																{
																	echo 'Payment Options';
																}
																else
																{
																	echo 'Payment';
																}
																?>
															</a>
														</li>
														<li class="<?php echo $step == 'review' ? 'current' : ''; ?>" style="width:18.33333%;">
															<div class="end-bg <?php echo $step == 'review' ? 'current' : ''; ?><?php echo $step == 'receipt' ? 'end' : ''; ?>"></div>
															<a href="<?php echo $stepi <= 4 ? 'javascript:;' : site_url('checkout/review'); ?>">
																<i class="fa fa-<?php echo $stepi > 4 ? 'check' : 'pencil'; ?>"></i>
																<?php
																if ($this->session->user_role == 'wholesale')
																{
																	echo 'Review Your Inquiry';
																}
																else
																{
																	echo 'Review';
																}
																?>
															</a>
														</li>
														<li class="<?php echo $step == 'receipt' ? 'current' : ''; ?>" style="width:18.33333%;">
															<div class="last-bg <?php echo $step == 'receipt' ? 'current' : ''; ?>"></div>
															<a href="<?php echo $stepi <= 5 ? 'javascript:;' : site_url('checkout/receipt'); ?>">
																<i class="fa fa-<?php echo $stepi > 5 ? 'check' : 'file-text-o'; ?>"></i>
																<?php
																if ($this->session->user_role == 'wholesale')
																{
																	echo 'Inquiry Receipt';
																}
																else
																{
																	echo 'Receipt';
																}
																?>
															</a>
														</li>
													</ul>
													<div class="mt-element-step hidden-md hidden-lg">
														<div class="row step-thin">
															<?php if ($this->session->user_cat != 'wholesale') { ?>
                                                            <div class="col-md-4 bg-grey mt-step-col" style="padding-top:5px;padding-bottom:5px;">
                                                                <div class="mt-step-number bg-white font-grey text-center" style="font-size:18px;"><span style="display:inline-block;width:5px;">1</span></div>
                                                                <div class="mt-step-title uppercase font-grey-cascade">Address</div>
                                                            </div>
															<?php } ?>
                                                            <div class="col-md-4 bg-grey mt-step-col" style="padding-top:5px;padding-bottom:5px;">
                                                                <div class="mt-step-number bg-white font-grey" style="font-size:18px;"><span style="display:inline-block;width:5px;">2</span></div>
                                                                <div class="mt-step-title uppercase font-grey-cascade">Delivery</div>
                                                            </div>
															<?php if ($this->session->user_cat != 'wholesale') { ?>
                                                            <div class="col-md-4 bg-grey mt-step-col" style="padding-top:5px;padding-bottom:5px;">
                                                                <div class="mt-step-number bg-white font-grey" style="font-size:18px;"><span style="display:inline-block;width:5px;">3</span></div>
                                                                <div class="mt-step-title uppercase font-grey-cascade">Payment</div>
                                                            </div>
															<?php } ?>
                                                            <div class="col-md-4 bg-grey mt-step-col" style="padding-top:5px;padding-bottom:5px;">
                                                                <div class="mt-step-number bg-white font-grey" style="font-size:18px;"><span style="display:inline-block;width:5px;">4</span></div>
                                                                <div class="mt-step-title uppercase font-grey-cascade">Review</div>
                                                            </div>
                                                            <div class="col-md-4 bg-grey mt-step-col" style="padding-top:5px;padding-bottom:5px;">
                                                                <div class="mt-step-number bg-white font-grey" style="font-size:18px;"><span style="display:inline-block;width:5px;">5</span></div>
                                                                <div class="mt-step-title uppercase font-grey-cascade">Receipt</div>
                                                            </div>
														</div>
													</div>

													<!-- WHOLESALE PAYMENT NOTIFICATION -->
													<div id="modal-checkout_payment_ws_notice" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Notice!</h4>
																</div>
																<div class="modal-body">
																	<p>
																		Accounts payment terms are applicable.
																	</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->

													<!-- WHOLESALE ADDRESS NOTIFICATION -->
													<div id="modal-checkout_address_ws_notice" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-sm">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">Notice!</h4>
																</div>
																<div class="modal-body">
																	<p>
																		Your addresses is already on record.
																	</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
																</div>
															</div>
															<!-- /.modal-content -->
														</div>
														<!-- /.modal-dialog -->
													</div>
													<!-- /.modal -->
													<!-- END CHECKOUT STEPS -->
