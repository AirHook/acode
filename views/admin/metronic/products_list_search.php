									<?php
									/*********
									 * This style a fix to the dropdown menu inside table-responsive table-scrollable
									 * datatables. Setting position to relative allows the main dropdown button to
									 * follow cell during responsive mode. A jquery is also needed on the button to
									 * toggle class to change back position to absolute so that the dropdown menu
									 * shows even on overflow.
									 *
									 * And some image tile fixes
									 */
									?>
									<style>
										.dropdown-fix {
											position: relative;
										}
										.thumb-tiles {
											position: relative;
											margin-right: 5px;
											margin-bottom: 5px;
											float: left;
										}
										.thumb-tiles .thumb-tile {
											display: block;
											float: left;
												height: 90px; /*135px;*/
												width: 60px !important; /*90px !important;*/
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
											/*margin: 0 10px 10px 0;*/
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
											/*margin-bottom: 10px;*/
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
												min-height: 20px;
											background-color: transparent;
										}
										.thumb-tiles .thumb-tile .tile-object > .name {
											position: relative;
											bottom: 0;
											left: 0;
											margin: 0 auto;
											font-weight: 300;
												font-size: 10px;
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

                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl-product_list_search" data-product_count="<?php echo @$products_count; ?>">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs hidden-sm"> <!-- counter --> </th>
                                                <th style="width:190px;"> Image </th>
                                                <th> Status </th>
                                                <th> Prod No </th>
                                                <th> Designer </th>
                                                <th class="hide"> Categories </th>
                                                <th> Product Name </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
											if ($products)
											{
												$i = 1;
												$unveil = FALSE;
												foreach ($products as $product)
												{
													// set image paths
													$pre_url =
														$this->config->item('PROD_IMG_URL')
														.'product_assets/WMANSAPREL/'
														.$product->d_url_structure.'/'
														.$product->sc_url_structure
													;
													$img_front_pre = $pre_url.'/product_front/thumbs/';
													$img_back_pre = $pre_url.'/product_back/thumbs/';
													$img_side_pre = $pre_url.'/product_side/thumbs/';
													// the image filename
													// the old ways dependent on category and folder structure
													$image = $product->prod_no.'_'.$product->primary_img_id.'_1.jpg';
													// the new way relating records with media library
													$new_pre_url = $this->config->item('PROD_IMG_URL').$product->media_path.$product->media_name;
													$img_front_new = $new_pre_url.'_f1.jpg';
													$img_back_new = $new_pre_url.'_b1.jpg';
													$img_side_new = $new_pre_url.'_s1.jpg';

													// after the first batch, hide the images through unveil
													if (($i / 25) > 1) $unveil = TRUE;
													?>

                                            <tr class="odd gradeX" onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
                                                <td class="hidden-xs hidden-sm">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="text-center"> <!-- Images -->
													<div class="thumb-tiles">
														<?php
														/*********
														 * Original thumb tile with image hover commented out
														 */
														?>
														<div class="thumb-tile image bg-blue-hoki">
															<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$product->prod_id); ?>">
																<div class="tile-body">
																	<!--
																	<img class="img-b img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
																	-->
																	<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"' : 'src="'.($product->primary_img ? $img_front_new : $img_front_pre.$image).'"'; ?> alt="">
																	<noscript>
																		<!--
																		<img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
																		-->
																		<img class="  " src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
																	</noscript>
																</div>
																<div class="tile-object">
																	<div class="name"> <?php //echo $product->prod_no; ?>Front </div>
																</div>
															</a>
														</div>
													</div>
													<div class="thumb-tiles">
														<div class="thumb-tile image bg-blue-hoki">
															<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$product->prod_id); ?>">
																<div class="tile-body">
																	<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_side_new : $img_side_pre.$image).'"' : 'src="'.($product->primary_img ? $img_side_new : $img_side_pre.$image).'"'; ?> alt="">
																</div>
																<div class="tile-object">
																	<div class="name"> <?php //echo $product->prod_no; ?>Side </div>
																</div>
															</a>
														</div>
													</div>
													<div class="thumb-tiles">
														<div class="thumb-tile image bg-blue-hoki">
															<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$product->prod_id); ?>">
																<div class="tile-body">
																	<img class="  img-unveil" <?php echo $unveil ? 'data-src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"' : 'src="'.($product->primary_img ? $img_back_new : $img_back_pre.$image).'"'; ?> alt="">
																</div>
																<div class="tile-object">
																	<div class="name"> <?php //echo $product->prod_no; ?>Back </div>
																</div>
															</a>
														</div>
													</div>
                                                </td>
												<!-- DOC: Remove "disabled-link disable-target" classes to enable the element -->
                                                <td> <!-- Publish -->
													<?php
													switch ($product->publish)
													{
														case '1':
														case '11':
														case '12':
															$label = 'success';
															$label_text = 'Public';
															break;
														case '2':
															$label = 'info';
															$label_text = 'Private';
															break;
														case '3':
															$label = 'warning';
															$label_text = 'Pending';
															break;
														case '0':
														default:
															$label = 'danger';
															$label_text = 'Unpublished';
													}
													?>
                                                    <span class="label label-sm label-<?php echo $label; ?>"> <?php echo $label_text; ?> </span>
												</td>
                                                <td>
													<?php echo $product->prod_no; ?> <br />
													<small>
														<a class="hidden_first_edit_link" style="display:none;" href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$product->prod_id); ?>"><cite>edit/view variants</cite></a>
													</small>
												</td>
                                                <td> <?php echo $product->designer; ?> </td>
                                                <td class="hide"> <?php //echo $product->designer; ?> </td>
                                                <td> <?php echo $product->prod_name; ?> </td>
                                                <td> <!-- Actions -->
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/edit/index/'.$product->prod_id); ?>">
														<i class="icon-pencil"></i> Edit </a>
                                                </td>
                                            </tr>

													<?php
													$i++;
												}
											} ?>

                                        </tbody>
                                    </table>
