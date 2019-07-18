                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<?php
										/***********
										 * Noification area
										 */
										?>
										<div class="margin-top-20">
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

                                        <style>
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

										<div class="cart_basket_wrapper">
											<div class="row margin-top-20">

                                                <?php
                                                if ($sa_items)
                                                {
                                                    $i = 1;
                                                    foreach ($sa_items as $item)
                                                    {
                                                        // get product details
                                                        $product = $this->product_details->initialize(array('tbl_product.prod_no'=>$item));

                                                        if ( ! $product)
                                                        {
                                                            $exp = explode('_', $item);
                                                            $product = $this->product_details->initialize(
                                                                array(
                                                                    'tbl_product.prod_no' => $exp[0],
                                                                    'color_code' => $exp[1]
                                                                )
                                                            );

                                                        }

                                                        // set image paths
                                                        // the new way relating records with media library
                                                        $style_no = $product->prod_no.'_'.$product->color_code;
                                                        $image_new = $product->media_path.$style_no.'_f3.jpg';
                                                        $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
    													$img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
                                                        $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
                                                        ?>

                                                <div class="summary-item-container col-md-6">
                                                    <div style="height:110px;padding:10px 0px;background:#eee;margin-bottom:5px;">

                                                        <?php
                                                        /**********
                                                         * Item IMAGE and Details
                                                         * Image links to product details page
                                                         */
                                                        ?>
                                                        <div class="col-md-6" style="height:105px;">

                                                            <div style="position:relative;">
                                                                <a href="<?php echo $img_linesheet; ?>" class="fancybox">
                                                                    <img class="img-b" src="<?php echo ($product->primary_img ? $img_back_new : $img_back_pre.$image); ?>" alt="" style="width:60px;height:auto;">
                                                                    <img class="img-a" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="" style="width:60px;height:auto;">
                                                                </a>
                                                            </div>
                                                            <div class="" style="margin-left:80px;">
                                                                <h4 style="margin:0px;">
                                                                    <?php echo $item; ?>
                                                                    <br />
                                                                    <span style="font-size:0.8em;">
                                                                        <?php echo $product->prod_name; ?>
                                                                    </span>
                                                                </h4>
                                                                <p style="margin:0px;">
                                                                    <span style="color:#999;">Product#: <?php echo $item; ?></span><br />
                                                                    Color: &nbsp; <?php echo $product->color_name; ?>
                                                                </p>
                                                            </div>

                                                        </div>
                                                        <?php
                                                        /**********
                                                         * Price (editable)
                                                         */
                                                        ?>
                                                        <div class="col-md-4 item-price-col">

                                                            <div class="box item-price">
                                                                <?php
                                                                // let's process session sa_options if any
                                            					$options_array =
                                            						$this->session->sa_options
                                            						? json_decode($this->session->sa_options, TRUE)
                                            						: array()
                                            					;
                                                                $price = @$options_array['e_prices'][$item] ?: $product->wholesale_price;
                                                                echo $price;
                                                                ?>
                                                            </div>

                                                            <div class="box-tools clearfix">

                                                                <button data-toggle="modal" href="#modal-regular2-<?php echo $item; ?>" type="button" class="btn btn-link btn-xs"><i class="fa fa-pencil"></i> Edit Price</button>

                                                                <!-- EDIT CART ITEM QTY -->
                                                                <div id="modal-regular2-<?php echo $item; ?>" class="modal fade bs-modal-sm in" id="small" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-sm">
                                                                        <div class="modal-content">

                                                                            <?php
                                                                            echo form_open(
                                                                                'sales/sales_package/set_options',
                                                                                array(
                                                                                    'class'=>'form-horizontal form-edit_prices'
                                                                                )
                                                                            );
                                                                            ?>

                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                <h4 class="modal-title">Edit Price</h4>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <?php echo $item; ?>

                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-4">New Price
                                                                                    </label>
                                                                                    <div class="col-md-4">
                                                                                        <input type="hidden" name="tokes" value="<?php echo $this->security->get_csrf_token_name(); ?>" />
                                                                                        <input type="hidden" name="chash" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                                                        <input type="hidden" name="item" value="<?php echo $item; ?>" />
                                                                                        <input type="text" name="price" data-required="1" class="form-control input-sm" value="<?php echo $price; ?>" size="2" />
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                                                                                <button type="submit" class="btn dark e_prices">Apply changes</button>
                                                                            </div>

                                                                            <?php echo form_close(); ?>

                                                                        </div>
                                                                        <!-- /.modal-content -->
                                                                    </div>
                                                                    <!-- /.modal-dialog -->
                                                                </div>
                                                                <!-- /.modal -->

                                                            </div>
                                                        </div>
                                                        <?php
                                                        /**********
                                                         * Status
                                                         */
                                                        ?>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" class="summary-item-checkbox" name="prod_no" value="<?php echo $item; ?>" checked data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}' />
                                                        </div>

                                                    </div>
                                                </div>

                                                        <?php
                                                        $i++;
                                                    }
                                                } ?>

												<div class="no-items-notification col-sm-12">
													<h4 class="text-center" style="margin:85px auto 150px;<?php echo $sa_items ? 'display:none;' : ''; ?>"> There are no items in your Shop Bag </h4>
												</div>

											</div>
										</div>
                                    </div>

                                    <br />
                        			<div class="row send-package-btn <?php echo $sa_items ? '' : 'hide'; ?>">
                        				<div class="col-md-3">
                        					<a href="<?php echo site_url('sales/create/step3'); ?>" class="btn dark btn-block"> SEND PACKAGE </a>
                        				</div>
                        			</div>

                                    <!-- END PAGE CONTENT INNER -->
