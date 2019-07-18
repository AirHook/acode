                    <!-- BEGIN PAGE CONTENT BODY -->
					<?php if (@$this->webspace_details->options['site_type'] === 'hub_site') { ?>
                    <div class="note note-default">
                        <h3><?php echo $this->webspace_details->name; ?></h3>
                        <p> This theme selection page is for the current domain <?php echo $this->webspace_details->site; ?> only. <span class="hide">If you need to select themes for other webspaces, go to Accounts &raquo; <a href="<?php echo site_url($this->config->slash_item('admin_folder').'webspaces'); ?>">Webspaces</a> and select the webspace for options.</span></p>
                    </div>
					<?php } ?>
					
					<?php
					/*********
					 * Notification area
					 */
					?>
					<?php if ( ! @$this->webspace_details->options['theme']) { ?>
					<div class="alert alert-danger">
						<button class="close" data-close="alert"></button> Select a theme and activate it!
					</div>
					<?php } ?>
					<?php if ($this->session->flashdata('success') == 'edit') { ?>
					<div class="alert alert-success">
						<button class="close" data-close="alert"></button> Theme activated! Visit site <a href="<?php echo site_url(); ?>" target="_blank">here</a>.
					</div>
					<?php } ?>
					
					<div class="row">
					
						<?php
						/*********
						 * Roden 2
						 */
						?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<div class="portlet light portlet-fit bordered mt-element-ribbon">
								<?php if (@$this->webspace_details->options['theme'] === 'roden2') { ?>
								<div class="ribbon ribbon-right ribbon-clip ribbon-shadow ribbon-round ribbon-border-dash-hor ribbon-color-danger uppercase">
									<div class="ribbon-sub ribbon-clip ribbon-right"></div>
									Active </div>
								<?php } ?>
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-paint-brush font-blue"></i>
										<span class="caption-subject font-blue bold uppercase">Roden 2</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="mt-element-overlay">
										<div class="row">
											<div class="col-md-12">
												<div class="mt-overlay-4">
													<img src="<?php echo base_url(); ?>assets/themes/roden2/screenshot.jpg">
													<div class="mt-overlay">
														<h2>Roden 2</h2>
														<?php if (@$this->webspace_details->options['theme'] !== 'roden2') { ?>
														<a class="mt-info btn default btn-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'themes/activate/index/'.$this->webspace_details->id.'/roden2'); ?>">Activate Theme</a>
														<?php } ?>
														<?php if (@$this->webspace_details->options['theme'] === 'roden2') { ?>
														<a class="mt-info btn red-flamingo btn-solid" href="<?php echo site_url(); ?>" target="_blank">Visit Site</a>
														<a class="mt-info btn default btn-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'themes/options/index/'.$this->webspace_details->id.'/roden2'); ?>">Theme Options</a>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<?php
						/*********
						 * General Industry 3 (GI3)
						 */
						?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 <?php echo $this->webspace_details->options['site_type'] == 'hub_site' ? '' : 'hide'; ?>">
							<div class="portlet light portlet-fit bordered mt-element-ribbon">
								<?php if (@$this->webspace_details->options['theme'] === 'GI3') { ?>
								<div class="ribbon ribbon-right ribbon-clip ribbon-shadow ribbon-round ribbon-border-dash-hor ribbon-color-danger uppercase">
									<div class="ribbon-sub ribbon-clip ribbon-right"></div>
									Active </div>
								<?php } ?>
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-paint-brush font-blue"></i>
										<span class="caption-subject font-blue bold uppercase">Gen Ind 3 (GI3)</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="mt-element-overlay">
										<div class="row">
											<div class="col-md-12">
												<div class="mt-overlay-4">
													<img src="<?php echo base_url(); ?>assets/themes/GI3/screenshot.jpg">
													<div class="mt-overlay">
														<h2>GI3</h2>
														<?php if (@$this->webspace_details->options['theme'] !== 'GI3') { ?>
														<a class="mt-info btn default btn-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'themes/activate/index/'.$this->webspace_details->id.'/GI3'); ?>">Activate Theme</a>
														<?php } ?>
														<?php if (@$this->webspace_details->options['theme'] === 'GI3') { ?>
														<a class="mt-info btn red-flamingo btn-solid" href="<?php echo site_url(); ?>" target="_blank">Visit Site</a>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<?php
						/*********
						 * Old Default Theme (deprecated)
						 */
						?>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 hide">
							<div class="portlet light portlet-fit bordered mt-element-ribbon">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-paint-brush font-green"></i>
										<span class="caption-subject font-blue bold uppercase">Default</span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="mt-element-overlay">
										<div class="row">
											<div class="col-md-12">
												<div class="mt-overlay-4">
													<img src="../assets/pages/img/page_general_search/06.jpg">
													<div class="mt-overlay">
														<h2>Default</h2>
														<?php if (@$this->webspace_details->options['theme'] !== 'default') { ?>
														<a class="mt-info btn default btn-outline" href="#">Activate Theme</a>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                        </div>
						
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<h2>More themes to come...</h2>
                        </div>
						
					</div>
                    <!-- END PAGE CONTENT BODY -->
					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
