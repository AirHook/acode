						<style>
							.tiles .tile {
								width: 140px !important;
								height: 210px;
							}
							.thumb-tiles {
								position: relative;
								margin-right: -10px;
							}
							.thumb-tiles .thumb-tile {
								display: block;
								float: left;
								height: 180px; /*210px;*/
								width: 120px !important; /*140px */
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
								margin: 0 10px 45px 0; /* from 10 to 45 add margin to bottom */
							}
							.thumb-tiles .thumb-tile.selected .corner::after {
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
							.thumb-tiles .thumb-tile.selected .check::after {
								font-family: FontAwesome;
								font-size: 12px;
								content: "\f00c";
								color: white;
								position: absolute;
								top: -3px;
								right: 0px;
								z-index: 101;
							}
							.thumb-tiles .thumb-tile.image .tile-body {
								padding: 0 !important;
							}
							.thumb-tiles .thumb-tile .tile-body {
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
							.thumb-tiles .thumb-tile.image .tile-body > img {
								width: 100%;
								height: auto;
								min-height: 100%;
								max-width: 100%;
							}
							.thumb-tiles .thumb-tile .tile-body img {
								margin-right: 10px;
							}
							.thumb-tiles .thumb-tile .tile-object {
								position: absolute;
								bottom: 0;
								left: 0;
								right: 0;
								min-height: 30px;
								background-color: transparent;
							}
							.thumb-tiles .thumb-tile .tile-object > .name {
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

						<h4> <cite>THE ITEMS:</cite> </h4>
						<br />

						<?php
						/***********
						 * Selected Items Thumbs
						 */
						?>
						<div class="thumb-tiles sales-package clearfix">

							<?php
							if ( ! empty($sa_items))
							{
								foreach ($sa_items as $item)
								{
									// get product details
									$exp = explode('_', $item);
									if (count($exp) == 2)
									{
										$params = array(
											'tbl_product.prod_no'=>$exp[0],
											'color_code'=>$exp[1]
										);
									}
									else $params = array('tbl_product.prod_no'=>$exp[0]);
									$product = $this->product_details->initialize($params);

									$options_array =
										$this->session->sa_options
										? json_decode($this->session->sa_options, TRUE)
										: array()
									;
									$price = @$options_array['e_prices'][$item] ?: $product->wholesale_price;

									// the image filename
									$image = $product->prod_no.'_'.$product->primary_img_id.'_f3.jpg';
									$style_no = $product->prod_no.'_'.$product->color_code;
									// the new way relating records with media library
									$path_to_image = $product->media_path.$style_no.'_f3.jpg';
									$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
									$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';

									?>

							<div class="thumb-tile package image bg-blue-hoki <?php echo $this->product_details->prod_no.'_'.$product->primary_img_id; ?> selected" data-sku="<?php echo $product->prod_no.'_'.$product->primary_img_id; ?>" data-prod_no="<?php echo $product->prod_no; ?>" data-prod_id="<?php echo $product->prod_id; ?>">

								<a href="javascript:;">

									<div class="tile-body">
										<img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
										<img class="img-a" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
									</div>
									<div class="tile-object">
										<div class="name hide">
											<?php echo $product->prod_no; ?> <br />
											<?php echo $product->color_name; ?>
										</div>
									</div>

								</a>

								<div class="" style="color:black;line-height:1.2em;">
									<input type="checkbox" class="package_items" name="prod_no[]" value="<?php echo $product->prod_no.'_'.$product->color_code; ?>" style="float:right;margin-top:0px;" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}' checked />
									<?php echo $product->prod_no; ?> <br />
									<?php echo $product->color_name; ?> <br />
									<?php echo '$ &nbsp;'.number_format($price, 2); ?>
								</div>

							</div>

									<?php
								}
							}
							else
							{ ?>

							<input type="hidden" id="items_count" name="items_count" value="0" />
							<h3 class="hidden-xs hidden-sm">Selected items will show here... </h3>

								<?php
							} ?>

						</div>
