                        <!-- BEGIN PAGE CONTENT BODY -->

                        <div class="hidden-sm hidden-xs">
                            <?php $this->load->view('admin/metronic/sales_package_steps_wizard'); ?>
                        </div>

                        <div class="row margin-bottom-30">

                            <div class="col-md-12">
    							<div class="portlet ">
    								<div class="portlet-title">
    									<div class="actions btn-set">
    										<a class="btn btn-secondary-outline" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_package') : site_url($this->config->slash_item('admin_folder').'campaigns/sales_package'); ?>">
    											<i class="fa fa-reply"></i> Back to package list</a>
    										<a href="#modal_create_sales_package" class="btn sbold blue" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    											<i class="fa fa-plus"></i> Create Another Sales Package </a>
    									</div>
    								</div>
    							</div>
                            </div>

                            <?php
        					/***********
        					 * Left Column Content
        					 */
        					?>
    						<div class="col-xs-12">
                                <!-- BEGIN PORTLET-->
                                <div class="portlet box blue-hoki">
    								<div class="portlet-title">
    									<div class="caption">
    										<i class="fa fa-info"></i>Sales Package Images </div>
    								</div>
    								<div class="portlet-body">

    									<hr />

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
    										else
                                            { ?>
                                                <h3><cite> Selected images will show up here... </cite></h3>
                                                <?php
                                                echo '<input type="hidden" id="items_count" name="items_count" value="0" />';
                                            }
    										?>

    									</div>

    								</div>
                                </div>
                                <!-- END \PORTLET-->
    						</div>

                            <div class="col-md-12">
    							<div class="portlet ">
    								<div class="portlet-title">
    									<div class="actions btn-set">
                                            <a href="<?php echo site_url(($this->uri->segment(1) === 'sales' ? 'sales' : 'admin/campaigns').'/sales_package/edit/step1/'.$this->sales_package_details->sales_package_id); ?>" class="btn green">Edit Package Info</a>

    										<a href="<?php echo site_url(($this->uri->segment(1) === 'sales' ? 'sales' : 'admin/campaigns').'/sales_package/edit/step3/'.$this->sales_package_details->sales_package_id); ?>" class="btn sbold default">
    											Continue to next step... <i class="fa fa-share"></i>
                                            </a>
    									</div>
    								</div>
    							</div>
                            </div>

                            <?php
                            $this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/sales_package_products_grid'), $this->data);
                            ?>

                            <div class="col-md-12">
    							<div class="portlet ">
    								<div class="portlet-body">
                                        <div class="form-group">
											<div class="col-md-9 col-md-offset-3">

                                                <a href="<?php echo site_url(($this->uri->segment(1) === 'sales' ? 'sales' : 'admin/campaigns').'/sales_package/edit/step1/'.$this->sales_package_details->sales_package_id); ?>" class="btn green">Edit Package Info</a>

                                                <a href="<?php echo site_url(($this->uri->segment(1) === 'sales' ? 'sales' : 'admin/campaigns').'/sales_package/edit/step3/'.$this->sales_package_details->sales_package_id) ; ?>" class="btn sbold default"> Continue to next step... <i class="fa fa-share"></i></a>

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
    							</div>
                            </div>

                        </div>

						<?php if ($this->sales_package_details->sales_package_id != '1' && $this->sales_package_details->sales_package_id != '2') { ?>
						<script>
						$('.thumb-tiles.sales-package').on('click', '.thumb-tile.package', function() {
							$('#loading .modal-title').html('Removing...');
							$('#loading').modal('show');
							$.ajax({
								type:    "POST",
								url:     "<?php echo $this->uri->segment(1) == 'sales' ? site_url('sales/sales_package/addrem') : site_url($this->config->slash_item('admin_folder').'campaigns/sales_package/addrem'); ?>",
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

                        <!-- END PAGE CONTENT BODY -->
