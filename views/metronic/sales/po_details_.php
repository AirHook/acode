                        <div class="row margin-bottom-30">
                            <div class="col-md-12">

                                <div class="page-content-inner">

									<div class="checkout-wrapper">

										<div class="row">

											<?php
											/***********
											 * Noification area
											 */
											?>
											<div class="col-sm-12 clearfix">
												<div class="alert alert-danger display-hide">
													<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
												<div class="alert alert-success display-hide">
													<button class="close" data-close="alert"></button> Your form validation is successful! </div>
                                                <?php if ($this->session->flashdata('success') == 'add') { ?>
        										<div class="alert alert-success ">
        											<button class="close" data-close="alert"></button> Purchase Order successfully sent
        										</div>
        										<?php } ?>
											</div>

                                            <div class="portlet solid " style="padding-right:15px;">
                                                <div class="portlet-title">
                                                    <div class="actions btn-set">
                                                        <!--
                										<a class="btn btn-default po-pdf-print_" href="<?php echo base_url(); ?>assets/pdf/pdf_po_selected.php">
                                                        -->
                                                        <a class="btn btn-default po-pdf-print_" href="<?php echo site_url('sales/purchase_orders/view_pdf/index/'.$po_details->po_id); ?>" target="_blank">
                											<i class="fa fa-print"></i> View PDF for Print/Download
                                                        </a>
                                                        &nbsp;
                                                        <a class="btn dark " href="<?php echo site_url('sales/purchase_orders/create/send/'.$po_details->po_id.'/send'); ?>">
                											<i class="fa fa-send"></i> Send PO Again
                                                        </a>
                									</div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
    										<div class="col-md-6 pull-right">
    											<div class="form-group" data-site_section="<?php echo $this->uri->segment(1); ?>" data-object_data='{"po_id":"<?php echo $po_details->po_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
    												<label class="control-label col-md-3">Status</label>
    												<div class="col-md-9">
    													<div class="margin-bottom-10">
    														<input id="option1" type="radio" name="status" value="0" class="make-switch switch-status" data-size="mini" data-on-text="<i class='icon-plus'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $po_details->status == '0' ? 'checked' : ''; ?> />
    														<label for="option1">Open/Pending</label>
    													</div>
    													<div class="margin-bottom-10">
    														<input id="option2" type="radio" name="status" value="2" class="make-switch switch-status" data-size="mini" data-on-color="danger" data-on-text="<i class='icon-ban'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $po_details->status == '2' ? 'checked' : ''; ?> />
    														<label for="option2">On HOLD</label>
    													</div>
    													<div class="margin-bottom-10">
    														<input id="option3" type="radio" name="status" value="1" class="make-switch switch-status" data-size="mini" data-on-color="success" data-on-text="<i class='icon-check'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $po_details->status == '1' ? 'checked' : ''; ?> />
    														<label for="option3">Complete/Delivery</label>
    													</div>
    													<cite class="help-block small"> Changing the PO Status will update the PO almost immediately.<br />Be sure you know what you are doing. </cite>
    												</div>
    											</div>
    										</div>
    									</div>

                                        <div class="row printable-content" id="print-to-pdf">

                                            <div class="col-sm-12 po-summary-number">
												<div class="row">
													<div class="col-sm-12">
														<h3>
                                                            PURCHASE ORDER #<?php echo $po_details->po_number; ?> <br />
                                                            <small> Date: <?php echo $po_details->po_date; ?> </small>
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

											<div class="col-sm-12 po-summary-addresses">
                                                <div class="row">

                                                    <div class="col-sm-6">

														<h5> TO (Vendor Details) </h5>

														<p>
                                                            <?php echo $vendor_details->vendor_name ?: 'VENDOR NAME'; ?> <br />
                                                            <?php echo $vendor_details->address1 ?: 'Address1'; ?> <br />
                                                            <?php echo $vendor_details->address2 ? $vendor_details->address2.'<br />' : ''; ?>
                                                            <?php echo $vendor_details->city ?: 'City'; ?>, <?php echo $vendor_details->state ?: 'State'; ?> <br />
                                                            <?php echo $vendor_details->country ?: 'Country'; ?> <br />
                                                            <?php echo $vendor_details->telephone ?: 'Telephone'; ?> <br />
                                                            ATTN: <?php echo $vendor_details->contact_1 ?: 'Contact Name'; ?> <?php echo $vendor_details->vendor_email ? '('.safe_mailto($vendor_details->vendor_email).')': 'Email'; ?>
														</p>

													</div>
													<div class="col-sm-6">

														<h5> SHIP TO </h5>

														<p>
                                                            <?php echo $store_details->store_name ?: 'D&I Fashion Group'; ?> <br />
                                                            <?php echo $store_details->address1 ?: '230 West 38th Street'; ?> <br />
                                                            <?php echo $store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
                                                            <?php echo $store_details->city ?: 'New York'; ?>, <?php echo $store_details->state ?: 'NY'; ?> <?php echo $store_details->zipcode ?: '10018'; ?> <br />
                                                            <?php echo $store_details->country ?: 'United States'; ?> <br />
                                                            <?php echo $store_details->telephone ?: '212.840.0846'; ?> <br />
                                                            ATTN: <?php echo $store_details->fname ? $store_details->fname.' '.$store_details->lname : 'Joe Taveras'; ?> <?php echo $store_details->email ? '('.safe_mailto($store_details->email).')': '('.safe_mailto('help@shop7thavenue.com').')'; ?>
														</p>

                                                    </div>

												</div>
											</div>

                                            <div class="col-sm-12 sales_user_details">
                                                <p>
                                                    Ordered by: &nbsp;<?php echo $author->fname.' '.$author->lname.' ('.safe_mailto($author->email).')'; ?>
                                                </p>
                                            </div>

                                            <div class="col-sm-12 m-grid po-summary-dates">
                                                <div class="m-grid-row">
                                                    <div class="m-grid-col m-grid-col-sm-2">

                                                        <h5> Start Date: </h5>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$po_options['start_date']; ?>" readonly />
                                                            </div>
                                                        </div>

													</div>
                                                    <div class="m-grid-col m-grid-col-sm-2">

                                                        <h5> Cancel Date: </h5>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$po_options['cancel_date']; ?>" readonly />
                                                            </div>
                                                        </div>

													</div>
                                                    <div class="m-grid-col m-grid-col-sm-2">

                                                        <h5> Delivery Date: </h5>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input class="form-control form-control-inline" size="16" type="text" value="<?php echo $po_details->delivery_date; ?>" readonly />
                                                            </div>
                                                        </div>

													</div>
                                                    <div class="m-grid-col m-grid-col-sm-2">

                                                        <h5> Ship Via: </h5>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$po_options['ship_via']; ?>" readonly />
                                                            </div>
                                                        </div>

													</div>
                                                    <div class="m-grid-col m-grid-col-sm-2">

                                                        <h5> F.O.B: </h5>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$po_options['fob']; ?>" readonly />
                                                            </div>
                                                        </div>

													</div>
                                                    <div class="m-grid-col m-grid-col-sm-2">

                                                        <h5> Terms: </h5>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$po_options['terms']; ?>" readonly />
                                                            </div>
                                                        </div>

													</div>
                                                </div>
                                            </div>

											<div class="col-sm-12 cart_basket_wrapper">

												<div class="clearfix">
													<h4> Details: </h4>
												</div>

												<div class="cart_basket">

													<hr style="margin:5px 0 10px;border-color:#888;border-width:2px;" />

													<div class="table-scrollable table-scrollable-borderless">
														<table class="table table-striped table-hover table-light">
															<thead>
																<tr>
																	<th> Items (<?php echo count($po_items); ?>) </th>
																	<th> Size and Qty </th>
																	<th class="text-right"> Vendor Price </th>
																	<th class="text-right"> Subtotal </th>
																</tr>
															</thead>
															<tbody>

																<?php
																if ( ! empty($po_items))
																{
                                                                    $overall_qty = 0;
                                                                    $overall_total = 0;
																	$i = 1;
																	foreach ($po_items as $item => $size_qty)
																	{
                                                                        // get product details
                                                                        $product = $this->product_details->initialize(
                                                                            array(
                                                                                'tbl_product.prod_no' => $item
                                                                            )
                                                                        );

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

																<tr class="summary-item-container">
																	<?php
																	/**********
																	 * Item IMAGE and Details
																	 * Image links to product details page
																	 */
																	?>
																	<td>
                                                                        <a href="<?php echo $img_linesheet; ?>" class="fancybox pull-left">
                                                                            <img class="img-a" src="<?php echo ($product->primary_img ? $img_front_new : $img_front_pre.$image); ?>" alt="" style="width:60px;height:auto;">
                                                                        </a>
																		<div class="shop-cart-item-details" style="margin-left:80px;">
                                                                            <h4 style="margin:0px;">
                                                                                <?php echo $item; ?>
                                                                            </h4>
                                                                            <p style="margin:0px;">
                                                                                <span style="color:#999;">Product#: <?php echo $item; ?></span><br />
                                                                                Size: &nbsp; <?php echo '2'; ?><br />
                                                                                Color: &nbsp; <?php echo $product->color_name; ?>
                                                                            </p>
																		</div>
																	</td>
																	<?php
																	/**********
																	 * Size and Qty
																	 */
																	?>
																	<td class="size-and-qty-wrapper">
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
                                                                        <?php if ($product->size_mode == 1)
                                                                        {
                                                                            $this_size_qty = 0;
                                                                            for ($s=0;$s<23;$s=$s+2)
                                                                            {
                                                                                $size_label = 'size_'.$s;
                                                                                $s_qty =
                                                                                    isset($size_qty[$size_label])
                                                                                    ? $size_qty[$size_label]
                                                                                    : 0
                                                                                ;
                                                                                $this_size_qty += $s_qty;
                                                                                ?>

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
																	<td class="text-right">
                                                                        $ <?php echo number_format($size_qty['vendor_price'], 2); ?>
                                                                    </td>
                                                                    <?php
																	/**********
																	 * Subtotal
																	 */
																	?>
																	<td class="text-right">
                                                                        <?php
                                                                        $this_size_total = $this_size_qty * $product->vendor_price;
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

											<?php if ( ! empty($po_items))
											{ ?>

                                            <div class="col-sm-12 status-with-items">
                                                <div class="row">

    												<div class="col-sm-6">
                                                        <!-- Spacer -->
    												</div>

    												<div class="col-sm-6">
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

									</div>
                                </div>

                            </div>
                        </div>
