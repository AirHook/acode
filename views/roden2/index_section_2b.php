												<?php
												/**********
												 * Bottom Row (section)
												 */
												?>
												<div class="bottom-half <?php echo $this->config->item('site_slug') ? 'tempoparis' : 'hidden'; ?>"><!-- hidden, used only for tempo for now -->
													<div class="left-half hide-mobile">
														<div class="image-block">
														
															<?php
															/**********
															 * Images size within this container is 559 x 826
															 */
															?>
															
															<?php
															// get the sliders for container one
															$sel2b = "
																SELECT *
																FROM tbl_index_image
																WHERE
																	template = '".$this->config->item('template')."'
																	AND options = '2b'
																ORDER BY seq ASC
															";
															$qry2b = $db->query($sel2b);
															?>
															
															<?php if ($qry2b->num_rows() > 0): ?>

															<div class="fadeslideshow_wrapper" style="padding:0px 40px;">
																<div id="fadeshow_two-b" class="fadeslideshow_container">
																	<ul>
																		
																		<?php foreach($qry2b->result_array() as $row): ?>
																		
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
															
															<a href="<?php echo @$homepage_options['two-b']['image_link'] ? $homepage_options['two-b']['image_link'] : site_url(); ?>">
																<img class="not-loaded" src="<?php echo (@$homepage_options['two-b']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-b']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-b']['image'] : base_url().'assets/themes/roden2/images/051016_may_03.jpg'; ?>" alt="" />
															</a>
															
															<?php endif; ?>
															
														</div>
														<div class="copy-container">
															<!-- hidden -->
															<div class="copy-block products" style="display:none;">
																<p>
																	<a href="<?php echo site_url(); ?>">Mara Jumpsuit</a> // <a href="<?php echo site_url(); ?>">Francine Top</a> &amp; <a href="<?php echo site_url(); ?>">Almira Skirt</a>
																</p>
															</div>
															<div class="cta-block">
																<a href="<?php echo (@$homepage_options['two']['two_button_link1'] AND @$homepage_options['two']['two_button_link1'] != '&nbsp;') ? $homepage_options['two']['two_button_link1'] : site_url(); ?>">
																	<p class="cta">
																		<span><?php echo (@$homepage_options['two']['two_button_text1'] AND @$homepage_options['two']['two_button_text1'] != '&nbsp;') ? $homepage_options['two']['two_button_text1'] : 'Shop gowns'; ?></span>
																	</p>
																</a>
															</div>
														</div>
													</div>
													<div class="right-half">
														<div class="inner">
															<div class="image-block">
															
																<?php
																/**********
																 * Images size within this container is 559 x 826
																 */
																?>
																
																<?php
																// get the sliders for container one
																$sel2c = "
																	SELECT *
																	FROM tbl_index_image
																	WHERE
																		template = '".$this->config->item('template')."'
																		AND options = '2c'
																	ORDER BY seq ASC
																";
																$qry2c = $db->query($sel2c);
																?>
																
																<?php if ($qry2c->num_rows() > 0): ?>

																<div class="fadeslideshow_wrapper hide-mobile" style="padding:0px 40px;">
																	<div id="fadeshow_two-c" class="fadeslideshow_container">
																		<ul>
																			
																			<?php foreach($qry2c->result_array() as $row): ?>
																			
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
						
																	<a href="<?php echo @$homepage_options['two-c']['image_link'] ? $homepage_options['two-c']['image_link'] : site_url(); ?>">
																	
																		<?php
																		/**********
																		 * Using the picturefill javascript
																		 */
																		?>
																		<picture>
																			
																			<source srcset="<?php echo (@$homepage_options['two-c']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'] : base_url().'assets/themes/roden2/images/051016_may_04.jpg'; ?>" media="(min-width: 768px)" />
																			
																			<source srcset="<?php echo (@$homepage_options['two-c']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_02.jpg'; ?>" />
																			
																			<img class="not-loaded" src="<?php echo (@$homepage_options['two-c']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'] : base_url().'assets/themes/roden2/images/051016_may_04.jpg'; ?>" alt="" />
																			
																		</picture>
																	</a>
																	
																</div>
																	
																<?php endif;?>
																
																<?php
																/**********
																 * Images size within this container is 600 x 886
																 */
																?>
																
																<?php
																// get the sliders for container four
																$selm2 = "
																	SELECT *
																	FROM tbl_index_image
																	WHERE
																		template = '".$this->config->item('template')."'
																		AND options = 'm2'
																	ORDER BY seq ASC
																";
																$qrym2 = $db->query($selm2);
																?>
																
																<?php if ($qrym2->num_rows() > 0): ?>

																<div class="fadeslideshow_wrapper mobile-only">
																	<div id="fadeshow_m2" class="fadeslideshow_container">
																		<ul>
																			
																			<?php foreach($qrym2->result_array() as $row): ?>
																			
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
						
																	<a href="<?php echo @$homepage_options['two-c']['image_link'] ? $homepage_options['two-c']['image_link'] : site_url(); ?>">
																	
																		<?php
																		/**********
																		 * Using the picturefill javascript
																		 */
																		?>
																		<picture>
																			
																			<source srcset="<?php echo (@$homepage_options['two-c']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'] : base_url().'assets/themes/roden2/images/051016_may_04.jpg'; ?>" media="(min-width: 768px)" />
																			
																			<source srcset="<?php echo (@$homepage_options['two-c']['image_mobile'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image_mobile'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image_mobile'] : base_url().'assets/themes/roden2/images/051016_may_mobile_02.jpg'; ?>" />
																			
																			<img class="not-loaded" src="<?php echo (@$homepage_options['two-c']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-c']['image'] : base_url().'assets/themes/roden2/images/051016_may_04.jpg'; ?>" alt="" />
																			
																		</picture>
																	</a>
																	
																</div>
																	
																<?php endif;?>
																
															</div>
															<div class="copy-container">
																<div class="cta-block">
																	<a href="<?php echo (@$homepage_options['two']['two_button_link2'] AND @$homepage_options['two']['two_button_link2'] != '&nbsp;') ? $homepage_options['two']['two_button_link2'] : site_url(); ?>">
																		<p class="cta">
																			<span><?php echo (@$homepage_options['two']['two_button_text2'] AND @$homepage_options['two']['two_button_text2'] != '&nbsp;') ? $homepage_options['two']['two_button_text2'] : 'Shop reception'; ?></span>
																		</p>
																	</a>
																</div>
																<!-- hidden -->
																<div class="copy-block products" style="display:none;">
																	<p><a href="<?php echo site_url(); ?>">Bailey Dress</a></p>
																</div>
															</div>
														</div>
													</div>
												</div>
