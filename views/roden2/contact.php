									<div class="wl-contact-us" data-source="v-customerservice-contactus">
									
										<h1>Contact Us</h1>

										<div class="wl-grid clearfix">
											<div class="col md-col-7of12">

												<?php if ($view == 'contact_form'): ?>

												<?php if (isset($_SESSION['flashMsg'])) { ?>
												<div class="center notice" style="<?php echo $this->webspace_details->slug == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'background:pink;'; ?>padding:20px;">
													<?php echo $_SESSION['flashMsg']; ?>
												</div>
												<?php } ?>
												
												<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>
												
												<!-- BOF Form ==============================================================-->
												<?php echo form_open('contact'); ?>
				
													<?php if (validation_errors()): ?>
													<div class="center notice" style="<?php echo $this->webspace_details->slug == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'background:pink;'; ?>padding:20px;">
														<?php echo validation_errors(); ?>
													</div>
													<?php endif; ?>
													
													<input type="hidden" name="fuseaction" value="customerService.sendForm" />
					
													<div class="pairinglist clearfix" >
				
														<ul class="pairings clearfix">
		
															<li class="pairing-fname pairing-required pairing-vertical pairing clearfix">
																<label class="primary" for="fname">
																	<span class="required">*</span>
																	<span class="pairing-label">First Name:</span>
																	
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<input type="text" class="input-text" id="name" name="fname" value="<?php echo set_value('fname'); ?>" required="required" />
																		<?php echo form_error('fname'); ?>
																	</div>
																</div>
															</li>
		
															<li class="pairing-fname pairing-required pairing-vertical pairing clearfix">
																<label class="primary" for="lname">
																	<span class="required">*</span>
																	<span class="pairing-label">Last Name:</span>
																	
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<input type="text" class="input-text" id="name" name="lname" value="<?php echo set_value('lname'); ?>" required="required" />
																		<?php echo form_error('lname'); ?>
																	</div>
																</div>
															</li>
		
															<li class="pairing--state pairing-required pairing-vertical pairing clearfix">
																<label class="primary" for="state">
																	<span class="required">*</span>
																	<span class="pairing-label">State / Provinces</span>
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<select id="state" name="state" required="required">
																			<option value="">[Select State]</option>
																			
																			<?php foreach (list_states() as $state) { ?>
																			<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
																			<?php } ?>
																			
																		</select>
																		<?php echo form_error('state'); ?>
																	</div>
																</div>
															</li>
		
															<li class="pairing--country pairing-required pairing-vertical pairing clearfix">
																<label class="primary" for="country">
																	<span class="required">*</span>
																	<span class="pairing-label">Country</span>
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<select id="country" name="country" required="required">
																			<option value="">[Select Country]</option>
																			
																			<?php foreach (list_countries() as $country) { ?>
																			<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																			<?php } ?>
																			
																		</select>
																		<?php echo form_error('country'); ?>
																	</div>
																</div>
															</li>
		
															<li class="pairing-telephone pairing-required pairing-vertical pairing clearfix">
																<label class="primary" for="telephone">
																	<span class="required">*</span>
																	<span class="pairing-label">Phone Number:</span>
																	
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<input type="text" class="input-text" id="telephone" name="telephone" value="<?php echo set_value('telephone'); ?>" />
																		<?php echo form_error('telephone'); ?>
																	</div>
																</div>
															</li>
		
															<li class="pairing-email pairing-required pairing-vertical pairing clearfix">
																<label class="primary" for="email">
																	<span class="required">*</span>
																	<span class="pairing-label">Email Address:</span>
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<input type="email" class="input-text" id="email" name="email" value="<?php echo set_value('email'); ?>" required="required" />
																		<?php echo form_error('email'); ?>
																	</div>
																</div>
															</li>
															
															<li class="pairing-comments pairing-vertical pairing clearfix">
																<label class="primary" for="comments">

																	<span class="pairing-label">Comment/Question (limit of 500 characters)</span>
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<textarea id="comments" name="comments" rows="2" cols="40" maxlength="500" required="required"><?php echo set_value('comments'); ?></textarea>
																		<?php echo form_error('comments'); ?>
																	</div>
																</div>
															</li>
		
															<li class="pairing-recieveupdate pairing-required pairing-vertical pairing clearfix">
																<label class="primary" for="recieveupdate">
																	<span class="required">*</span>
																	<span class="pairing-label">Would you like to receive product updates from <?php echo $this->config->item('site_name'); ?> by Email?</span>
																	
																</label>
																<div class="pairing-content">
																	<div class="pairing-controls"> 
																		<input type="radio" class="input-radio" id="" name="recieveupdate" value="1" checked="true" >Yes</input>
																		<br/>
																		<input type="radio" class="input-radio" id="" name="recieveupdate" value="0" >No</input>
																	</div>
																</div>
															</li>
															
														</ul>
													</div>
		
													<div class="actionlist clearfix">
														<ul class="actions clearfix">
															<li class="action-primary action clearfix"> 
																<input class="button button--large button--<?php echo $this->webspace_details->slug; ?>" value="Submit" type="submit" value="Submit" name="submit" />
															</li> 
														</ul>
													</div>
										
												<?php echo form_close(); ?>
												<!-- EOF Form ==============================================================-->
												
												<?php else: ?>
												
												<h2>
													Thank you for contacting us.
													<br />
													You will be hearing from us within 24 hours to better assist you.
												</h2>
												
												<?php endif; ?>
												
											</div>

											<div class="col md-col-5of12 contact-methods" style="padding-left:30px">
				
												<div class="clearfix">
													<!-- SIDE BODY -->
													<!-- 2016-06-29 -->
													
													<h2 style="border-bottom:1px solid #dcdcdc;text-transform:uppercase;">Email</h2>
													<p>
														To contact us via email, complete the fields to the left, or write us at <?php echo safe_mailto($this->webspace_details->info_email, $this->webspace_details->info_email); ?>
													</p>
													
													<h2 style="border-bottom:1px solid #dcdcdc;text-transform:uppercase;">Support</h2>
													<p>
														Sales and Customer Support is available 7am – midnight EST, seven days a week: <?php echo safe_mailto($this->webspace_details->info_email, $this->webspace_details->info_email); ?>
													</p>
													
													<h2 style="border-bottom:1px solid #dcdcdc;text-transform:uppercase;">Mail</h2>
													<p>
														<?php echo strtoupper($this->webspace_details->name); ?>
														<br /> <?php echo $this->webspace_details->address1; ?>
														<br /> <?php echo $this->webspace_details->address2; ?>
														<br /> <?php echo $this->webspace_details->phone; ?>
													</p>
												</div>
					
											</div>
										</div>
									</div>
