<?php $controller =& get_instance(); 
$controller->load->model('sale_model');?>
<div class="wrapper animated fadeInRight">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					       <div class="col-sm-12">
					        <div class="panel panel-info">
							<div class="panel-heading"><?php lang('heading_sales_return'); ?> 
							<a href="<?php echo base_url('accounting/sales/saleReturn') ?>" class="btn btn-back pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;<?php lang('btn_go_back'); ?></a>
							</div>
							  <div class="panel panel-body">
					          	 <span>
					                  <?php $controller->showFlash(); ?>
					                </span>
					                <?php if(isset($model['id'])) { ?>
					               	<form action="<?php echo base_url('accounting/sales/saleReturn') ."/". $model['id']?>" method="POST" role="form">
					               <?php } else{ ?>
					               	<form action="<?php echo base_url('accounting/sales/saleReturn') ?>" method="POST" role="form">
					               <?php } ?>
					               <input type="hidden" name="salesInvoiceNo" value="<?php echo isset($model['salesInvoiceNo']) ? $model['salesInvoiceNo'] :''; ?>">
					               <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
									<div class="row">
										<div class="col-sm-4">
											<div class="input-left form-group">
												<label ><?php lang('lab_customer_cash'); ?>:</label>
											</div>
											<div class="input-right form-group">
												<input type="hidden" name="supplierId" class="customer_id" value="">
												<select required="" class="form-control select2 customername sale_returns" name="supplierId">
													<option></option>
													<?php
														$result=$controller->sale_model->getCustomers();
														if(!empty($result)){
															foreach($result as $index => $value){?>
													 	 	<option <?php echo ((isset($model['customerId']) && $model['customerId'] == $value->id ) || $index == 0) ? 'selected' :''; ?> value="<?php echo isset($value->id) ? $value->id :''; ?>">
													 	 		<?php echo isset($value->ledgerName) ? $value->ledgerName :''; ?>
													 	 	</option>
													<?php } } ?>
												</select>
											</div>
											
										</div>
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<div class="input-left-box form-group">
												<label><?php lang('lab_sales_invoice'); ?>:</label>
											</div>
											<div class="input-right-box form-group">
												<select required="" class="form-control select2 search-by-saleinvoice-no sale_returns_select" name="salesInvoiceNo">
														<option></option>
													<?php 
													$saleInvoicess=$controller->sale_model->getUnReturnInvoice();
															if(!empty($saleInvoicess)){
																foreach($saleInvoicess as $khanzarri){?>
																<option value="<?php echo isset($khanzarri->salesInvoiceNo) ? $khanzarri->salesInvoiceNo :''; ?>">
																	<?php echo isset($khanzarri->salesInvoiceNo) ? $khanzarri->salesInvoiceNo :''; ?>
																</option>
														<?php } } ?> 
												</select>
											</div>
											<div class="input-left-box form-group">
												 <div class="form-group ">
											        <label><?php lang('lab_current_date'); ?>:</label>	
												</div>	
											</div>
											<div class="input-right-box form-group">
												<div class="form-group ">
													<div class="input-group calendar">
													<?php if(isset($model['deliveryDate'])) { ?>
														<input required="" readonly="" type="text" name="deliveryDate" class="form-control <?php echo ($controller->has_access_of('edit_date_sale_return')) ? 'datepicker' : ''; ?>" value="<?php echo isset($model['deliveryDate']) ? date("M d,Y",strtotime($model['deliveryDate'])) :''; ?>">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<?php }else { ?>
														<input required="" readonly="" type="text" name="deliveryDate" class="form-control <?php echo ($controller->has_access_of('edit_date_sale_return')) ? 'datepicker' : ''; ?>" value="<?php echo date('M d,Y'); ?>">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="well well-padding">
										<div class="row">
											<div class="col-sm-12">
												<div class="">
												<table class="table products_list product_details">
													<thead>
														<tr>
															<th>#</th>
															<th><?php lang('lab_barcode'); ?></th>
															<th><?php lang('lab_select_product'); ?></th>
															<th><?php lang('lab_unit'); ?></th>
															<th><?php lang('lab_sale_qty'); ?></th>
															<th><?php lang('lab_return_qty'); ?></th>
															<th><?php lang('lab_unit_price'); ?></th>
															<th><?php lang('lab_select_tax'); ?></th>
															<th style="text-align: center;"><?php lang('lab_total_amount'); ?></th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														
													</tbody>
												</table>
												</div>
											</div>
										</div>
									</div>
										<div class="row">
											<div class="col-sm-4">
												<div class="input-left form-group">
													<label><?php lang('lab_remarks'); ?></label>	
												</div>
												<div class="input-right form-group">
													<textarea  name="narration" rows="4" class="form-control"><?php echo isset($model['narration']) ? $model['narration'] :'';?></textarea>
												</div>
											</div>
											<div class="col-sm-3">
												
											</div>
											<div class="col-sm-5">
												
												<div class="input-left-box form-group">
													<label><?php lang('lab_subTotal'); ?></label>
												</div>
												<div class="input-right-box form-group">
													<input required="" type="text" readonly="" name="subtotal" class="form-control subtotal" value="<?php echo isset($model['subtotal']) ? $model['subtotal'] :'0'; ?>" placeholder="Sub Total">
												</div>
												
												<div class="input-left-box form-group">
													<label><?php lang('lab_tax'); ?></label>
												</div>
												<div class="input-right-box form-group">
													<div class="row">
														<!-- <div class="col-sm-5">
															<div class="input-group" style="margin-left:px">
																<input  type="number" value="<?php echo isset($model['tax']) ? $model['tax'] :'0'; ?>" class="form-control tax" name="tax">
																<input type="hidden" name="tax_symbal" class="tax_symbal" value="">
																<span class="input-group-addon tax_symbal"></span>
															</div>
														</div> -->
														<div class="col-sm-12">
														<div class="input-group">
															<input type="hidden" name="tax" value="">
															<input type="hidden" name="tax_return_amount">
															<select  class="form-control taxForSale select2 selecTax" name="tax_name">
															<option value="0"><?php lang('lab_select'); ?></option>
																<?php if(!empty($taxesOnBill)){
														foreach ($taxesOnBill as $value) { ?>
														 	<option <?php echo (isset($model['tax']) && $model['tax'] == $value->id) ? 'selected' :''; ?>  value="<?php echo isset($value->id) ? $value->id :''; ?>" data-taxvalue="<?php echo isset($value->tax_value) ? $value->tax_value :''; ?>" data-taxtype="<?php echo isset($value->tax_symbal) ? $value->tax_symbal :''; ?>" >
														 		<?php echo isset($value->ledgerName) ? $value->ledgerName :''; ?>(<?php echo isset($value->tax_value) ? $value->tax_value :''; ?><?php echo isset($value->tax_symbal) ? $value->tax_symbal :''; ?>)
														 	</option>
														<?php } } ?>
															</select>
															<div class="input-group-addon">
													    <span class="input-group-text selected-tax-value">0.00</span>
													  </div>
													  </div>
														</div>
													</div>
												</div>
												<input type="hidden" name="" class="taxForValuesForBill" value="">
												<input type="hidden" name="" class="taxSymbalForBill" value="">
												<div class="input-left-box form-group">
													<label><?php lang('lab_total_before_discount'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input  type="text" value="" class="form-control total_before_discount"  readonly="true">
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_discount'); ?></label>
												</div>
												<div class="input-right-box form-group">
													
														<input  type="MyNumber" value="<?php echo isset($model['discount']) ? $model['discount'] :'0'; ?>" class="form-control discount_old" >
													
												</div>
												<div class="input-left-box form-group">
													<label>Deduction</label>
												</div>
												<div class="input-right-box form-group">
													
														<input  type="MyNumber" value="<?php echo isset($model['discount']) ? $model['discount'] :'0'; ?>" class="form-control discountForSale discount" name="discount">
													
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_freight'); ?></label>
												</div>
												<div class="input-right-box form-group">
													<div class="row">
														<div class="col-sm-5">
														<input  type="MyNumber" value="<?php echo isset($model['freight']) ? $model['freight'] :'0'; ?>" class="form-control freight" name="freight">
														</div>
														<div class="col-sm-7">
															<select  class="form-control select2 indeirect-expenses" name="ledgerId">
																<option></option>
															<?php
																$indirectExpenses=$controller->sale_model->getAccountLedger();
																if(!empty($indirectExpenses)){
																	foreach($indirectExpenses as $expenses){?>
																    <option value="<?php echo isset($expenses->id) ? $expenses->id :''; ?>">
																    	<?php echo isset($expenses->ledgerName) ? $expenses->ledgerName :''; ?>
																    </option>
															<?php } } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_total'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input required="" type="MyNumber" value="<?php echo isset($model['total']) ? $model['total'] :'0'; ?>" readonly="" class="form-control total"  placeholder="Total" name="total">
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_return_PAYMENT'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input type="MyNumber" value="" class="form-control paymentReturn"  placeholder="Return Payment" name="payment_return">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4"></div>
											<div class="col-sm-8">
												<div class="input-right-box form-group invoice_footer_btns">
												<div class="col-sm-4">
													<button type="submit" name="submit" style="width: 100%;" class="btn btn-info"><?php lang('btn_save'); ?></button>
												</div>
												<div class="col-sm-4">
													<input type="submit" name="save_print" style="width: 100%;" class="btn btn-info" value="<?php lang('btn_save_and_print'); ?>">
													
												</div>
												<div class="col-sm-4">
													<a href="<?php echo base_url('accounting/sales/saleReturn') ?>" class="btn btn-primary" style="width: 100%;"><?php lang('btn_close'); ?></a>
												</div>
											</div>
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