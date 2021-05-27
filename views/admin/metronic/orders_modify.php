					<?php
					// let's set the role for sales user my account
					$pre_link =
						@$role == 'sales'
						? 'my_account/sales'
						: 'admin'
					;
					// level 2 sales user cannot view/print packing list and barcodes
					if (@$role == 'sales' && @$this->sales_user_details->access_level == '2')
					{
						$hide_packing_list = 'display-none';
						$hide_barcdoes = 'display-none'; // also used at the items table print barcode link
						$hide_resend_order_email = 'display-none';
					}
					else
					{
						$hide_packing_list = '';
						$hide_barcdoes = '';
						$hide_resend_order_email = '';
					}
					?>
					<div class="m-grid m-grid-responsive-md page-file-wrapper" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>
						<div class="m-grid-row">

							<style>
								.filter-options .bootstrap-select.btn-group .dropdown-toggle .filter-option {
									font-size: 0.8em;
								}
								.filter-options .mt-radio {
									margin-bottom: 5px;
									font-size: 11px;
									padding-left: 25px;
								}
								.filter-options .mt-radio > span {
									height: 14px;
									width: 14px;
								}
								.filter-options .mt-radio > span::after {
									left: 3px;
									top: 3px;
								}
							</style>

							<?php
							/*********
							 * Action Sidebar
							 */
							?>
							<div class="m-grid-col m-grid-col-md-2 filter-options margin-bottom-20" style="padding-right:15px;font-size:0.8em;">

								<h4>Status:</h4>

								<label class="btn btn-default btn-block btn-sm margin-bottom-10" style="cursor:text;" onmouseover="$(this).css('background','none');">
									<?php
									// 0-new,1-complete,2-onhold,3-canclled,4-returned/refunded,5-shipment_pending,6-store_credit,7-payment_pending
									switch ($order_details->status)
									{
										case '0':
											echo 'NEW ORDER INQUIRY';
											$txt = 'This inquiry is being checked for stock and accounting is generating an invoice.';
										break;
										case '1':
											echo 'COMPLETE/SHIPPED';
											$txt = 'This order has shipped and tracking is available.';
										break;
										case '3':
											echo 'CANCELLED';
											$txt = 'This order is cancelled.';
										break;
										case '4':
											echo 'REFUNDED';
											$txt = 'This order is returned/cancelled on refund.';
										break;
										case '5':
											echo 'SHIPMENT PENDING';
											$txt = 'This order has been paid and packing list is ready. Warehouse is processing and shipping.';
										break;
										case '6':
											echo 'STORE CREDIT';
											$txt = 'This order is returned/cancelled on store credit.';
										break;
										case '7':
											echo 'PAYMENT PENDING';
											$txt = 'This order is awaiting payment from costumer.';
										break;
									}
									?>
								</label>

								<cite class="small font-red"><?php echo $txt; ?></cite>

								<hr style="margin:15px 0 15px;" />

								<label>
									Actions:
								</label>
								<?php if ($order_details->status == '0')
								{
									if (@$role == 'sales' && @$this->sales_user_details->access_level == '2') $hide_approve = 'hide';
									else $hide_approve = '';
									?>

								<button href="#modal-split_order" data-toggle="modal" class="btn grey-gallery btn-block btn-sm filter-options-field-details <?php echo $hide_approve; ?>" style="text-align:left;padding-left:10px;">
									<i class="fa fa-cut"></i>
									Split Order
								</button>

								<hr style="margin:15px 0 15px;" />

								<label>
									Options:
								</label>

								<a href="#modal-send_invoice_to_user" data-toggle="modal" class="btn grey-gallery btn-block btn-sm">
									Send Invoice To User
								</a>

								<a href="#modal-send_invoice_to_admin" data-toggle="modal" class="btn grey-gallery btn-block btn-sm">
									Send Invoice To Admin
								</a>

								<?php
							} ?>

								<a class="btn btn-secondary-outline btn-sm btn-block" href="<?php echo site_url('admin/orders/details/index/'.$order_details->order_id); ?>">
	                                <i class="fa fa-reply"></i> Back to Order Details
								</a>

							</div>

							<?php
							/*********
							 * Order Details
							 */
							?>
							<div class="m-grid-col m-grid-col-md-10">

			                    <!-- BEGIN PAGE CONTENT BODY -->
								<style>
									.img-absolute { position:absolute; }
								</style>

			                    <div class="row ">

									<?php
									/***********
									 * Noification area
									 */
									?>
									<div class="notifications col-md-12">
										<?php if ($this->session->flashdata('success') == 'email_confirmation_sent') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> Order Email Confirmation Sent
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Order information updated...
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
										<div class="alert alert-danger ">
											<button class="close" data-close="alert"></button> Ooops... Something went wrong. Please try again.
										</div>
										<?php } ?>
										<?php if (validation_errors()) { ?>
										<div class="alert alert-danger auto-remove">
											<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
										</div>
										<?php } ?>
									</div>

			                        <div class="col-md-12">
										<div class="portlet light portlet-fit portlet-datatable bordered">

											<div class="portlet-body">
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<h4>
					                                        <strong>
																ORDER INQUIRY #<?php echo $order_details->order_id.'-'.strtoupper(substr(($order_details->designer_group == 'Mixed Designers' ? 'SHO' : $order_details->designer_group),0,3)); ?> <?php echo @$order_details->options['sales_order'] ? '| SO' : ''; ?>
															</strong><?php echo $this->order_details->rev ? '<small><b>rev</b></small><strong>'.$this->order_details->rev.'</strong>' : ''; ?>
															<br />
					                                        <small> Date: <?php echo $order_details->order_date; ?> </small>
					                                    </h4>
					                                    <h4>
					                                        <?php echo @$order_details->options['ref_checkout_no'] ? 'Reference Sale Order #: '.@$order_details->options['ref_checkout_no'] : ''; ?>
					                                    </h4>

														<br />

													</div>
													<div class="col-md-6 col-sm-12">
														<div class="row static-info">
															<div class="col-xs-5 col-sm-4 name"> Designer: </div>
															<div class="col-xs-7 col-sm-8 value"> <?php echo $order_details->designer_group; ?> </div>
															<div class="col-xs-5 col-sm-4 name"> Customer: </div>
															<div class="col-xs-7 col-sm-8 value">
																<?php echo (@$user_details->store_name ?: $user_details->firstname.' '.$user_details->lastname).' (#'.$order_details->user_id.')'; ?>
															</div>
															<div class="col-xs-5 col-sm-4 name"> Role: </div>
															<div class="col-xs-7 col-sm-8 value"> <?php echo ($order_details->c == 'guest' OR $order_details->c == 'cs') ? 'Retail' : 'Wholesale'; ?> </div>
															<div class="col-xs-5 col-sm-4 name"> Payment Info: </div>
															<div class="col-xs-7 col-sm-8 value">
																<select name="payment_info">
																	<option value="">Select...</option>
																	<option value="cc">Credit Card</option>
																	<option value="pp">Paypal</option>
																	<option value="wt">Wire Transfer</option>
																</select>
															</div>
															<?php

																if (isset($this->order_details->options['0']))
																	$split_info1 = $this->order_details->options['0']['split_from'];
																else
																	$split_info1 = "";
																$split_info2 = $this->order_details->order_id;

																if ($split_info1!="")
																{
																	?>
																	<div class="col-xs-5 col-sm-4 name"> Split Info: </div>
																	<div class="col-xs-7 col-sm-8 value"> <?php echo$split_info1.', '.$split_info2; ?> </div>
																	<?php
																}
															?>

														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 col-sm-12">

														<h4>
															BILL TO
															<?php if ($order_details->c == 'ws') { ?>
															<a href="#modal-edit_store_details" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:50%;">
																Edit Store Details
															</a>
															<?php } else { ?>
															<a href="#modal-edit_user_details" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:50%;">
																Edit User Details
															</a>
															<?php } ?>
														</h4>

														<?php echo @$user_details->store_name ?: $user_details->firstname.' '.$user_details->lastname; ?>
														<br> <?php echo $user_details->address1; ?>
														<?php echo $user_details->address2 ? '<br>'.$user_details->address2 : ''; ?>
														<br> <?php echo $user_details->city; ?>
														<br> <?php echo $user_details->zipcode.' '.$user_details->state; ?>
														<br> <?php echo $user_details->country; ?>
														<?php echo $user_details->telephone ? '<br >T: '.$user_details->telephone : ''; ?>
														<br> ATTN: <?php echo $user_details->firstname.' '.$user_details->lastname; ?> <?php echo '<cite class="small">('.$user_details->email.')</cite>'; ?>

													</div>
													<div class="col-md-6 col-sm-12">

														<h4>
															SHIP TO
															<a href="#modal-edit_ship_to" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:50%;">
																Edit Shipping Address
															</a>
														</h4>

														<?php echo $order_details->store_name ?: $order_details->firstname.' '.$order_details->lastname; ?>
														<br> <?php echo $order_details->ship_address1; ?>
														<?php echo $order_details->ship_address2 ? '<br>'.$order_details->ship_address2 : ''; ?>
														<br> <?php echo $order_details->ship_city; ?>
														<br> <?php echo $order_details->ship_zipcode.' '.$order_details->ship_state; ?>
														<br> <?php echo $order_details->ship_country; ?>
														<?php echo $order_details->telephone ? '<br >T: '.$order_details->telephone : ''; ?>
														<br> ATTN: <?php echo $order_details->firstname.' '.$order_details->lastname; ?> <?php echo '<cite class="small">('.$order_details->email.')</cite>'; ?>

													</div>
												</div>
												<div class="row">
													<div class="col-md-12 col-sm-12 margin-top-20">

														<h4 style="display:inline-block;"> Ship Method: </h4>
														&nbsp; &nbsp;
														<?php
														if (@$order_details->courier == 'TBD')
														{
															// the TBD is taken only from Create Sales Order via sales user my account
															// and the options['shipmethod_text']
															echo @$order_details->options['shipmethod_text'] ?: $order_details->courier;
														}
														else
														{
															// this is normally used via the frontend checkout process
															echo @$order_details->courier ?: 'TBD';
														}
														?>
														<a href="#modal-edit_ship_method" data-toggle="modal" class="btn btn-xs grey-gallery hide" style="font-size:50%;">
															Edit Ship Method
														</a>

													</div>
												</div>

												<hr style="margin:20px 0 20px;border-color:#888;border-width:2px;" />
												<?php
												/*********
												 * This style a fix to the dropdown menu inside table-responsive table-scrollable
												 * datatables. Setting position to relative allows the main dropdown button to
												 * follow cell during responsive mode. A jquery is also needed on the button to
												 * toggle class to change back position to absolute so that the dropdown menu
												 * shows even on overflow.
												 *
												 * And some image tile fixes
												 */
												?>
												<style>
													.thumb-tiles {
														position: relative;
														margin-right: -10px;
													}
													.thumb-tiles .thumb-tile {
														display: block;
														float: left;
														height: 135px;
														width: 90px !important;
														cursor: default;
														text-decoration: none;
														color: #fff;
														position: relative;
														font-weight: 300;
														font-size: 12px;
														letter-spacing: .02em;
														line-height: 20px;
														overflow: hidden;
														border: 4px solid transparent;
														margin: 0 10px 10px 0;
													}
													.thumb-tiles .thumb-tile.image .tile-body {
														padding: 0 !important;
													}
													.thumb-tiles .thumb-tile .tile-body {
														height: 100%;
														vertical-align: top;
														padding: 10px;
														overflow: hidden;
														position: relative;
														font-weight: 400;
														font-size: 12px;
														color: #fff;
														margin-bottom: 10px;
													}
													.thumb-tiles .thumb-tile.image .tile-body > img {
														width: 100%;
														height: auto;
														min-height: 100%;
														max-width: 100%;
													}
													.thumb-tiles .thumb-tile .tile-body img {
														margin-right: 10px;
													}
													.thumb-tiles .thumb-tile .tile-object {
														position: absolute;
														bottom: 0;
														left: 0;
														right: 0;
														min-height: 30px;
														background-color: transparent;
													}
													.thumb-tiles .thumb-tile .tile-object > .name {
														position: absolute;
														bottom: 0;
														left: 0;
														margin-bottom: 5px;
														margin-left: 10px;
														margin-right: 15px;
														font-weight: 400;
														font-size: 13px;
														color: #fff;
													}
												</style>

												<div class="table-responsive">
													<table class="table table-hover table-bordered table-striped">
														<thead>
															<tr>
																<th class="hidden-xs hidden-sm"> <!-- counter --> </th>
																<th style="min-width:180px;"> Image </th>
																	<!--<th class="hide"> Item Name </th>-->
																<th> Product No </th>
																<th class="text-center" style="width:60px;"> Size </th>
																<th class="text-center" style="width:60px;"> Color </th>
																<th class="text-center" style="width:60px;"> Qty </th>
																<th class="text-right" style="width:70px;"> Regular Unit Price </th>
																<th class="text-right" style="width:70px;"> Discounted Unit Price </th>
																<th class="text-right" style="width:70px;"> Extended Price </th>
															</tr>
														</thead>
														<tbody>

															<?php
															if ($order_details->items())
															{
																$overall_total = 0;
																$i = 1;
																$total_qty = 0;
																foreach ($order_details->order_items as $item)
																//foreach ($order_details->items() as $item)
																{
																	// get product details
	                                                                $exp = explode('_', $item->prod_sku);
	                                                                $product = $this->product_details->initialize(
	                                                                    array(
	                                                                        'tbl_product.prod_no' => $exp[0],
	                                                                        'color_code' => $exp[1]
	                                                                    )
	                                                                );

																	// get size label
																	$size = $item->size;
																	$size_names = $this->size_names->get_size_names($product->size_mode);
																	$size_label = array_search($size, $size_names);

																	// get items options
																	$options = $item->options ? json_decode($item->options, TRUE) : array();

																	// set original price in case options['orig_price'] is not set
																	$orig_price =
																		@$options['orig_price']
																		?: (
																			$this->order_details->c == 'ws'
																			? $product->wholesale_price
																			: $product->retail_price
																		)
																	;
																	$price = $item->unit_price;
																	?>

															<tr class="odd gradeX" onmouseover="$(this).find('.hidden_first_edit_link').show();" onmouseout="$(this).find('.hidden_first_edit_link').hide();">
																<td class="hidden-xs hidden-sm text-center">
																	<?php echo $i; ?>
																</td>
																<!-- Image -->
																<td class="">
																	<div class="thumb-tiles pulll-left">
																		<div class="thumb-tile image bg-blue-hoki">
																			<div class="tile-body">
																				<img class="" src="<?php echo $this->config->item('PROD_IMG_URL').str_replace('_f2', '_f3', $item->image); ?>" alt="">
																			</div>
																			<div class="tile-object">
																				<div class="name"> <?php echo $item->prod_no; ?> </div>
																			</div>
																		</div>
																	</div>
																	<p style="margin:0px;">
	                                                                    <span style="color:#999;">Style#:&nbsp;<?php echo $item->prod_sku; ?></span><br />
	                                                                    Color: &nbsp; <?php echo $product->color_name; ?>
	                                                                    <?php echo @$product->designer_name ? '<br /><cite class="small">'.$product->designer_name.'</cite>' : ''; ?>
	                                                                    <?php echo @$product->category_names ? ' <cite class="small">('.end($product->category_names).')</cite>' : ''; ?>
	                                                                </p>
																	<a class="small <?php echo $hide_barcdoes; ?>" href="<?php echo site_url('admin/barcodes/print/single/index/'.$item->prod_sku.'/'.$size_label.'/'.$item->qty); ?>" target="_blank" style="color:black_;">
																		<i class="fa fa-barcode"></i> View/Print Barcode
																	</a>
																	<br /><br /><br />
																	<a href="#modal-remove_item" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:90%;" data-item_id="<?php echo $item->order_log_detail_id; ?>">Remove Item</a>
																</td>
																<!-- Prdo No -->
																<td>
																	<?php echo $item->prod_no; ?>
																	<?php echo $product->custom_order == '3' ? '<br /><em style="color:red;font-size:75%;">On Clearance</em>' : ''; ?>
																</td>
																<!-- Size -->
																<td class="text-center"> <?php echo $item->size; ?> </td>
																<!-- Color -->
																<td class="text-center"> <?php echo $item->color; ?> </td>
																<!-- Qty -->
																<td class="text-center">
																	<span>
																		<?php echo $item->qty; ?>
																	</span>
																	<br />
																	<a href="#modal-edit_quantity" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:90%;" data-item_id="<?php echo $item->order_log_detail_id; ?>" data-prod_no="<?php echo $item->prod_sku; ?>">
																		Edit
																	</a>
																</td>
																<!-- Reg Price -->
																<td class="text-right">
																	<?php if (
																		$product->custom_order == '3'
																		&& (
																			$item->unit_price != @$options['orig_price']
																			&& $item->unit_price != $orig_price
																		)
																	)
																	{
																		echo '<span style="text-decoration:line-through;">$ '.number_format((@$options['orig_price'] ?: $orig_price), 2).'</span>';
																	}
																	else
																	{
																		echo '$ '.number_format($item->unit_price, 2);
																	} ?>
																</td>
																<!-- Disc Price -->
																<td class="text-right">
																	<?php if (
																		$product->custom_order == '3'
																		&& (
																			$item->unit_price != @$options['orig_price']
																			&& $item->unit_price != $orig_price
																		)
																	)
																	{
																		echo '<span style="color:red;">$ '.number_format($item->unit_price, 2).'</span>';
																	}
																	else
																	{
																		echo '--';
																	} ?>
																	<br />
																	<a href="#modal-edit_discount" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:90%;" data-item_id="<?php echo $item->order_log_detail_id; ?>" data-prod_no="<?php echo $item->prod_sku; ?>" data-unit_price="<?php echo $item->unit_price; ?>" data-orig_price="<?php echo @$options['orig_price'] ?: $orig_price; ?>">
																		Edit
																	</a>
																</td>
																<!-- Extended -->
																<td class="text-right">
																	<?php
																	$this_size_total = $item->unit_price * $item->qty;
																	echo $this_size_total ? '$ '.number_format($this_size_total, 2) : '$0.00';
																	?>
																</td>
															</tr>

																	<?php
																	$overall_total += $this_size_total;
																	$total_qty += $item->qty;
																	$i++;
																}
															}
															else
															{ ?>

															<tr class="odd gradeX">
																<td colspan="9">No recods found.</td>
															</tr>

															<?php
															} ?>

															<tr>
																<td colspan="4" style="border: none;">Total # of Items: <?php echo $i; ?></td>
																<td align="right" style="border: none;">Total Quantity</td>
																<td colspan="5" style="border: none;"> <?php echo $total_qty; ?> &nbsp;</td>
															</tr>

														</tbody>
													</table>
												</div>

												<div class="row">
													<div class="col-md-6">
														<p class="block">Remarks/Instructions:</p>
														<p>
															<?php echo @$order_details->remarks; ?>
														</p>
														<a href="#modal-edit_remarks" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:80%;">
															Add/Edit Remarks
														</a>
													</div>
													<div class="col-md-6">

														<table class="table table-condensed">
															<!-- Order Amount -->
															<tr>
																<td>Subtotal</td>
																<td class="text-right">
																	<?php if ( ! @$order_details->options['discount']) { ?>
																	<a href="#modal-add_discount" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:80%;">
																		Add Discount
																	</a>
																	<?php } ?>
																	$ <?php echo number_format($overall_total, 2); ?>
																</td>
															</tr>
															<?php if (@$order_details->options['discount'])
															{
																$discount = $overall_total * ($order_details->options['discount'] / 100);
																?>
															<!-- Discount -->
															<tr>
																<td>Discount</td>
																<td class="text-right">
																	<a href="#modal-add_discount" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:80%;">
																		Edit/Remove Discount
																	</a>
																	<?php echo $order_details->options['discount'] ? '@'.$order_details->options['discount'].'%' : ''; ?> &nbsp; &nbsp;
																	($ <?php echo number_format($discount, 2); ?>)
																</td>
															</tr>
																<?php
															}
															else{
																$discount = 0;
															} ?>
															<!-- Shipping & Handling -->
															<tr>
																<td>Shipping &amp; Handling</td>
																<td class="text-right">
																	<a href="#modal-edit_shipping_fee" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:80%;">
																		Edit Shipping Fee
																	</a>
																	<?php echo '$ '.number_format($order_details->shipping_fee, 2); ?>
																</td>
															</tr>
															<!-- Taxes -->
															<tr>
																<td>Sales Tax (NY, USA only)</td>
																<td class="text-right">
																	<?php
																	$sales_tax = $order_details->ship_state == 'New York' ? ($order_details->order_amount) * 0.0875 : 0;
																	echo '$ '.number_format($sales_tax, 2);
																	?>
																</td>
															</tr>
															<tr>
																<td colspan="2">
																</td>
															</tr>
															<!-- Grand Total -->
															<tr>
																<td><strong>Order Subtotal</strong></td>
																<td class="text-right">
																	$ <?php echo number_format((($overall_total - $discount) + $order_details->shipping_fee + $sales_tax), 2); ?>
																</td>
															</tr>
														</table>

													</div>
												</div>
											</div>

										</div>
			                        </div>

			                    </div>
			                    <!-- END PAGE CONTENT BODY -->

								<!-- SET AS SPLIT ORDER added by noel (20210521) -->
								<div class="modal fade bs-modal-sm" id="modal-split_order" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Split Order</h4>
											</div>
											<div class="modal-body"> Confirm splitting order. </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url($pre_link.'/orders/split_order/index/'.$this->order_details->order_id); ?>" type="button" class="btn dark">
													Confirm?
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- SEND INVOICE TO ADMIN -->
								<div id="modal-send_invoice_to_admin" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/send_invoice/index/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-send_invoice_to_user'
												)
											); ?>
											<input type="hidden" name="isadmin" value="1" />
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Send Invoice To Admin</h4>
											</div>
											<div class="modal-body">
												<div class="form-group clearfix">
		                                            <label class="control-label">Select email address to send copy of invoice:
		                                            </label><br /><br />
		                                            <div class="col-md-4">
														<select name="admin_email" class="form-control input-sm" style="width:200px;">
															<option value="joe@rcpixel.com">joe@rcpixel.com</option>
															<option value="rsbgm@rcpixel.com">rsbgm@rcpixel.com</option>
															<option value="weng_0000@yahoo.com">weng_0000@yahoo.com</option>
															<option value="help@shop7thavenue.com">help@shop7thavenue.com</option>
															<option value="help@instylenewyork.com">help@instylenewyork.com</option>
														</select>
		                                            </div>
		                                        </div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Close</button>
												<button type="submit" class="btn dark submit-send_invoice_to_user">Confirm?</button>
											</div>

											</form>
											<!-- END FORM =========================================================-->

										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- SEND INVOICE TO USER -->
								<div id="modal-send_invoice_to_user" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/send_invoice/index/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-send_invoice_to_user'
												)
											); ?>

											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Send Invoice To User</h4>
											</div>
											<div class="modal-body"> Sending invoice to user via email. </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Close</button>
												<button type="submit" class="btn dark submit-send_invoice_to_user">Confirm?</button>
											</div>

											</form>
											<!-- END FORM =========================================================-->

										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- EDIT STORE DETAILS (for wholesale) -->
		                        <div id="modal-edit_store_details" class="modal fade bs-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
		                            <div class="modal-dialog modal-md">
		                                <div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/edit_store_details/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-edit_store_details'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />
											<input type="hidden" name="user_id" value="<?php echo $order_details->user_id; ?>" />

		                                    <div class="modal-header">
		                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                                        <h4 class="modal-title">Edit Store Details</h4>
		                                    </div>
		                                    <div class="modal-body clearfix">

		                                        <div class="edit_store_details form-body">

		                                            <div class="alert alert-danger display-none" data-test="test">
		                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
		                                            <div class="alert alert-success display-none">
		                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>

		        									<div class="form-body">

		        										<div class="form-group">
		        											<label>Email<span class="required"> * </span>
		        											</label>
		        											<div class="input-group">
		        												<span class="input-group-addon">
		        													<i class="fa fa-envelope"></i>
		        												</span>
		        												<input type="email" name="email" class="form-control edit_store_details" value="<?php echo $user_details->email; ?>" />
		        											</div>
		        										</div>
		        										<div class="form-group">
		        											<label>First Name<span class="required"> * </span>
		        											</label>
		        											<input name="firstname" type="text" class="form-control edit_store_details" value="<?php echo $user_details->fname; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Last Name<span class="required"> * </span>
		        											</label>
		        											<input name="lastname" type="text" class="form-control edit_store_details" value="<?php echo $user_details->lname; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Store Name / Company Name<span class="required"> * </span>
		        											</label>
		        											<input name="store_name" type="text" class="form-control edit_store_details" value="<?php echo @$user_details->store_name; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Fed Tax ID
		        											</label>
		        											<input name="fed_tax_id" type="text" class="form-control edit_store_details" value="<?php echo @$user_details->fed_tax_id; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Telephone<span class="required"> * </span>
		        											</label>
		        											<input name="telephone" type="text" class="form-control edit_store_details" value="<?php echo $user_details->telephone; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Address 1<span class="required"> * </span>
		        											</label>
		        											<input name="address1" type="text" class="form-control edit_store_details" value="<?php echo $user_details->address1; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Address 2
		        											</label>
		        											<input name="address2" type="text" class="form-control edit_store_details" value="<?php echo $user_details->address2; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>City<span class="required"> * </span>
		        											</label>
		        											<input name="city" type="text" class="form-control edit_store_details" value="<?php echo $user_details->city; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>State<span class="required"> * </span>
		        											</label>
		        											<select class="form-control bs-select edit_store_details" name="state" data-live-search="true" data-size="8">
		        												<option class="option-placeholder" value="">Select...</option>
		        												<?php foreach (list_states() as $state) { ?>
		        												<option value="<?php echo $state->state_name; ?>" <?php echo $user_details->state == $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
		        												<?php } ?>
		        											</select>
		        										</div>
		        										<div class="form-group">
		        											<label>Country<span class="required"> * </span>
		        											</label>
		        											<select class="form-control bs-select edit_store_details" name="country" data-live-search="true" data-size="8">
		        												<option class="option-placeholder" value="">Select...</option>
		        												<?php foreach (list_countries() as $country) { ?>
		        												<option value="<?php echo $country->countries_name; ?>" <?php echo $user_details->country == $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
		        												<?php } ?>
		        											</select>
		        										</div>
		        										<div class="form-group">
		        											<label>Zip Code<span class="required"> * </span>
		        											</label>
		        											<input name="zipcode" type="text" class="form-control edit_store_details" value="<?php echo $user_details->zipcode; ?>" />
		        										</div>

		                                                <div class="alert alert-danger display-none" data-test="test">
		                                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
		                                                <div class="alert alert-success display-none">
		                                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>

		        									</div>

		                                        </div>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
												<button type="submit" class="btn dark pull-right submit-edit_store_details" data-user_cat="<?php echo $order_details->c; ?>"> Submit </button>
		                                    </div>

											</form>
											<!-- END FORM =========================================================-->

		                                </div>
		                                <!-- /.modal-content -->
		                            </div>
		                            <!-- /.modal-dialog -->
		                        </div>
		                        <!-- /.modal -->

								<!-- EDIT SHIP TO ADDRESS -->
		                        <div id="modal-edit_ship_to" class="modal fade bs-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
		                            <div class="modal-dialog modal-md">
		                                <div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/edit_ship_to/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-edit_ship_to'
												)
											); ?>

											<input type="hidden" name="rev" value="<?php echo $order_details->rev; ?>" />

		                                    <div class="modal-header">
		                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                                        <h4 class="modal-title">Edit Ship To Address</h4>
		                                    </div>
		                                    <div class="modal-body clearfix">

		                                        <div class="edit_ship_to form-body">

		                                            <div class="alert alert-danger display-none" data-test="test">
		                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
		                                            <div class="alert alert-success display-none">
		                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>

		        									<div class="form-body">

		        										<div class="form-group">
		        											<label>Email
		        											</label>
		        											<div class="input-group">
		        												<span class="input-group-addon">
		        													<i class="fa fa-envelope"></i>
		        												</span>
		        												<input type="email" name="email" class="form-control edit_ship_to" value="<?php echo $order_details->email; ?>" />
		        											</div>
		        										</div>
		        										<div class="form-group">
		        											<label>First Name<span class="required"> * </span>
		        											</label>
		        											<input name="firstname" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->firstname; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Last Name<span class="required"> * </span>
		        											</label>
		        											<input name="lastname" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->lastname; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Store Name
		        											</label>
		        											<input name="store_name" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->store_name; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Telephone<span class="required"> * </span>
		        											</label>
		        											<input name="telephone" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->telephone; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Address 1<span class="required"> * </span>
		        											</label>
		        											<input name="ship_address1" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->ship_address1; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Address 2
		        											</label>
		        											<input name="ship_address2" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->ship_address2; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>City<span class="required"> * </span>
		        											</label>
		        											<input name="ship_city" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->ship_city; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>State<span class="required"> * </span>
		        											</label>
		        											<select class="form-control bs-select edit_ship_to" name="ship_state" data-live-search="true" data-size="8">
		        												<option class="option-placeholder" value="">Select...</option>
		        												<?php foreach (list_states() as $state) { ?>
		        												<option value="<?php echo $state->state_name; ?>" <?php echo $order_details->ship_state == $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
		        												<?php } ?>
		        											</select>
		        										</div>
		        										<div class="form-group">
		        											<label>Country<span class="required"> * </span>
		        											</label>
		        											<select class="form-control bs-select edit_ship_to" name="ship_country" data-live-search="true" data-size="8">
		        												<option class="option-placeholder" value="">Select...</option>
		        												<?php foreach (list_countries() as $country) { ?>
		        												<option value="<?php echo $country->countries_name; ?>" <?php echo $order_details->ship_country == $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
		        												<?php } ?>
		        											</select>
		        										</div>
		        										<div class="form-group">
		        											<label>Zip Code<span class="required"> * </span>
		        											</label>
		        											<input name="ship_zipcode" type="text" class="form-control edit_ship_to" value="<?php echo $order_details->ship_zipcode; ?>" />
		        										</div>

		                                                <div class="alert alert-danger display-none" data-test="test">
		                                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
		                                                <div class="alert alert-success display-none">
		                                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>

		        									</div>

		                                        </div>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
												<button type="submit" class="btn dark pull-right submit-edit_ship_to" data-user_cat="<?php echo $order_details->c; ?>"> Submit </button>
		                                    </div>

											</form>
											<!-- END FORM =========================================================-->

		                                </div>
		                                <!-- /.modal-content -->
		                            </div>
		                            <!-- /.modal-dialog -->
		                        </div>
		                        <!-- /.modal -->

								<!-- EDIT USER DETAILS (for consumers) -->
		                        <div id="modal-edit_user_details" class="modal fade bs-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
		                            <div class="modal-dialog modal-md">
		                                <div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/edit_user_details/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-edit_user_details'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />
											<input type="hidden" name="user_id" value="<?php echo $order_details->user_id; ?>" />

		                                    <div class="modal-header">
		                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                                        <h4 class="modal-title">Edit User Details</h4>
		                                    </div>
		                                    <div class="modal-body clearfix">

		                                        <div class="edit_store_details form-body">

		                                            <div class="alert alert-danger display-none" data-test="test">
		                                                <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
		                                            <div class="alert alert-success display-none">
		                                                <button class="close" data-close="alert"></button> Your form validation is successful! </div>

		        									<div class="form-body">

		        										<div class="form-group">
		        											<label>Email<span class="required"> * </span>
		        											</label>
		        											<div class="input-group">
		        												<span class="input-group-addon">
		        													<i class="fa fa-envelope"></i>
		        												</span>
		        												<input type="email" name="email" class="form-control edit_user_details" value="<?php echo $user_details->email; ?>" />
		        											</div>
		        										</div>
		        										<div class="form-group">
		        											<label>First Name<span class="required"> * </span>
		        											</label>
		        											<input name="firstname" type="text" class="form-control edit_user_details" value="<?php echo $user_details->fname; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Last Name<span class="required"> * </span>
		        											</label>
		        											<input name="lastname" type="text" class="form-control edit_user_details" value="<?php echo $user_details->lname; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Company Name
		        											</label>
		        											<input name="company" type="text" class="form-control edit_user_details" value="<?php echo @$user_details->store_name; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Fed Tax ID
		        											</label>
		        											<input name="fed_tax_id" type="text" class="form-control edit_user_details" value="<?php echo @$user_details->fed_tax_id; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Telephone<span class="required"> * </span>
		        											</label>
		        											<input name="telephone" type="text" class="form-control edit_user_details" value="<?php echo $user_details->telephone; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Address 1<span class="required"> * </span>
		        											</label>
		        											<input name="address1" type="text" class="form-control edit_user_details" value="<?php echo $user_details->address1; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>Address 2
		        											</label>
		        											<input name="address2" type="text" class="form-control edit_user_details" value="<?php echo $user_details->address2; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>City<span class="required"> * </span>
		        											</label>
		        											<input name="city" type="text" class="form-control edit_user_details" value="<?php echo $user_details->city; ?>" />
		        										</div>
		        										<div class="form-group">
		        											<label>State<span class="required"> * </span>
		        											</label>
		        											<select class="form-control bs-select edit_user_details" name="state_province" data-live-search="true" data-size="8">
		        												<option class="option-placeholder" value="">Select...</option>
		        												<?php foreach (list_states() as $state) { ?>
		        												<option value="<?php echo $state->state_name; ?>" <?php echo $user_details->state == $state->state_name ? 'selected="selected"' : ''; ?>><?php echo $state->state_name; ?></option>
		        												<?php } ?>
		        											</select>
		        										</div>
		        										<div class="form-group">
		        											<label>Country<span class="required"> * </span>
		        											</label>
		        											<select class="form-control bs-select edit_user_details" name="country" data-live-search="true" data-size="8">
		        												<option class="option-placeholder" value="">Select...</option>
		        												<?php foreach (list_countries() as $country) { ?>
		        												<option value="<?php echo $country->countries_name; ?>" <?php echo $user_details->country == $country->countries_name ? 'selected="selected"' : ''; ?>><?php echo $country->countries_name; ?></option>
		        												<?php } ?>
		        											</select>
		        										</div>
		        										<div class="form-group">
		        											<label>Zip Code<span class="required"> * </span>
		        											</label>
		        											<input name="zip_postcode" type="text" class="form-control edit_user_details" value="<?php echo $user_details->zipcode; ?>" />
		        										</div>

		                                                <div class="alert alert-danger display-none" data-test="test">
		                                                    <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
		                                                <div class="alert alert-success display-none">
		                                                    <button class="close" data-close="alert"></button> Your form validation is successful! </div>

		        									</div>

		                                        </div>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
												<button type="submit" class="btn dark pull-right submit-edit_user_details" data-user_cat="<?php echo $order_details->c; ?>"> Submit </button>

		                                    </div>

											</form>
											<!-- END FORM =========================================================-->

		                                </div>
		                                <!-- /.modal-content -->
		                            </div>
		                            <!-- /.modal-dialog -->
		                        </div>
		                        <!-- /.modal -->

								<!-- REMOVE ITEM -->
			                	<div id="modal-remove_item" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
			                		<div class="modal-dialog modal-sm">
			                			<div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/remove_item/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-remove_item'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />
											<input type="hidden" name="order_log_detail_id" value="" />

			                				<div class="modal-header">
			                					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			                					<h4 class="modal-title">WARNING!</h4>
			                				</div>
											<div class="modal-body"> Removing item from list. <br /> This cannot be undone! </div>
			                				<div class="modal-footer">
			                					<button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Close</button>
			                					<button type="submit" class="btn dark submit-remove_item">Confirm?</button>
			                				</div>

											</form>
											<!-- END FORM =========================================================-->

			                			</div>
			                			<!-- /.modal-content -->
			                		</div>
			                		<!-- /.modal-dialog -->
			                	</div>
			                	<!-- /.modal -->

								<!-- EDIT QTY -->
		                        <div id="modal-edit_quantity" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
		                            <div class="modal-dialog modal-sm">
		                                <div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/edit_item_qty/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-edit_user_details'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />
											<input type="hidden" name="order_log_detail_id" value="" />

		                                    <div class="modal-header">
		                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                                        <h4 class="modal-title">Edit Quantity</h4>
		                                    </div>
		                                    <div class="modal-body">

		                                        <span class="eiq-modal-item"> Item: </span>

		                                        <div class="form-group clearfix">
		                                            <label class="control-label col-md-7">Enter New Quantity
		                                            </label>
		                                            <div class="col-md-4">
		                                                <input type="text" name="qty" class="form-control input-sm" value="" />
		                                            </div>
		                                        </div>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
		                                        <button type="submit" class="btn dark submit-edit_quantity">Submit</button>
		                                    </div>

											</form>
											<!-- END FORM =========================================================-->

		                                </div>
		                                <!-- /.modal-content -->
		                            </div>
		                            <!-- /.modal-dialog -->
		                        </div>
		                        <!-- /.modal -->

								<!-- EDIT DISCOUNTED PRICE -->
		                        <div id="modal-edit_discount" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
		                            <div class="modal-dialog modal-sm">
		                                <div class="modal-content" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/edit_item_price/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-edit_user_details'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />
											<input type="hidden" name="order_log_detail_id" value="" />

		                                    <div class="modal-header">
		                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                                        <h4 class="modal-title">Edit Discounted Price</h4>
		                                    </div>
		                                    <div class="modal-body">

												<span class="edp-modal-item"> Item: </span>

		                                        <div class="form-group clearfix">
		                                            <label class="control-label col-md-7">Enter New Price
		                                            </label>
		                                            <div class="col-md-5">
		                                                <input type="text" name="unit_price" class="form-control input-sm" value="" />
		                                            </div>
		                                        </div>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
		                                        <button type="submit" class="btn dark submit-edit_discount">Submit</button>
		                                    </div>

											</form>
											<!-- END FORM =========================================================-->

		                                </div>
		                                <!-- /.modal-content -->
		                            </div>
		                            <!-- /.modal-dialog -->
		                        </div>
		                        <!-- /.modal -->

								<!-- EDIT REMARKS -->
			                	<div id="modal-edit_remarks" class="modal fade bs-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
			                		<div class="modal-dialog modal-md">
			                			<div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/edit_remarks/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-edit_remarks'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />

			                				<div class="modal-header">
			                					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			                					<h4 class="modal-title">Edit Remarks</h4>
			                				</div>
											<div class="modal-body clearfix">

												<div class="col-sm-12">
		                                            <label class="control-label">Remarks/Instructions:
		                                            </label>
		                                            <textarea name="remarks" class="form-control summernote" id="summernote_1" data-error-container="remarks_message_error">
														<?php echo @$order_details->remarks; ?>
													</textarea>
		                                            <div id="remarks_message_error"> </div>
		                                        </div>

											</div>
			                				<div class="modal-footer">
			                					<button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Close</button>
			                					<button type="submit" class="btn dark submit-edit_remarks">Submit</button>
			                				</div>

											</form>
											<!-- END FORM =========================================================-->

			                			</div>
			                			<!-- /.modal-content -->
			                		</div>
			                		<!-- /.modal-dialog -->
			                	</div>
			                	<!-- /.modal -->

								<!-- ADD DISCOUNT -->
		                        <div id="modal-add_discount" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
		                            <div class="modal-dialog modal-sm">
		                                <div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/add_discount/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-add_discount'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />

		                                    <div class="modal-header">
		                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                                        <h4 class="modal-title">Add Discount</h4>
		                                    </div>
		                                    <div class="modal-body">

		                                        <div class="form-group clearfix">
		                                            <label class="control-label col-md-5">Discount
		                                            </label>
		                                            <div class="col-md-4">
														<select name="discount" class="form-control input-sm">
															<?php
															for ($i=0;$i<100;$i++)
															{ ?>
															<option value="<?php echo $i; ?>" <?php echo @$order_details->options['discount'] == $i ? 'selected="selected"': ''; ?>>
																<?php echo $i; ?>%
															</option>
																<?php
															}
															?>
														</select>
		                                            </div>
		                                        </div>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
		                                        <button type="submit" class="btn dark submit-add_discount">Submit</button>
		                                    </div>

											</form>
											<!-- END FORM =========================================================-->

		                                </div>
		                                <!-- /.modal-content -->
		                            </div>
		                            <!-- /.modal-dialog -->
		                        </div>
		                        <!-- /.modal -->

								<!-- EDIT SHIPPING FEE -->
		                        <div id="modal-edit_shipping_fee" class="modal fade bs-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
		                            <div class="modal-dialog modal-sm">
		                                <div class="modal-content">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												$pre_link.'/orders/modify/edit_shipping_fee/'.$order_details->order_id,
												array(
													'class' => 'enter-user-form ws clearfix',
													'id' => 'form-edit_user_details'
												)
											); ?>

											<input type="hidden" name="revision" value="<?php echo $order_details->rev; ?>" />

		                                    <div class="modal-header">
		                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                                        <h4 class="modal-title">Edit Shipping</h4>
		                                    </div>
		                                    <div class="modal-body">

		                                        <div class="form-group clearfix">
		                                            <label class="control-label col-md-7">Enter Shipping Fee
		                                            </label>
		                                            <div class="col-md-5">
		                                                <input type="text" name="shipping_fee" class="form-control input-sm" value="<?php echo $order_details->shipping_fee; ?>" />
		                                            </div>
		                                        </div>

		                                    </div>
		                                    <div class="modal-footer">
		                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal" tabindex="-1">Cancel</button>
		                                        <button type="submit" class="btn dark submit-edit_shipping_fee">Submit</button>
		                                    </div>

											</form>
											<!-- END FORM =========================================================-->

		                                </div>
		                                <!-- /.modal-content -->
		                            </div>
		                            <!-- /.modal-dialog -->
		                        </div>
		                        <!-- /.modal -->

							</div>
						</div>
					</div>
