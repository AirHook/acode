<?php $controller =& get_instance(); 
$controller->load->model('product_model');
$controller->load->model('purchase_model');
?>
<div class="wrapper   animated fadeInRight ">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					        <div class="col-sm-12 ">
					        <div class="panel panel-info">
					        	<div class="panel panel-heading">
					        	<?php if(isset($model->id)) {?> 
								<?php lang('heading_edit_product'); ?>
					        	<?php } else { ?>
								<?php lang('heading_add_new_product'); ?>
								<?php } ?>
								<a href="<?php echo  base_url('accounting/products/products')?>" class="pull-right btn btn-back"><i class="fa fa-reply">&nbsp;&nbsp;<?php lang('btn_go_back'); ?></i></a>
					        	</div>
					          	 <span>
					                  <?php $controller->showFlash(); ?>
					                </span>
					               <div class="panel panel-body">
					                <?php if(isset($model->id)) { ?>
					               	<form action="<?php echo base_url('accounting/products/addProduct') ."/". $model->id?>" method="POST" role="form">
					               <?php } else{ ?>
					               	<form action="<?php echo base_url('accounting/products/addProduct') ?>" method="POST" role="form">
					               <?php } ?>
					               <input type="hidden" name="id" value="<?php echo isset($model->id) ? $model->id :''; ?>">
								<div class="well">
								<div class="row">
									<div class="col-sm-6">
										<div class="">
										<div class="form-group">
											<label class="panelheadingfont"><?php lang('lab_name'); ?></label>
											<input type="text" required="true" name="productName" class="form-control" value="<?php echo isset($model->productName) ? $model->productName : ''; ?>">
										</div>
										<div class="form-group">
											<label class="panelheadingfont"><?php lang('product_code'); ?></label>
											<input type="text"  name="product_code" readonly="true" class="form-control" value="<?php echo isset($model->product_code) ? $model->product_code : $code; ?>">
										</div>
										<div class="form-group">
											<label class="panelheadingfont"><?php lang('reorder_level'); ?></label>
											<input type="text" placeholder="<?php lang('reorder_level'); ?>"  name="reorder_level" class="form-control" value="<?php echo isset($model->reorder_level) ? $model->reorder_level :''; ?>">
										</div>
										<div class="form-group">
											<label class="panelheadingfont"><?php lang('lab_barcode'); ?></label>
											<input type="text" maxlength="12" size="12" name="barcode" class="form-control" value="<?php echo isset($model->barcode) ? $model->barcode : $bar_code; ?>">
										</div>
										<div class="form-group">
											<label class="panelheadingfont"><?php lang('lab_minimum_stock'); ?></label>
											<input type="MyNumber" name="minimumStock" class="form-control" value="<?php echo isset($model->minimumStock) ? $model->minimumStock : ''; ?>">
										</div>
										<div class="form-group">
											<label class="panelheadingfont"><?php lang('lab_narration'); ?></label>
											<textarea class="form-control" name="narration"><?php echo isset($model->narration) ? $model->narration : ''; ?></textarea>
										</div>
										<!-- <div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="panelheadingfont">Opening Stock</label>
												    <select class="form-control" name="isopeningstock" <?php echo isset($model->isopeningstock) ? 'disabled' :''; ?> >
												    	<option  <?php echo (isset($model->isopeningstock) && $model->isopeningstock == '1') ? 'selected' : ''; ?> value="1">Yes</option>
												    	<option <?php echo (isset($model->isopeningstock) && $model->isopeningstock == '0') ? 'selected' : ''; ?> value="0">No</option>
												    </select>
												</div>
											</div>
											<div class="col-sm-8" style="margin-top: 5px;">
												<div class="form-group">
													<label></label>
												    <input type="text" name="openingstock" class="form-control" <?php echo isset($model->isopeningstock) ? 'readonly' :''; ?>  value="<?php echo isset($model->openingstock) ? $model->openingstock : ''; ?>">
												</div>
											</div>
										</div> -->
									</div>
									</div>
									<div class="col-sm-6">
										<div class="">
										<div class="row">
											<div class="col-sm-12" style="margin-top: 5px;">
												<div class="form-group">
													<label class="panelheadingfont"><?php lang('lab_product_group'); ?></label>
													
												    <select name="groupId" class="form-control  select2">
												    	<?php
												    	if(isset($product_groups) && !empty($product_groups)) {
												    		foreach ($product_groups as $key => $value) {
												    			if(isset($model->groupId) && $model->groupId == $value->id) {
													    			echo '<option selected value="'.$value->id.'">'.$value->groupName.'</option>';
													    		} else {
													    			echo '<option value="'.$value->id.'">'.$value->groupName.'</option>';
													    		}
												    		}
												    	}
												    	?>
												    </select>
												</div>
											</div>
										</div>
										<div class="row"> 
											<div class="col-sm-12">
												<label><?php lang('expiry_date') ?></label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" name="expiry_date" class="form-control datepicker" value="<?php echo date('M d Y') ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<!-- <div class="col-sm-4">
												<div class="form-group">
												     <input type="text" name="brandId" class="form-control">
												</div>
											</div> -->
											<div class="col-sm-12" style="margin-top: 5px;">
												<div class="form-group">
													<label class="panelheadingfont"><?php lang('lab_brand'); ?></label>
													<!-- <label></label> -->
												    <!-- <input type="text" name="" class="form-control"> -->
												    <select name="brandId" class="form-control">
												    	<?php
												    	if(isset($product_brands) && !empty($product_brands)) {
												    		foreach ($product_brands as $key => $value) {
												    			echo '<option value="'.$value->id.'">'.$value->brandName.'</option>';
												    		}
												    	}
												    	?>
												    </select>
												</div>
											</div>
										</div>
										<div class="row">
											<!-- <div class="col-sm-4">
												<div class="form-group">
												     <input type="text" name="sizeId" class="form-control">
												</div>
											</div> -->
											<div class="col-sm-12" style="margin-top: 5px;">
												<div class="form-group">
													<label class="panelheadingfont"><?php lang('lab_size'); ?></label>
													<!-- <label></label> -->
												    <input type="text" name="sizeId" class="form-control">
												    <!-- <select name="sizeId" class="form-control"></select> -->
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label class="panelheadingfont"><?php lang('lab_status'); ?></label>
												    <select class="form-control" name="isActive">
												    	<option <?php echo (isset($model->isActive) && $model->isActive == 1) ? 'selected' : ''; ?> value="1"><?php lang('opt_active'); ?></option>
												    	<option <?php echo (isset($model->isActive) && $model->isActive == 0) ? 'selected' : ''; ?> value="0"><?php lang('opt_inactive'); ?></option>
												    </select>
												</div>
											</div>
										</div>
										<div class="row" style="display: none;">
											<div class="col-sm-12">
												<div class="form-group">
													<label class="panelheadingfont"><?php lang('type'); ?></label>
												    <select class="form-control" name="stock_type">
												    	<option <?php echo (isset($model->stock_type) && $model->stock_type == 1) ? 'selected' : ''; ?> value="1">Multiple Units (Stock count of Base Unit)</option>
												    	<option <?php echo (isset($model->stock_type) && $model->stock_type == 2) ? 'selected' : ''; ?> value="2">Multiple Units (Separate Stock)</option>
												    	<option <?php echo (isset($model->stock_type) && $model->stock_type == 3) ? 'selected' : ''; ?> value="3">Single Unit</option>
												    </select>
												</div>
											</div>
										</div>
									</div>
								</div>
								</div>
								<br>
								<br>
								<div class="well">
										<div class="row">
											<div class="col-sm-12">
												<div class="">
												<table class="table products_list">
													<thead>
														<tr>
															<th>#</th>
															<th style="width:300px"><?php lang('lab_UOM'); ?></th>
															<th style="width: 150px;"></th>
															<th style="width:200px"><?php lang('lab_purchase_rate'); ?></th>
															<th style="width:200px"><?php lang('lab_sale_rate'); ?></th>
															<th style="width:200px"><?php lang('lab_qty_opening_stock'); ?></th>

															<th style="width: 100px;"> </th>
														</tr>
													</thead>
													<tbody>
													<?php
													$result=$controller->purchase_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
													if(!isset($pricing_list) || empty($pricing_list)) {
														$pricing_list = array();
														array_push($pricing_list, array());
													}
													if(isset($pricing_list) && !empty($pricing_list)) {
														foreach ($pricing_list as $key => $row) {
															$is_derived = (isset($model->stock_type) && $model->stock_type == 1 && $key > 0) ? true : false;
															if($is_derived && $key == 1) {
																?>
																<tr class="derived-title"><td></td><td>Select Unit</td><td>Base Unit Qty</td><td>Purchase Rate</td><td>Sale Rate</td><td></td><td></td></tr>
																<?php
															} 
															?>
															<tr>
																<td><input type="hidden" name="product[<?php echo $key; ?>][id]" value="<?php echo isset($row->id) ? $row->id : ''; ?>">
																<?php 
																if($is_derived)
																	echo '<input type="hidden" name="product['.$key.'][base_id]" value="'.$row->base_id.'" />';
																else {
																	echo $key+1; 
																	echo ($key == 0) ? ' (Default) ' : '';
																}
																?></td>
																<td>
																	<div class="form-group">
																		<select required="true" class="form-control itemIDs UOMId select2" name="product[<?php echo $key; ?>][UOMId]">
																			<option></option>
																			<?php 
																				if(!empty($result)){
																					foreach($result as $value){
																						if(isset($row->UOMId) && $row->UOMId == $value->id) {
																							?>
																							<option selected value="<?php echo isset($value->id) ? $value->id :''; ?>">
																								<?php  echo isset($value->UOMName) ? $value->UOMName :''; ?>
																							</option>
																						<?php	
																						} else {
																							?><option value="<?php echo isset($value->id) ? $value->id :''; ?>">
																								<?php  echo isset($value->UOMName) ? $value->UOMName :''; ?>
																							</option><?php
																						} 
																					}
																				} ?>
																		</select>
																		
																	</div>
																</td>
																<td>
																	<?php if($is_derived) { ?>
																	<div class="form-group"><input type="MyNumber" name="product[<?php echo $key; ?>][base_qty]" value="<?php echo $row->base_qty; ?>" class="form-control base_qty"></div>
																	<?php } else { ?>
																	<a href="#" class="btn btn-primary addUnitFromProductPage">
																		<i class="fa fa-plus"></i>
																	</a>
																	<?php } ?>
																</td>
																<td>
																	<div class="form-group">
																		<?php price_input_field(array('name' => 'product['.$key.'][purchaseRate]', 'value' => format_value(isset($row->purchaseRate) ? $row->purchaseRate : ''), 'class' => 'form-control purchaseRate', 'placeholder' => '00.00')); ?>
																	</div>
																	
																</td>
																<td>
																	<div class="form-group">
																		<?php price_input_field(array('name' => 'product['.$key.'][saleRate]', 'value' => format_value(isset($row->saleRate) ? $row->saleRate : ''), 'class' => 'form-control saleRate', 'placeholder' => '00.00')); ?>
																	</div>
																	
																</td>
																<td>
																	<?php if(!$is_derived) { ?>
																	<div class="form-group">
																		<input type="MyNumber" <?php echo (isset($row->opening_stock_qty) && $row->opening_stock_qty > 0 ) ? 'readonly' : ''; ?> name="product[<?php echo $key; ?>][opening_stock_qty]" value="<?php echo isset($row->opening_stock_qty) ? $row->opening_stock_qty : ''; ?>" class="form-control " placeholder="00.00">
																	</div>
																	<?php } ?>
																</td>
																<td style="width: 120px;">
																	<!-- addNewTrPriceList -->
																	<?php if($key > 0) {
																		?><a href="<?php echo base_url('accounting/products/deleted')."/".$row->id ?>" class="btn btn-danger  pull-right delete-confirm " style="margin-right:3px;"><i class="fa fa-trash-o"></i></a><?php
																	} else { ?>
																		<a href="#" class="btn btn-info addNewTrPriceList add_derived_unit pull-right"><span class="fa fa-plus"></span></a>
																	<?php } ?>
																</td>
															</tr>
															<?php
														} } ?>
													</tbody>
												</table>
												</div>
											</div>
										</div>
									</div>
								<br>
								<br>
								<div class="row">
			               		<div class="col-sm-4">
			                	<a href="<?php echo  base_url('accounting/products/products')?>" class="form-btn btn  btn-primary btn-default1 ">
			                		<?php lang('btn_cancel'); ?>
			                	</a>&nbsp&nbsp
			                	<input type="submit" value="<?php lang('btn_save'); ?>" name="submit" class="form-btn btn btn-shadow btn-primary "/>
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
	</div>
</div>