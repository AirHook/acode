                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<div class="checkout-wrapper">

											<!-- BEGIN FORM =======================================================-->
											<?php echo form_open(
												'checkout/review',
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

												<div class="col-sm-8 checkout-summary-addresses clearfix">
													<div class="row">
														<div class="col-sm-12">
															<h4> <?php echo $this->session->user_role == 'wholesale' ? 'Inquiry' : 'Order'; ?> Review </h4>
															<div class="well">

																<h5> Payment Information <span class="small"> &nbsp; <a href="<?php echo site_url('checkout/payment'); ?>" style="color:black;">Edit</a></span></h5>

                                                                <?php
                                                                if ($this->session->user_role == 'wholesale_')
                                                                {
                                                                    switch ($this->session->ws_payment_options)
                                                                    {
                                                                        case '1':
                                                                            echo 'Use my card on file.';
                                                                        break;
                                                                        case '2':
                                                                            echo 'Add a card.<br />';
                                                                        break;
                                                                        case '3':
                                                                            echo 'Send Paypal Invoice.';
                                                                        break;
                                                                        case '4':
                                                                            echo 'Bill My Account.';
                                                                        break;
                                                                        case '5':
                                                                            echo 'Send Wire Request.';
                                                                        break;
                                                                    }

                                                                    if ($this->session->ws_payment_options == '2')
                                                                    { ?>

                                                                <div style="width:153px;height:24px;overflow:hidden;display:inline-block;">
																	<img style="width:216px;height:24px;" src="<?php echo base_url(); ?>images/credit-card-graphic.gif" />
																</div>

                                                                        <?php
                                                                        echo '&nbsp; xxxx-xxxx-xxxx-'.substr($this->session->flashdata('cc_number'), 12);
                                                                    }
                                                                    echo '<br />Account payment terms applicable.';
                                                                }
                                                                else
                                                                { ?>

                                                                <div style="width:153px;height:24px;overflow:hidden;display:inline-block;">
																	<img style="width:216px;height:24px;" src="<?php echo base_url(); ?>images/credit-card-graphic.gif" />
																</div>

                                                                    <?php
                                                                    echo '&nbsp; xxxx-xxxx-xxxx-'.substr($this->session->flashdata('cc_number'), 12);
                                                                } ?>
															</div>
														</div>

														<?php $this->load->view('metronic/checkout_summary_addresses'); ?>

													</div>
												</div>

												<div class="col-sm-12 cart_basket_wrapper">

													<div class="clearfix">
                                                        <div class="actions col-sm-3" style="float:right;margin-right:-15px;">
															<a href="<?php echo site_url('checkout/submit'); ?>" class="btn dark btn-block" type="button"> Submit <?php echo $this->session->user_role == 'wholesale' ? 'Inquiry' : 'Order'; ?> </a>
                                                        </div>

														<h4> Your Order <span class="small"> &nbsp; <a href="<?php echo site_url('cart'); ?>" style="color:black;">Edit</a></span></h4>

													</div>

													<div class="cart_basket">

														<hr style="margin:5px 0 10px;border-color:#888;border-width:2px;" />

														<div class="table-scrollable table-scrollable-borderless">
															<table class="table table-striped table-hover table-light">
																<thead>
																	<tr>
																		<th> Items (<?php echo $this->cart->total_items(); ?>) </th>
																		<th> Availability </th>
																		<th> Quantity </th>
                                                                        <th class="text-right"> Regular Price </th>
                                                                        <th class="text-right"> Discounted Price </th>
																		<th class="text-right"> Extended Price </th>
																	</tr>
																</thead>
																<tbody>

																	<?php
																	if ($this->cart->contents())
																	{
																		$i = 1;
																		foreach ($this->cart->contents() as $items)
																		{
																			// incorporate new image url system
																			if (
																				isset($items['options']['prod_image_url'])
																				&& ! empty($items['options']['prod_image_url'])
																			)
																			{
																				$href_text = str_replace('_f2', '_f3', $items['options']['prod_image_url']);
																			}
																			else
																			{
																				$href_text = str_replace('_2', '_3', $items['options']['prod_image']);
																			} ?>

																	<tr>
																		<?php
																		/**********
																		 * Item IMAGE and Details
																		 * Image links to product details page
																		 */
																		?>
																		<td>
																			<a class="pull-left" href="<?php echo $items['options']['current_url']; ?>" title="<?php echo $items['options']['prod_no']; ?>">
																				<img class="tooltips" src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" alt="<?php echo $items['options']['prod_no']; ?>" data-original-title="<?php echo $items['options']['prod_no']; ?>"  width="60" />
																			</a>
																			<div class="shop-cart-item-details" style="margin-left:80px;">
																				<h4 style="margin:0px;">
																					<a href="<?php echo $items['options']['current_url']; ?>" title="<?php echo $items['options']['prod_no']; ?>" class="tooltips" data-original-title="<?php echo $items['options']['prod_no']; ?>" data-placement="right">
																						<?php echo $items['options']['prod_no']; ?>
																						<br />
																						<span style="font-size:0.8em;">
																							<?php echo $items['name']; ?>
																						</span>
																					</a>
																				</h4>
																				<p style="margin:0px;">
																					<span style="color:#999;">Product#: <?php echo $items['options']['prod_no']; ?></span><br />
																					Size: &nbsp; <?php echo $items['options']['size']; ?><br />
																					Color: &nbsp; <?php echo $items['options']['color']; ?>
																				</p>
																			</div>
																		</td>
																		<?php
																		/**********
																		 * Status
																		 */
																		?>
																		<td>
																			<?php echo @$items['options']['custom_order'] == '1' ? '<span style="color:red;">Pre-order<br />Ships in 14-16 weeks</span>' : 'In Stock'; ?>
																			<?php if (@$items['options']['custom_order'] == '3')
																			{ ?>
																			<br />
																			<span style="color:red;">On Sale</span>
																				<?php
																			} ?>
																		</td>
																		<?php
																		/**********
																		 * Qty
																		 */
																		?>
																		<td>
																			<?php echo $items['qty']; ?>
																		</td>
                                                                        <?php
																		/**********
																		 * Regular Price
																		 */
																		?>
																		<td class="text-right">
                                                                            <?php if (@$items['options']['custom_order'] == '3')
																			{
                                                                                echo '<span style="text-decoration:line-through;">$ '.$this->cart->format_number(@$items['options']['orig_price']).'</span>';
																			}
                                                                            else
                                                                            {
                                                                                echo '$ '.$this->cart->format_number($items['price']);
                                                                            } ?>
                                                                        </td>
                                                                        <?php
																		/**********
																		 * Discounted Price
																		 */
																		?>
																		<td class="text-right">
                                                                            <?php if (@$items['options']['custom_order'] == '3')
																			{
                                                                                echo '<span style="color:red;">$ '.$this->cart->format_number($items['price']).'</span>';
																			}
                                                                            else
                                                                            {
                                                                                echo '--';
                                                                            } ?>
                                                                        </td>
                                                                        <?php
																		/**********
																		 * Extended
																		 */
																		?>
																		<td class="text-right">
																			$ <?php echo $this->cart->format_number($items['subtotal']); ?>
																		</td>
																	</tr>
																			<?php
																			$i++;
																			if (@$items['options']['custom_order'] == TRUE) $custom_order = TRUE;
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

												<?php if ($this->cart->total_items() > 0)
												{ ?>

												<div class="col-sm-6">
												</div>

												<div class="col-sm-6">
													<table class="table table-condensed cart-summary">
														<tr>
															<td>Subtotal</td>
															<td class="text-right">$ <?php echo $this->cart->format_number($this->cart->total()); ?></td>
														</tr>
														<tr>
															<td>Shipping &amp; Handling</td>
															<td class="text-right">
																<?php
																if ($this->session->shipmethod)
																{
																	switch ($this->session->shipmethod)
																	{
																		case '1':
																			$fix_fee = 16;
																		break;
																		case '2':
																			$fix_fee = 45;
																		break;
																		case '3':
																			$fix_fee = 65;
																		break;
																		case '4':
																			$fix_fee = 125;
																		break;
																	}

																	echo '$ '.$this->cart->format_number($fix_fee);
																}
																else
																{
																	$fix_fee = 0;
																	echo 'TBD';
																}
																?>
															</td>
														</tr>
														<tr>
															<td>Sales Tax (NY, USA only)</td>
															<td class="text-right">
                                                                <?php
                                                                if ($this->session->ny_tax)
                                                                {
                                                                    $review_nytax = $this->cart->total() * (@$this->webspace_details->options['ny_sales_tax'] ?: '0.08875');
                                                                }
                                                                else $review_nytax = 0;

                                                                echo '$ '.number_format($review_nytax, 2);
                                                                ?>
                                                            </td>
														</tr>
														<tr>
															<td colspan="2">
																<hr style="margin:5px 0;" />
															</td>
														</tr>
														<tr>
															<td><strong>Grand Total</strong></td>
															<td class="text-right">
                                                                <?php
                                                                $review_total = $this->cart->total() + $fix_fee + $review_nytax;
                                                                echo '$ '.number_format($review_total, 2);
                                                                ?>
															</td>
														</tr>
													</table>

													<div class="row">
														<div class="col-sm-6 pull-right">
															<a href="<?php echo site_url('checkout/submit'); ?>" class="btn dark btn-block" type="button"> Submit <?php echo $this->session->user_role == 'wholesale' ? 'Inquiry' : 'Order'; ?> </a>
														</div>
													</div>

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

										</div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
