<?php $controller =& get_instance(); 
$controller->load->model('purchase_model');
?>
<div class="wrapper animated fadeInRight">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
		            <div class="scroll-element full-height-scroll">
				        <!-- <div class="row">
				        	<div class="col-sm-12">
				        		<a href="" class="pull-right btn btn-info"><i class="fa fa-reply">Go Back</i></a>
				        	</div>
				        </div> -->
					    <div class="row">
					       <div class="col-sm-12">
					        <div class="panel panel-info">
							<div class="panel-heading"><?php lang('heading_purchase_order'); ?>
							<a href="<?php echo base_url('accounting/purchases/purchaseOrder') ?>" class="btn btn-back pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;<?php lang('btn_go_back'); ?></a>
							</div>
							  <div class="panel panel-body">
					          	 <span>
					                  <?php $controller->showFlash(); ?>
					                </span>
					                <?php if(isset($model['id'])) { ?>
					               	<form action="<?php echo base_url('accounting/purchases/editPurchaseOrder') ."/". $this->uri->segment(4)?>" method="POST" role="form">
					               <?php } else{ ?>
					               	<form action="<?php echo base_url('accounting/purchases/addPurchaseOrder') ?>" method="POST" role="form">
					               <?php } ?>
					               <input type="hidden" name="purchaseOrderNo" value="<?php echo isset($model['purchaseOrderNo']) ? $model['purchaseOrderNo'] :''; ?>">
					               <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
									<div class="row">
										<div class="col-sm-4">
											<div class="input-left form-group">
												<label ><?php lang('lab_supplier'); ?>:</label>
											</div>
											<div class="input-right form-group arrow-hide">
												<select required="" class="form-control select2 suppliername" name="supplierId">
													<option></option>
													<?php
														$result=$controller->purchase_model->getSupplier();
														if(!empty($result)){
															foreach($result as $index => $value){?>
													 	 	<option <?php echo ((isset($model['supplierId']) && $model['supplierId'] == $value->id) || $index == 0) ? 'selected' :''; ?> value="<?php echo isset($value->id) ? $value->id :''; ?>">
													 	 		<?php echo isset($value->ledgerName) ? $value->ledgerName :''; ?>
													 	 	</option>
													<?php } } ?>
												</select>
											</div>
											
										</div>
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
										    <div class="input-left-box form-group">
												<label><?php lang('lab_purchase_order_no'); ?>:</label>
											</div>
											<div class="input-right-box form-group">
											<?php if(!empty($totalPurchaseOrders)) { ?>
												<input type="text" name="purchaseOrderNo" class="form-control" readonly="" value="<?php echo isset($totalPurchaseOrders) ? sprintf("%0".$this->voucher_number_length."d", $totalPurchaseOrders) :''; ?>">
												<?php } else {?>
													<input type="text" name="purchaseOrderNo" class="form-control" readonly="" value="<?php echo isset($model['purchaseOrderNo']) ? $model['purchaseOrderNo'] :''; ?>">
												<?php } ?> 
											</div>
											<div class="input-left-box form-group">
												<label><?php lang('lab_purchase_quotation'); ?>:</label>
											</div>
											<div class="input-right-box form-group">
											<?php if(isset($model['purchase_quotation'])){ ?>
											<select  class="form-control select2 search-by-qoutation-no" name="purchase_quotation">
												<option></option>
												<?php 
													$query=array('isApproved'=>1,'status'=>1,'qoutationNo'=>$model['purchase_quotation'], 'company_id' => $company_id);
													$quotations=$controller->purchase_model->getAll('tbl_purchaseqoutationmaster',$query, array('created_on', 'DESC'));
													if(!empty($quotations)){
														foreach($quotations as $zariikhans) { ?>
														<option <?php echo (isset($model['purchase_quotation']) && $model['purchase_quotation'] == $zariikhans->qoutationNo) ? 'selected' :''; ?> value="<?php echo isset($zariikhans->qoutationNo) ? $zariikhans->qoutationNo :'';?>">
															<?php echo isset($zariikhans->qoutationNo) ? $zariikhans->qoutationNo :''; ?>
														</option>
												 <?php } } ?>
											</select>
											<?php } else { ?>
											<span class="p-q">
												<select  class="form-control select2 search-by-qoutation-no" name="purchase_quotation">
													<option></option>
													<?php 
														$query=array('isApproved'=>1,'status'=>0, 'company_id' => $company_id);
														$quotations=$controller->purchase_model->getAll('tbl_purchaseqoutationmaster',$query, array('created_on', 'DESC'));
														if(!empty($quotations)){
															foreach($quotations as $zariikhans){?>
															<option value="<?php echo isset($zariikhans->qoutationNo) ? $zariikhans->qoutationNo :'';?>">
																<?php echo isset($zariikhans->qoutationNo) ? $zariikhans->qoutationNo :''; ?>
															</option>
													 <?php } } ?>
												</select>
											</span>
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
														<input type="text" name="deliveryDate" class="form-control <?php echo ($controller->has_access_of('edit_date_purchase_orders')) ? 'datepicker' : ''; ?> deliveryDate" value="<?php echo isset($model['deliveryDate']) ? date("M d Y",strtotime($model['deliveryDate'])) :''; ?>" readonly="">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<?php }else { ?>
														<input type="text" name="deliveryDate" class="form-control <?php echo ($controller->has_access_of('edit_date_purchase_orders')) ? 'datepicker' : ''; ?> deliveryDate" value="<?php echo date("M d,Y") ?>" readonly="">
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
															<!-- <th><?php lang('lab_unit'); ?></th> -->
															<th>Vendor</th>
															<th>Color</th>
															<th>Size</th>
															<th><?php lang('lab_unit_price'); ?></th>
															<th><?php lang('lab_qty'); ?></th>
															<!-- <th><?php lang('unit_discount'); ?></th> -->
															<!-- <th><?php lang('lab_select_tax'); ?></th> -->
															<th style="text-align: center;"><?php lang('lab_total_amount'); ?></th>
															<th></th>
														</tr>
													</thead>
													<tbody>
													<?php if(isset($model['purhcaseDetail'])) { ?>
													<?php $serial_no=1;
														$length=count($model['purhcaseDetail']);
														foreach($model['purhcaseDetail'] as $key => $abidzari) {
															if(isset($abidzari->product_id))
															{
																$product_detail=$controller->purchase_model->getAll('tbl_product',array('id'=>$abidzari->product_id));
															}
														 ?>
														<tr>
															<td>
																<?php echo $serial_no++; ?>
															</td>
															<input type="hidden" name="product[<?php echo $key ?>][id]" value="<?php echo isset($abidzari->id) ? $abidzari->id :''; ?>">
															<td>
																<div class="form-group">
																	<input type="text" name="product[<?php echo $key ?>][barcode]" class="form-control barcodevalue" value="<?php echo isset($abidzari->barcode) ? $abidzari->barcode :''; ?>">
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select class="form-control selectProduct select2" name="product[<?php echo $key ?>][product_id]">
																	<option></option>
																	<?php
																		$products=$controller->purchase_model->getAll('tbl_product',array('isActive' => 1, 'company_id' => $company_id));
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
																	<select class="form-control select2 vendor_code" name="product[<?php echo $key ?>][vendor_code]">
																		<!-- <option>-select-</option> -->
																		<?php if(!empty($product_detail)){
																		           foreach($product_detail as $key=>$single){ ?>
																		           	<option value="<?php echo isset($single->vendor_code) ? $single->vendor_code :''; ?>">
																		           		<?php echo isset($single->vendor_code) ? $single->vendor_code :''; ?>
																		           	</option>
																		<?php } } ?>
																	</select>
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select class="form-control select2 color_code" name="product[<?php echo $key ?>][color_code]">
																		<?php if(!empty($product_detail)){
																		           foreach($product_detail as $key=>$single){ ?>
																		           	<option value="<?php echo isset($single->color_code) ? $single->color_code :''; ?>">
																		           		<?php echo isset($single->color_code) ? $single->color_code :''; ?>
																		           	</option>
																		<?php } } ?>
																	</select>
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select class="form-control select2 size" name="product[<?php echo $key ?>][size]">
																		<?php if(!empty($product_detail)){
																		           foreach($product_detail as $key=>$single){ ?>
																		           	<option value="<?php echo isset($single->size) ? $single->size :''; ?>">
																		           		<?php echo isset($single->size) ? $single->size :''; ?>
																		           	</option>
																		<?php } } ?>
																	</select>
																</div>
															</td>
															<!-- <td>
															<div class="form-group">
															<select class="form-control UOMId getByUnit select2" name="product[<?php echo $key ?>][UOMId]">
																		<option></option>
																		<?php 
																			$result=$controller->purchase_model->getAll('tbl_uom', "id IN (SELECT UOMId FROM tbl_purchasepricelist WHERE company_id = $company_id AND productName = $abidzari->product_id) AND company_id = $company_id");
																			if(!empty($result)){
																				foreach($result as $value){?>
																				<option <?php echo (isset($abidzari->UOMId) && $abidzari->UOMId==$value->id) ? 'selected':''; ?> value="<?php echo isset($value->id) ? $value->id :''; ?>">
																					<?php  echo isset($value->UOMName) ? $value->UOMName :''; ?>
																				</option>
																		<?php	} }?>
																	</select>
																</div>
																<input type="hidden" name="" class="uom-id" value="<?php echo isset($abidzari->UOMId) ? $abidzari->UOMId :''; ?>">
															</td> -->
															<td style="padding-top: 8px;">
																<input type="MyNumber" name="product[<?php echo $key ?>][rate]" class="purchaseRate form-control unitprice" value="<?php echo isset($abidzari->rate) ? $abidzari->rate :''; ?>">
																
															</td>
															<td>
																<div class="form-group">
																	<input type="MyNumber" name="product[<?php echo $key ?>][qty]" value="<?php echo isset($abidzari->qty) ? $abidzari->qty :''; ?>" class="form-control qty">
																</div>
																
															</td>
															<!-- <td style="padding-top:8px !important">
																<input type="MyNumber"  name="product[<?php echo $key ?>][unit_discount]" class="form-control unit_discount" value="<?php echo isset($abidzari->unit_discount) ? $abidzari->unit_discount :''; ?>" placeholder="0.00">
															</td> -->
															<!-- <td style="padding-top: 8px;">
															<?php
																$taxName=$controller->purchase_model->getAppliedTaxes($abidzari->product_id);
															
															 ?>
																<select name="product[<?php echo $key ?>][tax_id]" class="form-control appliedTaxes">
																	<option><?php lang('lab_select'); ?></option>
																	<?php 
																	$tax_value = 0;
																	$tax_symbal = '';
																	if(!empty($product_taxes)){ 
																			foreach($product_taxes as $zarizartab){
																				if((isset($abidzari->tax_id) && $abidzari->tax_id == $zarizartab->id) || $index == 0) {
																				$tax_value = $zarizartab->tax_value;
																				$tax_symbal = $zarizartab->tax_symbal;
																			}
																			?>
																			<option <?php echo (isset($abidzari->tax_id) && $abidzari->tax_id == $zarizartab->id) ? 'selected' :''; ?> value="<?php echo isset($zarizartab->id) ? $zarizartab->id :''; ?>">
																				<?php echo isset($zarizartab->ledgerName) ? $zarizartab->ledgerName :''; ?>(<?php echo isset($zarizartab->tax_value) ? $zarizartab->tax_value :'';
																					echo '&nbsp;';
																					echo isset($zarizartab->tax_symbal) ? $zarizartab->tax_symbal :'';
																				 ?>)
																			</option>
																	<?php } } ?>
																</select>
																<input type="hidden" name="" class="totaTaxValue" value="<?php echo $tax_value; ?>">
																<input type="hidden" name="" class="taxSymbal" value="<?php echo $tax_symbal; ?>">
																
															</td> -->
															<td style="text-align: center;">
																<input type="hidden" name="product[<?php echo $key ?>][amount]" class="amount" value="<?php  echo isset($abidzari->amount) ? $abidzari->amount :'';?>">
																<span class="amounthtml"><?php echo isset($abidzari->amount) ? $abidzari->amount :''; ?></span>
															</td>
															<td>
																<a href="#" class="btn btn-info addNewTr pull-right" style="display: <?php echo ($serial_no==$length) ? 'none' :''; ?>"><span class="fa fa-plus"></span></a>
																<a href="#" data-id="<?php echo isset($abidzari->id) ? $abidzari->id :''; ?>" data-table="tbl_purchaseorderdetails" data-amount="<?php echo isset($abidzari->amount) ? $abidzari->amount :''; ?>" class="btn btn-danger deleteFromDatabase  pull-right" style="margin-right:3px;"><i class="fa fa-trash-o"></i></a>
															</td>
														</tr>
														<?php } ?>
													<?php }else { ?>
														<tr>
															<td>1</td>
															<td>
																<div class="form-group">
																	<input type="text" name="product[0][barcode]" class="form-control barcodevalue" value="">
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select class="form-control selectProduct select2" name="product[0][product_id]">
																	<option></option>
																	<?php
																		$products=$controller->purchase_model->getAll('tbl_product', array('isActive' => 1, 'company_id' => $company_id));
																		if(!empty($products)){
																		foreach($products  as $value){
																	 ?>
																		<option value="<?php echo isset($value->id) ? $value->id :''; ?>">
																			<?php echo isset($value->productName) ? $value->productName :''; ?>
																		</option>
																	<?php } } ?>
																	</select>
																</div>
																<input type="hidden" name="product[0][productName]" class="productName" value="">
																
																<input type="hidden" name="" class="product-id" value="">
															</td>
															<td>
																<div class="form-group">
																	<select class="form-control select2 vendor_code" required="" name="product[0][vendor_code]">
																		<option>-select-</option>
																	</select>
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select class="form-control select2 color_code" required="" name="product[0][color_code]">
																		<option>-select-</option>
																	</select>
																</div>
															</td>
															<td>
																<div class="form-group">
																	<select class="form-control select2 size" name="product[0][size]">
																		<option>-select-</option>
																	</select>
																</div>
															</td>
															<!-- <td>
																<div class="form-group">
																	<select class="form-control UOMId getByUnit select2" name="product[0][UOMId]">
																		<option></option>
																		<?php 
																		$result = array();
																			if(!empty($result)){
																				foreach($result as $value){?>
																				<option value="<?php echo isset($value->id) ? $value->id :''; ?>">
																					<?php  echo isset($value->UOMName) ? $value->UOMName :''; ?>
																				</option>
																		<?php	} }?>
																	</select>
																	<input type="hidden" name="" class="uom-id" value="">
																</div>
															</td> -->
															<td style="padding-top:8px !important">
																<input type="MyNumber" name="product[0][rate]" class="purchaseRate form-control unitprice" value="00.000">
																
															</td>
															<td>
																<div class="form-group">
																	<input type="MyNumber" name="product[0][qty]" value="1" class="form-control qty">
																</div>
																
															</td>
															<!-- <td style="padding-top:8px !important">
																<input type="MyNumber"  name="product[0][unit_discount]" class="form-control unit_discount" value="" placeholder="0.00">
															</td> -->
															<!-- <td style="padding-top: 8px;">
																<select name="product[0][tax_id]" class="form-control appliedTaxes">
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
																<input type="hidden" name="" class="totaTaxValue" value="">
																<input type="hidden" name="" class="taxSymbal" value="">
																
															</td> -->
															
															<td style="text-align: center;">
																<input type="hidden" name="product[0][amount]" class="amount" value="">
																<span class="amounthtml">00.000</span>
															</td>
															<td>
																<a href="#" class="btn btn-info addNewTr pull-right"><span class="fa fa-plus"></span></a>
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
													<textarea name="narration" rows="4" class="form-control remarks"><?php echo isset($model['purchaseOrderNarration']) ? $model['purchaseOrderNarration'] :'';?></textarea>
												</div>		
												<!-- <div class="input-left form-group" style="margin-left: 129px;margin-top: 17px;">
													
													<input type="checkbox" name="isApproved" <?php echo (isset($model['purchaseOrderisApproved']) && $model['purchaseOrderisApproved'] == 1) ? 'checked' :''; ?> value="1" class="form-control i-checks">
													&nbsp;&nbsp;&nbsp;&nbsp;
													<label style="margin-top: -28px;margin-left: 25px;">Is Approved</label>
												</div> -->
												
											</div>
											<div class="col-sm-4">
											</div>
											<div class="col-sm-4">
												
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
												<select class="form-control select2 tax" name="tax"> 
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
												<input type="hidden" name="" class="taxForValuesForBill" value="<?php echo $tax_value; ?>">
												<input type="hidden" name="" class="taxSymbalForBill" value="<?php echo $tax_symbal; ?>">
													<!-- input required="" type="text" value="<?php echo isset($model['tax']) ? $model['tax'] :'0'; ?>" class="form-control tax" name="tax"> -->
												</div>
												
												<div class="input-left-box form-group">
													<label><?php lang('lab_total_before_discount'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input  type="text" value="" class="form-control total_before_discount"  readonly="true">
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_freight'); ?></label>
												</div>
												<div class="input-right-box form-group">
													
														<input required="" type="MyNumber" value="<?php echo isset($model['freight']) ? $model['freight'] :'0'; ?>" class="form-control freight" name="freight">
													
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_discount'); ?></label>
												</div>
												<div class="input-right-box form-group">
													<select name="discount_type" class="form-control selectDiscountMethod">
														<option  value=""><?php lang('lab_select'); ?></option>
														<option <?php echo ((isset($model['discount_type']) && $model['discount_type'] == '%') || !isset($model['discount_type'])) ? 'selected' :''; ?> value="%"><?php lang('opt_in_percentge'); ?>(%)</option>
														<option <?php echo (isset($model['discount_type']) && $model['discount_type'] == 'amount') ? 'selected' :''; ?> value="amount"><?php lang('opt_in_amount'); ?></option>
													</select>
													<!-- <input required="" type="number" value="<?php echo isset($model['discount']) ? $model['discount'] :'0'; ?>" class="form-control discount" name="discount"> -->
												</div>
												<?php if(isset($model['discount']) || true){?>
												<div class="discountAmount">
												<?php }else { ?>
												<div class="discountAmount" style="display: none;">
												<?php } ?>
												  <div class="input-right-box form-group">
													<input required="" type="MyNumber" value="<?php echo isset($model['discount']) ? $model['discount'] :'0'; ?>" class="form-control discount" name="discount">
													</div>
												</div>
												<div class="input-left-box form-group">
													<label><?php lang('lab_total'); ?></label> 
												</div>
												<div class="input-right-box form-group">
													<input required="" type="MyNumber" value="<?php echo isset($model['total']) ? $model['total'] :'0'; ?>" readonly="" class="form-control total"  placeholder="Total" name="total">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-4"></div>
											<div class="col-sm-8">
												<div class="input-right-box form-group invoice_footer_btns" >
												<div class="col-sm-4">
														<button type="submit" name="submit" style="width: 100%;" class="btn btn-info"><?php lang('btn_save'); ?></button>
												</div>
												<div class="col-sm-4">
													<input type="submit" name="save_print" style="width: 100%;" class="btn btn-info" value="<?php lang('btn_save_and_print'); ?>">
													
												</div>
												<div class="col-sm-4">
													<a href="<?php echo base_url('accounting/purchases/purchaseOrder') ?>" class="btn btn-primary" style="width: 100%;"><?php lang('btn_close'); ?></a>
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