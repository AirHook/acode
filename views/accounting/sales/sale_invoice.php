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
							<div class="panel-heading"><?php lang('heading_sales_invoices'); ?> 
							<a href="<?php echo base_url('accounting/sales/saleInvoice') ?>" class="btn btn-back pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;<?php lang('btn_go_back'); ?></a>
							</div>
							  <div class="panel panel-body">
					          	 <span>
					                  <?php $controller->showFlash(); ?>
					                </span>
					                <?php if(isset($model['id'])) { ?>
					               	<form action="<?php echo base_url('accounting/sales/editSaleInvoice') ."/". $model['id']?>" method="POST" role="form">
					               <?php } else{ ?>
					               	<form action="<?php echo base_url('accounting/sales/addSaleInvoice') ?>" method="POST" role="form">
					               <?php } ?>
					               <input type="hidden" name="salesInvoiceNo" value="<?php echo isset($model['salesInvoiceNo']) ? $model['salesInvoiceNo'] :''; ?>">
					               <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
									<div class="row">
										<div class="col-sm-4">
											<div class="input-left form-group">
												<label ><?php lang('lab_customer_cash'); ?>:</label>
											</div>
											<div class="input-right form-group">
												<select required="" class="form-control cashID  select2 customername" name="supplierId">
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
												<?php if(!empty($totalInvoice)) { ?>
												<input required="" type="text" name="salesInvoiceNo" value="<?php echo isset($totalInvoice) ? sprintf("%0".$this->voucher_number_length."d",$totalInvoice+1) :''; ?>" class="form-control" readonly="">
												<?php } else { ?>
												<input required="" type="text" name="salesInvoiceNo" value="<?php echo isset($model['salesInvoiceNo']) ? $model['salesInvoiceNo'] :'0001'; ?>" class="form-control" readonly="">
											<?php } ?>
											</div>
											<div class="input-left-box form-group">
												<label><?php lang('lab_sales_order_no'); ?>:</label>
											</div>
											<div class="input-right-box form-group">
											<?php if(isset($model['sale_order_no'])) { ?>
											<select  name="sale_order_no" class="form-control search-by-saleorder select2" >
													<option></option>
													<?php  
														$status=array('company_id'=>$this->session->userdata('company_id'));
														$saleOrder=$controller->sale_model->getAll('tbl_saleordermaster',$status);
														if(!empty($saleOrder)){
															foreach($saleOrder as $saleOrder){?>
													<option <?php echo (isset($model['sale_order_no']) && $model['sale_order_no'] == $saleOrder->saleorderNo ) ? 'selected' :''; ?> value="<?php echo isset($saleOrder->saleorderNo) ? $saleOrder->saleorderNo :''; ?>">
														<?php echo isset($saleOrder->saleorderNo) ? $saleOrder->saleorderNo :''; ?>
													</option>
													<?php } } ?>
												</select>
											<?php } else { ?>
												<select  name="sale_order_no" class="form-control search-by-saleorder select2" >
													<option></option>
													<?php  
														$status=array('company_id'=>$this->session->userdata('company_id'));
														$saleOrder=$controller->sale_model->getAll('tbl_saleordermaster',$status);
														if(!empty($saleOrder)){
															foreach($saleOrder as $saleOrder){?>
													<option value="<?php echo isset($saleOrder->saleorderNo) ? $saleOrder->saleorderNo :''; ?>">
														<?php echo isset($saleOrder->saleorderNo) ? $saleOrder->saleorderNo :''; ?>
													</option>
													<?php } } ?>
												</select>
											<?php } ?>
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
														<input required="" type="text" name="deliveryDate" class="form-control <?php echo ($controller->has_access_of('edit_date_sale_invoices')) ? 'datepicker' : ''; ?> deliveryDate" value="<?php echo isset($model['deliveryDate']) ? date("M d,Y",strtotime($model['deliveryDate'])) :''; ?>">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<?php }else { ?>
														<input required="" type="text" name="deliveryDate" class="form-control <?php echo ($controller->has_access_of('edit_date_sale_invoices')) ? 'datepicker' : ''; ?> deliveryDate" value="<?php echo date('M d,Y'); ?>">
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
															<th><?php lang('lab_qty'); ?></th>
															<th><?php lang('lab_unit_price'); ?></th>
															<th><?php lang('discount_amount'); ?></th>
															<th><?php lang('lab_select_tax'); ?></th>
															<th style="text-align: center;"><?php lang('lab_total_amount'); ?></th>
															<th></th>
														</tr>
													</thead>
													<tbody>
													<?php if(isset($model['purhcaseDetail'])) { ?>
													<?php $serial_no=1;
														foreach($model['purhcaseDetail'] as $key => $abidzari) { ?>
														<tr>
															<td>
																<?php echo $serial_no++; ?>
															</td>
															<input type="hidden" name="product[<?php echo $key ?>][id]" value="<?php echo isset($abidzari->id) ? $abidzari->id :''; ?>">
															<td>
																<div class="form-group">
																	<input required="" type="text" name="product[<?php echo $key ?>][barcode]" class="form-control barcodevalueForSale" value="<?php echo isset($abidzari->barcode) ? $abidzari->barcode :''; ?>">
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select  required="" class="form-control selectProductForSale  select2" name="product[<?php echo $key ?>][product_id]">
																	<option></option>
																	<?php
																		$products=$controller->sale_model->getStockProducts();
																		if(!empty($products)){
																		foreach($products  as $value){
																	 ?>
																		<option <?php echo (isset($abidzari->product_id) && $abidzari->product_id == $value->id) ? 'selected' :''; ?>  value="<?php echo isset($value->id) ? $value->id :''; ?>">
																			<?php echo isset($value->productName) ? $value->productName :''; ?>
																		</option>
																	<?php } } ?>
																	</select>
																</div>
																<input type="hidden" name="product[<?php echo $key ?>][productName]" class="productName" value="<?php echo isset($abidzari->productName) ? $abidzari->productName :''; ?>">
															
															<input type="hidden" name="" class="product-id" value="<?php echo isset($abidzari->product_id) ? $abidzari->product_id :''; ?>">
															</td>
															<td>
															<div class="form-group">
															<select required="" class="form-control UOMId getSalePriceByUnit select2" name="product[<?php echo $key ?>][UOMId]">
																		<option></option>
																		<?php 
																		if(isset($abidzari->UOMId) ):
																			$result=$controller->sale_model->getAll('tbl_uom', array('company_id' => $this->company_id));
																			if(!empty($result)){
																				foreach($result as $value){?>
																			<option <?php echo (isset($abidzari->UOMId) && $abidzari->UOMId==$value->id) ? 'selected':''; ?> value="<?php echo isset($value->id) ? $value->id :''; ?>">
																					<?php  echo isset($value->UOMName) ? $value->UOMName :''; ?>
																				</option> 
																		<?php	} }
																		endif;
																		?>
																	</select>
																	
																</div>
																<input type="hidden" name="" class="uom-id" value="<?php echo isset($abidzari->UOMId) ? $abidzari->UOMId :''; ?>">
															</td>
															<td>
																<div class="form-group">
																	<input required="" type="MyNumber" max="" name="product[<?php echo $key ?>][qty]" value="<?php echo isset($abidzari->qty) ? $abidzari->qty :''; ?>" class="form-control saleqty">
																</div>
																
															</td>
															<td>
																<input type="hidden" name="product[<?php echo $key ?>][rate]" class="purchaseRate" value="<?php echo isset($abidzari->rate) ? $abidzari->rate :''; ?>">
																<span class="purchaseRatehtml"><?php echo isset($abidzari->rate) ? $abidzari->rate:''; ?></span>
															</td>
															<td><input type="MyNumber" class="discount_amount form-control" name="product[<?php echo $key ?>][discount_amount]" value="<?php echo isset($abidzari->discount_amount) ? $abidzari->discount_amount :''; ?>"></td>
															<td style="padding-top: 8px;">
																<?php
																$taxName=$controller->sale_model->getAppliedTaxes($abidzari->product_id);
															 ?>
															 	<select name="product[<?php echo $key ?>][tax_id]" class="form-control appliedTaxes">
																	<option><?php lang('lab_select'); ?></option>
																	<?php if(!empty($product_taxes)){ 
																			foreach($product_taxes as $zarizartab){?>
																			<option <?php echo (isset($abidzari->tax_id) && $abidzari->tax_id == $zarizartab->id) ? 'selected' :''; ?> value="<?php echo isset($zarizartab->id) ? $zarizartab->id :''; ?>">
																				<?php echo isset($zarizartab->ledgerName) ? $zarizartab->ledgerName :''; ?>(<?php echo isset($zarizartab->tax_value) ? $zarizartab->tax_value :'';
																					echo '&nbsp;';
																					echo isset($zarizartab->tax_symbal) ? $zarizartab->tax_symbal :'';
																				 ?>)
																			</option>
																	<?php } } ?>
																</select>
																<input type="hidden" name="" class="totaTaxValue" value="<?php echo isset($abidzari->taxNames->tax_value) ? $abidzari->taxNames->tax_value :''; ?>">
																<input type="hidden" name="" class="taxSymbal" value="<?php echo isset($abidzari->taxNames->tax_type) ? $abidzari->taxNames->tax_type :''; ?>">
															</td>
															<td style="text-align: center;">
																<input type="hidden" name="product[<?php echo $key ?>][amount]" class="amount" value="<?php  echo isset($abidzari->amount) ? $abidzari->amount :'';?>">
																<span class="saleamounthtml"><?php echo isset($abidzari->amount) ? $abidzari->amount :''; ?></span>
															</td>
															<td>
																<a href="#" class="btn btn-info addNewTrforsale pull-right"><span class="fa fa-plus"></span></a>
																<a href="#" class="btn btn-danger deleteRowForsale  pull-right" style="margin-right:3px;"><i class="fa fa-trash-o"></i></a>
															</td>
														</tr>
														<?php } ?>
													<?php }else { ?>
														<tr>
															<td>1</td>
															<td>
																<div class="form-group">
																	<input  type="text" name="product[0][barcode]" class="form-control barcodevalueForSale" value="">
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select required="" class="form-control selectProductForSale select2" name="product[0][product_id]">
																	<option></option>
																	<?php
																		$products=$controller->sale_model->getStockProducts();
																		if(!empty($products)){
																		foreach($products  as $value){
																	 ?>
																		<option value="<?php echo isset($value->id) ? $value->id :''; ?>">
																			<?php echo isset($value->productName) ? $value->productName :''; ?>
																		</option>
																	<?php } } ?>
																	</select>
																</div>
															</td>
															<td>
																<input type="hidden" name="product[0][productName]" class="productName" value="">
																<span hidden class="productNamehtml"><?php lang('lab_fruture_mini_pack'); ?></span>
																<input type="hidden" name="" class="product-id" value="">
																<div class="form-group">
																	<select required="" class="form-control UOMId getSalePriceByUnit " name="product[0][UOMId]">
																		<option><?php lang('opt_select_unit'); ?></option>
																		
																	</select>
																	<input type="hidden" name="" class="uom-id" value="">
																</div>
															</td>
															<td>
																<div class="form-group">
																	<input required="" type="MyNumber" max="0" name="product[0][qty]" value="1" class="form-control saleqty">
																</div>
																
															</td>
															<td>
																<input type="MyNumber" name="product[0][rate]" class="purchaseRate form-control" value="00.00">
															</td>
															<td><input type="MyNumber" class="discount_amount  form-control" name="product[0][discount_amount]" value=""></td>
															<td style="padding-top: 8px;">
																<select name="product[0][tax_id]" class="form-control appliedTaxesForSale">
																	<option><?php lang('lab_select'); ?></option>
																	<?php if(isset($product_taxes) && !empty($product_taxes)){ 
																		foreach($product_taxes as $zarizartab){?>
																			<option <?php echo (isset($abidzari->tax_id) && $abidzari->tax_id == $zarizartab->id) ? 'selected' :''; ?> value="<?php echo isset($zarizartab->id) ? $zarizartab->id :''; ?>">
																				<?php echo isset($zarizartab->ledgerName) ? $zarizartab->ledgerName :''; ?>(<?php echo isset($zarizartab->tax_value) ? $zarizartab->tax_value :'';
																					echo '&nbsp;';
																					echo isset($zarizartab->tax_symbal) ? $zarizartab->tax_symbal :'';
																				 ?>)
																			</option>
																	<?php } } ?>
																</select>
																<input type="hidden" name="" class="totaTaxValue" value="0">
																<input type="hidden" name="" class="taxSymbal" value="0">
															</td>
															<td style="text-align: center;">
																<input type="hidden" name="product[0][amount]" class="amount" value="">
																<span class="saleamounthtml">00.000</span>
															</td>
															<td>
																<a href="#" class="btn btn-info addNewTrforsale pull-right"><span class="fa fa-plus"></span></a>
															</td>
														</tr>
													<?php } ?>
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
													<textarea name="narration" rows="4" class="form-control"><?php echo isset($model['narration']) ? $model['narration'] :'';?></textarea>
												</div>	
												<!-- <div class="input-right form-group">
													<input required="" type="checkbox" value="1" <?php echo (isset($model['salesInvoiceStatus']) && $model['salesInvoiceStatus'] == 1) ? 'checked' :''; ?> class="i-checks" name="salesInvoiceStatus">&nbsp;&nbsp;
													<label>Approved</label>
													&nbsp;&nbsp;&nbsp;&nbsp;
										             <input  type="checkbox" value="1" <?php echo (isset($model['salesInvoiceIsPrintAfterSave']) && $model['salesInvoiceIsPrintAfterSave'] == 1) ? 'checked' :''; ?> class="i-checks" name="salesInvoiceIsPrintAfterSave">&nbsp;&nbsp;
										             <label>Print After Save</label>
												</div> -->
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
													<div class="input-group">
													<select class="form-control select2 taxForSale" name="tax"> 
														<option value="0"><?php lang('lab_select'); ?></option>
														<?php 
														$tax_value = 0;
														$tax_symbal = '';
														if(!empty($taxesOnBill)){
															foreach ($taxesOnBill as $index => $value) { 
																if((isset($model['tax']) && $model['tax'] == $value->id) || $index == 0) {
																$tax_value = $value->tax_value;
																$tax_symbal = $value->tax_symbal;
															}
																?>
															 	<option <?php echo ((isset($model['tax']) && $model['tax'] == $value->id) || $index == 0) ? 'selected' :''; ?>  value="<?php echo isset($value->id) ? $value->id :''; ?>" data-taxvalue="<?php echo isset($value->tax_value) ? $value->tax_value :''; ?>" data-taxtype="<?php echo isset($value->tax_symbal) ? $value->tax_symbal :''; ?>" >
															 		<?php echo isset($value->ledgerName) ? $value->ledgerName :''; ?>(<?php echo isset($value->tax_value) ? $value->tax_value :''; ?><?php echo isset($value->tax_symbal) ? $value->tax_symbal :''; ?>)
															 	</option>
															<?php } } ?>
													</select>
													<div class="input-group-addon">
													    <span class="input-group-text selected-tax-value">0.00</span>
													  </div>
													  </div>
													<input type="hidden" name="" class="taxForValuesForBill" value="0">
												</div>

												<div class="input-left-box form-group">
													<label><?php lang('lab_total_inclusive_tax'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input  type="text" value="" class="form-control total_before_discount"  readonly="true">
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_freight'); ?></label>
												</div>
												<div class="input-right-box form-group">
													<div class="row">
														<div class="col-sm-5">
															<input required="" type="MyNumber" value="<?php echo isset($model['freight']) ? $model['freight'] :'0'; ?>" class="form-control freight freightForsale" name="freight">
														</div>
														<div class="col-sm-7">
															<select  class="form-control select2" name="ledgerId">
																<option></option>
															<?php
																$indirectExpenses=$controller->sale_model->getAccountLedger();
																if(!empty($indirectExpenses)){
																	foreach($indirectExpenses as $index => $expenses){?>
																    <option <?php echo ((isset($model['freight']) && $model['freight'] == $expenses->id) || $index ==0) ? 'selected' : ''; ?> value="<?php echo isset($expenses->id) ? $expenses->id :''; ?>">
																    	<?php echo isset($expenses->ledgerName) ? $expenses->ledgerName :''; ?>
																    </option>
															<?php } } ?>
															</select>
														</div>
													</div>
												</div>
												
												<div class="input-left-box form-group">
													<label><?php lang('lab_discount'); ?></label>
												</div>
												<div class="input-right-box form-group">
													<input required="" type="MyNumber" value="<?php echo isset($model['discount']) ? $model['discount'] :'0'; ?>" class="form-control discount discountForSale" name="discount">
													
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_total'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input required="" type="MyNumber" value="<?php echo isset($model['total']) ? $model['total'] :'0'; ?>" readonly="" class="form-control total"  placeholder="Total" name="total">
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('payment_method'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<select name="payment_method" class="form-control">
														<?php
														$payment_methods = $controller->sale_model->getAll('tbl_payment_methods', array('company_id' => $this->company_id));
														if(!empty($payment_methods)) {
															foreach ($payment_methods as $method) {
																echo '<option value="'.$method->id.'">'.$method->name.'</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_receive_payment'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input <?php echo (!isset($model['supplierId']) || $model['supplierId'] == 1) ? 'readonly="true"' : ''; ?> type="MyNumber" value="<?php echo isset($model['payment_receive']) ? $model['payment_receive'] :'0'; ?>" class="form-control paymentReceive"  placeholder="Payment Receive" name="payment_receive">
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_balance'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input  type="text" value="<?php echo (isset($model['total']) && isset($model['payment_receive'])) ? ((float)$model['total'] - (float)$model['payment_receive']) :'0'; ?>" readonly="" class="form-control balance" >
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4">
												<!-- <label class="checkbox-inline"><input type="checkbox" value="1"  name="thermal_print" onchange="valueChanged()" id="thermal_print">Thermal Print</label> -->

												<!-- <label class="checkbox-inline"><input type="checkbox" value="1"  name="print" onchange="valueChangedprint()" id="print">Print</label> -->
											</div>
											<div class="col-sm-8">
												<div class="input-right-box form-group">
												<div class="col-sm-4">
													<button type="submit" name="submit" style="width: 100%;" class="btn btn-info"><?php lang('btn_save'); ?></button>
												</div>
												<div class="col-sm-4" id="save_print">
													<input type="submit" name="print" style="width: 100%;" class="btn btn-success" value="<?php lang('btn_save_and_print'); ?>">
												</div>
												<div class="col-sm-4">
													<a href="<?php echo base_url('accounting/sales/saleInvoice') ?>" class="btn btn-primary" style="width: 100%;"><?php lang('btn_close'); ?></a>
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
<script type="text/javascript">
function valueChanged()
{
    if($('#thermal_print').is(":checked"))   
        $("#save_print").show();
    else
        $("#save_print").hide();
}

function valueChangedprint()
{
    if($('#print').is(":checked"))   
        $("#save_print").show();
    else
        $("#save_print").hide();
}

</script>