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

									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open($this->config->slash_item('admin_folder').'categories/add', array('class'=>'form-horizontal', 'id'=>'form-categories_add')); ?>

										<div class="form-actions top">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<button type="submit" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
														<span class="ladda-label">Submit</span>
														<span class="ladda-spinner"></span>
													</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
													<button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-categories_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
												</div>
											</div>
										</div>
                                        <div class="form-body">

											<?php
											/***********
											 * Noification area
											 */
											?>
											<div>
												<div class="alert alert-danger display-hide">
													<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
												<div class="alert alert-success display-hide">
													<button class="close" data-close="alert"></button> Your form validation is successful! </div>
												<?php if (validation_errors()) { ?>
												<div class="alert alert-danger">
													<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
												</div>
												<?php } ?>
											</div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Status
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select class="form-control bs-select" name="view_status">
                                                        <option value="1" <?php echo set_select('view_status', '1'); ?>>Active</option>
                                                        <option value="0" <?php echo set_select('view_status', '0'); ?>>Suspended</option>
                                                    </select>
													<span class="help-block font-red-mint"><cite> <?php echo form_error('view_status'); ?> </cite></span>
													<span class="help-block small"><em>This affects the category in its entirety. All link designers will be affected and their products under this category will not show when this item is suspended.</em></span>
                                                </div>
                                            </div>
											<div class="form-group">
												<label class="col-md-3 control-label">Category Sequencing</label>
												<div class="col-md-4">
                                                    <input name="category_seque" type="text" class="form-control cold-md-6" value="<?php echo set_value('category_seque') ?: '0'; ?>" />
													<span class="help-block font-red-mint"><cite> <?php echo form_error('category_seque'); ?> </cite></span>
													<span class="help-block small"><em>You can change this anytime during edit mode.<br />Accepts digits only.</em></span>
												</div>
											</div>
											<hr />
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Category Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4">
													<input type="text" id="category_name" name="category_name" class="form-control" value="<?php echo set_value('category_name'); ?>" />
													<span class="help-block font-red-mint"><cite> <?php echo form_error('category_name'); ?> </cite></span>
													<span class="help-block small"><em>Used at front end to describe the category.</em></span>
												</div>
                                            </div>
											<div class="form-group">
												<label class="col-md-3 control-label">Slug
                                                    <span class="required"> * </span>
												</label>
												<div class="col-md-4">
													<input type="text" id="category_slug" name="category_slug" class="form-control" value="<?php echo set_value('category_slug'); ?>">
													<span class="help-block font-red-mint"><cite> <?php echo form_error('category_slug'); ?> </cite></span>
													<span class="help-block small"><em>Used for URL purposes therefore must be unique. To re-use an existing category, edit the category and simply link a designer to it.</em></span>
												</div>
											</div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Parent Category
                                                </label>
                                                <div class="col-md-4">
													<div class="form-control height-auto">
														<div class="scroller" style="height:175px;" data-always-visible="1">


															<input type="hidden" name="parent_category_level" value="" />

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
                                                            if ($categories)
                                                            {
                                                                echo create_category_treelist(
    																$categories,
    																array(0),
    																$this->categories_tree->row_count
    															);
                                                            }
                                                            else echo 'Add at least one category first.'
															?>

														</div>
													</div>
													<span class="help-block small"><em>Select one categories where necesary.<br />If no parent category is selected, the new category will act as a parent by itself.</em></span>
                                                </div>
                                            </div>
											<hr />
											<div class="form-group">
												<label class="col-md-3 control-label margin-top-15">General and per linked Designers<br />specific details
												</label>
												<div class="col-md-9">

													<div class="note note-info">
														<h4 class="block">NOTES:</h4>
														<p> Category Icons and Linked Designers can be done during category edit mode. </p>
													</div>

												</div>
											</div>
											<hr />
											<div class="form-group">
												<label class="col-md-3 control-label">Description</label>
												<div class="col-md-4">
                                                    <textarea name="description" class="form-control"><?php echo set_value('description'); ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Title</label>
												<div class="col-md-4">
                                                    <input name="title" type="text" class="form-control" value="<?php echo set_value('title'); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Keyword</label>
												<div class="col-md-4">
                                                    <textarea name="keyword" class="form-control"><?php echo set_value('keyword'); ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Alttags</label>
												<div class="col-md-4">
                                                    <input name="alttags" type="text" class="form-control" value="<?php echo set_value('alttags'); ?>" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Footer</label>
												<div class="col-md-4">
                                                    <textarea name="footer" class="form-control"><?php echo set_value('footer'); ?></textarea>
												</div>
											</div>
                                        </div>
 										<div class="form-actions top">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<button type="submit" class="btn red-flamingo mt-ladda-btn ladda-button" data-style="expand-left">
														<span class="ladda-label">Submit</span>
														<span class="ladda-spinner"></span>
													</button>
													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'categories'); ?>" type="button" class="btn default tooltips" data-placement="top" data-original-title="Back to list">Cancel/Back to list</a>
													<button type="reset" class="btn grey-salsa btn-outline tooltips" onclick="$('input, select').closest('.form-group').removeClass('has-error');$('.alert-danger, .help-block-error').hide();$('#form-categories_add').reset();" data-placement="top" data-original-title="Reset form">Reset</button>
												</div>
											</div>
										</div>


									</form>
									<!-- END FORM ===================================================================-->
									<!-- END FORM-->
								</div>

                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE CONTENT BODY -->

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
