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
								 * OPTIONS
								 */
								?>
								<div class="order-summary col col-4of12">
            
									<?php $this->load->view('roden2/sales/my_info'); ?>
								
									<br />
									<div class="order-summary__header clearfix">
										<h6 class="section-heading">
											Package Other Info
										</h6>
									</div>
									<div class="section order-summary__detail clearfix">
										<table class="order-totals base">
											<tbody>
												<tr class="subtotal">
													<th style="width:60%;padding-bottom:10px;">Total number of items</th>
													<td style="width:40%;padding-bottom:10px;"><?php echo $this->sales_package_details->items_count; ?></td>
												</tr>
												<tr class="shipping">
													<th style="width:60%;">
														<span>Send with prices?</span>
													</th>
													<td style="width:40%;">
														Yes <input type="radio" id="send_w_prices" name="send_w_prices" value="Y" checked="checked" onclick="$('input[name=\'w_prices\']').val('Y');" />
														No <input type="radio" id="no_send_w_prices" name="send_w_prices" value="N" onclick="$('input[name=\'w_prices\']').val('N');" />
													</td>
												</tr>
												<tr class="tax hidden">
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
														Yes <input type="radio" id="yes_w_images" name="send_w_images" value="Y" onclick="$('input[name=\'w_images\']').val('Y');" />
														No <input type="radio" id="no_w_images" name="send_w_images" value="N" checked="checked" onclick="$('input[name=\'w_images\']').val('N');" />
														</span>
													</td>
												</tr>
											</tbody>
										</table>

										<div class="actionlist clearfix">
											<ul class="actions clearfix" style="text-align:center;">
												<!-- Series of Update Price Button -->
												<div id="upd_price_btn_1" style="display:none;">
													<button class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" type="button" name="upd_price_btn" onclick="update_form()">
														Update Prices Before Submitting
													</button>
												</div>
											</ul>
										</div>
										
									</div>
            
								</div>
								<!-- .order-summary -->
								
								<?php
								/**********
								 * Left side column
								 * Top Box
								 * CART DETAILS
								 */
								?>
								<div class="cart-detail col col-7of12">
            
									<div class="v-cart-cartdetail">

										<div class="section cart clearfix">
										
											<?php
											/**********
											 * Notification Area
											 */
											?>
											<?php if ($this->session->flashdata('flashRegMsg')): ?>
											<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
												<?php echo $this->session->flashdata('flashRegMsg'); ?>
											</div>
											<?php endif; ?>
											<?php if ($this->session->flashdata('error') == 'invalid_email_address') { ?>
											<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
												Invalid email address. Please try again.
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('success') == 'sales_package_sent') { ?>
											<div style="padding:10px 20px;background:#c0fca4;margin-bottom:30px;">
												<span style="float:right;cursor:pointer;" onclick="$(this).closest('div').hide();">[X]</span>
												<a name="#" style="text-decoration:none;">Sales package successfully sent.
												Back to</a> <a href="<?php echo site_url('sales/dashboard'); ?>">DASHBOARD</a>.
											</div>
											<?php } ?>
										
											<h6 class="section-heading"><?php echo $this->sales_package_details->name; ?></h6>
											
											<div class="" style="width:100%;">
												<div class="cart-information">
													<div class="return-policy-block">
														<div class="v-login-fields clearfix">
															<div class="pairinglist clearfix" >
																<ul class="pairings clearfix">
													
																	<li class="pairing-email pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="recipients_email">
																			<span class="required">*</span>
																			<span class="pairing-label">Email Subject</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<input type="email" name="email_subject" class="form-control input-text" value="<?php echo $this->sales_package_details->email_subject; ?>" <?php echo $this->sales_package_details->sales_user == '1' ? 'readonly style="background-color:#cfcfcf;"' : ''; ?>/> 
																			</div>
																		</div>
																		<?php echo form_error('email_subject'); ?>
																	</li>
													
																	<li class="pairing-email_message pairinglist--centered pairing-required pairing-vertical pairing clearfix">
																		<label class="primary page-text-body" for="email_message">
																			<span class="pairing-label">Short Message</span>
																		</label>
																		<div class="pairing-content">
																			<div class="pairing-controls"> 
																				<?php echo $this->sales_package_details->email_message; ?>
																			</div>
																		</div>
																		<?php echo form_error('email_message'); ?>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
												<p>
													NOTE: <br />
													<?php if ($this->sales_package_details->sales_package_id == '1' OR $this->sales_package_details->sales_package_id == '2') { ?>
													This is a SYSTEM GENERATED sales package. Edit is not enabled on this sales package.<br />
													<?php } ?>
													<?php if ($this->sales_package_details->sales_package_id != '1' && $this->sales_package_details->sales_package_id != '2' && $this->sales_package_details->sales_user == '1') { ?>
													This is an ADMIN GENERATED sales package. Edit is not enabled on this sales package.<br />
													<?php } ?>
													Max of 30 items per package sent by 10's in 3 separate emails.
												</p>
											</div>
											
											<h6 class="section-heading">The Items</h6>
											
											<div class="sales-pacakge-items">
											
												<?php 
												if ( ! empty($this->sales_package_details->items)) 
												{
													foreach ($this->sales_package_details->items as $product)
													{
														// get product details
														$this->product_details->initialize(array('prod_no'=>$product));
														
														// let set the classes and other items...
														$classes2 = in_array($this->product_details->prod_no, $this->sales_package_details->items) ? 'selected ' : '';
														
														// set image paths
														$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
														$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
														// the image filename
														$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
														?>
														
												<div class="product-line-item__image thumb" style="width:130px;height:auto;position:relative;">
													<a href="javascript:void(0);" title="<?php echo $product; ?>">
														<img class="product-browse-s img-block img-b" src="<?php echo $img_back_pre.$image; ?>">
														<img class="product-browse-s img-block img-a" src="<?php echo $img_front_pre.$image; ?>" alt="<?php echo $this->product_details->prod_no; ?>">
													</a>
													<div style="margin-top:200px;">
														<p>
															<?php if (
															($this->sales_package_details->sales_package_id != '1' && $this->sales_package_details->sales_package_id != '2') && $this->sales_package_details->sales_user != '1'
															)
															{ ?>
															<input type="checkbox" class="s_checkbox-prod_id <?php echo $classes2; ?>" name="s_prod_id" id="s_<?php echo $this->product_details->prod_id; ?>" value="<?php echo $this->product_details->prod_id; ?>" data-prod_no="<?php echo $this->product_details->prod_no; ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>" style="float:right;" <?php echo in_array($this->product_details->prod_no, $this->sales_package_details->items) ? 'checked' : ''; ?>/>
															<?php } ?>
															<?php echo $this->product_details->prod_no; ?></br>
															$ <?php echo number_format($this->product_details->wholesale_price, 2) ; ?>
														</p>
													</div>
												</div>
												
													<?php }
												} 
												else 
												{ ?>
												<p style="margin-top:50px;font-size:1.2em;">
												Please select items below to start populating this sales package.
												</p>
												<?php } ?>
											
												<input type="hidden" id="items_count" name="items_count" value="<?php echo $this->sales_package_details->items_count; ?>" />
							
											</div>
											
										</div>

									</div>
									
									<?php if (
										($this->sales_package_details->sales_package_id != '1' && $this->sales_package_details->sales_package_id != '2') && $this->sales_package_details->sales_user != '1'
									)
									{ ?>
									<div class="v-cart-cartdetail">
										Select items here...
										<?php $this->load->view($this->webspace_details->options['theme'].'/sales/sales_package_view_products_grid', $this->data); ?>
									</div>
									<?php } ?>
									
								</div>
								<!-- .cart-detail -->

								<?php
								/**********
								 * Right side column
								 * Bottom Service Box
								 * Contact Info and notations to user
								 */
								?>
								<?php $this->load->view(THEME_FOLDER.'/sales/user_list_and_register'); ?>
								
							</div>
							<!-- .wl-grid -->
	
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->

					<!-- Regular Modal -->
					<div id="modal-create_sales_package" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<span class="close" onclick="$('#modal-create_sales_package').hide();"><span style="font-size:0.7em;">CLOSE</span> &times;</span>
									<h1 class="modal-title">Create Sales Package</h1>
								</div>
								<div class="modal-body">
								
									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open('sales/create_sales_package', array('id'=>'form_create_sales_package')); ?>
									
									<input type="hidden" name="sales_user" value="<?php echo $this->sales_user_details->admin_sales_id; ?>" />
									
									<div class="form-group">
										<label class="col-md-3 control-label">Sales Package Name:
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="sales_package_name" placeholder="" style="width:100%;" /> 
											<span class="help-block">Give this sales package a name...</span>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Email Subject
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" name="email_subject" data-required="1" class="form-control" value="" style="width:100%;" /> 
											<span class="help-block">used as the subject for the email campaign</span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-9 col-md-offset-2">
											<button type="submit" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>">Create Sales Package</button>
										</div>
									</div>
									
									<?php echo form_close(); ?>
									<!-- End FORM ===================================================================-->
									
								</div>
							</div>
						</div>
					</div>
					<!-- END Regular Modal -->
					
					<!-- Regular Modal -->
					<div id="modal-loading" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content modal-sm">
								<div class="modal-header">
									<h1 class="modal-title">Loading</h1>
								</div>
								<div class="modal-body" style="text-align:center;">
									<i class="fa fa-gear fa-2x fa-spin"></i>
								</div>
							</div>
						</div>
					</div>
					<!-- END Regular Modal -->
					
					<script>
					$('.sales-pacakge-items').on('click', '.s_checkbox-prod_id', function() {
						$('#modal-loading .modal-title').html('Removing...');
						$('#modal-loading').show();
								$('#'+$(this).data('prod_id')).removeClass('selected');
								$('#'+$(this).data('prod_id')).attr('checked', false);
						$.ajax({
							type:    "POST",
							url:     "<?php echo site_url('sales/sales_front_addrem'); ?>",
							data:    {
								"action":"rem_item",
								"id":"<?php echo $this->sales_package_details->sales_package_id; ?>",
								"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
								"admin_sales_id":"<?php echo $this->sales_user_details->admin_sales_id; ?>",
								"prod_no":$(this).data('prod_no'),
								"prod_id":$(this).data('prod_id')
							},
							success: function(data) {
								//alert('call back');
								$('.sales-pacakge-items').html('');
								$('.sales-pacakge-items').html(data);
								$('#modal-loading').hide();
							},
							// vvv---- This is the new bit
							error:   function(jqXHR, textStatus, errorThrown) {
								$('#modal-loading').show();
								location.reload();
								//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
							}
						});
						$('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
					});
					</script>
