<?php $controller =& get_instance(); ?>
<div class="wrapper animated fadeInRight">
     <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
		            <div class="scroll-element full-height-scroll">
					    <div class="row">
					        <div class="col-sm-12 ">
						        <div class="row">
						        	<div class="col-sm-12">
						        		<span>
					                       <?php $controller->showFlash(); ?>
					                     </span>
						        		<div class="panel panel-info">
							        	<div class="panel panel-heading">
						        			<?php if(isset($model['id'])) {?>
											<?php lang('heading_supplier_detail'); ?>
								        	<?php } else { ?>
								        	<?php lang('heading_supplier_detail'); ?>
											
											<?php } ?>
									<a href="<?php echo base_url('accounting/suppliers/index') ?>" class="btn btn-back pull-right"><i class="fa fa-reply"></i>&nbsp;&nbsp;<?php lang('btn_go_back'); ?></a>
							        	</div>
							        	<?php if(isset($model['id'])) { ?>
						               	<form action="<?php echo base_url('accounting/suppliers/add') ."/". $this->uri->segment(4) ?>" method="POST" role="form">
						                     <input type="hidden" name="id" value="<?php echo isset($model['id']) ?  $model['id'] :''; ?>">
						               <?php } else { ?>
						               	<form action="<?php echo base_url('accounting/suppliers/add') ?>" method="POST" role="form">
						               <?php } ?>
							        	<div class="panel panel-body">
							        		<div class="">
							        		<div class="row">
							        			<div class="col-sm-6">
									        		<div class="">
									        			<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_supplier_name'); ?></label>
										               		 		<input required="" type="text" name="supplierName" value="<?php echo isset($model['supplierName']) ? $model['supplierName'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_supplier_code'); ?></label>
										               		 		<input readonly="true" type="text"  value="<?php echo isset($model['supplierCode']) ? $model['supplierCode'] : $customer_code; ?>" class="form-control">
										               		 		<input type="hidden" name="supplierCode" value="<?php echo isset($model['supplierCode']) ? $model['supplierCode'] : $customer_code; ?>" >
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_mailing_name'); ?></label>
										               				<input type="text" name="mailingName" value="<?php echo isset($model['mailingName']) ? $model['mailingName'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_pho_number'); ?></label>
										               				<input  type="MyNumber" name="phone" value="<?php echo isset($model['phone']) ? $model['phone'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_mob_number'); ?></label>
										               				<input type="MyNumber" name="mobile" value="<?php echo isset($model['mobile']) ? $model['mobile'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_email'); ?></label>
										               				<input type="email" name="email" value="<?php echo isset($model['email']) ? $model['email'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_narration'); ?></label>
										               				<input type="text" name="narration" value="<?php echo isset($model['narration']) ? $model['narration'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_CST_No'); ?></label>
										               		 		<input type="MyNumber" name="cst" value="<?php echo isset($model['cst']) ? $model['cst'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_opening_balance'); ?></label>
										               				<input <?php echo isset($model['opening_balance']) ? 'readonly' :''; ?> type="MyNumber" name="opening_balance" value="<?php echo isset($model['opening_balance']) ? $model['opening_balance'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
									        					<div class="form-group">
									        						<label><?php lang('lab_debit_credit'); ?></label>
									        						<select  <?php echo (isset($model['crOrDr']) && $model['crOrDr'] != '') ? 'readonly ' :''; ?> class="form-control" name="crOrDr">
									        							<option  value=""><?php lang('opt_select_from_list'); ?></option>
									        							<option <?php echo (isset($model['crOrDr'])  && $model['crOrDr'] == 'Credit') ? 'disabled ' :''; ?> <?php echo (isset($model['crOrDr']) && $model['crOrDr'] == 'Credit') ? 'selected' : '';  ?> value="Credit"><?php lang('opt_credit'); ?></option>
									        							<option <?php echo (isset($model['crOrDr'])  && $model['crOrDr'] == 'Debit') ? 'disabled ' :''; ?><?php echo (isset($model['crOrDr']) && $model['crOrDr'] == 'Debit') ? 'selected' : '';  ?> value="Debit"><?php lang('opt_debit'); ?></option>
									        						</select>
									        					</div>
									        				</div>
										               	</div>
									        		</div>
							        		    </div>
							        		    <div class="col-sm-6">
									        		<div class="">
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_credit_period'); ?></label>
										               		 		<input type="text" name="creditPeriod" value="<?php echo isset($model['creditPeriod']) ? $model['creditPeriod'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang(''); ?>Credit Limit</label>
										               				<input type="MyNumber" name="creditLimit" value="<?php echo isset($model['creditLimit']) ? $model['creditLimit'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<!-- <div class="form-group">
										               				<label class="panelheadingfont">Pricing Level Id</label>
										               				<input type="number" name="pricinglevelId" value="<?php echo isset($model['pricinglevelId']) ? $model['pricinglevelId'] :''; ?>" class="form-control">
										               			</div> -->
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_bill_by_bill'); ?></label>
										               		 		<input type="text" name="billByBill" value="<?php echo isset($model['billByBill']) ? $model['billByBill'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_branch_name'); ?></label>
										               				<input type="text" name="branchName" value="<?php echo isset($model['branchName']) ? $model['branchName'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<!-- <div class="form-group">
										               				<label class="panelheadingfont">Branch Code</label>
										               				<input type="text" name="branchCode" value="<?php echo isset($model['branchCode']) ? $model['branchCode'] :''; ?>" class="form-control">
										               			</div> -->
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_bank_account_number'); ?> </label>
										               				<input type="MyNumber"   name="bankAccountNumber" value="<?php echo isset($model['bankAccountNumber']) ? $model['bankAccountNumber'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_TIN'); ?></label>
										               				<input type="MyNumber" name="tin" class="form-control" value="<?php echo isset($model['tin']) ? $model['tin'] :'';?>">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			
										               			<div class="form-group">
									                                <label class="panelheadingfont"><?php lang('lab_pan'); ?></label>
									                                <input type="MyNumber" name="pan" value="<?php echo isset($model['pan']) ? $model['pan'] :''; ?>" class="form-control">
									                            </div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_route_id'); ?></label>
										               		 		<input type="text" name="routeId" value="<?php echo isset($model['routeId']) ? $model['routeId'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-12">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_address'); ?></label>
										               				<textarea class="form-control" name="address"><?php echo isset($model['address']) ? $model['address'] :''; ?></textarea>
										               			</div>
										               		</div>
										               	</div>
									        		</div>
							        		    </div>
							        		    </div>
							        		    <div class="row">
							                   		<div class="col-sm-4">
								                	<input type="submit" value="<?php lang('btn_save'); ?>" name="submit" class="form-btn btn btn-shadow btn-primary "/>
								                	&nbsp;&nbsp;
								                	<a href="<?php echo base_url('accounting/suppliers/index') ?>" class="form-btn btn  btn-primary btn-default1 ">
								                		<?php lang('btn_cancel'); ?>
								                	</a>
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
	