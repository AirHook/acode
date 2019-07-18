					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
					
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<div class="v-login-formstemplate clearfix">
								<h1>Sign In</h1>
		
								<div class="wl-grid clearfix">
								
									<?php
									/**********
									 * Left Side Sign In
									 */
									?>
									<div class="col col-1of1">
										<section class="equal-height-section">
					
											<div class="v-login-form section page-text-body">
											
												<div id="sign-in-form" style="width:50%;margin:0 auto;">
													<div class="header-subtext header-subtext--with-border center hidden-on-mobile">
														<p><span class="subline" style="font-size:1.05rem;">Resource (ADMIN SALES ONLY)</span></p>
														<p class="intro"><span class="subline">Sign in.</span></p>
													</div>
													<div class="header-subtext header-subtext--with-border center hidden-on-desktop">
														<p>Returning Customers (RETAILERS ONLY)</p>
														<p class="intro">Sign in to place Wholesale Order.</p>
													</div>
													
													<?php if ($this->session->flashdata('flashMsg')): ?>
													<div class="center notice" style="<?php echo $this->config->item('site_slug') == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'background:pink;'; ?>padding:20px;">
														<?php echo strtoupper($this->session->flashdata('flashMsg')); ?>
													</div>
													<?php endif; ?>
													
													<!--bof form===========================================================================-->
													<?php
													// --------------------------------------
													// Login area
													echo form_open('resource');
													echo form_hidden('site_slug', $this->config->item('site_slug'));
													?>
													<!--<form id="vLogin-form-form-1" name="vLogin_form_form_1" action="" method="post" class="start-page__form  checkout-form">
														<input type="hidden" name="fuseaction" value="login.processLogin" />-->
														
														<div class="v-login-fields clearfix">
															<div class="pairinglist clearfix" >
																<ul class="pairings clearfix">
													
																	<li class="pairing-username pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="vLogin-fields-username-1">
																			<span class="required">*</span>
																			<span class="pairing-label">Email Address</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<input type="email" class="input-text" required="required" id="vLogin-fields-username-1" name="username" value="" />
																			</div>
																		</div>
																	</li>
													
																	<li class="pairing-password pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="vLogin-fields-password-1">
																			<span class="required">*</span>
																			<span class="pairing-label">Password</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<input type="password" class="input-password" required="required" id="vLogin-fields-password-1" name="password" />
																			</div>
																		</div>
																	</li>
																</ul>
															</div>
														</div>

														<div style="text-align:center;">
															<button type="submit" class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" style="width:200px;">Sign In Now</button>
														</div>
														
														<a class="start-page__recovery  button button--text  button--center hidden" title="Password Recovery" onclick="$('#reset-password-form').show();$('#sign-in-form').hide();$('div.notice').hide();">Forgot Your Password?</a>
														
													<?php echo form_close(); ?>
													<!--eof form===========================================================================-->
													
													<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>
												</div>
												
												<div id="reset-password-form" class="hidden">
													<div class="header-subtext header-subtext--with-border center hidden-on-mobile">
														<p><span class="subline" style="font-size:1.05rem;">RECOVER PASSWORD</span></p>
														<p class="intro"><span class="subline">Enter email address.</span></p>
													</div>
													<div class="header-subtext header-subtext--with-border center hidden-on-desktop">
														<p>RECOVER PASSWORD</p>
														<p class="intro">Enter email address.</p>
													</div>
													
													<?php if ($this->session->flashdata('flashMsg')): ?>
													<div class="center notice" style="<?php echo $this->config->item('site_slug') == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'background:pink;'; ?>padding:20px;">
														<?php echo strtoupper($this->session->flashdata('flashMsg')); ?>
													</div>
													<?php endif; ?>
													
													<!--bof form===========================================================================-->
													<?php
													// --------------------------------------
													// Login area
													echo form_open('wholesale/reset_password');
													echo form_hidden('password', 'reset_password');
													echo form_hidden('site_referrer', $this->config->item('site_domain'));
													?>
													<!--<form id="vLogin-form-form-1" name="vLogin_form_form_1" action="" method="post" class="start-page__form  checkout-form">
														<input type="hidden" name="fuseaction" value="login.processLogin" />-->
														
														<div class="v-login-fields clearfix">
															<div class="pairinglist clearfix" >
																<ul class="pairings clearfix">
													
																	<li class="pairing-username pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="vLogin-fields-username-1">
																			<span class="required">*</span>
																			<span class="pairing-label">Email Address</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<input type="email" class="input-text" required="required" id="vLogin-fields-username-1" name="email" value="" />
																			</div>
																		</div>
																	</li>
													
																</ul>
															</div>
														</div>
														
														<p class="page-text-body" style="letter-spacing:1px;">
															Please enter your email address to retrieve your forgotten password.<br />
															If you do not receive your email please be sure to check your spam or junk folder.<br />
															For other concerns, you may contact us <a href="<?php echo site_url('contact'); ?>">here</a>.
														</p>

														<div style="text-align:center;">
															<button type="submit" class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" style="width:200px;">Recover Password</button>
														</div>
														
														<a class="start-page__recovery  button button--text  button--center " title="Sign In Now" onclick="$('#reset-password-form').hide();$('#sign-in-form').show();$('div.notice').hide();">Sign In now here.</a>
														
													<?php echo form_close(); ?>
													<!--eof form===========================================================================-->
													
													<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>
												</div>
												
											</div>

										</section>
									</div>
			
									<?php
									/**********
									 * Right Side Register
									 */
									?>
									<div class="col col-1of2 hidden">
										<section class="equal-height-section">
					
											<div class="v-account-form clearfix page-text-body">
												<header class="header-subtext header-subtext--with-border center hidden-on-mobile">
													<p><span class="subline" style="font-size:1.05rem;">Create An Account (STORES ONLY)</span></p>
													<p class="intro"><span class="subline">Register for Wholesale Pricing information.</span></p>
												</header>
												<header class="header-subtext header-subtext--with-border center hidden-on-desktop">
													<p>Create An Account (STORES ONLY)</p>
													<p class="intro">Register for Wholesale Pricing information.</p>
												</header>
		
												<?php if ($this->session->flashdata('flashRegMsg')): ?>
												<div class="center" style="background:<?php echo $this->config->item('site_slug') == 'tempoparis' ? 'red' : 'pink'; ?>;padding:20px;">
													<?php echo $this->session->flashdata('flashRegMsg'); ?>
												</div>
												<?php endif; ?>
												
												<!--bof form=============================================================================-->
												<?php echo form_open('wholesale/register'); ?>
												<?php echo form_hidden('site_referrer', $this->config->item('site_domain')); ?>
												
												<?php
												// code snipet to check if referred by sales package check user from sales address book
												if ($this->session->flashdata('ref_from_sales_package_offer'))
												{
													echo form_hidden('sa_landing_page', $this->session->userdata('sa_lading_page'));
													echo form_hidden('ref_from_sales_package_offer', TRUE);
													echo form_hidden('admin_sales_email', $this->session->userdata('sa_admin_sales_email'));
													echo form_hidden('reference_designer', $this->session->userdata('sa_ref_designer'));
												}
												?>
												<!--<form name="vAccount_form_form_1" action="" method="post" class="start-page__form">
													<input type="hidden" name="fuseaction" value="account.create" />-->

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
		
																<li class="pairing-pword pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																	<label class="primary page-text-body" for="vAccount-fields-pword-1">
																		<span class="required">*</span>
																		<span class="pairing-label">Password</span>
																	</label>
																	<div class="pairing-content">
																		<div class="pairing-controls"> 
																			<div class="field">
																				<input type="password" required="required" class="input-password" id="vAccount-fields-pword-1" name="pword" value="" />
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
																					<?php
																					$get_country = $this->query_page->get_country();
																					if($get_country->num_rows()>0) {
																						foreach($get_country->result() as $country) {
																							?>
																					<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																							<?php
																						}
																					}
																					?>
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
																					<?php
																					$get_states = $this->query_page->get_states();
																					if($get_states->num_rows()>0) {
																						foreach($get_states->result() as $state) {
																							?>
																					<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state', $state->state_name); ?>><?php echo $state->state_name; ?></option>
																							<?php
																						}
																					}
																					?>
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
			
												<p style="color:#ba6a5c;font-size:.75rem;font-style: italic;letter-spacing:0;"><?php echo $this->config->item('site_name'); ?> respects your privacy and does not share e-mail addresses with third parties.<br /><br /></p>
											
												<div style="text-align:center;">
													<button type="submit" class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" id="vAccount-form-submit_noPreload-1" name="accountFormSubmit_noPreload" style="wodth:200px;">Create Account</button>
												</div>

												<?php echo form_close(); ?>
												<!--eof form=============================================================================-->
												
											</div>
											<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>

										</section>
									</div>
								</div>
							</div>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>
				</div><!-- END .wrap-content -->

