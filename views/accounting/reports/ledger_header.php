<?php $controller=& get_instance() ?>
<div class="wrapper animated fadeInRight">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
               
                <div class="row">
                    <div class="col-sm-12">
                		<div class="report-head">
                			<div class="row">
                				<div class="col-sm-2">
                                     <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" />
                					<label><?php lang('lab_account_group'); ?></label>
                					<select name="account_group" class="form-control select2">
                                        <option value="all"><?php lang('lab_all_groups'); ?></option>
                						<?php
                						if(isset($account_groups) && !empty($account_groups)) {
                							foreach ($account_groups as $key => $value) {
                								if(isset($group) && $value->id == $group)
                                                    echo '<option selected value="'.$value->id.'">'.$value->accountGroupName.'</option>';
                                                else
                									echo '<option  value="'.$value->id.'">'.$value->accountGroupName.'</option>';
                							}
                						}
                						?>
                					</select>
                				</div>
                                <div class="col-sm-2">
                                    <label><?php lang('lab_account_ledger'); ?></label>
                                    <select name="account_ledger" class="form-control select2">
                                        <option value="all"><?php lang('lab_all_ledgers'); ?></option>
                                        <?php
                                        if(isset($account_ledgers) && !empty($account_ledgers)) {
                                            foreach ($account_ledgers as $key => $value) {
                                                if(isset($ledger_id) && $value->id == $ledger_id)
                                                    echo '<option selected value="'.$value->id.'">'.$value->ledgerName.'</option>';
                                                else
                                                    echo '<option  value="'.$value->id.'">'.$value->ledgerName.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                				<div class="col-sm-2">
                					<label><?php lang('lab_date_range'); ?></label>
                                    <input type="hidden" class="year_start" value="<?php echo isset($active_year->fromDate) ? date('M d Y', strtotime($active_year->fromDate)) : date('M d Y'); ?>">
                                    <input type="hidden" class="year_end" value="<?php echo isset($active_year->toDate) ? date('M d Y', strtotime($active_year->toDate)) : date('M d Y'); ?>">
                					<select name="date_range" class="form-control date-select" >
                						<option <?php echo (isset($date_range) && $date_range == -30) ? 'selected' : ''; ?> value="last30Days"><?php lang('opt_last_30_days'); ?></option>
                						<option <?php echo (isset($date_range) && $date_range == -15) ? 'selected' : ''; ?> value="last15Days"><?php lang('opt_last_15_days'); ?></option>
                						<option <?php echo (isset($date_range) && $date_range == 0) ? 'selected' : ''; ?> value="today"><?php lang('opt_today'); ?></option>
                						<option <?php echo (isset($date_range) && $date_range == '') ? 'selected' : ''; ?> value=""><?php lang('opt_specific_range'); ?></option>
                                        <option <?php echo (isset($date_range) && $date_range == 'active_year') ? 'selected' : ''; ?> value="active_year"><?php lang('opt_active_financial_year'); ?></option>
                					</select>
                				</div>
                               
                				<div <?php echo (isset($date_range) && ($date_range == '' )) ? '' : 'hidden'; ?> class="col-sm-2 date-selector " >
                					<label><?php lang('lab_start_date'); ?></label>
                					<div class="input-group ">
	                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control datepicker" name="start" value="<?php echo (isset($start)) ? date('M d Y', strtotime($start)) : ''; ?>">
	                                </div>
                				</div>
                				<div <?php echo (isset($date_range) && ($date_range == '')) ? '' : 'hidden'; ?> class="col-sm-2  date-selector" >
                					<label><?php lang('lab_end_date'); ?></label>
                					<div class="input-group ">
	                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control datepicker" name="end" value="<?php echo (isset($end)) ? date('M d Y', strtotime($end)) : ''; ?>">
	                                </div>
                				</div>
                               
                				<div  class="col-sm-2">
                					<div><label>&nbsp;</label></div>
                					<a href="#" class="btn btn-primary view-ledger_report-btn" ><?php lang('btn_view_report'); ?></a>
                				</div>
                			</div>
                		</div>
                		<hr>