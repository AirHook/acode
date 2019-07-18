								<?php if (@$file == 'themes_options') { ?>
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
												 * TITLE Block
												 */
												?>
												<div class="copy-container tablet-only">
													<div class="title-block">
													
														<?php if (@$homepage_options['one']['one_title1'] AND $homepage_options['one']['one_title1'] != '&nbsp;'): ?>
														
														<h1><?php echo (@$homepage_options['one']['one_title1'] AND $homepage_options['one']['one_title1'] != '&nbsp;') ? $homepage_options['one']['one_title1'] : '<span style="color:#fafafa;">Lorem</span>'; ?> <i><?php echo (@$homepage_options['one']['one_title2'] AND $homepage_options['one']['one_title2'] != '&nbsp;') ? $homepage_options['one']['one_title2'] : '<span style="color:#efefef;">Ipsum</span>'; ?></i></h1>
														
														<?php else: ?>
														
														<h1>Lorem <i>Ipsum</i></h1>
														
														<?php endif; ?>
														
													</div>
													<div class="copy-block hide-mobile">
													
														<?php if (@$homepage_options['one']['one_text1'] AND @$homepage_options['one']['one_text1'] != '&nbsp;'): ?>
														
														<p>
															<?php echo @$homepage_options['one']['one_text1'] ? $homepage_options['one']['one_text1'] : '<span style="color:#8d8d8d;">Lorem ipsum dolor sit amet...</span>'; ?>
														</p>
														
														<?php else: ?>
														
														<p>
															Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. - Edit this text at admin...
														</p>
														
														<?php endif; ?>
														
													</div>
												</div>
												
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
													
													<?php if ($qry1->num_rows() > 0): ?>
													
													<div class="fadeslideshow_wrapper hide-mobile">
														<div id="fadeshow_one" class="fadeslideshow_container">
															<ul>
																
																<?php foreach($qry1->result_array() as $row): ?>
																
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

														<?php
														/**********
														 * Using the picturefill javascript
														 */
														?>
														<a href="<?php echo @$homepage_options['one']['image_link'] ? $homepage_options['one']['image_link'] : site_url(); ?>">
															<picture>
															
																<source srcset="<?php echo (@$homepage_options['one']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['one']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image'] : base_url().'assets/themes/roden2/images/051016_may_01.jpg'; ?>" media="(min-width: 768px)" />
																
																<source srcset="<?php echo (@$homepage_options['one']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['one']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_01.jpg'; ?>" media="(max-width: 767px)" />
																
																<img class="not-loaded" src="<?php echo @$homepage_options['one']['image'] ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image'] : base_url().'assets/themes/roden2/images/051016_may_01.jpg'; ?>" alt="" style="width:100%;" />
																
															</picture>
														</a>
														
													</div>
													
													<?php endif; ?>
													
													<?php if ($qrym1->num_rows() > 0): ?>
													
													<div class="fadeslideshow_wrapper mobile-only">
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
													
													<div class="mobile-only">

														<?php
														/**********
														 * Using the picturefill javascript
														 */
														?>
														<a href="<?php echo @$homepage_options['one']['image_link'] ? $homepage_options['one']['image_link'] : site_url(); ?>">
															<picture>
															
																<source srcset="<?php echo (@$homepage_options['one']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['one']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image'] : base_url().'assets/themes/roden2/images/051016_may_mobile_01.jpg'; ?>" media="(min-width: 768px)" />
																
																<source srcset="<?php echo (@$homepage_options['one']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['one']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_01.jpg'; ?>" media="(max-width: 767px)" />
																
																<img class="not-loaded" src="<?php echo @$homepage_options['one']['image'] ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['one']['image'] : base_url().'assets/themes/roden2/images/051016_may_mobile_01.jpg'; ?>" alt="" />
																
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
													<div class="title-block hide-tablet">
													
														<?php if (@$homepage_options['one']['one_title1'] AND $homepage_options['one']['one_title1'] != '&nbsp;'): ?>
														
														<h1><?php echo (@$homepage_options['one']['one_title1'] AND $homepage_options['one']['one_title1'] != '&nbsp;') ? $homepage_options['one']['one_title1'] : '<span style="color:#fafafa;">Lorem</span>'; ?> <i><?php echo (@$homepage_options['one']['one_title2'] AND $homepage_options['one']['one_title2'] != '&nbsp;') ? $homepage_options['one']['one_title2'] : '<span style="color:#efefef;">Ipsum</span>'; ?></i></h1>
														
														<?php else: ?>
														
														<h1>Lorem <i>Ipsum</i></h1>
														
														<?php endif; ?>
														
													</div>
													<div class="copy-block hide-tablet">
													
														<?php if (@$homepage_options['one']['one_text1'] AND @$homepage_options['one']['one_text1'] != '&nbsp;'): ?>
														
														<p>
															<?php echo @$homepage_options['one']['one_text1'] ? $homepage_options['one']['one_text1'] : '<span style="color:#8d8d8d;">Lorem ipsum dolor sit amet...</span>'; ?>
														</p>
														
														<?php else: ?>
														
														<p>
															Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. - Edit this text at admin...
														</p>
														
														<?php endif; ?>
														
													</div>
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
								<?php } ?>
