<?php $controller =& get_instance(); 
$controller->load->model('purchase_model');
?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
		            <div class="scroll-element full-height-scroll">
				       	<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading"><?php lang('heading_payment_register'); ?></div>
			<div class="panel-body">
				<form method="POST">
					<input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" >
							 <div class="col-sm-3">
				           		<div class="form-group">
					           	<label><?php lang('lab_cash_bank'); ?></label>
					           	 <select name="cash" class="form-control">
					           	 	<option><?php lang('opt_all'); ?></option>
					           	 	<option><?php lang('opt_all'); ?></option>
					           	 	<option><?php lang('opt_all'); ?></option>
					           	 </select>
					           </div>
				           </div>
							<div class="col-sm-3">
								<div class="form-group datepicker1">
							     <label><?php lang('lab_from_date'); ?></label>	
								   <div class="input-group date calendar">
									<input type="text" name="from_date" class="form-control" required="required">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								 </div>
				               </div> 
							</div>
							<div class="col-sm-3">
								<div class="form-group datepicker1">
							     <label><?php lang('lab_to_date'); ?></label>	
								   <div class="input-group date calendar">
									<input type="text" name="to_date" class="form-control" required="required">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								 </div>
				           </div> 
							</div>
				           <div class="col-sm-3">
				           		<div class="form-group">
					           	<label><?php lang('lab_voucher_no'); ?></label>
					           	<input type="text" name="oucher_num" class="form-control">
					           </div>
				           </div>

				           <div class="col-sm-4 pull-right text-right" >
				           		<div class="form-group" style="margin-top: 20px;">
						          	<input type="submit" name="submit" value="Search" class="btn btn-info">
						          	<input type="submit" name="submit" value="Cancel" class="btn btn-default">
						           </div>
				           </div>
				</form>

				<table class="table">
					<thead>
						<tr>
						<th><?php lang('lab_sr_no'); ?></th>
						<th><?php lang('lab_voucher_no'); ?></th>
						<th><?php lang('lab_voucher_type'); ?></th>
						<th><?php lang('lab_date'); ?></th>
						<th><?php lang('lab_cash_bank'); ?></th>
						<th><?php lang('lab_narration'); ?></th>
						<th><?php lang('lab_amount'); ?></th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td>#</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>

						</tr>
					</tbody>
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