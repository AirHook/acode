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
					        	<?php lang('create_stock_count'); ?>
					        	</div>
					          	 <span>
					                  <?php $controller->showFlash(); 
					                  ?>
					                </span>
					               <div class="panel panel-body">
					                
								<div class="well">
								<form method="POST" action="<?php echo base_url('accounting/products/createStockInvoice'); ?>">
									<?php if(isset($model->id)): ?>
										<input type="hidden" name="id" value="<?php echo $model->id; ?>">
									<?php endif; ?>
								<div class="well" >
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label>Select Product</label>
												<select class="stock_product form-control select2">
													<?php
													if(isset($products) && !empty($products)) {
														foreach ($products as $product) {
															echo '<option value="'.$product->id.'">'.$product->productName.'</option>';
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-sm-1">
											<div class="form-group">
												<label><div>&nbsp;</div></label>
												<a href="#" class="btn btn-primary add-stock-row"><i class="fa fa-plus"></i>&nbsp;Add</a>
											</div>
										</div>
										<div class="col-sm-2">
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label>Show Counted before</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" value="<?php echo date('M d Y'); ?>" class="form-control datepicker from_date" >
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group">
												<label><div>&nbsp;</div></label>
												<a href="#" class="btn btn-primary show-all-product"><i class="fa fa-search"></i>&nbsp;Show All Products</a>
											</div>
										</div>
									</div>
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
														<th></th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th colspan="5">Total</th>
														<th class="total_expected"></th>
														<th class="total_counted"></th>
														<th class="total_difference"></th>
														<th class="total_cost_price"></th>
														<th class="total_sale_price"></th>
														<th></th>
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
														<td class="more_qty"></td>
														<td class="more_sale"></td>
														<td class="more_cost"></td>
													</tr>
													<tr>
														<td>Less than expected</td>
														<td class="less_qty"></td>
														<td class="less_sale"></td>
														<td class="less_cost"></td>
													</tr>
												</tbody>
												<tfoot>
													<tr>
														<th>Net Difference</th>
														<th class="total_difference"></th>
														<th class="total_sale_price"></th>
														<th class="total_cost_price"></th>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>
								</div>
								<br>
								<br>
								<div class="row">
									<div class="col-sm-12">
										<label><input type="checkbox" name="print"  value="">&nbsp;Print Invoice</label>
									</div>
								</div>
								<div class="row">
			               		<div class="col-sm-8">
			                	<a href="<?php echo  base_url('accounting/products/stockInvoices')?>" class="form-btn btn  btn-default btn-default1 ">
			                		<?php lang('btn_cancel'); ?>
			                	</a>&nbsp&nbsp
			                	<input type="submit" value="<?php lang('apply_changes_to_inventory'); ?>" name="apply_inventory" class="form-btn btn btn-shadow btn-primary "/>
			                	<input type="submit" value="<?php lang('btn_save'); ?>" name="submit" class="form-btn btn btn-shadow btn-primary "/>
			                	</div>
			                	</div>
			                </form>
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

