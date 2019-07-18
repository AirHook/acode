									<div class="row">

										<!-- BEGIN PRODUCT THUMGS SIDEBAR -->
										<div class="admin_product_thumbs_sidebar col col-md-3" data-active_designer="<?php echo $active_designer; ?>" data-active_category="<?php echo $active_category; ?>">

											<?php $this->load->view($this->config->slash_item('admin_folder').''.($this->config->slash_item('admin_template') ?: 'metronic/').'products_stocks_csv_sidebar'); ?>

										</div>
										<!-- END PRODUCT THUMGS SIDEBAR -->

										<!-- BEGIN PRODUCT LIST -->
										<div class="col col-md-9">

											<div class="panel-group accordion" id="accordion3">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> Download Stocks CSV Masterfile for <?php echo @$category; ?> of <?php echo $designer; ?> </a>
														</h4>
													</div>
													<div id="collapse_3_1" class="panel-collapse in">
														<div class="panel-body">

															<h3>
																FILENAME: &nbsp;
																<cite class="small" style="color:black;">
																	<?php echo 'shop7_stock_csv_master_'.$active_designer.'_'.$active_category.'.csv'; ?>
																</cite>
															</h3>

															<p>
																<a class="btn dark" href="<?php echo site_url('admin/products/csv/stocks_update/download/index/'.$active_designer.'/'.$active_category.'/'.$category_id); ?>">
																 	Download Stocks CSV
																</a>
															</p>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2"> Upload &amp; Update Stocks CSV Masterfile for <?php echo @$category; ?> of <?php echo $designer; ?> </a>
														</h4>
													</div>
													<div id="collapse_3_2" class="panel-collapse">
														<div class="panel-body">

															<!-- BEGIN FORM-->
															<!-- FORM =======================================================================-->
															<?php echo form_open(
																site_url('admin/products/csv/stocks_update/upload'),
																array(
																	'id'=>'form-csv_stocks_update',
																	'enctype'=>'multipart/form-data'
																)
															); ?>

															<input type="hidden" name="designer_slug" value="<?php echo $active_designer; ?>" />
															<input type="hidden" name="category_slug" value="<?php echo $active_category; ?>" />
															<input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />
															<input type="hidden" name="return_uri" value="<?php echo $this->uri->uri_string(); ?>" />

															<div class="alert alert-success">
				    											<button class="close" data-close="alert"></button> There is currently no way to check if file name uploaded is for the correct category. Please follow indicated FILENAME above to ensure correct file uploaded.
				    										</div>

															<div class="form-body">
                                                                <div class="form-group">

																	<div class="fileinput fileinput-new margin-bottom-10" data-provides="fileinput">
																		<span class="btn dark btn-file btn-outline">
																			<span class="fileinput-new"> Click to Select File </span>
																			<span class="fileinput-exists"> Change Selected File </span>
																			<input type="file" id="file" name="file"> </span>
																		<span class="fileinput-filename"> </span> &nbsp;
																		<a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
																	</div>

																</div>
															</div>
															<div class="form-actions margin-bottom-30">
                                                                <div class="row">
                                                                    <div class="col-md-3">
		                                                                <button type="button" class="btn dark btn-block csv_stocks_update">
																			<i class="fa fa-check"></i> Submit
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
											</div>

										</div>
										<!-- END PRODUCT LIST -->

									</div>
