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
							<?php echo form_open(
								$this->config->slash_item('admin_folder').'campaigns/sales_package/edit/filter/'.$this->sales_package_details->sales_package_id
							); ?>
							
							<div class="row margin-bottom-30">
								<div class="col-xs-12 col-sm-3">
									<select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
										<?php if ($designers) { ?>
										<?php foreach ($designers as $designer) { ?>
										<?php 
										if (
											$this->webspace_details->options['site_type'] === 'hub_site'
											&& $designer->url_structure != $this->webspace_details->slug
											&& $designer->with_products === '1'
										) { 
										?>
										<option value="<?php echo $designer->url_structure; ?>" <?php echo $active_designer == $designer->url_structure ? 'selected="selected"' : ''; ?>>
											<?php echo $designer->designer; ?>
										</option>
										<?php } else if (
											$this->webspace_details->options['site_type'] !== 'hub_site'
											&& (
												$designer->url_structure === $this->webspace_details->slug
												OR $designer->folder === $this->webspace_details->slug  // backwards compatibility for 'basix-black-label'
											)
											&& $designer->with_products === '1'
										) { ?>
										<option value="<?php echo $designer->url_structure; ?>" <?php echo $active_designer == $designer->url_structure ? 'selected="selected"' : ''; ?>>
											<?php echo $designer->designer; ?>
										</option>
										<?php } ?>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
								<div class="col-xs-12 col-sm-3">
									<div class="form-group">
										<div class="form-control height-auto categories-checkbox_treelist">
											<div class="category_treelist scroller" style="height:150px;" data-always-visible="1" data-handle-color="#637283">
												<ul class="list-unstyled">
											
												<?php
												/**********
												 * Load the categories as a list only
												 */
												if ($categories) {
												$ic = 1;
													foreach ($categories as $category) 
													{
														// set if 'uncategorized' is checked or not
														if (is_array($active_category)) $uncat_select = in_array(0, $active_category) ? 'checked': '';
														else $uncat_select = ($active_category == 0 OR $active_category == 'uncategorized') ? 'checked': '';
														
														// set select if category is already selected
														if (is_array($active_category)) $select = in_array($category->category_id, $active_category) ? 'checked': '';
														else $select = $active_category == $category->category_slug ? 'checked': '';
														
														if (($uncat_select OR ! $select)  && $ic == 1) 
														{ ?>
													<li>
														<label><input type="checkbox" name="categories[]" class="category_treelist 0" value="0" data-parent_category="0" data-category_slug="uncategorized" <?php echo $uncat_select; ?>> Uncategorized </label>
													</li>
															<?php
															$ic++;
														}
														?>
													
													<li>
														<label><input type="checkbox" name="categories[]" class="category_treelist <?php echo $category->category_id; ?>" value="<?php echo $category->category_id; ?>" data-parent_category="<?php echo $category->parent_category; ?>" data-category_slug="<?php echo $category->category_slug; ?>" <?php echo $select; ?>> <?php echo $category->category_name; ?> &nbsp; <em class="small">(<?php echo $category->category_slug; ?>)</em> </label>
													</li>
												
														<?php
													}
												}
												?>
												
												</ul>
											</div>
										</div>
										<cite class="help-block small"> Select as many categories you want. A certain category may show no products for specific designers. Uncheck all to get all products. </cite>
									</div>
								</div>
								<div class="col-xs-12 col-sm-3">
									<select class="form-control bs-select" name="order_by">
										<option value="prod_date" <?php echo $order_by == 'prod_date' ? 'selected="selected"': ''; ?>> Newest to Oldest </option>
										<option value="seque" <?php echo $order_by == 'seque' ? 'selected="selected"': ''; ?>> Ordering </option>
									</select>
								</div>
								<div class="col-xs-12 col-sm-3">
									<input class="btn btn-primary" type="submit" name="filter_proucts" value="Apply Filter" />
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
										// the old ways dependent on category and folder structure
										$image = $product->prod_no.'_'.$product->primary_img_id.'_3.jpg';
										// the new way relating records with media library
										$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$product->media_name.'_f3.jpg';
										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$product->media_name.'_b3.jpg';
										
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
										$classes.= ($product->publish != '0' && $product->publish != '3' && $product->view_status != 'N') ? 'grid ' : '';
										$classes.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') ? 'mt-element-ribbon ' : '';
										$classes.= in_array($product->prod_no, $this->sales_package_details->items) ? 'selected ' : '';
										
										// let set the css style...
										$styles = $dont_display_thumb;
										$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';
										
										// ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
										$ribbon_color = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'danger' : 'info';
										$tooltip = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'Unpubished' : 'Private';
										?>
										
								<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" data-unpublish="<?php echo ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'Unpublished' : 'Published'; ?>" data-sku="<?php echo $product->prod_no.'_'.$product->primary_img_id; ?>" data-prod_no="<?php echo $product->prod_no; ?>" data-prod_id="<?php echo $product->prod_id; ?>" style="<?php echo $styles; ?>" data-primary_img="<?php echo $product->primary_img; ?>">
								
									<?php if ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') { ?>
									<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-<?php echo $ribbon_color; ?> uppercase tooltips" data-placement="top" data-container="body" data-original-title="<?php echo $tooltip; ?>" style="position:absolute;left:-3px;width:28px;padding:1em 0;">
										<i class="fa fa-ban"></i>
									</div>
									<?php } ?>
									<div class="corner"> </div>
									<div class="check"> </div>
									<div class="tile-body">
										<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt=""> 
										<img class="img-a img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"' : 'src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'; ?> alt=""> 
										<noscript>
											<img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt=""> 
											<img class="img-a" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt=""> 
										</noscript>
									</div>
									<div class="tile-object">
										<div class="name"> <?php echo $product->prod_no; ?> </div>
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
									<button class="btn default btn-block btn-lg" onclick="$(\'img\').unveil();$(\'.batch-2 .img-unveil\').trigger(\'unveil\');$(\'.btn-2, .batch-1\').show();$(this).hide();"> LOAD MORE... </button>
								';
								
								for ($batch_it = 2; $batch_it <= ($cnti / 100); $batch_it++)
								{
									echo '<button class="btn default btn-block btn-lg btn-'.$batch_it.'" onclick="$(\'.batch-'.($batch_it + 1).' .img-unveil\').trigger(\'unveil\');$(\'.btn-'.($batch_it + 1).' ,.batch-'.$batch_it.'\').show();$(this).hide();" style="display:none;"> LOAD MORE... </button>';
								}
							}
							
							// a fix for the float...
							echo '<button class="btn default btn-block btn-lg" style="visibility:hidden"> NO MORE TO LOAD... </button>';
							?>
							
                        </div>
                    </div>
					
					<script>
					$('.thumb-tile.grid').click(function(){
						if ($('#items_count').val() < 30 || $(this).hasClass('selected'))
						{
							$(this).toggleClass('selected');
							if ($(this).hasClass('selected')) $('#loading .modal-title').html('Adding...');
							else $('#loading .modal-title').html('Removing...');
							$('#loading').modal('show');
							var action = 'rem_item';
							if ($(this).hasClass('selected')) action = 'add_item';
							$.ajax({
								type:    "POST",
								url:     "<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/addrem'); ?>",
								data:    {
									"action":action,
									"id":"<?php echo $this->sales_package_details->sales_package_id; ?>",
									"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
									"sku":$(this).data('sku'),
									"prod_no":$(this).data('prod_no'),
									"prod_id":$(this).data('prod_id')
								},
								success: function(data) {
									//alert('call back');
									$('.thumb-tiles.sales-package').html('');
									$('.thumb-tiles.sales-package').html(data);
									$('#loading').modal('hide');
								},
								// vvv---- This is the new bit
								error:   function(jqXHR, textStatus, errorThrown) {
									$('#reloading .modal-body .modal-body-text').html('');
									$('#reloading').modal('show');
									location.reload();
									//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
								}
							});
						}else{
							$('#items_count_notice').modal('show');
						}
					});
					</script>
