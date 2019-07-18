													<!-- BEGIN ADDRESS -->
													<h4> Billing Address</h4>
													<div class="form-body">
														<div class="form-group">
															<label class="mt-checkbox mt-checkbox-outline"> Use as my shipping address
																<input type="checkbox" value="1" name="same_shipping_address" <?php echo $this->session->same_shipping_address === '0' ? '' : 'checked'; ?> />
																<span></span>
															</label>
														</div>
														<div class="form-group">
															<label>Email Address
																<span class="required">*</span></label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-envelope"></i>
																</span>
																<input type="email" class="form-control" name="b_email" placeholder="Email Address" value="<?php echo $this->session->b_email ?: set_value('b_email'); ?>" /> 
															</div>
															<?php echo form_error('b_email', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>First Name
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_firstname" placeholder="" value="<?php echo $this->session->b_firstname ?: set_value('b_firstname'); ?>" /> 
															<?php echo form_error('b_firstname', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Last Name
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_lastname" placeholder="" value="<?php echo $this->session->b_lastname ?: set_value('b_lastname'); ?>" /> 
															<?php echo form_error('b_lastname', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Telephone
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_phone" placeholder="" value="<?php echo $this->session->b_phone ?: set_value('b_phone'); ?>" /> 
															<?php echo form_error('b_phone', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Country
																<span class="required">*</span></label>
															<select class="form-control bs-select select-country" name="b_country" data-size="8" data-live-search="true" data-bsh-type="b_">
																<option value="">Select Country</option>
																<?php foreach (list_countries() as $country) { ?>
																<option value="<?php echo $country->countries_name; ?>" <?php echo $this->session->b_country == $country->countries_name ? 'selected="selected"' : set_select('b_country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																<?php } ?>
															</select>
															<?php echo form_error('b_country', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Address1
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_address1" placeholder="" value="<?php echo $this->session->b_address1 ?: set_value('b_address1'); ?>" /> 
															<?php echo form_error('b_address1', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Address2</label>
															<input type="text" class="form-control" name="b_address2" placeholder="" value="<?php echo $this->session->b_address2 ?: set_value('b_address2'); ?>" /> 
															<?php echo form_error('b_address2', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>City
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_city" placeholder="" value="<?php echo $this->session->b_city ?: set_value('b_city'); ?>" /> 
															<?php echo form_error('b_city', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>State
																<span class="required">*</span></label>
															<select class="form-control bs-select select-state" name="b_state" data-size="8" data-live-search="true">
																<option value="">Select State</option>
																<?php foreach (list_states() as $state) { ?>
																<option value="<?php echo $state->state_name; ?>" <?php echo $this->session->b_state == $state->state_name ? 'selected="selected"' : set_select('b_state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
																<?php } ?>
															</select>
															<?php echo form_error('b_state', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Zipcode
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_zip" placeholder="" value="<?php echo $this->session->b_zip ?: set_value('b_zip'); ?>" /> 
															<?php echo form_error('b_zip', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
													</div>
													<!-- END ADDRESS -->