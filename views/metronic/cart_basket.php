                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

										<?php
										/***********
										 * Noification area
										 */
										?>
										<div class="margin-top-20">
											<div class="alert alert-danger display-hide">
												<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
											<div class="alert alert-success display-hide">
												<button class="close" data-close="alert"></button> Your form validation is successful! </div>
											<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
											<div class="alert alert-danger">
												<button class="close" data-close="alert"></button> An error occured. Please try again.
											</div>
											<?php } ?>
											<?php if ($this->session->flashdata('error') == 'minimum_order_required') { ?>
											<div class="alert alert-danger">
												<button class="close" data-close="alert"></button> Minimun First Order 15 Units. Please add more items to cart.
											</div>
											<?php } ?>
											<?php if (validation_errors()) { ?>
											<div class="alert alert-danger">
												<button class="close" data-close="alert"></button> <?php echo validation_errors(); ?>
											</div>
											<?php } ?>
										</div>

										<div class="cart_basket_wrapper">
											<div class="row margin-top-20">
												<div class="col col-sm-12">
													<div class="cart_basket">

														<h3>SHOPPING BAG</h3>

														<hr style="margin:5px 0 10px;border-color:#888;border-width:2px;" />

														<div class="table-scrollable table-scrollable-borderless">
															<table class="table table-striped table-hover table-light">
																<thead>
																	<tr>
																		<th> Items (<?php echo $this->cart->total_items(); ?>) </th>
																		<th> Quantity </th>
																		<th> Status </th>
																		<th class="text-right"> Unit Price </th>
																		<th class="text-right"> Subtotal </th>
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
																		 * Qty (editable)
																		 */
																		?>
																		<td>
																			<div class="box"><?php echo $items['qty']; ?></div>
																			<div class="box-tools clearfix">
																				<button data-toggle="modal" href="#modal-regular2-<?php echo $items['rowid']; ?>" type="button" class="btn btn-link btn-xs"><i class="fa fa-pencil"></i> Edit</button>
																				<br />
																				<button data-toggle="modal" href="#modal-remove-<?php echo $items['rowid']; ?>" type="button" class="btn btn-link btn-xs"><i class="fa fa-close"></i> Remove</button>

																				<!-- EDIT CART ITEM QTY -->
																				<div id="modal-regular2-<?php echo $items['rowid']; ?>" class="modal fade draggable-modal ui-draggable bs-modal-sm in" id="small" tabindex="-1" role="dialog" aria-hidden="true">
																					<div class="modal-dialog modal-sm">
																						<div class="modal-content">

																							<?php echo form_open('cart/update_cart', array('class'=>'form-horizontal')); ?>

																							<div class="modal-header">
																								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																								<h4 class="modal-title">Edit Item</h4>
																							</div>
																							<div class="modal-body">

																								<?php echo $items['options']['prod_no'].'<br />'; ?>
																								<?php echo $items['name']; ?>

																								<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
																								<?php echo form_hidden('special_sale_prefix', ($this->uri->segment(1) === 'special_sale' ? '1' : '0')); ?>
																								<?php echo 'Quantity: '; ?>

																								<div class="form-group">
																									<label class="control-label col-md-3">Quantity
																									</label>
																									<div class="col-md-3">
																										<input type="text" name="<?php echo $i.'[qty]'; ?>" data-required="1" class="form-control input-sm" value="<?php echo $items['qty']; ?>" maxlength="3" size="2" />
																									</div>
																								</div>

																							</div>
																							<div class="modal-footer">
																								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
																								<button type="submit" class="btn dark">Apply changes</button>
																							</div>

																							<?php echo form_close(); ?>

																						</div>
																						<!-- /.modal-content -->
																					</div>
																					<!-- /.modal-dialog -->
																				</div>
																				<!-- /.modal -->

																				<!-- REMOVE ITEM FROM CART -->
																				<div id="modal-remove-<?php echo $items['rowid']; ?>" class="modal fade draggable-modal ui-draggable bs-modal-sm in" id="small" tabindex="-1" role="dialog" aria-hidden="true">
																					<div class="modal-dialog modal-sm">
																						<div class="modal-content">
																							<div class="modal-header">
																								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																								<h4 class="modal-title">Remove Item</h4>
																							</div>
																							<div class="modal-body">

																								<?php echo $items['options']['prod_no'].'<br />'; ?>
																								<?php echo $items['name']; ?>
																								<br /><br />
																								Remove item from cart?

																							</div>
																							<div class="modal-footer">
																								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
																								<a href="<?php echo site_url('cart/update_cart/index/'.$i.'/'.$items['rowid']); ?>" type="submit" class="btn dark">Remove</a>
																							</div>
																						</div>
																						<!-- /.modal-content -->
																					</div>
																					<!-- /.modal-dialog -->
																				</div>
																				<!-- /.modal -->

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
																			<span style="color:red;">On Clearance</span>
																				<?php
																			} ?>
																		</td>
																		<?php
																		/**********
																		 * Unit Price
																		 */
																		?>
																		<td class="text-right">
                                                                            <?php if (@$items['options']['custom_order'] == '3')
																			{
                                                                                echo '<span style="text-decoration:line-through;">$ '.$this->cart->format_number(@$items['options']['orig_price']).'</span>';
                                                                                echo '&nbsp;';
                                                                                echo '<span style="color:red;">$ '.$this->cart->format_number($items['price']).'</span>';
																			}
                                                                            else
                                                                            {
                                                                                echo '$ '.$this->cart->format_number($items['price']);
                                                                            } ?>
                                                                        </td>
                                                                        <?php
																		/**********
																		 * Subtotal
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
													<div class="portlet light" style="padding-top:0px;">
														<div class="portlet-title">
															<div class="caption">
																<span class="caption-subject"> Promo Codes </span>
															</div>
														</div>
														<div class="portlet-body">

															<div class="input-group">
																<div class="input-icon">
																	<input class="form-control" name="promocode" type="text">
																</div>
																<span class="input-group-btn">
																	<button id="genpassword" class="btn dark" type="button">
																		<i class="fa fa-arrow-left fa-fw"></i> Apply </button>
																</span>
															</div>

														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<table class="table table-condensed cart-summary">
														<tr>
															<td>Subtotal</td>
															<td class="text-right">$ <?php echo $this->cart->format_number($this->cart->total()); ?></td>
														</tr>
														<tr>
															<td>Estimated Shipping &amp; Handling</td>
															<td class="text-right">TBD</td>
														</tr>
														<tr>
															<td>Estimated Sales Tax (NY, USA only)</td>
															<td class="text-right">TBD</td>
														</tr>
														<tr>
															<td colspan="2">
																<hr style="margin:5px 0;" />
															</td>
														</tr>
														<tr>
															<td><strong>Estimated Total</strong></td>
															<td class="text-right">$ <?php echo $this->cart->format_number($this->cart->total()); ?></td>
														</tr>
													</table>

													<div class="row">
														<div class="col-sm-6 pull-right">
															<?php if ($this->session->user_loggedin)
															{ ?>
															<a href="<?php echo site_url('checkout/delivery'); ?>" class="btn dark btn-block" type="button"> Proceed to Checkout </a>
																<?php
															}
															else
															{ ?>
															<a href="<?php echo site_url('checkout'); ?>" class="btn dark btn-block" type="button"> Proceed to Checkout </a>
																<?php
															} ?>
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
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
