                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light">
								<div class="portlet-title">
									<div class="caption font-dark">
										<i class="icon-settings font-dark"></i>
										<span class="caption-subject bold uppercase"> <?php echo $page_title; ?></span> 
									</div>
								</div>
								<div class="portlet-body">
								
									<div class="row">
										<div class="col-md-6">
											<div class="btn-group">
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/add'); ?>" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false"> Add a New Category
													<i class="fa fa-plus"></i>
												</a>
											</div>
										</div>
									</div>
									
									<?php
									/***********
									 * Notification area
									 */
									?>
									<div>
										<?php if ($this->session->flashdata('success') == 'add') { ?>
										<div class="alert alert-success auto-remove margin-top-15">
											<button class="close" data-close="alert"></button> New Category ADDED!
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove margin-top-15">
											<button class="close" data-close="alert"></button> Category information updated.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'delete') { ?>
										<div class="alert alert-success auto-remove margin-top-15">
											<button class="close" data-close="alert"></button> Category permanently removed from records.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
										<div class="alert alert-danger auto-remove margin-top-15">
											<button class="close" data-close="alert"></button> An error occured. Please try again.
										</div>
										<?php } ?>
									</div>
									
									<?php
									/***********
									 * For hub sites, this tab form is best used to segregate category list accordingly
									 * We must put a switch here to differentiate list for designer satellite sites
									 */
									?>
									
									<!-- BEGIN TAB-->
									<div class="tabbable-bordered">
								
										<!-- TABS -->
										<ul class="nav nav-tabs">
											
											<?php if ($designers) { ?>
											<?php $i = 1; foreach ($designers as $designer) { ?>
											<?php 
											if (
												$this->webspace_details->options['site_type'] === 'hub_site'
												&& $designer->url_structure != SITESLUG
											) { 
											?>
											<?php if ($i === 1) { ?>
											
											<li class="nav-tabs-item <?php echo $active_category_tab == 'general' ? 'active' : ''; ?> <?php echo ! isset($active_category_tab) ? 'active' : ''; ?>" data-tab_name="general">
												<a href="#tab_general" id="tab-tab_general" data-toggle="tab"> General
												</a>
											</li>
											
											<?php } ?>
											
											<li class="nav-tabs-item <?php echo $active_category_tab == $designer->url_structure ? 'active' : ''; ?>" data-tab_name="<?php echo $designer->url_structure; ?>">
												<a href="#tab_<?php echo $designer->url_structure; ?>" id="tab-tab_<?php echo $designer->url_structure; ?>" data-toggle="tab"> <?php echo $designer->designer; ?>
												</a>
											</li>
											
											<?php } else if (
												$this->webspace_details->options['site_type'] !== 'hub_site'
												&& (
													$designer->url_structure === SITESLUG
													OR $designer->folder === SITESLUG  // backwards compatibility for 'basix-black-label'
												)
											) { ?>
											
											<li class="nav-tabs-item <?php echo $active_category_tab == $designer->url_structure ? 'active' : ''; ?>" data-tab_name="<?php echo $designer->url_structure; ?>">
												<a href="#tab_<?php echo $designer->url_structure; ?>" id="tab-tab_<?php echo $designer->url_structure; ?>" data-toggle="tab"> <?php echo $designer->designer; ?>
												</a>
											</li>
											
											<?php } ?>
											<?php $i++; } ?>
											<?php } ?>
											
										</ul>
										<!-- END TABS -->
										
										<!-- BEGIN TAB CONTENTS -->
										<div class="tab-content clearfix">
										
											<div class="tab-pane <?php echo $active_category_tab == 'general' ? 'active' : ''; ?> <?php echo ! isset($active_category_tab) ? 'active' : ''; ?>" id="tab_general">
											
												<?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'categories_general'); ?>
												
											</div>
											
											<?php if ($designers) { ?>
											
											<?php $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'categories_designers', $this->data); ?>
											
											<?php } ?>
											
										</div>
										<!-- END TAB CONTENTS -->
										
									</div>
									<!-- END TAB-->
									
								</div>
							</div>
                            <!-- END \PORTLET-->
						</div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->
