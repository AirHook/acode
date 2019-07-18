<?php $controller =& get_instance(); 
?>
                    <!-- BEGIN PAGE CONTENT BODY -->
					<style>
					.img-absolute { position:absolute; }
					</style>
                    <div class="row ">
						<!-- BEGIN FORM-->
						<!-- FORM =======================================================================-->
                        <div class="col-md-12">
							<div class="portlet ">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-leaf"></i><?php echo $product_detail[0]->prod_no ?: 'Product Number'; ?>
									</div>
									<div class="actions btn-set">
										<a class="btn btn-secondary-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'products'); ?>">
											<i class="fa fa-reply"></i> Back to product list</a>
										<a class="btn blue <?php echo $this->webspace_details->options['site_type'] == 'sat_site' ? 'hide' : ''; ?>" href="<?php echo site_url($this->config->slash_item('admin_folder').'products/add'); ?>">
											<i class="fa fa-plus"></i> Add New Product </a>
									</div>
									
								</div>
							</div>
                        </div>
						<div class="col-lg-9 col-md-8 col-xs-12 pull-left">
							<!-- BEGIN Portlet PORTLET-->
							<div class="portlet box blue form">
								<div class="portlet-title">
									<div class="caption">
										<i class="fa fa-cog"></i> Barcode Variants
									</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"> </a>
									</div>
									<!-- DOC: Remove "hide" class to enable -->
									<div class="actions hide">
										<a href="javascript:;" class="btn btn-default btn-sm">
											<i class="fa fa-check"></i> Update </a>
									</div>
								</div>
								<div class="portlet-body">
									<?php $controller->showFlash(); ?>
									<form action="<?php echo site_url($this->config->slash_item('admin_folder').'products/barcodes/generatebarcode')?>" method="POST">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" >
										<input type="hidden" name="st_id" value="<?php echo isset($product_detail[0]->st_id) ? $product_detail[0]->st_id :''; ?>" >
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Product Number</label>
													<input type="text" class="form-control" readonly="" name="prod_no" value="<?php echo isset($product_detail[0]->prod_no) ? $product_detail[0]->prod_no :''; ?>">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Color</label>
													<input type="text" class="form-control" readonly="" name="color" value="<?php echo isset($product_detail[0]->color_name) ? $product_detail[0]->color_name :''; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Size</label>
													<select class="form-control select_size" name="size">
														<option <?php echo (isset($size) && $size == 0) ? 'selected':''; ?> value="0">0</option>
														<option <?php echo (isset($size) && $size == 2) ? 'selected':''; ?> value="2">2</option>
														<option <?php echo (isset($size) && $size == 4) ? 'selected':''; ?> value="4">4</option>
														<option <?php echo (isset($size) && $size == 6) ? 'selected':''; ?> value="6">6</option>
														<option <?php echo (isset($size) && $size == 8) ? 'selected':''; ?> value="8">8</option>
														<option <?php echo (isset($size) && $size == 10) ? 'selected':''; ?> value="10">10</option>
														<option <?php echo (isset($size) && $size == 12) ? 'selected':''; ?> value="12">12</option>
														<option <?php echo (isset($size) && $size == 14) ? 'selected':''; ?> value="14">14</option>
														<option <?php echo (isset($size) && $size == 16) ? 'selected':''; ?> value="16">16</option>
														<option <?php echo (isset($size) && $size == 18) ? 'selected':''; ?> value="18">18</option>
														<option <?php echo (isset($size) && $size == 20) ? 'selected':''; ?> value="20">20</option>
														<option <?php echo (isset($size) && $size == 22) ? 'selected':''; ?> value="22">22</option>
														<option <?php echo (isset($size) && $size == 'ss') ? 'selected':''; ?> value="ss">ss</option>
														<option <?php echo (isset($size) && $size == 'sm') ? 'selected':''; ?>  value="sm">sm</option>
														<option <?php echo (isset($size) && $size == 'sl') ? 'selected':''; ?> value="sl">sl</option>
														<option <?php echo (isset($size) && $size == 'sxl') ? 'selected':''; ?> value="sxl">sxl</option>
														<option <?php echo (isset($size) && $size == 'sxxl') ? 'selected':''; ?> value="sxxl">sxxl</option>
														<option <?php echo (isset($size) && $size == 'sxl1') ? 'selected':''; ?> value="sxl1">sxl1</option>
														<option <?php echo (isset($size) && $size == 'sxl2') ? 'selected':''; ?> value="sxl2">sxl2</option>
														<option <?php echo (isset($size) && $size == 'ssm') ? 'selected':''; ?> value="ssm">ssm</option>
														<option <?php echo (isset($size) && $size == 'sml') ? 'selected':''; ?> value="sml">sml</option>
														<option <?php echo (isset($size) && $size == 'sprepack1221') ? 'selected':''; ?> value="sprepack1221">sprepack1221</option>
														<option <?php echo (isset($size) && $size == 'sonesizefitsall') ? 'selected':''; ?> value="sonesizefitsall">sonesizefitsall</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<button type="submit" class="btn btn-primary">Generate Barcode</button>
											</div>
										</div>
									<form>
									<?php if(isset($barcode_code) && $barcode_code!='' ){?>
										<div class="row text-center">
											<div class="col-sm-12">
												<div style="text-align:center;padding-top:20px">
									              <img src="<?php echo base_url('assets/barcodes/').$barcode_img; ?>">
									          </div>
											</div>
										</div>
										<div class="row text-center" style="margin-top:10px">
											<div class="col-sm-12">
												<a target="_blank" href="<?php echo site_url($this->config->slash_item('admin_folder').'products/barcodes/barcodes/'.$product_detail[0]->prod_no.'/'.$product_detail[0]->color_name.'/'.$sizecode); ?>" class="btn btn-info btn-xs">Print Barcode</a>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<!-- END Portlet PORTLET-->
						</div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
