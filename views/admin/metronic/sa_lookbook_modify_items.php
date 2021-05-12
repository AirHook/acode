						<?php
						/***********
						 * Thumbs
						 */
						// calc width and height (2/3 = w/h)
						$imgw = '123';
						$imgh = (3*$imgw)/2;
						?>
						<style>
							.cart_basket .thumb-tiles {
								position: relative;
								margin-right: -10px;
							}
							.cart_basket .thumb-tiles .thumb-tile {
								display: block;
								float: left;
								width: <?php echo $imgw; ?>px !important; /*140px */
								height: <?php echo $imgh; ?>px; /*210px;*/
								cursor: pointer;
								text-decoration: none;
								color: #fff;
								position: relative;
								font-weight: 300;
								font-size: 12px;
								letter-spacing: .02em;
								line-height: 20px;
								/*overflow: hidden;*/	/* to show the checkbox at bottom */
								border: 4px solid transparent;
								margin: 0 10px 60px 0; /* from 10 to 45 add margin to bottom */
							}
							.cart_basket .thumb-tiles .thumb-tile.selected .corner::after {
								content: "";
								display: inline-block;
								border-left: 30px solid transparent;
								border-bottom: 30px solid transparent;
								border-right: 30px solid #67809F;
								position: absolute;
								top: -3px;
								right: -3px;
								z-index: 100;
							}
							.cart_basket .thumb-tiles .thumb-tile.selected .check::after {
								font-family: FontAwesome;
								font-size: 12px;
								content: "\f00c";
								color: white;
								position: absolute;
								top: -3px;
								right: 0px;
								z-index: 101;
							}
							.cart_basket .thumb-tiles .thumb-tile.image .tile-body {
								padding: 0 !important;
							}
							.cart_basket .thumb-tiles .thumb-tile .tile-body {
								height: 100%;
								vertical-align: top;
								padding: 10px;
								overflow: hidden;
								position: relative;
								font-weight: 400;
								font-size: 12px;
								color: #fff;
								margin-bottom: 5px; /* from 10 to 5 reduce to bring checkbox closer */
							}
							.cart_basket .thumb-tiles .thumb-tile.image .tile-body > img {
								width: 100%;
								height: auto;
								min-height: 100%;
								max-width: 100%;
							}
							.cart_basket .thumb-tiles .thumb-tile .tile-body img {
								margin-right: 10px;
							}
							.cart_basket .thumb-tiles .thumb-tile .tile-object {
								position: absolute;
								bottom: 0;
								left: 0;
								right: 0;
								min-height: 30px;
								background-color: transparent;
							}
							.cart_basket .thumb-tiles .thumb-tile .tile-object > .name {
								position: absolute;
								bottom: 0;
								left: 0;
								margin-bottom: 5px;
								margin-left: 10px;
								margin-right: 15px;
								font-weight: 400;
								font-size: 13px;
								color: #fff;
							}
							.img-a {
								position: absolute;
								left: 0;
								top: 0;
							}
							.img-b {
								position: absolute;
								left: 0;
								top: 0;
							}
						</style>

						<h4> LOOKBOOK <?php echo $sa_items_count ? '<span class="span_items_count">('.$sa_items_count.')</span>' : '<span class="span_items_count"></span>'; ?> ITEMS: </h4>
						<br />

						<?php
						/***********
						 * Selected Items Thumbs
						 */
						?>
						<div class="thumb-tiles sales-package lookbook clearfix" style="min-height:350px;max-height:600px;overflow-y:scroll;border:1px solid #ccc;margin-right:0px;background-color:#eee;padding:5px;">

							<?php
							if ( ! empty(@$sa_items))
							{
								$i = 2;
								foreach ($sa_items as $item => $options)
								{
									// get product details
									$exp = explode('_', $item);
									$product = $this->product_details->initialize(
										array(
											'tbl_product.prod_no' => $exp[0],
											'color_code' => $exp[1]
										)
									);

									if ( ! $product)
									{
										// a catch all system
										continue;
									}

									// set image paths
									$style_no = $item;
									$prod_no = $exp[0];
									$color_code = $exp[1];
									$color_name = $this->product_details->get_color_name($color_code);

									// the image filename
									$image = $product->media_path.$style_no.'_f3.jpg';
									$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
									if (@getimagesize($this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg'))
									{
										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
									}
									elseif (@getimagesize($this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg'))
									{
										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_s3.jpg';
									}
									else $img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';

									// set product logo
									if ( ! @getimagesize($this->config->item('PROD_IMG_URL').$product->designer_logo))
									{
										// get default logo folder
										$logo = base_url().'assets/images/logo/logo-'.$product->designer_slug.'.png';
									}
									else
									{
										$logo = $this->config->item('PROD_IMG_URL').$product->designer_logo;
									}

									// set some data
									$price = @$options[2] ?: 0;
									$size_names = $this->size_names->get_size_names($product->size_mode);
									$category = $this->categories_tree->get_name($options[1]); // get category name of category slug

									$show_price = @$sa_options['w_prices'] == 'Y' ? '' : "display-none";
									$show_sizes = @$sa_options['w_sizes'] == 'Y' ? '' : "display-none";
									?>

							<div class="lookbook-item " style="min-height:340px;padding:3%;border:1px solid #ccc;margin: 0 3px 8px;background:white;">
								<div class="pull-left" style="width:48%;position:relative;">
									<img src="<?php echo $img_front_new; ?>" style="width:100%;" />
									<img src="<?php echo $logo; ?>" style="position:absolute;top:5px;left:5px;width:100px;height:auto;" />
									<p style="color:white;position:absolute;top:83%;left:6px;font-size:90%;transform-origin: 0 0;transform:rotate(270deg);">
										<?php echo strtoupper($category); ?>
									</p>
									<p style="color:white;position:absolute;bottom:-10px;left:10px;font-size:60%;">
										<?php echo $prod_no; ?> &nbsp; &nbsp; <?php echo $color_name; ?> &nbsp; &nbsp;
										<span class="lb-items-w_prices <?php echo $show_price; ?>">
											$<?php echo $price; ?> &nbsp; &nbsp;
											<i class="fa fa-2x fa-pencil-square tooltips btn-edit_item_price" style="cursor:pointer;" data-original-title="Edit Price" data-item="<?php echo $item; ?>" data-price="<?php echo $price; ?>"></i>
										</span>
										<?php
										$i = 0;
										$span_size = FALSE; // assume initially there is no available sizes
										foreach ($size_names as $size_label => $s)
										{
											// do not show zero stock sizes
											if ($product->$size_label === '0') continue;

											// it is now assumed that this next size after is with stocks
											//<br />
											//Sizes: 0(2) 2(2) 4(6) 6(2) 12(2)
											if ($i === 0)
											{
												// this means there is a size with stock
												echo '<br class="lb-items-w_sizes '.$show_sizes.'" /><span class="lb-items-w_sizes '.$show_sizes.'">Sizes: ';
												$span_size = TRUE;
											}

											echo $s.'('.$product->$size_label.') ';

											$i++;
										}
										if ($span_size) echo '</span>';
										?>
									</p>
								</div>
								<div class="pull-right" style="width:48%;position:relative;">
									<img src="<?php echo $img_back_new; ?>" style="width:100%;" />
									<p style="color:white;position:absolute;bottom:-10px;right:10px;font-size:60%;">
										<?php echo $i; ?>
									</p>
									<p class="tooltips" data-original-title="Remove Item" data-placement="left" style="color:black;position:absolute;top:-12px;right:5px;cursor:pointer;">
										<i class="fa fa-2x fa-times-circle package_items" data-prod_no="<?php echo $prod_no; ?>" data-item="<?php echo $item; ?>" data-category_slug="<?php echo @$options[1] ?: ''; ?>" data-style_no="<?php echo $item; ?>" data-sku="<?php echo $style_no; ?>" data-page="modify"></i>
									</p>
								</div>
								<div class="clearfix"></div>
							</div>

									<?php
									$i = $i + 2;
								} ?>

							<input type="hidden" id="items_count" name="items_count" value="<?php echo $sa_items_count; ?>" />

								<?php
							}
							else
							{ ?>

							<input type="hidden" id="items_count" name="items_count" value="0" />
							<h3 class="" style="margin-bottom:100px;"> <cite>Selected items will show here...</cite> </h3>

								<?php
							} ?>

						</div>
