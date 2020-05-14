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
									$imgw = '150';
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
											overflow: hidden;
											border: 4px solid transparent;
											margin: 0 10px 10px 0;
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
											margin-bottom: 10px;
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

									<div class="row">

										<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
										<div class="admin_product_thumbs_sidebar col col-md-2">
											<?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'products_list_sidebar', $this->data); ?>
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
						                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
						                            </span>
						                            <?php echo $this->pagination->create_links(); ?>
						                        </div>
						                    </div>
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
														$img_front_pre =
															$this->config->item('PROD_IMG_URL')
															.'product_assets/WMANSAPREL/'
															.$product->d_url_structure.'/'
															.$product->sc_url_structure
															.'/product_front/thumbs/'
														;
														$img_back_pre =
															$this->config->item('PROD_IMG_URL')
															.'product_assets/WMANSAPREL/'
															.$product->d_url_structure.'/'
															.$product->sc_url_structure
															.'/product_back/thumbs/'
														;
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
														// set ribbon for PRIVATE & UNPUBLISH items
														$classes.= $product->publish != '1' ? 'mt-element-ribbon' : '';

														// let set the css style...
														$styles = $dont_display_thumb;
														//$styles.= $product->publish != '1' ? 'cursor:not-allowed;' : '';

														// ribbon color - assuming that other an not published or pending (danger/unpublished), the item is private (info/private)
														$ribbon_color = $product->publish == '0' ? 'danger' : 'info';
														$tooltip = $product->publish == '3' ? 'Pending' : ($product->publish == '0' ? 'Unpubished' : 'Private');
														?>

												<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" style="<?php echo $styles; ?>">

													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$product->prod_id); ?>">

														<?php if ($product->publish != '1') { ?>
														<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-<?php echo $ribbon_color; ?> uppercase tooltips" data-placement="top" data-container="body" data-original-title="<?php echo $tooltip; ?>" style="position:absolute;left:-3px;width:28px;padding:1em 0;">
															<i class="fa fa-ban"></i>
														</div>
														<?php } ?>
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

													</a>

												</div>

													<?php
													$cnti++;
													}
												}
												else
												{
													echo '<button class="btn default btn-block btn-lg"> NO PRODUCTS TO LOAD... </button>';
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

											<?php
						                    /***********
						                     * Bottom Pagination
						                     */
						                    ?>
						                    <?php if ( ! @$search) { ?>
						                    <div class="row margin-bottom-10">
						                        <div class="col-md-12 text-justify pull-right">
						                            <span>
						                                Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $limit * $page; ?> of about <?php echo number_format($count_all); ?> records
						                            </span>
						                            <?php echo $this->pagination->create_links(); ?>
						                        </div>
						                    </div>
						                    <?php } ?>

										</div>
										<!-- END PRODUCT THUMGS GRID -->

									</div>
