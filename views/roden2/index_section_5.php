										<?php
										/**********
										 * Fifth image container
										 * Boxed grid single image
										 */
										?>
										<div class="container-five <?php echo $this->config->item('site_slug') ? 'tempoparis' : 'hidden'; ?>"><!-- hidden, used only for tempo for now -->
											<div class="inner">
												<div class="image-block">
												
													<?php
													/**********
													 * Images size within this container is 1060 x 577
													 */
													?>
													
													<?php
													// get the sliders for container four
													$sel5 = "
														SELECT *
														FROM tbl_index_image
														WHERE
															template = '".$this->config->item('template')."'
															AND options = '5'
														ORDER BY seq ASC
													";
													$qry5 = $db->query($sel5);
													?>
													
													<?php if ($qry5->num_rows() > 0): ?>

													<div class="fadeslideshow_wrapper">
														<div id="fadeshow_five" class="fadeslideshow_container">
															<ul>
																
																<?php foreach($qry5->result_array() as $row): ?>
																
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

													<a href="<?php echo @$homepage_options['five']['image_link'] ? $homepage_options['five']['image_link'] : site_url(); ?>">
														<img class="not-loaded" src="<?php echo (@$homepage_options['five']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['five']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['five']['image'] : base_url().'assets/themes/roden2/images/051016_may_07.jpg'; ?>" alt="" />
													</a>
													
													<?php endif; ?>
													
												</div>
												<div class="copy-container">
													<div class="cta-block">
														<a href="<?php echo (@$homepage_options['five']['five_button_link1'] AND @$homepage_options['five']['five_button_link1'] != '&nbsp;') ? $homepage_options['five']['five_button_link1'] : site_url(); ?>">
															<p class="cta">
																<span><?php echo (@$homepage_options['five']['five_button_text1'] AND @$homepage_options['five']['five_button_text1'] != '&nbsp;') ? $homepage_options['five']['five_button_text1'] : 'Shop back detail'; ?></span>
															</p>
														</a>
													</div>
													<!-- hidden -->
													<div class="copy-block products" style="display:none;">
														<p><a href="<?php echo site_url(); ?>">Amalia Gown</a> // <a href="<?php echo site_url(); ?>">Jensen Gown</a></p>
													</div>
												</div>
												<div class="mobile-only">
												
													<?php
													/**********
													 * Images size within this container is 600 x 886
													 */
													?>
													
													<?php
													// get the sliders for container four
													$selm5 = "
														SELECT *
														FROM tbl_index_image
														WHERE
															template = '".$this->config->item('template')."'
															AND options = 'm5'
														ORDER BY seq ASC
													";
													$qrym5 = $db->query($selm5);
													?>
													
													<?php if ($qrym5->num_rows() > 0): ?>

													<div class="fadeslideshow_wrapper">
														<div id="fadeshow_m5" class="fadeslideshow_container">
															<ul>
																
																<?php foreach($qrym5->result_array() as $row): ?>
																
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
													
													<a href="<?php echo @$homepage_options['five']['image_link'] ? $homepage_options['five']['image_link'] : site_url(); ?>">
														<img class="not-loaded" src="<?php echo (@$homepage_options['five']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['five']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['five']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_05.jpg'; ?>" alt="" />
													</a>
													
													<?php endif; ?>
													
													<div class="cta-block">
														<a href="<?php echo (@$homepage_options['five']['five_button_link1'] AND @$homepage_options['five']['five_button_link1'] != '&nbsp;') ? $homepage_options['five']['five_button_link1'] : site_url(); ?>">
															<p class="cta">
																<span><?php echo (@$homepage_options['five']['five_button_text1'] AND @$homepage_options['five']['five_button_text1'] != '&nbsp;') ? $homepage_options['five']['five_button_text1'] : 'Shop back detail'; ?></span>
															</p>
														</a>
													</div>
												</div>
											</div>
										</div>
										<!-- .container-four -->
