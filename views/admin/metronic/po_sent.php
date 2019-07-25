                                    <!-- BEGIN PAGE CONTENT INNER -->
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

                                                <div class="portlet solid " style="padding:0 15px;">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <a class="btn dark " href="<?php echo site_url('admin/purchase_orders/modify/index/'.$po_details->po_id); ?>">
                                                                <i class="fa fa-pencil"></i> Modify PO
                                                            </a>
                                                        </div>
                                                        <div class="actions btn-set">
                                                            <a class="btn dark" href="<?php echo site_url('admin/products/barcodes/print_po_barcodes/'.$po_details->po_id); ?>" target="_blank">
                                                                <i class="fa fa-print"></i> Print PO Barcodes
                                                            </a>
                                                            &nbsp;
                                                            <a class="btn btn-default po-pdf-print_" href="<?php echo site_url('admin/purchase_orders/view_pdf/index/'.$po_details->po_id); ?>" target="_blank">
                    											<i class="fa fa-eye"></i> View PDF for Print/Download
                                                            </a>
                                                            &nbsp;
                                                            <a class="btn dark " href="<?php echo site_url('admin/purchase_orders/create/send/'.$po_details->po_id.'/send'); ?>">
                    											<i class="fa fa-send"></i> Send PO Again
                                                            </a>
                    									</div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row printable-content" id="print-to-pdf">

                                                <div class="col-sm-12 po-summary-number margin-bottom-20">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h3>
                                                                <strong> PURCHASE ORDER #<?php echo $po_details->po_number; ?> <br />
                                                                <small> Date: <?php echo $po_details->po_date; ?> </small>
                                                            </h3>
                                                            <h4>
                                                                <?php echo @$po_options['ref_po_no'] ? 'Reference Manual PO#: '.$po_options['ref_po_no'] : ''; ?>
                                                                <?php echo (@$po_options['ref_po_no'] && @$po_options['ref_so_no']) ? '<br />' : ''; ?>
                                                                <?php echo @$po_options['ref_so_no'] ? 'Reference SO#: '.$po_options['ref_so_no'] : ''; ?>
                                                            </h4>
                                                            <p>
                                                                <?php echo $company_name; ?> <br />
                                                                <?php echo $company_address1; ?><br />
                                                                <?php echo $company_address2 ? $company_address2.'<br />' : ''; ?>
                                                                <?php echo $company_city.', '.$company_state.' '.$company_zipcode; ?><br />
                                                                <?php echo $company_country; ?><br />
                                                                <?php echo $company_telephone; ?>
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
                                                                <?php echo $store_details->store_name ?: $company_name; ?> <br />
                                                                <?php echo $store_details->address1 ?: $company_address1; ?> <br />
                                                                <?php echo $store_details->address2 ? $store_details->address2.'<br />' : $company_address2 ? $company_address2.'<br />' : ''; ?>
                                                                <?php echo $store_details->city ?: $company_city; ?>, <?php echo $store_details->state ?: $company_state; ?> <?php echo $store_details->zipcode ?: $company_zipcode; ?> <br />
                                                                <?php echo $store_details->country ?: $company_country; ?> <br />
                                                                <?php echo $store_details->telephone ?: $company_telephone; ?> <br />
                                                                ATTN: <?php echo $store_details->fname ? $store_details->fname.' '.$store_details->lname : $company_contact_person; ?> <?php echo $store_details->email ? '('.safe_mailto($store_details->email).')' : '('.safe_mailto($company_contact_email).')'; ?>
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
                                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo $this->purchase_order_details->delivery_date; ?>" readonly />
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
                                                                            $style_no = $item;
                                                                            $prod_no = $exp[0];
                                                                            $color_code = $exp[1];
                                                                            $temp_size_mode = 1; // default size mode

                                                                            if ($product)
                                                                            {
                                                                                $image_new = $product->media_path.$style_no.'_f3.jpg';
                                                                                $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
                                                                                $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
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
                                                                                $size_mode = $this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
                                                                                $color_name = $this->product_details->get_color_name($color_code);
                                                                            }

                                                                            // get size names
                                                                            $size_names = $this->size_names->get_size_names($size_mode);
                                                                            ?>

																	<tr class="summary-item-container">
																		<?php
																		/**********
																		 * Item IMAGE and Details
																		 * Image links to product details page
																		 */
																		?>
																		<td>
                                                                            <a href="<?php echo $img_linesheet ?: 'javascript:;'; ?>" class="<?php echo $img_linesheet ? 'fancybox' : ''; ?> pull-left">
                                                                                <img class="img-a" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg'; ?>');" />
                                                                            </a>
																			<div class="shop-cart-item-details" style="margin-left:80px;">
                                                                                <h4 style="margin:0px;">
                                                                                    <?php echo $item; ?>
                                                                                </h4>
                                                                                <p style="margin:0px;">
                                                                                    <span style="color:#999;">Product#: <?php echo $item; ?></span><br />
                                                                                    Size: &nbsp; <?php echo '2'; ?><br />
                                                                                    Color: &nbsp; <?php echo $color_name; ?>
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
                                                                            <?php
                                                                            $this_size_qty = 0;
                                                                            //for ($s=0;$s<23;$s=$s+2)
                                                                            foreach ($size_names as $size_label => $s)
                                                                            {
                                                                                //$size_label = 'size_'.$s;
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
                                                                                <input tpye="text" class="this-total-qty <?php echo $item.' '.$prod_no; ?>" style="border:1px solid #ccc;font-size:12px;width:30px;padding-left:5px;background-color:white;" value="<?php echo $this_size_qty; ?>" readonly />
                                                                            </div>

                                                                            <div class="margin-top-10 hide">
                                                                                <a href="#barcode-<?php echo $item?>" data-toggle="modal" class="btn dark btn-outline btn-sm">Print Barcode Labels</a>
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
                                                                            $this_size_total = $this_size_qty * $size_qty['vendor_price'];
                                                                            ?>
																			$ <?php echo number_format($this_size_total, 2); ?>
																		</td>

                                                                        <input type="hidden" class="input-order-subtotal <?php echo $item.' '.$prod_no; ?>" name="subtotal" value="<?php echo $this_size_total; ?>" />

                                                                        <?php
                                                                        /**********
                                                                         * Modal for barcode labels
                                                                         */
                                                                        ?>
                                                                        <!-- BARCODES -->
            															<div class="modal fade bs-modal-md" id="barcode-<?php echo $item; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            																<div class="modal-dialog modal-md">
            																	<div class="modal-content">
            																		<div class="modal-header">
            																			<button type="button" class="close dismiss-publish-modal" data-dismiss="modal" aria-hidden="true"></button>
            																			<h4 class="modal-title">Barcode Labels</h4>
            																		</div>
            																		<div class="modal-body">

                                                                                        <div class="row">
                                                                                            <div class="col col-sm-9 margin-bottom-10">
                                                                                                PO# <?php echo $po_details->po_number; ?> - <strong><?php echo $item; ?></strong> Barcodes
                                                                                            </div>
                                                                                            <?php
                                                                                            $variables='';
                                                                                            $all=$size_qty;
                                                                                            $all['prod_no']=$prod_no;
                                                                                            $all['color_code']=$color_code;
                                                                                            $all['color_name']=$color_name;
                                                                                            foreach ($all as $key => $row)
                                                                                            {
                                                                                                $variables.=$key.'='.$row.'&';
                                                                                            }

                                                                                            ?>
                                                                                            <div class="col col-sm-3 margin-bottom-10">
                                                                                                <a href="<?php echo site_url('admin/products/barcodes/print_all_barcodes/'.@$product->st_id); ?>?<?php echo $variables ?>" class="btn dark btn-outline btn-sm" target="_blank">Print All Barcodes</a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row margin-bottom-10">
                                                                                            <div class="col col-sm-2">
                                                                                                <strong>Size</strong>
                                                                                            </div>
                                                                                            <div class="col col-sm-2">
                                                                                                <strong>Qty</strong>
                                                                                            </div>
                                                                                            <div class="col col-sm-4">
                                                                                                <strong>Barcode</strong>
                                                                                            </div>
                                                                                            <div class="col col-sm-4">
                                                                                                <strong>Actions</strong>
                                                                                            </div>
                                                                                        </div>

                                                                                            <?php foreach ($size_qty as $size_label => $qty)
                                                                                            {
                                                                                                if($qty > 0){
                                                                                                if ($size_label != 'color_name' && $size_label != 'vendor_price' && $size_label != 'prod_no' && $size_label != 'color_code' )
                                                                                                { ?>

                                                                                        <div class="row margin-bottom-10">
                                                                                            <div class="col col-sm-2">
                                                                                                Size <?php echo $size_names[$size_label]; ?>
                                                                                            </div>
                                                                                            <div class="col col-sm-2">
                                                                                                <?php echo $qty; ?>
                                                                                            </div>
                                                                                            <div class="col col-sm-4">
                                                                                                <?php
                                                                                                $code_text = $prod_no.'-'.$color_code.'-'.$size_label.'-'.(@$product->st_id ?: '000');
                                                                                                $barcode_image_name = $prod_no.'_'.$color_code.'_'.$size_label.'_'.(@$product->st_id ?: '000');
                                                                                                $imageResource = Zend_Barcode::draw(
                                                                                                    'code128',
                                                                                                    'image',
                                                                                                    //$barcodeOptions,
                                                                                                    array('text' => $code_text,'drawText'=>false,'barHeight' => 50),
                                                                                                    //$rendererOptions
                                                                                                    array()
                                                                                                );
                                                                                                $store_image = imagepng($imageResource, "assets/barcodes/".$barcode_image_name.".png");
                                                                                                ?>
                                                                                                <div style="display:inline-block;text-align:justify;margin:0 auto;">
                                                                                                    <img src="<?php echo base_url(); ?>assets/barcodes/<?php echo $barcode_image_name; ?>.png" style="max-width:102%;" />
                                                                                                    <div style="width:100%;font-size:10px;padding:0 3px;">
                                                                                                        <span style="float:right;">STOCK ID: <?php echo @$product->st_id ?: '---'; ?></span>
                                                                                                        <span><?php echo $prod_no ?: ''; ?></span><br />
                                                                                                        <span><?php echo $color_name ?: ''; ?></span><br />
                                                                                                        <span><?php echo $size_label ? 'SIZE '.$size_names[$size_label] :''; ?></span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col col-sm-4">
                                                                                                <a href="<?php echo site_url('admin/products/barcodes/print_barcode/'.@$product->st_id); ?>?size_label=<?php echo $size_label; ?>" class="btn dark btn-outline btn-sm" target="_blank">Print Barcode</a>
                                                                                                 <a href="<?php echo site_url('admin/products/barcodes/print_all/'.@$product->st_id.'/'.$qty.'/'.$size_label); ?>" class="btn dark btn-outline btn-sm" target="_blank">Print All</a>
                                                                                            </div>
                                                                                        </div>
                                                                                      <?php }  }  } ?>
                                                                                    </div>
            																		<div class="modal-footer">
            																			<button type="button" class="btn dark btn-outline dismiss-publish-modal" data-dismiss="modal">Close</button>
            																			</a>
            																		</div>
            																	</div>
            																	<!-- /.modal-content -->
            																</div>
            																<!-- /.modal-dialog -->
            															</div>
            															<!-- /.modal -->

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

                                                        <div class="col-sm-7">
                                                            <?php if ($po_details->remarks)
                                                            { ?>
                											<p>Remarks/Instructions:</p>
                                                            <small>
                                                                <?php echo $po_details->remarks; ?>
                                                            </small>
                                                                <?php
                                                            } ?>
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
										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
