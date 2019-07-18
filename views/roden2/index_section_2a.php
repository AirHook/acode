												<?php
												/**********
												 * Top Row (section)
												 */
												?>
												<div class="clearfix top-half hide-mobile">
												
													<?php
													/**********
													 * TITLE Block
													 */
													?>
													<div class="left-half">
														<div class="copy-container">
															<div class="copy-block">
																<p>
																	<?php echo (@$homepage_options['two']['two_text1'] AND $homepage_options['two']['two_text1'] != '&nbsp;') ? $homepage_options['two']['two_text1'] : 'Lavish'; ?>
																	<br /> <?php echo (@$homepage_options['two']['two_text2'] AND $homepage_options['two']['two_text2'] != '&nbsp;') ? $homepage_options['two']['two_text2'] : 'Adornment'; ?> </br>
																	<span><?php echo (@$homepage_options['two']['two_text3'] AND $homepage_options['two']['two_text3'] != '&nbsp;') ? $homepage_options['two']['two_text3'] : '/ Contemporary'; ?></span>
																	<br /><span><?php echo (@$homepage_options['two']['two_text4'] AND $homepage_options['two']['two_text4'] != '&nbsp;') ? $homepage_options['two']['two_text4'] : 'Outline'; ?></span>
																</p>
															</div>
															<div class="title-block">
																<p class="large-text">
																	<span class="one"><?php echo (@$homepage_options['two']['two_title1'] AND $homepage_options['two']['two_title1'] != '&nbsp;') ? $homepage_options['two']['two_title1'] : 'A'; ?></span> <span class="two"><?php echo (@$homepage_options['two']['two_title2'] AND $homepage_options['two']['two_title2'] != '&nbsp;') ? $homepage_options['two']['two_title2'] : 'delicate'; ?></span> <span class="three"><?php echo (@$homepage_options['two']['two_title3'] AND $homepage_options['two']['two_title3'] != '&nbsp;') ? $homepage_options['two']['two_title3'] : 'combo'; ?></span>
																</p>
															</div>
															<!-- hidden-->
															<div class="copy-block products" style="display:none;">
																<p><a href="<?php echo site_url(); ?>">Tabitha Gown</a> // <a href="<?php echo site_url(); ?>">Naya Dress</a> // <a href="<?php echo site_url(); ?>">Hazel Dress</a></p>
															</div>
														</div>
													</div>
													
													<?php
													/**********
													 * IMAGE Block
													 */
													?>
													<div class="right-half">
														<div class="image-block" style="max-width:559px;padding-bottom:10px;">
														
															<?php
															/**********
															 * Images size within this container is 559 x 826
															 */
															?>
															
															<?php
															// get the sliders for container one
															$sel2a = "
																SELECT *
																FROM tbl_index_image
																WHERE
																	template = '".$this->config->item('template')."'
																	AND options = '2a'
																ORDER BY seq ASC
															";
															$qry2a = $db->query($sel2a);
															?>
															
															<?php if ($qry2a->num_rows() > 0): ?>
															
															<div class="fadeslideshow_wrapper">
																<div id="fadeshow_two-a" class="fadeslideshow_container">
																	<ul>
																		
																		<?php foreach($qry2a->result_array() as $row): ?>
																		
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
															
															<a href="<?php echo @$homepage_options['two-a']['image_link'] ? $homepage_options['two-a']['image_link'] : site_url(); ?>" data-image="<?php echo @$homepage_options['two-a']['image']; ?>">
																<img class="not-loaded" src="<?php echo (@$homepage_options['two-a']['image'] AND file_exists(FCPATH.'assets/themes/roden2/uploads/'.$homepage_options['two-a']['image'])) ? base_url().'assets/themes/roden2/uploads/'.$homepage_options['two-a']['image'] : base_url().'assets/themes/roden2/images/051016_may_02.jpg'; ?>" alt="" />
															</a>
															
															<?php endif; ?>
															
														</div>
													</div>
												</div>
