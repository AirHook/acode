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

						<h4> PACKAGE ITEMS: </h4>
						<br />

						<?php
						/***********
						 * Selected Items Thumbs
						 */
						?>
						<div class="thumb-tiles sales-package clearfix">

							<?php
							if ( ! empty(@$sa_items))
							{
								$i_solo = 1;
								foreach ($sa_items as $item)
								{
									// get product details
									$exp = explode('_', $item);
									$product = $this->product_details->initialize(
										array(
											'tbl_product.prod_no' => $exp[0],
											'color_code' => $exp[1]
										)
									);

									// set image paths
									// the new way relating records with media library
									$style_no = $item;
									$prod_no = $exp[0];
									$color_code = $exp[1];

									// the image filename
									if ($product)
									{
										$image = $product->media_path.$style_no.'_f3.jpg';
										$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
										$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
										$img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
										$img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
										$color_name = $product->color_name;

										// set price
										$price =
											@$sa_options['e_prices'][$item]
											?: ($product->clearance == '3' OR $product->custom_order == '3')
												? $product->wholesale_price_clearance
												: $product->wholesale_price
										;
									}
									else
									{
										$image = 'images/instylelnylogo_3.jpg';
										$img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$img_back_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$img_large = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$img_linesheet = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
										$color_name = $this->product_details->get_color_name($color_code);

										// set price
										$price = @$sa_options['e_prices'][$item] ?: 0;
									}

									// check if item is on sale
									$onsale = ($product->clearance == '3' OR $product->custom_order == '3') ? TRUE : FALSE;

									$display_prices = @$sa_options['w_prices'] == 'N' ? 'display-none' : '';
									?>

							<div class="thumb-tile package image bg-blue-hoki <?php echo $style_no; ?> selected" data-sku="<?php echo $style_no; ?>" data-prod_no="<?php echo $prod_no; ?>" data-prod_id="<?php echo @$product->prod_id; ?>">

								<a href="javascript:;">

									<div class="tile-body">
										<img class="img-b img-unveil" src="<?php echo $img_back_new; ?>" alt="">
										<img class="img-a img-unveil" src="<?php echo $img_front_new; ?>" alt="">
									</div>
									<div class="tile-object">
										<div class="name hide">
											<?php echo $prod_no; ?> <br />
											<?php echo $color_name; ?>
										</div>
									</div>

								</a>

								<div class="" style="color:black;line-height:1.2em;">
									<input type="checkbox" class="package_items tooltips" data-original-title="Remove item" name="prod_no[]" data-page="create" value="<?php echo $style_no; ?>" style="float:right;margin-top:0px;" checked />
									<?php echo $prod_no; ?> <br />
									<?php echo $color_name; ?> <br />
									<div class="item_prices <?php echo $style_no; ?> <?php echo $display_prices; ?>">
										<span class="<?php echo $onsale ? '' : 'e_prices'; ?>" data-price="<?php echo $price; ?>" style="<?php echo $onsale ? 'text-decoration:line-through;' : ''; ?>">
											<?php echo '$'.number_format($price, 2); ?>
										</span>
										<span class="<?php echo $onsale ? 'e_prices' : ''; ?>" data-price="<?php echo $price; ?>" style="color:red;<?php echo $onsale ? '' : 'display:none;'; ?>">
											<?php echo '&nbsp;$'.number_format($product->wholesale_price_clearance, 2); ?>
										</span>
										<button type="button" data-item="<?php echo $item; ?>" class="btn btn-link btn-xs btn-edit_item_price tooltips" data-original-title="Edit Price" style="position:relative;top:-2px;"><i class="fa fa-pencil small"></i></button>
									</div>
								</div>

							</div>

									<?php

									if ($i_solo == 3) $i_solo = 1;
									else $i_solo++;
								}
							}
							else
							{ ?>

							<input type="hidden" id="items_count" name="items_count" value="0" />
							<h3 class="" style="margin-bottom:100px;"> <cite>Selected items will show here...</cite> </h3>

								<?php
							} ?>

						</div>
