<?php $controller =& get_instance(); ?>
<div class="wrapper wrapper-content  animated fadeInRight wrapper-background-color">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content"> 
                <span class="pull-right">
				 <?php if ($controller->has_access_of('add_stock_count')) { ?>
                    <a  href="<?php echo base_url('accounting/products/createStockInvoice') ?>"  class="btn btn btn-primary "> <i class="fa fa-plus"></i> <?php lang('btn_add_new'); ?></a>
                    <?php } ?> 
                    </span>
                    <h2>
                       <?php lang('stock_count'); ?>
                    </h2>
                    <div class="clearfix"></div>
                    <div class="clients-list">
                        <div class="full-height-scroll">
                            <div class="table-responsive">
					          	 <table class="table table-striped table-hover table-hover dataTables1">
					          	 	<thead>
					          	 		<tr>
					          	 			<th><?php lang('lab_sr_no'); ?></th>
					          	 			<th><?php lang('invoice_no'); ?></th>
					          	 			<th><?php lang('created_on'); ?></th>
					          	 			<th></th>
					          	 		</tr>
					          	 	</thead>
					          	 	<tbody>
					          	 	<?php if(!empty($invoices)){
					          	 		$serial_no=1;
					          	 		foreach($invoices as $value){?>
					          	 		<tr>
					          	 			<td>
					          	 				<?php echo $serial_no++; ?>
					          	 			</td>
					          	 			<td>
					          	 				<?php echo isset($value->invoice_no) ? $value->invoice_no :''; ?>
					          	 			</td>
					          	 			<td>
					          	 				<?php echo isset($value->created_on) ? date('M d Y', strtotime($value->created_on)) :''; ?>
					          	 			</td>
					          	 			<td>
					          	 				<?php if(isset($value->is_applied) && $value->is_applied == 0): ?>
				 							<?php if ($controller->has_access_of('delete_stock_count')) { ?>
						          	 				<a href="<?php echo base_url('accounting/products/delete') ?>/<?php echo $value->id ; ?>/tbl_stock_invoices" class="fa-btn delete-confirm"><i class="fa fa-trash"></i></a>
				 							<?php } ?>
				 							<?php if ($controller->has_access_of('view_stock_count')) { ?>
						          	 				<a href="<?php echo base_url('accounting/products/viewStockInvoice') ?>/<?php echo $value->id ; ?>" class="fa-btn "><i class="fa fa-eye"></i></a>
				 							<?php } ?>
						          	 			<?php else: ?>
						          	 				<span class="label label-info">Applied to inventory</span>
						          	 			<?php endif; ?>
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
