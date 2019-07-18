								<?php
								/**********
								 * Right side column
								 * Bottom Service Box
								 * Contact Info and notations to user
								 */
								?>
								<section class="ct ct-cartbody col col-4of12">
								
									<div class="order-summary__header clearfix">
										<h6 class="section-heading">
											Send <?php echo $file === 'linesheet' ? 'Linesheet' : 'Sales Package'; ?>
										</h6>
									</div>
									
									<?php
									/**********
									 * Notification Area
									 */
									?>
									<?php if ($this->session->flashdata('error') == 'add_new_user_error') { ?>
									<div style="padding:10px 20px;background:pink;margin:0 10px 20px;color:red;">
										There was an error in the New User form sent. Please try again.<br />
										Fields with (*) are required fields.
									</div>
									<?php } ?>
										
									<div class="choose-user-type-to-send" style="padding:0px 10px;">
										<h3> Send to: </h3>
										<div style="text-align:center;">
											<button type="button" name="new_user" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" value="new" style="width:155px;" onclick="if ($('#items_count').val() == 0) { alert('Please select an item first.'); } else { $('#ws-user-list').hide();$('#ws-user-registration').show(); };">
												New User
											</button>
											<button type="button" name="current_user" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" value="current" style="width:155px;" onclick="if ($('#items_count').val() == 0) { alert('Please select an item first.'); } else { $('#ws-user-registration').hide();$('#ws-user-list').show(); };">
												Current User
											</button>
										</div>
									</div>
									
									<br />
									
									<div id="ws-user-list" class="cart-information" style="display:none;">
									
										<h3> Current Users: </h3>
										<br />
										<div class="return-policy-block">
											
											<?php
											/**********
											 * CURRENT USER
											 */
											?>
											<!-- BEGIN FORM-->
											<!-- FORM =======================================================================-->
											<?php echo form_open('sales/send_package/current_user'); ?>
											
											<input type="hidden" name="sales_package_id" value="<?php echo @$this->sales_package_details->sales_package_id ?: '0'; ?>" />
											
											<input type="hidden" name="type_of_sending" value="<?php echo @$file; ?>" />
											<input type="hidden" name="w_prices" value="Y" />
											<input type="hidden" name="w_images" value="N" />
											<input type="hidden" name="linesheets_only" value="N" />
											
											<?php if ($wholesale_users) { ?>
											
											<div class="pairinglist clearfix" >
												<ul class="pairings clearfix">

													<li class="pairing-country pairinglist--centered pairing-required pairing-vertical pairing clearfix">
														<label class="primary page-text-body" for="vAccount-fields-country-1">
															<span class="pairing-label">Select One or More Users</span>
														</label>
														<div class="pairing-content">
															<div class="pairing-controls"> 
																<div class="field" style="max-height:300px;overflow:auto;background:#fff;border:1px solid #f0f0f0;padding:5px;">
																	<?php foreach ($wholesale_users as $user) { ?>
										
																	<div>
																		<input type="checkbox" name="email[]" value="<?php echo $user->email; ?>" style="position:relative;top:1px;float:left;"/>
																		<div style="margin-left:30px;"><?php echo ucwords($user->store_name).' <small>('.$user->email.')</small> '; ?></div>
																	</div>
																	
																	<?php } ?>
																</div>
															</div>
														</div>
													</li>

												</ul>
											</div>
												
											<div style="text-align:center;margin-top:35px;">
												<button type="submit" name="submit" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" value="SEND">
													Send  <?php echo $file === 'linesheet' ? 'Linesheet' : 'Sales Package'; ?>
												</button>
											</div>
											
											<?php } else { ?>
											
											No users available...
											
											<?php } ?>
											
											<?php echo form_close(); ?>
											<!-- End FORM ===================================================================-->
											<!-- END FORM-->
											
										</div>
									</div>
								
									<div id="ws-user-registration" class="cart-information" style="display:none;">
									
										<h3> New User: </h3>
										<br />
										<div class="return-policy-block">
										
											<?php
											/**********
											 * NEW USER
											 */
											?>
											<!-- BEGIN FORM-->
											<!-- FORM =======================================================================-->
											<?php echo form_open('sales/send_package/new_user'); ?>
											
											<input type="hidden" name="sales_package_id" value="<?php echo @$this->sales_package_details->sales_package_id ?: '0'; ?>" />
											
											<input type="hidden" name="type_of_sending" value="<?php echo @$file; ?>" />
											<input type="hidden" name="w_prices" value="Y" />
											<input type="hidden" name="w_images" value="N" />
											<input type="hidden" name="linesheets_only" value="N" />
											<input type="hidden" name="is_active" value="1" />
											<input type="hidden" name="reference_designer" value="<?php echo $this->sales_user_details->designer; ?>" />
											<input type="hidden" id="admin_sales_email" name="admin_sales_email" value="<?php echo $this->sales_user_details->email; ?>" />
										
											<div class="v-account-fields">
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">

														<li class="pairing-email pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-email-1">
																<span class="required">*</span>
																<span class="pairing-label">Email Address</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="email" required="required" class="input-text" id="vAccount-fields-email-1" name="email" value="<?php echo set_value('email'); ?>" />
																		<?php echo form_error('email'); ?>
																	</div>
																</div>
															</div>
														</li>

														<li class="pairing-pword pairinglist--centered pairing-required pairing-vertical pairing clearfix hidden">
															<label class="primary page-text-body" for="vAccount-fields-pword-1">
																<span class="required">*</span>
																<span class="pairing-label">Password</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="hidden" class="input-password" id="vAccount-fields-pword-1" name="pword" value="instyle2017" />
																	</div>
																</div>
															</div>
														</li>

													</ul>
												</div>
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">

														<li class="pairing-store_name pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-store_name-1">
																<span class="required">*</span>
																<span class="pairing-label">Company / Store</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" required="required" class="input-text" id="vAccount-fields-store_name-1" name="store_name" value="" />
																	</div>
																</div>
															</div>
														</li>

														<li class="pairing-fed_tax_id pairinglist--centered pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-fed_tax_id-1">
																<span class="pairing-label">Federal Tax ID</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" class="input-text" id="vAccount-fields-fed_tax_id-1" name="fed_tax_id" value="" />
																	</div>
																</div>
															</div>
														</li>

													</ul>
												</div>
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">

														<li class="pairing-firstname pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-firstname-1">
																<span class="required">*</span>
																<span class="pairing-label">First Name</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" required="required" class="input-text" id="vAccount-fields-firstname-1" name="firstname" value="" />
																	</div>
																</div>
															</div>
														</li>

														<li class="pairing-lastname pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-lastname-1">
																<span class="required">*</span>
																<span class="pairing-label">Last Name</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" required="required" class="input-text" id="vAccount-fields-lastname-1" name="lastname" value="" />
																	</div>
																</div>
															</div>
														</li>

													</ul>
												</div>
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">

														<li class="pairing-address1 pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-address1-1">
																<span class="required">*</span>
																<span class="pairing-label">Address 1</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" required="required" class="input-text" id="vAccount-fields-address1-1" name="address1" value="" />
																	</div>
																</div>
															</div>
														</li>

														<li class="pairing-address2 pairinglist--centered pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-address2-1">
																<span class="pairing-label">Address 2</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" class="input-text" id="vAccount-fields-address2-1" name="address2" value="" />
																	</div>
																</div>
															</div>
														</li>

													</ul>
												</div>
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">

														<li class="pairing-city pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-city-1">
																<span class="required">*</span>
																<span class="pairing-label">City</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" required="required" class="input-text" id="vAccount-fields-city-1" name="city" value="" />
																	</div>
																</div>
															</div>
														</li>

														<li class="pairing-country pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-country-1">
																<span class="required">*</span>
																<span class="pairing-label">Country</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<select required="required" class="input-select" id="vAccount-fields-country-1" name="country">
																			<option value="">- Select Country -</option>
														<?php foreach (list_countries() as $country) { ?>
                                                        <option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
														<?php } ?>
																		</select>
																	</div>
																</div>
															</div>
														</li>

													</ul>
												</div>
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">

														<li class="pairing- pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-state-1">
																<span class="required">*</span>
																<span class="pairing-label">State/Province</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<select required="required" class="input-select" id="vAccount-fields-state-1" name="state">
																			<option value="">- Select State -</option>
														<?php foreach (list_states() as $state) { ?>
                                                        <option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
														<?php } ?>
																		</select>
																	</div>
																</div>
															</div>
														</li>

														<li class="pairing-zipcode pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-zipcode-1">
																<span class="required">*</span>
																<span class="pairing-label">Zip</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" required="required" class="input-text" id="vAccount-fields-zipcode-1" name="zipcode" value="" />
																	</div>
																</div>
															</div>
														</li>

													</ul>
												</div>
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">

														<li class="pairing-telephone pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-telephone-1">
																<span class="required">*</span>
																<span class="pairing-label">Telephone</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" required="required" class="input-text" id="vAccount-fields-telephone-1" name="telephone" value="" />
																	</div>
																</div>
															</div>
														</li>

														<li class="pairing-fax pairinglist--centered pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="vAccount-fields-fax-1">
																<span class="pairing-label">Fax</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<div class="field">
																		<input type="text" class="input-text" id="vAccount-fields-fax-1" name="fax" value="" />
																	</div>
																</div>
															</div>
														</li>

													</ul>
												</div>
											</div>

											<div style="text-align:center;">
												<button type="submit" name="submit" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" value="SEND">
													Send <?php echo $file === 'linesheet' ? 'Linesheet' : 'Sales Package'; ?>
												</button>
											</div>
											
											<?php echo form_close(); ?>
											<!-- End FORM ===================================================================-->
											<!-- END FORM-->
											
										</div>
									</div>
									<!-- .cart-information -->
									
								</section>
								
