<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
	<div class="row  overflow-hide">
	    <div class="col-sm-12 overflow-hide">
	        <div class="ibox overflow-hide">
	            <div class="ibox-content">
	                <h2>Sale Orders List
						<div class="clearfix"></div>
					</h2>
					<div class="clients-list listing">
	                   <div class="full-height-scroll">
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
		                                <!-- <th>Action</th> -->
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
		                                           <?php echo isset($row->sales_order_date) ? date('M d,Y',$row->sales_order_date) :''; ?>
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
		                                       <!-- <td>
		                                       		<a href="#" class="btn btn-info btn-xs">View Detail</a>
		                                       </td> -->
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
