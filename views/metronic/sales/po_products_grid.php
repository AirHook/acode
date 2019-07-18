									<!-- BEGIN PRODUCT THUMGS GRID -->
									<div class="col col-md-12">

										<?php
										/*********
										 * This style is adapted from the main style for tiles but changed
										 * for this grid view
										 */
										?>
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
												margin: 0 10px 30px 0; /* from 10 to 30 add margin to bottom */
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

										<?php if ($search_string) { ?>
			                            <h1><small><em>Search results for:</em></small> "<?php echo $search_string; ?>"</h1>
			                            <br />
			                            <?php } ?>

										<div class="thumb-tiles" data-row-count="<?php echo $products_count; ?>">

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
													// the image filename
													$image = $product->prod_no.'_'.$product->primary_img_id.'_f3.jpg';
													$style_no = $product->prod_no.'_'.$product->color_code;
													// the new way relating records with media library
													$path_to_image = $product->media_path.$style_no.'_f3.jpg';
													$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
													$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
													$img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';

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
													if (in_array($style_no, $po_items))
													{
														$classes.= 'selected';
														$checkbox_check = 'checked';
													}
													if (
														in_array($product->prod_no, $po_items)
														&& $product->primary_img_id == $product->color_code
													)
													{
														$classes.= 'selected';
														$checkbox_check = 'checked';
													}

													// set class selected for if items has already been selected for the sales package
													//$classes.= in_array($product->prod_no, $sa_items) ? 'selected ' : '';
													?>

											<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" style="<?php echo $styles; ?>">

												<a href="<?php echo $img_linesheet; ?>" class="fancybox">

													<?php if ($product->publish == '0' OR $product->publish == '3' OR $product->view_status == 'N' OR $product->public == 'N') { ?>
													<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-<?php echo $ribbon_color; ?> uppercase tooltips" data-placement="top" data-container="body" data-original-title="<?php echo $tooltip; ?>" style="position:absolute;left:-3px;width:28px;padding:1em 0;">
														<i class="fa fa-ban"></i>
													</div>
													<?php } ?>

													<?php if ($product->with_stocks == '0') { ?>
													<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-right ribbon-color-danger uppercase tooltips" data-placement="top" data-container="body" data-original-title="Pre Order" style="position:absolute;right:-3px;width:28px;padding:1em 0;">
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
														<div class="name">
															<?php echo $product->prod_no; ?> <br />
															<?php echo $product->color_name; ?>
														</div>
													</div>

												</a>

												<div class="" style="color:red;font-size:0.9rem;">
													<span> Add to Puchase Order: </span>
													<input type="checkbox" class="package_items" name="prod_no[]" value="<?php echo $product->prod_no.'_'.$product->color_code; ?>" style="float:right;" <?php echo $checkbox_check; ?> data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}' />
												</div>

											</div>

												<?php
												$cnti++;
												}
											}
											else
											{
												if ($search_string) $txt1 = 'SEARCH DID NOT YIELD PRODUCT RESULTS...';
												else $txt1 = 'NO PRODUCTS TO LOAD...';
												echo '<button class="btn default btn-block btn-lg"> '.$txt1.' </button>';
											}
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
												echo '<button class="btn default btn-block btn-lg btn-'.$batch_it.'" onclick="$(\'.batch-'.($batch_it + 1).' .img-unveil\').trigger(\'unveil\');$(\'.btn-'.($batch_it + 1).' ,.batch-'.$batch_it.'\').show();$(this).hide();'.(($batch_it + 1) > ($cnti / 100) ? '$(\'.no-more-to-load\').show()' : '').'" style="display:none;"> LOAD MORE... </button>';
											}

											echo '<button class="btn default btn-block btn-lg no-more-to-load" style="display:none;"> NO MORE TO LOAD... </button>';
										}

										// a fix for the float...
										echo '<button class="btn default btn-block btn-lg" style="visibility:hidden"> NO MORE TO LOAD... </button>';
										?>

									</div>
									<!-- END PRODUCT THUMGS GRID -->
