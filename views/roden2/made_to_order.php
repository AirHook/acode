	<div class="wl-grid clearfix">
	
		<?php
		/**********
		 * Left Side Sign In
		 */
		?>
		<div class="col col-1of2">
			<section class="equal-height-section">

				<div class="v-login-form section">
					<div class="header-subtext header-subtext--with-border">
						<h4><?php echo strtoupper($page_title); ?></h4>
					</div>
					<div class="ct ct-body clearfix">
					
						<?php if ($this->webspace_details->slug === 'junnieleigh'): ?>
							
							<?php echo $page_text; ?>
							
						<?php else: ?>
						
						<p style="font-size:1.0em;">
							Bespoke gorgeousness and made-to-order loveliness is what's on offer from Basix Bridal.
							<br /><br />
							Silk, satin, tulle, embellished with pearls, Swarovski crystals, silk ribbon embroidery, and antique lace are but a small selection of materials open to you.
							<br /><br />
							You can choose from an extensive archive of current and previous collections to create your dress from parts you find attractive, or can elect to have a bespoke design created especially for you based on a photo, drawing or insporation.
							<br /><br />
							A minimum lead time of 4-5 months is preferred, and from first informal set of inteviews and data gathering, through the toile and silk fittings, to final touches, you are encouraged to spend as much time as you need to ensure the final result is everything you imagined.
							<br /><br />
							Prices start at around $1500 for made-to-order, and $2500 for bespoke.
							<br /><br />
							Please feel free to complete the form for a no obligation consultation to discuss your requirements.
							<br /><br />
							Be sure to add the two email addresses to your contact list or our response may end up languishing in your junk folder.
							<br /><br />
						</p>
						
						<?php endif; ?>
						
					</div>
				</div>

			</section>
		</div>

		<?php
		/**********
		 * Right Side Register
		 */
		?>
		<div class="col col-1of2">
			<section class="equal-height-section">

				<div class="v-account-form clearfix">
					<header class="header-subtext header-subtext--with-border center">
						<h4>&nbsp;</h4>
					</header>
					
					<div class="ct ct-body clearfix">
						<p>

							<?php if ($this->session->flashdata('flashRegMsg')): ?>
							<div class="center" style="background:pink;padding:20px;">
								<?php echo $this->session->flashdata('flashRegMsg'); ?>
							</div>
							<?php endif; ?>
							
							<?php if ($this->session->flashdata('made_to_order_send_success')): ?>
							<div class="center" style="background:lightgreen;padding:20px;margin-bottom:20px;">
								Thank you!<br />We will get in touch with you as soon as we can!
							</div>
							<?php endif; ?>
							
							<!--bof form=============================================================================-->
							<?php echo form_open(); ?>
							
							<!--<form name="vAccount_form_form_1" action="" method="post" class="start-page__form">
								<input type="hidden" name="fuseaction" value="account.create" />-->

								<div class="v-account-fields">
									<div class="pairinglist clearfix" >
										<ul class="pairings clearfix">

											<li class="pairing-name pairinglist--centered pairing-required pairing-vertical pairing clearfix">
												<label class="primary" for="vAccount-fields-name-1">
													<span class="required">*</span>
													<span class="pairing-label">My Name Is...</span>
												</label>
												<div class="pairing-content">
													<div class="pairing-controls"> 
														<div class="field">
															<input type="text" required="required" class="input-text" id="vAccount-fields-name-1" name="name" value="<?php echo set_value('name'); ?>" />
															<?php echo form_error('name'); ?>
														</div>
													</div>
												</div>
											</li>

											<li class="pairing-email pairinglist--centered pairing-required pairing-vertical pairing clearfix">
												<label class="primary" for="vAccount-fields-email-1">
													<span class="required">*</span>
													<span class="pairing-label">My Email Is...</span>
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

										</ul>
									</div>
									<div class="pairinglist clearfix" >
										<ul class="pairings clearfix">

											<li class="pairing-email2 pairinglist--centered pairing-required pairing-vertical pairing clearfix">
												<label class="primary" for="vAccount-fields-email2-1">
													<span class="required">*</span>
													<span class="pairing-label">My Second Email Contact To CC Is...</span>
												</label>
												<div class="pairing-content">
													<div class="pairing-controls"> 
														<div class="field">
															<input type="email" required="required" class="input-text" id="vAccount-fields-email2-1" name="email2" value="<?php echo set_value('email2'); ?>" />
															<?php echo form_error('email2'); ?>
														</div>
													</div>
												</div>
											</li>
											
											<li class="pairing- pairinglist--centered pairing-required pairing-vertical pairing clearfix">
												<label class="primary" for="vAccount-fields-opt_item-1">
													<span class="required">*</span>
													<span class="pairing-label">Select Option</span>
												</label>
												<div class="pairing-content">
													<div class="pairing-controls"> 
														<div class="field">
															<select required="required" class="input-select" id="vAccount-fields-opt_item-1" name="opt_item" style="border:1px solid #999;">
																<option value="">- Select -</option>
																<option value="I&#39;m getting married&#33;">I'm getting married!</option>
																<option value="I need a knockout evening dress&#33;">I need a knockout evening dress!</option>
															</select>
														</div>
													</div>
												</div>
											</li>
											
										</ul>
									</div>
									<div class="pairinglist clearfix" >
										<ul class="pairings clearfix">

											<li class="pairing-comments pairinglist--centered pairing-required pairing-vertical pairing clearfix">
												<label class="primary" for="vAccount-fields-comments-1">
													<span class="pairing-label">Tell us more about what you are looking for and links to any inspiration, we will respond promptly.</span>
												</label>
												<div class="pairing-content">
													<div class="pairing-controls"> 
														<div class="field">
															<textarea name="comments" id="vAccount-fields-comments-1" style="width:100%;"></textarea>
														</div>
													</div>
												</div>
											</li>

											<li class="pairinglist--centered pairing-vertical pairing clearfix">
											</li>

										</ul>
									</div>
								</div>

							<p style="color:#ba6a5c;font-size:.8125rem;font-style: italic;letter-spacing:0;"><?php echo $this->webspace_details->name; ?> respects your privacy and does not share e-mail addresses with third parties.<br /><br /></p>
						
								<button type="submit" class="button button--large button--center button--<?php echo $this->webspace_details->slug; ?>" id="vAccount-form-submit_noPreload-1" name="submit_made_to_order">Submit</button>

							<?php echo form_close(); ?>
							<!--eof form=============================================================================-->
							
						</p>
					</div>
					<p style="color:#ba6a5c;font-size:0.8125rem;font-style:italic;letter-spacing:0;margin-left:10px;">*<span class="screenreaderonly"> indicates </span>Required</p>
					
				</div>

			</section>
		</div>

	</div>