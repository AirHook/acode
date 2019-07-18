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
										<?php if ($this->session->flashdata('success') == 'recent_items_udpate') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Recent Items Sales Package updated...
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'change_sales_package_name') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Sales Package information updated
										</div>
										<?php } ?>
										<?php if (validation_errors()) { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
										</div>
										<?php } ?>
									</div>

									<div class="actions btn-set">
										<a class="btn btn-secondary-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package'); ?>">
											<i class="fa fa-reply"></i> Back to package list</a>
										<a href="#modal_create_sales_package" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false">
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
						<div class="col-lg-3 col-md-4 col-xs-12 pull-right">
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
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/send/index/'.$this->sales_package_details->sales_package_id); ?>" class="btn blue btn-lg btn-block mt-ladda-btn ladda-button mt-progress-demo" data-style="slide-left">
													<span class="ladda-label">Send Package</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
											<div class="col" style="margin-top:30px;">
												<a data-toggle="modal" href="#delete-<?php echo $this->sales_package_details->sales_package_id; ?>"><em> Delect Permanently </em></a>
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
										<i class="fa fa-info"></i>Sales Package Information </div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Save </a>
									</div>
								</div>
								<div class="portlet-body">

									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
										$this->config->slash_item('admin_folder').'campaigns/sales_package/change_name/index/'.$this->sales_package_details->sales_package_id,
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
											<?php if ($this->session->userdata('error') === 'recent_items_udpate') { ?>
											<div class="alert alert-danger ">
												<button class="close" data-close="alert"></button> There was an error updating the sales package. Please try again.<br />If this problem persists, please contact the administrator. </div>
											<?php } ?>
											<?php if ($this->session->userdata('success') === 'create_sales_package') { ?>
											<div class="alert alert-success auto-remove">
												<button class="close" data-close="alert"></button> Sales package added. You may now select images to add to the sales package. </div>
											<?php } ?>
											<?php if ($this->session->userdata('success') === 'change_sales_package_name') { ?>
											<div class="alert alert-success auto-remove">
												<button class="close" data-close="alert"></button> Records updated. </div>
											<?php } ?>
										</div>

										<div class="form-group">
											<label class="control-label col-md-2">Package Name
												<span class="required"> * </span>
											</label>
											<div class="col-md-9">
												<input type="text" name="sales_package_name" data-required="1" class="form-control" value="<?php echo $this->sales_package_details->sales_package_name; ?>" <?php echo ($this->sales_package_details->sales_package_id == '1' OR $this->sales_package_details->sales_package_id == '2') ? 'readonly' : ''; ?>/>
											</div>
										</div>
										<!-- DOC: hiding 'set_as_default' to avoid user confusion -->
										<div class="form-group hide">
											<div class="col-md-9 col-md-offset-2">
												<div class="mt-checkbox-inline">
													<label class="mt-checkbox mt-checkbox-outline">
														<input type="checkbox" name="set_as_default" value="1" <?php echo $this->sales_package_details->set_as_default ? 'checked': ''; ?>> Set as default
														<span></span>
													</label>
													<span class="help-block"> Sets this sales package as the package to send in the Send Sales Package dropdown actions for wholesale user list </span>
												</div>
											</div>
										</div>
										<!-- -->
										<?php if (
											$this->sales_package_details->sales_package_id == '1'
											OR $this->sales_package_details->sales_package_id == '2'
											OR $this->sales_package_details->author == 'system'
										) { ?>
										<div class="form-group">
											<div class="col-md-9 col-md-offset-2">
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
												<input type="text" name="email_subject" data-required="1" class="form-control" value="<?php echo $this->sales_package_details->email_subject; ?> <?php echo $this->designer_details->name ? ' - '.strtoupper($this->designer_details->name) : ''; ?>" />
												<span class="help-block">used as the subject for the email campaign</span>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-2">Message
												<span class="required"> * </span>
											</label>
											<div class="col-md-9">
												<textarea name="email_message" id="summernote_1"><?php echo $this->sales_package_details->email_message; ?></textarea>
												<span class="help-block">a short message to the users</span>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-9 col-md-offset-2">
												<button type="submit" class="btn green" onclick="$('#loading .modal-title').html('Updating...');$('#loading').modal('show');">Update Package Info</button>
												<?php if ($this->sales_package_details->sales_package_name == 'General Recent Items') { ?>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'products/update_recent_items_sales_package'); ?>" class="btn blue pull-right" onclick="$('#loading .modal-title').html('Re-populating...');$('#loading').modal('show');">
													Re-populate Recent Items</a>
												<?php } ?>
												<?php if ($this->sales_package_details->sales_package_name == 'Designer Recent Items') { ?>
												<a href="#modal-select_designer_for_designer_recent_sales_package" data-toggle="modal" class="btn blue pull-right">
													Select Items for another DESIGNER</a>
												<?php } ?>
												<?php if ($this->sales_package_details->sales_package_name == 'Popular Items') { ?>
												<a href="javascript:;" class="btn blue pull-right">Re-populate Popular Items</a>
												<?php } ?>
											</div>
										</div>
									</div>

									<hr />

									<?php if ($this->sales_package_details->sales_package_id == '1' OR $this->sales_package_details->sales_package_id == '2') { ?>

									<div class="m-heading-1 border-green m-bordered">
										<p> <strong>System Selected Images</strong> - This sales package is system generated. </p>
										<p> NOTE: Max of 30 images per package only, which will be sent in 3 separate emails. </p>
									</div>

									<?php } else { ?>

									<div class="m-heading-1 border-green m-bordered">
										<p> <strong>Select Images</strong> - Select images by clicking on the filtered product list at bottom. The product will appear in the package below. </p>
										<p> <strong>De-Select Images</strong> - Simply click on the image below to remove it from the package. </p>
										<p> Each action is automatically saved. </p>
										<p> NOTE: Max of 30 images per package only, which will be sent in 3 separate emails. </p>
									</div>

									<?php } ?>

									</form>
									<!-- End FORM ===================================================================-->
									<!-- END FORM-->

									<style>
    									.thumb-tiles {
    										position: relative;
    										margin-right: -10px;
    									}
    									.thumb-tiles .thumb-tile {
    										display: block;
    										float: left;
    										height: 210px;
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
    										height: 120px;
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
    										min-height: 100%;
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
    										margin-bottom: 5px;
    										margin-left: 10px;
    										margin-right: 15px;
    										font-weight: 400;
    										font-size: 13px;
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
												// the image filename
												// the old ways dependent on category and folder structure
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

											echo '<input type="hidden" id="items_count" name="items_count" value="'.$this->sales_package_details->items_count.'" />';
										}
										else echo '<input type="hidden" id="items_count" name="items_count" value="0" />';
										?>

									</div>

								</div>
                            </div>
                            <!-- END \PORTLET-->
						</div>

						<?php if ($this->sales_package_details->sales_package_id != '1' && $this->sales_package_details->sales_package_id != '2') { ?>
						<script>
						$('.thumb-tiles.sales-package').on('click', '.thumb-tile.package', function() {
							$('#loading .modal-title').html('Removing...');
							$('#loading').modal('show');
							$.ajax({
								type:    "POST",
								url:     "<?php echo site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/addrem'); ?>",
								data:    {
									"action":"rem_item",
									"id":"<?php echo $this->sales_package_details->sales_package_id; ?>",
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
						<?php } ?>
