                                    <!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
										$this->uri->segment(1).'/sales_orders/review',
										array(
											'class'=>'form-horizontal',
											'id'=>'form-sales_orders_review'
										)
									); ?>

									<input type="hidden" name="so_number" value="<?php echo $so_number; ?>" />
									<input type="hidden" name="so_date" value="<?php echo date('Y-m-d', time()); ?>" />
									<input type="hidden" name="des_id" value="<?php echo $des_id; ?>" />
									<input type="hidden" name="vendor_id" value="<?php echo $vendor_details->vendor_id; ?>" />
									<input type="hidden" name="store_id" value="<?php echo $store_details->user_id; ?>" />

                                    <div class="row printable-content" id="print-to-pdf">

                                        <div class="col-sm-12 so-number margin-bottom-10">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3>
														<strong> SALES ORDER INVOICE #<?php echo $so_number; ?> </strong> <br />
														<small> Date: <?php echo date('Y-m-d', time()); ?> </small>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 so-addresses">
                                            <div class="row">

                                                <div class="col-sm-6">

                                                    <p><strong> BILLING ADDRESS </strong></p>

                                                    <p>
														<?php echo $store_details->store_name; ?> <br />
														<?php echo $store_details->address1; ?> <br />
														<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
														<?php echo $store_details->city.', '.$store_details->state.' '.$store_details->zipcode; ?> <br />
														<?php echo $store_details->country; ?> <br />
														<?php echo $store_details->telephone; ?> <br />
                                                    </p>

                                                </div>
                                                <div class="col-sm-6">

                                                    <p><strong> SHIPPING ADDRESS </strong></p>

                                                    <p>
														<?php echo $store_details->store_name; ?> <br />
														<?php echo $store_details->address1; ?> <br />
														<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
														<?php echo $store_details->city.', '.$store_details->state.' '.$store_details->zipcode; ?> <br />
														<?php echo $store_details->country; ?> <br />
														<?php echo $store_details->telephone; ?> <br />
														ATTN: <?php echo $store_details->fname ? $store_details->fname.' '.$store_details->lname : ''; ?> <?php echo $store_details->email ? '('.safe_mailto($store_details->email).')': ''; ?>
                                                    </p>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-sm-12 so-author">
                                            <p>
                                                Sales Person: &nbsp;<?php echo $this->session->admin_loggedin ? 'IN-HOUSE' : ''; ?>
												<input type="hidden" name="author" value="<?php echo $this->session->admin_loggedin ? '1' : $author->admin_sales_id; ?>" />
                                            </p>
                                        </div>

                                        <div class="col-sm-12 so-misc">
                                            <div class="row">
                                                <div class="col-sm-4">

                                                    <h5> Shipping Method: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" size="16" type="text" value="<?php echo set_value('ship_via'); ?>" name="ship_via" />
														</div>
													</div>

                                                </div>
                                                <div class="col-sm-4">

                                                    <h5> Shipping Terms: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" size="16" type="text" value="<?php echo set_value('fob'); ?>" name="fob" />
														</div>
													</div>

                                                </div>
                                                <div class="col-sm-4">

                                                    <h5> Payment Terms: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" size="16" type="text" value="<?php echo set_value('terms'); ?>" name="terms" />
														</div>
													</div>

                                                </div>
                                            </div>
											<div class="row">
                                                <div class="col-sm-4">

                                                    <h5> Purchase Order Reference: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" type="text" value="<?php echo set_value('reference_po'); ?>" name="reference_po" />
														</div>
													</div>

                                                </div>
                                                <div class="col-sm-4">

                                                    <h5> Order Date: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline date-picker" size="16" type="text" value="<?php echo set_value('reference_po_date'); ?>" name="reference_po_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
															<span class="help-block small"> Click to Select date </span>
														</div>
													</div>

                                                </div>
												<div class="col-sm-4">

                                                    <h5> Our Order #: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" type="text" value="<?php echo set_value('our_order'); ?>" name="our_order" />
														</div>
													</div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 so-cart cart_basket_wrapper">

											<!--------------------------------->
											<hr style="margin:15px 0;border-color:#ccc;border-width:1px;" />
											<div class="cart-basket">

                                                <div class="table-scrollable table-scrollable-borderless">
                                                    <table class="table table-striped table-hover table-light">
                                                        <thead>
                                                            <tr>
																<th style="max-width:120px;"> Qty<br />Required </th>
																<th style="max-width:120px;"> Qty<br />Shipped </th>
																<th style="max-width:120px;"> B.O. </th>
                                                                <th> Items </th>
                                                                <th> Description </th>
                                                                <th class="text-right"> Unit<br />Price </th>
                                                                <th class="text-right"> Extended </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php if ( ! empty($so_items))
                                                            {
                                                                $overall_qty = 0;
                                                                $overall_total = 0;
                                                                $i = 1;
                                                                foreach ($so_items as $item => $size_qty)
                                                                {
                                                                    // get product details
                                                                    $exp = explode('_', $item);
                                                                    $product = $this->product_details->initialize(
                                                                        array(
                                                                            'tbl_product.prod_no' => $exp[0],
                                                                            'color_code' => $exp[1]
                                                                        )
                                                                    );

																	// this is like a catch all error...
																	if ( ! $product) continue;

                                                                    // set image paths
                                                                    // the new way relating records with media library
                                                                    $style_no = $product->prod_no.'_'.$product->color_code;
                                                                    $image_new = $product->media_path.$style_no.'_f3.jpg';
                                                                    $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                                                                    $img_back_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_b3.jpg';
                                                                    $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';

                                                                    // get size names
                                                                    $size_names = $this->size_names->get_size_names($product->size_mode);

																	$this_size_qty = 0;
						                                			foreach ($size_qty as $size_label => $qty)
						                                			{
						                                				$this_size_qty += $qty;
						                                				$s = $size_names[$size_label];

						                                				if (
						                                                    isset($so_items[$item][$size_label])
						                                                    && $s != 'XXL' && $s != 'XL1' && $s != 'XL2' && $s != '22'
						                                                )
						                                				{
                                                                    ?>

                                                            <tr class="summary-item-container">

																<?php
                                                                /**********
                                                                 * Quantities
                                                                 */
                                                                ?>
																<td style="vertical-align:top;"><?php echo $qty; ?></td>
																<td style="vertical-align:top;"><?php echo $qty; ?></td>
																<td style="vertical-align:top;">0</td>

																<?php
                                                                /**********
                                                                 * Item Number
                                                                 */
                                                                ?>
																<td style="vertical-align:top;">
																	<?php echo $item; ?><br />
																	<?php echo 'Size '.$s; ?>
																</td>

                                                                <?php
                                                                /**********
																 * Description
                                                                 * Item IMAGE and Details
                                                                 * Image links to product details page
                                                                 */
                                                                ?>
                                                                <td style="vertical-align:top;">
                                                                    <a href="<?php echo $img_linesheet; ?>" class="fancybox pull-left">
                                                                        <img class="" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="" style="width:60px;height:auto;">
                                                                    </a>
                                                                    <div class="shop-cart-item-details" style="margin-left:80px;">
                                                                        <h5 style="margin:0px;">
                                                                            <?php echo $product->prod_no; ?>
                                                                        </h5>
                                                                        <p style="margin:0px;">
                                                                            <span style="color:#999;">Style#: <?php echo $item; ?></span><br />
                                                                            Color: &nbsp; <?php echo $product->color_name; ?>
																			<?php echo @$product->category_names ? '<br /><cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
                                                                        </p>
                                                                    </div>
                                                                </td>

                                                                <?php
                                                                /**********
                                                                 * Unit WS Price
                                                                 */
                                                                ?>
                                                                <td class="text-right" style="vertical-align:top;">
                                                                    $ <?php echo number_format(@$product->wholesale_price, 2); ?>
                                                                </td>

                                                                <?php
                                                                /**********
                                                                 * Subtotal
                                                                 */
                                                                ?>
                                                                <td class="text-right" style="vertical-align:top;">
                                                                    <?php
                                                                    $this_size_total = $this_size_qty * @$product->wholesale_price;
                                                                    ?>
                                                                    $ <?php echo $this->cart->format_number($this_size_total); ?>
                                                                </td>

                                                            </tr>
																			<?php
																		}
																	}

                                                                    $i++;
                                                                    $overall_qty += $this_size_qty;
                                                                    $overall_total += $this_size_total;
                                                                }
                                                            } ?>

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <hr />

											</div>
										</div>

                                        <?php if ( ! empty($so_items))
                                        { ?>

                                        <div class="col-sm-12 status-with-items">
                                            <div class="row">

                                                <div class="col-sm-7">
													<label class="control-label">Remarks/Instructions:
													</label>
													<textarea name="remarks" class="form-control summernote" id="summernote_1" data-error-container="email_message_error"></textarea>
													<div id="email_message_error"> </div>
                                                </div>

                                                <div class="col-sm-1">
                                                    <!-- Spacer -->
                                                </div>

                                                <div class="col-sm-4">
                                                    <table class="table table-condensed cart-summary">
                                                        <tr>
                                                            <td> Quantity Total </td>
                                                            <td class="overall-qty text-right">
                                                                <?php echo $overall_qty; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Order Total </td>
                                                            <td class="text-right order-total">
                                                                <?php
                                                                echo '$ '.number_format($overall_total, 2);
                                                                ?>
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td> Tax Due: </td>
                                                            <td class="text-right order-total">
                                                                <?php
																$fed_tax_id =
																	is_numeric(@$store_details->fed_tax_id)
																	? floatval(@$store_details->fed_tax_id)
																	: 0
																;
																$tax_due =
																	$fed_tax_id
																	? '$ '.number_format($fed_tax_id, 2)
																	: '-'
																;
                                                                echo $tax_due;
                                                                ?>
                                                            </td>
                                                        </tr>
														<tr style="font-weight:700;">
                                                            <td> Grand Total </td>
                                                            <td class="text-right order-total">
                                                                <?php
																$grand_total =
																	$fed_tax_id
																	? $overall_total * $fed_tax_id
																	: $overall_total
																;
                                                                echo '$ '.number_format($grand_total, 2);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                            </td>
                                                        </tr>
                                                    </table>

													<div class="row">
														<div class="col-sm-12 pull-right">
															<!-- DOC: add class "submit-po_summary_review" to execute script to send form -->
															<button class="btn dark btn-block mt-bootbox-new submit-po_summary_review hidden-xs hidden-sm"> Submit Sales Order Invoice </button>
															<button class="btn dark btn-block mt-bootbox-new submit-po_summary_review hidden-md hidden-lg"> Submit SO </button>
														</div>
													</div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-sm-12 no-item-notification" style="display:none;">
                                            <h4 class="text-center" style="margin:85px auto 150px;"> There are no items in your Shop Bag </h4>
                                        </div>

                                            <?php
                                        }
                                        else
                                        { ?>

                                        <div class="col-sm-12">
                                            <h4 class="text-center" style="margin:85px auto 150px;"> There are no items in your Shop Bag </h4>
                                        </div>
                                            <?php
                                        } ?>

                                    </div>

									</form>
									<!-- END FORM ===================================================================-->
									<!-- END FORM-->
