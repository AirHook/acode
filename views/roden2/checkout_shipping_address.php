					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<div class="v-checkout-checkouttemplate checkout-container checkout-multipage" data-step="'user'">
								<div class="wl-grid clearfix">
								
									<?php
									/**********
									 * 3/4 column
									 */
									?>
									<div class="template-row col col-8of12">
									
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
										
											<div class="checkout-step section clearfix checkout-step-current" data-step="'addresses'">
											
												<h2 class="section-heading">
													<a class="checkout-heading-link" href="#addresses">
														Shipping Address
													</a>
												</h2>
												<div style="display: none;" class="summary"></div>
												
												<div class="content" style="display: block;">
													<div class="v-checkout-shippingaddressshipmentoptiontemplate clearfix">

														<!--
														<form name="vCheckout_shippingAddressShipmentOptionTemplate_form_1" id="vCheckout-shippingAddressShipmentOptionTemplate-form-1" action="<?php echo site_url(); ?>" method="post" class="checkout-form" novalidate="novalidate">
														-->
														
														<?php echo form_open('register/process_customer_info'); ?>
														<?php echo $this->session->flashdata('flashRegMsg'); ?>
			
															<input type="hidden" name="control" value="cart" />
															
															<input name="fuseaction" value="checkout.insertShippingAddress" type="hidden">

															<div class="v-checkout-checkoutaddresssingleform togglefields clearfix">
																<div class="addresses-new togglefields-group clearfix">
																	
																	<input name="ID" value="" type="hidden">
																	<input name="addressIsPublic" value="1" type="hidden">
																	<input name="accountAddressTitleID" value="" type="hidden">
																	<input name="middleName" value="" type="hidden">
																	<input name="eveningPhone" value="" type="hidden">
																	<input name="descriptiveName" value="" type="hidden">

																	<div class="v-accountaddress-fields clearfix">
																		<div class="pairinglist clearfix">
																			
																			<ul class="pairings clearfix">
		
																				<li class="pairing-firstname pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-firstName-1">
																						<span class="required">*</span>
																						<span class="pairing-label">First Name</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" maxlength="50" required="required" id="vAccountAddress-fields-firstName-1" name="firstName" value="" type="text">
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-lastname pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-lastName-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Last Name</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" maxlength="60" required="required" id="vAccountAddress-fields-lastName-1" name="lastName" value="" type="text">
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-companyname optional pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-companyName-1">
																						<span class="pairing-label">Company Name</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" maxlength="50" id="vAccountAddress-fields-companyName-1" name="companyName" value="" type="text">
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-address1 pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-address1-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Address</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" maxlength="60" required="required" id="vAccountAddress-fields-address1-1" name="address1" value="" type="text">
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-address2 optional pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-address2-1">
																						<span class="pairing-label">Address 2</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" maxlength="60" id="vAccountAddress-fields-address2-1" name="address2" value="" type="text">
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-country pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-country-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Country</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<select name="country" id="vAccountAddress-fields-country-1" data-validation="{required:true}">
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
																							<input class="input-text" required="required" id="vAccountAddress-fields-zip-1" name="zip" value="" size="5" maxlength="20" type="text">
																						</div>
																					</div>
																				</li>

																				<!-- hidden -->
																				<label class="no-uppercase  template-row__label  template-row__label--padded-alt hidden" for="vAccountAddress-fields-addressIsPoBox-1">
																					<input class="input-checkbox" id="vAccountAddress-fields-addressIsPoBox-1" name="addressIsPoBox" value="1" type="checkbox">
																					Please check here if this address is a P.O. Box, an APO, or an FPO
																				</label>
		
																				<li class="pairing-city pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-city-1">
																						<span class="required">*</span>
																						<span class="pairing-label">City</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" required="required" maxlength="20" id="vAccountAddress-fields-city-1" name="city" value="" type="text">
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-state pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-state-1">
																						<span class="required">*</span>
																						<span class="pairing-label">State</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<select name="state" id="vAccountAddress-fields-state-1">
																								<option value=""> - select state - </option>
																								<?php
																								$get_states = $this->query_page->get_states();
																								if ($get_states->num_rows() > 0)
																								{
																									foreach ($get_states->result() as $state)
																									{
																										if ($this->session->userdata('shipping_country') != 'United States') $state_default = 'Other';
																										$sel_state = $state_default == $state->state_name ? 'selected="selected"' : '';
																										?>
																										<option value="<?php echo $state->state_name; ?>" <?php echo $sel_state; ?>><?php echo $state->state_name; ?></option>
																										<?php
																									}
																								}
																								?>
																							</select>
																						</div>
																					</div>
																				</li>
		
																				<li style="display: none;" class="pairing-freetextstate pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-freeTextState-1">
																						<span class="pairing-label">Non-US State / Province</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input id="vAccountAddress-fields-freeTextState-1" name="freeTextState" value="" maxlength="30" class="input-text" type="text">
																						</div>
																					</div>
																				</li>
		
																			</ul>
																		
																		</div>
		
																		<div class="pairinglist clearfix">
																		
																			<ul class="pairings clearfix">
		
																				<li class="pairing-dayphone pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-dayPhone-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Telephone</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" required="required" data-validation="{phone:true}" maxlength="30" id="vAccountAddress-fields-dayPhone-1" name="dayPhone" value="" size="15" type="text">
																						</div>
																					</div>
																				</li>
																	
																			</ul>
																			
																		</div>
		
																		<div class="pairinglist clearfix">
																			
																			<ul class="pairings clearfix">
																	
																				<li class="pairing-emailaddress pairing-required pairing-vertical pairing clearfix">
																					<label class="primary" for="vAccountAddress-fields-emailAddress-1">
																						<span class="required">*</span>
																						<span class="pairing-label">Email Address</span>
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<input class="input-text" required="required" maxlength="70" id="vAccountAddress-fields-emailAddress-1" name="emailAddress" value="" size="32" type="email">
																						</div>
																					</div>
																				</li>
		
																				<label class="no-uppercase  template-row__label" for="vAccountAddress-fields-addressIsCommercial-1">
																					<input class="input-checkbox" id="vAccountAddress-fields-addressIsCommercial-1" name="addressIsCommercial" value="1" type="checkbox">
																					Please check here if this is a commercial address
																				</label>
																			
																				<label class="no-uppercase  template-row__label  template-row__label--padded" for="vAccountAddress-fields-sendEmailUpdates-1">
																					<input class="input-checkbox" id="vAccountAddress-fields-sendEmailUpdates-1" name="sendEmailUpdates" value="1" checked="checked" type="checkbox">
																					Send me email updates
																				</label>

																				<li class="paring-horizontal pairing unsubscribe clearfix">Current email subscribers <a href="http://www.bhldn.com/index.cfm/fuseaction/emailsignup.unsubscribeForm">click here</a> to unsubscribe.</li> 
		
																				<li class="pairing-defaultshipping pairing-vertical pairing clearfix">
																					<label class="primary" for="isdefaultshipping">
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<label for="isDefaultShipping">
																								<input class="input-checkbox" id="isDefaultShipping" name="isDefaultShipping" value="1" type="checkbox">
																								Default Shipping Address
																							</label>
																						</div>
																					</div>
																				</li>
		
																				<li class="pairing-defaultbilling pairing-vertical pairing clearfix">
																					<label class="primary" for="isdefaultbilling">
																					</label>
																					<div class="pairing-content">
																						<div class="pairing-controls"> 
																							<label for="isDefaultBilling">
																								<input class="input-checkbox" id="isDefaultBilling" name="isDefaultBilling" value="1" type="checkbox">
																								Default Billing Address
																							</label>
																						</div>
																					</div>
																				</li>
		
																			</ul>
																			
																		</div>
		
																	</div>

																</div>
															</div>

															<div class="actionlist actionlist-continue clearfix">
																<ul class="actions clearfix">
																	<li class="action-primary action clearfix"> 
																		<button type="submit" class="button button--<?php echo $this->config->item('site_slug'); ?>">Continue Checkout</button>
																	</li> 
																</ul>
															</div>
		
														</form>
														
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
														<td>&#36;8.95</td>
													</tr>
													<tr class="addtnlshipping hidden"><!-- hidden -->
														<th>
															<span>Additional Shipping Charges</span>
														</th>
														<td>&#36;15.00</td>
													</tr>
													<tr class="tax">
														<th>Estimated Sales Tax (NY, USA Only)</th>
														<td>&#36;0.00</td>
													</tr>
													<tr class="total">
														<th>
															<span>Grand Total Cost</span>
														</th>
														<td><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + @$shipping_fee); ?></td>
													</tr>
												</tbody>
											</table>

											<div class="promocode">
												<a href="#" class="promocode__switch" data-promocode-switch="">Have a Promo code?</a>
												<form id="vCart-promoCodeForm-form-1" name="vCart_promoCodeForm_form_1" action="/index.cfm" method="post" class="promocode__form ajaxform" data-json-response='true'>
													<input type="hidden" name="fuseaction" value="cart.applyPromoCode" />
													<input type="hidden" name="originalFuseaction" value="cart.view" />
													<input type="text" class="input-text  promocode__input" id="vCart-promoCodeForm-fulfillmentSystemCode-1" name="fulfillmentSystemCode" value="" placeholder="Enter Your Promo Code" maxlength="20"/>
													<input type="submit" class="button  promocode__submit" value="Apply" />
												</form>
											</div>

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
												
												$href_text = str_replace('_2', '_3', $items['options']['prod_image']);
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
																<!-- item Subtotal -->
																<tr class="price">
																	<th>
																		Item Total
																	</th>
																	<td>
																		<div class="price">
																			<span itemprop="price" content="450.00">
																				<?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($items['subtotal']); ?>
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
