												<?php
												/***********
												 * Noification area
												 */
												?>
												<div>
													<?php if ( ! $this->product_details->categories) { ?>
													<div class="alert alert-danger margin-bottom-10">
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
														<i class="fa fa-warning fa-lg"></i> You product item is not categorizes properly.
													</div>
													<?php } ?>
													<?php if ( ! $this->product_details->retail_price) { ?>
													<div class="alert alert-danger margin-bottom-10">
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
														<i class="fa fa-warning fa-lg"></i> You product has no retail price.
													</div>
													<?php } ?>
													<?php if ( ! $this->product_details->wholesale_price) { ?>
													<div class="alert alert-danger margin-bottom-10">
														<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
														<i class="fa fa-warning fa-lg"></i> You product has no wholesale price.
													</div>
													<?php } ?>
												</div>

												<div class="form-body">
													<div class="form-group">
														<label class="col-lg-3 control-label">SKU (Prod No.):
															<span class="required"> * </span>
														</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="prod_no" placeholder="" readonly value="<?php echo $this->product_details->prod_no; ?>"> </div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Product Name:
															<span class="required"> * </span>
														</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" name="prod_name" placeholder="" value="<?php echo $this->product_details->prod_name; ?>">
															<span class="help-block"> shown on prouct listings and details pages</span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Description:
														</label>
														<div class="col-lg-9">
															<textarea class="form-control" name="prod_desc"><?php echo $this->product_details->prod_desc; ?></textarea>
															<span class="help-block"> shown on prouct details pages description section </span>
														</div>
													</div>
													<hr />
													<div class="form-group">
														<label class="col-lg-3 control-label">Designer:
															<span class="required"> * </span>
														</label>
														<div class="col-lg-9">
															<select class="bs-select form-control" id="designer" name="designer">
																<?php if ($designers) { ?>
																<?php foreach ($designers as $designer) { ?>
																<option value="<?php echo $designer->des_id; ?>" data-url_structure="<?php echo $designer->url_structure; ?>" <?php echo $this->product_details->des_id == $designer->des_id ? 'selected="selected"': ''; ?>> <?php echo $designer->designer; ?> </option>
																<?php } } ?>
															</select>
															<input type="hidden" name="designer_slug" value="<?php echo $this->product_details->d_url_structure; ?>" />
														</div>
													</div>
													<hr />
													<div class="form-group">
														<label class="col-md-3 control-label">Vendor Code:
														</label>
														<div class="col-md-9">
															<select class="bs-select form-control" id="vendor_id" name="vendor_id" data-live-search="true" data-size="5" data-show-subtext="true">
																<option value="" data-content="<em>Select a vendor..</em>"></option>
															<?php if ($vendors) { ?>
															<?php foreach ($vendors as $vendor) { ?>
																<option value="<?php echo $vendor->vendor_id; ?>" <?php echo $this->product_details->vendor_id == $vendor->vendor_id ? 'selected="selected"' : ''; ?> data-subtext="<?php echo $vendor->vendor_name; ?>" data-vendor_code="<?php echo $vendor->vendor_code; ?>">
																	<?php echo $vendor->vendor_code; ?>
																</option>
															<?php } ?>
															<?php } ?>
															</select>
															<input type="hidden" name="vendor_code" value="<?php echo $this->product_details->vendor_code; ?>" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label">Size Mode:
														</label>
														<div class="col-md-9">

															<div class="mt-radio-list">
	                                                            <label class="mt-radio mt-radio-outline">
	                                                                <input type="radio" name="size_mode" value="1" <?php echo $this->product_details->size_mode == '1' ? 'checked="checked"' : ''; ?> />
																	Mode A: 0,2,4,6,8,10,...,22
	                                                                <span></span>
	                                                            </label>
	                                                            <label class="mt-radio mt-radio-outline">
	                                                                <input type="radio" name="size_mode" value="0" <?php echo $this->product_details->size_mode == '0' ? 'checked="checked"' : ''; ?> />
																	Mode B: XS,S,M,L,XL,XXL
	                                                                <span></span>
	                                                            </label>
																<label class="mt-radio mt-radio-outline">
	                                                                <input type="radio" name="size_mode" value="2" <?php echo $this->product_details->size_mode == '2' ? 'checked="checked"' : ''; ?> />
																	Mode C: Pre-packed (1S-2M-2L-1XL)
	                                                                <span></span>
	                                                            </label>
	                                                            <label class="mt-radio mt-radio-outline">
	                                                                <input type="radio" name="size_mode" value="3" <?php echo $this->product_details->size_mode == '3' ? 'checked="checked"' : ''; ?> />
																	Mode D: S-M, M-L
	                                                                <span></span>
	                                                            </label>
																<label class="mt-radio mt-radio-outline">
	                                                                <input type="radio" name="size_mode" value="4" <?php echo $this->product_details->size_mode == '4' ? 'checked="checked"' : ''; ?> />
																	Mode E: One Size Fits All
	                                                                <span></span>
	                                                            </label>
																<!--
	                                                            <label class="mt-radio mt-radio-outline mt-radio-disabled">
	                                                                <input type="radio" disabled> Disabled
	                                                                <span></span>
	                                                            </label>
															-->
	                                                        </div>

														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Categories:
															<span class="required"> * </span>
														</label>
														<div class="col-lg-9">
															<div class="form-control cat_crumbs help-block" style="font-style:italic;font-size:80%;">
																<?php echo implode('&nbsp; &raquo; &nbsp;', $this->product_details->category_names); ?>
															</div>
															<div class="form-control height-auto">
																<div class="category_treelist scroller" data-always-visible="1" data-handle-color="#637283">

																<?php
																/**********
																 * Let us use a metroni helper to load category tree
																 * Note the following that is neede:
																 * 		$categories (object)
																 *		$this->product_details->categories
																 *		$this->categories_tree->row_count
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
															<span class="help-block small"><em> select or deselect categories </em></span>
															<?php
															/**********
															 * Poppulate the slugs on this hidden input
															 */
															$cat_slugs = '';
															foreach ($this->product_details->categories as $cat_id)
															{
																$c_slug = $this->categories_tree->get_slug($cat_id);
																$this->cat_slugs =
																	$this->cat_slugs != ''
																	? $this->cat_slugs.','.$c_slug
																	: $c_slug
																;
															}
															?>
															<input type="hidden" name="category_slugs" value="<?php echo $this->cat_slugs; ?>" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Retail Price:
															<span class="required"> * </span>
														</label>
														<div class="col-lg-4">
															<input type="text" class="form-control" name="less_discount" placeholder="" value="<?php echo $this->product_details->retail_price; ?>" /> </div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Retail Sale Price:
														</label>
														<div class="col-lg-4">
															<input type="text" class="form-control" name="catalogue_price" placeholder="" value="<?php echo $this->product_details->retail_sale_price; ?>" /> </div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Wholesale Price:
															<span class="required"> * </span>
														</label>
														<div class="col-lg-4">
															<input type="text" class="form-control" name="wholesale_price" placeholder="" value="<?php echo $this->product_details->wholesale_price; ?>" /> </div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Clearance Price:
														</label>
														<div class="col-lg-4">
															<input type="text" class="form-control" name="wholesale_price_clearance" placeholder="" value="<?php echo $this->product_details->wholesale_price_clearance; ?>" /> </div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Vendor Price:
														</label>
														<div class="col-lg-4">
															<input type="text" class="form-control" name="vendor_price" placeholder="" value="<?php echo $this->product_details->vendor_price; ?>" /> </div>
													</div>
												</div>
