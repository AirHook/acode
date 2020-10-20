													<!-- BEGIN ADDRESS -->
													<h4> Shipping Address</h4>
													<div class="form-body">
														<!-- DOC: this from-group is used here as a spacer only to even out with first column -->
														<div class="form-group">
															<label class="mt-checkbox mt-checkbox-outline" style="visibility:hidden;"> Use as my billing address
																<input type="checkbox" value="1" name="same_billing_address" disabled />
																<span></span>
															</label>
														</div>
														<?php if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
														{
															$alt_address = $this->wholesale_user_details->alt_address;
															?>
														<div class="form-group">
															<label>Select Saved SHIP TO Address
																</label>
															<select class="form-control bs-select select-alt_address" name="alt_address" data-size="8" data-live-search="true" data-show-subtext="true">
																<option value="" data-alt_details='{"email":"","firstname":"","lastname":"","telephone":"","address1":"","address2":"","city":"","state":"","country":"","zipcode":""}'>Select...</option>
																<?php
																foreach ($alt_address as $key => $address)
																{
																	$email_prop = 'email'.$key;
																	$email = $this->wholesale_user_details->$email_prop ?: $this->wholesale_user_details->email;
																	if (
																		! empty($address['firstname'])
																		&& ! empty($address['lastname'])
																		&& ! empty($address['store_name'])
																		&& ! empty($address['address1'])
																		&& ! empty($address['city'])
																		&& ! empty($address['state'])
																		&& ! empty($address['country'])
																		&& ! empty($address['zipcode'])
																	)
																	{ ?>
																<option value="<?php echo $key; ?>" data-subtext="<em><?php echo $address['address1'].' '.$address['country']; ?></em>" data-alt_details='{"email":"<?php echo $email; ?>","firstname":"<?php echo $address['firstname']; ?>","lastname":"<?php echo $address['lastname']; ?>","telephone":"<?php echo $address['telephone']; ?>","address1":"<?php echo $address['address1']; ?>","address2":"<?php echo $address['address2']; ?>","city":"<?php echo $address['city']; ?>","state":"<?php echo $address['state']; ?>","country":"<?php echo $address['country']; ?>","zipcode":"<?php echo $address['zipcode']; ?>"}'>
																	<?php
																	echo $address['store_name'];
																	?>
																</option>
																		<?php
																	}
																}
																?>
															</select>
														</div>
														<?php } ?>
														<div class="form-group">
															<label>Email Address
																</label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-envelope"></i>
																</span>
																<input type="email" class="form-control" name="sh_email" placeholder="Email Address" value="<?php echo $this->session->sh_email ?: set_value('sh_email'); ?>" />
															</div>
															<?php echo form_error('sh_email', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>First Name
																</label>
															<input type="text" class="form-control" name="sh_firstname" placeholder="" value="<?php echo $this->session->sh_firstname ?: set_value('sh_firstname'); ?>" />
															<?php echo form_error('sh_firstname', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Last Name
																</label>
															<input type="text" class="form-control" name="sh_lastname" placeholder="" value="<?php echo $this->session->sh_lastname ?: set_value('sh_lastname'); ?>" />
															<?php echo form_error('sh_lastname', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Telephone
																</label>
															<input type="text" class="form-control" name="sh_phone" placeholder="" value="<?php echo $this->session->sh_phone ?: set_value('sh_phone'); ?>" />
															<?php echo form_error('sh_phone', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Country
																</label>
															<select class="form-control bs-select select-country" name="sh_country" data-size="8" data-live-search="true" data-bsh-type="sh_">
																<option value="">Select Country</option>
																<?php foreach (list_countries() as $country) { ?>
																<option value="<?php echo $country->countries_name; ?>" <?php echo $this->session->sh_country == $country->countries_name ? 'selected="selected"' : set_select('sh_country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																<?php } ?>
															</select>
															<?php echo form_error('sh_country', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Address1
																</label>
															<input type="text" class="form-control" name="sh_address1" placeholder="" value="<?php echo $this->session->sh_address1 ?: set_value('sh_address1'); ?>" />
															<?php echo form_error('sh_address1', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Address2</label>
															<input type="text" class="form-control" name="sh_address2" placeholder="" value="<?php echo $this->session->sh_address2 ?: set_value('sh_address2'); ?>" />
															<?php echo form_error('sh_address2', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>City
																</label>
															<input type="text" class="form-control" name="sh_city" placeholder="" value="<?php echo $this->session->sh_city ?: set_value('sh_city'); ?>" />
															<?php echo form_error('sh_city', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>State
																</label>
															<select class="form-control bs-select select-state" name="sh_state" data-size="8" data-live-search="true">
																<option value="">Select State</option>
																<?php foreach (list_states() as $state) { ?>
																<option value="<?php echo $state->state_name; ?>" <?php echo $this->session->sh_state == $state->state_name ? 'selected="selected"' : set_select('sh_state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
																<?php } ?>
															</select>
															<?php echo form_error('sh_state', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Zipcode
																</label>
															<input type="text" class="form-control" name="sh_zip" placeholder="" value="<?php echo $this->session->sh_zip ?: set_value('sh_zip'); ?>" />
															<?php echo form_error('sh_zip', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
													</div>
													<!-- END ADDRESS -->
