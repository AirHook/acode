                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-leaf font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp sbold"><?php echo $this->category_details->category_name; ?></span>
                            </div>
							<div class="actions btn-set">
								<div class="btn-group">
									<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Select another category...
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu">
										<?php if ($categories) { ?>
										<?php foreach ($categories as $category) { ?>
										<?php if ($category->category_id !== $this->uri->segment(4) && $category->category_id !== '1') { ?>
										
										<li>
											<a href="<?php echo site_url('sales/select_items/index/'.$category->category_id.($this->uri->segment(5) ? '/'.$this->uri->segment(5) : '')); ?>"> <?php echo $category->category_name; ?> </a>
										</li>
										
										<?php } ?>
										<?php } ?>
										<?php } ?>
									</ul>
								</div>
						</div>
                        </div>
                        <div class="portlet-body">
						
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
										$img_linesheet_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$product->d_url_structure.'/'.$product->sc_url_structure.'/product_linesheet/';
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
										$classes.= ($product->publish != '0' && $product->publish != '3' && $product->view_status != 'N') ? 'grid ' : '';
										$classes.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') ? 'mt-element-ribbon ' : '';
										$classes.= @in_array($product->prod_no, @$items) ? 'selected ' : '';
										
										// let set the css style...
										$styles = $dont_display_thumb;
										$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';
										
										// ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
										$ribbon_color = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'danger' : 'info';
										$tooltip = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'Unpubished' : 'Private';
										?>
										
								<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" data-unpublish="<?php echo ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'Unpublished' : 'Published'; ?>" data-sku="<?php echo $product->prod_no.'_'.$product->primary_img_id; ?>" data-prod_no="<?php echo $product->prod_no; ?>" data-prod_id="<?php echo $product->prod_id; ?>" style="<?php echo $styles; ?>">
								
									<?php if ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') { ?>
									<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-<?php echo $ribbon_color; ?> uppercase tooltips" data-placement="top" data-container="body" data-original-title="<?php echo $tooltip; ?>" style="position:absolute;left:-3px;width:28px;padding:1em 0;">
										<i class="fa fa-ban"></i>
									</div>
									<?php } ?>
									<div class="corner"> </div>
									<div class="check"> </div>
									<div class="tile-body <?php echo $classes; ?>" data-sku="<?php echo $product->prod_no.'_'.$product->primary_img_id; ?>" data-prod_no="<?php echo $product->prod_no; ?>" data-prod_id="<?php echo $product->prod_id; ?>" style="<?php echo $styles; ?>">
										<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.$img_back_pre.$image.'"' : 'src="'.$img_back_pre.$image.'"'; ?> alt=""> 
										<img class="img-a img-unveil" <?php echo $unveil ? 'data-src="'.$img_front_pre.$image.'"' : 'src="'.$img_front_pre.$image.'"'; ?> alt=""> 
										<noscript>
											<img class="img-b" src="<?php echo $img_back_pre.$image; ?>" alt=""> 
											<img class="img-a" src="<?php echo $img_front_pre.$image; ?>" alt=""> 
										</noscript>
									</div>
									<div class="tile-object">
										<div class="name"> <?php echo $product->prod_no; ?> </div>
										<div class="number" title="View Linesheet"> 
											<a href="<?php echo $img_linesheet_pre.$product->prod_no.'_'.$product->primary_img_id.'.jpg'; ?>" class="fancybox-button" data-fancybox="product_tile_group" data-rel="fancybox-button" rel="nofollow">
												<i class="fa fa-search"></i> 
											</a>
										</div>
									</div>
									
									<a href="javascript:;" class="btn blue btn-bloxk mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left">Clear selected items</a>
								</div>
								
									<?php 
									$cnti++;
									}
								}
								else echo '<h3>No products</h3>';
								?>
							
							</div>
							
							<?php
							if (@$cnti > 100)
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
					$('.thumb-tile.grid .tile-body').click(function(){
						if ($('#items_count').val() < 30 || $(this).hasClass('selected'))
						{
							$(this).closest('.thumb-tile').toggleClass('selected');
							$(this).toggleClass('selected');
							if ($(this).hasClass('selected')) $('#loading .modal-title').html('Adding...');
							else $('#loading .modal-title').html('Removing...');
							$('#loading').modal('show');
							var action = 'rem_item';
							if ($(this).hasClass('selected')) action = 'add_item';
							$.ajax({
								type:    "POST",
								url:     "<?php echo $linesheet_sending_only ? site_url('sales/sales_linesheet_addrem') : site_url('sales/sales_front_addrem'); ?>",
								data:    {
									"action":action,
									"id":"<?php echo $linesheet_sending_only ? @$this->sales_user_details->admin_sales_id : @$this->sales_package_details->sales_package_id; ?>",
									"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
									"sku":$(this).data('sku'),
									"prod_no":$(this).data('prod_no'),
									"prod_id":$(this).data('prod_id')
								},
								success: function(data) {
									<?php
									if (
										empty($this->sales_user_details->options['selected'])
										OR @$this->sales_package_details->items_count == 0
									)
									{ ?>
										$('.select_items_first').hide();
										$('.send_package_next').show();
										<?php
									}
									?>
									$('.thumb-tiles.sales-package').html('');
									$('.thumb-tiles.sales-package').html('');
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
