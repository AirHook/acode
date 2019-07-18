                    <!-- BEGIN PAGE CONTENT BODY -->

					<div class="hidden-sm hidden-xs">
						<?php $this->load->view('metronic/sales/steps_wizard'); ?>
					</div>

					<div class="col-md-12">
						<div class="portlet ">
							<div class="portlet-title">

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div>
									<?php if ($this->session->flashdata('success') == 'add') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> New Product ADDED! Continue edit new product now...
									</div>
									<?php } ?>
									<?php if ($this->session->flashdata('success') == 'edit') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> Product item updated...
									</div>
									<?php } ?>
								</div>

								<div class="actions btn-set">
									<a class="btn btn-secondary-outline" href="<?php echo site_url('sales/sales_package'); ?>">
										<i class="fa fa-reply"></i> Back to List</a>
									<a href="#modal_create_sales_package" class="btn sbold blue hide" data-toggle="modal" data-backdrop="static" data-keyboard="false">
										<i class="fa fa-plus"></i> Create Sales Package </a>
								</div>
							</div>
						</div>
					</div>

					<?php
					/***********
					 * Right Column
					 */
					?>
					<div class="col-lg-3 col-md-4 col-xs-12 hidden-xs hidden-sm pull-right">
						<!-- BEGIN Portlet PORTLET-->
						<div class="portlet box blue-hoki form">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-bullhorn"></i>Send </div>
							</div>
							<div class="portlet-body">
								<div class="form-body">
									<div class="row">
										<div class="actions btn-set">

											<?php if (@$linesheet_sending_only) { ?>

											<a href="#modal-select_items_first" class="btn blue btn-lg btn-block select_items_first" data-toggle="modal" style="<?php echo empty($this->sales_user_details->options['selected']) ? '' : 'display:none;'; ?>">
												<span class="ladda-label">Send Package</span>
												<span class="ladda-spinner"></span>
											</a>
											<a href="<?php echo site_url('sales/view_summary'); ?>" class="btn blue btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo send_package_next" data-style="slide-left" style="<?php echo empty($this->sales_user_details->options['selected']) ? 'display:none;' : ''; ?>">
												<span class="ladda-label">Send Package</span>
												<span class="ladda-spinner"></span>
											</a>

											<?php } else { ?>

											<a href="#modal-select_items_first" class="btn blue btn-lg btn-block select_items_first" data-toggle="modal" style="<?php echo $this->sales_package_details->items_count == 0 ? '' : 'display:none;'; ?>">
												<span class="ladda-label">Send Package</span>
												<span class="ladda-spinner"></span>
											</a>
											<a href="<?php echo site_url('sales/view_summary/index/'.@$this->sales_package_details->sales_package_id); ?>" class="btn blue btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo send_package_next" data-style="slide-left" style="<?php echo @$this->sales_package_details->items_count == 0 ? 'display:none;' : ''; ?>">
												<span class="ladda-label">Send Package</span>
												<span class="ladda-spinner"></span>
											</a>

											<?php } ?>

										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- END Portlet PORTLET-->
					</div>

					<?php
					/***********
					 * Left Column Content
					 */
					?>
					<div class="col-lg-9 col-md-8 col-xs-12 pull-left">
						<!-- BEGIN PORTLET-->
						<div class="portlet box blue-hoki">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-info"></i><?php echo ($this->sales_user_details->access_level == '1' OR @$linesheet_sending_only) ? 'Linesheet': 'Sales Package'; ?> Information </div>
								<!-- DOC: Remove "hide" class to enable -->
								<div class="actions hide">
									<a href="javascript:;" class="btn btn-default btn-sm">
										<i class="fa fa-check"></i> Save </a>
								</div>
							</div>
							<div class="portlet-body">

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div>
									<?php if ($this->session->flashdata('success') == 'reset_package_items') { ?>
									<div class="alert alert-success auto-remove">
										<button class="close" data-close="alert"></button> Sales Package items cleared. You may now select new items.
									</div>
									<?php } ?>
								</div>

								<?php if ($this->sales_user_details->access_level == '2' && ! @$linesheet_sending_only) { ?>

								<!-- BEGIN FORM-->
								<!-- FORM =======================================================================-->
								<?php echo form_open(
									'sales/select_items/update_package/'.$active_category.'/'.@$this->sales_package_details->sales_package_id,
									array(
										'class'=>'form-horizontal',
										'id'=>'form_products_edit'
									)
								); ?>

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
											<button class="close" data-close="alert"></button> There was a problem with the form. Please check and try again. </div>
										<?php } ?>
										<?php if ($this->session->userdata('success') === 'create_sales_package') { ?>
										<div class="alert alert-success">
											<button class="close" data-close="alert"></button> Sales package added. You may now select images to add to the sales package. </div>
										<?php } ?>
										<?php if ($this->session->userdata('success') === 'change_sales_package_name') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Sales Package information updated. </div>
										<?php } ?>
									</div>

									<div class="form-group">
										<label class="control-label col-md-2">Package Name
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" name="sales_package_name" data-required="1" class="form-control" value="<?php echo @$this->sales_package_details->sales_package_name; ?>" <?php echo (@$this->sales_package_details->sales_package_id == '1' OR @$this->sales_package_details->sales_package_id == '2') ? 'readonly' : ''; ?>/>
											<cite class="help-block small"> A a user friendly name to identify this package as reference. </cite>
										</div>
									</div>
									<?php if (@$this->sales_package_details->sales_package_id == '1' OR @$this->sales_package_details->sales_package_id == '2') { ?>
									<div class="form-group">
										<div class="col-md-9 col-md-offset-2 hidden-xs hidden-sm">
											<div class="note note-info">
												<p> <strong>System Generated</strong> - This sales package is system generated. The items are populated based on newly added or popular products. </p>
											</div>
										</div>
									</div>
									<?php } ?>
									<hr />
									<div class="form-group">
										<label class="control-label col-md-2">Email Subject
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<input type="text" name="email_subject" data-required="1" class="form-control" value="<?php echo @$this->sales_package_details->email_subject; ?>" />
											<cite class="help-block small"> Used as the subject for the email. </cite>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">Message
											<span class="required"> * </span>
										</label>
										<div class="col-md-9">
											<textarea name="email_message" class="form-control" rows="5"><?php echo @$this->sales_package_details->email_message; ?></textarea>
											<cite class="help-block small"> A short message to the users. HTML tags are accepted. </cite>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-9 col-md-offset-2">

											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-6">
													<button type="submit" class="btn green btn-block" onclick="$('#loading .modal-title').html('Updating...');$('#loading').modal('show');">Update Above Package Info</button>
												</div>
												<br class="hidden-md hidden-lg" />
												<br class="hidden-md hidden-lg" />
												<div class="col-xs-12 col-sm-12 col-md-6">
													<?php if (@$this->sales_package_details->sales_package_id == '1')
													{ ?>

													<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/update_recent_items_sales_package'); ?>" class="btn blue btn-block pull-right" onclick="$('#loading .modal-title').html('Re-populating...');$('#loading').modal('show');">Re-populate Recent Items</a>

														<?php
													}

													if (@$this->sales_package_details->sales_package_id == '2')
													{ ?>

													<a href="javascript:;" class="btn blue btn-block pull-right">Re-populate Popular Items</a>

														<?php
													} ?>
												</div>
											</div>

										</div>
									</div>
								</div>

								<hr />

								</form>
								<!-- End FORM ===================================================================-->
								<!-- END FORM-->

								<?php } ?>

								<?php if (@$this->sales_package_details->sales_package_id == '1' OR @$this->sales_package_details->sales_package_id == '2')
								{ ?>

								<div class="m-heading-1 border-green m-bordered">
									<p> <strong>System Selected Images</strong> - This sales package is system generated. </p>
									<p class="hide"> NOTE: Max of 30 images per package only, which will be sent in 3 separate emails. </p>
								</div>

									<?php
								}
								else
								{ ?>

								<div class="m-heading-1 border-green m-bordered">
									<p> <strong>Select Images</strong> - Select images by clicking on the product list at bottom. The product will appear in the package below. </p>
									<p> <strong>De-Select Images</strong> - Simply click on the image below to remove it from the package. </p>
									<p> Each action is automatically saved. </p>
									<p> NOTE: Max of 30 images per package only, which will be sent in 3 separate emails. </p>
								</div>

									<?php
								} ?>

								<style>
									.thumb-tiles {
										position: relative;
										margin-right: -10px;
									}
									.thumb-tiles .thumb-tile {
										display: block;
										float: left;
										height: 230px;
										width: 140px !important;
										cursor: pointer;
										text-decoration: none;
										color: #fff;
										position: relative;
										font-weight: 300;
										font-size: 12px;
										letter-spacing: .02em;
										line-height: 20px;
										overflow: hidden;
										border: 4px solid transparent;
										margin: 0 10px 10px 0;
									}
									.thumb-tiles .package {
										width: 80px !important;
										height: 116px;
									}
									.thumb-tiles .thumb-tile.selected .corner::after {
										content: "";
										display: inline-block;
										border-left: 40px solid transparent;
										border-bottom: 40px solid transparent;
										border-right: 40px solid #ccc;
										position: absolute;
										top: -3px;
										right: -3px;
										z-index: 100;
									}
									.thumb-tiles .thumb-tile.selected .check::after {
										font-family: FontAwesome;
										font-size: 13px;
										content: "\f00c";
										color: red;
										position: absolute;
										top: 2px;
										right: 2px;
										z-index: 101;
									}
									.thumb-tiles .thumb-tile.image .tile-body {
										padding: 0 !important;
									}
									.thumb-tiles .thumb-tile .tile-body {
										height: 100%;
										vertical-align: top;
										padding: 10px;
										overflow: hidden;
										position: relative;
										font-weight: 400;
										font-size: 12px;
										color: #fff;
										margin-bottom: 10px;
									}
									.thumb-tiles .thumb-tile.image .tile-body > img {
										width: 100%;
										height: auto;
										/*min-height: 100%;*/
										max-width: 100%;
									}
									.thumb-tiles .thumb-tile .tile-body img {
										margin-right: 10px;
									}
									.thumb-tiles .thumb-tile .tile-object {
										position: absolute;
										bottom: 0;
										left: 0;
										right: 0;
										min-height: 30px;
										background-color: transparent;
									}
									.thumb-tiles .thumb-tile .tile-object > .name {
										position: absolute;
										bottom: 0;
										left: 0;
										margin-bottom: 0px;
										margin-left: 0px;
										font-weight: 400;
										font-size: 13px;
										color: #fff;
									}
									.thumb-tiles .thumb-tile .tile-object > .number {
										position: absolute;
										bottom: 0;
										right: 0;
										margin-bottom: 0px;
										margin-left: 0px;
										margin-right: 0px;
										font-weight: 400;
										font-size: 13px;
										color: #fff;
									}
									.thumb-tiles .thumb-tile .tile-object > .number a {
										color: #fff;
									}
									.img-a {
										position: absolute;
										left: 0;
										top: 0;
									}
									.img-b {
										position: absolute;
										left: 0;
										top: 0;
									}
								</style>

								<?php
								/***********
								 * Selected Items Thumbs
								 */
								?>
								<div class="thumb-tiles sales-package clearfix">

									<?php
									if ( ! empty($this->sales_package_details->items))
									{
										foreach ($this->sales_package_details->items as $product)
										{
											// get product details
											$this->product_details->initialize(array('tbl_product.prod_no'=>$product));

											// set image paths
											$img_front_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_front/thumbs/';
											$img_back_pre = $this->config->item('PROD_IMG_URL').'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_folder.'/product_back/thumbs/';
											// the image filename
											$image = $this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'_3.jpg';
											// the new way relating records with media library
											$img_front_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_f3.jpg';
											$img_back_new = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_b3.jpg';
											?>

									<div class="thumb-tile package image bg-blue-hoki <?php echo $this->product_details->prod_no.'_'.$this->product_details->primary_img_id; ?> selected" data-sku="<?php echo $this->product_details->prod_no.'_'.$this->product_details->primary_img_id; ?>" data-prod_no="<?php echo $this->product_details->prod_no; ?>" data-prod_id="<?php echo $this->product_details->prod_id; ?>">

										<div class="corner"> </div>
										<div class="check"> </div>
										<div class="tile-body">
											<img class="img-b" src="<?php echo ($this->product_details->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="">
											<img class="img-a" src="<?php echo ($this->product_details->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="">
										</div>
										<div class="tile-object">
											<div class="name"> <?php echo $this->product_details->public == 'N' ? '<span style="color:#ed6b75;"> Private </span> <br />' : ''; ?> <?php echo $this->product_details->prod_no; ?> </div>
										</div>

									</div>

											<?php
										}
										echo '<input type="hidden" id="items_count" name="items_count" value="'.@$items_count.'" />';
										?>

									<div class="text-right hide" style="clear:both;margin-right:10px;">

										<?php if (@$linesheet_sending_only)
										{ ?>

										<a href="<?php echo site_url('sales/clear_items'); ?>" class="btn blue mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left">Clear selected items</a>

											<?php
										}
										else
										{ ?>

										<a href="<?php echo site_url('sales/clear_package_items/index/'.$this->sales_package_details->sales_package_id.'/'.$this->uri->segment(4)); ?>" class="btn blue mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left">Clear package items</a>

											<?php
										} ?>

									</div>

										<?php
									}
									else
									{ ?>

									<input type="hidden" id="items_count" name="items_count" value="0" />
									<h3 class="hidden-xs hidden-sm">Selected items will show here... </h3>

										<?php
									} ?>

								</div>

							</div>
						</div>
						<!-- END \PORTLET-->
					</div>

					<?php if (@$this->sales_package_details->sales_package_id != '1' && @$this->sales_package_details->sales_package_id != '2')
					{ ?>
					<script>
						$('.thumb-tiles.sales-package').on('click', '.thumb-tile.package', function() {
							$('#loading .modal-title').html('Removing...');
							$('#loading').modal('show');
							$.ajax({
								type:    "POST",
								url:     "<?php echo $linesheet_sending_only ? site_url('sales/sales_linesheet_addrem') : site_url('sales/sales_front_addrem'); ?>",
								data:    {
									"action":"rem_item",
									"id":"<?php echo $linesheet_sending_only ? @$this->sales_user_details->admin_sales_id : @$this->sales_package_details->sales_package_id; ?>",
									"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
									"sku":$(this).data('sku'),
									"prod_no":$(this).data('prod_no'),
									"prod_id":$(this).data('prod_id')
								},
								success: function(data) {
									$('.thumb-tiles.sales-package').html('');
									$('.thumb-tiles.sales-package').html(data);
									$('#loading').modal('hide');
								},
								// vvv---- This is the new bit
								error: function(jqXHR, textStatus, errorThrown) {
									$('#reloading .modal-body .modal-body-text').html('');
									$('#reloading').modal('show');
									location.reload();
									//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
								}
							});
							$('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
						});
					</script>
						<?php
					} ?>

					<?php
					/***********
					 * Left Bottom Column Content - Products Grid
					 */
					?>
					<div class="col-xs-12 hide">
						<!-- BEGIN PORTLET-->
						<div class="portlet box blue-hoki">
							<div class="portlet-title">
								<div class="caption">
									<i class="icon-diamond"></i>Product Listing to Select Items </div>
								<!-- DOC: Remove "hide" class to enable -->
								<div class="actions hide">
									<a href="javascript:;" class="btn btn-default btn-sm">
										<i class="fa fa-check"></i> Save </a>
								</div>
							</div>
							<div class="portlet-body">

								<?php $this->load->view('metronic/sales/sales_package_products_grid'); ?>

							</div>
						</div>
					</div>

					<div style="clear:both;"></div>

					<!-- SELECT ITEMS FIRST -->
					<div class="modal fade bs-modal-sm" id="modal-select_items_first" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title"></h4>
								</div>
								<div class="modal-body text-center">
									<h3 class="margin-bottom-30"> Ooops...!
									</h3>
									<p> Please select items first.
									</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
