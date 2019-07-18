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
								
									<?php if ($this->cart->contents()): ?>
								
									<div class="order-summary__header clearfix">
										<h6 class='section-heading'>Order Summary</h6>
									</div>
									
									<div class="section order-summary__detail clearfix">
									
										<table class="order-totals base">
											<tbody>
												<tr class="subtotal">
													<th>Subtotal</th>
													<td>$ <?php echo $this->cart->format_number($this->cart->total()); ?></td>
												</tr>
												<tr class="shipping">
													<th>
														<span>Estimated Shipping</span>
													</th>
													<td>-</td>
												</tr>
												<tr class="tax">
													<th>Estimated Sales Tax (NY, USA Only)</th>
													<td>-</td>
												</tr>
												<tr class="total">
													<th>
														<span>Grand Total Cost</span>
													</th>
													<td><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + @$shipping_fee); ?></td>
												</tr>
											</tbody>
										</table>

										<?php
										/*
										| ---------------------------------------------------------------------------------------
										| Cart processing options
										| ---------------------------------------------------------------------------------------
										*/
										if ($this->session->userdata('user_cat') == 'wholesale')
										{
											echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/submit_order', array('id'=>'form_cart_basket'));
											
											$hidden_input = array(
												'payment_first_name' 	=> $this->wholesale_user_details->fname,
												'payment_last_name' 	=> $this->wholesale_user_details->lname,
												'email' 				=> $this->wholesale_user_details->email,
												'payment_telephone' 	=> $this->wholesale_user_details->telephone,
												'payment_storename'		=> $this->wholesale_user_details->store_name,
												
												'payment_address1' 		=> $this->wholesale_user_details->address1,
												'payment_address2' 		=> $this->wholesale_user_details->address2,
												'payment_city' 			=> $this->wholesale_user_details->city,
												'payment_state' 		=> $this->wholesale_user_details->state,
												'payment_country' 		=> $this->wholesale_user_details->country,
												'payment_zip' 			=> $this->wholesale_user_details->zipcode,

												'shipping_address1' 	=> $this->wholesale_user_details->address1,
												'shipping_address2' 	=> $this->wholesale_user_details->address2,
												'shipping_city' 		=> $this->wholesale_user_details->city,
												'shipping_state' 		=> $this->wholesale_user_details->state,
												'shipping_country' 		=> $this->wholesale_user_details->country,
												'shipping_zipcode'		=> $this->wholesale_user_details->zipcode
											);
											echo form_hidden($hidden_input);

											$some_session_data = array(
												'shipping_courier'	=> '',
												'shipping_fee'		=> '',
												'shipping_id'		=> ''
											);
											$this->session->unset_userdata($some_session_data);
										}
										else echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/process_cart',array('id'=>'form_cart_basket'));
										
										if ($this->session->userdata('user_cat') == 'wholesale') $proceed_btn_text = 'Submit order &raquo;';
										else $proceed_btn_text = 'Proceed to checkout &raquo;';
										?>
										<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />
										
										<div class="actionlist clearfix">
											<ul class="actions clearfix" style="text-align:center;">
												<button class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" type="submit" name="submit">
													<?php echo $proceed_btn_text; ?>
												</button>
											</ul>
										</div>
										
										<?php echo form_close(); ?>
										<!--eof form==========================================================================-->
		
									</div>
            
									<?php endif; ?>

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
										
											<h6 class='section-heading'><?php echo ! $this->cart->contents() ? 'Cart' : 'My Cart'; ?></h6>
											
											<?php if ( ! $this->cart->contents()): ?>
												
											<div class="product-line-item  product-line-item--empty">
												<p>Your Cart is empty</p>
											</div>
											
											<?php else: ?>
											
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
														<div class="shipping" style="text-align:right;line-height:unset;"><!-- float right -->
															<span style="">
																<?php echo @$items['options']['custom_order'] == '1' ? '<span style="color:red;">Pre-order<br />Ships in 14-16 weeks</span>' : 'In Stock'; ?>
															</span>
															
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

													<?php
													/**********
													 * Action Buttons
													 */
													?>
													<div class="product-line-item__actions clearfix" style="float:right;">
														<div class="actionlist clearfix">
															<ul class="actions clearfix">
																<li class="action-edit action-secondary action clearfix"> 
																	<a class="button button--alt button--small" href="javascript:void(0);" onclick="$('#modal-regular2-<?php echo $items['rowid']; ?>').show();">Edit</a>
																</li>
																<li class="action-remove action-secondary action clearfix"> 
																	<a class="button button--alt button--small" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/': '').'cart/update_cart/index/'.$i.'/'.$items['rowid']); ?>" title="Remove item from your Cart">Remove</a>
																</li>
																<li class="action-save action-secondary action clearfix hidden"><!-- hidden -->
																	<a class="button button--alt button--small" href="/index.cfm/fuseaction/cart.saveForLater/cartItemID/d63079fd-fa54-4157-886c-557c5f771a87/" title="Save 'Havana Corset' for later">Save For Later</a>
																</li> 
															</ul>
														</div>
													</div>
													
												</li>
												
												<!-- Regular Modal 2 -->
												<div id="modal-regular2-<?php echo $items['rowid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<span class="close" onclick="$('#modal-regular2-<?php echo $items['rowid']; ?>').hide();"><span style="font-size:0.7em;">CLOSE</span> &times;</span>
																<h1 class="modal-title">Edit Item</h1>
															</div>
															<div class="modal-body">
															
																<?php echo $items['options']['prod_no'].'<br />'; ?>
																<?php echo $items['name']; ?>
																
																<?php echo form_open(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'cart/update_cart'); ?>
																<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
																<?php echo form_hidden('special_sale_prefix', ($this->uri->segment(1) === 'special_sale' ? '1' : '0')); ?>
																<?php echo 'Quantity: '; ?>
																<?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '2')); ?>
																<?php echo '<br />'; ?>
																
																<button type="submit" class="button button--alt button--small" href="javascript:void(0);" style="margin-left:0px;">Submit</button>
																
																<?php echo form_close(); ?>

															</div>
														</div>
													</div>
												</div>
												<!-- END Regular Modal 2 -->
                
												<?php 
												$i++;; 
												if (@$items['options']['custom_order'] == TRUE) $custom_order = TRUE;
												else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
												else $custom_order = FALSE;
												endforeach; 
												?>
												
											</ul>
											
											<?php endif; ?>
											
										</div>

										<?php
										/**********
										 * Source has a second box at left side
										 * Intended for Save For Later items
										 * Adding a wrapping div to hide the section
										 */
										?>
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
												By placing your order, you agree to <?php echo $this->config->item('site_domain'); ?>’s <a href="<?php echo site_url('terms_of_use'); ?>">terms of use</a>
											</p>
											<br />
											<p>
												<b>FAQs</b>
												<br /> Have questions? <a class="external-link" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'faq'); ?>" rel="nofollow">Read our FAQs</a>
											</p>
											<br />
											<p>
												<b>RETURNS</b>
												<br /> Learn more about our <a class="external-link" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'return_policy'); ?>" rel="nofollow">return policy</a>
											</p>
											<br />
											<p>
												<b>SHIPPING</b>
												<br /> See information on our <a class="external-link" href="<?php echo site_url(($this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '').'shipping'); ?>" rel="nofollow">shipping</a>
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
