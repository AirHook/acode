                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="notifcations">
											<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>	
											<div class="alert alert-danger">
												<strong>Ooops!</strong>&nbsp; Something went wrong. Please try again.
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('error') == 'user_exists') { ?>	
											<div class="alert alert-danger">
												<strong>Error!</strong>&nbsp; User already exists.
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
											
												<div class="col-md-12 <?php echo $view == 'form' ?: 'hide'; ?>">
												
													<div class="form form-body">
													
														<h3 class="form-section">Create New Account</h3>
														
														<div class="form-register form-consumer">
														
															<!-- BEGIN Form ==============================================================-->
															<?php echo form_open(
																'account/register/consumer',
																array(
																	'class' => 'form-vertical',
																	'id' => 'form-register_consumer'
																)
															); ?>
															
															<input type="hidden" name="user_type" value="" />
															
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
																<?php if ($this->session->flashdata('success') == 'consumer_registration_add') { ?>
																<div class="alert alert-success auto-remove">
																	<button class="close" data-close="alert"></button> New Account ADDED! Continue edit new account below now...
																</div>
																<?php } ?>
															</div>
															
															<h4 class="form-section">Consumer Registration</h4>

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="text" placeholder="First Name *" class="form-control input-md" name="firstname" value="<?php echo set_value('firstname'); ?>" required="required" /> 
																		<?php echo form_error('firstname', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="text" placeholder="Last Name *" class="form-control input-md" name="lastname" value="<?php echo set_value('lastname'); ?>" required="required" /> 
																		<?php echo form_error('lastname', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="email" placeholder="Email *" class="form-control input-md" name="email" value="<?php echo set_value('email'); ?>" required="required" /> 
																		<?php echo form_error('email', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="password" placeholder="Password *" class="form-control input-md" name="password" value="<?php echo set_value('password'); ?>" required="required" id="password" /> 
																		<?php echo form_error('password', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="password" placeholder="Confirm Password *" class="form-control input-md" name="passconf" value="<?php echo set_value('passconf'); ?>" required="required" /> 
																		<?php echo form_error('passconf', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="text" placeholder="Address 1 *" class="form-control input-md" name="address1" value="<?php echo set_value('address1'); ?>" required="required" /> 
																		<?php echo form_error('address1', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="text" placeholder="Address 2" class="form-control input-md" name="address2" value="<?php echo set_value('address2'); ?>" /> 
																		<?php echo form_error('address2', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="text" placeholder="City *" class="form-control input-md" name="city" value="<?php echo set_value('city'); ?>" required="required" /> 
																		<?php echo form_error('city', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="text" placeholder="Zip/Post Code *" class="form-control input-md" name="zip_postcode" value="<?php echo set_value('zip_postcode'); ?>" required="required" /> 
																		<?php echo form_error('zip_postcode', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<select class="form-control select2 select-country" name="country">
																			<option></option>
																			<?php foreach (list_countries() as $country) { ?>
																			<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																			<?php } ?>
																		</select>
																		<?php echo form_error('country', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																		<select class="form-control select2 select-state" name="state_province">
																			<option></option>
																			<?php foreach (list_states() as $state) { ?>
																			<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state_province', $state->state_name); ?>><?php echo $state->state_name; ?></option>
																			<?php } ?>
																		</select>
																		<?php echo form_error('state_province', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<input type="text" placeholder="Telephone" class="form-control input-md" name="telephone" value="<?php echo set_value('telephone'); ?>" required="required" /> 
																		<?php echo form_error('telephone', '<cite class="help-block text-danger">', '</cite>'); ?>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label>I would like to receive email updates from:</label>
																		<div class="mt-checkbox-inline">
																			<label class="mt-checkbox mt-checkbox-outline">
																				<input value="1" name="receive_productupd" type="checkbox" checked> <?php echo $this->webspace_details->name; ?>
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<a href="<?php echo site_url('account'); ?>" class="btn btn-default btn-block" style="border:3px solid black;">CANCEL</a>
																	</div>
																</div>
																<!--/span-->
																<div class="col-md-6">
																	<div class="form-group">
																		<button type="submit" class="btn dark btn-block" style="border:3px solid black;">CREATE ACCOUNT</button>
																	</div>
																</div>
																<!--/span-->
															</div>
															<!--/row-->
															
															</form>
															<!-- END Form ==============================================================-->
															
														</div>
														<!--/form-consumer-->
														
													</div>
												</div>
												
												<div class="col-md-6 <?php echo $view == 'success-notice' ?: 'hide'; ?>">
												
													<div class="form form-body">
														
														<h3 class="">New Account Creation</h3>
														
														<p>
															We have received your application. Our customer representative will get in touch with you within 24 hours.
														</p>
														
														<a href="<?php echo site_url(); ?>" class="btn dark btn-block" style="border:3px solid black;">CONTINUE SHOPPING</a>
													</div>
													
												</div>
												
											</div>
										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->