													<!-- BEGIN Portlet PORTLET-->
													<div class="portlet light bordered order-summary">
														<div class="portlet-title">
															<div class="caption">
																<span class="caption-subject"> Order Summary</span>
															</div>
														</div>
														<div class="portlet-body">

															<div class="mt-element-list">
																<div class="mt-list-container list-news ext-1">
																	<ul>
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

																		<li class="mt-list-item clearfix">
																			<!-- IMAGE -->
																			<div class="list-thumb">
																				<a href="<?php echo $items['options']['current_url']; ?>">
																					<img alt="" src="<?php echo $this->config->item('PROD_IMG_URL').$href_text; ?>" />
																				</a>
																			</div>
																			<!-- INFO -->
																			<div class="list-item-content">
																				<!-- Prod No and Details -->
																				<h4 style="margin:0px;">
																					<?php echo $items['options']['prod_no']; ?>
																					<br />
																					<span style="font-size:0.8em;">
																						<?php echo $items['name']; ?>
																					</span>
																				</h4>
																				<!-- Sub Details -->
																				<p style="margin:0px;">
																					<span style="color:#999;">Product#: <?php echo $items['options']['prod_no']; ?></span><br />
																					Size: &nbsp; <?php echo $items['options']['size']; ?><br />
																					Color: &nbsp; <?php echo $items['options']['color']; ?><br />
																					Quantity: &nbsp; <?php echo $items['qty']; ?><br />
																					<small style="font-size:0.7em;">
																						<?php echo @$items['options']['custom_order'] == '1' ? '<cite style="color:red;">Pre-order - Ships in 14-16 weeks</cite>' : '<cite style="color:#999;">In Stock</cite>'; ?>
																						<?php if (@$items['options']['custom_order'] == '3')
																						{ ?>
																						<br />
																						<cite style="color:red;">On Clearance</cite>
																							<?php
																						} ?>
																					</small>
																				</p>
																			</div>
																			<!-- SUBTOTAL -->
																			<div class="list-item-price">
																				$ <?php echo $this->cart->format_number($items['subtotal']); ?>
																			</div>
																		</li>
																				<?php
																				$i++;
																				if (@$items['options']['custom_order'] == TRUE) $custom_order = TRUE;
																				else if (isset($custom_order) && $custom_order == TRUE) $custom_order = TRUE;
																				else $custom_order = FALSE;
																			}
																		} ?>

																	</ul>
																</div>
															</div>

															<div class="total-summary margin-top-30">

																<table class="table table-condensed cart-summary">
																	<tr>
																		<td>Order Subtotal</td>
																		<td class="text-right">$ <?php echo $this->cart->format_number($this->cart->total()); ?></td>
																	</tr>
																	<tr>
																		<td>Estimated Shipping &amp; Handling</td>
																		<td class="text-right" id="add-shipping">
																			<?php
																			if ($this->session->shipmethod && $stepi > 2)
																			{
																				$summary_shipping = $this->session->fix_fee;
																				echo '$ '.$this->cart->format_number($summary_shipping);
																			}
																			else
																			{
																				$summary_shipping = 0;
																				echo 'TBD';
																			}
																			?>
																		</td>
																	</tr>
																	<tr>
																		<td>Estimated Sales Tax (NY, USA only)</td>
																		<td class="text-right" id="add-tax">
																			<?php
																			if (
																				($ny_tax == '1' && ($stepi == 1 OR $stepi == 2))
																				OR ($this->session->ny_tax && $stepi > 1)
																			)
																			{
																				$summary_nytax = $this->cart->total() * $this->webspace_details->options['ny_sales_tax'];
																				echo '$ '.$this->cart->format_number($summary_nytax);
																			}
																			else
																			{
																				$summary_nytax = 0;
																				echo 'TBD';
																			}
																			?>
																		</td>
																	</tr>
																	<tr>
																		<td><strong>Estimated Total</strong></td>
																		<td class="text-right" id="estimated-total" data-original-value="<?php echo $this->cart->total(); ?>">
																			<?php
																			$estimated_total = $this->cart->total() + $summary_shipping + $summary_nytax;
																			echo '$ '.$this->cart->format_number($estimated_total);
																			?>
																		</td>
																	</tr>
																</table>

															</div>

														</div>
													</div>
													<!-- END Portlet PORTLET-->
