                        <div class="row">
						
                            <div class="col-md-12">
								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open(
									$this->config->slash_item('admin_folder').'products/add/multiple_upload_images', 
									array(
										'id'=>'form-products_add_multiple_upload_images', 
										'class'=>'form-horizontal'
									)
								); ?>
									
								<!-- BEGIN Portlet PORTLET-->
								<div class="portlet box blue form">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-cog"></i> Select Options
										</div>
										<!-- DOC: Remove "hide" class to enable -->
										<div class="actions hide">
											<a href="javascript:;" class="btn btn-default btn-sm">
												<i class="fa fa-check"></i> Update </a>
										</div>
									</div>
									<div class="portlet-body">
									
										<div class="row">
										<div class="col-md-6">
										
										</div>
										<div class="col-md-6">
										
													<div class="form-group">
														<label class="control-label col-md-3">Parent Category
														</label>
														<div class="col-md-9">
															<div class="form-control height-auto">
															
																<?php
																/**********
																 * Let us use a metroni helper to load category tree
																 * Note the following that is neede:
																 * 		$categories (object) // the list of categories to list in a tree like manner
																 *		$this->product_details->categories // links or attached to categories
																 *		$this->categories_tree->row_count
																 *		$show_uncategorized = FALSE
																 */
																?>
																
																<?php 
																echo create_category_treelist(
																	$categories,
																	$this->product_details->categories,
																	$this->categories_tree->row_count
																); 
																?>
								
															</div>
															<span class="help-block small"><em>Select one parent category.</em></span>
														</div>
													</div>
													
										</div>
										</div>
								
										<div class="form-body">
											<div class="form-group">
												<label class="col-lg-3 control-label">Select Product View
													<span class="required"> * </span>
												</label>
												<div class="col-lg-5">
													<select class="bs-select form-control multiple_upload_defaults" name="select_product_view" data-base_url="<?php echo base_url(); ?>" data-admin_folder="<?php echo $this->config->item('admin_folder'); ?>" data-csrf_token="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf_hash="<?php echo $this->security->get_csrf_hash(); ?>" data-show-subtext="true">
														<option value="front" data-subtext="[main view]" <?php echo $select_product_view == 'front' ? 'selected="selected"': ''; ?>> Front </option>
														<option value="back" data-subtext="[hover view]" <?php echo $select_product_view == 'back' ? 'selected="selected"': ''; ?>> Back </option>
														<option value="side" data-subtext="[alternate]" <?php echo $select_product_view == 'side' ? 'selected="selected"': ''; ?>> Side </option>
														<option value="others" data-subtext="[other gallery view]"> Others </option>
														<option value="coloricon" data-subtext="" <?php echo $select_product_view == 'coloricon' ? 'selected="selected"': ''; ?> class="hide"> Color Icon </option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-3 control-label">Designer:
													<span class="required"> * </span>
												</label>
												<div class="col-lg-5">
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
													<span class="help-block small"><em> All products uploaded will be assigned to the selected designer. </em></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-3 control-label"> Misc.
													<span class="required"> * </span>
												</label>
												<div class="col-lg-9">
													<div class="mt-radio-inline">
														<label class="mt-radio mt-radio-outline">
															<input type="radio" name="publish_this" value="1" checked /> Publish
															<span></span>
														</label>
														<label class="mt-radio mt-radio-outline">
															<input type="radio" name="publish_this" value="0" /> UN-Publish
															<span></span>
														</label>
														<br />
														<label class="mt-radio mt-radio-outline">
															<input type="radio" name="private_view" value="0" checked /> Public
															<span></span>
														</label>
														<label class="mt-radio mt-radio-outline">
															<input type="radio" name="private_view" value="1" /> Private
															<span></span>
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-3 control-label">Categories:
												</label>
												<div class="col-lg-5">
													<div class="form-control height-auto categories-checkbox_treelist">
														<div class="category_treelist scroller" style="height:150px;" data-always-visible="1" data-handle-color="#637283">
														
															<?php
															/**********
															 * Let us use a metroni helper to load category tree
															 * Note the following that is neede:
															 * 		$categories (object) // the list of categories to list in a tree like manner
															 *		$this->product_details->categories // links or attached to categories
															 *		$this->categories_tree->row_count
															 *		$show_uncategorized = FALSE
															 */
															?>
															
															<?php 
															echo create_category_treelist(
																$categories,
																$this->product_details->categories,
																$this->categories_tree->row_count
															); 
															?>
							
														</div>
													</div>
													<span class="help-block small"><em> OPTIONAL<br />You can also set categories later at edit product details. </em></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-3 control-label">Stocks
												</label>
												<div class="col-lg-5">
													<select class="bs-select form-control multiple_upload_defaults" name="stocks" data-live-search="true" data-size="5">
														<option value="0"> 0 </option>
														<?php for ($i=1;$i<=30;$i++) { ?>
														<option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
														<?php } ?>
													</select>
													<span class="help-block small"><em> OPTIONAL<br />Select an amount if you want to auto-add stock quantity to products uploaded.<br />This can be set later at edit product details. </em></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-3 control-label">&nbsp;
												</label>
												<div class="col-lg-5">
													<div class="note note-warning">
														<h4 class="block">Notice! ... before uploading.</h4>
														<p> Ensure that the options above are for the batch of images to be uploaded to avoid mix up on product details. </p>
														<br />
														<p> You can begin drag and drop of images below... </p>
													</div>
													<input class="btn btn-primary form-control" type="button" value="Refresh Page" onclick="location.reload(true);" />
												</div>
											</div>
										</div>
						
									</div>
								</div>
								<!-- END Portlet PORTLET-->
								
								<input type="hidden" name="set-from" value="dropdown_filter" />
								
								<div class="row margin-bottom-30">
									<?php 
									if (
										isset($seasons) 
										&& $this->webspace_details->slug == 'tempoparis'
										 OR $active_designer_details->slug == 'tempoparis'
									) { ?>
									<div class="col-xs-12 col-sm-3">
										<div class="form-group">
											<label class="control-label">Seasons Facets
												<span class="required"> * </span>
											</label>
											<select class="bs-select form-control multiple_upload_defaults" name="seasons" data-base_url="<?php echo base_url(); ?>" data-admin_folder="<?php echo $this->config->item('admin_folder'); ?>" data-csrf_token="<?php echo $this->security->get_csrf_token_name(); ?>" data-csrf_hash="<?php echo $this->security->get_csrf_hash(); ?>">
												<?php foreach ($seasons as $season) { ?>
												<option value="<?php echo $season->url_structure; ?>" <?php echo $active_season == $season->url_structure ? 'selected="selected"': ''; ?>> <?php echo $season->event_name; ?> </option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php } ?>
									<div class="col-xs-12 col-sm-3">
									</div>
									<div class="col-xs-12 col-sm-3">
									</div>
								</div>
								
								</form>
								<!-- End FORM ===================================================================-->
								<!-- END FORM-->
							</div>
								
                            <div class="col-md-12">
								<?php echo form_open(
									//$this->config->slash_item('admin_folder').'products/upload_images', 
									$this->config->slash_item('admin_folder').'products/uploads', 
									array(
										'class'=>'dropzone dropzone-file-area', 
										'id'=>'my-dropzone',
										'enctype'=>'multipart/form-data'
									)
								); ?>
									<input type="hidden" name="add_product" value="1" />
									<input type="hidden" name="product_view" value="<?php echo $select_product_view ?: 'front'; ?>" />
									<!--
									<input type="hidden" name="subcat_id" value="<?php //echo $active_category_details->category_id; ?>" />
									<input type="hidden" name="category_slug" value="<?php //echo $active_category; ?>" />
									-->
									<input type="hidden" name="categories" value="" />
									<input type="hidden" name="category_slugs" value="" />
									<input type="hidden" name="des_id" value="<?php echo $active_designer_details->des_id; ?>" />
									<input type="hidden" name="designer_slug" value="<?php echo $active_designer_details->slug; ?>" />
									<input type="hidden" name="stock_qty" value="0" />
									<input type="hidden" name="view_status" value="Y" />
									<input type="hidden" name="public" value="Y" />
									<input type="hidden" name="publish" value="1" />
									<input type="hidden" name="color_publish" value="Y" />
									<input type="hidden" name="new_color_publish" value="1" />
									<?php if ($this->webspace_details->slug == 'tempoparis' OR $active_designer_details->slug == 'tempoparis') { ?>
									<input type="hidden" name="events" value="<?php echo @$active_season ?: ''; ?>" />
									<?php } ?>
									<h4 class="sbold"> Product Images </h4>
									<p>Drop files here or click to select files for upload.</p>
									<p>Please don't forget to select from above options for the images to be uploaded.<br />Drag as many files deem possible.</p>
								</form>
                            </div>
                        </div>
