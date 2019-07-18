								<?php if (@$file == 'themes_options') { ?>
								<div style="width:480px;">
									<div class="homepage">
										<div class="roden-creative">
								<?php } ?>
									
										<?php
										/**********
										 * First image container
										 */
										?>
										<div class="container-one">
											<div class="inner">
											
												<?php
												/**********
												 * IMAGE Block
												 */
												?>
												<div class="image-block" style="<?php echo @$file == 'themes_options' ? 'width:54%;' : ''; ?>">
												
													<?php
													// note that this is only for roden theme
													// get the sliders for container one desktop and mobile
													$sel1 = "
														SELECT *
														FROM tbl_index_image
														WHERE
															template = '".$this->config->item('template')."'
															AND options = '1'
														ORDER BY seq ASC
													";
													$qry1 = $db->query($sel1);
													$selm1 = "
														SELECT *
														FROM tbl_index_image
														WHERE
															template = '".$this->config->item('template')."'
															AND options = 'm1'
														ORDER BY seq ASC
													";
													$qrym1 = $db->query($selm1);
													?>
													
													<?php if ($qrym1->num_rows() > 0): ?>
													
													<div class="fadeslideshow_wrapper mobile-only_">
														<div id="fadeshow_m1" class="fadeslideshow_container">
															<ul>
																
																<?php foreach($qrym1->result_array() as $row): ?>
																
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
													
													<div class="mobile-only_">

														<?php
														/**********
														 * Using the picturefill javascript
														 */
														?>
														<a href="<?php echo @$homepage_options['one']['image_link'] ? $homepage_options['one']['image_link'] : site_url(); ?>">
															<picture>
															
																<source srcset="<?php echo (@$homepage_options['one']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['one']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image'] : base_url().'assets/themes/roden2/images/051016_may_mobile_01.jpg'; ?>" media="(min-width: 768px)" />
																
																<source srcset="<?php echo (@$homepage_options['one']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['one']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_01.jpg'; ?>" media="(max-width: 767px)" />
																
																<img class="not-loaded" src="<?php echo @$homepage_options['one']['image'] ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image'] : base_url().'assets/themes/roden2/images/051016_may_mobile_01.jpg'; ?>" alt="" style="width:100%;" />
																
															</picture>
														</a>
														
													</div>
													
													<?php endif; ?>
													

												</div>
												
												<?php
												/**********
												 * Mobile
												 */
												?>
												<div class="copy-container mobile-cta">
													<div class="cta-block">
													
														<a href="<?php echo (@$homepage_options['one']['one_button_link1'] AND @$homepage_options['one']['one_button_link1'] != '&nbsp;') ? $homepage_options['one']['one_button_link1'] : site_url(); ?>">
															<p class="cta">
																<span><?php echo (@$homepage_options['one']['one_button_text1'] AND @$homepage_options['one']['one_button_text1'] != '&nbsp;') ? $homepage_options['one']['one_button_text1'] : 'Shop new'; ?></span>
															</p>
														</a>
													</div>
												</div>
											</div>
											<!-- .inner -->
										</div>
										<!-- .container-one -->
										
								<?php if (@$file == 'themes_options') { ?>
										</div>
									</div>
								</div>
								<?php } ?>
