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

		                        </div>

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
									<div class="col-md-6 pull-right hide">
			                            <div class="form-group" data-site_section="<?php echo $this->uri->segment(1); ?>" data-object_data='{"po_id":"<?php echo $this->sales_order_details->po_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
			                                <label class="control-label col-md-2">Status</label>
			                                <div class="col-md-10">
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('0','1','2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Open/Pending
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Picked and Packed (Partial/Complete)
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('3','4','5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; In Transit (Partial/Complete)
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('4','5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Delivered Partial (Shows only on partial delivery)
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo in_array($this->sales_order_details->status, array('5')) ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; Complete/Delivered
			                                    </cite>
			                                    <br />
			                                    Others:
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo $this->sales_order_details->status == '6' ? 'check-' : ''; ?>square-o"></i>
			                                         &nbsp; On Hold
			                                    </cite>
			                                    <cite class="small" style="font-weight:100;display:block;">
			                                        <i class="fa fa-<?php echo $this->sales_order_details->status == '7' ? 'check-' : ''; ?>square-o"></i>
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
                                <div class="row printable-content">

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
	                                 * Action Buttons
	                                 */
	                                ?>
									<div class="col-sm-4 pick-and-pack pull-right" style="margin-top:85px;">
										<div class="row">
											<div class="col-sm-12 button-actions" data-object_data='{"so_id":"<?php echo $this->sales_order_details->so_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
												<button class="btn dark btn-block btn-lg manual-pick">PICK AND PACK ITEMS MANUALLY<br />TO COMPLETE SALES ORDER</button>
												<button class="btn grey-mint btn-block btn-lg scan-pick">SCAN OUT ITEMS USING BARCODE</button>
												<div class="input-icon input-icon-lg right display-none input-upc_barcode" style="margin-top:5px;">
		                                            <i class="fa fa-barcode font-dark tooltips" data-original-title="Cancel"></i>
		                                            <input type="text" class="form-control input-lg" name="upc_barcode" placeholder="Scan Barcode...">
												</div>
												<hr style="margin:15px 0;border-color:#ccc;border-width:1px;" />
												<button class="btn btn-block btn-lg update-so-mod">UPDATE SALES ORDER DETAILS</button>
											</div>
										</div>
									</div>

									<?php
	                                /***********
	                                 * Cart Basket
	                                 */
	                                ?>
                                    <div class="col-sm-8 so-cart cart_basket_wrapper">

										<!--------------------------------->
										<hr style="margin:15px 0;border-color:#ccc;border-width:1px;" />
										<div class="cart-basket">

                                            <div class="table-scrollable table-scrollable-borderless">
                                                <table class="table table-striped table-hover table-light">
                                                    <thead>
														<tr>
															<th style="width:50px;border-bottom:none;"></th>
	                                                        <th colspan="3" class="text-center" style="padding:unset;border-bottom:none;border-left:1px solid #F2F5F8;border-right:1px solid #F2F5F8;"> Qty </th>
	                                                        <th colspan="6" style="border-bottom:none;"></th>
	                                                    </tr>
	                                                    <tr>
															<th></th>
	                                                        <th class="text-center" style="width:50px;vertical-align:top;color:black;border-left:1px solid #F2F5F8;"> Req'd </th>
	                                                        <th class="text-center" style="width:50px;vertical-align:top;color:black;"> Ship'd </th>
	                                                        <th class="text-center" style="width:50px;vertical-align:top;color:black;border-right:1px solid #F2F5F8;"> B.O. </th>
	                                                        <th style="vertical-align:top;color:black;"> Item/Desc </th>
	                                                        <th style="vertical-align:top;width:60px;color:black;" class="text-right"> Availabe Stock </th>
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
	                                                            $temp_size_mode = 1; // default size mode

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

                                                        <tr class="summary-item-container <?php echo $item.' '.$size_label; ?>" data-item="<?php echo $item; ?>" data-size_label="<?php echo $size_label; ?>">

															<?php
                                                            /**********
                                                             * Checkbox
                                                             */
                                                            ?>
                                                            <td class="text-center" style="vertical-align:top;">
																<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
							                                        <input type="checkbox" class="checkboxes" name="checkbox[]" value="<?php echo $so_details->so_id; ?>" />
							                                        <span></span>
							                                    </label>
                                                            </td>

															<?php
                                                            /**********
                                                             * Quantities
                                                             */
                                                            ?>
															<td style="vertical-align:top;" class="reqd"><?php echo $qty[0]; ?></td>
															<td style="vertical-align:top;" class="shipd"><?php echo @$qty[1]; ?></td>
															<td style="vertical-align:top;" class="bo"><?php echo @$qty[2]; ?></td>

                                                            <?php
                                                            /**********
															 * Item/Description
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
																		$upcfg['st_id'] = $product->prod_no;
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
                                                                        Color: &nbsp; <?php echo $product->color_name; ?><br />
																		<?php echo 'Size '.$s; ?>
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
                                                             * Available Stock
                                                             */
                                                            ?>
                                                            <td class="text-center stock" style="vertical-align:top;">
                                                                <?php echo @$product->$size_label; ?>
                                                            </td>

                                                        </tr>
																		<?php
																	}
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

                                </div>

							</div>
					    </div>
					</div>
					<!-- END PAGE CONTENT INNER -->
