                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="notifcations">
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

										<div class="product-details-wrapper margin-top-30" style="margin-bottom:250px;">
											<div class="row">
												<div class="col-sm-6">
												
													<div class="<?php echo $view == 'form' ?: 'hide'; ?>">

														<!-- BOF Form ==============================================================-->
														<?php echo form_open(); ?>

														<div class="form form-body">
															
															<div class="form-group">
																<a href="<?php echo site_url('account'); ?>" style="color:black;text-decoration:underline;">Back to Sign in</a>
															</div>
															
															<h3 class="">Forgot Password</h3>
															
															<p>
																Please enter your email address to retrieve your forgotten password. If you did not receive your email, please be sure to check your spam or junk folder. For other concerns, you may contact as <a href="<?php echo site_url('contact'); ?>">here</a>.
															</p>
															
															<div class="form-group">
																<input type="text" placeholder="Email" class="form-control input-md" name="email" value="<?php echo set_value('email'); ?>" required="required" /> 
																<?php echo form_error('email', '<cite class="help-block text-danger">', '</cite>'); ?>
															</div>
															<button type="submit" class="btn dark btn-block" style="border:3px solid black;">CONTINUE</button>
														</div>
														
														</form>
														<!-- End of Form ==============================================================-->
													
													</div>
													
													<div class="<?php echo $view == 'success-notice' ?: 'hide'; ?>">
													
														<div class="form form-body">
															
															<h3 class="">Forgot Password</h3>
															
															<p>
																Recover password email sent.
															</p>
															
															<a href="<?php echo site_url(); ?>" class="btn dark btn-block" style="border:3px solid black;">CONTINUE SHOPPING</a>
														</div>
														
													</div>
													
												</div>
											</div>
										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->