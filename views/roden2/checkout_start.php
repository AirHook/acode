					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<div class="v-checkout-checkouttemplate checkout-container checkout-multipage" data-step="'user'">
								<div class="wl-grid clearfix">
									<div class="template-row col ">
									
										<div class="checkout-progress">
											<p>
												<strong>Begin our secure checkout.</strong> 
												Please complete our simple 6-step process and your items will be on their way to you shortly.
											</p>
										</div>
				
										<?php
										/**********
										 * Renaming class 'checkout-content'
										 * to unhide it from site.css display:none; style
										 */
										?>
										<div class="checkout-content-renamed-to-unhide">
											<div class="v-checkout-startpagetemplate wl-grid start-page  clearfix" data-step="user">
											
												<?php
												/**********
												 * Column
												 * Create An Account
												 */
												?>
												<div class="col col-1of3">
													<section class="equal-height-section">
													
														<div class="v-account-createguestaccountform clearfix">
															<header class="header-subtext header-subtext--with-border  header-subtext--margined  center">
																<h4>Guest Checkout</h4>
																<p class="intro"><span class="subline">If you prefer shopping without registering, click below. You can create an account later for faster checkouts, online order history, and more.</span></p>
															</header>
															<form id="vAccount-createGuestAccountForm-form-1" name="vAccount_createGuestAccountForm_form_1" action="<?php echo site_url(); ?>" method="post" class="checkout-form isolated">
																<input type="hidden" name="fuseaction" value="checkout.createAccount" />
																<input type="hidden" name="isGuestAccount" value="1" />
																<button type="submit" class="button button--large button--center button--<?php echo $this->config->item('site_slug'); ?>">Guest Checkout</button>
															</form>
														</div>
														
													</section>
												</div>
										
												<?php
												/**********
												 * Column
												 * Create An Account
												 */
												?>
												<div class="col col-1of3">
													<section class="equal-height-section">
													
														<div class="v-account-form clearfix">
												
															<header class="header-subtext header-subtext--with-border center">
																<h4>Create An Account</h4>
																<p class="intro"><span class="subline">Create an account for faster checkouts, online order history, and more.</span></p>
															</header>
												
															<form name="vAccount_form_form_1" action="<?php echo site_url(); ?>" method="post" class="start-page__form  checkout-form">
															
																<input type="hidden" name="fuseaction" value="checkout.createAccount" />

																<div class="v-account-fields">
																	<div class="pairinglist clearfix" >
														
																		<ul class="pairings clearfix">
												
																			<li class="pairing-emailaddress pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																				<label class="primary" for="vAccount-fields-emailAddress-2">
																					<span class="required">*</span>
																					<span class="pairing-label">Email Address</span>
																				</label>
																				<div class="pairing-content">
																					<div class="pairing-controls"> 
																						<div class="field">
																							<input type="email" required="required" class="input-text" id="vAccount-fields-emailAddress-2" name="emailAddress" value="" />
																						</div>
																					</div>
																				</div>
																			</li>
												
																			<li class="pairing-confirmemailaddress pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																				<label class="primary" for="vAccount-fields-confirmEmailAddress-2">
																					<span class="required">*</span>
																					<span class="pairing-label">Confirm Email Address</span>
																				</label>
																				<div class="pairing-content">
																					<div class="pairing-controls"> 
																						<div class="field">
																							<input type="email" required="required" data-validation="{equalTo:'#vAccount-fields-emailAddress-2'}" class="input-text" id="vAccount-fields-confirmEmailAddress-2" name="confirmEmailAddress" value="" />
																						</div>
																					</div>
																				</div>
																			</li>
																
																		</ul>
																	</div>
												
																	<div class="pairinglist clearfix" >
																	
																		<ul class="pairings clearfix">
												
																			<li class="pairing-password pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																				<label class="primary" for="vAccount-fields-password-2">
																					<span class="required">*</span>
																					<span class="pairing-label">Password</span>
																				</label>
																				<div class="pairing-content">
																					<div class="pairing-controls"> 
																						<div class="field">
																							<input type="password" required="required" class="input-password" id="vAccount-fields-password-2" name="password" value="" />
																						</div>
																					</div>
																				</div>
																			</li>
												
																			<li class="pairing-confirmpassword pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																				<label class="primary" for="vAccount-fields-confirmPassword-2">
																					<span class="required">*</span>
																					<span class="pairing-label">Confirm Password</span>
																				</label>
																				<div class="pairing-content">
																					<div class="pairing-controls"> 
																						<div class="field">
																							<input type="password" required="required" data-validation="{equalTo:'#vAccount-fields-password-2'}" class="input-password" id="vAccount-fields-confirmPassword-2" name="confirmPassword" value="" />
																						</div>
																					</div>
																				</div>
																			</li>
																
																		</ul>
																	</div>

																</div>

																<button type="submit" class="button button--large button--center button--<?php echo $this->config->item('site_slug'); ?>" id="vAccount-form-submit_noPreload-1" name="accountFormSubmit_noPreload">Create Account</button>
																
															</form>
														</div>
														
														<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>\
														
													</section>
												</div>
										
												<?php
												/**********
												 * Column
												 * Returning Customers
												 */
												?>
												<div class="col col-1of3">
													<section class="equal-height-section">
													
														<div class="v-login-form section">
														
															<div class="header-subtext header-subtext--with-border center">
																<h4>Returning Customers</h4>
																<p class="intro"><span class="subline">Already have a account with us? Sign in here.</span></p>
															</div>
															
															<form id="vLogin-form-form-1" name="vLogin_form_form_1" action="#" method="post" class="start-page__form  checkout-form">
															
																<input type="hidden" name="fuseaction" value="login.processLogin" />
												
																<div class="v-login-fields clearfix">
																	<div class="pairinglist clearfix" >
													
																		<ul class="pairings clearfix">
											
																			<li class="pairing-emailaddress pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																				<label class="primary" for="vLogin-fields-emailAddress-1">
																					<span class="required">*</span>
																					<span class="pairing-label">Email Address</span>
																				</label>
																				<div class="pairing-content">
																					<div class="pairing-controls"> 
																						<input type="email" class="input-text" required="required" id="vLogin-fields-emailAddress-1" name="emailAddress" value="" />
																					</div>
																				</div>
																			</li>
											
																			<li class="pairing-password pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																				<label class="primary" for="vLogin-fields-password-1">
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

																<button type="submit" class="button button--large button--center button--<?php echo $this->config->item('site_slug'); ?>">Sign In</button>
																
																<a href="#" class="start-page__recovery  button button--text  button--center dialog" data-dialog='{"dialogClass": "dialog-no-title-bar"}' title="Password Recovery Page">Forgot Your Password?</a>
																
															</form>
														</div>
														
														<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>
														
													</section>
												</div>

											</div>
										</div>
			
									</div>
								</div>
							</div>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>

                
