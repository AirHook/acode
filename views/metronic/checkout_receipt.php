                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="checkout-wrapper">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												'checkout/payment',
												array(
													'class' => 'form-horizontal',
													'id' => 'form-checkout_review'
												)
											); ?>

											<div class="row margin-top-10 margin-bottom-30">
												<div class="col-sm-12 clearfix">

													<?php $this->load->view('metronic/checkout_steps'); ?>

												</div>
											</div>
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
													<?php if (validation_errors()) { ?>
													<div class="alert alert-danger">
														<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
													</div>
													<?php } ?>
												</div>

												<div class="col-sm-12">
													<h3 class=""> Thank you for your order!
														<small class="pull-right" style="position:relative;top:3px;font-size:0.5em;">
															<a class="a-black hide" href="#pending-print-receipt" data-toggle="modal">
																Print Receipt </a> <!--&nbsp; | &nbsp;-->
															<a class="a-black" href="<?php echo site_url('shop/womens_apparel'); ?>">
																Continue Shopping </a>
														</small>
													</h3>
													<h4 class=""> Order#: <?php echo $order_id; ?> </h4>
													<p>
														Your order was successfully placed on <?php echo $this->order_details->order_date; ?>.<br />
                                                        * NOTE: Your order was received and will be researched for availability on product.<br />
                                                        <?php echo $this->webspace_details->name ?: 'Shop 7th Avenue / In Style New York'; ?> <?php echo $this->webspace_details->address1.($this->webspace_details->address2 ? ' '.$this->webspace_details->address1 : ' ').$this->webspace_details->city.', '.$this->webspace_details->state.' '.$this->webspace_details->zipcode; ?><br />
                                                        EMAIL <?php echo safe_mailto($this->webspace_details->info_email); ?><br />
                                                        Purchaser agrees to abide by the company <a href="<?php echo site_url('return_policy'); ?>" target="_blank">Return Policy</a>.
													</p>
												</div>

												<div class="col-sm-8 checkout-summary-addresses clearfix">
													<div class="row">
														<div class="col-sm-12">
															<div class="well">

																<h5> Payment Information </h5>

																<div style="width:153px;height:24px;overflow:hidden;display:inline-block;">
																	<img style="width:216px;height:24px;" src="<?php echo base_url(); ?>images/credit-card-graphic.gif" />
																</div>
																xxxx-xxxx-xxxx-<?php echo substr($this->session->flashdata('cc_number'), 12); ?>
															</div>
														</div>

                                                        <?php
                                                        /**********
                                                         * Billing, Shipping Address, and Shipping Method
                                                         */
                                                        ?>
														<?php $this->load->view('metronic/checkout_summary_addresses'); ?>

													</div>
												</div>

												<div class="col-sm-12 cart_basket_wrapper">

													<div class="cart_basket">

														<hr style="margin:5px 0 10px;border-color:#888;border-width:2px;" />

														<div class="table-scrollable table-scrollable-borderless">
															<table class="table table-striped table-hover table-light">
																<thead>
																	<tr>
																		<th> Items (<?php echo $this->order_details->order_qty; ?>) </th>
																		<th> Availability </th>
																		<th> Quantity </th>
																		<th class="text-right"> Unit Price </th>
																		<th class="text-right"> Subtotal </th>
																	</tr>
																</thead>
																<tbody>

																	<?php
																	if ($this->order_details->order_items)
																	{
																		$i = 1;
																		foreach ($this->order_details->order_items as $items)
																		{ ?>

																	<tr>
																		<?php
																		/**********
																		 * Item IMAGE and Details
																		 * Image links to product details page
																		 */
																		?>
																		<td>
																			<img class="tooltips" src="<?php echo $this->config->item('PROD_IMG_URL').$items->image; ?>" alt="<?php echo $items->prod_no; ?>" data-original-title="<?php echo $items->prod_no; ?>"  width="60" style="float:left;" />
																			<div class="shop-cart-item-details" style="margin-left:80px;">
																				<h4 style="margin:0px;">
																					<?php echo $items->prod_no; ?>
																					<br />
																					<span style="font-size:0.8em;">
																						<?php echo $items->prod_name; ?>
																					</span>
																				</h4>
																				<p style="margin:0px;">
																					<span style="color:#999;">Product#: <?php echo $items->prod_no; ?></span><br />
																					Size: &nbsp; <?php echo $items->size; ?><br />
																					Color: &nbsp; <?php echo $items->color; ?>
																				</p>
																			</div>
																		</td>
																		<?php
																		/**********
																		 * Status
																		 */
																		?>
																		<td>
																			<?php echo @$items->custom_order == '1' ? '<span style="color:red;">Pre-order<br />Ships in 14-16 weeks</span>' : 'In Stock'; ?>
																			<?php if (@$items->custom_order == '3')
																			{ ?>
																			<br />
																			<span style="color:red;">On Special Sale</span>
																				<?php
																			} ?>
																		</td>
																		<?php
																		/**********
																		 * Qty
																		 */
																		?>
																		<td>
																			<?php echo $items->qty; ?>
																		</td>
																		<?php
																		/**********
																		 * Unit Price and Subtotal
																		 */
																		?>
																		<td class="text-right"> $ <?php echo $this->cart->format_number($items->unit_price); ?> </td>
																		<td class="text-right">
																			$ <?php echo $this->cart->format_number($items->subtotal); ?>
																		</td>
																	</tr>
																			<?php
																			$i++;
																			if (@$items->flag == '3') $custom_order = TRUE;
																			else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
																			else $custom_order = FALSE;
																		}
																	} ?>

																</tbody>
															</table>
														</div>

														<hr />

													</div>
												</div>

												<?php if ($this->order_details->order_items > 0)
												{ ?>

												<div class="col-sm-6">
												</div>

												<div class="col-sm-6">
													<table class="table table-condensed cart-summary">
														<tr>
															<td>Subtotal</td>
															<td class="text-right">$ <?php echo number_format($this->order_details->order_amount, 2); ?></td>
														</tr>
														<tr>
															<td>Shipping &amp; Handling</td>
															<td class="text-right">
																<?php echo number_format($this->order_details->shipping_fee, 2); ?>
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
																<hr style="margin:5px 0;" />
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

											</form>
											<!-- END FORM =======================================================-->

											<!-- PENDING -->
											<div class="modal fade bs-modal-md" id="pending-print-receipt" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-md">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
															<h3 class="modal-title">Apologies for the inconvenince</h3>
														</div>
														<div class="modal-body">
																Please bear with us as this section of the website is currently under construction.<br />Please contact us <a href="<?php echo site_url('contact'); ?>">here</a> for further querries
														</div>
														<div class="modal-footer">
															<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
											<!-- /.modal -->

										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
