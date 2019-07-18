<?php
$controller =& get_instance(); 
?>
<hr style="border-color: DimGray;">
<?php if(!empty($saleReturnReports)){?>
<div class="row">
    <div class="col-sm-12">
        <h2><?php lang('heading_reports_detail'); ?></h2>
        <br>
        <table class="table-box">
                <thead>
                    <tr>
                        <th><?php lang('lab_invoice_no'); ?></th>
                        <th><?php lang('lab_customer_cash'); ?></th>
                        <th><?php lang('lab_product_name'); ?></th>
                        <th><?php lang('lab_unit'); ?></th>
                        <th><?php lang('lab_price_per_unit'); ?></th>
                        <th><?php lang('lab_quantity'); ?></th>
                        <th><?php lang('lab_amount'); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?php lang('lab_total'); ?></th>
                        <th>
                          <?php 
                            $totalQty=0;
                            foreach($saleReturnReports as $total) {
                              if(isset($total->qty)){
                                $totalQty+=$total->qty;
                              }
                            }
                            echo $totalQty;
                          ?>
                        </th>
                        <th>
                           <?php 
                            $totalAmount=0;
                            foreach($saleReturnReports as $totalamount) {
                              if(isset($totalamount->amount)){
                                $totalAmount+=$totalamount->amount;
                              }
                            }
                            echo $totalAmount;
                          ?>
                        </th>
                    </tr>
                </tfoot>
                   <tbody>
                   <?php foreach($saleReturnReports as $values) { ?>
                        <tr>
                          <td>
                            <?php echo isset($values->salesInvoiceNo) ? $values->salesInvoiceNo :''; ?>
                              
                          </td>
                          <td>
                        <?php echo isset($values->customerName->ledgerName) ? $values->customerName->ledgerName :''; ?>
                          </td>
                          <td>
                            <?php echo isset($values->productName) ? $values->productName :''; ?>
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
                          <td>
                            <?php echo isset($values->amount) ? price_value($values->amount) :''; ?>
                          </td>
                        </tr>
                    <?php } ?>
                   </tbody>
                   
        </table>
    </div>
</div>
<?php } else {?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h3><?php lang('heading_no_reports_available_for_this_date'); ?></h3>
  
</div>
<?php } ?>