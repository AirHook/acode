					<!-- BEGIN PAGE CONTENT INNER -->
					<div class="row">
						<div class="col-sm-12 page-content-inner">

							<div class="so-details-wrapper">

								<?php
		                        /***********
		                         * Action Bar
		                         */
		                        ?>
		                        <div class="portlet solid " style="padding-right:0px;padding-left:0px;">

		                            <div class="portlet-title">
		                                <div class="actions btn-set pull-left">
											<a class="btn blue" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders/create') : site_url($this->config->slash_item('admin_folder').'sales_orders/create'); ?>">
		                                        <i class="fa fa-plus"></i> Create New Sales Order </a>
		                                    <a class="btn btn-secondary-outline" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/sales_orders') : site_url($this->config->slash_item('admin_folder').'sales_orders'); ?>">
		                                        <i class="fa fa-reply"></i> Back to Sales Order list</a>
		                                </div>
		                            </div>
		                            <hr />
		                            <div class="portlet-title">

		                                <?php if ($this->sales_order_details->status != '5')
		                                { ?>

		                                <div class="caption modify-so">
		                                    <!--
		                                    <a class="btn dark " href="<?php echo site_url($this->uri->segment(1).'/purchase_orders/modify/index/'.$so_details->sales_order_id); ?>">
		                                    -->
		                                    <a class="btn dark " href="javascript:;">
		                                        <i class="fa fa-pencil"></i> Modify SO
		                                    </a>
		                                </div>

		                                    <?php
		                                } ?>

		                                <div class="actions btn-set">
		                                    <a class="btn dark" href="<?php echo site_url($this->uri->segment(1).'/barcodes/print/so/index/'.$so_details->sales_order_id); ?>" target="_blank">
		                                        <i class="fa fa-print"></i> Print All Barcodes
		                                    </a>
		                                    &nbsp;
		                                    <a class="btn btn-default po-pdf-print_" href="<?php echo site_url($this->uri->segment(1).'/sales_orders/view_pdf/index/'.$so_details->sales_order_id); ?>" target="_blank">
		                                        <i class="fa fa-eye"></i> View PDF for Print/Download
		                                    </a>
		                                    &nbsp;
		                                    <a class="btn dark " href="<?php echo site_url($this->uri->segment(1).'/sales_orders/send/index/'.$so_details->sales_order_id); ?>">
		                                        <i class="fa fa-send"></i> Send SO
		                                    </a>
		                                </div>
		                            </div>
		                        </div>

								<div class="row">

									<?php
									/***********
									 * Noification area
									 */
									?>
									<div class="col-sm-12 clearfix">
										<div class="alert alert-danger display-hide" data-test="test">
											<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
										<div class="alert alert-success display-hide">
											<button class="close" data-close="alert"></button> Your form validation is successful! </div>
										<?php if ($this->session->flashdata('success') == 'add') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> Purchase Order successfully sent
										</div>
										<?php } ?>
									</div>

								</div>

								<?php
		                        /***********
		                         * STATUS
		                         */
		                        ?>
		                        <div class="row">
		                            <div class="col-md-6 pull-right">
		                                <div class="form-group" data-site_section="<?php echo $this->uri->segment(1); ?>" data-object_data='{"sales_order_id":"<?php echo $this->sales_order_details->sales_order_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
		                                    <label class="control-label col-md-3">Status</label>
		                                    <div class="col-md-9">
		                                        <div class="margin-bottom-10">
		                                            <input id="option4" type="radio" name="status" value="1" class="make-switch switch-status" data-size="mini" data-on-text="<i class='icon-plus'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '1' ? 'checked' : ''; ?> />
		                                            <label for="option4">Open/Pending</label>
		                                        </div>
		                                        <div class="margin-bottom-10">
		                                            <input id="option3" type="radio" name="status" value="3" class="make-switch switch-status" data-size="mini" data-on-color="warning" data-on-text="<i class='icon-energy'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '3' ? 'checked' : ''; ?> />
		                                            <label for="option3">Return</label>
		                                        </div>
		                                        <div class="margin-bottom-10">
		                                            <input id="option2" type="radio" name="status" value="2" class="make-switch switch-status" data-size="mini" data-on-color="danger" data-on-text="<i class='icon-ban'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '2' ? 'checked' : ''; ?> />
		                                            <label for="option2">On HOLD</label>
		                                        </div>
		                                        <!--
		                                        <div class="margin-bottom-10">
		                                            <input id="option2" type="radio" name="status" value="4" class="make-switch switch-status" data-size="mini" data-on-color="info" data-on-text="<i class='fa fa-truck'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '4' ? 'checked' : ''; ?> />
		                                            <label for="option2">In Transit</label>
		                                        </div>
		                                        -->
		                                        <div class="margin-bottom-10">
		                                            <input id="option1" type="radio" name="status" value="5" class="make-switch switch-status" data-size="mini" data-on-color="success" data-on-text="<i class='icon-check'></i>" data-off-text="&nbsp;-&nbsp;" <?php echo $this->sales_order_details->status == '5' ? 'checked' : ''; ?> />
		                                            <label for="option1">Complete/Delivery</label>
		                                        </div>
		                                        <cite class="help-block small"> Changing the SO Status will update the SO almost immediately. </cite>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>

								<?php
								/**
								 * SO Summary Form
								 */
								?>
                                <div class="row printable-content" id="print-to-pdf">

                                    <div class="col-sm-12 so-number margin-bottom-10">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3>
                                                    <strong> SALES ORDER INVOICE #<?php echo $so_number; ?> </strong> <?php echo @$this->sales_order_details->rev ? '<small><b>rev</b></small><strong>'.@$this->sales_order_details->rev.'</strong>' : ''; ?> <br />
                                                    <small> Date: <?php echo $so_date; ?> </small>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

									<div class="col-sm-12 po-summary-company clearfix">
										<div class="row">
											<div class="col-sm-12">
												<h3> <?php echo $company_name; ?> </h3>

												<p>
													<?php echo $company_address1; ?><br />
													<?php echo $company_address2 ? $company_address2.'<br />' : ''; ?>
													<?php echo $company_city.', '.$company_state.' '.$company_zipcode; ?><br />
													<?php echo $company_country; ?><br />
													<?php echo $company_telephone; ?>
												</p>
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
                                            Sales Person: &nbsp;<?php echo $this->sales_order_details->author == '1' ? 'IN-HOUSE' : $store_details->fname.' '.$store_details->lname.' ('.safe_mailto($store_details->email).')'; ?>
                                        </p>
                                    </div>

                                    <div class="col-sm-12 so-misc">
                                        <div class="row">
                                            <div class="col-sm-4">

                                                <h5> Shipping Method: </h5>
												<div class="form-group row">
													<div class="col-md-12">
														<input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['ship_via']; ?>" name="ship_via" readonly style="background:white;" />
													</div>
												</div>

                                            </div>
                                            <div class="col-sm-4">

                                                <h5> Shipping Terms: </h5>
												<div class="form-group row">
													<div class="col-md-12">
														<input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['fob']; ?>" name="fob" readonly style="background:white;" />
													</div>
												</div>

                                            </div>
                                            <div class="col-sm-4">

                                                <h5> Payment Terms: </h5>
												<div class="form-group row">
													<div class="col-md-12">
														<input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['terms']; ?>" name="terms" readonly style="background:white;" />
													</div>
												</div>

                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-sm-4">

                                                <h5> Purchase Order Reference: </h5>
												<div class="form-group row">
													<div class="col-md-12">
														<input class="form-control form-control-inline" type="text" value="<?php echo @$so_options['reference_po']; ?>" name="reference_po" readonly style="background:white;" />
													</div>
												</div>

                                            </div>
                                            <div class="col-sm-4">

                                                <h5> Order Date: </h5>
												<div class="form-group row">
													<div class="col-md-12">
														<input class="form-control form-control-inline" type="text" value="<?php echo @$so_options['reference_po_date']; ?>" name="reference_po_date" readonly style="background:white;" />
													</div>
												</div>

                                            </div>
											<div class="col-sm-4">

                                                <h5> Our Order #: </h5>
												<div class="form-group row">
													<div class="col-md-12">
														<input class="form-control form-control-inline" type="text" value="<?php echo @$so_options['our_order']; ?>" name="our_order" readonly style="background:white;" />
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
																//if ( ! $product) continue;

                                                                // set image paths
                                                                // the new way relating records with media library
                                                                $style_no = $item;
                                                                $image_new = $product->media_path.$style_no.'_f3.jpg';
                                                                $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
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
                                                                <div class="shop-cart-item-details" style="margin-left:80px;" data-st_id="<?php echo $product->st_id; ?>">
																	<?php
																	if (@$product->st_id)
																	{
																		$upcfg['st_id'] = $product->st_id;
																		$upcfg['size_label'] = $size_label;
																		$this->upc_barcodes->initialize($upcfg);
																		echo $this->upc_barcodes->generate();
																		?>
																	<div style="display:inline-block;float:right;text-align:center;">
																		<svg style="float:right;"
																			class="barcode"
																			jsbarcode-format="upc"
																			jsbarcode-value="<?php echo $this->upc_barcodes->generate(); ?>"
																			jsbarcode-textmargin="0"
																			jsbarcode-width="1"
																			jsbarcode-height="60"
																			jsbarcode-fontoptions="bold">
																		</svg><br />
																		<a class="small" href="<?php echo site_url($this->uri->segment(1).'/barcodes/print/so_item/index/'.$product->st_id.'/'.$size_label); ?>" target="_blank">
									                                        <i class="fa fa-print"></i> Print Barcode
									                                    </a>
																	</div>
																		<?php
																	} ?>
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
												<p>
													<?php echo $so_details->remarks; ?>
												</p>
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

							</div>
					    </div>
					</div>
					<!-- END PAGE CONTENT INNER -->
