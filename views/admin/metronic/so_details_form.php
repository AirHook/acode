                                    <!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php echo form_open(
										$this->uri->segment(1).'/sales_orders/create/step2',
										array(
											'class'=>'form-horizontal',
											'id'=>'form-sales_orders_create'
										)
									); ?>

                                    <div class="row printable-content" id="print-to-pdf">

                                        <div class="col-sm-12 so-number margin-bottom-10">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3 class="margin-bottom-20">
                                                        <strong> SALES ORDER #<?php echo $so_number; ?> </strong><br />
                                                        <small> Date: <?php echo date('Y-m-d', time()); ?> </small>
                                                    </h3>
                                                    <p>
                                                        D&amp;I Fashion Group <br />
                                                        230 West 38th Street <br />
                                                        New York, NY 10018 <br />
                                                        United State <br />
                                                        212.8400846
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 so-addresses">
                                            <div class="row">

                                                <div class="col-sm-6">

                                                    <p><strong> TO </strong></p>

                                                    <p>
														<?php echo $store_details->store_name ?: 'D&I Fashion Group'; ?> <br />
														<?php echo $store_details->address1 ?: '230 West 38th Street'; ?> <br />
														<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
														<?php echo $store_details->city ?: 'New York'; ?>, <?php echo $store_details->state ?: 'NY'; ?> <?php echo $store_details->zipcode ?: '10018'; ?> <br />
														<?php echo $store_details->country ?: 'United States'; ?> <br />
														<?php echo $store_details->telephone ?: '212.840.0846'; ?> <br />
														ATTN: <?php echo $store_details->fname ? $store_details->fname.' '.$store_details->lname : 'Joe Taveras'; ?> <?php echo $store_details->email ? '('.safe_mailto($store_details->email).')': '('.safe_mailto('help@ship7thavenue.com').')'; ?>
                                                    </p>

                                                </div>
                                                <div class="col-sm-6">

                                                    <p><strong> SHIP TO </strong>
														<a href="#modal-edit_ship_to" data-toggle="modal" class="small ship-to-popovers popovers" data-trigger="hover" data-placement="top" data-container="body" data-content="Click here to change 'Ship To' address. Reset to return to default." data-original-title="EDIT Shipt To" style="margin-left:10px;"> edit </a> <small>/</small> <a href="<?php echo site_url($this->uri->segment(1).'/sales_orders/create/reset_ship_to'); ?>" class="small"> reset </a>
													</p>

                                                    <p>
														<?php echo $store_details->store_name ?: 'D&I Fashion Group'; ?> <br />
														<?php echo $store_details->address1 ?: '230 West 38th Street'; ?> <br />
														<?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
														<?php echo $store_details->city ?: 'New York'; ?>, <?php echo $store_details->state ?: 'NY'; ?> <?php echo $store_details->zipcode ?: '10018'; ?> <br />
														<?php echo $store_details->country ?: 'United States'; ?> <br />
														<?php echo $store_details->telephone ?: '212.840.0846'; ?> <br />
														ATTN: <?php echo $store_details->fname ? $store_details->fname.' '.$store_details->lname : 'Joe Taveras'; ?> <?php echo $store_details->email ? '('.safe_mailto($store_details->email).')': '('.safe_mailto('help@ship7thavenue.com').')'; ?>
                                                    </p>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-sm-12 so-author">
                                            <p>
                                                Ordered by: &nbsp;Joe Taveras
                                                <br />
                                                Designer: &nbsp;General Items
                                                <br />
												Vendor: &nbsp;Mixed Vendors
                                            </p>
                                        </div>

                                        <div class="col-sm-12 m-grid so-misc">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Due Date: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline date-picker" size="16" type="text"   value="" name="start_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
															<span class="help-block"> Click to Select date </span>
														</div>
													</div>

                                                </div>
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Shipping Method: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" size="16" type="text" value="" name="ship_via" />
														</div>
													</div>

                                                </div>
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Shipping Terms: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" size="16" type="text" value="" name="fob" />
														</div>
													</div>

                                                </div>
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Payment Terms: </h5>
													<div class="form-group row">
														<div class="col-md-12">
															<input class="form-control form-control-inline" size="16" type="text" value="" name="terms" />
														</div>
													</div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 m-grid so-cart cart_basket_wrapper">

											<h4>Details</h4>
											<hr /> <!--------------------------------->
											<div class="cart-basket">

                                                <div class="table-scrollable table-scrollable-borderless">
                                                    <table class="table table-striped table-hover table-light">
                                                        <thead>
                                                            <tr>
                                                                <th> Items (<?php echo count($so_items); ?>) </th>
                                                                <th> Size and Qty </th>
                                                                <th class="text-right"> Unit Price </th>
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
                                                                    ?>

                                                            <tr class="summary-item-container">

                                                                <?php
                                                                /**********
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
                                                                        </p>
                                                                    </div>
                                                                </td>

                                                                <?php
                                                                /**********
                                                                 * Size and Qty
                                                                 */
                                                                ?>
                                                                <td class="size-and-qty-wrapper" style="vertical-align:top;">
                                                                    <style>
                                                                        .size-select {
                                                                            border: 0;
                                                                            font-size: 12px;
                                                                            width: 30px;
                                                                           -webkit-appearance: none;
                                                                            -moz-appearance: none;
                                                                            appearance: none;
                                                                        }
                                                                        .size-select:after {
                                                                            content: "\f0dc";
                                                                            font-family: FontAwesome;
                                                                            color: #000;
                                                                        }
                                                                    </style>
                                                                    <?php
                                                                    $this_size_qty = 0;
                                                                    foreach ($size_names as $size_label => $s)
                                                                    {
                                                                        $s_qty =
                                                                            isset($size_qty[$size_label])
                                                                            ? $size_qty[$size_label]
                                                                            : 0
                                                                        ;
                                                                        $this_size_qty += $s_qty;

                                                                        if ($s != 'XL1' && $s != 'XL2')
                                                                        { ?>

                                                                    <div style="display:inline-block;">
                                                                        <?php echo $s; ?> <br />
                                                                        <input tpye="text" class="this-size-qty" style="border:1px solid #<?php echo $s_qty > 0 ? '000' : 'ccc'; ?>;font-size:12px;width:30px;padding-left:5px;background-color:white;" value="<?php echo $s_qty; ?>" readonly />
                                                                    </div>

                                                                            <?php
                                                                        }
                                                                    } ?>

                                                                    =

                                                                    <div style="display:inline-block;">
                                                                        Total <br />
                                                                        <input tpye="text" class="this-total-qty <?php echo $item.' '.$product->prod_no; ?>" style="border:1px solid #ccc;font-size:12px;width:30px;padding-left:5px;background-color:white;" value="<?php echo $this_size_qty; ?>" readonly />
                                                                    </div>

                                                                </td>

                                                                <?php
                                                                /**********
                                                                 * Unit Vendor Price
                                                                 */
                                                                ?>
                                                                <td class="text-right" style="vertical-align:top;">
                                                                    $ <?php echo number_format(@$size_qty['wholesale_price'], 2); ?>
                                                                </td>

                                                                <?php
                                                                /**********
                                                                 * Subtotal
                                                                 */
                                                                ?>
                                                                <td class="text-right" style="vertical-align:top;">
                                                                    <?php
                                                                    $this_size_total = $this_size_qty * @$size_qty['wholesale_price'];
                                                                    ?>
                                                                    $ <?php echo $this->cart->format_number($this_size_total); ?>
                                                                </td>

                                                                <input type="hidden" class="input-order-subtotal <?php echo $item.' '.$product->prod_no; ?>" name="subtotal" value="<?php echo $this_size_total; ?>" />

                                                            </tr>
                                                                    <?php
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

                                                    <?php
                                    				if (@$so_details->remarks)
                                    				{
                                    					echo 'Remarks/Instructions:<br /><br />';
                                                        echo '<div style="font-size:0.8em;">';
                                    					echo $so_details->remarks;
                                                        echo '</div>';
                                    				}
                                    				?>

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
                                                            <td colspan="2">
                                                            </td>
                                                        </tr>
                                                    </table>

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

									<!-- EDIT SHIP TO -->
									<div class="modal fade" id="modal-edit_ship_to" tabindex="-1" role="basic" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title"> Edit Shipt To Address </h4>
												</div>

												<!-- BEGIN FORM-->
												<!-- FORM =======================================================================-->
												<?php echo form_open(
													$this->uri->segment(1).'/sales_orders/edit_ship_to',
													array(
														'id'=>'form-seletc_user'
													)
												); ?>

												<div class="modal-body">

													<div class="form margin-bottom-30">

														<div class="form-body">
															<div class="form-group">
																<div class="btn-group btn-group-justified">
																	<a href="javascript:;" class="btn dark select-user" data-user="new_user"> NEW STORE USER </a>
																	<a href="javascript:;" class="btn dark btn-outline select-user" data-user="current_user"> CURRENT STORE USER </a>
																</div>
															</div>
														</div>

														<?php $this->load->view('metronic/sales/summary_view_send_to_new_user'); ?>

														<?php $this->load->view('metronic/sales/summary_view_send_to_current_user'); ?>
													</div>

												</div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
													<button type="submit" class="btn dark confirm-select_user"> Submit </button>
												</div>

												</form>
												<!-- END FORM ===================================================================-->
												<!-- END FORM-->

											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->
