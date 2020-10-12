					<?php
					// let's set the role for sales user my account
					$pre_link =
						@$role == 'wholesale'
						? 'my_account/wholesale'
						: 'admin'
					;
					?>
					<div class="page-head">
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									ORDER INQUIRY DETAILS
								</div>
								<div class="actions">
									<div class="btn-group btn-group-devided">
										<a class="btn btn-secondary-outline font-dark" href="javascript:;" onclick="history.back();">
											<i class="fa fa-reply"></i> Back to order logs
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="m-grid m-grid-responsive-md page-file-wrapper">
						<div class="m-grid-row">

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
										<?php if ($this->session->flashdata('success') == 'wire_transfer_payment_option') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> We shall send you our Bank Details for the wire transfer shortly.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'paypal_payment_option') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> A PAYPAL INVOICE will be sent to you shortly.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'credit_card_payment_option') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> We shall process your credit card payment shortly and advise when order is pending shipment.
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'email_confirmation_sent') { ?>
										<div class="alert alert-success ">
											<button class="close" data-close="alert"></button> Order Email Confirmation Sent
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'edit') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Order status updated...
										</div>
										<?php } ?>
										<?php if ($this->session->flashdata('success') == 'invoice_sent') { ?>
										<div class="alert alert-success auto-remove">
											<button class="close" data-close="alert"></button> Order invoice sent to user.
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

											<div class="portlet-title hide">

												<div class="caption">
													<i class="icon-settings font-dark"></i>
													<span class="caption-subject font-dark sbold uppercase">
														<!-- Title here... -->
													</span>
												</div>
												<div class="actions">
													<div class="btn-group btn-group-devided">
														<a class="btn btn-secondary-outline" href="<javascript:;">
															<i class="fa fa-reply"></i> Back to order logs
														</a>
													</div>
												</div>
											</div>

											<div class="portlet-body">
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<h4>
					                                        <strong>
																ORDER INQUIRY #<?php echo $order_details->order_id.'-'.strtoupper(substr(($order_details->designer_group == 'Mixed Designers' ? 'SHO' : $order_details->designer_group),0,3)); ?> <?php echo @$order_details->options['sales_order'] ? '| SO' : ''; ?>
															</strong>
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
															<div class="col-xs-7 col-sm-8 value"> <?php echo $name; ?> </div>
															<div class="col-xs-5 col-sm-4 name"> Role: </div>
															<div class="col-xs-7 col-sm-8 value"> <?php echo ($order_details->c == 'guest' OR $order_details->c == 'cs') ? 'Retail' : 'Wholesale'; ?> </div>
															<div class="col-xs-5 col-sm-4 name"> Payment Info: </div>
															<div class="col-xs-7 col-sm-8 value">

																<?php if ($order_details->c == 'ws')
																{
																	if (@$order_details->options['payment_option'])
																	{
																		echo $order_details->options['payment_method'];
																	}
																	else
																	{
																		echo '<a href="'.site_url($pre_link.'/orders/payment_options/index/'.$order_details->order_id).'" class="">SELECT PAYMENT OPTIONS</a>';
																	}
																}
																else
																{
																	if (@$order_details->options['payment_method'])
																	{
																		echo $order_details->options['payment_method'];
																	}
																	else
																	{
																		echo 'Credit Card';
																	}
																} ?>

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 col-sm-12">

														<h4> Billing Address </h4>

														<?php
														echo $store_name ?: $firstname.' '.$lastname; echo '<br />';
														echo $address1.'<br />';
														echo $address2 ? $address2.'<br />' : '';
														echo $city.', '.$zipcode.' '.$state.'<br />';
														echo $country.'<br />';
														echo $telephone.'<br />';
														echo 'ATTN: '.$firstname.' '.$lastname.' <cite class="small">('.$email.')</cite>';
														?>

													</div>
													<div class="col-md-6 col-sm-12">

														<h4> Shipping Address </h4>

														<?php
														echo $sh_store_name ?: $sh_firstname.' '.$sh_lastname; echo '<br />';
														echo $sh_address1.'<br />';
														echo $sh_address2 ? $sh_address2.'<br />' : '';
														echo $sh_city.', '.$sh_zipcode.' '.$sh_state.'<br />';
														echo $sh_country.'<br />';
														echo $sh_telephone.'<br />';
														echo 'ATTN: '.$sh_firstname.' '.$sh_lastname.' <cite class="small">('.$sh_email.')</cite>';
														?>

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
																<th class="text-center"> Size </th>
																<th class="text-center"> Color </th>
																<th class="text-center"> Qty </th>
																<th class="text-right" style="width:70px;"> Regular Price </th>
																<th class="text-right" style="width:70px;"> Discounted Price </th>
																<th class="text-right" style="width:70px;"> Extended Price </th>
															</tr>
														</thead>
														<tbody>

															<?php
															if ($order_details->order_items)
															{
																$overall_total = 0;
																$i = 1;
																foreach ($order_details->order_items as $item)
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
																			$order_details->c == 'ws'
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
																<td class="text-center"> <?php echo $item->qty; ?> </td>
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

														</tbody>
													</table>
												</div>

												<div class="row">
													<div class="col-md-6">
														<p class="block">Remarks/Comments:</p>
														<p>
															<?php echo @$order_details->remarks; ?>
														</p>
													</div>
													<div class="col-md-6">

														<table class="table table-condensed">
															<!-- Order Amount -->
															<tr>
																<td>Subtotal</td>
																<td class="text-right">$ <?php echo number_format($overall_total, 2); ?></td>
															</tr>
															<?php if (@$order_details->options['discount'])
															{
																$discount = $overall_total * ($order_details->options['discount'] / 100);
																?>
															<!-- Discount -->
															<tr>
																<td>Discount</td>
																<td class="text-right">
																	<?php echo @$order_details->options['discount'] ? '@'.$order_details->options['discount'].'%' : ''; ?> &nbsp; &nbsp;
																	($ <?php echo number_format($discount, 2); ?>)
																</td>
															</tr>
																<?php
															}
															else
															{
																$discount = 0;
															} ?>
															<!-- Shipping & Handling -->
															<tr>
																<td>Shipping &amp; Handling</td>
																<td class="text-right">
																	<?php echo '$ '.number_format($order_details->shipping_fee, 2); ?>
																</td>
															</tr>
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

							</div>
						</div>
					</div>
