					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
						<div id="main" class="content-grid  clearfix" role="main">
                        
							<div class="v-cart-viewtemplate wl-grid">
							
								<?php
								/**********
								 * Right side column
								 * Top Box
								 * ORDER SUMMARY
								 */
								?>
								<div class="order-summary col col-4of12">
            
									<div class="order-summary__header clearfix">
										<h6 class='section-heading'>Summary</h6>
									</div>
									
									<div class="section order-summary__detail clearfix">
									
										<table class="order-totals base">
											<tbody>
												<tr class="subtotal">
													<th>Subtotal</th>
													<td>$ <?php echo $this->cart->format_number($this->order_details->order_amount - $this->order_details->shipping_fee); ?></td>
												</tr>
												<tr class="shipping">
													<th>
														<span>Estimated Shipping</span>
													</th>
													<td><?php echo $this->order_details->shipping_fee == '0' ? '-' : $this->cart->format_number($this->order_details->shipping_fee); ?></td>
												</tr>
												<tr class="tax">
													<th>Estimated Sales Tax (NY, USA Only)</th>
													<td><?php echo $this->order_details->ship_state === 'New York' ? $this->cart->format_number(($this->order_details->order_amount - $this->order_details->shipping_fee) * @$this->webspace_details->options['ny_sales_tax']) : '-'; ?></td>
												</tr>
												<tr class="total">
													<th>
														<span>Grand Total Cost</span>
													</th>
													<td>$ <?php echo $this->cart->format_number($this->order_details->order_amount + @$shipping_fee + ($this->order_details->ship_state === 'New York' ? $this->cart->format_number(($this->order_details->order_amount - $this->order_details->shipping_fee) * $this->config->item('ny_sales_tax')) : 0)); ?></td>
												</tr>
											</tbody>
										</table>

										<?php if ($this->order_details->ship_country !== 'United States'): ?>
										
										<p class="">
											We only use DHL to ship for countries other than USA. You will be contacted by customer service for respective shipping fees.
										</p>
										
										<?php endif; ?>
										
										<div class="promocode hidden"><!-- hidden -->
											<a href="#" class="promocode__switch" data-promocode-switch="">Have a Promo code?</a>
											<form id="vCart-promoCodeForm-form-1" name="vCart_promoCodeForm_form_1" action="/index.cfm" method="post" class="promocode__form ajaxform" data-json-response='true'>
												<input type="hidden" name="fuseaction" value="cart.applyPromoCode" />
												<input type="hidden" name="originalFuseaction" value="cart.view" />
												<input type="text" class="input-text  promocode__input" id="vCart-promoCodeForm-fulfillmentSystemCode-1" name="fulfillmentSystemCode" value="" placeholder="Enter Your Promo Code" maxlength="20"/>
												<input type="submit" class="button  promocode__submit" value="Apply" />
											</form>
										</div>

										<div class="actionlist clearfix hidden"><!-- hidden -->">
											<ul class="actions clearfix">
												<a class="button button--instylenewyork" href="<?php echo site_url('cart/customer_info'); ?>">Proceed to checkout &raquo;</a>
											</ul>
										</div>
		
									</div>
            
								</div>
								<!-- .order-summary -->
								
								<?php
								/**********
								 * Left side column
								 * Topo Box
								 * CART DETAILS
								 */
								?>
								<div class="cart-detail col col-7of12">
            
									<div class="v-cart-cartdetail">

										<div class="section cart clearfix">
										
											<?php if ($this->session->flashdata('flashRegMsg')): ?>
											
											<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
												<?php echo $this->session->flashdata('flashRegMsg'); ?>
											</div>
											
											<?php endif; ?>
											
											<div style="padding:30px 20px;margin-bottom:30px;border:1px solid #dcdcdc;font-style:italic;">
												THANK YOU : &nbsp;  Your order number is <?php echo $this->order_details->order_id; ?>.
												<br /><br />
												Your order has been received and is being processed.
												<br />
												A representative will be contacting you via email with confirmation of product shipment, at that time we will process your payment information. 
											</div>
										
											<h6 class='section-heading'>Your Order</h6>
											
											<ul class="cart-items">
											
												<?php 
												$i = 1; 
												foreach ($this->order_details->items() as $items):
												?>
				
												<li class="product-line-item even product-line-item--shipping-charge clearfix">
												
													<?php
													/**********
													 * Item IMAGE
													 * linking to product details page
													 */
													$href_text = str_replace(array('_2', '_f2'), array('_1', '_f1'), $items->image);
													?>
													<div class="product-line-item__image">
														<img class="product-browse-s  img-block" src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" alt="<?php echo $items->prod_no; ?>" />
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
															<span style=""><?php echo @$items->custom_order == '1' ? '<span style="color:red;">Pre-order<br />Ships in 12 weeks</span>' : 'In Stock'; ?></span>
															
															<?php if (@$items->custom_order == '3'): ?>
															
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
															<?php echo $items->prod_no; ?>
															<br />
															<span style="font-size:0.8em;">
																<?php echo $items->prod_name; ?>
															</span>
														</h3>
														<p class="product__id fsid" style="color:#999;">
															Product#: <?php echo $items->prod_no; ?>
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
																		<?php echo $items->color; ?>
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
																		<?php echo $items->size; ?>
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
																		<?php echo $items->qty; ?>
																	</td>
																</tr>
																<!-- item unit ptice -->
																<tr class="fv fv-horizontal">
																	<th>
																		<span class="fv-label">
																			Unit Price&nbsp;
																		</span>
																	</th>
																	<td>
																		$ <?php echo $this->cart->format_number($items->unit_price); ?>
																	</td>
																</tr>
																<!-- item Subtotal -->
																<tr class="price">
																	<th>
																		Item Total
																	</th>
																	<td>
																		<div class="price">
																			<span itemprop="price" content="">
																				$ <?php echo $this->cart->format_number($items->subtotal); ?>
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

													<?php
													/**********
													 * Action Buttons
													 
													<div class="product-line-item__actions clearfix" style="float:right;">
														<div class="actionlist clearfix">
															<ul class="actions clearfix">
																<li class="action-edit action-secondary action clearfix"> 
																	<a class="button button--alt button--small" href="javascript:void(0);" onclick="$('#modal-regular2-<?php echo $items['rowid']; ?>').show();">Edit</a>
																</li>
																<li class="action-remove action-secondary action clearfix"> 
																	<a class="button button--alt button--small" href="<?php echo site_url('cart/update_cart/'.$i.'/'.$items['rowid']); ?>" title="Remove item from your Cart">Remove</a>
																</li>
																<li class="action-save action-secondary action clearfix hidden"><!-- hidden -->
																	<a class="button button--alt button--small" href="/index.cfm/fuseaction/cart.saveForLater/cartItemID/d63079fd-fa54-4157-886c-557c5f771a87/" title="Save 'Havana Corset' for later">Save For Later</a>
																</li> 
															</ul>
														</div>
													</div>
													 */
													?>
													
												</li>
												
												<?php 
												$i++;
												endforeach; 
												?>
												
											</ul>
											
										</div>

										<?php
										/**********
										 * Source has a second box at left side
										 * Intended for Save For Later items
										 * Adding a wrapping div to hide the section
										 
										<div class="hidden"><!-- added wrapping div -->
										<div class="section saved clearfix">
											<h2 class='section-heading'>Saved For Later</h2>
											<div class="saved-items  product-line-item  product-line-item--empty">
												<p class="product-line-item__empty-text">You have not saved anything for later yet</p>
											</div>
										</div>
										<div class="section saved clearfix">
										</div>
										</div>
										 */
										?>

									</div>
								</div>
								<!-- .cart-detail -->

								<?php
								/**********
								 * Right side column
								 * Bottom Service Box
								 * Contact Info and notations to user
								 */
								?>
								<section class="ct ct-cartbody col col-4of12">
									<div class="cart-information">
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
											<p class="terms">
												By placing your order, you agree to <?php echo $this->config->item('site_domain'); ?>’s <a href="#">terms of use</a>
											</p>
											<br />
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
										</div>

									</div>
									<!-- .cart-information -->
								</section>
								
							</div>
							<!-- .wl-grid -->
	
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->
