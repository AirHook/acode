					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<div class="v-checkout-checkouttemplate checkout-container checkout-multipage" data-step="'addresses'">
								<div class="wl-grid clearfix">

									<?php
									/**********
									 * 3/4 column
									 */
									?>
									<div class="template-row col col-8of12">
									
										<div class="system-message general-message hidden">
											<div class="message">
												To protect your security, your guest account has expired due to inactivity.  Your items are still in your Cart, so please continue to checkout.
											</div>
										</div>
		
										<?php if ($this->session->flashdata('flashMsg')): ?>
										
										<div style="<?php echo $this->config->item('site_slug') == 'tempoparis' ? 'background:red;color:white;font-size:1.33em;' : 'background:pink;'; ?>padding:10px 20px;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
											<?php echo $this->session->flashdata('flashMsg'); ?>
										</div>
										
										<?php endif; ?>
										
										<?php
										/**********
										 * Renaming class 'checkout-content'
										 * to unhide it from site.css display:none; style
										 */
										?>
										<div class="checkout-content-renamed-to-unhide">
										
										
											<div class="checkout-step section clearfix checkout-step-completed" data-step="'addresses'">
										
												<h2 class="section-heading">
													<a class="checkout-heading-link" href="#addresses">
														Your Information
													</a>
												</h2>
												<div style="display: block;" class="summary">
													<div class="v-checkout-xhrsummary clearfix">
					
														<div class="contact contact-vertical vcard">
															<div class="adr">
																<div class="fn n">
																	<span class="given-name"><?php echo $this->wholesale_user_details->fname; ?></span>
																	<span class="family-name"><?php echo $this->wholesale_user_details->lname; ?></span>
																</div>
																<div>
																	<span class="street-address"><?php echo $this->wholesale_user_details->store_name; ?></span>
																</div>
																<span class="street-address"><?php echo $this->wholesale_user_details->address1; ?></span>
																<span class="street-address"><?php echo $this->wholesale_user_details->address2; ?></span>
																<div>
																	<span class="locality"><?php echo $this->wholesale_user_details->city; ?></span>
																	<span class="region"><?php echo $this->wholesale_user_details->country == 'United States' ? $this->wholesale_user_details->state : $this->wholesale_user_details->state; ?></span>
																	<span class="postal-code"><?php echo $this->wholesale_user_details->zipcode; ?></span> 
																</div>
																<div class="country-name"><?php echo $this->wholesale_user_details->country; ?></div>
															</div>
															<div class="tel">
																<strong>Telephone:</strong>
																<span class="value"><?php echo $this->wholesale_user_details->telephone; ?></span>
															</div>
														</div>
		
														<div class="actionlist clearfix">
															<ul class="actions clearfix">
																<li class="action-primary action clearfix"> 
																	<a href="<?php echo site_url('wholesale/logout'); ?>" class="button button--small button--<?php echo $this->webspace_details->slug; ?>">
																		Logout
																	</a>
																</li> 
															</ul>
														</div>
														
													</div>
													
													<div class="section clearfix">
													
														<?php if ($this->session->sales_package) { ?>
														
														<div class="active-sales-package">
															Sales Package Active Link:<br />
															<?php
															$link = implode('/', json_decode($this->session->sales_package_link, TRUE));
															?>
															<a href="<?php echo site_url($link); ?>">
																<?php echo site_url($link); ?>
															</a>
														</div>
														
														<?php } ?>
														
													</div>
													
												</div>	
	
											</div>
											
										</div>
									</div>
									
									<?php
									/**********
									 * 3/4 column
									 */
									?>
									<div class="col col-4of12 ">
									
										<!-- This shows up on the cart page, as well as pdp -->
										<style>
											.return-policy-block a,
											.return-policy-block a:visited {
												color: #666666;
												text-decoration: underline;
											}

											.return-policy-block a:hover {
												color: #333333;
											}

											.accordion__section .terms {
												display: none;
											}
										</style>
										<div class="return-policy-block">
											<p>
												<b>FAQs</b>
												<br /> Have questions? <a class="external-link" href="<?php echo site_url('faq'); ?>" rel="nofollow">Read our FAQs</a>
											</p>
											<br />
											<p>
												<b>RETURNS</b>
												<br /> Learn more about our <a class="external-link" href="#" rel="nofollow">return policy</a>
											</p>
											<br />
											<p>
												<b>SHIPPING</b>
												<br /> See information on our <a class="external-link" href="<?php echo site_url('shipping'); ?>" rel="nofollow">shipping</a>
											</p>
											<br />
											<p>
												<b>INTERNATIONAL ORDERS</b>
												<br /> Are you an international customer? Read more about our shipping rates for <a class="external-link" href="#" rel="nofollow">international orders</a>
											</p>
											<br />
											<p>
												<b>Dresses not returned in original condition may be refused or subject to a $75 restocking fee.</b> <a class="external-link" href="#">Learn more</a>
											</p>
										</div>

									</div>
									
								</div>
							</div>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>
