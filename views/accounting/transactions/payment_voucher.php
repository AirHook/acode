<?php $controller =& get_instance(); 
$controller->load->model('transaction_model');?>
<style type="text/css">
	.full-width{
		width:100% !important;
	}
</style>
<div class="wrapper animated fadeInRight">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					       <div class="col-sm-12">
					        <div class="panel panel-info">
							<div class="panel-heading"> 
								<?php lang('heading_payment_voucher'); ?>
							</div>
							  <div class="panel panel-body">
					          	 <span>
					                  <?php $controller->showFlash(); ?>
					                </span>
					                <?php if(isset($model['id'])) { ?>
					               	<form action="<?php echo base_url('accounting/Transactions/paymentVoucher') ."/". $model['id']?>" method="POST" role="form">
					               <?php } else{ ?>
					               	<form action="<?php echo base_url('accounting/Transactions/paymentVoucher') ?>" method="POST" role="form">
					               <?php } ?>
					               <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
										<div class="row">
											<div class="col-sm-4">
												<div class="input-left form-group">
													<label><?php lang('lab_cash_bank'); ?></label>
												</div>
												<div class="input-right form-group">
													<select required="" class="form-control select2 " name="main_ledger_id">
														<option></option>
													<?php 
														$cashBank=$controller->transaction_model->getCashAndBackAccountLedgers();
														if(!empty($cashBank)){
															foreach($cashBank as $bankAccountCash){?>
															<option <?php echo (isset($bankAccountCash->id) && $bankAccountCash->id == 1) ? 'selected' :''; ?> value="<?php echo isset($bankAccountCash->id) ? $bankAccountCash->id :''; ?>">
																<?php echo isset($bankAccountCash->ledgerName) ? $bankAccountCash->ledgerName :''; ?>
															</option>
															<?php } } ?>
													</select>
												</div>
												<!-- <div class="input-left form-group">
													<label>Currency</label>
												</div>
												<div class="input-right form-group">
												<select name="currency" class="form-control select2">
														
														<?php
														$query=array('company_id'=>$this->session->userdata('company_id'));
														$currency=$controller->transaction_model->getAll('tbl_currency',$query);
														if(!empty($currency)){
															foreach($currency as $value){?>
															<option value="<?php echo isset($value->id) ? $value->id :''; ?>">
																<?php echo isset($value->currency_code) ? $value->currency_code :''; ?>
															</option>
														<?php } } ?>
													</select>
												</div> -->
											</div>
													<div class="col-sm-4"></div>
													<div class="col-sm-4">
														<div class="input-left-box form-group">
															 <div class="form-group ">
														        <label><?php lang('lab_date'); ?>:</label>	
															</div>	
														</div>
														<div class="input-right-box form-group">
															<div class="form-group ">
																<div class="input-group calendar">
																	
																	<input required="" readonly="" type="text" name="date" class="form-control <?php echo ($controller->has_access_of('edit_date_payment_voucher')) ? 'datepicker' : ''; ?>" value="<?php echo date('M d,Y'); ?>">
																	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																	
																</div>
															</div>
														</div>
														<div style="margin-left: 38px" class="input-left form-group">
																<label><?php lang('lab_voucher_no'); ?>:</label>
															</div>
															<div style="width:239px" class="input-right form-group">
																<input required="" type="text" readonly="" name="voucherNo" class="form-control" value="PV-<?php echo isset($next_type) ? sprintf('%05d', $next_type) : '00001'; ?>">
															</div>
													</div>
												</div>
												<br>
												<div class="well well-padding">
													<div class="row">
														<div class="col-sm-12">
															<div class="">
															<table class="table payment_table voucher_details">
																<thead>
																	<tr>
																		<th><?php lang('lab_sr_no'); ?></th>
																		<th><?php lang('lab_account_ledger'); ?></th>
																		<th ><?php lang('lab_amount'); ?></th>
																		<th ><?php lang('lab_check_no'); ?></th>
																		<th ><?php lang('lab_check_date'); ?></th>
																		<th ><?php lang('lab_action'); ?></th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>1</td>
																		<td>
																			<select required="" name="payment[0][ledgerId]" class="form-control select2 accountLedgerNo">
																				<option></option>
																			<?php
																				$accounLedger=$controller->transaction_model->getAll('tbl_accountledger', 'company_id IS NULL OR company_id = '.$this->company_id);
																				if(!empty($accounLedger)){
																					foreach($accounLedger as $value){?>
																					<option value="<?php echo isset($value->id) ? $value->id :''; ?>">
																						<?php echo isset($value->ledgerName) ? $value->ledgerName :''; ?>
																					</option>
																				<?php } } ?>
																			</select>
																		</td>
																		<td>
																			<?php
																				price_input_field(array('name' => 'payment[0][amount]', 'value' =>'', 'class'=>'form-control amount', 'placeholder' => '00.00'),'full-width');
																			 ?>
																			<!-- <input required="" type="MyNumber" name="payment[0][amount]" class="form-control amount"> -->
																		</td>
																		<td>
																			<input type="text" name="payment[0][chequeNo]" class="form-control">
																		</td>
																		<td>
																			<div class="form-group ">
																			<div class="input-group calendar">
																					
																					<input readonly="" type="text" name="payment[0][chequeDate]" class="form-control datecheckno <?php echo ($controller->has_access_of('edit_date_payment_voucher')) ? 'datepicker' : ''; ?>" value="<?php echo date('M d,Y'); ?>">
																					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																					
																				</div>
																			</div>
																		</td>
																		<td>
																			
																			<a href="#" style="margin-left:35px;" class="btn btn-info addRowForPayment"><i class="fa fa-plus"></i></a>
																		</td>
																	</tr>
																</tbody>
															</table>
															</div>
														</div>
													</div>
												</div>
												
												<div class="input-right-box form-group">
													<div class="col-sm-3 pull-right">
														<button type="submit" name="submit" style="width: 100%;" class="btn btn-info"><?php lang('btn_save'); ?></button>
													</div>
													<div class="col-sm-3 pull-right">
														<button type="submit" name="save_print" style="width: 100%;" class="btn btn-info">Save & Print</button>
													</div>
													<div class="col-sm-3 pull-right">
															<a href="<?php echo base_url('accounting/Transactions/paymentVoucher') ?>" class="btn btn-primary" style="width: 100%;"><?php lang('btn_close'); ?></a>
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