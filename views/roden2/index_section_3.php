										<?php
										/**********
										 * Third image container
										 * about Full width section
										 */
										?>
										<div class="container-three">
											<div class="inner" style="width:100%;">
												<div class="image-block">
												
													<?php
													/**********
													 * Images size within this container is 1260 x 754
													 */
													?>
													
													<?php
													// get the sliders for container one
													$sel3 = "
														SELECT *
														FROM tbl_index_image
														WHERE
															template = '".$this->config->item('template')."'
															AND options = '3'
														ORDER BY seq ASC
													";
													$qry3 = $db->query($sel3);
													?>
													
													<?php if ($qry3->num_rows() > 0): ?>

													<div class="fadeslideshow_wrapper hide-mobile">
														<div id="fadeshow_three" class="fadeslideshow_container">
															<ul>
																
																<?php foreach($qry3->result_array() as $row): ?>
																
																<li>
																	<?php if ($row['link'] != ''): ?>
																	<a href="<?php echo $row['link']; ?>" title="<?php echo $row['title']; ?>">
																	<?php endif; ?>
																	<img src="<?php echo base_url(); ?>assets/themes/roden2/uploads/sliders/<?php echo $row['image_name']; ?>" alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>" />
																	<?php if ($row['link'] != ''): ?>
																	</a>
																	<?php endif; ?>
																</li>
																
																<?php endforeach; ?>
																
															</ul>
														</div>
													</div>
													
													<?php else: ?>
													
													<div class="hide-mobile">
													
														<a href="<?php echo @$homepage_options['three']['image_link'] ? $homepage_options['three']['image_link'] : site_url(); ?>">
														
															<?php
															/**********
															 * Using the picturefill javascript
															 */
															?>
															<picture>
																
																<source srcset="<?php echo (@$homepage_options['three']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['three']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['three']['image'] : base_url().'assets/themes/roden2/images/051016_may_05.jpg'; ?>" media="(min-width: 768px)" />
																
																<source srcset="<?php echo (@$homepage_options['three']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['three']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['three']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_03.jpg'; ?>" />
																
																<img class="not-loaded" src="<?php echo (@$homepage_options['three']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['three']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['three']['image'] : base_url().'assets/themes/roden2/images/051016_may_05.jpg'; ?>" alt="" />
																
															</picture>
														</a>
													
													</div>
													
													<?php endif; ?>
													
													<?php
													/**********
													 * Images size within this container is 600 x 886
													 */
													?>
													
													<?php
													// get the sliders for container three
													$selm3 = "
														SELECT *
														FROM tbl_index_image
														WHERE
															template = '".$this->config->item('template')."'
															AND options = 'm3'
														ORDER BY seq ASC
													";
													$qrym3 = $db->query($selm3);
													?>
													
													<?php if ($qrym3->num_rows() > 0): ?>

													<div class="fadeslideshow_wrapper mobile-only">
														<div id="fadeshow_m3" class="fadeslideshow_container">
															<ul>
																
																<?php foreach($qrym3->result_array() as $row): ?>
																
																<li>
																	<?php if ($row['link'] != ''): ?>
																	<a href="<?php echo $row['link']; ?>" title="<?php echo $row['title']; ?>">
																	<?php endif; ?>
																	<img src="<?php echo base_url(); ?>assets/themes/roden2/uploads/sliders/<?php echo $row['image_name']; ?>" alt="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>" />
																	<?php if ($row['link'] != ''): ?>
																	</a>
																	<?php endif; ?>
																</li>
																
																<?php endforeach; ?>
																
															</ul>
														</div>
													</div>
													
													<?php else: ?>
													
													<div class="mobile-only">
													
														<a href="<?php echo @$homepage_options['three']['image_link'] ? $homepage_options['three']['image_link'] : site_url(); ?>">
														
															<?php
															/**********
															 * Using the picturefill javascript
															 */
															?>
															<picture>
																
																<source srcset="<?php echo (@$homepage_options['three']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['three']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['three']['image'] : base_url().'assets/themes/roden2/images/051016_may_05.jpg'; ?>" media="(min-width: 768px)" />
																
																<source srcset="<?php echo (@$homepage_options['three']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['three']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['three']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_03.jpg'; ?>" />
																
																<img class="not-loaded" src="<?php echo (@$homepage_options['three']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['three']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['three']['image'] : base_url().'assets/themes/roden2/images/051016_may_05.jpg'; ?>" alt="" />
																
															</picture>
														</a>
													
													</div>
													
													<?php endif; ?>
													
												</div>
												<div class="copy-container">
													<div class="title-block">
														<p class="large-text">
															<?php echo (@$homepage_options['three']['three_title1'] AND $homepage_options['three']['three_title1'] != '&nbsp;') ? $homepage_options['three']['three_title1'] : 'Make'; ?>
															<br /> <i><?php echo (@$homepage_options['three']['three_title2'] AND $homepage_options['three']['three_title2'] != '&nbsp;') ? $homepage_options['three']['three_title2'] : 'your own'; ?></i> 
															<br /><?php echo (@$homepage_options['three']['three_title3'] AND $homepage_options['three']['three_title3'] != '&nbsp;') ? $homepage_options['three']['three_title3'] : 'Creations'; ?>
														</p>
													</div>
													<div class="cta-block">
														<a href="<?php echo (@$homepage_options['three']['three_button_link1'] AND @$homepage_options['three']['three_button_link1'] != '&nbsp;') ? $homepage_options['three']['three_button_link1'] : site_url(); ?>">
															<p class="cta">
																<span><?php echo (@$homepage_options['three']['three_button_text1'] AND @$homepage_options['three']['three_button_text1'] != '&nbsp;') ? $homepage_options['three']['three_button_text1'] : 'Shop bridal dresses'; ?></span>
															</p>
														</a>
													</div>
													<!-- hidden -->
													<div class="copy-block products" style="display:none;">
														<p>
															<a href="<?php echo site_url(); ?>">Faymi Corset</a> &amp; <a href="<?php echo site_url(); ?>">Ahsan Skirt</a> //
															<br />
															<a href="<?php echo site_url(); ?>">Salene Taffeta Corset</a> &amp; <a href="<?php echo site_url(); ?>">Amora Skirt</a> //
															<br />
															<a href="<?php echo site_url(); ?>">Carina Corset</a> &amp; <a href="<?php echo site_url(); ?>">Maisey Skirt</a>
														</p>
													</div>
												</div>
											</div>
										</div>
										<!-- .container-three -->
		
