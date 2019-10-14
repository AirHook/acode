                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

                                        <?php
										/***********
										 *	Notifications
										 */
										?>
										<div class="notifcations">
											<?php if ($this->session->flashdata('success') == 'logout_successful') { ?>
											<div class="alert alert-success">
												Logout successful!!!
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('success') == 'days_lapsed') { ?>
											<div class="alert alert-warning">
												You have been logged out from the system for being idle for some number of days. Please login again.
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('error') == 'invalid_credentials') { ?>
											<div class="alert alert-danger">
												<strong>Error!</strong>&nbsp; Invalid Credentials. Please try again.
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
											<div class="alert alert-danger">
												<strong>Ooops!</strong>&nbsp; Something went wrong. Please try again.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'no_sales_package') { ?>
											<div class="alert alert-danger">
												<strong>Ooops!</strong>&nbsp; Something went wrong. Please try again.
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('error') == 'not_in_the_list') { ?>
											<div class="alert alert-danger">
												<strong>Invalid!</strong>&nbsp; The email address you entered is not in the registered list.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'sales_package_invalid_credentials') { ?>
											<div class="alert alert-danger">
												<strong>Error!</strong>&nbsp; The link is not valid.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'sa_diff_user_loggedin') { ?>
											<div class="alert alert-danger">
												<strong>Ooops!</strong>&nbsp; You are accessing a link as a different user. Please log out and try again.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'tempoparis_must_login') { ?>
											<div class="alert alert-danger">
												You must be logged in to access the page.
											</div>
											<?php } ?>
                                            <?php if ($this->session->flashdata('error') == 'click_one_error') { ?>
											<div class="alert alert-danger">
												The activation email link you are accessing is no longer valid.
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

										<div class="product-details-wrapper" style="margin-bottom:150px;">
											<div class="row">
												<div class="col-sm-6">

													<!-- BOF Form ==============================================================-->
													<?php echo form_open(); ?>

                                                    <div class="form form-body">

														<h3 class="form-section">Sign Into My Account</h3>

														<div class="form-group">
															<input type="text" placeholder="Email" class="form-control input-md" name="email" value="<?php echo set_value('email'); ?>" required="required" />
															<?php echo form_error('email', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<input type="password" placeholder="Password" class="form-control input-md" name="password" value="<?php echo set_value('password'); ?>" required="required" />
															<?php echo form_error('password', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<a href="<?php echo site_url('account/forgot_password'); ?>" style="color:black;text-decoration:underlinel">Forgot Password</a>
														</div>
														<button type="submit" class="btn dark btn-block" style="border:3px solid black;">SIGN IN</button>
                                                    </div>

													</form>
													<!-- End of Form ==============================================================-->

													<br />

                                                    <div class="form form-body">

														<h3 class="form-section">I'm New Here</h3>

                                                        <?php if ($this->webspace_details->slug !== 'tempoparis')
                                                        { ?>

														<a href="<?php echo site_url('account/register/consumer'); ?>" class="btn btn-default btn-block margin-bottom-20" style="border:3px solid black;">CREATE CONSUMER ACCOUNT</a>

                                                            <?php
                                                        } ?>

														<a href="<?php echo site_url('account/register/wholesale'); ?>" class="btn btn-default btn-block" style="border:3px solid black;">CREATE WHOLESALE BUYER ACCOUNT</a>

													</div>

												</div>
												<div class="col-sm-6">

                                                    <?php if ($this->webspace_details->slug !== 'tempoparis')
                                                    { ?>

													<!-- BOF Form ==============================================================-->
													<?php echo form_open(); ?>

                                                    <div class="form form-body">

														<h3 class="form-section">Check Order Status</h3>

														<div class="form-group">
															<input type="text" placeholder="Order Number" class="form-control input-md" name="order_id" value="<?php echo set_value('order_id'); ?>" required="required" />
															<?php echo form_error('order_id', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<input type="text" class="form-control input-md" name="" style="visibility:hidden;" disabled />
														</div>
														<div class="form-group">
															<a href="javascript:;">&nbsp;</a>
														</div>
														<!--<button type="submit" class="btn btn-default btn-block" style="border:3px solid black;">SUBMIT</button>-->
														<a href="#pending-oder-tracking" data-toggle="modal" class="btn btn-default btn-block" style="border:3px solid black;">SUBMIT</a>
                                                    </div>

													</form>
													<!-- End of Form ==============================================================-->

													<!-- PENDING -->
													<div class="modal fade bs-modal-md" id="pending-oder-tracking" tabindex="-1" role="dialog" aria-hidden="true">
														<div class="modal-dialog modal-md">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h3 class="modal-title">Apologies for the inconvenince</h3>
																</div>
																<div class="modal-body">
																		Please bear with us as this section of the website is currently under construction.<br />Please contact us <a href="<?php echo site_url('contact'); ?>">here</a> for further querries
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

                                                        <?php
                                                    } ?>

												</div>
											</div>
										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
