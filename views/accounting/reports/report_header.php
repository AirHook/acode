<?php $controller=& get_instance(); ?>
<div class="wrapper animated fadeInRight">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
               
                <div class="row">
                    <div class="col-sm-12">
                		<div class="report-head">
                			<div class="row">
                                <input type="hidden" name="report_name" value="<?php echo $selected; ?>">
                                <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" />
                				<div class="col-sm-2" style="display: none;">
                					<label><?php lang('lab_select_report'); ?></label>
                					<select name="report_name" class="form-control ">
                						<?php
                						if(isset($reports) && !empty($reports)) {
                							foreach ($reports as $key => $value) {
                								if($value['link'] == $selected)
                									echo '<option selected value="'.$value['link'].'">'.$value['title'].'</option>';
                								else
                									echo '<option value="'.$value['link'].'">'.$value['title'].'</option>';
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
                                <?php
                                if(isset($has_product_filter) && $has_product_filter) {
                                    ?>
                                    <div class="col-sm-2">
                                        <label><?php lang('product'); ?></label>
                                        <select name="product" class="form-control product select2" >
                                            <option value="">Select Product</option>
                                            <?php
                                            if(isset($products) && !empty($products)) {
                                                foreach ($products as $key => $value) {
                                                    if(isset($product_id) && $product_id == $value->id)
                                                        echo '<option selected value="'.$value->id.'">'.$value->productName.'</option>';
                                                    else
                                                        echo '<option value="'.$value->id.'">'.$value->productName.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                                if(isset($has_unit_filter) && $has_unit_filter) {
                                    ?>
                                    <div class="col-sm-2">
                                        <label><?php lang('unit'); ?></label>
                                        <select name="unit" class="form-control unit" >
                                            <option value="">Select Unit</option>
                                            <?php
                                            if(isset($units) && !empty($units)) {
                                                foreach ($units as $key => $value) {
                                                    if(isset($unit_id) && $unit_id == $value->id)
                                                        echo '<option selected value="'.$value->id.'">'.$value->UOMName.'</option>';
                                                    else
                                                        echo '<option value="'.$value->id.'">'.$value->UOMName.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }

                                if(isset($has_cashier_filter) && $has_cashier_filter) {
                                    ?>
                                    <div class="col-sm-2">
                                    <label><?php lang('cashier'); ?></label>
                                    <select name="cashier" class="form-control" >
                                        <option value="">All</option>
                                        <?php
                                        if(isset($users) && !empty($users)) {
                                            foreach ($users as $key => $value) {
                                                if(isset($cashier) && $cashier == $value->id)
                                                    echo '<option selected value="'.$value->id.'">'.$value->first_name.' '.$value->last_name.'</option>';
                                                else
                                                    echo '<option value="'.$value->id.'">'.$value->first_name.' '.$value->last_name.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <?php
                                }
                                if(isset($has_payment_method_filter) && $has_payment_method_filter) {
                                    ?>
                                    <div class="col-sm-2">
                                    <label><?php lang('payment_method'); ?></label>
                                    <select name="payment_method" class="form-control" >
                                        <option value="">All</option>
                                        <?php
                                        if(isset($payment_methods) && !empty($payment_methods)) {
                                            foreach ($payment_methods as $key => $value) {
                                                if(isset($payment_method) && $payment_method == $value->id)
                                                    echo '<option selected value="'.$value->id.'">'.$value->name.'</option>';
                                                else
                                                    echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <?php
                                }
                                ?>
                				<div  class="col-sm-2">
                					<div><label>&nbsp;</label></div>
                					<a href="#" class="btn btn-primary view-report-btn" ><?php lang('btn_view_report'); ?></a>
                				</div>
                			</div>
                		</div>
                		<hr>