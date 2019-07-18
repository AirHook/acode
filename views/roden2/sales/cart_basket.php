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
										<h6 class="section-heading">
										
											<?php if ($this->session->userdata('access_level') != '1'): ?>
											Options
											<?php else: ?>
											Send Yourself Linesheets
											<?php endif; ?>
										</h6>
									</div>
									
										<?php if ($this->session->userdata('access_level') != '1'): ?>
									
									<div class="section order-summary__detail clearfix">
									
										<table class="order-totals base">
											<tbody>
												<tr class="subtotal">
													<th style="width:60%;padding-bottom:10px;">Total number of items</th>
													<td style="width:40%;padding-bottom:10px;"><?php echo $this->cart->total_items(); ?></td>
												</tr>
												<tr class="shipping">
													<th style="width:60%;">
														<span>Send with prices?</span>
													</th>
													<td style="width:40%;">
														Yes  <input type="radio" id="send_w_prices" name="send_w_prices" value="Y" checked="checked"  onclick="ungray_e_prices()" />
														No <input type="radio" id="no_send_w_prices" name="send_w_prices" value="N" onclick="gray_e_prices()" />
													</td>
												</tr>
												<tr class="tax">
													<th style="width:60%;">
														<span>Edit prices?</span>
													</th>
													<td style="width:40%;">
														<span id="span_e_prices">
														Yes <input type="radio" id="yes_e_prices" name="e_prices" value="Y" onclick="edit_prices()" />
														No <input type="radio" id="no_e_prices" name="e_prices" value="N" checked="checked" onclick="unedit_prices()" />
														</span>
													</td>
												</tr>
												<tr class="tax">
													<th style="width:60%;">
														<span>Attach Linesheets</span>
													</th>
													<td style="width:40%;">
														<span id="span_w_images" style="">
														Yes <input type="radio" id="yes_w_images" name="send_w_images" value="Y" onclick="send_w_images('y')" />
														No <input type="radio" id="no_w_images" name="send_w_images" value="N" checked="checked" onclick="send_w_images('n')" />
														</span>
													</td>
												</tr>
												<tr class="tax">
													<th style="width:60%;">
														<span>Send Linesheets only</span>
													</th>
													<td style="width:40%;">
														<span id="span_linesheets_only" style="">
														Yes <input type="radio" id="yes_linesheets_only" name="attached_linesheets_only" value="Y" onclick="linesheets_only('y')" />
														No <input type="radio" id="no_linesheets_only" name="attached_linesheets_only" value="N" checked="checked" onclick="linesheets_only('n')" />
														</span>
													</td>
												</tr>
											</tbody>
										</table>

										<div class="actionlist clearfix">
											<ul class="actions clearfix" style="text-align:center;">
												<!-- Series of Update Price Button -->
												<div id="upd_price_btn_1" style="display:none;">
													<button class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" type="button" name="upd_price_btn" onclick="update_form()">
														Update Prices Before Submitting
													</button>
												</div>
											</ul>
										</div>
										
									</div>
            
										<?php endif; ?>
										
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
										
											<h6 class='section-heading'><?php echo ! $this->cart->contents() ? 'Items' : 'My Items'; ?></h6>
											
											<?php if ( ! $this->cart->contents()): ?>
												
											<div class="product-line-item  product-line-item--empty">
												<p>Your List is empty</p>
											</div>
											
											<?php else: ?>
											
											<ul class="cart-items">
											
												<?php  echo form_open('sa/update_summary', array('id' => 'product_linesheet_summary', 'namne' => 'product_linesheet_summary')); ?>
												
												<?php 
												/**********
												 * Needed for update of cart 
												 */
												?>
												<input type="hidden" id="is_edit_price" name="is_edit_price" value="N" />
				
												<?php
												$i = 1; 
												foreach ($this->cart->contents() as $items): 
												
													echo form_hidden($i.'[rowid]', $items['rowid']);
												
													// assign the primary images
													$img_url		= $items['options']['image_url'];
													$img_thumb 	    = $img_url.'product_front/thumbs/'.$items['id'].'_2.jpg';
													$img_thumb_back = $img_url.'product_back/thumbs/'.$items['id'].'_2.jpg';
													$img_thumb_side = $img_url.'product_side/thumbs/'.$items['id'].'_2.jpg';
													
													// check images and set default logo where necessary
													if (get_http_response_code($this->config->item('PROD_IMG_URL').$img_thumb) === '200')
													{
														$thumbnail = $this->config->item('PROD_IMG_URL').$img_thumb;
														if (get_http_response_code($this->config->item('PROD_IMG_URL').$img_thumb_back) === '200')
														{
															$back = $this->config->item('PROD_IMG_URL').$img_thumb_back;
														}
														else
														{
															if (get_http_response_code($this->config->item('PROD_IMG_URL').$img_thumb_side) === '200')
															{
																$back = $this->config->item('PROD_IMG_URL').$img_thumb_side;
															}
															else
															{
																$back = $this->config->item('PROD_IMG_URL').$img_thumb;
															}
														}
													}
													else
													{
														$thumbnail  = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_2.jpg';
														$back  		= $this->config->item('PROD_IMG_URL').'images/instylelnylogo_2.jpg';
													}
													
													$alt = $items['name'];
													
													// The link for the product line sheet image
													$seg = $img_url.'product_linesheet/';
												?>
												
												<li class="product-line-item even product-line-item--shipping-charge clearfix">
												
													<?php
													/**********
													 * Item IMAGE
													 * linking to product details page
													 */
													?>
													<div class="product-line-item__image">
														<a href="javascript:void(0);" title="<?php echo $items['options']['prod_no']; ?>">
															<img class="product-browse-s  img-block" src="<?php echo $thumbnail; ?>" alt="<?php echo $items['options']['prod_no']; ?>" />
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
															<?php echo $items['options']['prod_no']; ?>
															<br />
															<span style="font-size:0.8em;">
																<?php echo $items['name']; ?>
															</span>
														</h3>
														<p class="product__id fsid" style="color:#999;">
															Product#: <?php echo $items['options']['prod_no']; ?>
														</p>

														<?php if ($this->session->userdata('access_level') != '1'): ?>
														
														<?php
														/**********
														 * Item Cart details
														 */
														?>
														<table class="product__options base">
															<tbody>
																<!-- item Subtotal -->
																<tr class="price">
																	<th>
																		Price
																	</th>
																	<td>
																		<div class="price" id="price_div<?php echo $i; ?>">
																			<div id="the_price_<?php echo $i; ?>">
																				<span itemprop="price">
																					<?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($items['subtotal']); ?>
																				</span>
																			</div>
																			<div id="edited_price_<?php echo $i; ?>">
																				<input type="hidden" id="cart_val_<?php echo $i; ?>" name="cart_val_<?php echo $i; ?>" value="<?php echo $items['options']['val']; ?>" />
																				<input type="text" id="price_<?php echo $i; ?>" name="price_<?php echo $i; ?>" value="<?php echo $items['price']; ?>" size="5" style="float:right;text-align:right;display:none;" />
																			</div>
																			<div id="the_price_disabled_<?php echo $i; ?>" style="display:none;">
																				<span style="position:relative;right:25px;">-</span>
																			</div>
																		</div>
																		<meta itemprop="priceCurrency" content="USD" />
																	</td>
																</tr>
															</tbody>
														</table>
														
														<?php endif; ?>
								
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
																<li class="action-remove action-secondary action clearfix"> 
																	<input type="hidden" id="<?php echo $i.'[qty]'; ?>" name="<?php echo $i.'[qty]'; ?>" value="<?php echo $items['qty']; ?>" />
																	<a class="button button--alt button--small" href="javascript:void(0);" onclick="update_form('<?php echo $i.'[qty]'; ?>')" title="Remove item from list">Remove</a>
																</li>
															</ul>
														</div>
													</div>
													
												</li>
												
												<?php 
												$i++;; 
												
												endforeach;
												
												echo form_close();
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
								
									<?php if ( ! $this->cart->contents()): ?>
									
									<div class="actionlist clearfix">
										<ul class="actions clearfix" style="text-align:center;">
											<!-- Series of Update Price Button -->
											<div id="upd_price_btn_1">
												<button class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" type="button" name="upd_price_btn" onclick="window.location.href='<?php echo site_url('sa/apparel'); ?>';">
													Select items again
												</button>
											</div>
										</ul>
									</div>
									
									<?php else: ?>
									
										<?php if ($this->session->userdata('access_level') != '1'): ?>
									
									<div class="order-summary__header clearfix">
										<h6 class="section-heading">
											Send Sales Package
										</h6>
									</div>
									
										<?php endif; ?>
									
									<div class="cart-information">
										<div class="return-policy-block">
										
											<?php echo form_open('sa/send_product_linesheet'); ?>
											
											<input type="hidden" id="w_prices" name="w_prices" value="<?php echo $this->session->userdata('access_level') != '1' ? 'Y' : 'N'; ?>" />
											<input type="hidden" id="w_images" name="w_images" value="N" />
											<input type="hidden" id="linesheets_only" name="linesheets_only" value="<?php echo $this->session->userdata('access_level') != '1' ? 'N' : 'Y'; ?>" />
										
											<div class="v-login-fields clearfix">
												<div class="pairinglist clearfix" >
													<ul class="pairings clearfix">
										
														<li class="pairing-recipients_name pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="recipients_name">
																<?php if ($this->session->userdata('access_level') != '1'): ?>
																<span class="required">*</span>
																<?php endif; ?>
																<span class="pairing-label">Recipients Name</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																
																	<?php if ($this->session->userdata('access_level') != '1'): ?>
																	
																	<input type="text" id="recipients_name" class="input-text" required="required" name="recipients_name" value="<?php echo set_value('recipients_name') ? set_value('recipients_name') : $this->session->userdata('auto_recipients_name'); ?>" />
																	
																	<?php else: ?>
																	
																	<input type="text" id="recipients_name_" class="input-text" required="required"name="recipients_name_" value="<?php echo $this->session->userdata('admin_sales_email'); ?>" disabled="disabled" style="background:#eaeaea;cursor:not-allowed;" />
																	
																	<input type="hidden" name="email" value="<?php echo $this->session->userdata('admin_sales_email'); ?>" />
																	<input type="hidden" id="recipients_name" name="recipients_name" value="<?php echo ucwords($this->session->userdata('admin_sales_user').' '.$this->session->userdata('admin_sales_lname')); ?>" />
																	<input type="hidden" name="recipients_store_name" value="<?php echo  set_value('recipients_store_name') ? set_value('recipients_store_name') : $this->session->userdata('auto_recipients_store_name'); ?>" />
																	<input type="hidden" name="bcc_email" value="" />
																	
																	<?php endif; ?>
																	
																</div>
															</div>
															<?php echo form_error('recipients_name'); ?>
														</li>
														
										<?php if ($this->session->userdata('access_level') != '1'): ?>
										
														<li class="pairing-recipients_store_name pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="recipients_store_name">
																<span class="required">*</span>
																<span class="pairing-label">Store Name</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<input type="text" class="input-text" required="required" id="recipients_store_name" name="recipients_store_name" value="<?php echo  set_value('recipients_store_name') ? set_value('recipients_store_name') : $this->session->userdata('auto_recipients_store_name'); ?>" />
																</div>
															</div>
															<?php echo form_error('recipients_store_name'); ?>
														</li>
													</ul>
													<ul class="pairings clearfix">
										
														<li class="pairing-email pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="recipients_email">
																<span class="required">*</span>
																<span class="pairing-label">Recipients Email</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<input type="email" class="input-text" required="required" id="recipients_email" name="email" value="<?php echo set_value('email') ? set_value('email') : $this->session->userdata('auto_recipients_email'); ?>" />
																</div>
															</div>
															<?php echo form_error('email'); ?>
														</li>
										
														<li class="pairing-bcc_email pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="bcc_email">
																<span class="pairing-label">BCC Email</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<input type="text" class="input-text" id="bcc_email" name="bcc_email" value="<?php echo set_value('bcc_email'); ?>" />
																</div>
															</div>
															<?php echo form_error('bcc_email'); ?>
														</li>
													</ul>
													<ul class="pairings clearfix">
													
										<?php endif; ?>
										
														<li class="pairing-email pairinglist--centered pairing-required pairing-vertical pairing clearfix">
															<label class="primary page-text-body" for="comments_overall">
																<span class="pairing-label">Comments Overall</span>
															</label>
															<div class="pairing-content">
																<div class="pairing-controls"> 
																	<textarea id="comments_overall" name="comments_overall" rows="5" class="input-text" ><?php echo set_value('comments_overall'); ?></textarea>
																</div>
															</div>
															<?php echo form_error('comments_overall'); ?>
														</li>
														
													</ul>
												</div>
											</div>

											<div style="text-align:center;">
												<button type="submit" name="submit" class="button button--small--text button--<?php echo $this->config->item('site_slug'); ?>" style="width:200px;" value="SEND">
													<?php if ($this->session->userdata('access_level') != '1'): ?>
													Send Sales Package
													<?php else: ?>
													Send Yourself Linesheets
													<?php endif; ?>
												</button>
											</div>
											
											<?php echo form_close(); ?>
											
										</div>
									</div>
									<!-- .cart-information -->
									
									<?php endif; ?>
									
								</section>
								
							</div>
							<!-- .wl-grid -->
	
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->

					<?php
					function get_http_response_code($domain1) {
						$headers = get_headers($domain1);
						return substr($headers[0], 9, 3);
					}
					?>