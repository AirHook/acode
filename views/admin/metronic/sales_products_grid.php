									<div class="table-toolbar <?php echo @$role == 'sales' ? 'hide' : ''; ?>" style="margin-bottom:20px;">
										<div class="row">
											<div class="col-md-6 pull-right text-right">
												<div class="btn-group">

													<a class="btn btn-link" style="color:black;text-decoration:none;cursor:default;" disabled>
														View as:
													</a>
													<button type="button" class="btn blue btn-<?php echo $view_as == 'products_list' ? 'blue' : 'outline'; ?> tooltips btn-listgrid" data-view_as="products_list" data-container="body" data-placement="top" data-original-title="List View" style="margin-right:3px;">
														<i class="glyphicon glyphicon-list"></i>
													</button>
													<button type="button" class="btn blue btn-<?php echo $view_as == 'products_grid' ? 'blue' : 'outline'; ?> tooltips btn-listgrid" data-view_as="products_grid" data-container="body" data-placement="top" data-original-title="Grid View">
														<i class="glyphicon glyphicon-th"></i>
													</button>

												</div>
											</div>
										</div>
									</div>

									<?php
									/*********
									 * This style is adapted from the main style for tiles but changed
									 * for this grid view
									 */
									// calc width and height (2/3 = w/h)
									$imgw = '180';
									$imgh = (3*$imgw)/2;
									?>
									<style>
										.thumb-tiles {
											position: relative;
											margin-right: -10px;
										}
										.thumb-tiles .thumb-tile {
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
                                            margin: 0 10px 10px 0; /* from 10 to 30 add margin to bottom */
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
										.stock-select,
										.size-select {
											border: 0;
											font-size: 12px;
											width: 40px;
										   -webkit-appearance: none;
											-moz-appearance: none;
											appearance: none;
										}
										.stock-select:after,
										.size-select:after {
											content: "\f0dc";
											font-family: FontAwesome;
											color: #000;
										}
									</style>

									<div class="row">

										<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
										<div class="admin_product_thumbs_sidebar col col-md-2">
											<?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'sales_products_list_sidebar', $this->data); ?>
										</div>
										<!-- END PRODUCT THUMGS SIDEBAR -->

										<!-- BEGIN PRODUCT THUMGS GRID -->
										<div class="col col-md-10">

											<?php
						                    /***********
						                     * Top Pagination
						                     */
						                    ?>
						                    <?php if ( ! @$search) { ?>
						                    <div class="row margin-bottom-10">
						                        <div class="col-md-12 text-justify pull-right">
						                            <span style="<?php echo $this->pagination->create_links() ? 'position:relative;top:15px;' : ''; ?>">
						                                <?php if ($count_all == 0) { ?>
						                                Showing 0 records
						                                <?php } else { ?>
						                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
						                                <?php } ?>
						                            </span>
						                            <?php echo $this->pagination->create_links(); ?>
						                        </div>
						                    </div>
						                    <?php } ?>

											<div class="thumb-tiles" data-row-count="<?php echo $products_count; ?>">

												<?php
	        									if (@$products)
	        									{
	        										$dont_display_thumb = '';
	        										$batch = '';
	        										$unveil = FALSE;
	        										$cnti = 0;
	        										foreach ($products as $product)
	        										{
	        											// set image paths
	        											// the image filename
	        											$image = $product->prod_no.'_'.$product->primary_img_id.'_f3.jpg';
	        											$style_no = $product->prod_no.'_'.$product->color_code;
	        											// the new way relating records with media library
	        											$path_to_image = $product->media_path.$style_no.'_f3.jpg';
	        											$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
	        											$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
	                                                    $img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';

	        											// after the first batch, hide the images
	        											if ($cnti > 0 && fmod($cnti, 100) == 0)
	        											{
	        												$dont_display_thumb = 'display:none;';
	        												$batch = 'batch-'.($cnti / 100);
	        												if (($cnti / 100) > 1) $unveil = TRUE;
	        											}

	        											// let set the classes and other items...
	        											$classes = $product->prod_no.' ';
	        											$classes.= $style_no.' ';
	        											$classes.= $batch.' ';
	        											$classes.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') ? 'mt-element-ribbon ' : '';

	        											// let set the css style...
	        											$styles = $dont_display_thumb;
	        											$styles.= ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'cursor:not-allowed;' : '';

	                                                    // ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
	                                    				$ribbon_color = ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N') ? 'danger' : 'info';
	                                    				$tooltip = $product->publish == '3' ? 'Pending' : (($product->publish == '0' OR $product->view_status == 'N') ? 'Unpubished' : 'Private');

	        											// due to showing of all colors in thumbs list, we now consider the color code
	        											// we check if item has color_code. if it has only product number use the primary image instead
	        											$checkbox_check = '';
	                                                    if (isset($so_items[$style_no]))
	        											{
	        												$classes.= 'selected';
	        												$checkbox_check = 'checked';
	        											}

														// check if item is on sale
	                									$onsale = (@$product->clearance == '3' OR $product->custom_order == '3') ? TRUE : FALSE;

	                                                    // get options if any
	                                                    $color_options = json_decode($product->color_options, TRUE);
	        											?>

	        									<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" style="<?php echo $styles; ?>">

													<!--<a href="<?php echo $img_large; ?>" class="fancybox " data-original-title="Click to zoom">-->
	                                                <a href="javascript:;" class="package_items" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>" data-page="create">

	                                                    <?php if ($product->with_stocks == '0') { ?>
	        											<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-right ribbon-color-danger uppercase tooltips" data-placement="bottom" data-container="body" data-original-title="Pre Order" style="position:absolute;right:-3px;width:28px;padding:1em 0;">
	        												<i class="fa fa-ban"></i>
	        											</div>
	        											<?php } ?>

	        											<div class="corner"> </div>
	        											<div class="check"> </div>
	        											<div class="tile-body">
	        												<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.$img_back_new.'"' : 'src="'.$img_back_new.'"'; ?> alt="">
	        												<img class="img-a img-unveil" <?php echo $unveil ? 'data-src="'.$img_front_new.'"' : 'src="'.$img_front_new.'"'; ?> alt="">
	        												<noscript>
	        													<img class="img-b" src="<?php echo $img_back_new; ?>" alt="">
	        													<img class="img-a" src="<?php echo $img_front_new; ?>" alt="">
	        												</noscript>
	        											</div>
	        											<div class="tile-object">
	        												<div class="name">
	        													<?php echo $product->prod_no; ?> <br />
	        													<?php echo $product->color_name; ?> <br />
																<span style="<?php echo $onsale ? 'text-decoration:line-through;' : ''; ?>">
	                                                                $<?php echo $product->wholesale_price; ?>
	                                                            </span>
	                                                            <span style="color:pink;<?php echo $onsale ? '' : 'display:none;'; ?>">
	                                                                &nbsp;$<?php echo $product->wholesale_price_clearance; ?>
	                                                            </span>
	        												</div>
	        											</div>

	        										</a>

	        										<div class="hide" style="color:red;font-size:1rem;">
	                                                    <i class="fa fa-plus package_items so <?php echo $product->prod_no.'_'.$product->color_code; ?>" style="background:#ddd;line-height:normal;padding:1px 2px;margin-right:3px;" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"></i>
	                                                    <span class="text-uppercase package_items" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"> Create Sales Order </span>
	        										</div>
													<div class="hide" style="color:red;font-size:1rem;">
	                                                    <i class="fa fa-plus package_items po <?php echo $product->prod_no.'_'.$product->color_code; ?>" style="background:#ddd;line-height:normal;padding:1px 2px;margin-right:3px;" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"></i>
	                                                    <span class="text-uppercase package_items" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"> Create Purchase Order </span>
	        										</div>
													<div class="hide" style="color:red;font-size:1rem;">
	                                                    <i class="fa fa-plus package_items sa <?php echo $product->prod_no.'_'.$product->color_code; ?>" style="background:#ddd;line-height:normal;padding:1px 2px;margin-right:3px;" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"></i>
	                                                    <span class="text-uppercase package_items" data-item="<?php echo $product->prod_no.'_'.$product->color_code; ?>"> Create Sales Package </span>
	        										</div>

	        									</div>

	        										<?php
	        										$cnti++;
	        										}
	        									} ?>

											</div>

											<?php
						                    /***********
						                     * Bottom Pagination
						                     */
						                    ?>
						                    <?php if ( ! @$search && $count_all != 0) { ?>
						                    <div class="row margin-bottom-10">
						                        <div class="col-md-12 text-justify pull-right">
						                            <span>
						                                <?php if ($count_all == 0) { ?>
						                                Showing 0 records
						                                <?php } else { ?>
						                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all < ($limit * $page) ? $count_all : $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
						                                <?php } ?>
						                            </span>
						                            <?php echo $this->pagination->create_links(); ?>
						                        </div>
						                    </div>
						                    <?php } ?>

										</div>
										<!-- END PRODUCT THUMGS GRID -->

									</div>
