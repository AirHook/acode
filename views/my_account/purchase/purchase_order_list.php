<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
	<div class="row  overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
	                <h2>Purchase Orders List
						<div class="clearfix"></div>
					</h2>
					<div class="clients-list listing">
	                   <div class="full-height-scroll">
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
		                                <th>Action</th>
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
		                                           <?php echo isset($row->po_date) ? date('M d,Y',$row->po_date) :''; ?>
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
		                                       <td>
		                                       		<a href="<?php echo base_url('my_account/purchase/detail/').$row->po_id ?>" class="btn btn-info btn-xs">View Detail</a>
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
	</div>
</div>
