<div class="table-toolbar">
	<ul class="nav nav-tabs">
		<li class="<?php echo $this->uri->uri_string() == 'my_account/'.$role.'/dashboard' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/'.$role.'/dashboard'); ?>">
				Dashboard
			</a>
		</li>
		<li class="<?php echo $this->uri->uri_string() == 'my_account/'.$role.'/orders' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/'.$role.'/orders'); ?>">
				All Orders
			</a>
		</li>
		<?php
		if($role=="wholesale") {
			if ($this->webspace_details->slug !== 'tempoparis') { ?>
			<li class="<?php echo $this->uri->segment(4) == 'pending' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/pending'); ?>">
					Pending Orders
				</a>
			</li>
			<li class="<?php echo $this->uri->segment(4) == 'onhold' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/onhold'); ?>">
					On Hold Orders
				</a>
			</li>
			<li class="<?php echo $this->uri->segment(4) == 'completed' ? 'active' : ''; ?>">
				<a href="<?php echo site_url('my_account/'.$role.'/orders/completed'); ?>">
					Completed Orders
				</a>
			</li>
			<?php }
		} ?>
		<li class="<?php echo $this->uri->segment(3) == 'profile' ? 'active' : ''; ?>">
			<a href="<?php echo site_url('my_account/'.$role.'/profile'); ?>">
				My Info
			</a>
		</li>
	</ul>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Stats on favorite Item</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"></h1>
                <small>Under Construction</small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h4>Latest Sale Orders</h4>
            </div>
            <div class="panel panel-body">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped dashboard_datatable">
                            <thead>
                            <tr>
                                <th># </th>
                                <th>Sales order Number</th>
                                <th>Sale order Date</th>
                                <th>Product Item</th>
                                <th>Store Name</th>
                                <th>Designer</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($sale_order)){ 
                                        foreach($sale_order as $key=>$row){?>
                                   <tr>
                                       <td><?php echo $key+1; ?></td>
                                       <td>
                                           <?php echo isset($row->sales_order_number) ? $row->sales_order_number :''; ?>
                                       </td>
                                       <td>
                                           <?php
                                            $this->sales_order_date=@date('Y-m-d', $row->sales_order_date); 
                                            echo $this->sales_order_date;
                                            ?>
                                       </td>
                                       <td>
                                            <?php
                                                if(isset($row->items))
                                                {
                                                    $detail=json_decode($row->items);
                                                    if(!empty($detail))
                                                    {
                                                        foreach($detail as $key=>$item)
                                                        {
                                                            echo isset($item->prod_no) ? $item->prod_no:'';
                                                            echo ',';
                                                        }
                                                    }
                                                }
                                             ?>
                                       </td>
                                       <td>
                                           <?php echo isset($row->store_name) ? $row->store_name :''; ?>
                                       </td>
                                       <td>
                                           <?php echo isset($row->designer) ? $row->designer :''; ?>
                                       </td>
                                       <td>
                                           <?php 
                                                echo (isset($row->status) && $row->status == 4) ? 'Pending' :'';
                                            ?>
                                       </td>
                                   </tr>
                               <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h4>Latest Purchase Orders</h4>
            </div>
            <div class="panel panel-body">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped dashboard_datatable">
                            <thead>
                            <tr>
                                <th># </th>
                                <th>PO Number</th>
                                <th>PO Date</th>
                                <th>Product Items</th>
                                <th>Store Name</th>
                                <th>Designer</th>
                                <th>Vendor</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($purchase_order)){ 
                                        foreach($purchase_order as $key=>$row){?>
                                   <tr>
                                       <td><?php echo $key+1; ?></td>
                                       <td>
                                           <?php echo isset($row->po_number) ? $row->po_number :''; ?>
                                       </td>
                                       <td>
                                          <?php
                                            $this->po_date = @date('Y-m-d', $row->po_date); 
                                           echo $this->po_date;
                                          ?>
                                       </td>
                                       <td>
                                            <?php
                                                if(isset($row->items))
                                                {
                                                    $detail=(array)json_decode($row->items);
                                                    if(!empty($detail))
                                                    {
                                                        foreach($detail as $key=>$item)
                                                        {
                                                            echo $key;
                                                        }
                                                    }
                                                }
                                             ?>
                                       </td>
                                       <td>
                                           <?php echo isset($row->store_name) ? $row->store_name :''; ?>
                                       </td>
                                       <td>
                                           <?php echo isset($row->designer) ? $row->designer :''; ?>
                                       </td>
                                       <td>
                                           <?php echo isset($row->vendor_name) ? $row->vendor_name :''; ?>
                                       </td>
                                       <td>
                                           <?php 
                                                echo (isset($row->status) && $row->status == 0) ? 'Pending' :'';
                                            ?>
                                       </td>
                                   </tr>
                               <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

