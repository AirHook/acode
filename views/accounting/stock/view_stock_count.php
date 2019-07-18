<?php $controller =& get_instance(); 
$controller->load->model('product_model');
$controller->load->model('purchase_model');
?>
<div class="wrapper  promotion_page animated fadeInRight ">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					        <div class="col-sm-12 ">
					        <div class="panel panel-info">
					        	<div class="panel panel-heading">
					        	<?php lang('view_stock_count'); ?>
					        	</div>
					          	 <span>
					                  <?php $controller->showFlash(); 
					                  ?>
					                </span>
					               <div class="panel panel-body">
					                
								<div class="" >
									<div class="row">
										<div class="col-sm-6">
											<table>
												<tr>
													<th>Report Name:</th>
													<td>Stock Count</td>
												</tr>
												<tr>
													<th>Sale Man:</th>
													<td><?php echo isset($model->user_name) ? $model->user_name : ''; ?></td>
												</tr>
												<tr>
													<th>Date:</th>
													<td><?php echo isset($model->created_on) ? date('M d Y', strtotime($model->created_on)) : ''; ?></td>
												</tr>
											</table>
										</div>
										<div class="col-sm-6 text-right">
											<?php if(!isset($is_print)): ?>
											<a href="<?php echo base_url('accounting/products/viewStockInvoice/'.$model->id.'/print') ?>" class="btn btn-success"><i class="fa fa-print"></i>&nbsp;Print</a>
											<?php endif; ?>
										</div>
									</div>
									<br>
									<br>
								<div id="print-area">
									<div class="row">
										<div class="col-sm-12">
											<div class="">
											<table class="table table-bordered products_list stock-items">
												<thead>
													<tr>
														<th><?php lang('product'); ?></th>
														<th><?php lang('code'); ?></th>
														<th><?php lang('unit'); ?></th>
														<th><?php lang('cost_price'); ?></th>
														<th><?php lang('sale_price'); ?></th>
														<th><?php lang('expected'); ?></th>
														<th><?php lang('counted'); ?></th>
														<th><?php lang('difference'); ?></th>
														<th><?php lang('cost_price'); ?></th>
														<th><?php lang('sale_price'); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php
													$total_expected = 0;
													$total_counted = 0;
													$more_difference = 0;
													$less_difference = 0;
													$more_cost = 0;
													$less_cost = 0;
													$more_sale = 0;
													$less_sale = 0;
													if(isset($items) && !empty($items)) {
														foreach ($items as $item) {
															$total_expected += $item->expected_qty;
															$total_counted += $item->counted_qty;
															if($item->difference > 0)
																$more_difference += $item->difference;
															else
																$less_difference -= $item->difference;
															if($item->total_cost_price > 0)
																$more_cost += $item->total_cost_price;
															else
																$less_cost -= $item->total_cost_price;
															if($item->total_sale_price > 0)
																$more_sale += $item->total_sale_price;
															else
																$less_sale -= $item->total_sale_price;
															?>
															<tr>
																<td><?php echo $item->product_name; ?></td>
																<td><?php echo $item->code; ?></td>
																<td><?php echo $item->unit_name; ?></td>
																<td><?php echo $item->cost_price; ?></td>
																<td><?php echo $item->sale_price; ?></td>
																<td><?php echo $item->expected_qty; ?></td>
																<td><?php echo $item->counted_qty; ?></td>
																<td><?php echo ($item->difference > 0) ? '+' : ''; ?><?php echo $item->difference; ?></td>
																<td><?php echo ($item->total_cost_price > 0) ? '+' : ''; ?><?php echo $item->total_cost_price; ?></td>
																<td><?php echo ($item->total_sale_price > 0) ? '+' : ''; ?><?php echo $item->total_sale_price; ?></td>
															</tr>
															<?php
														}
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<th colspan="5">Total</th>
														<th class="total_expected"><?php echo $total_expected; ?></th>
														<th class="total_counted"><?php echo $total_counted; ?></th>
														<th class="total_difference"><?php echo ($more_difference - $less_difference); ?></th>
														<th class="total_cost_price"><?php echo ($more_cost - $less_cost); ?></th>
														<th class="total_sale_price"><?php echo ($more_sale - $less_sale); ?></th>
													</tr>
												</tfoot>
											</table>
											<br>
											<table class="table table-bordered">
												<thead>
													<tr>
														<th></th>
														<th>QTY</th>
														<th>Price</th>
														<th>Cost</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>More than expected</td>
														<td class="more_qty"><?php echo $more_difference; ?></td>
														<td class="more_sale"><?php echo $more_sale; ?></td>
														<td class="more_cost"><?php echo $more_cost; ?></td>
													</tr>
													<tr>
														<td>Less than expected</td>
														<td class="less_qty"><?php echo $less_difference; ?></td>
														<td class="less_sale"><?php echo $less_sale; ?></td>
														<td class="less_cost"><?php echo $less_cost; ?></td>
													</tr>
												</tbody>
												<tfoot>
													<tr>
														<th>Net Difference</th>
														<th class="total_difference"><?php echo ($more_difference - $less_difference); ?></th>
														<th class="total_sale_price"><?php echo ($more_sale - $less_sale); ?></th>
														<th class="total_cost_price"><?php echo ($more_cost - $less_cost); ?></th>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>
								</div>
		                          </div>
		                          </div>
		                        </div>
					        </div>
					    </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>

