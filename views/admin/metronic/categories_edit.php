					<!-- BEGIN FORM-->
					<!-- FORM =======================================================================-->
					<?php echo form_open(
						$this->config->slash_item('admin_folder').'categories/edit/index/'.$this->category_details->category_id,
						array(
							'class'=>'form-horizontal',
							'id'=>'form-categories_edit'
						)
					); ?>

					<input type="hidden" name="category_seque" value="<?php echo $this->category_details->category_seque; ?>" />

						<div class="form-actions top">
							<div class="row">
								<label class="col-md-3 text-right">

                                    <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                                    { ?>

									<div class="btn-group">
										<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/add'); ?>" class="btn sbold blue">
											<i class="fa fa-plus"></i>&nbsp; Add New Category
										</a>
									</div>

                                        <?php
                                    } ?>
								</label>
								<div class="col-md-9">
									<button type="submit" class="btn red-flamingo">Update</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
									<button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
								</div>
							</div>
						</div>

                        <hr />
                        <div class="form-body">

							<?php
							/***********
							 * Noification area
							 */
							?>
							<div class="notifciations">
								<div class="alert alert-danger display-hide">
									<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
								<div class="alert alert-success display-hide">
									<button class="close" data-close="alert"></button> Your form validation is successful! </div>
								<?php if ($this->session->flashdata('success') == 'add') { ?>
								<div class="alert alert-success auto-remove">
									<button class="close" data-close="alert"></button> New CATEGORY added. Continue editing...
								</div>
								<?php } ?>
								<?php if ($this->session->flashdata('success') == 'edit') { ?>
								<div class="alert alert-success auto-remove">
									<button class="close" data-close="alert"></button> Category information updated...
								</div>
								<?php } ?>
								<?php if (validation_errors()) { ?>
								<div class="alert alert-danger">
									<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
								</div>
								<?php } ?>
							</div>

                            <?php
							/***********
							 * General Info and Category Tree list
							 */
							?>
							<div class="row">
								<div class="col-md-5">

									<div class="form-group">
										<label class="control-label col-md-3">Status
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<select class="form-control bs-select" name="view_status">
												<option value="1" <?php echo $this->category_details->status == '1' ? 'selected="selected"' : ''; ?>>Active</option>
												<option value="0" <?php echo $this->category_details->status == '0' ? 'selected="selected"' : ''; ?>>Suspended</option>
											</select>
											<span class="help-block font-red-mint"><cite> <?php echo form_error('view_status'); ?> </cite></span>
											<span class="help-block small"><em>This affects the category in its entirety. All link designers will be affected and their products under this category will not show when this item is suspended.</em></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Category Sequencing</label>
										<div class="col-md-9">
											<input name="category_seque" type="text" class="form-control cold-md-6" value="<?php echo $this->category_details->category_seque; ?>" />
											<span class="help-block font-red-mint"><cite> <?php echo form_error('category_seque'); ?> </cite></span>
											<span class="help-block small"><em>Accepts digits only.</em></span>
										</div>
									</div>
									<hr />
									<div class="form-group">
										<label class="control-label col-md-3">Category Name
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" id="category_name" name="category_name" class="form-control" value="<?php echo $this->category_details->category_name; ?>" />
											<span class="help-block font-red-mint"><cite> <?php echo form_error('category_name'); ?> </cite></span>
											<span class="help-block small"><em>Used at front end to describe the category.</em></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Slug
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" name="category_slug" class="form-control" value="<?php echo $this->category_details->category_slug; ?>" />
											<span class="help-block font-red-mint"><cite> <?php echo form_error('category_slug'); ?> </cite></span>
											<span class="help-block small"><em>Used for URL purposes therefore must be unique.</em></span>
											<span class="help-block small font-red"><em>IMPORTANT! Becarefule in changing this value. This may affect linked items such as designers and products.</em></span>
										</div>
									</div>

								</div>
								<div class="col-md-7">

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
												 *		$this->product_details->parent_category // parent category in array form
												 *		$this->categories_tree->row_count
												 *		current category item id
												 *		current category children if any
												 */
												?>

												<?php
												$cat_tree = create_category_parent_treelist(
													$categories,
													array($this->category_details->parent_category),
													$this->categories_tree->row_count,
													$this->category_details->category_id,
													$children
												);
												?>

												<div class="scroller" data-always-visible="1" data-start="<?php echo $cat_tree ? "input[name='categories[]']:checked" : ''; ?>">

													<input type="hidden" name="parent_category_level" value="" />

													<?php echo $cat_tree; ?>

												</div>

											</div>
											<span class="help-block small"><em>Select one parent category.</em></span>
										</div>
									</div>

								</div>
							</div>

                            <?php
							/***********
							 * Icon and Meta Data
							 */
							?>
							<?php if ($this->webspace_details->options['site_type'] !== 'hub_site') { ?>
							<h3 class="form-section">Icon and Meta data</h3>
							<?php } else { ?>
							<h3 class="form-section">Icons and Meta data</h3>
							<?php } ?>

							<div class="form-group">

								<?php
								/***********
								 * Let us take some category details into an array
								 */
									$linked_designers =
										is_array($this->category_details->linked_designers)
										? $this->category_details->linked_designers
										: explode(',', $this->category_details->linked_designers)
									;
								//$linked_designers = explode(',', $this->category_details->designers);
									$icon_images =
										is_array($this->category_details->icons)
										? $this->category_details->icons
										: explode(',', $this->category_details->icons)
									;
								//$icon_images = explode(',', $this->category_details->icons);
									$descriptions =
										is_array($this->category_details->descriptions)
										? $this->category_details->descriptions
										: explode(',', $this->category_details->descriptions)
									;
								//$descriptions = explode('|', $this->category_details->descriptions);
									$title =
										is_array($this->category_details->title)
										? $this->category_details->title
										: explode(',', $this->category_details->title)
									;
								//$title = explode('|', $this->category_details->title);
									$keyword =
										is_array($this->category_details->keyword)
										? $this->category_details->keyword
										: explode(',', $this->category_details->keyword)
									;
								//$keyword = explode('|', $this->category_details->keyword);
									$alttags =
										is_array($this->category_details->alttags)
										? $this->category_details->alttags
										: explode(',', $this->category_details->alttags)
									;
								//$alttags = explode('|', $this->category_details->alttags);
									$footer =
										is_array($this->category_details->footer)
										? $this->category_details->footer
										: explode(',', $this->category_details->footer)
									;
								//$footer = explode('|', $this->category_details->footer);

                                // for designer satellite sites
                                $des_key =
                                    $this->webspace_details->options['site_type'] != 'hub_site'
                                    ? $this->webspace_details->slug
                                    : 'general'
                                ;
								?>

								<label class="col-md-3 control-label">Default <?php echo $this->webspace_details->options['site_type'] == 'hub_site' ? 'GENERAL' : ''; ?> Icon and Meta Data</label>
								<div class="col-md-9">
									<?php
									/***********
									 * Thumbnail
									 */
									?>
									<div class="col-sm-4 pull-right">
										<div class="thumbnail">
											<img src="<?php echo base_url(); ?>images/subcategory_icon/thumb/<?php echo (array_key_exists(0, $icon_images) ? @$icon_images[0] : @$icon_images[$des_key]) ?: 'default-subcat-icon.jpg'; ?>" width="100%" data-icon_tab="general" onerror="this.onerror=null;this.src='<?php echo base_url(); ?>images/subcategory_icon/thumb/default-subcat-icon.jpg';document.getElementById('thumb-error-general').style.display='block';" />
											<div class="caption">
												<div id="subcategory_icon_caption_general">
													<h4 > <?php echo (@$icon_images[0] OR @$icon_images[$des_key]) ? 'File:' : ''; ?> </h4>
													<p> <?php echo array_key_exists(0, $icon_images) ? @$icon_images[0] : @$icon_images[$des_key]; ?> <p>
												</div>
												<p>
													<a href="#modal-upload_images" data-toggle="modal" data-designer="<?php echo $des_key; ?>" class="btn blue upload_images"> <?php echo (@$icon_images[0] OR @$icon_images[$des_key]) ? 'Edit/Change' : 'Upload'; ?> </a>
													<a href="javascript:;" class="remove_icon btn default" data-designer="<?php echo $des_key; ?>" data-category_id="<?php echo $this->category_details->category_id; ?>">
														Remove
													</a>
												</p>
												<p id="thumb-error-general" class="thumb-error general small text-danger" style="font-style:italic;display:none;"> There was an error loading image file. Upload or change image. </p>
											</div>
										</div>
									</div>
									<?php
									/***********
									 * Other info
									 */
									?>
									<div class="col-sm-8">
										<div class="form-group">
											<label class="col-md-3 control-label">Description</label>
											<div class="col-md-9">
												<textarea name="descriptions[general]" class="form-control" rows="5"><?php echo array_key_exists(0, $descriptions) ? @$descriptions[0] : @$descriptions[$des_key]; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Title</label>
											<div class="col-md-9">
												<input name="title[general]" type="text" class="form-control" value="<?php echo array_key_exists(0, $title) ? $title[0] : $title[$des_key]; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Keyword</label>
											<div class="col-md-9">
												<textarea name="keyword[general]" class="form-control"><?php echo array_key_exists(0, $keyword) ? $keyword[0] : $keyword[$des_key]; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Alttags</label>
											<div class="col-md-9">
												<input name="alttags[general]" type="text" class="form-control" value="<?php echo array_key_exists(0, $alttags) ? $alttags[0] : $alttags[$des_key]; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Footer</label>
											<div class="col-md-9">
												<textarea name="footer[general]" class="form-control"><?php echo array_key_exists(0, $footer) ? $footer[0] : $footer[$des_key]; ?></textarea>
											</div>
										</div>
									</div>
								</div>

							</div>

                            <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                            { ?>

							<hr />
							<div class="form-group">

								<label class="col-md-3 control-label">DESIGNER Icon and Meta Data</label>
								<div class="col-md-9">
									<div class="mt-checkbox-inline" data-object_data='{"category_id":"<?php echo $this->category_details->category_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

											<?php if ($designers)
											{
												$i = 1;
												foreach ($designers as $designer)
												{
													if (
														$this->webspace_details->options['site_type'] === 'hub_site'
														&& $designer->url_structure != SITESLUG
													)
													{ ?>

										<label class="mt-checkbox mt-checkbox-outline col-md-3">
											<input type="checkbox" class="group-checkable-link-des checkbox-<?php echo $designer->url_structure; ?>" name="d_url_structure[<?php echo $designer->url_structure; ?>]" value="<?php echo $designer->url_structure; ?>" <?php echo in_array($designer->url_structure, $linked_designers) ? 'checked' : ''; ?> data-category_id="<?php echo $this->category_details->category_id; ?>" />
												<?php echo $designer->designer; ?>
											<span></span>
										</label>
														<?php
													}
												}
											}
											?>

										<div class="clearfix"></div>
										<span class="help-block small"><em>Check to link a designer, uncheck to unlink.<br />Linked designers will show below</em></span>
									</div>
								</div>

							</div>

								<?php if ($designers)
								{
									$i = 1;
									foreach ($designers as $designer)
									{
										if (
											$this->webspace_details->options['site_type'] === 'hub_site'
											&& $designer->url_structure != SITESLUG
										)
										{
											// check if variable is assoc array or not
											if (array() === $linked_designers) $is_assoc = FALSE;
											else $is_assoc = array_keys($linked_designers) !== range(0, count($linked_designers) - 1);

											// get key of designer if linked
											$key = array_search($designer->url_structure, $linked_designers);

											// if linked...
											if ($key != FALSE)
											{
												// check if $key is numeric or string
												if ($is_assoc)
												{
													$key = $designer->url_structure;
												}
												else $key += 1;
												//if (is_numeric($key)) $key += 1;
												//else $key = $designer->url_structure;
											}
											else
											{
												if ($is_assoc)
												{
													$key = 'general';
												}
												else $key = 0;
											}
											$hide = in_array($designer->url_structure, $linked_designers) ? '' : 'display:none;';
											?>

							<hr style="<?php echo $hide; ?>" />
							<div class="form-group div-link-des-<?php echo $designer->url_structure; ?>" style="<?php echo $hide; ?>">

								<label class="col-md-3 control-label"> <?php echo strtoupper($designer->designer); ?> </label>
								<div class="col-md-9">
									<?php
									/***********
									 * Thumbnail
									 */
									?>
									<div class="col-sm-4 pull-right">
										<div class="thumbnail">
											<img src="<?php echo base_url(); ?>images/subcategory_icon/thumb/<?php echo @$icon_images[$key] ?: 'default-subcat-icon.jpg'; ?>" width="100%" data-icon_tab="<?php echo $designer->url_structure; ?>" onerror="this.onerror=null;this.src='<?php echo base_url(); ?>images/subcategory_icon/thumb/default-subcat-icon.jpg';document.getElementById('thumb-error-<?php echo $designer->url_structure; ?>').style.display='block';" />
											<div class="caption">
												<div id="subcategory_icon_caption_<?php echo $designer->url_structure; ?>">
													<h4> <?php echo @$icon_images[$key] ? 'File:' : ''; ?> </h4>
													<p> <?php echo @$icon_images[$key] ? $icon_images[$key] : ''; ?> <p>
												</div>
												<p>
													<a href="#modal-upload_images" data-toggle="modal" data-designer="<?php echo $designer->url_structure; ?>" class="btn blue upload_images"> <?php echo @$icon_images[$key] ? 'Edit/Change' : 'Upload'; ?> </a>
													<?php if (@$icon_images[$key]) { ?>
													<a href="javascript:;" class="remove_icon btn default" data-designer="<?php echo $designer->url_structure; ?>" data-category_id="<?php echo $this->category_details->category_id; ?>">
														Remove
													</a>
													<?php } ?>
												</p>
												<?php if (@$icon_images[$key]) { ?>
												<p id="thumb-error-<?php echo $designer->url_structure; ?>" class="thumb-error <?php echo $designer->url_structure; ?> small text-danger" style="font-style:italic;display:none;"> There was an error loading image file. Upload or change image. </p>
												<?php } ?>
											</div>
										</div>
									</div>
									<?php
									/***********
									 * Other info
									 */
									?>
									<div class="col-sm-8">
										<div class="form-group">
											<label class="col-md-3 control-label">Description</label>
											<div class="col-md-9">
												<textarea name="descriptions[<?php echo $designer->url_structure; ?>]" class="form-control" rows="5"><?php echo isset($descriptions[$key]) ? $descriptions[$key] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Title</label>
											<div class="col-md-9">
												<input name="title[<?php echo $designer->url_structure; ?>]" type="text" class="form-control" value="<?php echo isset($title[$key]) ? $title[$key] : ''; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Keyword</label>
											<div class="col-md-9">
												<textarea name="keyword[<?php echo $designer->url_structure; ?>]" class="form-control"><?php echo isset($keyword[$key]) ? $keyword[$key] : ''; ?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Alttags</label>
											<div class="col-md-9">
												<input name="alttags[<?php echo $designer->url_structure; ?>]" type="text" class="form-control" value="<?php echo isset($alttags[$key]) ? $alttags[$key] : ''; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Footer</label>
											<div class="col-md-9">
												<textarea name="footer[<?php echo $designer->url_structure; ?>]" class="form-control"><?php echo isset($footer[$key]) ? $footer[$key] : ''; ?></textarea>
											</div>
										</div>
									</div>
								</div>

							</div>
											<?php
										}
									}
                                }
							}
							?>

                        </div>

                        <hr />
                        <div class="form-actions bottom">
							<div class="row">
								<label class="col-md-3 text-right">

                                    <?php if ($this->webspace_details->options['site_type'] == 'hub_site')
                                    { ?>

									<div class="btn-group">
										<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/add'); ?>" class="btn sbold blue" tabindex="-98">
											<i class="fa fa-plus"></i>&nbsp; Add New Category
										</a>
									</div>

                                        <?php
                                    } ?>

								</label>
								<div class="col-md-9">
									<button type="submit" class="btn red-flamingo">Update</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
									<button type="reset" class="btn grey-salsa btn-outline tooltips hide" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-webspace_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
								</div>
								<div class="col-md-offset-3 col-md-9">
									<br />
									<a data-toggle="modal" href="#delete-<?php echo $this->category_details->category_id; ?>"><em>Delete Permanently</em></a>
								</div>
							</div>
						</div>

					</form>
					<!-- END FORM ===================================================================-->
					<!-- END FORM-->

					<!-- DELETE ITEM -->
					<div class="modal fade bs-modal-sm" id="delete-<?php echo $this->category_details->category_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Warning!</h4>
								</div>
								<div class="modal-body">
									Permanently DELETE item? <br /> This cannot be undone!
									<br /><br />
									<span class="small text-danger"> By deleting this, you are unlinking category to all linked designers, and it will no longer show in browser by designer pages at front end. </span>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/delete/index/'.$this->category_details->category_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</a>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- LINK DESIGENR -->
					<div class="modal fade bs-modal-md" id="modal-link_designer" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Link a Designer</h4>
								</div>
								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open($this->config->slash_item('admin_folder').'categories/link_designer', array(
									'role'=>'form',
									'id'=>'form-link_designer'
								)); ?>
								<input type="hidden" name="category_id" value="<?php echo $this->category_details->category_id; ?>" />
								<div class="modal-body">
									Link the category to another designer.
									<div class="form-group">
										<label class="control-label">Select a Designer:
											<span class="required"> * </span>
										</label>
										<div class="">
											<select class="form-control bs-select" name="link_designer">
												<option value=""> Select... </option>
												<?php if ($designers) { ?>
												<?php foreach ($designers as $designer) { ?>
												<?php if ($designer->url_structure !== 'instylenewyork') {
													if ( ! in_array($designer->url_structure, $linked_designers)) { ?>
												<option value="<?php echo $designer->url_structure; ?>"><?php echo $designer->designer; ?></option>
													<?php } ?>
												<?php } ?>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
									<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Confirm?</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
								</form>
								<!-- END FORM ===================================================================-->
								<!-- END FORM-->
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- UPLOAD IMAGES -->
					<div class="modal fade bs-modal-md" id="modal-upload_images" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-md">
							<div class="modal-content">

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Upload Category Icon Images</h4>
								</div>
								<div class="modal-body">

									<div class="m-heading-1 border-green m-bordered">
										<p> Files are uploaded automatically after full progress. </p>
									</div>

									<div class="hide">
										<p> Icon images upload is currently disabled due to this part of the system is being updated. </p>
									</div>

									<div class="row ">
										<div class="col-md-12">
										<!-- BEGIN FORM-->
										<!-- FORM =======================================================================-->
										<?php echo form_open($this->config->slash_item('admin_folder').'categories/upload_images', array(
											'class'=>'dropzone dropzone-file-area',
											'id'=>'my-dropzone-categories',
											'enctype'=>'multipart/form-data'
										)); ?>
											<input type="hidden" name="category_id" value="<?php echo $this->category_details->category_id; ?>" />
											<input type="hidden" name="designer" value="" />
											<h4 class="sbold hide"> Icon Image </h4>
										</form>
										<!-- END FORM ===================================================================-->
										<!-- END FORM-->
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories/edit/index/'.$this->category_details->category_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Done</span>
										<span class="ladda-spinner"></span>
									</a>
								</div>

							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
