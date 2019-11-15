                    <div class="row">

                        <?php
                        /***********
                         * Noification area
                         */
                        ?>
                        <div class="notifications col-sm-12 clearfix">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                            <?php if ($this->session->flashdata('success') == 'add') { ?>
                            <div class="alert alert-success ">
                                <button class="close" data-close="alert"></button> Purchase Order successfully added
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('success') == 'sent') { ?>
                            <div class="alert alert-success ">
                                <button class="close" data-close="alert"></button> Purchase Order successfully sent
                            </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('success') == 'approved') { ?>
                            <div class="alert alert-success ">
                                <button class="close" data-close="alert"></button> Purchase Order approved and successfully sent to vendor
                            </div>
                            <?php } ?>
                        </div>

                        <div class="portlet solid " style="padding-right:15px;">

                            <div class="portlet-title <?php echo $this->session->vendor_loggedin ? 'hide' : ''; ?>">
                                <div class="caption font-dark">
                                </div>
                                <div class="actions btn-set">
                                    <a class="btn btn-secondary-outline" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders') : site_url($this->config->slash_item('admin_folder').'purchase_orders'); ?>">
                                        <i class="fa fa-reply"></i> Back to PO list</a>
                                    <a class="btn blue" href="<?php echo $this->uri->segment(1) === 'sales' ? site_url('sales/purchase_orders/create') : site_url($this->config->slash_item('admin_folder').'purchase_orders/create'); ?>">
                                        <i class="fa fa-plus"></i> Create New PO </a>
                                </div>
                            </div>

                            <hr />

                            <div class="portlet-title">

                                <?php if ($this->purchase_order_details->status != '5')
                                { ?>

                                <div class="caption">
                                    <a class="btn dark " href="<?php echo site_url($this->uri->segment(1).'/purchase_orders/modify/index/'.$po_details->po_id); ?>">
                                        <i class="fa fa-pencil"></i> Modify PO
                                    </a>
                                </div>

                                    <?php
                                } ?>

                                <div class="actions btn-set">
                                    <a class="btn dark" href="<?php echo site_url($this->uri->segment(1).'/barcodes/print/po/index/'.$po_details->po_id); ?>" target="_blank">
                                        <i class="fa fa-print"></i> Print All Barcodes
                                    </a>
                                    &nbsp;
                                    <a class="btn btn-default po-pdf-print_" href="<?php echo site_url($this->uri->segment(1).'/purchase_orders/view_pdf/index/'.$po_details->po_id); ?>" target="_blank">
                                        <i class="fa fa-eye"></i> View PDF for Print/Download
                                    </a>
                                    &nbsp;
                                    <a class="btn dark " href="<?php echo site_url($this->uri->segment(1).'/purchase_orders/send/index/'.$po_details->po_id); ?>">
                                        <i class="fa fa-send"></i> Send PO Again
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <?php
                        /***********
                         * Status
                         */
                        ?>
                        <div class="col-md-6 pull-right">
                            <div class="form-group" data-site_section="<?php echo $this->uri->segment(1); ?>" data-object_data='{"po_id":"<?php echo $this->purchase_order_details->po_id; ?>","<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
                                <label class="control-label col-md-2">Status</label>
                                <div class="col-md-10">
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo in_array($this->purchase_order_details->status, array('0','1','2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; Open/Pending Approval
                                    </cite>
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo in_array($this->purchase_order_details->status, array('1','2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; Approved
                                    </cite>
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo in_array($this->purchase_order_details->status, array('2','3','4','5')) ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; Sent to Vendor
                                    </cite>
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo in_array($this->purchase_order_details->status, array('3','4','5')) ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; Email Viewed by Vendor
                                    </cite>
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo in_array($this->purchase_order_details->status, array('4','5')) ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; In Transit
                                    </cite>
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo in_array($this->purchase_order_details->status, array('5')) ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; Complete/Delivered
                                    </cite>
                                    <br />
                                    Others:
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo $this->purchase_order_details->status == '6' ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; On Hold
                                    </cite>
                                    <cite class="small" style="font-weight:100;display:block;">
                                        <i class="fa fa-<?php echo $this->purchase_order_details->status == '7' ? 'check-' : ''; ?>square-o"></i>
                                         &nbsp; Cancelled
                                    </cite>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row printable-content" id="print-to-pdf">

                        <div class="col-sm-12 po-summary-number margin-bottom-20">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>
                                        <strong> PURCHASE ORDER #<?php echo $po_details->po_number; ?> </strong> <?php echo $this->purchase_order_details->rev ? '<small><b>rev</b></small><strong>'.$this->purchase_order_details->rev.'</strong>' : ''; ?> <br />
                                        <small> Date: <?php echo $po_details->po_date; ?> </small>
                                    </h3>
                                    <h4>
                                        <?php echo @$po_options['ref_po_no'] ? 'Reference Manual PO#: '.$po_options['ref_po_no'] : ''; ?>
                                        <?php echo (@$po_options['ref_po_no'] && @$po_options['ref_so_no']) ? '<br />' : ''; ?>
                                        <?php echo @$po_options['ref_so_no'] ? 'Reference SO#: '.$po_options['ref_so_no'] : ''; ?>
                                    </h4>
                                    <br />
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

                                    <p><strong> TO (Vendor Details) </strong></p>

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

                                    <p><strong> SHIP TO </strong></p>

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

                        <div class="col-sm-12 m-grid m-grid-responsive-sm po-summary-options1">
                            <div class="m-grid-row">
                                <div class="m-grid-col">

                                    <h6> Reference SO# (if any): </h6>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input class="form-control form-control-inline bg-white" size="16" type="text" value="<?php echo @$po_options['ref_so_no']; ?>" name="options[ref_so_no]" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="m-grid-col">

                                    <h6> Store Name (optional): </h6>
                                    <div class="form-group row" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
                                        <div class="col-md-12">
                                            <select class="bs-select form-control pull-right" name="options[po_store_id]" data-live-search="true" data-size="5" data-show-subtext="true" data-container="body" disabled>
                                                <option value="<?php echo $store_details->user_id; ?>" data-subtext="<em><?php echo $store_details->email; ?></em>" data-des_slug="<?php echo $store_details->reference_designer; ?>">
                                                    <?php echo ucwords(strtolower($store_details->store_name)); ?>
                                                </option>
                                            </select>
                                            <input class="form-control form-control-inline" size="16" type="hidden" value="<?php echo $this->session->admin_po_store_id; ?>" name="po_store_id" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="m-grid-col">

                                    <h6> Replenishment Options: </h6>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="options[stock_replenishment]" value="1" <?php echo @$po_options['stock_replenishment'] == '1' ? 'checked="checked" disabled' : ''; ?> />
                                                    <span></span>
                                                </span>
                                                <input type="text" class="form-control" value="Stock Replenishment" readonly style="background-color:transparent;" />
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 m-grid po-summary-options2">
                            <div class="m-grid-row">
                                <div class="m-grid-col m-grid-col-sm-2">

                                    <h5> Start Date: </h5>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input class="form-control form-control-inline bg-white" size="16" type="text" value="<?php echo @$po_options['start_date']; ?>" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="m-grid-col m-grid-col-sm-2">

                                    <h5> Cancel Date: </h5>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input class="form-control form-control-inline bg-white" size="16" type="text" value="<?php echo @$po_options['cancel_date']; ?>" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="m-grid-col m-grid-col-sm-2">

                                    <h5> Delivery Date: </h5>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input class="form-control form-control-inline bg-white" size="16" type="text" value="<?php echo $this->purchase_order_details->delivery_date; ?>" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="m-grid-col m-grid-col-sm-2">

                                    <h5> Ship Via: </h5>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input class="form-control form-control-inline bg-white" size="16" type="text" value="<?php echo @$po_options['ship_via']; ?>" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="m-grid-col m-grid-col-sm-2">

                                    <h5> F.O.B: </h5>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input class="form-control form-control-inline bg-white" size="16" type="text" value="<?php echo @$po_options['fob']; ?>" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="m-grid-col m-grid-col-sm-2">

                                    <h5> Terms: </h5>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input class="form-control form-control-inline bg-white" size="16" type="text" value="<?php echo @$po_options['terms']; ?>" readonly />
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
                                                <th class="text-right"> Unit Price </th>
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
                                                    $vendor_price =
                                                        isset($size_qty['vendor_price'])
                                                        ? $size_qty['vendor_price']
                                                        : (@$product->vendor_price ?: 0)
                                                    ;
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
                                                        $size_mode = @$this->designer_details->webspace_options['size_mode'] ?: $temp_size_mode;
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
                                                <td style="vertical-align:top;">
                                                    <a href="<?php echo $img_linesheet ?: 'javascript:;'; ?>" class="<?php echo $img_linesheet ? 'fancybox' : ''; ?> pull-left">
                                                        <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg'; ?>');" />
                                                    </a>
                                                    <div class="shop-cart-item-details" style="margin-left:70px;">
                                                        <h4 style="margin:0px;" data-st_id="<?php echo @$product->st_id; ?>">
                                                            <?php echo $item; ?>
                                                        </h4>
                                                        <p style="margin:0px;">
                                                            <span style="color:#999;">Product#: <?php echo $item; ?></span><br />
                                                            Color: &nbsp; <?php echo $color_name; ?>
                                                            <?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
                                                            <?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
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
                                                        <input tpye="text" class="this-size-qty" name="this-size-qty[]" style="border:1px solid #<?php echo $s_qty > 0 ? '000' : 'ccc'; ?>;font-size:12px;width:30px;padding-left:5px;background-color:white;" value="<?php echo $s_qty; ?>" readonly />
                                                        <br />
                                                        <a class="small text-default tooltips print-upc-size <?php echo $s_qty > 0 ? '' : 'invisible'; ?>" data-original-title="Print Barcodes of this size" data-placement="bottom" href="<?php echo base_url().'admin/barcodes/print/po_item/index/'.$po_details->po_id.'/'.$item.'/'.$size_label; ?>" target="_blank" data-item="<?php echo $item; ?>" data-size="<?php echo $s; ?>">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    </div>

                                                            <?php
                                                        }
                                                    } ?>

                                                    <div style="display:inline-block;position:relative;top:-18px;">=</div>

                                                    <div style="display:inline-block;">
                                                        Total <br />
                                                        <input tpye="text" class="this-total-qty <?php echo $item.' '.$prod_no; ?>" style="border:1px solid #ccc;font-size:12px;width:30px;padding-left:5px;background-color:white;" value="<?php echo $this_size_qty; ?>" readonly /> <br />
                                                        <a class="small text-default tooltips print-upc-item" data-original-title="Print All Barcodes of this item" data-placement="bottom" href="<?php echo site_url('admin/barcodes/print/po_item/index/'.$po_details->po_id.'/'.$item); ?>" target="_blank" data-item="<?php echo $item; ?>">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    </div>

                                                    <!--
                                                    <div class="margin-top-10">
                                                        <a href="<?php echo site_url($this->uri->segment(1).'/barcodes/print/po_item/index/'.$po_details->po_id.'/'.$item); ?>" class="btn dark btn-outline btn-sm" target="_blank">Print Barcode Labels</a>
                                                    </div>
                                                    -->
                                                </td>
                                                <?php
                                                /**********
                                                 * Unit Vendor Price
                                                 */
                                                ?>
                                                <td class="text-right" style="vertical-align:top;">
                                                    <?php
                                                    $v_price = @$po_options['show_vendor_price'] == '1' ? $vendor_price : 0;
                                                    ?>
                                                    $ <?php echo number_format($v_price, 2); ?>
                                                </td>
                                                <?php
                                                /**********
                                                 * Subtotal
                                                 */
                                                ?>
                                                <td class="text-right" style="vertical-align:top;">
                                                    <?php
                                                    $this_size_total = $this_size_qty * $v_price;
                                                    ?>
                                                    $ <?php echo number_format($this_size_total, 2); ?>
                                                </td>

                                                <input type="hidden" class="input-order-subtotal <?php echo $item.' '.$prod_no; ?>" name="subtotal" value="<?php echo $this_size_total; ?>" />

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

                                    <?php
                                    if($this->purchase_order_details->remarks)
                                    {
                                        echo 'Remarks/Instructions:<br /><br />';
                                        echo '<div style="font-size:0.8em;">';
                                        echo $this->purchase_order_details->remarks;
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

                    <!-- PRINT ITEM SIZE'S BARCODE OPTIONS -->
                    <div id="modal-print-upc-size" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Print UPC Barcode</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label><span class="item"></span><br />Size <span class="size"></span></label>
                                            <div class="mt-radio-list" data-url="">
                                                <label class="mt-radio mt-radio-outline"> This Quantity <p class="qty" style="display:inline;"></p> pcs
                                                    <input type="radio" value="1" name="test" checked />
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline"> Just 1 label
                                                    <input type="radio" value="0" name="test" />
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                    <button type="button" class="btn dark print-upc-size" data-url="">Print</button>
                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
