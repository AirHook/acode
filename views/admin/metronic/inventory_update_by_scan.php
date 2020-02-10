					<!-- BEGIN PAGE CONTENT INNER -->
					<div class="row">
						<div class="col-sm-12 page-content-inner">

							<div class="so-details-wrapper">

								<?php
								/***********
								 * Noification area
								 */
								?>
								<div class="row">
									<div class="col-sm-12 clearfix">
										<div class="alert alert-danger display-hide" data-test="test">
											<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
										<div class="alert alert-success display-hide">
											<button class="close" data-close="alert"></button> Your form validation is successful! </div>
										<?php if ($this->session->flashdata('success') == 'inventory_updated') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> Physical Count Inventory Updated
										</div>
										<?php } ?>
									</div>
								</div>

								<?php
								/**
								 * SO Summary Form
								 */
								?>
                                <div class="row printable-content">

									<?php
	                                /***********
	                                 * Actions Column (pulled right)
	                                 */
	                                ?>
									<div class="col-sm-4 pick-and-pack pull-right" style="margin-top:5px;">
										<div class="row">
											<div class="col-sm-12 button-actions" data-object_data='{"so_id":"<?php echo $this->sales_order_details->so_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
												<div class="input-icon input-icon-lg right input-upc_barcode" style="margin-top:5px;">
		                                            <i class="fa fa-barcode font-dark tooltips" data-original-title="Cancel"></i>
		                                            <input type="text" id="input-scan_barcode" class="form-control input-lg" name="upc_barcode" placeholder="Scan Barcode..." autofocus style="border:none;border-bottom:1px solid #ccc;">
												</div>
												<div class="notes">
													<h4>Tips:</h4>
													<ul class="">
														<li>Start scanning items</li>
														<li>Each scan is one line item, one count</li>
														<li>To count an item more than once, scan item according to count</li>
														<li>Scan as many as possible and scroll on the box to review scanned items</li>
														<li>Click on submit to update inventory</li>
														<li>To REMOVE an item, check the checkbox and click the DELETE button</li>
													</ul>
													<h5>NOTES:</h5>
													<ul class="">
														<li>This inventory count is to update the physical inventory count on record. It overrides any exisintg information in the system.</li>
														<li>Data will be lost if you leave the page without submitting it</li>
													</ul>
												</div>
												<hr style="margin:15px 0;border-color:#ccc;border-width:1px;" />
												<button class="btn dark btn-block btn-lg btn-update-inventory">SUBMIT</button>
												<button class="btn btn-block btn-lg display-none btn-delete-selected">DELETE SELECTED</button>
											</div>
										</div>
									</div>

									<?php
	                                /***********
	                                 * Cart Basket
	                                 */
	                                ?>
                                    <div class="col-sm-8 so-cart cart_basket_wrapper">

										<div class="cart-basket">

                                            <div class="table-scrollable" id="scan_items_count_wrapper" style="overflow-y:auto;height:500px;">
                                                <table class="table table-striped table-hover table-light" id="tbl-scan_items_count">
                                                    <thead style="position:sticky;top:0;background:white;z-index:1;">
	                                                    <tr>
															<th style="width:40px;"></th>
	                                                        <th> Item/Desc </th>
	                                                        <th class="text-right" style="width:60px;"> Count </th>
	                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php if ( ! empty($scan_count_items))
                                                        {
                                                            $overall_qty = 0;
                                                            $overall_total = 0;
                                                            $i = 1;
                                                            foreach ($scan_count_items as $index => $item_size_label)
                                                            {
																// just a catch all error suppression
	                                                            //if ( ! $index) continue;

																// breakdown $item_size_label
																$item = $item_size_label[0];
																$size_label = $item_size_label[1];
																$st_id = $item_size_label[2];

                                                                // get product details
                                                                $exp = explode('_', $item);
                                                                $product = $this->product_details->initialize(
                                                                    array(
                                                                        'tbl_product.prod_no' => $exp[0],
                                                                        'color_code' => $exp[1]
                                                                    )
                                                                );

																// set some data
	                                                            $style_no = $item;
	                                                            $prod_no = $exp[0];
	                                                            $color_code = $exp[1];

																// get size mode - '1' for default size mode
                                                                $temp_size_mode = '1';

																if ($product)
	                                                            {
	                                                                $image_new = $product->media_path.$style_no.'_f3.jpg';
	                                                                $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
	                                                                $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
	                                                                $img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
	                                                                $size_mode = $product->size_mode;
	                                                                $color_name = $product->color_name;

	                                                                // take any existing product's size mode
	                                                                $temp_size_mode = $product->size_mode;
	                                                            }
	                                                            else
	                                                            {
	                                                                $image_new = 'images/instylelnylogo_3.jpg';
	                                                                $img_front_new = $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg';
	                                                                $img_linesheet = '';
	                                                                $img_large = '';
	                                                                $size_mode = $this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
	                                                                $color_name = $this->product_details->get_color_name($color_code);
	                                                            }

                                                                // get size names
																$size_names = $this->size_names->get_size_names($size_mode);
                                                                ?>

                                                        <tr class="summary-item-container <?php echo $item.' '.$size_label; ?>" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>" style="height:110px;">

															<?php
                                                            /**********
                                                             * Checkbox
                                                             */
                                                            ?>
                                                            <td class="text-center" style="vertical-align:top;">
																<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
							                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $item.'|'.$size_label.'|'.$st_id; ?>" />
							                                        <span></span>
							                                    </label>
                                                            </td>

                                                            <?php
                                                            /**********
															 * Item/Description
                                                             * Item IMAGE and Details
                                                             * Image links to product details page
                                                             */
                                                            ?>
                                                            <td style="vertical-align:top;">
                                                                <a href="<?php echo $img_linesheet; ?>" class="fancybox pull-left">
                                                                    <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;">
                                                                </a>
                                                                <div class="shop-cart-item-details" style="margin-left:80px;" data-st_id="<?php echo @$product->st_id; ?>">
                                                                    <h5 style="margin:0px;">
                                                                        <?php echo $prod_no; ?>
                                                                    </h5>
                                                                    <p style="margin:0px;">
                                                                        <span style="color:#999;">Style#: <?php echo $item; ?></span><br />
                                                                        Color: &nbsp; <?php echo $color_name; ?><br />
																		<?php echo 'Size '.$size_names[$size_label]; ?>
																		<?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
																		<?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
                                                                    </p>
                                                                </div>
                                                            </td>

                                                            <?php
                                                            /**********
                                                             * Scan Count
                                                             */
                                                            ?>
                                                            <td class="text-right scan-count" style="vertical-align:top;">
																1
                                                            </td>

                                                        </tr>

																<?php
                                                                $i++;
                                                            }
														} ?>

                                                    </tbody>
                                                </table>
                                            </div>

										</div>
										<div class="total-count text-right">
											Total Items / Total Count: <strong id="total-count" style="display:inline-block;width:50px;padding-right:10px;"><?php echo @$i ? $i - 1 : '0'; ?></strong>
										</div>
									</div>

                                </div>

							</div>
					    </div>
					</div>
					<!-- END PAGE CONTENT INNER -->
