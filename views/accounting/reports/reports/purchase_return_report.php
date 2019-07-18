<?php
$controller =& get_instance(); 
?>
<hr style="border-color: DimGray;">
<?php if(!empty($purchaseReturnReports)){?>
<div class="row">
    <div class="col-sm-12">
        <h2><?php lang('heading_reports_detail'); ?></h2>
        <br>
        <table class="table-box">
                <thead>
                    <tr>
                        <th><?php lang('lab_invoice_no'); ?></th>
                        <th><?php lang('lab_suplier_cash'); ?></th>
                        <th><?php lang('lab_invoice_date'); ?></th>
                        <th><?php lang('lab_product_name'); ?></th>
                        <th><?php lang('lab_unit'); ?></th>
                        <th><?php lang('lab_price_per_unit'); ?></th>
                        <th><?php lang('lab_quantity'); ?></th>
                        <th><?php lang('lab_tax'); ?></th>
                        <th><?php lang('lab_amount'); ?></th>
                    </tr>
                </thead>
                   <tbody>
                   <?php foreach($purchaseReturnReports as $values) { ?>
                        <tr>
                          <td>
                            <?php echo isset($values->purchaseInvoiceId) ? $values->purchaseInvoiceId :''; ?>
                              
                          </td>
                          <td>
                       		 <?php echo isset($values->supplierName->ledgerName) ? $values->supplierName->ledgerName :''; ?>
                          </td>
                          <td><?php echo isset($values->created_on) ? date('M d Y',strtotime($values->created_on)) :''; ?></td>
                          <td>
                            <?php echo isset($values->products_name) ? $values->products_name :''; ?>
                          </td>
                          <td>
                            <?php echo isset($values->unitName->UOMName) ? $values->unitName->UOMName :''; ?>
                          </td>
                          <td>
                              <?php echo isset($values->rate) ? price_value($values->rate) :''; ?>
                          </td>
                          <td>
                            <?php echo isset($values->qty) ? $values->qty :''; ?>
                          </td>
                          <td><?php echo isset($values->tax_amount) ? price_value($values->tax_amount) :''; ?></td>
                          <td>
                            <?php echo isset($values->amount) ? price_value($values->amount) :''; ?>
                          </td>
                        </tr>
                    <?php } ?>
                   </tbody>
                   <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?php lang('lab_total'); ?></th>
                        <th>
                          <?php 
                            $totalQty=0;
                            foreach($purchaseReturnReports as $total){
                              if(isset($total->qty)){
                                $totalQty+=$total->qty;
                              }
                            }
                            echo $totalQty;
                          ?>
                        </th>
                        <th>
                        	<?php 
                            $totalTax=0;
                            foreach($purchaseReturnReports as $total_tax){
                              if(isset($total_tax->tax_amount)){
                                $totalTax+=(float)$total_tax->tax_amount;
                              }
                            }
                            echo price_value($totalTax);
                          ?>
                        </th>
                        <th>
                           <?php 
                            $totalAmount=0;
                            foreach($purchaseReturnReports as $totalamount){
                              if(isset($totalamount->amount)){
                                	$totalAmount+=(float)($totalamount->amount);
                                }
                            }
                            echo price_value($totalAmount);
                          ?>
                        </th>
                    </tr>
                </tfoot>
        </table>
    </div>
</div>
<?php } else {?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h3><?php lang('heading_no_reports_available_for_this_date'); ?></h3>
  
</div>
<?php } ?>