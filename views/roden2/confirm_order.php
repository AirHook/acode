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
									
										<div class="checkout-progress">
											<p>
												<strong>Step 2 of 6.</strong>
												Please select a shipping address by choosing a saved address or adding a new shipping address.
											</p>
										</div>
				
										<div class="system-message general-message hidden">
											<div class="message">
												To protect your security, your guest account has expired due to inactivity.  Your items are still in your Cart, so please continue to checkout.
											</div>
										</div>
		
										<?php if ($this->session->flashdata('flashMsg')): ?>
										
										<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
											<?php echo $this->session->flashdata('flashMsg'); ?>
										</div>
										
										<?php endif; ?>
										
										<?php
										if (validation_errors())
										{
											echo '<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">';
											
											echo form_error('payment_card_type') ? 'Please select card type.<br />' : '';
											echo form_error('payment_card_num') ? 'An error occurred with your card number.<br />' : '';
											echo form_error('payment_exp_date') ? 'Invalid expiration dates.<br />' : '';
											echo form_error('payment_card_code') ? 'Invalide card security code.<br />' : '';
											
											echo form_error('agree_to_return_policy') ? 'Please confirm you agree to return policy.<br />' : '';
											
											echo form_error('shipping_address1') ? 'Address 1 is required.<br />' : '';
											echo form_error('shipping_city') ? 'City is required.<br />' : '';
											echo form_error('shipping_state') ? 'State is required.<br />' : '';
											echo form_error('shipping_country') ? 'Country is required.<br />' : '';
											echo form_error('shipping_zipcode') ? 'Postal Zip Code is required.<br />' : '';
											
											echo '</div>';
										}
										?>

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
														Shipping Address
													</a>
												</h2>
												<div style="display: block;" class="summary">
													<div class="v-checkout-xhrsummary clearfix">
					
														<div class="contact contact-vertical vcard">
															<div class="adr">
																<div class="fn n">
																	<span class="given-name"><?php echo $cur_user_info->fname; ?></span>
																	<span class="family-name"><?php echo $cur_user_info->lname; ?></span>
																</div>
																<span class="street-address"><?php echo $cur_user_info->address1; ?></span>
																<span class="street-address"><?php echo $cur_user_info->address2; ?></span>
																<div>
																	<span class="locality"><?php echo $cur_user_info->city; ?></span>
																	<span class="region"><?php echo $cur_user_info->country == 'United States' ? $cur_user_info->state : $cur_user_info->state; ?></span>
																	<span class="postal-code"><?php echo $cur_user_info->zipcode; ?></span> 
																</div>
																<div class="country-name"><?php echo $cur_user_info->country; ?></div>
															</div>
															<div class="tel">
																<strong>Telephone:</strong>
																<span class="value"><?php echo $cur_user_info->telephone; ?></span>
															</div>
														</div>
		
														<div class="actionlist clearfix">
															<ul class="actions clearfix">
																<li class="action-primary action clearfix"> 
																	<a href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/edit_customer_info'); ?>" class="button button--small button--<?php echo $this->webspace_details->slug; ?>">
																		Edit
																	</a>
																</li> 
															</ul>
														</div>
														
													</div>
												</div>	
												
											</div>
											
											<div class="checkout-step section clearfix checkout-step-current" data-step="'payment'">
					
												<h2 class="section-heading">
													<a class="checkout-heading-link" href="#payment">
														Payment &amp; Billing Address
													</a>
												</h2>
												<div style="display: none;" class="summary"></div>
												
												<div class="content" style="display: block;">
													<div class="v-checkout-paymentsingleform clearfix">
    
														<!-- BEGIN FORM-->
														<!-- FORM =======================================================================-->

														<!--
														<form id="vCheckout-paymentSingleForm-form-1" name="vCheckout_paymentSingleForm_form_1" action="https://www.bhldn.com/index.cfm" method="post" class="checkout-form" novalidate="novalidate">
														-->
														<?php echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/confirm_order', array('class'=>'checkout-form')); ?>
														
															<!--
															<input name="fuseaction" value="checkout.updatePaymentInformation" type="hidden">
															-->
        
															<div class="card togglefields">
																<div class="card-new togglefields-group clearfix">
																
																	<?php
																	/**********
																	 * The Shipping Address
																	 */
																	?>
																	<input type="hidden" value="<?php echo (isset($cur_user_info->address1)) ? $cur_user_info->address1 : ''; ?>" name="shipping_address1" />
																	<input type="hidden" value="<?php echo (isset($cur_user_info->address2)) ? $cur_user_info->address2 : ''; ?>" name="shipping_address2" />
																	<input type="hidden" value="<?php echo (isset($cur_user_info->city)) ? $cur_user_info->city : ''; ?>" name="shipping_city" />
																	<input type="hidden" value="<?php echo (isset($cur_user_info->country)) ? $cur_user_info->country : ''; ?>" name="shipping_country" />
																	<input type="hidden" value="<?php echo ($this->session->userdata('user_cat') == 'wholesale') ? (isset($cur_user_info->state) ? $cur_user_info->state : '') : (isset($cur_user_info->state) ? $cur_user_info->state : ''); ?>" name="shipping_state" />
																	<input type="hidden" value="<?php echo ($this->session->userdata('user_cat') == 'wholesale') ? (isset($cur_user_info->zipcode) ? $cur_user_info->zipcode : '') : (isset($cur_user_info->zipcode) ? $cur_user_info->zipcode : ''); ?>" name="shipping_zipcode" />
                    
																	<!--
																	<input name="paymentType" value="new" type="hidden">
                
																	<input id="vCheckout-paymentSingleForm-accountTenderIDNew-1" name="accountTenderID" value="" type="hidden">
																	<input id="vCheckout-paymentSingleForm-creditCardType-1" name="creditCardType" value="" type="hidden">
																	-->
																	
																	<?php
																	/**********
																	 * Credit Card Info
																	 */
																	?>
																	<div class="row clearfix">

																		<table>
																			<tbody>
																				<tr class="fv fv-horizontal fv-cardtype">
																					<th>
																						<span class="fv-label wl-h4 uppercase hidden-on-mobile">
																							Card Type&nbsp;
																						</span>
																						<span style="font-weight:normal;" class="hidden-on-desktop">
																							Card Type&nbsp;
																						</span>
																					</th>
																					<td>
																						<select name="payment_card_type">
																							<option value=""> - select card type - </option>
																							<option value="MC">Master Card</option>
																							<option value="VISA">Visa Card</option>
																							<option value="DISCOVER">Discovery Card</option>
																							<option value="AMEX">American Express Card</option>
																						</select>
																					</td>
																				</tr>
																			</tbody>
																		</table>
                    
																		<div class="pairinglist clearfix">
																		
																			<ul class="pairings clearfix">
		
																				<li class="pairing-payment_card_num pairing-required pairing-horizontal pairing clearfix">
																					<label class="primary" for="vCheckout-paymentSingleForm-payment_card_num-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Card No.</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" id="vCheckout-paymentSingleForm-payment_card_num-1" required="required" name="payment_card_num" value="" maxlength="20" type="text">
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-exp pairing-required pairing-horizontal pairing clearfix">
																					<label class="primary" for="vCheckout-paymentSingleForm-creditCardExpirationMonth-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Exp. Date</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<select id="vCheckout-paymentSingleForm-creditCardExpirationMonth-1" name="creditCardExpirationMonth" required="required">
																								<option value="">Month</option>
																								<option value="01">
																									01 (Jan)
																								</option>
																							
																								<option value="02">
																									02 (Feb)
																								</option>
																							
																								<option value="03">
																									03 (Mar)
																								</option>
																							
																								<option value="04">
																									04 (Apr)
																								</option>
																							
																								<option value="05">
																									05 (May)
																								</option>
																							
																								<option value="06">
																									06 (Jun)
																								</option>
																							
																								<option value="07">
																									07 (Jul)
																								</option>
																							
																								<option value="08">
																									08 (Aug)
																								</option>
																							
																								<option value="09">
																									09 (Sep)
																								</option>
																							
																								<option value="10">
																									10 (Oct)
																								</option>
																							
																								<option value="11">
																									11 (Nov)
																								</option>
																							
																								<option value="12">
																									12 (Dec)
																								</option>
																							</select>
																							<select id="vCheckout-paymentSingleForm-creditCardExpirationYear-1" name="creditCardExpirationYear" required="required">
																								<option value="">Year</option>
																								
																								<?php
																								$year = date('Y', time());
																								$max_year = $year + 10;
																								for ($cur = $year; $cur < ($year + 10); $cur+=1)
																								{
																								?>
																								<option value="<?php echo substr($cur, -2); ?>">
																									<?php echo $cur; ?>
																								</option>
																								<?php } ?>
																								
																							</select>
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-payment_card_code pairing-required pairing-horizontal pairing clearfix">
																					<label class="primary" for="vCheckout-paymentSingleForm-payment_card_code-1">
																						<span class="required">*</span>
																						<span class="pairing-label">CID code</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" id="vCheckout-paymentSingleForm-payment_card_code-1" name="payment_card_code" value="" maxlength="4" size="4" required="required" type="text">
																						</div>
																					</div>
																				</li>
		
																			</ul>
																			
																		</div>
																		
																	</div>
																	<!-- END Credit Card Info -->
                
																</div>
																
																<div class="card-new-address clearfix">
																
																	<h4 class="uppercase">Billing Address</h4>
                
																	<div class="v-checkout-checkoutaddresssingleform togglefields clearfix">
																		<div class="addresses-saved togglefields-group clearfix">
		
																			<div class="radio-adr-wrap clearfix">
																				<input class="input-radio togglefields-trigger" id="radio-adr-saved" name="useExistingAddress" value="1" checked="checked" type="radio" onclick="$('.new-address-form').hide();">
																				<label for="radio-adr-saved">Same as Shipping Address</label>
																			</div>
			
																			<div class="pairinglist clearfix">
																				<ul class="pairings clearfix">
																					<li class="pairing-savedadr pairing-horizontal pairing clearfix">
																						<label class="primary" for="vCheckout-checkoutAddressSingleForm-savedAddresses-1">
																							<span class="pairing-label">Saved Addresses</span>
																						</label>
																						<div class="pairing-content">
																							<div class="pairing-controls"> 
																								<select id="vCheckout-checkoutAddressSingleForm-savedAddresses-1" class="fixed-width-select" name="existingAddress">
																									<option value="1" selected="selected">
																										<?php echo $cur_user_info->fname.' '.$cur_user_info->lname.', '.$cur_user_info->address1.' '.$cur_user_info->address2.', '.$cur_user_info->city.', '.($cur_user_info->country == 'United States' ? $cur_user_info->state : $cur_user_info->state).' '.$cur_user_info->zipcode; ?>
																									</option>
																								</select>
																								<input type="hidden" name="payment_first_name" value="<?php echo $cur_user_info->fname; ?>" />
																								<input type="hidden" name="payment_last_name" value="<?php echo $cur_user_info->lname; ?>" />
																								<input type="hidden" name="payment_address_1" value="<?php echo $cur_user_info->address1; ?>" />
																								<input type="hidden" name="payment_address_2" value="<?php echo $cur_user_info->address2; ?>" />
																								<input type="hidden" name="payment_city" value="<?php echo $cur_user_info->city; ?>" />
																								<input type="hidden" name="payment_state" value="<?php echo $cur_user_info->country == 'United States' ? $cur_user_info->state : $cur_user_info->state; ?>" />
																								<input type="hidden" name="payment_country" value="<?php echo $cur_user_info->country; ?>" />
																								<input type="hidden" name="payment_zip" value="<?php echo $cur_user_info->zipcode; ?>" />
																								<input type="hidden" name="payment_telephone" value="<?php echo $cur_user_info->telephone; ?>" />
																								<input type="hidden" name="email" value="<?php echo $cur_user_info->email; ?>" />
																							</div>
																						</div>
																					</li>
																				</ul>
																			</div>
		
																		</div>
																		
																		<div class="addresses-new togglefields-group clearfix togglefields-group-disabled">
		
																			<div class="radio-adr-wrap clearfix">
																				<input class="input-radio togglefields-trigger" id="radio-adr-new" name="useExistingAddress" value="0" type="radio" onclick="$('.new-address-form').show();$">
																				<label for="radio-adr-new">Enter New Address</label>
																			</div>
		
																			<div class="v-accountaddress-fields clearfix new-address-form hidden">
																			
																				<div class="pairinglist clearfix">
																					
																					<br />
																					
																					<ul class="pairings clearfix">
				
																						<li class="pairing-email pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-email-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Email Address</span>
																								
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" required="required" maxlength="70" id="vAccountAddress-fields-email-1" name="email" value="<?php echo (isset($cur_user_info->email)) ? $cur_user_info->email : ''; ?>" size="32" type="email">
																								</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_first_name pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_first_name-1">
																								<span class="required">*</span>
																								<span class="pairing-label">First Name</span>
																								
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" maxlength="50" required="required" id="vAccountAddress-fields-payment_first_name-1" name="payment_first_name" value="<?php echo (isset($cur_user_info->fname)) ? $cur_user_info->fname : ''; ?>" type="text">
																								</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_last_name pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_last_name-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Last Name</span>
																								
																							</label>
																							<div class="pairing-content">
																								
																								<div class="pairing-controls"> 
																							<input class="input-text" maxlength="60" required="required" id="vAccountAddress-fields-payment_last_name-1" name="payment_last_name" value="<?php echo (isset($cur_user_info->lname)) ? $cur_user_info->lname : ''; ?>" type="text">
																									</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_telephone pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_telephone-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Telephone</span>
																								
																							</label>
																							<div class="pairing-content">
																								
																								<div class="pairing-controls"> 
																								<input class="input-text" required="required" data-validation="{phone:true}" maxlength="30" id="vAccountAddress-fields-payment_telephone-1" name="payment_telephone" value="<?php echo (isset($cur_user_info->telephone)) ? $cur_user_info->telephone : ''; ?>" size="15" type="text">
																									</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_country pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_country-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Country</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<select name="payment_country" id="vAccountAddress-fields-payment_country-1" onchange="check_usa(this)">
																										<option value=""> - select country - </option>
																										
																										<?php foreach (list_countries() as $country) { ?>
																										
																										<option value="<?php echo $country->countries_name; ?>"<?php if (isset($cur_user_info->country) && $country->countries_name == $cur_user_info->country) echo ' selected="selected"'; ?>><?php echo $country->countries_name; ?></option>
																										
																										<?php } ?>
																										
																									</select>
																									<script type="text/javascript">
																										function check_usa(id)
																										{
																											var x = id.selectedIndex;
																											var y = id.options;
																											var txt = y[x].value;
																											if (txt == 'United States')
																											{
																												$( ".input_states" ).hide();
																												$( ".dd_usa_states" ).show();
																												$( "#input_states_field" ).val( "" );
																												$( ".non-us-cost-summary-item" ).hide();
																												$( ".us-cost-summary-item" ).show();
																											}
																											else
																											{
																												$( ".input_states" ).show();
																												$( ".dd_usa_states" ).hide();
																												$( "#dd_usa_states_options" ).val( "" );
																												$( ".non-us-cost-summary-item" ).show();
																												$( ".us-cost-summary-item" ).hide();
																											}
																										}
																									</script>
																								</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_address_1 pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_address_1-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Address</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" maxlength="60" required="required" id="vAccountAddress-fields-payment_address_1-1" name="payment_address_1" value="<?php echo (isset($cur_user_info->address1)) ? $cur_user_info->address1 : ''; ?>" type="text">
																								</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_address_2 optional pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_address_2-1">
																								<span class="pairing-label">Address 2</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" maxlength="60" id="vAccountAddress-fields-payment_address_2-1" name="payment_address_2" value="<?php echo (isset($cur_user_info->address2)) ? $cur_user_info->address2 : ''; ?>" type="text">
																								</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_city pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_city-1">
																								<span class="required">*</span>
																								<span class="pairing-label">City</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" required="required" maxlength="20" id="vAccountAddress-fields-payment_city-1" name="payment_city" value="<?php echo (isset($cur_user_info->city)) ? $cur_user_info->city : ''; ?>" type="text">
																								</div>
																							</div>
																						</li>
																						
																						<li style="display: block;" class="pairing-payment_state pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_state-1">
																								<span class="required">*</span>
																								<span class="pairing-label input_states" <?php echo $cur_user_info->country == 'United States' ? 'style="display:none;"' : ''; ?>>Non-US State / Province</span>
																								<span class="pairing-label dd_usa_states" <?php echo $cur_user_info->country == 'United States' ? '' : 'style="display:none;"'; ?>>State</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls input_states" <?php echo $cur_user_info->country == 'United States' ? 'style="display:none;"' : ''; ?>> 
																									<input id="vAccountAddress-fields-payment_state-1 input_states_field" name="payment_state[]" value="<?php echo (isset($cur_user_info->state)) ? $cur_user_info->state : ''; ?>" maxlength="30" class="input-text" type="text">
																								</div>
																								<div class="pairing-controls dd_usa_states" <?php echo $cur_user_info->country == 'United States' ? '' : 'style="display:none;"'; ?>> 
																									<select name="payment_state[]" id="vAccountAddress-fields-payment_state-1 dd_usa_states_options">
																										<option value=""> - select state - </option>
																										
																										<?php foreach (list_states() as $state) { ?>
																										<option value="<?php echo $state->state_name; ?>" <?php echo $state->state_name == $cur_user_info->state ? 'selected="selected"': ''; ?>><?php echo $state->state_name; ?></option>
																										<?php } ?>
																										
																									</select>
																								</div>
																							</div>
																						</li>
																						
																						<li class="pairing-payment_zip pairing-required pairing-horizontal pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-payment_zip-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Zip/Postal Code</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls">
																									<?php
																									if ($this->session->userdata('user_cat') == 'wholesale')
																									{
																										$p_zip_value = (isset($cur_user_info->zipcode)) ? $cur_user_info->zipcode : '';
																									}
																									else
																									{
																										$p_zip_value = (isset($cur_user_info->zipcode)) ? $cur_user_info->zipcode : '';
																									}
																									?>
																									<input class="input-text" required="required" id="vAccountAddress-fields-payment_zip-1" name="payment_zip" value="<?php echo $p_zip_value; ?>" size="5" maxlength="20" type="text">
																								</div>
																							</div>
																						</li>
																						
																					</ul>
																				
																				</div>
				
																			</div>

																		</div>
																	</div>
																</div>
															</div>
        
															<div class="card-new-address clearfix">
															
																<h4 class="uppercase">Return Policy</h4>
															
																<div class="v-checkout-checkoutaddresssingleform togglefields clearfix">
																	<div class="agree-policy togglefields-group clearfix">
	
																		<div class="radio-adr-wrap clearfix">
																			<input class="input-radio togglefields-trigger" id="radio-agree-policy" name="agree_to_return_policy" value="aye" required="required" type="radio">
																			<label for="radio-agree-policy">
																				 &nbsp; 
																				I agree to the 
																				<a href="javascript:void(0);" onclick="$('#this-dialog').show();" class="hidden-on-mobile">
																					Return Policy
																				</a>
																				<a href="javascript:void(0);" onclick="$('#this-dialog-mobile').show();" class="hidden-on-desktop">
																					Return Policy
																				</a>
																				<span class="required">*</span>
																			</label>
																		</div>
		
																	</div>
																</div>
															</div>
														
															<?php
															/**********
															 * Popup Dialog
															 * for Return Policy
															 */
															?>
															<!-- Desktop -->
															<div aria-labelledby="ui-dialog-title-1" id="this-dialog" role="dialog" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="display: none; z-index: 10001; outline: 0px none; height: auto; width: 700px; top: 30px; left: 50%; margin-left:-350px;">
																<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix bg-color-<?php echo $this->config->item('site_slug'); ?>">
																	<span id="ui-dialog-title-1" class="ui-dialog-title">&nbsp;</span>
																	<a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);" onclick="$('#this-dialog').hide();"><span class="ui-icon ui-icon-closethick"></span></a>
																</div>
																<div style="width: auto; min-height: 115px; height: auto;" class="ui-dialog-content ui-widget-content">
																	<div class="v-checkout-shippingaddresstemplate clearfix">
																		
																		<?php //$this->load->view($this->config->slash_item('template').'return_policy'); ?>
																		<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy'); ?>
																		
																	</div>
																</div>
															</div>
														
															<!-- Mobile -->
															<div aria-labelledby="ui-dialog-title-1" id="this-dialog-mobile" role="dialog" tabindex="-1" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable" style="display: none; z-index: 10001; outline: 0px none; height: auto; width: 250px; top: 500px; left: 50%; margin-left:-125px;">
																<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix bg-color-<?php echo $this->config->item('site_slug'); ?>" style="height:80px;">
																	<span id="ui-dialog-title-1" class="ui-dialog-title">&nbsp;</span>
																	<a role="button" class="ui-dialog-titlebar-close ui-corner-all" href="javascript:void(0);" onclick="$('#this-dialog-mobile').hide();$('div#policy-content').hide();$('#policy-toggle-switch').show();"><span class="ui-icon ui-icon-closethick" style="color:black;"></span></a>
																</div>
																<div style="width: auto; min-height: 115px; height: auto;" class="ui-dialog-content ui-widget-content">
																	<div class="v-checkout-shippingaddresstemplate clearfix">
																		
																		<?php //$this->load->view($this->config->slash_item('template').'return_policy_mobile'); ?>
																		<?php $this->load->view($this->webspace_details->options['theme'].'/return_policy_mobile'); ?>
																		
																	</div>
																</div>
															</div>
														
															<div class="actionlist actionlist-continue clearfix">
																<ul class="actions clearfix">
																	<li class="action-primary action clearfix"> 
																		<button type="submit" class="button button--<?php echo $this->webspace_details->slug; ?>">Continue Checkout</button>
																	</li> 
																</ul>
															</div>
		
														</form>
														<!-- End FORM ===================================================================-->
														
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
									
										<?php if ($this->cart->contents()): ?>
									
										<div class="order-summary__header clearfix">
											<h6 class='section-heading'>Order Summary</h6>
										</div>
										
										<div class="section order-summary__detail clearfix">
										
											<table class="order-totals base">
												<tbody>
													<tr class="subtotal">
														<th>Subtotal</th>
														<td><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total()); ?></td>
													</tr>
													<tr class="shipping">
														<th>
															<span>Estimated Shipping</span>
														</th>
														<?php if ($ship_method) { ?>
														<td>
															<?php echo $this->cart->format_number($ship_method->fix_fee); ?>
														</td>
														<?php } else { ?>
														<td>-</td>
														<?php } ?>
													</tr>
													<tr class="tax">
														<th>Estimated Sales Tax (NY, USA Only)</th>
														<?php if ($cur_user_info->country == 'United States') { ?>
														<td class="us-cost-summary-item">
															<?php 
															if (isset($this->webspace_details->options['ny_sales_tax']))
															{
																$taxed = $this->cart->format_number($this->webspace_details->options['ny_sales_tax'] * $this->cart->total());
															}
															else $taxed = '-';
															echo $taxed; 
															?>
														</td>
														<?php } else { ?>
														<td class="non-us-cost-summary-item">-</td>
														<?php } ?>
													</tr>
													<tr class="total">
														<th>
															<span>Grand Total Cost</span>
														</th>
														<?php if ($cur_user_info->country == 'United States') { ?>
														<td class="us-cost-summary-item"><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + $taxed + @$ship_method->fix_fee); ?></td>
														<?php } else { ?>
														<td class="non-us-cost-summary-item"><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + @$ship_method->fix_fee); ?></td>
														<?php } ?>
													</tr>
												</tbody>
											</table>

										</div>
				
										<br /><br />
										
										<div class="header clearfix">
											<h6 class="section-heading">Items</h6>
										</div>
										
										<div class="section products clearfix">
										
											<ul class="cart-items">
											
												<?php 
												$i = 1; 
												foreach ($this->cart->contents() as $items): 
												
												// incorporate new image url system
												if (
													isset($items['options']['prod_image_url']) 
													&& ! empty($items['options']['prod_image_url'])
												)
												{
													$href_text = str_replace('_f2', '_f3', $items['options']['prod_image_url']);
												}
												else
												{
													$href_text = str_replace('_2', '_3', $items['options']['prod_image']);
												}
												?>
				
												<li class="product-line-item even product-line-item--shipping-charge clearfix">
												
													<?php
													/**********
													 * Item IMAGE
													 * linking to product details page
													 */
													?>
													<div class="product-line-item__image">
														<a href="<?php echo $items['options']['current_url']; ?>" title="<?php echo $items['options']['prod_no']; ?>">
															<img class="product-browse-s  img-block" src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" alt="<?php echo $items['options']['prod_no']; ?>" />
														</a>
													</div>

													<?php
													/**********
													 * Item INFO
													 */
													?>
													<div class="product-line-item__info">
								
														<?php
														/**********
														 * Shipping - in-stock or pre-order
														 */
														?>
														<div class="shipping" style="text-align:right;line-height:unset;font-size:0.6rem;"><!-- float right -->
															<span style=""><?php echo @$items['options']['custom_order'] == '1' ? '<span style="color:red;">Pre-order</span>' : 'In Stock'; ?></span>
															
															<?php if (@$items['options']['custom_order'] == '3'): ?>
															
															<br />
															<span style="color:red;">On Special Sale</span>
															
															<?php endif; ?>
															
														</div>
								
														<?php
														/**********
														 * Product Name / Product Description / grayed Prod No.
														 * linking to product details page
														 */
														?>
														<h3 class="product__name">
															<a href="<?php echo $items['options']['current_url']; ?>" title="<?php echo $items['options']['prod_no']; ?>" title="Havana Corset">
																<?php echo $items['options']['prod_no']; ?>
																<br />
																<span style="font-size:0.8em;">
																	<?php echo $items['name']; ?>
																</span>
															</a>
														</h3>
														<p class="product__id fsid" style="color:#999;">
															Product#: <?php echo $items['options']['prod_no']; ?>
														</p>

														<?php
														/**********
														 * Item Cart details
														 */
														?>
														<table class="product__options base">
															<tbody>
																<!-- item color -->
																<tr class="fv fv-horizontal">
																	<th>
																		<span class="fv-label">
																			Color&nbsp;
																		</span>
																	</th>
																	<td>
																		<?php echo $items['options']['color']; ?>
																	</td>
																</tr>
																<!-- item size -->
																<tr class="fv fv-horizontal">
																	<th>
																		<span class="fv-label">
																			Size&nbsp;
																		</span>
																	</th>
																	<td>
																		<?php echo $items['options']['size']; ?>
																	</td>
																</tr>
																<!-- item qty -->
																<tr class="fv fv-horizontal">
																	<th>
																		<span class="fv-label">
																			Quantity&nbsp;
																		</span>
																	</th>
																	<td>
																		<?php echo $items['qty']; ?>
																	</td>
																</tr>
																<!-- item unit price -->
																<tr class="fv fv-horizontal">
																	<th>
																		<span class="fv-label">
																			Unit Price&nbsp;
																		</span>
																	</th>
																	<td>
																		$ <?php echo $this->cart->format_number($items['price']); ?>
																	</td>
																</tr>
																<!-- item Subtotal -->
																<tr class="price">
																	<th>
																		Item Total
																	</th>
																	<td>
																		<div class="price">
																			<span itemprop="price" content="450.00">
																				$ <?php echo $this->cart->format_number($items['subtotal']); ?>
																			</span>
																		</div>
																		<meta itemprop="priceCurrency" content="USD" />
																	</td>
																</tr>
															</tbody>
														</table>
								
														<?php
														/**********
														 * Some notations
														 * Adding a wrapping div to hide it
														 
														<div class="hidden"><!-- warpping div to hide the section -->
														<div class="pairinglist clearfix" >
															<ul class="pairings clearfix">
															</ul>
														</div>
														<p class="product__shipping-charge italicize">This item has an additional shipping charge of &#36;15.00. We are unable to ship this item to P.O. Boxes.</p>
														</div>
														 */
														?>
								
													</div>

												</li>
												
												<?php 
												$i++;; 
												if (@$items['options']['custom_order'] == TRUE) $custom_order = TRUE;
												else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
												else $custom_order = FALSE;
												endforeach; 
												?>
												
											</ul>
											
										</div>
			
										<?php endif; ?>
										
									</div>
									
								</div>
							</div>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>
