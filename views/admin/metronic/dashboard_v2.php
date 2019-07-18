<!-- BEGIN PAGE CONTENT BODY -->
<div class="note note-default" style="padding:0px;border-left:none;">
    <h3>Dashboard</h3>
    <p> Here you can place recent activites or updates at the admin panel. This may include the following: new products, new users, new stats, etc... </p>
    <p> For more info please check out
        <a class="btn red btn-outline" href="<?php echo site_url('admin/dcn'); ?>" target="">the official documentation</a>
    </p>
</div>
<div class="row">
	<div class="col-sm-12">
		<a href="<?php echo site_url('admin/sales_orders'); ?>" class="btn btn-info btn-xs">View Sales Orders</a>
		<?php
	        // available only on hub sites for now
	        if ($this->webspace_details->options['site_type'] == 'hub_site')
        { ?>
		<a href="<?php echo site_url('admin/sales_orders/create'); ?>" class="btn btn-success btn-xs">Add Sales Orders</a>
	<?php } ?>
		<a href="<?php echo site_url('admin/campaigns/sales_package'); ?>" class="btn btn-primary btn-xs">View Sales Packages</a>
		<a href="#modal_create_sales_package" data-toggle="modal" class="btn btn-success btn-xs">Add Sales Packages</a>
		<a href="<?php echo site_url('admin/purchase_orders'); ?>" class="btn btn-info btn-xs">View Purchase Orders</a>
		<a href="<?php echo site_url($this->config->slash_item('admin_folder').'purchase_orders/create'); ?>" class="btn btn-success btn-xs">Add Purchase Orders</a>
		<a href="<?php echo site_url('admin/users/wholesale'); ?>" class="btn btn-info btn-xs">View Wholesale Users</a>
		<a href="<?php echo site_url('admin/users/wholesale/add'); ?>" class="btn btn-success btn-xs">Add Wholesale Users</a>
	</div>
</div>
<div class="row order_row">
	<div class="col-sm-6">
		<div class="panel panel-default scrollportletId">
	      	<div class="panel-heading">Sales Orders</div>
	        <div class="panel-body">
	        	<div class="row">
	        		<div class="col-sm-12">
			      	    <table class="table table-striped table-bordered table-hover table-checkable order-column">
			      	 		<thead>
			      	 			<tr>
			      	 				<th><strong>#</strong></th>
				      	 			<th><strong>SO Number</strong></th>
				      	 			<th><strong>SO Date</strong></th>
				      	 			<th><strong>Status</strong></th>
				      	 			<th><strong>Action</strong></th>
			      	 			</tr>
			      	 		</thead>
			      	 		<tbody>
			      	 			<?php if(!empty($sale_orders)){
			      	 		            foreach($sale_orders as $key=>$order){ 
			      	 		            	$edit_link =
		                                            $this->uri->segment(1) === 'sales'
		                                            ? site_url('sales/sales_orders/details/index/'.$order->sales_order_id)
		                                            : site_url($this->config->slash_item('admin_folder').'sales_orders/details/index/'.$order->sales_order_id)
			      	 		            	?>
						      	 			<tr>
						      	 				<td><?php echo $key+1 ?></td>
						      	 				<td>
						      	 					<?php echo $order->sales_order_number; ?>
						      	 				</td>
						      	 				<td>
						      	 					<?php
														$date = @date('Y-m-d', $order->sales_order_date);
														echo $date;
													?>
						      	 				</td>
						      	 				<td>
													<?php
													switch ($order->status)
													{
														case '1':
															$label = 'success';
															$text = 'Complete';
														break;
														case '2':
															$label = 'danger';
															$text = 'On Hold';
														break;
														case '3':
															$label = 'warning';
															$text = 'Return';
														break;
														case '4':
														default:
															$label = 'info';
															$text = 'Pending';
													}
													?>
					                                <span class="label label-sm label-<?php echo $label; ?>"> <?php echo $text; ?> </span>
					                            </td>
					                            <td>
					                            	<a href="<?php echo $edit_link; ?>" class=" btn btn-info btn-xs"><i class="icon-pencil"></i> View Details </a>
					                            </td>
						      	 			</tr>
			      	 				<?php } } ?>
			      	 		</tbody>
			      	    </table>
	        		</div>
	        	</div>
	        	<?php if(count($sale_orders_length) > 10){ ?>
		      		<div class="row">
		      			<div class="col-sm-12 text-center">
		      				<a href="<?php echo site_url('admin/sales_orders'); ?>" class="btn btn-success"> View More </a>
		      			</div>
		      		</div>
		      	<?php } ?>
	        </div>
	    </div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default scrollportletId">
	      	<div class="panel-heading">Purchases Orders</div>
	      	<div class="panel-body">
	      		<div class="row">
	      			<div class="col-sm-12">
			      		<table class="table table-striped table-bordered table-hover table-checkable order-column">
			      	 		<thead>
			      	 			<tr>
			      	 				<th><strong>#</strong></th>
				      	 			<th><strong>PO Number</strong></th>
				      	 			<th><strong>PO Date</strong></th>
				      	 			<th><strong>Status</strong></th>
				      	 			<th><strong>Action</strong></th>
			      	 			</tr>
			      	 		</thead>
			      	 		<tbody>
			      	 		<?php if(!empty($purchase_orders)){
			      	 		            foreach($purchase_orders as $key=>$order){ 
			      	 		            	$edit_link =
		                                            $this->uri->segment(1) === 'sales'
		                                            ? site_url('sales/purchase_orders/details/index/'.$order->po_id)
		                                            : site_url($this->config->slash_item('admin_folder').'purchase_orders/details/index/'.$order->po_id)
			      	 		            	?>
						      	 			<tr>
						      	 				<td><?php echo $key+1 ?></td>
						      	 				<td>
						      	 					<?php echo $order->des_code.$order->po_number; ?>
						      	 				</td>
						      	 				<td>
						      	 					<?php
														$date = @date('Y-m-d', $order->po_date);
														echo $date;
													?>
						      	 				</td>
						      	 				<td>
						      	 					<?php
														switch ($order->status)
														{
															case '1':
																$label = 'success';
																$text = 'Complete';
															break;
															case '2':
																$label = 'danger';
																$text = 'On Hold';
															break;
															case '0':
															default:
																$label = 'info';
																$text = 'Pending';
														}
														?>
						                            <span class="label label-sm label-<?php echo $label; ?>"> <?php echo $text; ?> </span>
						      	 				</td>
						      	 				<td>
						      	 					<a href="<?php echo $edit_link; ?>" class="btn btn-xs btn-info"><i class="icon-pencil"></i> View Details </a>
						      	 				</td>
						      	 			</tr>
			      	 				<?php } } ?>
			      	 		</tbody>
			      	    </table>
	      			</div>
	      		</div>
	      		<?php if(count($purchase_orders_length) > 10){ ?>
		      		<div class="row">
		      			<div class="col-sm-12 text-center">
		      				<a href="<?php echo site_url('admin/purchase_orders'); ?>" class="btn btn-success"> View More </a>
		      			</div>
		      		</div>
		      	<?php } ?>
	      	</div>
	    </div>
	</div>
</div>
<!-- END PAGE CONTENT BODY -->
