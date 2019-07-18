                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

                                        <?php
										/***********
										 *	Notifications
										 */
										?>
										<div class="notifcations">
											<?php if ($this->session->flashdata('error') == 'invalid_credentials') { ?>
											<div class="alert alert-danger">
												<strong>Error!</strong>&nbsp; Invalid Credentials. Please try again.
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('error') == 'status_inactive') { ?>
											<div class="alert alert-danger">
												<strong>Ooops!</strong>&nbsp; Your account is existing but has been deemed inactive. You may request to have it activate below.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'click_one_error') { ?>
											<div class="alert alert-danger">
												The sales package you are accessing is no longer valid. You may request for the same sales package again below.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'invalid_link') { ?>
											<div class="alert alert-danger">
												Something went wrong. The sales package you are accessing seems invalid. You may request for the same sales package again below.
											</div>
											<?php } ?>
											<?php
											if (validation_errors())
											{ ?>
											<div class="alert alert-danger">
												<strong>Error!</strong>
												<?php echo validation_errors(); ?>
											</div>
												<?php
											} ?>
										</div>

										<div class="product-details-wrapper margin-top-30" style="margin-bottom:150px;">
											<div class="row">
												<div class="col-sm-6">

													<div class="<?php echo $view == 'form' ?: 'hide'; ?>">

														<!-- BOF Form ==============================================================-->
														<?php echo form_open(); ?>

														<div class="form form-body">

															<div class="form-group">
																<a href="<?php echo site_url('account'); ?>" style="color:black;text-decoration:underline;">Back to Sign in</a>
															</div>

															<h3 class="">Request For Sales Package</h3>

															<p>
																Enter your email address below. Your account will be reviewed and, our customer representative will get in touch with you within 24 hours.
															</p>

															<div class="form-group">
																<input type="text" placeholder="Email" class="form-control input-md" name="email" value="<?php echo set_value('email') ?: $this->wholesale_user_details->email; ?>" required="required" />
																<?php echo form_error('email', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
															<button type="submit" class="btn dark btn-block" style="border:3px solid black;">CONTINUE</button>
														</div>

														</form>
														<!-- End of Form ==============================================================-->

													</div>

													<div class="<?php echo $view == 'success-notice' ?: 'hide'; ?>">

														<div class="form form-body">

															<h3 class="">Request for Sales Package Sent</h3>

															<p>
																You request has been sent. Our customer representative will get back at you as soon as possible.
															</p>

															<a href="<?php echo site_url(); ?>" class="btn dark btn-block" style="border:3px solid black;">CONTINUE SHOPPING</a>
														</div>

													</div>

												</div>
											</div>
										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
