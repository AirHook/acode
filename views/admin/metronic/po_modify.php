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
													<div class="alert alert-danger display-hide" data-test="test">
														<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
													<div class="alert alert-success display-hide">
														<button class="close" data-close="alert"></button> Your form validation is successful! </div>
													<?php if (validation_errors()) { ?>
													<div class="alert alert-danger">
														<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
													</div>
													<?php } ?>
                                                    <?php if ($this->session->flashdata('success') == 'edit') { ?>
            										<div class="alert alert-success ">
            											<button class="close" data-close="alert"></button> Purchase Order successfully modified
            										</div>
            										<?php } ?>
												</div>

                                                <div class="col-sm-12">
                                                    <div class="well">

                                                        PO MODIFY mode - <cite>modification is usually done on the po finer details like dates, quantities, prices, and instructions. Items can not be removed. If there is a need to cancel or remove an item, just set all quantities of the particular item to zero.</cite>

                                                    </div>
                                                </div>

												<div class="col-sm-8 po-summary-company clearfix">
													<div class="row">
														<div class="col-sm-12">

                                                            <h3>
                                                                <?php echo $company_name; ?><br />
                                                                <small>
                                                                <?php echo $company_address2 ? $company_address2.'<br />' : ''; ?>
                                                                <?php echo $company_address1; ?><br />
                                                                <?php echo $company_city.', '.$company_state.' '.$company_zipcode; ?><br />
                                                                <?php echo $company_country; ?><br />
                                                                <?php echo $company_telephone; ?>
    															</small>
                                                            </h3>

														</div>
                                                    </div>
												</div>

                                                <div class="col-sm-12 po-summary-number">
													<div class="row">
														<div class="col-sm-12">
															<h3>
                                                                PURCHASE ORDER <strong>#<?php echo $this->purchase_order_details->po_number; ?></strong> <?php echo $this->purchase_order_details->rev ? '<small><b>rev</b></small><strong>'.$this->purchase_order_details->rev.'</strong>' : ''; ?> <br />
                                                                <small> Date: <?php echo $this->purchase_order_details->delivery_date; ?> </small>
                                                            </h3>
                                                            <h4>
                                                                <?php echo @$po_options['ref_po_no'] ? 'Reference Manual PO#: '.$po_options['ref_po_no'] : ''; ?>
                                                                <?php echo (@$po_options['ref_po_no'] && @$po_options['ref_so_no']) ? '<br />' : ''; ?>
                                                                <?php echo @$po_options['ref_so_no'] ? 'Reference SO#: '.$po_options['ref_so_no'] : ''; ?>
                                                            </h4>
														</div>
                                                    </div>
												</div>

												<div class="col-sm-12 po-summary-addresses">
                                                    <div class="row">

                                                        <div class="col-sm-6">

															<h5><strong> TO (Vendor Details) </strong></h5>

															<p>
                                                                <?php echo $vendor_details->vendor_name; ?> <br />
                                                                <?php echo $vendor_details->address1; ?> <br />
                                                                <?php echo $vendor_details->address2 ? $vendor_details->address2.'<br />' : ''; ?>
                                                                <?php echo $vendor_details->city ? $vendor_details->city.', ' : ''; ?><?php echo $vendor_details->state; ?> <br />
                                                                <?php echo $vendor_details->country; ?> <br />
                                                                <?php echo $vendor_details->telephone; ?> <br />
                                                                ATTN: <?php echo $vendor_details->contact_1; ?> <?php echo $vendor_details->vendor_email ? '('.safe_mailto($vendor_details->vendor_email).')': ''; ?>
															</p>

														</div>
                                                        <div class="col-sm-6">

															<h5> <strong>SHIP TO</strong>
                                                                <a href="#modal-edit_ship_to" data-toggle="modal" class="small hide" style="margin-left:10px;"> edit </a>
                                                            </h5>

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
                                                        <?php
        												/***********
        												 * Uses the same properties between admin and sales user
        												 */
        												?>
                                                        Ordered by: &nbsp;<?php echo $author->fname.' '.$author->lname.' ('.safe_mailto($author->email).')'; ?>
                                                    </p>
                                                </div>

                                                <!-- BEGIN FORM =======================================================-->
                                                <?php echo form_open(
                                                    $this->uri->segment(1).'/purchase_orders/modify/index/'.$this->purchase_order_details->po_id,
                                                    array(
                                                        'class' => 'form-horizontal',
                                                        'id' => 'form-po_modify'
                                                    )
                                                ); ?>

                                                <input type="hidden" name="action" value="modify" />

                                                <div class="col-sm-12 m-grid po-summary-dates">
                                                    <div class="m-grid-row">
                                                        <div class="m-grid-col m-grid-col-sm-2">

                                                            <h5> Start Date: </h5>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <input class="form-control form-control-inline date-picker" size="16" type="text" value="<?php echo $this->purchase_order_details->options['start_date']; ?>" name="start_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
                                                                    <span class="help-block"> Click to Select date </span>
                                                                </div>
                                                            </div>

														</div>
                                                        <div class="m-grid-col m-grid-col-sm-2">

                                                            <h5> Cancel Date: </h5>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <input class="form-control form-control-inline date-picker" size="16" type="text" value="<?php echo $this->purchase_order_details->options['cancel_date']; ?>" name="cancel_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
                                                                    <span class="help-block"> Click to Select date </span>
                                                                </div>
                                                            </div>

														</div>
                                                        <div class="m-grid-col m-grid-col-sm-2">

                                                            <h5> Delivery Date: </h5>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <input class="form-control form-control-inline date-picker" size="16" type="text" value="<?php echo $this->purchase_order_details->delivery_date; ?>" name="delivery_date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d" />
                                                                    <span class="help-block"> Click to Select date </span>
                                                                </div>
                                                            </div>

														</div>
                                                        <div class="m-grid-col m-grid-col-sm-2">

                                                            <h5> Ship Via: </h5>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo $this->purchase_order_details->options['ship_via']; ?>" name="ship_via" />
                                                                </div>
                                                            </div>

														</div>
                                                        <div class="m-grid-col m-grid-col-sm-2">

                                                            <h5> F.O.B: </h5>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo $this->purchase_order_details->options['fob']; ?>" name="fob" />
                                                                </div>
                                                            </div>

														</div>
                                                        <div class="m-grid-col m-grid-col-sm-2">

                                                            <h5> Terms: </h5>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <input class="form-control form-control-inline" size="16" type="text" value="<?php echo $this->purchase_order_details->options['terms']; ?>" name="terms" />
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
															<table class="table table-striped table-hover table-light" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
																<thead>
																	<tr>
																		<th> Items (<?php echo count($this->purchase_order_details->items); ?>) </th>
																		<th> Size and Qty </th>
                                                                        <th> </th>
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
																		foreach ($po_items as $item => $qtty)
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
																		<td>
                                                                            <a href="<?php echo $img_linesheet ?: 'javascript:;'; ?>" class="<?php echo $img_linesheet ? 'fancybox' : ''; ?> pull-left">
                                                                                <img class="" src="<?php echo $img_front_new; ?>" alt="" style="width:60px;height:auto;" onerror="$(this).attr('src','<?php echo $this->config->item('PROD_IMG_URL').'images/instylelnylogo_3.jpg'; ?>');" />
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
                                                                                $size_qty =
                                                                                    ! empty($qtty) && isset($qtty[$size_label])
                                                                                    ? $qtty[$size_label]
                                                                                    : 0
                                                                                ;
                                                                                $this_size_qty += $size_qty;
                                                                                ?>

                                                                            <div style="display:inline-block;">
                                                                                <?php echo $s; ?> <br />
                                                                                <select name="size_<?php echo $s; ?>" class="size-select" style="border:1px solid #<?php echo $size_qty > 0 ? '000' : 'ccc'; ?>;" data-page="modify" data-prod_no="<?php echo $item; ?>" data-vendor_price="<?php echo @$product->vendor_price; ?>">
                                                                                    <?php
                                                                                    for ($i=0;$i<31;$i++)
                                                                                    {
                                                                                        echo '<option value="'.$i.'" '.($i == $size_qty ? 'selected' : '').'>'.$i.'</option>';
                                                                                    } ?>
                                                                                </select>
                                                                            </div>

                                                                                <?php
                                                                            } ?>

                                                                            =

                                                                            <div style="display:inline-block;">
                                                                                Total <br />
                                                                                <input tpye="text" class="this-total-qty <?php echo $item.' '.$prod_no; ?>" style="border:1px solid #ccc;font-size:12px;width:30px;padding-left:5px;background-color:white;" value="<?php echo $this_size_qty; ?>" readonly />
                                                                            </div>
																		</td>

																		<td></td>

																		<?php
																		/**********
																		 * Unit Vendor Price
																		 */
																		?>
																		<td class="unit-vendor-price-wrapper">
                                                                            <div class="clearfix">
                                                                                <div class="unit-vendor-price <?php echo $prod_no; ?> pull-right" style="height:27px;width:40px;border:1px solid #ccc;padding-top:4px;padding-right:4px;text-align:right;">
                                                                                    <?php echo $qtty['vendor_price']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-right">
                                                                                <button data-toggle="modal" href="#modal-edit_vendor_price-<?php echo $item; ?>" type="button" class="btn btn-link btn-xs" style="padding-right:0;margin-right:0;"><i class="fa fa-pencil"></i> Edit</button>
                                                                            </div>

                                                                            <!-- EDIT VENDOR PRICE -->
                                                                            <div id="modal-edit_vendor_price-<?php echo $item; ?>" class="modal fade bs-modal-sm in" id="small" tabindex="-1" role="dialog" aria-hidden="true">
                                                                                <div class="modal-dialog modal-sm">
                                                                                    <div class="modal-content">

                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                            <h4 class="modal-title">Edit Vendor Price</h4>
                                                                                        </div>
                                                                                        <div class="modal-body">

                                                                                            <?php echo $item; ?>

                                                                                            <div class="form-group clearfix">
                                                                                                <label class="control-label col-md-4">New Price
                                                                                                </label>
                                                                                                <div class="col-md-4">
                                                                                                    <input type="text" name="vendor_price-<?php echo $item; ?>" data-required="1" class="form-control input-sm modal-input-vendor-price <?php echo $prod_no; ?>" value="<?php echo number_format($qtty['vendor_price']); ?>" size="2" data-prod_no="<?php echo $item; ?>" data-item="<?php echo $prod_no; ?>" data-page="modify" />
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="alert alert-danger">
                                        														<button class="close hide" data-close="alert"></button> NOTE: this changes the price of all variants of this product item
                                        													</div>

                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
                                                                                            <button type="button" class="btn dark edit_vendor_prices" data-prod_no="<?php echo $item; ?>">Apply changes</button>
                                                                                        </div>

                                                                                    </div>
                                                                                    <!-- /.modal-content -->
                                                                                </div>
                                                                                <!-- /.modal-dialog -->
                                                                            </div>
                                                                            <!-- /.modal -->

                                                                        </td>
                                                                        <?php
																		/**********
																		 * Subtotal
																		 */
																		?>
																		<td class="text-right order-subtotal <?php echo $item.' '.$prod_no; ?>">
                                                                            <?php
                                                                            $this_size_total = $this_size_qty * $qtty['vendor_price'];
                                                                            ?>
																			$ <?php echo $this->cart->format_number($this_size_total); ?>
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

                                                            <div class="form-group">
                    											<label class="control-label">Remarks/Instructions:
                    											</label>
                    											<textarea name="remarks" class="form-control summernote" id="summernote_1" data-error-container="email_message_error"><?php echo $this->purchase_order_details->remarks; ?></textarea>
                    											<div id="email_message_error"> </div>
                    										</div>

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
                                                                        //$review_total = $this->cart->total() + @$fix_fee + @$review_nytax;
                                                                        echo '$ '.number_format($overall_total, 2);
                                                                        ?>
                                                                    </td>
        														</tr>
        														<tr>
        															<td colspan="2">
        															</td>
        														</tr>
        													</table>

                                                            <!-- DOC: add class "submit-po_summary_review" to execute script to send form -->
                                                            <button class="btn dark btn-block mt-bootbox-new submit-po_summary_review"> Modify Purchase Order </button>

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

                                                </form>
                                                <!-- END FORM =======================================================-->

											</div>


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
                                    						'admin/purchase_orders/edit_ship_to',
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

										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
