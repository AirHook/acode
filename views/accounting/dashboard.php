<?php $controller =& get_instance(); 
$controller->load->model('sale_model');
?>
<div class="row">
    <div class="col-lg-12">
        <div data-toggle="buttons" class="btn-group pull-right view-dash-btns">
            <label class="btn btn-sm btn-white active"> <input type="radio" data-id="day" name="options"><?php  lang('lab_day'); ?>  </label>
            <label class="btn btn-sm btn-white "> <input type="radio" data-id="week" name="options"> <?php lang('lab_week'); ?>  </label>
            <label class="btn btn-sm btn-white"> <input type="radio" data-id="month" name="options"> <?php lang('lab_month'); ?> </label>
            <label class="btn btn-sm btn-white"> <input type="radio" data-id="year" name="options"> <?php lang('lab_year'); ?> </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right current-tab"><?php lang('lab_today'); ?></span>
                <h5><?php lang('lab_Sales'); ?></h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins total-sales"></h1>
                <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> -->
                <small><?php lang('lab_total_sales'); ?></small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right current-tab"><?php lang('lab_today'); ?></span>
                <h5><?php lang('lab_purchases'); ?></h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins total-purchases"></h1>
                <!-- <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> -->
                <small><?php lang('lab_total_purchases'); ?></small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right current-tab"><?php lang('lab_today'); ?>Today</span>
                <h5><?php lang('lab_expenses'); ?></h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins total-expenses"></h1>
                <!-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> -->
                <small><?php lang('lab_total_expenses'); ?></small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <!-- <span class="label label-danger pull-right">Today </span> -->
                <h5><?php lang('lab_stock_value'); ?></h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins stock-value"></h1>
                <!-- <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div> -->
                <small><?php lang('lab_total_stock_value'); ?></small>
            </div>
        </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                    <div >
                        <div data-toggle="buttons" class="btn-group pull-right view-btns">
		                    <label class="btn btn-sm btn-white"> <input type="radio" data-id="day" name="options"><?php lang('lab_day'); ?></label>
		                    <label class="btn btn-sm btn-white "> <input type="radio" data-id="week" name="options"><?php lang('lab_week'); ?></label>
		                    <label class="btn btn-sm btn-white"> <input type="radio" data-id="month" name="options"><?php lang('lab_month'); ?></label>
		                    <label class="btn btn-sm btn-white active"> <input type="radio" data-id="year" name="options"><?php lang('lab_year'); ?> </label>
		                </div>
                    </div>

                <div>
                    <canvas id="lineChart" height="171" style="display: block; width: 733px; height: 171px;" width="733"></canvas>
                </div>

                <!-- <div class="m-t-md">
                    <small class="pull-right">
                        <i class="fa fa-clock-o"> </i>
                        Update on 16.07.2015
                    </small>
                   <small>
                       <strong>Analysis of sales:</strong> The value has been changed over time, and last month reached a level over $50,000.
                   </small>
                </div> -->

            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-lg-12">
    <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php lang('lab_recent_invoices'); ?></h5>
      <!--   <div class="ibox-tools">
            <div data-toggle="buttons" class="btn-group" style="margin-top: -7px;">
                <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Day </label>
                <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> Week </label>
                <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label>
            </div>
        </div> -->
    </div>
    <div class="ibox-content">
       <!--  <div class="row">
            <div class="col-sm-9 m-b-xs">
            </div>
            <div class="col-sm-3">
                <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
            </div>
        </div> -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><?php lang('lab_invoices'); ?> </th>
                    <th><?php lang('lab_date'); ?></th>
                    <th><?php lang('lab_customer_name'); ?></th>
                    <th><?php lang('lab_phone'); ?></th>
                    <th><?php lang('lab_freight'); ?></th>
                    <th><?php lang('lab_discount'); ?> </th>
                    <th><?php lang('lab_today'); ?></th>
                    <th><?php lang('lab_tax_value'); ?></th>
                    <th><?php lang('lab_total'); ?></th>
                </tr>
                </thead>
                <tbody>
                	<?php
                	if(isset($sale_invoices) && !empty($sale_invoices) ) {
                		foreach ($sale_invoices as $invoice) {
                			if(isset($invoice->customerId)){
								$customer=$controller->sale_model->getById('tbl_accountledger',$invoice->customerId);
							}
                			?>
                			<tr>
                				<td><a href="<?php echo base_url('accounting/sales/printInvoice/'.$invoice->salesInvoiceNo); ?>"><?php echo $invoice->salesInvoiceNo; ?></a></td>
                				<td><?php echo date('M d Y', strtotime($invoice->created_on)); ?></td>
                				<td><?php echo isset($customer->ledgerName) ? $customer->ledgerName : ''; ?></td>
                				<td><?php echo isset($customer->phone) ? $customer->phone : ''; ?></td>
                				<td><?php echo price_value($invoice->subtotal); ?></td>
                				<td><?php echo price_value($invoice->discount); ?></td>
                				<td><?php echo price_value($invoice->freight); ?></td>
                				<td><?php echo price_value($invoice->tax_amount); ?></td>
                				<td><?php echo price_value($invoice->total); ?></td>
                			</tr>
                			<?php
                		}
                	} else {
                		?>
                		<tr>
                			<td class="text-center" colspan="9"><?php lang('lab_no_found'); ?></td>
                		</tr>
                		<?php
                	}
                	?>
                </tbody>
            </table>
        </div>

    </div>
    </div>
    </div>

    </div>
    <div class="row">

    <div class="col-lg-6">
    <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Products Less than Re order Level</h5>
      <!--   <div class="ibox-tools">
            <div data-toggle="buttons" class="btn-group" style="margin-top: -7px;">
                <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Day </label>
                <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> Week </label>
                <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label>
            </div>
        </div> -->
    </div>
    <div class="ibox-content">
       <!--  <div class="row">
            <div class="col-sm-9 m-b-xs">
            </div>
            <div class="col-sm-3">
                <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
            </div>
        </div> -->
        <div class="table-responsive">
            <table class="table table-striped dashboard_datatable">
                <thead>
                <tr>
                    <th><?php lang('lab_sr_no'); ?></th>
                    <th><?php lang('product_code'); ?></th>
                    <th><?php lang('lab_item_name'); ?></th>
                    <th><?php lang('lab_re_order_level'); ?></th>
                    <th><?php lang('available_stock'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($products)){
                          foreach($products as $key=>$value){ ?>
                       <tr>
                           <td><?php echo sprintf('%04d',$key+1); ?></td>
                           <td><?php echo isset($value->product_code) ? $value->product_code :'';?></td>
                           <td><?php echo isset($value->productName) ? $value->productName :'';?></td>
                           <td><?php echo isset($value->reorder_level) ? $value->reorder_level :'';?></td>
                           <td><?php echo isset($value->stock_qty) ? $value->stock_qty :'';?></td>
                       </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>

    </div>
    </div>
    </div>

    <div class="col-lg-6">
    <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Products Less Than Minimum Stock Level</h5>
      <!--   <div class="ibox-tools">
            <div data-toggle="buttons" class="btn-group" style="margin-top: -7px;">
                <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Day </label>
                <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> Week </label>
                <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label>
            </div>
        </div> -->
    </div>
    <div class="ibox-content">
       <!--  <div class="row">
            <div class="col-sm-9 m-b-xs">
            </div>
            <div class="col-sm-3">
                <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
            </div>
        </div> -->
        <div class="table-responsive">
            <table class="table table-striped dashboard_datatable">
                <thead>
                <tr>
                    <th><?php lang('lab_sr_no'); ?></th>
                    <th><?php lang('product_code'); ?></th>
                    <th><?php lang('lab_item_name'); ?></th>
                    <th><?php lang('stock_level'); ?></th>
                    <th><?php lang('available_stock'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($stock)){
                          foreach($stock as $key=>$value){ ?>
                       <tr>
                           <td><?php echo sprintf('%04d',$key+1); ?></td>
                           <td><?php echo isset($value->product_code) ? $value->product_code :'';?></td>
                           <td><?php echo isset($value->productName) ? $value->productName :'';?></td>
                           <td><?php echo isset($value->minimumStock) ? number_format($value->minimumStock,0) :'';?></td>
                           <td><?php echo isset($value->stock_qty) ? $value->stock_qty :'';?></td>
                       </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
</div>