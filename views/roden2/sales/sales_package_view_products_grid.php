                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-leaf font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp sbold">Product List</span>
                            </div>
                        </div>
                        <div class="portlet-body">
						
							<!-- BEGIN FORM-->
							<!-- FORM =======================================================================-->
							<?php echo form_open('sales/set_active_designer_category'); ?>
							
							<input type="hidden" name="sales_package_id" value="<?php echo $this->sales_package_details->sales_package_id; ?>" />
							<input type="hidden" name="type_of_sending" value="<?php echo $file; ?>" />
							
							<div class="v-account-fields">
								<div class="pairinglist clearfix" >
									<ul class="pairings clearfix">

										<li class="pairing-designer pairinglist--centered pairing-required pairing-vertical pairing clearfix">
											<label class="primary page-text-body" for="vAccount-fields-designer-1">
												<span class="pairing-label">Designer</span>
											</label>
											<div class="pairing-content">
												<div class="pairing-controls"> 
													<div class="field">
														<select required="required" class="input-select" id="vAccount-fields-country-1" name="designer">
															<?php if ($designer_specific_defaults) { ?>

															<?php if ($designers) { ?>
															<?php foreach ($designers as $designer) { ?>
															<?php if ($designer->url_structure == $designer_specific_defaults && $designer->with_products == '1') { ?>
															<option value="<?php echo $designer->url_structure; ?>" <?php echo $d_url_structure == $designer->url_structure ? 'selected="selected"' : ''; ?>>
																<?php echo $designer->designer; ?>
															</option>
															<?php } ?>
															<?php } ?>
															<?php } ?>
															
															<?php } else { ?>
															
															<?php if ($designers) { ?>
															<?php foreach ($designers as $designer) { ?>
															<?php if ($designer->url_structure !== $this->webspace_details->slug && $designer->with_products == '1') { ?>
															<option value="<?php echo $designer->url_structure; ?>" <?php echo $d_url_structure == $designer->url_structure ? 'selected="selected"' : ''; ?>>
																<?php echo $designer->designer; ?>
															</option>
															<?php } ?>
															<?php } ?>
															<?php } ?>
															
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										</li>

										<li class="pairing-category pairinglist--centered pairing-required pairing-vertical pairing clearfix">
											<label class="primary page-text-body" for="vAccount-fields-category-1">
												<span class="pairing-label">Category</span>
											</label>
											<div class="pairing-content">
												<div class="pairing-controls"> 
													<div class="field">
														<select required="required" class="input-select" id="vAccount-fields-country-1" name="category" data-active_designer="<?php echo $d_url_structure; ?>">
															<option value="">Select a category..</option>
															<?php if ($designers) { ?>
															<?php foreach ($designers as $designer) { ?>
															<?php if ($designer->url_structure !== SITESLUG) { ?>
															<?php $des_categories = $this->categories->treelist(array('d_url_structure'=>$designer->url_structure)); ?>
															<?php if ($des_categories) { ?>
															<?php foreach ($des_categories as $category) { ?>
															<?php if ($category->category_slug != 'apparel' && $category->with_products > 0) { ?>
															<option class="all-options <?php echo $designer->url_structure; ?>" value="<?php echo $category->category_slug; ?>" <?php echo @$sc_slug == $category->category_slug ? 'selected="selected"' : ''; ?>>
																<?php echo $category->category_name; ?>
															</option>
															<?php } ?>
															<?php } ?>
															<?php } ?>
															<?php } ?>
															<?php } ?>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										</li>

									</ul>
								</div>
								<div style="text-align:center;">
									<button type="submit" name="apply_filter" class="button button--small--text button--<?php echo $this->webspace_details->slug; ?>" value="new" style="width:155px;margin-bottom:30px;" onclick="">
										Apply Filter
									</button>
								</div>
							</div>
							
							</form>
							<!-- End FORM ===================================================================-->
							<!-- END FORM-->
						
							<div class="thumb-tiles" data-products-count="<?php echo $products_count; ?>">
							
								<?php 
								if ($products) 
								{
									$dont_display_thumb = '';
									$batch = '';
									$unveil = FALSE;
									$cnti = 0;
									foreach ($products as $product) 
									{
										
										// set image paths
										$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$product->d_url_structure.'/'.$product->sc_url_structure.'/product_front/thumbs/';
										$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$product->d_url_structure.'/'.$product->sc_url_structure.'/product_back/thumbs/';
										// the image filename
										$image = $product->prod_no.'_'.$product->primary_img_id.'_3.jpg';
										
										// after the first batch, hide the images
										if ($cnti > 0 && fmod($cnti, 100) == 0)
										{
											$dont_display_thumb = 'display:none;';
											$batch = 'batch-'.($cnti / 100);
											if (($cnti / 100) > 1) $unveil = TRUE;
										}
										
										// let set the classes and other items...
										$classes = $product->prod_no.'_'.$product->primary_img_id.' ';
										$classes.= $batch.' ';
										$classes2 = in_array($product->prod_no, $this->sales_package_details->items) ? 'selected ' : '';
										
										// let set the css style...
										$styles = $dont_display_thumb;
										$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';
										?>
										
											<div class="product-line-item__image thumb <?php echo $classes; ?>" style="width:130px;height:auto;position:relative;<?php echo $styles; ?>">
												<a href="javascript:void(0);" title="">
													<img class="product-browse-s img-block img-b img-unveil" <?php echo $unveil ? 'data-src="'.$img_back_pre.$image.'"' : 'src="'.$img_back_pre.$image.'"'; ?>>
													<img class="product-browse-s img-block img-a img-unveil" <?php echo $unveil ? 'data-src="'.$img_front_pre.$image.'"' : 'src="'.$img_front_pre.$image.'"'; ?> alt="">
												</a>
												<div style="margin-top:200px;">
													<p>
														<input type="checkbox" class="checkbox-prod_id <?php echo $classes2; ?>" name="prod_id" id="<?php echo $product->prod_id; ?>" value="<?php echo $product->prod_id; ?>" data-prod_no="<?php echo $product->prod_no; ?>" data-prod_id="<?php echo $product->prod_id; ?>" style="float:right;" <?php echo in_array($product->prod_no, $this->sales_package_details->items) ? 'checked' : ''; ?>/>
														<?php echo $product->prod_no; ?><br />
														$ <?php echo number_format($product->wholesale_price, 2) ; ?>
													</p>
												</div>
											</div>
											
									<?php 
									$cnti++;
									}
								}
								?>
							
							</div>
							
							<?php
							if ($cnti > 100)
							{
								echo '
									<button class="button button--small--text button--'.$this->webspace_details->slug.'" onclick="$(\'img\').unveil();$(\'.batch-2 .img-unveil\').trigger(\'unveil\');$(\'.btn-2, .batch-1\').show();$(this).hide();"> LOAD MORE... </button>
								';
								
								for ($batch_it = 2; $batch_it <= ($cnti / 100); $batch_it++)
								{
									echo '<button class="button button--small--text button--'.$this->webspace_details->slug.' btn-'.$batch_it.'" onclick="$(\'.batch-'.($batch_it + 1).' .img-unveil\').trigger(\'unveil\');$(\'.btn-'.($batch_it + 1).' ,.batch-'.$batch_it.'\').show();$(this).hide();" style="display:none;"> LOAD MORE... </button>';
								}
							}
							
							// a fix for the float...
							echo '<button class="button button--small--text button--'.$this->webspace_details->slug.'" style="visibility:hidden"> NO MORE TO LOAD... </button>';
							?>
							
                        </div>
                    </div>
					
					<script>
					$('.checkbox-prod_id').click(function(){
						if ($('#items_count').val() < 30 || $(this).hasClass('selected'))
						{
							$(this).toggleClass('selected');
							// set checked attribute
							if ($(this).hasClass('selected')) $(this).attr('checked', true);
							else $(this).attr('checked', false);
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
								url:     "<?php echo site_url('sales/sales_front_addrem'); ?>",
								data:    {
									"action":action,
									"id":"<?php echo $this->sales_package_details->sales_package_id; ?>",
									"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
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
									$('#modal-loading').hide();
									location.reload();
									//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
								}
							});
						}else{
							alert('Maximum of 30 items only in a package.');
						}
					});
					</script>
