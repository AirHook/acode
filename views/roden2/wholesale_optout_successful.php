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
														Optout
													</a>
												</h2>
												<div style="display: block;" class="summary">
												
													<div class="section clearfix">
													
														We are sorry to see you leave.<br />
														You have successfully opted out of our mailing list.
													
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
