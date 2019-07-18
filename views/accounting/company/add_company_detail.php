<?php $controller =& get_instance();
$controller->load->model('company_model') ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
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
						        			<?php if(isset($model['companyId'])) {?>
											<?php lang('heading_company_detail'); ?>
								        	<?php } else { ?>
											<?php lang('heading_company_detail'); ?>
											<?php } ?>
							        	</div>
							        	<?php if(isset($model['companyId'])) { ?>
						               	<form action="<?php echo base_url('accounting/company/addCompanyDetail') ."/". $model['companyId'] ?>" method="POST" role="form">
						                     <input type="hidden" name="companyId" value="<?php echo isset($model['companyId']) ?  $model['companyId'] :''; ?>">
						               <?php } else{ ?>
						               	<form action="<?php echo base_url('accounting/company/addCompanyDetail') ?>" method="POST" role="form">
						               <?php } ?>
							        	<div class="panel panel-body">
							        	<div class="">
							        		<div class="row">
							        			<div class="col-sm-6">
									        		<div class="">
									        			<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_company_name'); ?></label>
										               		 		<input required="" type="text" name="companyName" value="<?php echo isset($model['companyName']) ? $model['companyName'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-5">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_country_name'); ?></label>
										               				<select class="select2 form-control fromcountry" name="country">
										               					<option value=""></option>
										               					<?php
										               						if(!empty($countriesList)){
										               							foreach($countriesList as $value){?>
										               								<option <?php echo (isset($model['country']) && $model['country'] == $value->country_name) ? 'selected' :''; ?> value="<?php echo isset($value->country_name) ? $value->country_name :''; ?>">
										               									<?php echo isset($value->country_name) ? $value->country_name :''; ?>
										               								</option>
										               					 <?php } } ?>
										               				</select>
										               				
										               			</div>
										               		</div>
										               		<div class="col-sm-1" style="margin-left: -16px; margin-top: 6px;">
										               			<div class="form-group">
										               				<label></label>
										               			   <a href="#" data-abid="1" class="btn btn-primary addCountry"><i class="fa fa-plus"></i></a>
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_state'); ?></label>
										               				<input required="" type="text" name="state" value="<?php echo isset($model['state']) ? $model['state'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_mailing_name'); ?></label>
										               				<input required="" type="text" name="mailingName" value="<?php echo isset($model['mailingName']) ? $model['mailingName'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_email_id'); ?></label>
										               				<input required="" type="text" name="emailId" value="<?php echo isset($model['emailId']) ? $model['emailId'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_website'); ?></label>
										               				<input type="text" name="web" value="<?php echo isset($model['web']) ? $model['web'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_phone'); ?></label>
										               				<input required="" type="text" name="phone" value="<?php echo isset($model['phone']) ? $model['phone'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_CST_No'); ?></label>
										               		 		<input type="text" name="cst" value="<?php echo isset($model['cst']) ? $model['cst'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-12">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_address'); ?></label>
										               			<textarea required="" class="form-control" name="address"><?php echo isset($model['address']) ? $model['address'] :''; ?></textarea>
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
										               				<label class="panelheadingfont"><?php lang('lab_PIN_code'); ?></label>
										               		 		<input type="text" name="pin" value="<?php echo isset($model['pin']) ? $model['pin'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_mob_number'); ?></label>
										               				<input required="" type="text" name="mobile" value="<?php echo isset($model['mobile']) ? $model['mobile'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_TIN_no'); ?></label>
										               		 		<input type="text" name="tin" value="<?php echo isset($model['tin']) ? $model['tin'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_PAN_no'); ?></label>
										               				<input type="text" name="pan" value="<?php echo isset($model['pan']) ? $model['pan'] :''; ?>" class="form-control">
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_financial_year_from'); ?></label>
										               		 		<div class="input-group">
									                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input <?php echo isset($model['financialYearFrom']) ? 'readonly="true"' : ''; ?> required="true" type="text" class="form-control <?php echo isset($model['financialYearFrom']) ? '' : 'datepicker'; ?> " name="financialYearFrom" value="<?php echo isset($model['financialYearFrom']) ? date('M d Y', strtotime($model['financialYearFrom'])) :''; ?>">
									                                </div>
										               			</div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_financial_year_to'); ?></label>
										               		 		<div class="input-group">
									                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input <?php echo isset($model['financialYearTo']) ? 'readonly="true"' : ''; ?> required="true" type="text" class="form-control <?php echo isset($model['financialYearTo']) ? '' : 'datepicker'; ?> " name="financialYearTo" value="<?php echo isset($model['financialYearTo']) ? date('M d Y', strtotime($model['financialYearTo'])) :''; ?>">
									                                </div>
										               			</div>
										               		</div>
										               		
										               	</div>
										               	<div class="row">
										               		
										               		<div class="col-sm-6">
										               			<div class="form-group">
									                                <label class="panelheadingfont"><?php lang('lab_current_date'); ?></label>
									                                <div class="input-group">
									                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required="true" type="text" class="form-control datepicker " name="currentDate" value="<?php echo isset($model['currentDate']) ? date('M d Y', strtotime($model['currentDate'])) :''; ?>">
									                                </div>
									                            </div>
										               		</div>
										               		<div class="col-sm-6">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_books_begining_from'); ?></label>
										               				<div class="input-group">
									                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input required="true" type="text" class="form-control datepicker " name="booksBeginingFrom" value="<?php echo isset($model['booksBeginingFrom']) ? date('M d Y', strtotime($model['booksBeginingFrom'])) :''; ?>">
									                                </div>
										               			</div>
										               		</div>
										               	</div>
										               	<div class="row">
										               		<div class="col-sm-12">
										               			<div class="form-group">
										               				<label class="panelheadingfont"><?php lang('lab_descriptions'); ?></label>
										               				<textarea class="form-control" name="extra1"><?php echo isset($model['extra1']) ? $model['extra1'] :''; ?></textarea>
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
								                	<a href="" class="form-btn btn  btn-primary btn-default1 ">
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
</div>
	