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
													<?php if ($this->session->flashdata('error') == 'invalid_credentials') { ?>
													<div class="center notice" style="background:pink;font-size:1.33em;padding:20px;">
														Invalid credetials. Please try again.
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
														
														<a class="start-page__recovery  button button--text  button--center hidden" title="Password Recovery" onclick="$('#reset-password-form').show();$('#sign-in-form').hide();$('div.notice').hide();">Forgot Your Password?</a>
														
													<?php echo form_close(); ?>
													<!--eof form===========================================================================-->
													
													<p class="reqmsg">*<span class="screenreaderonly"> indicates </span>Required</p>
												</div>
												
											</div>

										</section>
									</div>
			
								</div>
							</div>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>
				</div><!-- END .wrap-content -->

