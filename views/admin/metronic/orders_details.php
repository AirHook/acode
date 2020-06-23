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

							<div class="m-grid-col m-grid-col-md-2 filter-options margin-bottom-20" style="padding-right:15px;font-size:0.8em;">

								<h4>Options</h4>

								<div class="form-group">
                                    <label>
										Status
									</label>
                                    <div class="mt-radio-list" style="padding:0px;">

										<?php if ($order_details->status == '1')
										{ ?>

										<label>
											This order is closed and shipped. In case of return, please select return options below:
										</label>
										<label class="mt-radio mt-radio-outline"> Refunded
                                            <input type="radio" class="filter-options-field-details" value="refunded" name="status" <?php echo @$this->order_details->status == '4' ? 'checked="checked"' : ''; ?>  />
                                            <span></span>
                                        </label>
										<label class="mt-radio mt-radio-outline"> Store Credit
                                            <input type="radio" class="filter-options-field-details" value="store_credit" name="status" <?php echo @$this->order_details->status == '6' ? 'checked="checked"' : ''; ?>  />
                                            <span></span>
                                        </label>

											<?php
										}
										// for returned orders
										else if ($order_details->status == '4')
										{ ?>

										<label class="mt-radio mt-radio-outline"> Refunded
                                            <input type="radio" class="filter-options-field-details" value="refunded" name="status" <?php echo @$this->order_details->status == '4' ? 'checked="checked"' : ''; ?>  />
                                            <span></span>
                                        </label>

											<?php
										}
										// for returned orders
										else if ($order_details->status == '6')
										{ ?>

										<label class="mt-radio mt-radio-outline"> Store Credit
                                            <input type="radio" class="filter-options-field-details" value="store_credit" name="status" <?php echo @$this->order_details->status == '6' ? 'checked="checked"' : ''; ?>  />
                                            <span></span>
                                        </label>

											<?php
										}
										// all esle...
										else
										{
											if ($order_details->status == '0')
											{ ?>

										<label class="mt-radio mt-radio-outline"> New Order
                                            <input type="radio" class="filter-options-field-details" value="pending" name="status" <?php echo @$this->order_details->status == '0' ? 'checked="checked"' : ''; ?> />
                                            <span></span>
                                        </label>

												<?php
											} ?>

										<label class="mt-radio mt-radio-outline"> Shipment Pending
                                            <input type="radio" class="filter-options-field-details" value="acknowledge" name="status" <?php echo @$this->order_details->status == '5' ? 'checked="checked"' : ''; ?> />
                                            <span></span>
                                        </label>
										<label class="mt-radio mt-radio-outline"> Complete / Shipped
                                            <input type="radio" class="filter-options-field-details" value="complete" name="status" <?php echo @$this->order_details->status == '1' ? 'checked="checked"' : ''; ?> />
                                            <span></span>
                                        </label>
                                        <label class="mt-radio mt-radio-outline"> Cancelled
                                            <input type="radio" class="filter-options-field-details" value="cancel" name="status" <?php echo @$this->order_details->status == '3' ? 'checked="checked"' : ''; ?>  />
                                            <span></span>
                                        </label>

											<?php
										} ?>
                                    </div>
                                </div>

								<?php if (@$this->order_details->sales_order_number) { ?>
                                <label>
									Ref. Sales Order #: &nbsp; <a href="javascript:;"> <?php echo $this->order_details->sales_order_number; ?> </a>
								</label>
								<?php } ?>

								<hr style="margin:5px 0 15px;" />

								<a href="<?php echo site_url('admin/orders/view_packing_list/index/'.$this->order_details->order_id); ?>" class="btn grey-gallery btn-block btn-sm" target="_blank">
									View/Print Packing List
								</a>
								<a href="<?php echo site_url('admin/barcodes/print/co/index/'.$this->order_details->order_id); ?>" class="btn grey-gallery btn-block btn-sm" target="_blank">
									View/Print Barcodes
								</a>
								<a href="javascript:;" class="btn grey-gallery btn-block btn-sm btn-resend_email_confirmation" data-user_id="<?php echo $this->order_details->user_id; ?>" data-order_id="<?php echo $this->order_details->order_id; ?>" data-user_cat="<?php echo $this->order_details->c; ?>">
									Resend Email Confirmation
								</a>

	                            <a class="btn btn-secondary-outline btn-sm btn-block" href="<?php echo site_url('admin/orders/'.$status); ?>">
	                                <i class="fa fa-reply"></i> Back to Order logs
								</a>

								<?php if ($this->webspace_details->options['site_type'] == 'hub_site') { ?>
								<br />
								<a href="#modal-delete" data-toggle="modal">
									<cite>Delete Order Permanently</cite>
								</a>
								<?php } ?>

							</div>
							<div class="m-grid-col m-grid-col-md-10">

			                    <!-- BEGIN PAGE CONTENT BODY -->
								<style>
									.img-absolute { position:absolute; }
								</style>

			                    <div class="row ">

									<!-- BEGIN FORM-->
									<!-- FORM =======================================================================-->
									<!--<form class="form-horizontal form-row-seperated" action="#">-->
									<?php echo form_open(
										'admin/orders/details/index/'.$this->order_details->order_id,
										array(
											'class'=>'form-horizontal',
											'id'=>'form-orders_details'
										)
									); ?>

									<input type="hidden" name="order_id" value="<?php echo $order_details->order_id; ?>" />

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
											<button class="close" data-close="alert"></button> Order status updated...
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
													<span class="caption-subject font-dark sbold uppercase"> Order #<?php echo $this->order_details->order_id.'-'.strtoupper(substr(($this->order_details->designer_group == 'Mixed Designers' ? 'SHO' : $this->order_details->designer_group),0,3)); ?> <?php echo @$this->order_details->options['sales_order'] ? '| SO' : ''; ?>
														<span class="hidden-xs">| <?php echo $this->order_details->order_date; ?> </span>
													</span>
												</div>
												<div class="actions">
													<div class="btn-group btn-group-devided">
														<a class="btn btn-secondary-outline" href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/'); ?>">
															<i class="fa fa-reply"></i> Back to order logs
														</a>
													</div>
												</div>
											</div>

											<div class="portlet-body">
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<h3>
					                                        <strong>
																ORDER #<?php echo $this->order_details->order_id.'-'.strtoupper(substr(($this->order_details->designer_group == 'Mixed Designers' ? 'SHO' : $this->order_details->designer_group),0,3)); ?> <?php echo @$this->order_details->options['sales_order'] ? '| SO' : ''; ?>
															</strong>
															<br />
					                                        <small> Date: <?php echo $this->order_details->order_date; ?> </small>
					                                    </h3>
					                                    <h4>
					                                        <?php echo @$this->order_details->options['ref_checkout_no'] ? 'Reference Sale Order #: '.@$this->order_details->options['ref_checkout_no'] : ''; ?>
					                                    </h4>

														<br />

													</div>
													<div class="col-md-6 col-sm-12">
														<div class="row static-info">
															<div class="col-xs-5 col-sm-4 name"> Role: </div>
															<div class="col-xs-7 col-sm-8 value"> <?php echo ($this->order_details->c == 'guest' OR $this->order_details->c == 'cs') ? 'Retail' : 'Wholesale'; ?> </div>
															<div class="col-xs-5 col-sm-4 name"> Payment Info: </div>
															<div class="col-xs-7 col-sm-8 value"> Credit Card </div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 col-sm-12">

														<h4> Billing Address </h4>

														<?php echo $this->order_details->store_name ?: $this->order_details->firstname.' '.$this->order_details->lastname; ?>
														<br> <?php echo $this->order_details->ship_address1; ?>
														<?php echo $this->order_details->ship_address2 ? '<br>'.$this->order_details->ship_address2 : ''; ?>
														<br> <?php echo $this->order_details->ship_city; ?>
														<br> <?php echo $this->order_details->ship_zipcode.' '.$this->order_details->ship_state; ?>
														<br> <?php echo $this->order_details->ship_country; ?>
														<?php echo $this->order_details->telephone ? '<br >T: '.$this->order_details->telephone : ''; ?>
														<br> ATTN: <?php echo $this->order_details->firstname.' '.$this->order_details->lastname; ?> <?php echo '<cite class="small">('.$this->order_details->email.')</cite>'; ?>

													</div>
													<div class="col-md-6 col-sm-12">

														<h4> Shipping Address </h4>

														<?php echo $this->order_details->store_name ?: $this->order_details->firstname.' '.$this->order_details->lastname; ?>
														<br> <?php echo $this->order_details->ship_address1; ?>
														<?php echo $this->order_details->ship_address2 ? '<br>'.$this->order_details->ship_address2 : ''; ?>
														<br> <?php echo $this->order_details->ship_city; ?>
														<br> <?php echo $this->order_details->ship_zipcode.' '.$this->order_details->ship_state; ?>
														<br> <?php echo $this->order_details->ship_country; ?>
														<?php echo $this->order_details->telephone ? '<br >T: '.$this->order_details->telephone : ''; ?>
														<br> ATTN: <?php echo $this->order_details->firstname.' '.$this->order_details->lastname; ?> <?php echo '<cite class="small">('.$this->order_details->email.')</cite>'; ?>

													</div>
												</div>
												<div class="row">
													<div class="col-md-12 col-sm-12 margin-top-20">

														<h4 style="display:inline-block;"> Ship Method: </h4>
														&nbsp; &nbsp;
														<?php echo @$this->order_details->courier ?: 'DHL Rates Apply'; ?>

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
																<th class="text-right" style="width:70px;"> Extended </th>
															</tr>
														</thead>
														<tbody>

															<?php
															if ($this->order_details->items())
															{
																$i = 1;
																foreach ($this->order_details->items() as $item)
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

																	// set original price in case options['orig_price'] is not set
																	$orig_price = $this->order_details->c == 'ws' ? $product->wholesale_price : $product->retail_price;

																	// get items options
																	$options = $item->options ? json_decode($item->options, TRUE) : array();
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
																				<img class="" src="<?php echo (str_replace('_f2', '_f3', $item->image)); ?>" alt="">
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
																	<a class="small" href="<?php echo site_url('admin/barcodes/print/single/index/'.$item->prod_sku.'/'.$size_label.'/'.$item->qty); ?>" target="_blank" style="color:black_;">
																		<i class="fa fa-barcode"></i> View/Print Barcode
																	</a>
																</td>
																<!-- Item Name --
																<td class="hide">
																	<?php echo $item->prod_name; ?>
																	<br />
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
																	<div style="display:inline-block;text-align:center;">
																		<svg style="float:right;"
																			class="barcode"
																			jsbarcode-format="upc"
																			jsbarcode-value="<?php echo $this->upc_barcodes->generate(); ?>"
																			jsbarcode-textmargin="0"
																			jsbarcode-width="1"
																			jsbarcode-height="50"
																			jsbarcode-fontoptions="bold">
																		</svg><br />
																		<a class="small" href="<?php echo site_url('admin/barcodes/print/single/index/'.$item->prod_sku.'/'.$size_label.'/'.$item->qty); ?>" target="_blank" style="color:black;">
									                                        <i class="fa fa-barcode"></i> Print Barcode
									                                    </a>
																	</div>
																		<?php
																	} ?>
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
																<!-- Unit Price -->
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
																<!-- Unit Price -->
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
																<!-- Subtotal -->
																<td class="text-right"> <?php echo '$'.number_format($item->subtotal, 2); ?> </td>
															</tr>

																	<?php
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
															<?php echo @$this->order_details->comments; ?>
														</p>
													</div>
													<div class="col-md-6">

														<table class="table table-condensed">
															<tr>
																<td>Subtotal</td>
																<td class="text-right">$ <?php echo number_format($this->order_details->order_amount, 2); ?></td>
															</tr>
															<tr>
																<td>Shipping &amp; Handling</td>
																<td class="text-right">
																	<?php echo '$ '.number_format($this->order_details->shipping_fee, 2); ?>
																</td>
															</tr>
															<tr>
																<td>Sales Tax (NY, USA only)</td>
																<td class="text-right">
																	<?php
																	$sales_tax = $this->order_details->ship_state == 'New York' ? ($this->order_details->order_amount) * 0.0875 : 0;
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
																	$ <?php echo number_format(($this->order_details->order_amount + $this->order_details->shipping_fee + $sales_tax), 2); ?>
																</td>
															</tr>
														</table>

													</div>
												</div>
											</div>

										</div>
			                        </div>

									</form>
									<!-- End FORM =======================================================================-->
									<!-- END FORM-->

			                    </div>
			                    <!-- END PAGE CONTENT BODY -->

								<!-- PENDING ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-pending" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Status Update</h4>
											</div>
											<div class="modal-body"> Set order staus to PENDING! </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$this->order_details->order_id.'/pending'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- COMPLETE ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-complete" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Status Update</h4>
											</div>
											<div class="modal-body"> Set order staus to COMPLETE! </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$this->order_details->order_id.'/complete'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- ON HOLD ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-on_hold" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Status Update</h4>
											</div>
											<div class="modal-body"> Set order staus to ON HOLD! </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/status/index/'.$this->order_details->order_id.'/on_hold'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- CANCEL ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-cancel" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Status Update</h4>
											</div>
											<div class="modal-body"> CANCEL Order? </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url('admin/orders/status/index/'.$this->order_details->order_id.'/cancel'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- DELETE ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Status Update</h4>
											</div>
											<div class="modal-body"> DELETE Order? <br /> This cannot be undone! </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url('admin/orders/delete/index/'.$this->order_details->order_id); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- RETURN FOR EXCHANGE ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-return_exchange" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Return Item Remarks</h4>
											</div>
											<div class="modal-body"> Set order as "Items returned for EXCHANGE"! </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/exchange'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- RETURN FOR STORE CREDIT ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-return_scredit" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Return Item Remarks</h4>
											</div>
											<div class="modal-body"> Set order as "Items returned for STORE CREDIT"! </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/scredit'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- RETURN FOR REFUND ITEM -->
								<div class="modal fade bs-modal-sm" id="modal-return_refund" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Return Item Remarks</h4>
											</div>
											<div class="modal-body"> Set order as "Items returned for REFUND"! </div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<a href="<?php echo site_url($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/refund'); ?>" type="button" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

								<!-- RETURN FOR OTHER REASONS ITEM -->
								<div class="modal fade bs-modal-md" id="modal-return_others" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-md">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Return Item Remarks</h4>
											</div>
												<!-- FORM =======================================================================-->
												<?php echo form_open($this->config->slash_item('admin_folder').'orders/returns/index/'.$this->order_details->order_id.'/others', array('class'=>'form-horizontal', 'id'=>'form-returns_others')); ?>
											<div class="modal-body">
												<div class="form-body">
													<div class="form-group">
														<div class="col-md-offset-2 col-md-10">
															Set order as "Items returned for OTHER REASONS"!
														</div>
													</div>
												</div>
												<div class="form-body">
													<div class="form-group">
														<label class="col-lg-2 control-label">Comments:</label>
														<div class="col-lg-10">
															<textarea class="form-control" rows="5" name="comments"></textarea>
															<span class="help-block"> Remarks about other reasons for returning item </span>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
												<button type="submit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left">
													<span class="ladda-label">Confirm?</span>
													<span class="ladda-spinner"></span>
												</button>
											</div>
												</form>
												<!-- End FORM =======================================================================-->
												<!-- END FORM-->
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->

							</div>
						</div>
					</div>
