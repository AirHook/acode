				<footer>
				
					<ul class="footer-nav">
						<li class="ordering<?php echo ($this->uri->uri_string() == 'ordering' OR $this->uri->uri_string() == 'special_sale/ordering') ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'ordering'); ?>">Ordering</a>
						</li>
						<li class="shipping<?php echo ($this->uri->uri_string() == 'shipping' OR $this->uri->uri_string() == 'special_sale/shipping') ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'shipping'); ?>">Shippping</a>
						</li>
						<li class="shipping<?php echo ($this->uri->uri_string() == 'return_policy' OR $this->uri->uri_string() == 'special_sale/return_policy') ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'return_policy'); ?>">Returns</a>
						</li>
						<li class="privacy_notice<?php echo ($this->uri->uri_string() == 'privacy_notice' OR $this->uri->uri_string() == 'special_sale/privacy_notice') ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'privacy_notice'); ?>">Privacy</a>
						</li>
						<li class="faq<?php echo ($this->uri->uri_string() == 'faq' OR $this->uri->uri_string() == 'special_sale/faq') ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'faq'); ?>">FAQ</a>
						</li>
						
						<?php if ($this->uri->segment(1) !== 'special_sale'): ?>
						
						<li class="sitemap<?php echo $this->uri->uri_string() == 'sitemap' ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'sitemap'); ?>">Sitemap</a>
						</li>
							
							<?php if ($this->config->item('site_slug') !== 'tempoparis'): ?>
							
						<li class="press<?php echo $this->uri->uri_string() == 'press' ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'press'); ?>">Press</a>
						</li>
						
							<?php endif; ?>
							
						<?php endif; ?>
						
						<li class="contact<?php echo ($this->uri->uri_string() == 'contact' OR $this->uri->uri_string() == 'special_sale/contact') ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'contact'); ?>">Contact</a>
						</li>
						
						<?php if (
							$this->config->item('site_slug') !== 'issueny' 
							AND $this->config->item('site_domain') !== 'www.tempoparis.net'
							AND $this->config->item('site_slug') !== 'issuenewyork'
							AND $this->config->item('site_slug') !== 'issueny'
							AND $this->config->item('site_slug') !== 'andrewoutfitter'
							AND $this->config->item('site_slug') !== 'storybookknits'
						) { ?>
						
						<li class="terms_of_use<?php echo ($this->uri->uri_string() == 'terms_of_use' OR $this->uri->uri_string() == 'special_sale/terms_of_use') ? ' is_active_footer_nav' : ''; ?>">
							<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale_' ? 'special_sale/' : '').'terms_of_use'); ?>">Terms Of Use</a>
						</li>
						<li class="resource<?php echo $this->uri->uri_string() == 'resource' ? ' is_active_footer_nav' : ''; ?>" style="display:none;">
							<a href="<?php echo site_url('resource'); ?>">Resource</a>
						</li>
						
						<?php } ?>
						
					</ul>

					<?php
					/*****
					 * Will display onclick of "Our Collection" link
					 */
					?>
					<div class="about-text  js-about-text">
						<p>We offer a keen edit of wedding gowns, bridal accessories, bridesmaid dresses, wedding decor, and gifts. You can browse our full assortment of wedding dresses online at any time. Should you like to try on a style before purchasing, please contact one of our <a href="<?php echo str_replace('https', 'http', site_url()); ?>">several locations</a> across the country to make an appointment. (Note appointments are recommended for trying on wedding dress styles only.)</p>
					</div>

					<?php if ( ! $this->session->userdata('user_loggedin') OR $this->session->userdata('user_cat') != 'wholesale'): ?>
					
					<?php
					/*****
					 * Socials
					 */
					?>
					<ul class="footer-social clearfix hidden" style="display:none;">
						<!--
						<li class="facebook">
							<a href="http://www.facebook.com/"
								class="coremetrics-tag"
								data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'
								target="_blank">
								<span class="txt">Facebook</span>
								<span class="ico"></span>
							</a>
						</li>
						<li class="twitter">
							<a href="http://twitter.com/"
								class="coremetrics-tag"
								data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'
								target="_blank">
								<span class="txt">Twitter</span>
								<span class="ico"></span>
							</a>
						</li>
						-->
						<li class="youtube">
							<a target="_blank" class="icon fa-2x fa fa-youtube-play" style="background:none;color:#9a9a9a;">
									<span class="txt">You Tube</span>
									<span class="ico"></span>
							</a>
						</li>
						<li class="pinterest">
							<a target="_blank" class="icon fa-2x fa fa-pinterest-square" style="background:none;color:#9a9a9a;">
									<span class="txt">Pinterest</span>
									<span class="ico"></span>
							</a>
						</li>
						<li class="instagram">
							<a target="_blank" class="icon fa-2x fa fa-instagram" style="background:none;color:#9a9a9a;">
									<span class="txt">Instagram</span>
									<span class="ico"></span>
							</a>
						</li>
					</ul>

					<?php
					/*****
					 * Opt In Email
					 */
					?>
					<!--
					<form id="vLayout-layout-form-1" name="vLayout_layout_form_1" action="" method="post" class="dialog footer-signup hide" onSubmit="ga.send('send', 'event', 'newsletter signups', 'submit', 'footer');" data-dialog='{"dialogClass": "wl-dialog--bordered", "minHeight": 180}'>
						<input type="hidden" name="fuseaction" value="emailSignup.processBrandedSignUp" />
						<label class="primary" for="email"><span class="required">*</span><span>Email Signup</span></label>
						<input type="email" class="input-text" id="email" name="emailAddress" required="required" placeholder="sign up for special offers" />
						
						<div class="actionlist clearfix">
							<ul class="actions clearfix">
								<li class="action-primary action clearfix"> 
									<button type="submit" class="button--icon">Submit</button>
								</li> 
							</ul>
						</div>
					</form>
					-->
					<?php endif; ?>
					
				</footer>
				
			</div>
			<!-- #wrap-bg2 -->
		
		<?php if ($this->uri->uri_string() == ''): ?>
		
		<p id="back-top">
			<a href="#body-tag"><span class="icon icon-up fa fa-angle-up fa-5x" aria-hidden="true"></span><span class="">Back To Top</span></a>
		</p>
		
		<p id="start-page-down">
			<a href="#body-tag-bottom" class="hidden-on-desktop"><span class="icon icon-down fa fa-angle-down fa-5x" aria-hidden="true"></span></a>
		</p>
		
		<?php endif; ?>
		
        </div>
		<!-- #wrap -->

		<?php
		/**********
		 * Popup Dialog
		 * for Return Policy
		 */
		?>
		<!-- Desktop -->
		<div aria-labelledby="ui-dialog-title-1" id="ws-lapse-dialog" role="dialog" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="display: none; z-index: 10001; outline: 0px none; height: auto; width: 700px; top: 30px; left: 50%; margin-left:-350px;">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix bg-color-<?php echo $this->webspace_details->slug; ?>">
				<span id="ui-dialog-title-1" class="ui-dialog-title">&nbsp;</span>
				<a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);" onclick="$('#ws-lapse-dialog').hide();"><span class="ui-icon ui-icon-closethick"></span></a>
			</div>
			<div style="width: auto; min-height: 115px; height: auto; padding: 20px 50px;" class="ui-dialog-content ui-widget-content">
				<div class="v-checkout-shippingaddresstemplate clearfix">
					
					<p style="font-size:1.3em;">
					Hi <?php echo $this->wholesale_user_details->fname; ?>!
					</p>
					
					<p style="font-size:1.3em;">
					You were idle for quite some time. Would you like to continue with your session?
					</p>
					
					<div class="actionlist clearfix">
						<ul class="actions clearfix">
							<li class="action-primary action clearfix"> 
								<a href="<?php echo site_url('wholesale/logout'); ?>" class="button button--small button--<?php echo $this->webspace_details->slug; ?>">
									Log Me Out </a>
							</li> 
							<li class="action-default action clearfix"> 
								<a href="<?php echo site_url('wholesale/relapse'); ?>" class="button button--small button--<?php echo $this->webspace_details->slug; ?>">
									Continue... </a>
							</li> 
						</ul>
					</div>
	
				</div>
			</div>
		</div>
	
		<?php
		/*****
		 * Home Page Pop Up using site-min.js script
		 * Removing temporarily as it is not needed for now
		 * By adding an underscore at the id tag and setting display to none
		 */
		?>
		<div id="homepageTakeover_" class="clearfix" style="display:none;">
			<div class="v-emailsignup-homesignupform clearfix">
				<h3 class="wl-h1">Sign up <span>for</span> <?php echo $this->config->item('site_name'); ?> emails</h3>
				<h2>Be the first to know about new arrivals, events, and offers.</h2>
		
				<div class="form-wrap">
					<form id="vEmailSignUp-homeSignUpForm-form-1" name="vEmailSignUp_homeSignUpForm_form_1" action="#" method="post" class="dialog" data-dialog='{"dialogClass": "wl-dialog--bordered", "minHeight": 180}'
					onSubmit="return false; ga.send('event', 'newsletter signups', 'submit', 'homepopup');">
						<input type="hidden" name="fuseaction" value="emailSignup.processHomeSignup" />
						<input type="hidden" name="isFullForm" value="1" />
				
						<div class="pairinglist clearfix" >
							
							<ul class="pairings clearfix">
								<li class="pairing-email pairing-required pairing-vertical pairing clearfix">
									<label class="primary" for="email">
										<span class="required">*</span>
										<span class="pairing-label">Email Address:</span>
										
									</label>
									<div class="pairing-content">
										
										<div class="pairing-controls"> 
												<input type="email" class="input-text email" name="emailAddress" required="required" placeholder="Enter Email" />
														</div>
									</div>
								</li>
								<li class="pairing-zip pairing-required pairing-vertical pairing clearfix">
									<label class="primary" for="zip">
										<span class="required">*</span>
										<span class="pairing-label">Zipcode:</span>
										
									</label>
									<div class="pairing-content">
										
										<div class="pairing-controls"> 
												<input type="text" class="input-text" id="zip" name="zip" placeholder="Enter Zip Code" />
														</div>
									</div>
								</li>
							</ul>
						</div>
		
						<div class="actionlist clearfix">
							<ul class="actions clearfix">
								<li class="action-primary action clearfix"> 
									<input type="submit" class="button button--large" value="Submit" />
								</li> 
							</ul>
						</div>
		
						<p class="legal-copy">By signing up, you agree to receive <?php echo $this->config->item('site_name'); ?> offers, promotions and other commerical messages. You may unsubscribe at any time.</p>
						
					</form>
				</div>
			</div>
		</div>
		
		<div class="overlay" style="display: none;"></div>

