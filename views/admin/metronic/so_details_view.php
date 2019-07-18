                                    <!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<?php /* echo form_open(
										(
                                            $this->uri->segment(1) === 'sales'
                                            ? 'sales/sales_orders/create'
                                            : $this->config->slash_item('admin_folder').'sales_orders/create'
                                        ),
										array(
											'class'=>'form-horizontal',
											'id'=>'form-sales_orders_create'
										)
									); */ ?>

                                    <div class="row printable-content" id="print-to-pdf">

                                        <div class="col-sm-12 so-number margin-bottom-10">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3 class="margin-bottom-20">
                                                        <strong> SALES ORDER #<?php echo $so_details->so_number; ?> </strong> <?php echo @$this->sales_order_details->rev ? '<small><b>rev</b></small><strong>'.@$this->sales_order_details->rev.'</strong>' : ''; ?> <br />
                                                        <small> Date: <?php echo $so_details->so_date; ?> </small>
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

                                                    <p><strong> BILL TO </strong></p>

                                                    <p>
                                                        <?php echo $so_details->store_name ?: 'STORE NAME'; ?> <br />
                                                        <?php echo $so_details->bill_address1 ?: 'Address1'; ?> <br />
                                                        <?php echo $so_details->bill_address2 ? $so_details->bill_address2.'<br />' : ''; ?>
                                                        <?php echo $so_details->bill_city ?: 'City'; ?>, <?php echo $so_details->bill_state ?: 'State'; ?> <?php echo $so_details->bill_zipcode ?: 'Zipcode' ?>  <br />
                                                        <?php echo $so_details->bill_country ?: 'Country'; ?> <br />
                                                        <?php echo $so_details->telephone ?: 'Telephone'; ?> <br />
                                                        ATTN: <?php echo $so_details->firstname ? $so_details->firstname.' '.$so_details->lastname : 'Contact Name'; ?> <?php echo $so_details->email ? '('.safe_mailto($so_details->email).')': '(Email)'; ?>
                                                    </p>

                                                </div>
                                                <div class="col-sm-6">

                                                    <p><strong> SHIP TO </strong></p>

                                                    <p>
                                                        <?php echo $so_details->store_name ?: 'STORE NAME'; ?> <br />
                                                        <?php echo $so_details->ship_address1 ?: $so_details->bill_address1; ?> <br />
                                                        <?php echo $so_details->ship_address2 ? $so_details->ship_address2.'<br />' : ($so_details->bill_address2 ? $so_details->bill_address2.'<br />' : ''); ?>
                                                        <?php echo $so_details->ship_city ?: $so_details->bill_city; ?>, <?php echo $so_details->ship_state ?: $so_details->bill_state; ?> <?php echo $so_details->ship_zipcode ?: $so_details->bill_zipcode; ?> <br />
                                                        <?php echo $so_details->ship_country ?: $so_details->bill_country; ?> <br />
                                                        <?php echo $so_details->telephone ?: 'Telephone'; ?> <br />
                                                        ATTN: <?php echo $so_details->firstname ? $so_details->firstname.' '.$so_details->lastname : 'Contact Name'; ?> <?php echo $so_details->email ? '('.safe_mailto($so_details->email).')': '(Email)'; ?>
                                                    </p>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-sm-12 so-author">
                                            <p>
                                                Ordered by: &nbsp;<?php echo @$author->fname.' '.@$author->lname; ?> &nbsp; <cite class="small"><?php echo safe_mailto(@$author->email); ?></cite>
                                                <br />
                                                Designer: &nbsp;<?php echo $so_details->designer ?: 'General Items'; ?>
                                                <br />
                                                <?php echo $so_details->vendor_name ? 'Vendor: &nbsp;'.$so_details->vendor_name.' ('.$so_details->vendor_code.')' : '';?>
                                            </p>
                                        </div>

                                        <div class="col-sm-12 m-grid so-misc">
                                            <div class="m-grid-row">
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Due Date: </h5>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_details->due_date; ?>" readonly />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Shipping Method: </h5>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['ship_via']; ?>" readonly />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Shipping Terms: </h5>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['fob']; ?>" readonly />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="m-grid-col m-grid-col-sm-3">

                                                    <h5> Payment Terms: </h5>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <input class="form-control form-control-inline" size="16" type="text" value="<?php echo @$so_options['terms']; ?>" readonly />
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

                                                                    <div class="margin-top-10">
                                                                        <a href="#barcode-<?php echo $item?>" data-toggle="modal" class="btn dark btn-outline btn-sm">Print Barcode Labels</a>
                                                                    </div>

                                                                </td>

                                                                <?php
                                                                /**********
                                                                 * Unit Vendor Price
                                                                 */
                                                                ?>
                                                                <td class="text-right" style="vertical-align:top;">
                                                                    $ <?php echo number_format($size_qty['wholesale_price'], 2); ?>
                                                                </td>

                                                                <?php
                                                                /**********
                                                                 * Subtotal
                                                                 */
                                                                ?>
                                                                <td class="text-right" style="vertical-align:top;">
                                                                    <?php
                                                                    $this_size_total = $this_size_qty * $size_qty['wholesale_price'];
                                                                    ?>
                                                                    $ <?php echo $this->cart->format_number($this_size_total); ?>
                                                                </td>

                                                                <input type="hidden" class="input-order-subtotal <?php echo $item.' '.$product->prod_no; ?>" name="subtotal" value="<?php echo $this_size_total; ?>" />

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
                                                                                        PO# <?php echo $so_details->so_number; ?> - <strong><?php echo $item; ?></strong> Barcodes
                                                                                    </div>
                                                                                    <?php
                                                                                    $variables='';
                                                                                    $all=$size_qty;
                                                                                    $all['prod_no']=$product->prod_no;
                                                                                    $all['color_code']=$product->color_code;
                                                                                    $all['color_name']=$product->color_name;
                                                                                    foreach ($all as $key => $row)
                                                                                    {
                                                                                        $variables.=$key.'='.$row.'&';
                                                                                    }

                                                                                    ?>
                                                                                    <div class="col col-sm-3 margin-bottom-10">
                                                                                        <a href="<?php echo site_url('admin/barcodes/print_all_barcodes/'.$product->st_id); ?>?<?php echo $variables ?>" class="btn dark btn-outline btn-sm" target="_blank">Print All Barcodes</a>
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
                                                                                        if ($size_label != 'color_name' && $size_label != 'vendor_price' && $size_label != 'prod_no' && $size_label != 'color_code' && $size_label != 'wholesale_price')
                                                                                        { ?>

                                                                                <div class="row margin-bottom-10">
                                                                                    <div class="col col-sm-2">
                                                                                        <?php echo $size_label; ?>
                                                                                    </div>
                                                                                    <div class="col col-sm-2">
                                                                                        <?php echo $qty; ?>
                                                                                    </div>
                                                                                    <div class="col col-sm-4">
                                                                                        <?php
                                                                                        $code_text = $product->prod_no.'-'.$product->color_code.'-'.$size_label.'-'.$product->st_id;
                                                                                        $barcode_image_name = $product->prod_no.'_'.$product->color_code.'_'.$size_label.'_'.$product->st_id;
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
                                                                                                <span style="float:right;">STOCK ID: <?php echo isset($product->st_id) ? $product->st_id :''; ?></span>
                                                                                                <span><?php echo isset($product->prod_no) ? $product->prod_no:''; ?></span><br />
                                                                                                <span><?php echo isset($product->color_name) ? $product->color_name :''; ?></span><br />
                                                                                                <span><?php echo isset($size_label) ? strtoupper(str_replace('_',' ',$size_label)) :''; ?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col col-sm-4">
                                                                                        <a href="<?php echo site_url('admin/barcodes/print_barcode/'.$product->st_id); ?>?size_label=<?php echo $size_label; ?>" class="btn dark btn-outline btn-sm" target="_blank">Print Barcode</a>
                                                                                         <a href="<?php echo site_url('admin/products/barcodes/print_all/'.$product->st_id.'/'.$qty.'/'.$size_label); ?>" class="btn dark btn-outline btn-sm" target="_blank">Print All</a>
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

                                        <?php if ( ! empty($so_items))
                                        { ?>

                                        <div class="col-sm-12 status-with-items">
                                            <div class="row">

                                                <div class="col-sm-7">

                                                    <?php
                                    				if($so_details->remarks)
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

									<!--</form>
									<!-- END FORM-->
