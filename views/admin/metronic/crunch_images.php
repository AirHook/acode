                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">
							
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase"> <?php echo $page_title; ?></span>
                                    </div>
                                </div>
								
								<div class="portlet-body form">

								<div class="portlet-body form">
								
									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open($this->config->slash_item('admin_folder').'products/crunch_images/crunch', array('class'=>'form-horizontal', 'id'=>'form-crunch_images')); ?>
									
                                        <div class="form-body">
										
											<?php
											/***********
											 * Noification area
											 */
											?>
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                                            <div class="alert alert-success display-hide">
                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>
											<?php if ($this->session->success == 'crunching') { ?>
											<div class="alert alert-success auto-remove">
												<button class="close" data-close="alert"></button> Product images are now being crunch...<br />It may take a while to finish depending on the number of images.<br />Please check on the images and report any unwanted results.
											</div>
											<?php } ?>
											<?php if ($this->session->error == 'crunching') { ?>
											<div class="alert alert-danger auto-remove">
												<button class="close" data-close="alert"></button> Ooops... Something went wrong. Please try again.
											</div>
											<?php } ?>
											<?php if (validation_errors()) { ?>
                                            <div class="alert alert-danger">
												<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
											</div>
											<?php } ?>
											
											<h3>Options</h3>
											
											<div class="form-group" data-count="<?php echo $this->webspace_details->slug; ?>">
                                                <label class="control-label col-md-3">Select Designer
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
													<select class="bs-select form-control" name="designer" data-live-search="true" data-size="5">
														<?php if ($designers) { ?>
														<?php foreach ($designers as $designer) { ?>
															<?php 
															if (
																$this->webspace_details->options['site_type'] === 'hub_site'
																&& $designer->url_structure != $this->webspace_details->slug
															) { 
															?>
														<option value="<?php echo $designer->url_structure; ?>" <?php echo $active_designer == $designer->url_structure ? 'selected="selected"' : ''; ?> data-des_id="<?php echo $designer->des_id; ?>" data-d_folder="<?php echo $designer->url_structure; ?>">
															<?php echo $designer->designer; ?>
														</option>
															<?php } else if (
																$this->webspace_details->options['site_type'] !== 'hub_site'
																&& (
																	$designer->url_structure === $this->webspace_details->slug
																	OR $designer->folder === $this->webspace_details->slug  // backwards compatibility for 'basix-black-label'
																)
															) { ?>
														<option value="<?php echo $designer->url_structure; ?>" <?php echo $active_designer == $designer->url_structure ? 'selected="selected"' : ''; ?> data-des_id="<?php echo $designer->des_id; ?>" data-d_folder="<?php echo $designer->url_structure; ?>">
															<?php echo $designer->designer; ?>
														</option>
															<?php } ?>
														<?php } ?>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
                                                <label class="control-label col-md-3">Select Category
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
													<select class="bs-select form-control" name="category" data-live-search="true" data-size="5" data-active_designer="<?php echo $active_designer; ?>">
														<option value="" data-content="<em>Select a category..</em>"></option>
														<?php if ($designers) { ?>
														<?php foreach ($designers as $designer) { ?>
														<?php if (
															$this->webspace_details->options['site_type'] === 'hub_site'
															&& $designer->url_structure != $this->webspace_details->slug
														) { ?>
														<?php $des_categories = $this->categories->treelist(array('d_url_structure'=>$designer->url_structure)); ?>
														<?php if ($des_categories) { ?>
														<?php foreach ($des_categories as $category) { ?>
														<?php if ($category->category_slug != 'apparel') { ?>
														<option class="all-options <?php echo $designer->url_structure; ?>" value="<?php echo $category->category_slug; ?>" <?php echo $active_category == $category->category_slug ? 'selected="selected"' : ''; ?> data-subcat_id="<?php echo $category->category_id; ?>">
															<?php echo $category->category_name; ?>
														</option>
														<?php } ?>
														<?php } ?>
														<?php } ?>
														<?php } else if (
															$this->webspace_details->options['site_type'] !== 'hub_site'
															&& (
																$designer->url_structure === $this->webspace_details->slug
																OR $designer->folder === $this->webspace_details->slug  // backwards compatibility for 'basix-black-label'
															)
														) { ?>
														<?php $des_categories = $this->categories->treelist(array('d_url_structure'=>$designer->url_structure)); ?>
														<?php if ($des_categories) { ?>
														<?php foreach ($des_categories as $category) { ?>
														<?php if ($category->category_slug != 'apparel') { ?>
														<option class="all-options <?php echo $designer->url_structure; ?>" value="<?php echo $category->category_slug; ?>" <?php echo $active_category == $category->category_slug ? 'selected="selected"' : ''; ?> data-subcat_id="<?php echo $category->category_id; ?>">
															<?php echo $category->category_name; ?>
														</option>
														<?php } ?>
														<?php } ?>
														<?php } ?>
														<?php } ?>
														<?php } ?>
														<?php } ?>
													</select>
												</div>
											</div>
											
											<?php
											/***********
											 * Might be good to use this NOTE here to advise
											 * admin of possibilities such as no products uploaded yet
											 */
											?>
                                            <div class="form-group hidden">
												<div class="col-md-offset-3 col-md-9">
													<div class="note note-info">
														<h4 class="block">NOTE:</h4>
														<p>
															Perhaps there is a need to add products before being able to use this feature.
														</p>
													</div>
												</div>
											</div>

										</div>
 										<div class="form-actions bottom">
											<div class="row">
												<div class="col-md-offset-3 col-md-3">
													<button type="submit" id="crunch_go" class="btn btn-primary btn-block mt-ladda-btn ladda-button" data-style="expand-left">
														<span class="ladda-label">Crunch Images</span>
														<span class="ladda-spinner"></span>
													</button>
												</div>
											</div>
										</div>
										
									</form>
									<!-- END FORM ===================================================================-->
									<!-- END FORM-->
									
								</div>
								
								</div>

                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->

