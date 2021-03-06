													<!-- BEGIN ADDRESS -->
													<h4> Billing Address</h4>
													<div class="form-body">
														<div class="form-group">
															<label class="mt-checkbox mt-checkbox-outline"> Use as my shipping address

																<?php
																// default (general public)
																$same_sh_add_checkbox = $this->session->same_shipping_address === '0' ? '' : 'checked';
																// for wholesale users editing shipping address
																if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
																{
																	$same_sh_add_checkbox = '';
																	$readonly_b_details = 'readonly';
																}
																else $readonly_b_details = '';
																?>

																<input type="checkbox" value="1" name="same_shipping_address" <?php echo $same_sh_add_checkbox; ?> />
																<span></span>
															</label>
														</div>
														<?php if ($this->session->user_loggedin && $this->session->user_role == 'wholesale') { ?>
														<div class="form-group" style="visibility:hidden;">
															<label>Country
																</label>
															<select class="form-control bs-select select-b_address dummy" name="select_b_address" data-size="8" data-live-search="true" data-bsh-type="sh_" disabled>
																<option value="">Select...</option>
															</select>
														</div>
														<?php } ?>
														<div class="form-group">
															<label>Email Address
																<span class="required">*</span></label>
															<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-envelope"></i>
																</span>
																<input type="email" class="form-control" name="b_email" placeholder="Email Address" value="<?php echo $this->session->b_email ?: set_value('b_email'); ?>" <?php echo $readonly_b_details; ?> />
															</div>
															<?php echo form_error('b_email', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>First Name
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_firstname" placeholder="" value="<?php echo $this->session->b_firstname ?: set_value('b_firstname'); ?>" <?php echo $readonly_b_details; ?> />
															<?php echo form_error('b_firstname', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Last Name
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_lastname" placeholder="" value="<?php echo $this->session->b_lastname ?: set_value('b_lastname'); ?>" <?php echo $readonly_b_details; ?> />
															<?php echo form_error('b_lastname', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Telephone
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_phone" placeholder="" value="<?php echo $this->session->b_phone ?: set_value('b_phone'); ?>" <?php echo $readonly_b_details; ?> />
															<?php echo form_error('b_phone', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Country
																<span class="required">*</span></label>

															<?php
															if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
															{ ?>

															<input type="text" class="form-control" name="b_country" placeholder="" value="<?php echo $this->session->b_country ?: set_value('b_country'); ?>" <?php echo $readonly_b_details; ?> />

																<?php
															}
															else
															{ ?>

															<select class="form-control bs-select select-country" name="b_country" data-size="8" data-live-search="true" data-bsh-type="b_">
																<option value="">Select Country</option>
																<?php foreach (list_countries() as $country) { ?>
																<option value="<?php echo $country->countries_name; ?>" <?php echo $this->session->b_country == $country->countries_name ? 'selected="selected"' : set_select('b_country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																<?php } ?>
															</select>
															<?php echo form_error('b_country', '<cite class="help-block text-danger">', '</cite>'); ?>

																<?php
															}
															?>

														</div>
														<div class="form-group">
															<label>Address1
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_address1" placeholder="" value="<?php echo $this->session->b_address1 ?: set_value('b_address1'); ?>" <?php echo $readonly_b_details; ?> />
															<?php echo form_error('b_address1', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>Address2</label>
															<input type="text" class="form-control" name="b_address2" placeholder="" value="<?php echo $this->session->b_address2 ?: set_value('b_address2'); ?>" <?php echo $readonly_b_details; ?> />
															<?php echo form_error('b_address2', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>City
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_city" placeholder="" value="<?php echo $this->session->b_city ?: set_value('b_city'); ?>" <?php echo $readonly_b_details; ?> />
															<?php echo form_error('b_city', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
														<div class="form-group">
															<label>State
																<span class="required">*</span></label>

															<?php
															if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
															{ ?>

															<input type="text" class="form-control" name="b_state" placeholder="" value="<?php echo $this->session->b_state ?: set_value('b_state'); ?>" <?php echo $readonly_b_details; ?> />

																<?php
															}
															else
															{ ?>

															<select class="form-control bs-select select-state" name="b_state" data-size="8" data-live-search="true">
																<option value="">Select State</option>
																<?php foreach (list_states() as $state) { ?>
																<option value="<?php echo $state->state_name; ?>" <?php echo $this->session->b_state == $state->state_name ? 'selected="selected"' : set_select('b_state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
																<?php } ?>
															</select>
															<?php echo form_error('b_state', '<cite class="help-block text-danger">', '</cite>'); ?>

																<?php
															} ?>

														</div>
														<div class="form-group">
															<label>Zipcode
																<span class="required">*</span></label>
															<input type="text" class="form-control" name="b_zip" placeholder="" value="<?php echo $this->session->b_zip ?: set_value('b_zip'); ?>" <?php echo $readonly_b_details; ?> />
															<?php echo form_error('b_zip', '<cite class="help-block text-danger">', '</cite>'); ?>
														</div>
													</div>
													<!-- END ADDRESS -->
