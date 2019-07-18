										<?php
										/**********
										 * Fourth image container
										 */
										?>
										<div class="container-four <?php echo $this->config->item('site_slug') ? 'tempoparis' : 'hidden'; ?>"><!-- hidden used for tempo for now -->
											<div class="inner">
												<div class="left-half">
													<div class="copy-container">
														<div class="title-block hide-mobile">
															<p class="large-text">
																<?php echo (@$homepage_options['four']['four_title1'] AND $homepage_options['four']['four_title1'] != '&nbsp;') ? $homepage_options['four']['four_title1'] : 'Tempor'; ?> 
																<span class="one"><?php echo (@$homepage_options['four']['four_title2'] AND $homepage_options['four']['four_title2'] != '&nbsp;') ? $homepage_options['four']['four_title2'] : 'incidi'; ?></span>
																<?php echo (@$homepage_options['four']['four_title3'] AND $homepage_options['four']['four_title3'] != '&nbsp;') ? $homepage_options['four']['four_title3'] : 'dunt'; ?>
															</p>
														</div>
														<div class="copy-block hide-mobile">
															<p><?php echo (@$homepage_options['four']['four_text1'] AND $homepage_options['four']['four_text1'] != '&nbsp;') ? $homepage_options['four']['four_text1'] : 'Lace shorts / Lace skrits'; ?></p>
														</div>
														<div class="cta-block">
															<a href="<?php echo (@$homepage_options['four']['four_button_link1'] AND @$homepage_options['four']['four_button_link1'] != '&nbsp;') ? $homepage_options['four']['four_button_link1'] : site_url(); ?>">
																<p class="cta">
																	<span><?php echo (@$homepage_options['four']['four_button_text1'] AND @$homepage_options['four']['four_button_text1'] != '&nbsp;') ? $homepage_options['four']['four_button_text1'] : 'Shop accessories'; ?></span>
																</p>
															</a>
														</div>
													</div>
												</div>
												<div class="right-half">
													<div class="image-block" style="width:100%;">
													
														<?php
														/**********
														 * Images size within this container is 414 x 630
														 */
														?>
														
														<?php
														// get the sliders for container four
														$sel4 = "
															SELECT *
															FROM tbl_index_image
															WHERE
																template = '".$this->config->item('template')."'
																AND options = '4'
															ORDER BY seq ASC
														";
														$qry4 = $db->query($sel4);
														?>
														
														<?php if ($qry4->num_rows() > 0): ?>

														<div class="fadeslideshow_wrapper hide-mobile" style="max-width:414px;margin-left:20%;">
															<div id="fadeshow_four" class="fadeslideshow_container">
																<ul>
																	
																	<?php foreach($qry4->result_array() as $row): ?>
																	
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
													
															<a href="<?php echo @$homepage_options['four']['image_link'] ? $homepage_options['four']['image_link'] : site_url(); ?>">
															
																<?php
																/**********
																 * Using the picturefill javascript
																 */
																?>
																<picture>
																	
																	<source srcset="<?php echo (@$homepage_options['four']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['four']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['four']['image'] : base_url().'assets/themes/roden2/images/051016_may_06.jpg'; ?>" media="(min-width: 768px)" />
																	
																	<source srcset="<?php echo (@$homepage_options['four']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['four']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['four']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_04.jpg'; ?>" />
																	
																	<img class="not-loaded" src="<?php echo (@$homepage_options['four']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['four']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['four']['image'] : base_url().'assets/themes/roden2/images/051016_may_06.jpg'; ?>" alt="" />
																	
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
														// get the sliders for container four
														$selm4 = "
															SELECT *
															FROM tbl_index_image
															WHERE
																template = '".$this->config->item('template')."'
																AND options = 'm4'
															ORDER BY seq ASC
														";
														$qrym4 = $db->query($selm4);
														?>
														
														<?php if ($qrym4->num_rows() > 0): ?>

														<div class="fadeslideshow_wrapper mobile-only">
															<div id="fadeshow_m4" class="fadeslideshow_container">
																<ul>
																	
																	<?php foreach($qrym4->result_array() as $row): ?>
																	
																	<li>
																		<?php if ($row['link'] != ''): ?>
																		<a href="<?php echo $row['link']; ?>" title="<?php echo $row['title']; ?>">
																		<?php endif; ?>
																		<img src="<?php echo base_url(); ?>assets/themes/roden2/uploads/sliders/<?php echo $row['image_name']; ?>" title="<?php echo $row['title']; ?>" title="<?php echo $row['title']; ?>" />
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
													
															<a href="<?php echo @$homepage_options['four']['image_link'] ? $homepage_options['four']['image_link'] : site_url(); ?>">
															
																<?php
																/**********
																 * Using the picturefill javascript
																 */
																?>
																<picture>
																	
																	<source srcset="<?php echo (@$homepage_options['four']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['four']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['four']['image'] : base_url().'assets/themes/roden2/images/051016_may_06.jpg'; ?>" media="(min-width: 768px)" />
																	
																	<source srcset="<?php echo (@$homepage_options['four']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['four']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['four']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_04.jpg'; ?>" />
																	
																	<img class="not-loaded" src="<?php echo (@$homepage_options['four']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['four']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['four']['image'] : base_url().'assets/themes/roden2/images/051016_may_06.jpg'; ?>" alt="" />
																	
																</picture>
															</a>
															
														</div>
															
														<?php endif; ?>
														
													</div>
													<!-- hidden -->
													<div class="copy-block products hide-tablet" style="display:none;">
														<p><a href="<?php echo site_url(); ?>">Adelina Lace Veil</a></p>
													</div>
												</div>
											</div>
										</div>
										<!-- .container-four -->
		