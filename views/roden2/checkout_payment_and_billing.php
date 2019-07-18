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
																	<span class="given-name">Edward</span>
																	<span class="family-name">Lumba</span>
																</div>
																<span class="street-address">Street Street</span>
																<div>
																	<span class="locality">City City</span>
																	<span class="region">MM</span>
																	<span class="postal-code">1750</span> 
																</div>
																<div class="country-name">PH</div>
															</div>
															<div class="tel">
																<strong>Telephone:</strong>
																<span class="value">+639175555555</span>
															</div>
														</div>
		
														<div class="actionlist clearfix">
															<ul class="actions clearfix">
																<li class="action-primary action clearfix"> 
																	<a href="#addresses" class="button button--small">
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
    
														<form id="vCheckout-paymentSingleForm-form-1" name="vCheckout_paymentSingleForm_form_1" action="https://www.bhldn.com/index.cfm" method="post" class="checkout-form" novalidate="novalidate">
														
															<input name="fuseaction" value="checkout.updatePaymentInformation" type="hidden">
        
															<div class="card togglefields">
																<div class="card-new togglefields-group clearfix">
                    
																	<input name="paymentType" value="new" type="hidden">
                
																	<input id="vCheckout-paymentSingleForm-accountTenderIDNew-1" name="accountTenderID" value="" type="hidden">
																	<input id="vCheckout-paymentSingleForm-creditCardType-1" name="creditCardType" value="" type="hidden">
																	
																	<div class="row clearfix">

																		<table>
																			<tbody>
																				<tr class="fv fv-horizontal fv-cardtype">
																					<th>
																						<span class="fv-label wl-h4 uppercase">
																							Card Type&nbsp;
																						</span>
																					</th>
																					<td>
																						<p class="cardtype-display">(Auto)</p>
																					</td>
																				</tr>
																			</tbody>
																		</table>
                    
																		<div class="pairinglist clearfix">
																		
																			<ul class="pairings clearfix">
		
																				<li class="pairing-cardnumber pairing-required pairing-horizontal pairing clearfix">
																					<label class="primary" for="vCheckout-paymentSingleForm-creditCardNumber-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Card No.</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" id="vCheckout-paymentSingleForm-creditCardNumber-1" required="required" data-validation="{creditcardnumber:true}" name="creditCardNumber" value="" maxlength="20" type="text">
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
																								<option value="16">
																									2016
																								</option>
																							
																								<option value="17">
																									2017
																								</option>
																							
																								<option value="18">
																									2018
																								</option>
																							
																								<option value="19">
																									2019
																								</option>
																							
																								<option value="20">
																									2020
																								</option>
																							
																								<option value="21">
																									2021
																								</option>
																							
																								<option value="22">
																									2022
																								</option>
																							
																								<option value="23">
																									2023
																								</option>
																							
																								<option value="24">
																									2024
																								</option>
																							
																								<option value="25">
																									2025
																								</option>
																							
																								<option value="26">
																									2026
																								</option>
																							
																								<option value="27">
																									2027
																								</option>
																							
																								<option value="28">
																									2028
																								</option>
																							
																								<option value="29">
																									2029
																								</option>
																							
																								<option value="30">
																									2030
																								</option>
																							
																								<option value="31">
																									2031
																								</option>
																							</select>
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-seccode pairing-required pairing-horizontal pairing clearfix">
																					<label class="primary" for="vCheckout-paymentSingleForm-creditCardSecurityCode-1">
																						<span class="required">*</span>
																						<span class="pairing-label">CID code</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" id="vCheckout-paymentSingleForm-creditCardSecurityCode-1" name="creditCardSecurityCode_new" value="" maxlength="4" size="4" required="required" type="text">
																							<a href="/cid-code" class="dialog" data-dialog="{dialogClass:'dialog-cid'}">What is a CID code?</a>
																						</div>
																					</div>
																				</li>
		
																			</ul>
																			
																		</div>
																		
																	</div>
                
																	<div class="pairinglist clearfix">
																		<ul class="pairings clearfix">
																			<li class="pairing-savethiscard pairing-horizontal pairing clearfix">
																				<label class="primary" for="vCheckout-paymentSingleForm-saveTender-1">
																					<span class="pairing-label">Save this card for future purchases</span>
																				</label>
																				<div class="pairing-content">
																					<div class="pairing-controls"> 
																						<input class="input-checkbox" id="vCheckout-paymentSingleForm-saveTender-1" name="saveTender" value="1" checked="checked" type="checkbox">
																					</div>
																				</div>
																			</li>
																		</ul>
																	</div>
		
																</div>
																
																<div class="card-new-address clearfix">
																
																	<h4 class="uppercase">Billing Address</h4>
                
																	<div class="v-checkout-checkoutaddresssingleform togglefields clearfix">
																		<div class="addresses-saved togglefields-group clearfix">
		
																			<div class="radio-adr-wrap clearfix">
																				<input class="input-radio togglefields-trigger" id="radio-adr-saved" name="useExistingAddress" value="true" checked="checked" type="radio">
																				<label for="radio-adr-saved">Use Saved Address</label>
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
																									<option value="7c4c2021-85ed-40e2-b3a8-145f41eefeb0" selected="selected">Edward Lumba, Street Street, City City, MM 1750</option>
																								</select>
																							</div>
																						</div>
																					</li>
																				</ul>
																			</div>
		
																			<div class="actionlist clearfix">
																				<ul class="actions clearfix">
																					<li class="action-edit action-secondary action clearfix"> 
																						<a class="button button--small edit-account-item" data-account-item-select="'div.checkout-step-current select[name=existingAddress]'" href="https://www.bhldn.com/index.cfm/fuseaction/checkout.editShippingAddress/ID/7c4c2021-85ed-40e2-b3a8-145f41eefeb0/" title="Edit Shipping Address ''">Edit</a>
																					</li>
																					<li class="action-delete action-secondary action clearfix"> 
																						<a href="https://www.bhldn.com/index.cfm/fuseaction/accountAddress.delete/ID/7c4c2021-85ed-40e2-b3a8-145f41eefeb0" title="Delete" class="button button--small delete-account-item" data-account-item-select="'select[name=shipmentOption]'">Delete</a>
																					</li> 
																				</ul>
																			</div>
		
																		</div>
																		<div class="addresses-new togglefields-group clearfix togglefields-group-disabled">
		
																			<div class="radio-adr-wrap clearfix">
																				<input class="input-radio togglefields-trigger" id="radio-adr-new" name="useExistingAddress" value="false" type="radio">
																				<label for="radio-adr-new">Enter New Address</label>
																			</div>
		
																			<input disabled="disabled" name="ID" value="" type="hidden">

																			<input disabled="disabled" name="addressIsPublic" value="1" type="hidden">
																			<input disabled="disabled" name="accountAddressTitleID" value="" type="hidden">
																			<input disabled="disabled" name="middleName" value="" type="hidden">
																			<input disabled="disabled" name="eveningPhone" value="" type="hidden">
																			<input disabled="disabled" name="descriptiveName" value="" type="hidden">

																			<div class="v-accountaddress-fields clearfix">
																				<div class="pairinglist clearfix">
																					
																					<ul class="pairings clearfix">
				
																						<li class="pairing-email pairing-required pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-email-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Email Address</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" required="required" maxlength="70" id="vAccountAddress-fields-email-1" name="email" value="<?php echo set_value('email'); ?>" size="32" type="email">
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-firstname pairing-required pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-firstname-1">
																								<span class="required">*</span>
																								<span class="pairing-label">First Name</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" maxlength="50" required="required" id="vAccountAddress-fields-firstname-1" name="firstname" value="<?php echo set_value('firstname'); ?>" type="text">
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-lastname pairing-required pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-lastname-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Last Name</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" maxlength="60" required="required" id="vAccountAddress-fields-lastname-1" name="lastname" value="<?php echo set_value('lastname'); ?>" type="text">
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-phone pairing-required pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-phone-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Telephone</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" required="required" data-validation="{phone:true}" maxlength="30" id="vAccountAddress-fields-phone-1" name="phone" value="<?php echo set_value('phone'); ?>" size="15" type="text">
																								</div>
																							</div>
																						</li>
																			
																						<li class="pairing-country pairing-required pairing-vertical pairing clearfix">
																							<br /><br />
																							<h2 class="section-heading">Ship To Address</h2>
																							<label class="primary" for="vAccountAddress-fields-country-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Country</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<select name="country" id="vAccountAddress-fields-country-1" data-validation="{required:true}" onchange="check_usa(this);">
																										<option value=""> - select country - </option>
																										<?php
																										$get_country = $this->query_page->get_country();
																										if ($get_country->num_rows() > 0)
																										{
																											foreach ($get_country->result() as $country)
																											{
																												$sel_country = $this->session->userdata('shipping_country') == $country->countries_name ? 'selected="selected"' : '';
																												?>
																												<option value="<?php echo $country->countries_name; ?>" <?php echo $sel_country; ?>><?php echo $country->countries_name; ?></option>
																												<?php
																											}
																										}
																										?>
																									</select>
																									<script type="text/javascript">
																										function check_usa(id)
																										{
																											var x = id.selectedIndex;
																											var y = id.options;
																											var txt = y[x].value;
																											if (txt == 'United States')
																											{
																												$( ".pairing-shipping-options" ).show();
																												$( ".dhl_notice" ).hide();
																												$( ".input_states" ).hide();
																												$( ".dd_usa_states" ).show();
																												$( "#input_states_field" ).val( "" );
																											}
																											else
																											{
																												$( ".pairing-shipping-options" ).hide();
																												$( ".dhl_notice" ).show();
																												$( ".input_states" ).show();
																												$( ".dd_usa_states" ).hide();
																												$( "#dd_usa_states_options" ).val( "" );
																												$( ".usa_ship_options" ).attr( "checked", false );
																											}
																										}
																									</script>
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-address1 pairing-required pairing-vertical pairing clearfix">
																							<br />
																							<label class="primary" for="vAccountAddress-fields-address1-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Address 1</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" maxlength="60" required="required" id="vAccountAddress-fields-address1-1" name="address1" value="<?php echo set_value('address1'); ?>" type="text">
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-address2 optional pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-address2-1">
																								<span class="pairing-label">Address 2</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" maxlength="60" id="vAccountAddress-fields-address2-1" name="address2" value="<?php echo set_value('address2'); ?>" type="text">
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-city pairing-required pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-city-1">
																								<span class="required">*</span>
																								<span class="pairing-label">City</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" required="required" maxlength="20" id="vAccountAddress-fields-city-1" name="city" value="<?php echo set_value('city'); ?>" type="text">
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-states pairing-required pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-us-states-1">
																								<span class="required">*</span>
																								<span class="pairing-label input_states">Non-US State / Province</span>
																								<span class="pairing-label dd_usa_states">State</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls input_states"> 
																									<input id="vAccountAddress-fields-non-us-states-1 input_states_field" name="non-us-states" value="" maxlength="30" class="input-text" type="text">
																								</div>
																								<div class="pairing-controls dd_usa_states"> 
																									<select name="us-states" id="vAccountAddress-fields-us-states-1 dd_usa_states_options">
																										<option value=""> - select state - </option>
																										<?php
																										$get_states = $this->query_page->get_states();
																										if ($get_states->num_rows() > 0)
																										{
																											foreach ($get_states->result() as $state)
																											{
																												?>
																												<option value="<?php echo $state->state_name; ?>"><?php echo $state->state_name; ?></option>
																												<?php
																											}
																										}
																										?>
																									</select>
																								</div>
																							</div>
																						</li>
				
																						<li class="pairing-zip pairing-required pairing-vertical pairing clearfix">
																							<label class="primary" for="vAccountAddress-fields-zip-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Zip/Postal Code</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																									<input class="input-text" required="required" id="vAccountAddress-fields-zip-1" name="zip" value="<?php echo set_value('zip'); ?>" size="5" maxlength="20" type="text">
																								</div>
																							</div>
																						</li>

																						<label class="no-uppercase  template-row__label  template-row__label--padded" for="vAccountAddress-fields-sendEmailUpdates-1">
																							<input class="input-checkbox" id="vAccountAddress-fields-sendEmailUpdates-1" name="sendEmailUpdates" value="1" checked="checked" type="checkbox">
																							Send me email updates
																						</label>

																						<?php
																						// check for customer order in the cart
																						foreach ($this->cart->contents() as $items):
																							if ($items['options']['custom_order'] == 1) $custom_order = TRUE;
																							else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
																							else $custom_order = FALSE;
																						endforeach;
																						
																						if ($custom_order)
																						echo '
																							<br />
																							<h2 class="section-heading">
																								An item in your cart is <strong>Custom Order.</strong><br />Shipment will be approximately <span style="color:red;">12 weeks</span> from order.
																							</h2>
																						';
																						?>
																						
																						<br class="dhl_notice"/>
																						<h2 class="section-heading dhl_notice">
																							We only use DHL to ship for countries other than USA. You will be contacted by customer service for respective shipping fees.
																						</h2>
																						
																						<li class="pairing-shipping-options pairing-required pairing-vertical pairing clearfix hidden">
																							<br />
																							<label class="primary" for="vAccountAddress-fields-zip-1">
																								<span class="required">*</span>
																								<span class="pairing-label">Select Shipping Options (US Only)</span>
																							</label>
																							<div class="pairing-content">
																								<div class="pairing-controls"> 
																								
																									<?php
																									$get_shipmethod = $this->query_product->get_shipping_method();
																									
																									if ($get_shipmethod->num_rows() > 0):
																									?>
																									
																										<?php
																										$y = 0;
																										foreach ($get_shipmethod->result() as $shipmethod):
																										
																											if ($custom_order && $shipmethod->ship_id != 1) $show_me = 'style="display:none;"';
																											else $show_me = '';
																										?>

																									<input class="input-radio usa_ship_options usa_ship_options" id="vAccountAddress-fields-shipmethod-1" name="shipmethod" value="1" type="radio" <?php echo $show_me; ?>>
																									<span <?php echo $show_me; ?>><?php echo $shipmethod->ship_id.' - '.$shipmethod->courier.' ('.$shipmethod->fee; ?>)</span>
																									<br />
																									
																										<?php
																										$y++;
																										endforeach;
																										?>
																										
																									<?php endif; ?>

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
        
															<div class="actionlist actionlist-continue clearfix">
																<ul class="actions clearfix">
																	<li class="action-primary action clearfix"> 
																		<button type="submit" class="button">Continue Checkout</button>
																	</li> 
																</ul>
															</div>
		
														</form>
													</div>
												</div>
	
											</div>
											
										</div>
									</div>
								</div>
							</div>

						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div>
