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
												
												<section class="equal-height-section">
													
												<div class="content" style="display: block;">
													<div class="v-checkout-shippingaddressshipmentoptiontemplate clearfix">
													
														<!-- BEGIN FORM-->
														<!-- FORM =======================================================================-->

														<!--
														<form name="vCheckout_shippingAddressShipmentOptionTemplate_form_1" id="vCheckout-shippingAddressShipmentOptionTemplate-form-1" action="<?php echo site_url(); ?>" method="post" class="checkout-form" novalidate="novalidate">
														-->
														
														<?php echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/customer_info'); ?>
														<?php echo validation_errors() ? '<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">'. validation_errors() .'</div>' : ''; ?>
														<?php echo $this->session->flashdata('flashRegMsg') ? '<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">'.$this->session->flashdata('flashRegMsg') .'</div>' : ''; ?>
														
															<input type="hidden" name="control" value="cart" />
															
															<!--<input name="fuseaction" value="checkout.insertShippingAddress" type="hidden">-->

															<div class="v-checkout-checkoutaddresssingleform togglefields clearfix">
																<div class="addresses-new togglefields-group clearfix">
																	
																	<?php
																	/**********
																	 * Source's inputs
																	 
																	<input name="ID" value="" type="hidden">
																	<input name="addressIsPublic" value="1" type="hidden">
																	<input name="accountAddressTitleID" value="" type="hidden">
																	<input name="middleName" value="" type="hidden">
																	<input name="eveningPhone" value="" type="hidden">
																	<input name="descriptiveName" value="" type="hidden">
																	 */
																	?>

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
																								
																								<?php foreach (list_countries() as $country) { ?>
																								
																								<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country', $country->countries_name); ?>><?php echo $country->countries_name; ?></option>
																								
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
																										$( ".pairing-shipping-options" ).show();
																										$( ".dhl_notice" ).hide();
																										$( ".input_states" ).hide();
																										$( ".dd_usa_states" ).show();
																										$( "#input_states_field" ).val( "" );
																										$( ".non-us-cost-summary-item" ).hide();
																										$( ".us-cost-summary-item" ).show();
																									}
																									else
																									{
																										$( ".pairing-shipping-options" ).hide();
																										$( ".dhl_notice" ).show();
																										$( ".input_states" ).show();
																										$( ".dd_usa_states" ).hide();
																										$( "#dd_usa_states_options" ).val( "" );
																										$( ".usa_ship_options" ).attr( "checked", false );
																										$( ".non-us-cost-summary-item" ).show();
																										$( ".us-cost-summary-item" ).hide();
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
																							<input id="vAccountAddress-fields-non-us-states-1 input_states_field" name="non-us-states" value="<?php echo set_value('non-us-states'); ?>" maxlength="30" class="input-text" type="text">
																						</div>
																						<div class="pairing-controls dd_usa_states"> 
																							<select name="us-states" id="vAccountAddress-fields-us-states-1 dd_usa_states_options">
																								<option value=""> - select state - </option>
																								
																								<?php foreach (list_states() as $state) { ?>
																								<option value="<?php echo $state->state_name; ?>"><?php echo $state->state_name; ?></option>
																								<?php } ?>
																								
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
																					Send me special offers
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
																						An item in your cart is <strong>Custom Order.</strong><br />Shipment will be approximately <span style="color:red;">14-16 weeks</span> from order.
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
																							if ($ship_methods) 
																							{
																								$y = 0;
																								foreach ($ship_methods as $shipmethod)
																								{
																									if ($custom_order && $shipmethod->ship_id != 1) $show_me = 'style="display:none;"';
																									else $show_me = '';
																								?>

																							<input class="input-radio usa_ship_options usa_ship_options" id="vAccountAddress-fields-shipmethod-1" name="shipmethod" value="<?php echo $shipmethod->ship_id; ?>" type="radio" <?php echo $show_me; ?>>
																							<span <?php echo $show_me; ?>><?php echo $shipmethod->ship_id.' - '.$shipmethod->courier.' ('.$shipmethod->fee; ?>)</span>
																							<br />
																							
																									<?php
																									$y++;
																								}
																							} 
																							?>

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
																		<button type="submit" class="button button--<?php echo $this->webspace_details->slug; ?>">Continue Checkout</button>
																	</li> 
																</ul>
															</div>
		
														</form>
														<!-- END FORM ===================================================================-->
														
													</div>
													
													<p class="reqmsg">* <span class="screenreaderonly"> indicates </span>Required</p>
													
												</div>
												
												</section>
												
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
														<td>-</td>
													</tr>
													<tr class="tax">
														<th>Estimated Sales Tax (NY, USA Only)</th>
														<td class="non-us-cost-summary-item">-</td>
														<td class="us-cost-summary-item" style="display:none;">
															<?php 
															if (isset($this->webspace_details->options['ny_sales_tax']))
															{
																$taxed = $this->cart->format_number($this->webspace_details->options['ny_sales_tax'] * $this->cart->total());
															}
															else $taxed = '-';
															echo $taxed; 
															?>
														</td>
													</tr>
													<tr class="total">
														<th>
															<span>Grand Total Cost</span>
														</th>
														<td class="non-us-cost-summary-item"><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + @$shipping_fee); ?></td>
														<td class="us-cost-summary-item" style="display:none;"><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + @$shipping_fee + $taxed); ?></td>
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
													<div class="product-line-item__image" data-prod_image_url="<?php echo $items['options']['prod_image_url']; ?>">
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
