					<!-- BEGIN PAGE CONTENT INNER -->
					<?php
					$url_pre = @$role == 'sales' ? 'my_account/sales' : 'admin';
					?>
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
											<a class="btn blue" href="<?php echo site_url($url_pre.'/sales_orders/create'); ?>">
		                                        <i class="fa fa-plus"></i> Create New Sales Order </a>
		                                    <a class="btn btn-secondary-outline" href="<?php echo site_url($url_pre.'/sales_orders'); ?>">
		                                        <i class="fa fa-reply"></i> Back to Sales Order list</a>
		                                </div>
		                            </div>
		                            <hr />
		                            <div class="portlet-title">

		                                <?php if ($this->sales_order_details->status != '5')
		                                { ?>

		                                <div class="caption modify-so">
		                                    <!--
		                                    <a class="btn dark " href="<?php echo site_url($url_pre.'/sales_orders/modify/index/'.$so_details->sales_order_id); ?>">
		                                    -->
		                                    <a class="btn dark hide" href="javascript:;">
		                                        <i class="fa fa-pencil"></i> Modify SO
		                                    </a>
		                                </div>

		                                    <?php
		                                } ?>

		                                <div class="actions btn-set">
											<a class="btn default so-pick-and-pack" href="<?php echo site_url($url_pre.'/sales_orders/pick_and_pack/index/'.$so_details->sales_order_id); ?>">
		                                        <i class="fa fa-dropbox"></i> PICK and PACK
		                                    </a>
		                                    &nbsp;
		                                    <a class="btn dark" href="<?php echo site_url('admin/barcodes/print/so/index/'.$so_details->sales_order_id); ?>" target="_blank">
		                                        <i class="fa fa-print"></i> Print All Barcodes
		                                    </a>
											&nbsp;
		                                    <a class="btn default po-pdf-print_" href="<?php echo site_url($url_pre.'/sales_orders/view_packing_list/index/'.$so_details->sales_order_id); ?>" target="_blank">
		                                        <i class="fa fa-eye"></i> View PACKING LIST for Print/Download
		                                    </a>
		                                    &nbsp;
		                                    <a class="btn btn-default po-pdf-print_" href="<?php echo site_url($url_pre.'/sales_orders/view_pdf/index/'.$so_details->sales_order_id); ?>" target="_blank">
		                                        <i class="fa fa-eye"></i> View PDF for Print/Download
		                                    </a>
		                                    &nbsp;
		                                    <a class="btn dark " href="<?php echo site_url($url_pre.'/sales_orders/send/index/'.$so_details->sales_order_id); ?>">
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
											<button class="close" data-close="alert"></button> Purchase Order successfully created!
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'sent') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> Purchase Order successfully sent via email!
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
			                            <div class="form-group" data-site_section="<?php echo $this->uri->segment(1); ?>" data-object_data='{"po_id":"<?php echo $this->sales_order_details->po_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
			                                <label class="control-label col-md-2">Status</label>
			                                <div class="col-md-10">
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('0','1','2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Open/Pending
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('1','2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Picked and Packed (Partial/Complete)
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; In Transit (Partial/Complete)
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Complete/Delivered
			                                    </cite>
			                                    <br />
			                                    Others:
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo $this->sales_order_details->status == '6' ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Delivered Partial (Shows only on partial delivery)
			                                    </cite>
												<cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo $this->sales_order_details->status == '7' ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; On Hold
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo $this->sales_order_details->status == '8' ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Cancelled
			                                    </cite>
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

									<?php
	                                /***********
	                                 * SO Number and Revisions
	                                 */
	                                ?>
                                    <div class="col-sm-12 so-number margin-bottom-10">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3>
                                                    <strong> SALES ORDER #<?php echo $so_number; ?> </strong> <?php echo @$this->sales_order_details->rev ? '<small><b>rev</b></small><strong>'.@$this->sales_order_details->rev.'</strong>' : ''; ?> <br />
                                                    <small> Date: <?php echo $so_date; ?> </small>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

									<?php
	                                /***********
	                                 * BILL TO / SHIP TO
	                                 */
	                                ?>
                                    <div class="col-sm-12 so-addresses">
                                        <div class="row">

                                            <div class="col-sm-6">

                                                <p><strong> BILLING ADDRESS </strong></p>

                                                <p>
													<?php echo @$store_details->store_name; ?> <br />
													<?php echo @$store_details->address1; ?> <br />
													<?php echo @$store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
													<?php echo @$store_details->city.', '.@$store_details->state.' '.@$store_details->zipcode; ?> <br />
													<?php echo @$store_details->country; ?> <br />
													<?php echo @$store_details->telephone; ?> <br />
                                                </p>

                                            </div>
                                            <div class="col-sm-6">

                                                <p><strong> SHIPPING ADDRESS </strong></p>

                                                <p>
													<?php echo @$store_details->store_name; ?> <br />
													<?php echo @$store_details->address1; ?> <br />
													<?php echo @$store_details->address2 ? $store_details->address2.'<br />' : ''; ?>
													<?php echo @$store_details->city.', '.@$store_details->state.' '.@$store_details->zipcode; ?> <br />
													<?php echo @$store_details->country; ?> <br />
													<?php echo @$store_details->telephone; ?> <br />
													ATTN: <?php echo @$store_details->fname ? $store_details->fname.' '.@$store_details->lname : ''; ?> <?php echo @$store_details->email ? '('.safe_mailto($store_details->email).')': ''; ?>
                                                </p>

                                            </div>

                                        </div>
                                    </div>

									<?php
	                                /***********
	                                 * Author
	                                 */
	                                ?>
                                    <div class="col-sm-12 so-author">
                                        <p>
                                            Sales Person: &nbsp;<?php echo $this->sales_order_details->author == '1' ? 'IN-HOUSE' : $author->fname.' '.$author->lname.' ('.safe_mailto($author->email).')'; ?>
                                        </p>
                                    </div>

									<?php
	                                /***********
	                                 * SO Options 1
	                                 */
	                                ?>
	                                <div class="col-sm-12 m-grid m-grid-responsive-sm so-summary-options1">
	                                    <div class="m-grid-row">
	                                        <div class="m-grid-col">

	                                            <h6> Ref Check Out Order#: </h6>
	                                            <div class="form-group row">
	                                                <div class="col-md-4 col-sm-12">
	                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['ref_checkout_no']; ?>" name="options[ref_checkout_no]" />
	                                                </div>
	                                            </div>

	                                        </div>
	                                    </div>
	                                </div>

									<?php
	                                /***********
	                                 * SO Options 2
	                                 */
	                                ?>
	                                <div class="col-sm-12 m-grid m-grid-responsive-sm so-summary-options2">
	                                    <div class="m-grid-row">
	                                        <div class="m-grid-col">

	                                            <h6> Ship By Date: </h6>
	                                            <div class="form-group row">
	                                                <div class="col-md-12">
	                                                    <input class="form-control form-control-inline date-picker" type="text" value="<?php echo $this->sales_order_details->delivery_date; ?>" name="delivery_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
	                                                    <span class="help-block small hide" style="font-size:0.8em;"> Click to Select date </span>
	                                                </div>
	                                            </div>

	                                        </div>
	                                        <div class="m-grid-col">

	                                            <h6> Ship Via: </h6>
	                                            <div class="form-group row">
	                                                <div class="col-md-12">
	                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['ship_via']; ?>" name="options[ship_via]" />
	                                                </div>
	                                            </div>

	                                        </div>
	                                        <div class="m-grid-col">

	                                            <h6> F.O.B: </h6>
	                                            <div class="form-group row">
	                                                <div class="col-md-12">
	                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['fob']; ?>" name="options[fob]" />
	                                                </div>
	                                            </div>

	                                        </div>
	                                        <div class="m-grid-col">

	                                            <h6> Terms: </h6>
	                                            <div class="form-group row">
	                                                <div class="col-md-12">
	                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['terms']; ?>" name="options[terms]" />
	                                                </div>
	                                            </div>

	                                        </div>
	                                    </div>
	                                </div>

									<?php
	                                /***********
	                                 * Cart Basket
	                                 */
	                                ?>
                                    <div class="col-sm-12 so-cart cart_basket_wrapper">

										<!--------------------------------->
										<hr style="margin:15px 0;border-color:#ccc;border-width:1px;" />
										<div class="cart-basket">

                                            <div class="table-scrollable table-scrollable-borderless">
                                                <table class="table table-striped table-hover table-light">
                                                    <thead>
														<tr>
	                                                        <th colspan="3" class="text-center" style="padding:unset;border-bottom:none;border-right:1px solid #F2F5F8;"> Qty </th>
	                                                        <th colspan="6" style="border-bottom:none;"></th>
	                                                    </tr>
	                                                    <tr>
	                                                        <th class="text-center" style="width:50px;vertical-align:top;color:black;"> Req'd </th>
	                                                        <th class="text-center" style="width:50px;vertical-align:top;color:black;"> Ship'd </th>
	                                                        <th class="text-center" style="width:50px;vertical-align:top;color:black;border-right:1px solid #F2F5F8;"> B.O. </th>
	                                                        <th style="vertical-align:top;color:black;"> Items </th>
	                                                        <th style="vertical-align:top;color:black;"> Desc </th>
	                                                        <th></th> <!-- Remove button -->
	                                                        <th style="vertical-align:top;width:80px;color:black;" class="text-right">
	                                                            Unit Price
	                                                        </th>
	                                                        <th style="vertical-align:top;width:60px;color:black;" class="text-right"> Disc </th>
	                                                        <th style="vertical-align:top;width:80px;color:black;" class="text-right"> Extended </th>
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
																// just a catch all error suppression
	                                                            if ( ! $item) continue;

                                                                // get product details
                                                                $exp = explode('_', $item);
                                                                $product = $this->product_details->initialize(
                                                                    array(
                                                                        'tbl_product.prod_no' => $exp[0],
                                                                        'color_code' => $exp[1]
                                                                    )
                                                                );

																// set image paths
	                                                            $style_no = $item;
	                                                            $prod_no = $exp[0];
	                                                            $color_code = $exp[1];

                                                                // take designer details size mode
																// '1' for default size mode
                                                                $temp_size_mode = @$designer_details->webspace_options['size_mode'] ?: '1';

																// price can be...
	                                                            // onsale price (retail_sale_price or wholesale_price_clearance)
	                                                            // regular price (retail_price or wholesale_price)
	                                                            if (@$product->custom_order == '3')
	                                                            {
	                                                                $price =
	                                                                    $this->session->admin_so_user_cat == 'ws'
	                                                                    ? (@$product->wholesale_price_clearance ?: 0)
	                                                                    : (@$product->retail_sale_price ?: 0)
	                                                                ;
	                                                            }
	                                                            else
	                                                            {
	                                                                $price =
	                                                                    $this->session->admin_so_user_cat == 'ws'
	                                                                    ? (@$product->wholesale_price ?: 0)
	                                                                    : (@$product->retail_price ?: 0)
	                                                                ;
	                                                            }

																if ($product)
	                                                            {
	                                                                $image_new = $product->media_path.$style_no.'_f3.jpg';
	                                                                $img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f3.jpg';
	                                                                $img_linesheet = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_linesheet.jpg';
	                                                                $img_large = $this->config->item('PROD_IMG_URL').$product->media_path.$style_no.'_f.jpg';
	                                                                $size_mode = $product->size_mode;
	                                                                $color_name = $product->color_name;
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
					                                			foreach ($size_qty as $size_label => $qty)
					                                			{
					                                				$this_size_qty = $qty[0];
					                                				$s = $size_names[$size_label];

																	// calculate available stocks
	                                                                // and check for on sale items
	                                                                if ($product)
	                                                                {
																		if ($product->$size_label == '0')
																		{
																			$preorder = TRUE;
																			$partial_stock = FALSE;
																		}
																		elseif ($qty[0] <= $product->$size_label)
																		{
																			$preorder = FALSE;
																			$partial_stock = FALSE;
																		}
																		elseif ($qty[0] > $product->$size_label)
																		{
																			$preorder = TRUE;
																			$partial_stock = TRUE;
																		}
																		else
																		{
																			$preorder = FALSE;
																			$partial_stock = FALSE;
																		}
	                                                                    $onsale =
	                                                                        $product->custom_order == '3'
	                                                                        ? TRUE
	                                                                        : FALSE
	                                                                    ;
	                                                                }
	                                                                else
	                                                                {
	                                                                    // item not in product list
																		$preorder = FALSE;
																		$partial_stock = FALSE;
	                                                                    $onsale = FALSE;
	                                                                }

					                                				if (
					                                                    isset($size_qty[$size_label])
					                                                    && $s != 'XL1' && $s != 'XL2'
					                                                )
					                                				{
                                                                ?>

                                                        <tr class="summary-item-container">

															<?php
                                                            /**********
                                                             * Quantities
                                                             */
                                                            ?>
															<td style="vertical-align:top;"><?php echo $qty[0]; ?></td>
															<td style="vertical-align:top;"><?php echo @$qty[1]; ?></td>
															<td style="vertical-align:top;"><?php echo @$qty[2]; ?></td>

															<?php
                                                            /**********
                                                             * Item Number
                                                             */
                                                            ?>
															<td style="vertical-align:top;">
																<?php echo $prod_no; ?><br />
	                                                            <?php echo $color_name; ?><br />
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
                                                                    <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;">
                                                                </a>
                                                                <div class="shop-cart-item-details" style="margin-left:80px;" data-st_id="<?php echo @$product->st_id; ?>">
																	<?php
																	if (@$product->st_id)
																	{
																		$upcfg['prod_no'] = $product->prod_no;
																		$upcfg['st_id'] = $product->st_id;
																		$upcfg['size_label'] = $size_label;
																		$this->upc_barcodes->initialize($upcfg);
																		//echo $this->upc_barcodes->max_st_id;
																		//echo $this->upc_barcodes->generate();
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
																		<a class="small" href="<?php echo site_url($this->uri->segment(1).'/barcodes/print/so_item/index/'.$this->sales_order_details->so_number.'/'.$item.'/'.$size_label); ?>" target="_blank">
									                                        <i class="fa fa-print"></i> Print Barcode
									                                    </a>
																	</div>
																		<?php
																	} ?>
                                                                    <h5 style="margin:0px;">
                                                                        <?php echo $prod_no; ?>
                                                                    </h5>
                                                                    <p style="margin:0px;">
                                                                        <span style="color:#999;">Style#: <?php echo $item; ?></span><br />
                                                                        Color: &nbsp; <?php echo $color_name; ?>
																		<?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
																		<?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
                                                                    </p>
																	<?php if ($onsale) { ?>
	                                                                <span class="badge bg-red-mint badge-roundless display-block"> On Sale </span>
	                                                                <?php } ?>
																	<?php if ($preorder) { ?>
	                                                                <span class="badge badge-danger badge-roundless display-block"> Pre Order </span>
	                                                                <?php } ?>
																	<?php if ($partial_stock) { ?>
	                                                                <span class="badge badge-warning badge-roundless display-block"> Parial Stock </span>
	                                                                <?php } ?>
                                                                </div>
                                                            </td>

															<?php
	                                                        /**********
	                                                         * Blank - remove button on create page
	                                                         */
	                                                        ?>
	                                                        <td class="text-right">
	                                                        </td>

                                                            <?php
                                                            /**********
                                                             * Unit WS Price
                                                             */
                                                            ?>
                                                            <td class="text-right" style="vertical-align:top;">
                                                                $ <?php echo number_format($price, 2); ?>
                                                            </td>

															<?php
	                                                        /**********
	                                                         * Discount
	                                                         */
	                                                        ?>
	                                                        <td class="text-right discount-wrapper" style="vertical-align:top;">
	                                                            <?php
	                                                            $disc = @$size_qty['discount'] ?: 0;
	                                                            if ($disc == '0') echo '-';
	                                                            else echo number_format($disc, 2);
	                                                            ?>
	                                                        </td>

                                                            <?php
                                                            /**********
                                                             * Subtotal
                                                             */
                                                            ?>
                                                            <td class="text-right" style="vertical-align:top;">
                                                                <?php
                                                                $this_size_total = $this_size_qty * ($price - $disc);
                                                                ?>
																$ <?php echo number_format($this_size_total, 2); ?>
                                                            </td>

                                                        </tr>
																		<?php
																	}

																	$overall_qty += $this_size_qty;
	                                                                $overall_total += $this_size_total;
																}

                                                                $i++;
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
