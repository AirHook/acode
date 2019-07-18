					<?php
					/*********
					 * roden2 home page options
					 */
					?>
					
                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="note note-info">
                        <h3> Home Page Sections </h3>
                        <p> There are currently 5 sections to the home page of this theme. Each section has a desktop and respective mobile view for purposes of being responsive. Enabling or disabling a section affects both desktop and movile view simultaneously. </p>
                    </div>
					
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
					
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i> Settings </div>
								<div class="tools hide">
									<a href="javascript:;" class="collapse"> </a>
									<a href="#portlet-config" data-toggle="modal" class="config"> </a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="tabbable-custom nav-justified">
									<ul class="nav nav-tabs nav-justified">
										<li class="active">
											<a href="#tab_sec_1" data-toggle="tab"> Section 1 </a>
										</li>
										<li>
											<a href="#tab_sec_2a" data-toggle="tab"> Section 2a </a>
										</li>
										<li>
											<a href="#tab_sec_2b" data-toggle="tab"> Section 2b </a>
										</li>
										<li>
											<a href="#tab_sec_3" data-toggle="tab"> Section 3 </a>
										</li>
										<li>
											<a href="#tab_sec_4" data-toggle="tab"> Section 4 </a>
										</li>
										<li>
											<a href="#tab_sec_5" data-toggle="tab"> Section 5 </a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_sec_1">
											<p> Enabled. <br />
												<cite> By default, section 1 is always enabled. </cite>
											</p>
											<br />
											<div class="row">
												<div class="col-md-3 col-sm-3 col-xs-3">
													<ul class="nav nav-tabs tabs-left">
														<li class="active">
															<a href="#tab_sec_1_desktop" data-toggle="tab"> Desktop View </a>
														</li>
														<li>
															<a href="#tab_sec_1_mobile" data-toggle="tab"> Mobile View </a>
														</li>
													</ul>
												</div>
												<div class="col-md-9 col-sm-9 col-xs-9">
													<div class="tab-content">
														<div class="tab-pane active" id="tab_sec_1_desktop">
														
															<?php $this->load->view($this->webspace_details->options['theme'].'/index_section_1');  ?>
															
														</div>
														<div class="tab-pane fade" id="tab_sec_1_mobile">
														
															<?php $this->load->view($this->webspace_details->options['theme'].'/index_section_1_mobile');  ?>

														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="tab_sec_2a">
											<p> Howdy, I'm in Section 2. </p>
											<p> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie
												consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation. </p>
											<p>
												<a class="btn green" href="ui_tabs_accordions_navs.html#tab_1_1_2" target="_blank"> Activate this tab via URL </a>
											</p>
										</div>
										<div class="tab-pane" id="tab_sec_2b">
											<p> Howdy, I'm in Section 3. </p>
											<p> Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel
												eum iriure dolor in hendrerit in vulputate velit esse molestie consequat </p>
											<p>
												<a class="btn yellow" href="ui_tabs_accordions_navs.html#tab_1_1_3" target="_blank"> Activate this tab via URL </a>
											</p>
										</div>
										<div class="tab-pane" id="tab_sec_3">
											<p> Howdy, I'm in Section 2. </p>
											<p> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie
												consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation. </p>
											<p>
												<a class="btn green" href="ui_tabs_accordions_navs.html#tab_1_1_2" target="_blank"> Activate this tab via URL </a>
											</p>
										</div>
										<div class="tab-pane" id="tab_sec_4">
											<p> Howdy, I'm in Section 3. </p>
											<p> Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel
												eum iriure dolor in hendrerit in vulputate velit esse molestie consequat </p>
											<p>
												<a class="btn yellow" href="ui_tabs_accordions_navs.html#tab_1_1_3" target="_blank"> Activate this tab via URL </a>
											</p>
										</div>
										<div class="tab-pane" id="tab_sec_5">
											<p> Howdy, I'm in Section 3. </p>
											<p> Duis autem vel eum iriure dolor in hendrerit in vulputate. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel
												eum iriure dolor in hendrerit in vulputate velit esse molestie consequat </p>
											<p>
												<a class="btn yellow" href="ui_tabs_accordions_navs.html#tab_1_1_3" target="_blank"> Activate this tab via URL </a>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</div>
                    <!-- END PAGE CONTENT BODY -->
					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
