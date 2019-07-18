					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
					
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<div class="v-login-formstemplate clearfix">
								<h1>Login: To send store buyers product offers and to download linesheets</h1>
		
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
														<p><span class="subline hidden" style="font-size:1.05rem;">Resource (ADMIN SALES ONLY)</span></p>
														<p class="intro"><span class="subline">FILL IN BELOW FIELDS TO LOGIN TO YOUR DASHBOARD</span></p>
													</div>
													
													<?php
													/**********
													 * Notification Area
													 */
													?>
													<?php if ($this->session->flashdata('flashMsg')): ?>
													<div class="center notice" style="<?php echo $this->webspace_details->slug == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'background:pink;'; ?>padding:20px;">
														<?php echo strtoupper($this->session->flashdata('flashMsg')); ?>
													</div>
													<?php endif; ?>
													<?php if ($this->session->flashdata('success') == 'recovery_password_email_sent') { ?>
													<div class="center notice" style="background:#bbefa3;font-size:1.33em;padding:20px;">
														Recovery password email sent.<br />
														Thank you and we will reply shortly.
													</div>
													<?php } ?>
													<?php if ($this->session->flashdata('error') == 'invalid_credentials') { ?>
													<div class="center notice" style="background:pink;font-size:1.33em;padding:20px;">
														Invalid credetials. Please try again.
													</div>
													<?php } ?>
													<?php if ($this->session->flashdata('error') == 'incorrect_site') { ?>
													<div class="center notice" style="background:pink;font-size:1.33em;padding:20px;">
														Invalid login site. Please try again.
													</div>
													<?php } ?>
													<?php if ($this->session->flashdata('error') == 'unauthenticated') { ?>
													<div class="center notice" style="background:pink;font-size:1.33em;padding:20px;">
														You must be logged in to access page.
													</div>
													<?php } ?>
													<?php if ($this->session->flashdata('error') == 'time_lapse') { ?>
													<div class="center notice" style="background:pink;font-size:1.33em;padding:20px;">
														You have been idle for some time now. Please login again.
													</div>
													<?php } ?>
													<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
													<div class="center notice" style="background:pink;font-size:1.33em;padding:20px;">
														An error occured in the authentication process. Please login again.
													</div>
													<?php } ?>
													
													<!--bof form===========================================================================-->
													<?php
													// --------------------------------------
													// Login area
													echo form_open('resource');
													echo form_hidden('site_slug', $this->webspace_details->slug);
													?>
														
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
															<button type="submit" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" style="width:200px;">Sign In Now</button>
														</div>
														
														<a class="start-page__recovery  button button--text  button--center" title="Password Recovery" onclick="$('#reset-password-form').show();$('#sign-in-form').hide();$('div.notice').hide();">Forgot Your Password?</a>
														
													<?php echo form_close(); ?>
													<!--eof form===========================================================================-->
													
												</div>
												
												<div id="reset-password-form" class="hidden" style="width:50%;margin:0 auto;">
													<div class="header-subtext header-subtext--with-border center hidden-on-mobile">
														<p><span class="subline" style="font-size:1.05rem;">RECOVER PASSWORD</span></p>
														<p class="intro"><span class="subline">Fill in details below.</span></p>
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
													echo form_open('resource/forget_password');
													echo form_hidden('site_referrer', ($this->webspace_details->site ?: $this->config->item('site_domain')));
													?>
													<!--<form id="vLogin-form-form-1" name="vLogin_form_form_1" action="" method="post" class="start-page__form  checkout-form">
														<input type="hidden" name="fuseaction" value="login.processLogin" />-->
														
														<div class="v-login-fields clearfix">
															<div class="pairinglist clearfix" >
																<ul class="pairings clearfix">
													
																	<li class="pairing-username pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="vLogin-fields-username-1">
																			<span class="required">*</span>
																			<span class="pairing-label">Name</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<input type="text" class="input-text" required="required" id="vLogin-fields-username-1" name="username" value="" />
																			</div>
																		</div>
																	</li>
													
																	<li class="pairing-email pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="vLogin-fields-email-1">
																			<span class="required">*</span>
																			<span class="pairing-label">Email Address</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<input type="email" class="input-text" required="required" id="vLogin-fields-email-1" name="email" value="" />
																			</div>
																		</div>
																	</li>
													
																	<li class="pairing-telephone pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="vLogin-fields-telephone-1">
																			<span class="required">*</span>
																			<span class="pairing-label">Telephone</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<input type="text" class="input-text" required="required" id="vLogin-fields-telephone-1" name="telephone" value="" />
																			</div>
																		</div>
																	</li>
													
																</ul>
															</div>
														</div>
														
														<p class="page-text-body" style="letter-spacing:1px;">
															Please enter your email address to retrieve your forgotten password.<br />
															If you do not receive your email please be sure to check your spam or junk folder.<br />
															For other concerns, you may contact us <a href="<?php echo site_url('contact'); ?>" tabindex="-98">here</a>.
														</p>

														<div style="text-align:center;">
															<button type="submit" class="button button--small--text button--<?php echo $this->webspace_details->slug ?: $this->config->item('site_slug'); ?>" style="width:300px;">Forgot My Password</button>
														</div>
														
														<a class="start-page__recovery  button button--text  button--center " title="Sign In Now" onclick="$('#reset-password-form').hide();$('#sign-in-form').show();$('div.notice').hide();">Sign In now here.</a>
														
													<?php echo form_close(); ?>
													<!--eof form===========================================================================-->
													
												</div>
												
												<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>
											</div>

										</section>
									</div>
			
								</div>
							</div>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>
				</div><!-- END .wrap-content -->

