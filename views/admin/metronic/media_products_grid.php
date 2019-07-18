									<?php
									/*********
									 * This style is adapted from the main style for tiles but changed
									 * for this grid view
									 */
									?>
									<br />
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
										margin-bottom: 10px;
										margin-left: 10px;
										font-weight: 400;
										font-size: 13px;
										color: #fff;
										line-height: 1em;
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
									
									<div class="thumb-tiles" data-row-count="">
									
										<?php 
										if ($media) 
										{
											$dont_display_thumb = '';
											$batch = '';
											$unveil = FALSE;
											$cnti = 0;
											foreach ($media as $item) 
											{
												
												// set image paths
												$img_view = $this->config->item('PROD_IMG_URL').$item->media_path.(str_replace('.jpg', '_'.$item->media_view[0].'_thumb.jpg', $item->media_filename));
												
												// after the first batch, hide the images
												if ($cnti > 0 && fmod($cnti, 100) == 0)
												{
													$dont_display_thumb = 'display:none;';
													$batch = 'batch-'.($cnti / 100);
													if (($cnti / 100) > 1) $unveil = TRUE;
												}
												
												// media name parts
												$parts1 = explode('_', $item->media_name);
												$prod_no = $parts1[0];
												$color_code = $parts1[1];
												
												// let set the classes and other items...
												$classes = $item->media_name;
												$classes.= $batch.' ';
												$classes.= ($item->media_name == '') ? 'mt-element-ribbon' : '';
												
												// let set the css style...
												$styles = $dont_display_thumb;
												?>
												
										<div class="thumb-tile image bg-blue-hoki <?php echo $classes; ?>" style="<?php echo $styles; ?>">
										
											<a href="javascript:;" class="modal-product_media_properties" 
												data-attached_to="<?php echo $item->attached_to; ?>" 
												data-prod_id="<?php echo $item->prod_id; ?>" 
												data-media_id="<?php echo $item->media_id; ?>" 
												data-media_name="<?php echo $item->media_name; ?>" 
												data-media_path="<?php echo $item->media_path; ?>" 
												data-media_dimensions="<?php echo $item->media_dimensions ?: 'No dimensions given'; ?>" 
												data-media_timestamp="<?php echo date('F d Y', $item->timestamp); ?>" 
												data-media_view="<?php echo @$item->media_view[0]; ?>" 
												data-upload_version="<?php echo $item->upload_version; ?>" 
												data-media_filename="<?php echo $item->media_filename; ?>">
											
												<?php if ($styles === TRUE) { ?>
												<div class="ribbon ribbon-shadow ribbon-round ribbon-border-dash ribbon-vertical-left ribbon-color-danger/info uppercase tooltips" data-placement="top" data-container="body" data-original-title="TITLE" style="position:absolute;left:-3px;width:28px;padding:1em 0;">
													<i class="fa fa-ban"></i>
												</div>
												<?php } ?>
												<div class="tile-body">
													<img class="img-unveil" <?php echo $unveil ? 'data-src="'.$img_view.'"' : 'src="'.$img_view.'"'; ?> alt=""> 
													<noscript>
														<img class="img-a" src="<?php echo $img_view; ?>" alt=""> 
													</noscript>
												</div>
												<div class="tile-object">
													<div class="name"> 
														<?php echo $prod_no; ?> <br />
														<?php echo $color_code; ?> <br />
														<em class="small"><?php echo ($item->media_view != 'others' ? ucfirst($item->media_view) : '').($item->upload_version ? '&nbsp; -u'.$item->upload_version : ''); ?></em>
													</div>
												</div>
												
											</a>
											
										</div>
										
											<?php 
											$cnti++;
											}
										}
										else
										{
											echo '<button class="btn default btn-block btn-lg"> NO MEDIA TO LOAD... </button>';
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
											echo '<button class="btn default btn-block btn-lg btn-'.$batch_it.'" onclick="$(\'.batch-'.($batch_it + 1).' .img-unveil\').trigger(\'unveil\');$(\'.btn-'.($batch_it + 1).' ,.batch-'.$batch_it.'\').show();$(this).hide();" style="display:none;"> LOAD MORE... </button>';
										}
									}
									
									// a fix for the float...
									echo '<button class="btn default btn-block btn-lg" style="visibility:hidden"> NO MORE TO LOAD... </button>';
									?>
