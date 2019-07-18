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
								 * Sales User Info
								 */
								?>
								<div class="order-summary col col-4of12">
            
									<?php $this->load->view('roden2/sales/my_info'); ?>
								
								</div>
								
								<?php
								/**********
								 * Left side column
								 * Top Box
								 * CONTENT DETAILS
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
											<?php if ($this->session->flashdata('flashRegMsg')) { ?>
											<div style="padding:10px 20px;background:pink;margin-bottom:30px;border:1px solid red;color:red;font-style:italic;">
												<?php echo $this->session->flashdata('flashRegMsg'); ?>
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('error') == 'invalid_email_address') { ?>
											<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
												Invalid email address. Please try again.
											</div>
											<?php } ?>
											<?php if (validation_errors()) { ?>
											<div style="padding:10px 20px;background:pink;margin-bottom:30px;color:red;">
												We found errors on the new user registration form.
												<?php echo validation_errors(); ?>
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('success') == 'linesheet_sent') { ?>
											<div style="padding:10px 20px;background:#c0fca4;margin-bottom:30px;">
												<span style="float:right;cursor:pointer;" onclick="$(this).closest('div').hide();">[X]</span>
												<a name="#" style="text-decoration:none;">Linesheet successfully sent.
												Back to</a> <a href="<?php echo site_url('sales/dashboard'); ?>">DASHBOARD</a>.
											</div>
											<?php } ?>
										
											<h6 class="section-heading">Linesheet Sending</h6>
											
											<?php
											/**********
											 * Summary or Cart info
											 * Sales Package Items
											 * SELECTED
											 */
											?>
											<div class="selected-linsheet-items clearfix">
											
												<h6 class="section-heading">Selected Items</h6>
											
												<?php 
												if (isset($this->sales_user_details->options['selected']) && ! empty($this->sales_user_details->options['selected'])) 
												{
													foreach ($this->sales_user_details->options['selected'] as $selected)
													{
														// get product details
														$this->product_details->initialize(array('prod_no'=>$selected));
														
														// let set the classes and other items...
														$classes2 = (@$this->sales_user_details->options['selected'] && in_array($this->product_details->prod_no, $this->sales_user_details->options['selected'])) ? 'selected ' : '';
														
														// set image paths
														$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
														$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
														// the image filename
														$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
														?>
														
												<div class="product-line-item__image thumb" style="width:130px;height:auto;position:relative;">
													<a href="javascript:void(0);" title="<?php echo $selected; ?>">
														<img class="product-browse-s img-block img-b" src="<?php echo $img_back_pre.$image; ?>">
														<img class="product-browse-s img-block img-a" src="<?php echo $img_front_pre.$image; ?>" alt="<?php echo $this->product_details->prod_no?>">
													</a>
													<div style="margin-top:200px;">
														<p>
															<input type="checkbox" class="s_checkbox-prod_id <?php echo $classes2; ?>" name="s_prod_id" id="s_<?php echo $this->product_details->prod_id; ?>" value="<?php echo $this->product_details->prod_id; ?>" data-prod_no="<?php echo $this->product_details->prod_no; ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>" style="float:right;" <?php echo (@$this->sales_user_details->options['selected'] && in_array($this->product_details->prod_no, $this->sales_user_details->options['selected'])) ? 'checked' : ''; ?>/>
															
															<?php echo $this->product_details->prod_no; ?></br>
															$ <?php echo number_format($this->product_details->wholesale_price, 2) ; ?>
														</p>
													</div>
												</div>
												
													<?php }
												} 
												else 
												{ ?>
												<p style="margin:20px 0 50px;font-size:1.2em;">
												EMPTY. You may select from your favorites or from the product list below...
												</p>
												
												<?php } ?>
											
												<input type="hidden" id="items_count" name="items_count" value="<?php echo count(@$this->sales_user_details->options['selected']); ?>" />
							
											</div>
											<br />
										
											<?php
											/**********
											 * Summary or Cart info
											 * Sales Package Items
											 * FAVORITES
											 */
											?>
											<div class="favorites-items clearfix">
											
												<h6 class="section-heading" data-sales_designer="<?php echo $this->sales_user_details->designer; ?>">Favorites</h6>
												You can select items from your favorites here...
												<br />
											
												<?php 
												if ( ! empty($this->sales_user_details->favorites)) 
												{
													$favorites = $this->sales_user_details->favorites;
													$favorites = array_slice($favorites, 0, 10, TRUE);
													foreach ($favorites as $prod_no => $stats)
													{
														// get product details
														$this->product_details->initialize(array('prod_no'=>$prod_no));
														
														if (
															$this->sales_user_details->designer == $this->webspace_details->slug
															OR $this->sales_user_details->designer == $this->product_details->d_folder
															OR $this->sales_user_details->designer == $this->product_details->d_url_structure
														)
														{
															// let set the classes and other items...
															$classes2 = (@$this->sales_user_details->options['selected'] && in_array($this->product_details->prod_no, $this->sales_user_details->options['selected'])) ? 'selected ' : '';
															
															// set image paths
															$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
															$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
															// the image filename
															$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
															?>
														
												<div class="product-line-item__image thumb" style="width:130px;height:auto;position:relative;">
													<a href="javascript:void(0);" title="<?php echo $prod_no; ?>">
														<img class="product-browse-s img-block img-b" src="<?php echo $img_back_pre.$image; ?>">
														<img class="product-browse-s img-block img-a" src="<?php echo $img_front_pre.$image; ?>" alt="<?php echo $this->product_details->prod_no?>">
													</a>
													<div style="margin-top:200px;">
														<p>
															<input type="checkbox" class="fav_checkbox-prod_id <?php echo $classes2; ?>" name="fav_prod_id" id="fav_<?php echo $this->product_details->prod_id; ?>" value="<?php echo $this->product_details->prod_id; ?>" data-prod_no="<?php echo $this->product_details->prod_no; ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>" style="float:right;" <?php echo (@$this->sales_user_details->options['selected'] && in_array($this->product_details->prod_no, $this->sales_user_details->options['selected'])) ? 'checked' : ''; ?>/>
															
															<?php echo $this->product_details->prod_no; ?></br>
															$ <?php echo number_format($this->product_details->wholesale_price, 2) ; ?>
														</p>
													</div>
												</div>
												
															<?php 
														}
													}
												} 
												else 
												{ ?>
												<p style="margin-top:50px;font-size:1.2em;">
												Start sending linesheets to populate your favorites
												</p>
												
												<?php } ?>
											
											</div>
											
										</div>

									</div>
									
									<?php
									/**********
									 * Product listing for selection
									 */
									?>
									<div class="v-cart-cartdetail">
										<h6 class="section-heading">Product List</h6>
										Select items here...
										<br /><br />
										<?php $this->load->view($this->webspace_details->options['theme'].'/sales/sales_package_view_products_grid_for_linesheet', $this->data); ?>
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
					$('.selected-linsheet-items').on('click', '.s_checkbox-prod_id', function() {
						$('#modal-loading .modal-title').html('Removing...');
						$('#modal-loading').show();
						// by default, items clicked here is for removal from the selected items
						// unselect item at favs list
						$('#fav_'+$(this).data('prod_id')).removeClass('selected');
						$('#fav_'+$(this).data('prod_id')).attr('checked', false);
						// unselect item at products list
						$('#'+$(this).data('prod_id')).removeClass('selected');
						$('#'+$(this).data('prod_id')).attr('checked', false);
						// send ajax call to remove item from selected list
						$.ajax({
							type:    "POST",
							url:     "<?php echo site_url('sales/sales_linesheet_addrem'); ?>",
							data:    {
								"action":"rem_item",
								"id":"<?php echo $this->sales_user_details->admin_sales_id; ?>",
								"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
								"prod_no":$(this).data('prod_no'),
								"prod_id":$(this).data('prod_id')
							},
							success: function(data) {
								//alert('call back');
								$('.selected-linsheet-items').html('');
								$('.selected-linsheet-items').html(data);
							},
							// vvv---- This is the new bit
							error:   function(jqXHR, textStatus, errorThrown) {
								$('#modal-loading').show();
								location.reload();
								//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
							}
						}).done(function(){
							// check if items count is zero again or not
							// then hide the user registration and list
							if ($('#items_count').val() == 0) {
								$('#ws-user-list').hide();
								$('#ws-user-registration').hide();
							}
							$('#modal-loading').hide();
						});
						$('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
					});
					$('.favorites-items').on('click', '.fav_checkbox-prod_id', function(){
						if ($('#items_count').val() < 10 || $(this).hasClass('selected'))
						{
							$(this).toggleClass('selected');
							// set checked attribute
							if ($(this).hasClass('selected')){
								$(this).attr('checked', true);
								// set checked attribute at product list
								$('#'+$(this).data('prod_id')).addClass('selected');
								$('#'+$(this).data('prod_id')).attr('checked', true);
							}else{
								$(this).attr('checked', false);
								// set checked attribute at product list
								$('#'+$(this).data('prod_id')).removeClass('selected');
								$('#'+$(this).data('prod_id')).attr('checked', false);
							}
							// load modal
							if ($(this).hasClass('selected')) $('#modal-loading .modal-title').html('Adding...');
							else $('#modal-loading .modal-title').html('Removing...');
							$('#modal-loading').show();
							// set action
							var action = 'rem_item';
							if ($(this).hasClass('selected')) action = 'add_item';
							// ajax call
							$.ajax({
								type:    "POST",
								url:     "<?php echo site_url('sales/sales_linesheet_addrem'); ?>",
								data:    {
									"action":action,
									"id":"<?php echo $this->sales_user_details->admin_sales_id; ?>",
									"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
									"prod_no":$(this).data('prod_no'),
									"prod_id":$(this).data('prod_id')
								},
								success: function(data) {
									//alert('call back');
									$('.selected-linsheet-items').html('');
									$('.selected-linsheet-items').html(data);
									// check if items count is zero again or not
									// then hide the user registration and list
									if ($('#items_count').val() == 0) {
										$('#ws-user-list').hide();
										$('#ws-user-registration').hide();
									}
									//$('#modal-loading').hide();
								},
								// vvv---- This is the new bit
								error:   function(jqXHR, textStatus, errorThrown) {
									//$('#modal-loading').hide();
									location.reload();
									//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
								}
							}).done(function(){
								// ajax call
								$.ajax({
									type:    "GET",
									url:     "<?php echo site_url('sales/sales_update_favorites'); ?>",
									success: function(data) {
										//alert('call back');
										$('.favorites-items').html('');
										$('.favorites-items').html(data);
										$('#modal-loading').hide();
									},
									// vvv---- This is the new bit
									error:   function(jqXHR, textStatus, errorThrown) {
										//$('#modal-loading').hide();
										location.reload();
										//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
									}
								});
							});
						}else{
							alert('Maximum of 10 items only.');
						}
					});
					</script>
