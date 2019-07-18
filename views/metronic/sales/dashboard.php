                    <!-- BEGIN PAGE CONTENT BODY -->

					<?php $this->load->view('metronic/sales/steps_wizard'); ?>

					<?php
					/***********
					 * Noification area
					 */
					?>
					<div>
						<?php if ($this->session->flashdata('success') == 'reset_select_items') { ?>
						<div class="alert alert-success auto-remove">
							<button class="close" data-close="alert"></button> Selections for linesheet sending cleared. Please select a category again.
						</div>
						<?php } ?>
						<?php if (
							$this->session->flashdata('error') == 'no_id_passed'
							OR $this->session->flashdata('error') == 'error_sending_package'
							OR $this->session->flashdata('error') == 'error_sending_linesheet'
						) { ?>
						<div class="alert alert-danger auto-remove">
							<button class="close" data-close="alert"></button> Ooops... Something went wrong. Please try again.
						</div>
						<?php } ?>
					</div>

					<div class="portfolio-content portfolio-3 ">
						<div class="clearfix">
							<h3 class="margin-bottom-30"> Select Categories
							</h3>
						</div>
						<div id="js-grid-lightbox-gallery" class="cbp">

							<?php if ($categories)
							{
								$ic = 1;
								foreach ($categories as $category)
								{
									/***********
									 * Let us take some category details into an array
									 *
									$linked_designers = explode(',', $category->d_url_structure);
									$icon_images = explode(',', $category->icon_image);
									$descriptions = explode('|', $category->description);
									// */

									$ld = json_decode($category->d_url_structure , TRUE);
									$linked_designers =
										json_last_error() === JSON_ERROR_NONE
										? $ld
										: explode(',', $category->d_url_structure)
									;
									$ii = json_decode($category->icon_image , TRUE);
									$icon_images =
										json_last_error() === JSON_ERROR_NONE
										? $ii
										:	explode(',', $category->icon_image)
									;
									$desc = json_decode($category->description , TRUE);
									$descriptions =
										json_last_error() === JSON_ERROR_NONE
										? $desc
										: explode('|', $category->description)
									;

									// for links, let do first row...
									if ($ic == 1)
									{
										// create link
										$li_a_link = array($category->category_slug);
									}

									// if same category level, close previous </li> and open another one
									if ($category->category_level == @$prev_level)
									{
										// create new link
										$pop = array_pop($li_a_link);
										array_push($li_a_link, $category->category_slug);
									}

									// NOTE: next greater level is always greater by only 1 level
									// if so, create new open list <ul>
									if ($category->category_level == @$prev_level + 1)
									{
										// append to previous link
										array_push($li_a_link, $category->category_slug);
									}

									// if next category level is lower, close previous </li></ul> and open another one
									// dont forget to count the depth of levels
									if ($category->category_level < @$prev_level)
									{
										for ($deep = $prev_level - $category->category_level; $deep >= 0; $deep--)
										{
											//echo '</li></ul>';

											// update link
											$pop = array_pop($li_a_link);
										}

										// append to link
										array_push($li_a_link, $category->category_slug);
									}

									if ($category->category_id !== '1')
									{ ?>

							<div class="cbp-item web-design graphic print motion">
								<a href="<?php echo site_url('sales/create/step1/'.implode('/', $li_a_link)); ?>" class="cbp-caption" data-toggle="modal" data-category_id="<?php echo $category->category_id; ?>" data-title="<?php echo $category->category_name.'<br />'.$this->sales_user_details->designer_name; ?>" rel="nofollow">
									<div class="cbp-caption-defaultWrap">
										<!-- <?php echo @$icon_images[$this->sales_user_details->designer]; ?> -->
										<img src="<?php echo base_url(); ?>images/subcategory_icon/thumb/<?php echo @$icon_images[$this->sales_user_details->designer] ?: 'default-subcat-icon.jpg'; ?>" onerror="$(this).prop('src','<?php echo base_url(); ?>images/subcategory_icon/thumb/default-subcat-icon.jpg');" />
									</div>
									<div class="cbp-caption-activeWrap">
										<div class="cbp-l-caption-alignLeft">
											<div class="cbp-l-caption-body">
												<div class="cbp-l-caption-title"><?php echo $category->category_name; ?></div>
												<div class="cbp-l-caption-desc">by <?php echo $this->sales_user_details->designer_name; ?></div>
											</div>
										</div>
									</div>
								</a>
								<div class="cbp-l-grid-projects-title uppercase text-center uppercase text-center">
									<a href="<?php echo site_url('sales/create/step1/'.$category->category_slug); ?>" data-toggle="modal" style="color:black;">
										<?php echo $category->category_name; ?>
									</a>
								</div>
							</div>

										<?php
									}

									// save as previous level
									$prev_level = $category->category_level;

									$ic++;
								}
							} ?>

							<?php if ($this->sales_user_details->access_level == '2')
							{ ?>

							<div class="cbp-item web-design graphic print motion">
								<a href="javascript:;" class="cbp-caption" data-title="World Clock Widget<br>by Paul Flavius Nechita" rel="nofollow">
									<div class="cbp-caption-defaultWrap">
										<img src="<?php echo base_url(); ?>images/subcategory_icon/thumb/special_sale_icon.jpg" onerror="$(this).prop('src','<?php echo base_url(); ?>images/subcategory_icon/thumb/default-subcat-icon.jpg');"> </div>
									<div class="cbp-caption-activeWrap">
										<div class="cbp-l-caption-alignLeft">
											<div class="cbp-l-caption-body">
												<div class="cbp-l-caption-title">Send Special Sale</div>
												<div class="cbp-l-caption-desc"> </div>
											</div>
										</div>
									</div>
								</a>
								<div class="cbp-l-grid-projects-title uppercase text-center uppercase text-center">
									<a href="javascript:;" style="color:black;">
										Send Special Sale
									</a>
								</div>
							</div>

								<?php
							} ?>

						</div>
					</div>

                    <!-- END PAGE CONTENT BODY -->
