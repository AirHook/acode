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
									PAYMENT OPTIONS
								</div>
								<div class="actions">
									<div class="btn-group btn-group-devided">
										<a class="btn btn-secondary-outline font-dark" href="<javascript:;">
											<i class="fa fa-reply"></i> Back to order logs
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="page-file-wrapper">
						<div class="row">

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

							<?php
							/*********
							 * Payment Options
							 */
							?>
							<div class="col-md-4 clearfix">

								<div class="row">

									<div class="form-horizontal col-sm-12 clearfix">

										<h5> <i class="fa fa-credit-card"></i> Choose options for payment method</h5>

										<hr />

										<?php
										/***********
										 * Paypal
										 */
										if (@$order_details->options['payment_option'] && @$order_details->options['payment_option'] == 'pp')
										{
											$pp_checked = 'checked="checked" disabled';
										}
										else $pp_checked = '';
										?>
										<div class=" clearfix">

											<div class="form-group" style="margin-bottom:0px;">
												<div class="col-md-12">
													<div class="mt-checkbox-list">
														<label class="mt-checkbox mt-checkbox-outline">
															<h4>Paypal</h4>
															<input value="pp" name="ws_payment_options" type="checkbox" <?php echo $pp_checked; ?> />
															<span></span>
														</label>
													</div>
												</div>
											</div>
											<div class="well" style="margin-bottom:0px;">
												"Send me a Paypal Invoice"
											</div>

										</div>

										<hr />

										<?php
										/***********
										 * Credit Card
										 */
										if (@$order_details->options['payment_option'] && @$order_details->options['payment_option'] == 'cc')
  										{
  											$cc_checked = 'checked="checked" disabled';
  										}
 										else $cc_checked = '';
										?>
										<div class=" clearfix">

											<div class="form-group" style="margin-bottom:0px;">
												<div class="col-md-12">
													<div class="mt-checkbox-list">
														<label class="mt-checkbox mt-checkbox-outline">
															<h4>Credit Card</h4>
															<input value="cc" name="ws_payment_options" type="checkbox" <?php echo $cc_checked; ?> />
															<span></span>
														</label>
													</div>
												</div>
											</div>
											<div class="well cc-info clearfix display-none">

												<!-- BEGIN FORM-->
												<!-- FORM =======================================================================-->
												<?php echo form_open(
													$pre_link.'/orders/payment_options/credit_card/'.$order_details->order_id,
													array(
														'class'=>'form-horizontal',
														'id'=>'form-credit_card_info'
													)
												); ?>

												<div class="alert alert-danger display-none" data-test="test">
													<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
												<div class="alert alert-success display-none">
													<button class="close" data-close="alert"></button> Your form validation is successful! </div>

												<div class="form-group">
													<div class="col-md-12">
														<h5> Credit Card Info</h5>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Card Type</label>
													<div class="col-md-6">
														<select class="form-control bs-select" name="creditCardType" required="required" data-error-container="cc_type_error">
															<option value="">Select</option>
															<option value="MC">Master Card</option>
															<option value="VISA">Visa</option>
															<option value="DISCOVER">Discover</option>
															<option value="AMEX">American Express</option>
														</select>
														<div id="cc_type_error"> </div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Card Number</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="creditCardNumber" />
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label"> </label>
													<div class="col-md-8">
														<div style="width:153px;height:24px;overflow:hidden;">
															<img style="width:216px;height:24px;" src="<?php echo base_url(); ?>images/credit-card-graphic.gif" />
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Expiration</label>
													<div class="col-md-8">
														<div class="row">
															<div class="col-md-7">
																<select class="form-control bs-select" name="creditCardExpirationMonth" required="required" data-size="7" data-error-container="cc_expmo_error">
																	<option value="">Month</option>
																	<option value="01">01 (Jan)</option>
																	<option value="02">02 (Feb)</option>
																	<option value="03">03 (Mar)</option>
																	<option value="04">04 (Apr)</option>
																	<option value="05">05 (May)</option>
																	<option value="06">06 (Jun)</option>
																	<option value="07">07 (Jul)</option>
																	<option value="08">08 (Aug)</option>
																	<option value="09">09 (Sep)</option>
																	<option value="10">10 (Oct)</option>
																	<option value="11">11 (Nov)</option>
																	<option value="12">12 (Dec)</option>
																</select>
																<div id="cc_expmo_error"> </div>
															</div>
															<div class="col-md-5">
																<select class="form-control bs-select" name="creditCardExpirationYear" required="required" data-size="7" data-error-container="cc_expyy_error">
																	<option value="">Year</option>
																	<?php
																	$now = time();
																	for ($i = 0; $i < 10; $i++)
																	{
																		$yyyy = date('Y', strtotime('+'.$i.' year'));
																		$yy = date('y', strtotime('+'.$i.' year'));
																		?>
																	<option value="<?php echo $yy; ?>"><?php echo $yyyy; ?></option>
																		<?php
																	}
																	?>
																</select>
																<div id="cc_expyy_error"> </div>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Security Code</label>
													<div class="col-md-8">
														<div class="input-group">
															<input type="text" class="form-control input-small" name="creditCardSecurityCode" style="display:inline;" /> <label class="control-label"><span style="margin:0 10px;">What's this</span> <i class="fa fa-info-circle tooltips" data-original-title="A 3 or 4 digit verification number found at the back of your credit card" style="cursor:pointer;"></i></label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label"></label>
													<div class="col-md-8">
														<button type="submit" class="btn dark mt-ladda-btn ladda-button" data-style="expand-left">
															<span class="ladda-label">Submit</span>
															<span class="ladda-spinner"></span>
														</button>
													</div>
												</div>

												</form>
												<!-- END FORM ===================================================================-->

											</div>
											<div class="well cc-notice" style="margin-bottom:0px;">
												You will need to fill up credit card info
											</div>

										</div>

										<hr />

										<?php
										/***********
										 * Wire Transfer
										 */
										if (@$order_details->options['payment_option'] && @$order_details->options['payment_option'] == 'wt')
 										{
 											$wt_checked = 'checked="checked" disabled';
 										}
										else $wt_checked = '';
										?>
										<div class=" clearfix">

											<div class="form-group" style="margin-bottom:0px;">
												<div class="col-md-12">
													<div class="mt-checkbox-list">
														<label class="mt-checkbox mt-checkbox-outline">
															<h4>Wire Transfer</h4>
															<input value="wt" name="ws_payment_options" type="checkbox" <?php echo $wt_checked; ?> />
															<span></span>
														</label>
													</div>
												</div>
											</div>
											<div class="well" style="margin-bottom:0px;">
												"Send me a Bank Details"
											</div>

										</div>
									</div>
								</div>

							</div>

							<?php
							/*********
							 * Order Details
							 */
							?>
							<div class="col-md-8">

			                    <!-- BEGIN PAGE CONTENT BODY -->
								<style>
									.img-absolute { position:absolute; }
								</style>

			                    <div class="row ">

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
															<div class="col-xs-7 col-sm-8 value">
																<?php echo (@$this->wholesale_user_details->store_name ?: $this->wholesale_user_details->firstname.' '.$this->wholesale_user_details->lastname).' (#'.$order_details->user_id.')'; ?>
															</div>
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
																		echo 'SELECT PAYMENT OPTIONS';
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
																		echo 'SELECT PAYMENT OPTIONS';
																	}
																} ?>

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 col-sm-12">

														<h4> Billing Address </h4>

														<?php echo @$this->wholesale_user_details->store_name ?: $this->wholesale_user_details->firstname.' '.$this->wholesale_user_details->lastname; ?>
														<br> <?php echo $this->wholesale_user_details->address1; ?>
														<?php echo $this->wholesale_user_details->address2 ? '<br>'.$this->wholesale_user_details->address2 : ''; ?>
														<br> <?php echo $this->wholesale_user_details->city; ?>
														<br> <?php echo $this->wholesale_user_details->zipcode.' '.$this->wholesale_user_details->state; ?>
														<br> <?php echo $this->wholesale_user_details->country; ?>
														<?php echo $this->wholesale_user_details->telephone ? '<br >T: '.$this->wholesale_user_details->telephone : ''; ?>
														<br> ATTN: <?php echo $this->wholesale_user_details->firstname.' '.$this->wholesale_user_details->lastname; ?> <?php echo '<cite class="small">('.$this->wholesale_user_details->email.')</cite>'; ?>

													</div>
													<div class="col-md-6 col-sm-12">

														<h4> Shipping Address </h4>

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

					<!-- PAYPAL -->
					<div class="modal fade bs-modal-sm" id="modal-paypal" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Thank You!</h4>
								</div>
								<div class="modal-body"> A PAYPAL INVOICE will be sent to you via email. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline hide" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($pre_link.'/orders/payment_options/paypal/'.$order_details->order_id); ?>" class="btn dark mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Close</span>
										<span class="ladda-spinner"></span>
									</a>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- PAYPAL -->
					<div class="modal fade bs-modal-sm" id="modal-credit_card" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Thank You!</h4>
								</div>
								<div class="modal-body"> A PAYPAL INVOIC will be sent to you via email. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline hide" data-dismiss="modal">Close</button>
									<button type="button" class="btn dark mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Close</span>
										<span class="ladda-spinner"></span>
									</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

					<!-- PAYPAL -->
					<div class="modal fade bs-modal-sm" id="modal-wire_transfer" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close hide" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Thank You!</h4>
								</div>
								<div class="modal-body"> We will send you our Bank Details via email. </div>
								<div class="modal-footer">
									<button type="button" class="btn dark btn-outline hide" data-dismiss="modal">Close</button>
									<a href="<?php echo site_url($pre_link.'/orders/payment_options/wire_transfer/'.$order_details->order_id); ?>" class="btn dark mt-ladda-btn ladda-button" data-style="expand-left">
										<span class="ladda-label">Close</span>
										<span class="ladda-spinner"></span>
									</a>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
