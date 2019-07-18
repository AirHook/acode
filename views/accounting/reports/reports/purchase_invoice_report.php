<?php $controller=& get_instance();
    $controller->load->model('reports_model');
 ?>
    <div class="table-responsive m-t">
        <table class="table-box">
            <thead>
            <tr>
                <th><?php lang('lab_sr_no'); ?></th>
                <th><?php lang('lab_invoice_no'); ?>.</th>
                <th><?php lang('lab_invoice_date'); ?></th>
                <th><?php lang('lab_cash_party'); ?></th>
                <th><?php lang('lab_sub_total'); ?></th>
                <th><?php lang('lab_tax'); ?></th>
                <th><?php lang('lab_freight'); ?></th>
                <th><?php lang('lab_discount'); ?></th>
                <th><?php lang('lab_grand_total'); ?></th>
                <th><?php lang('lab_payment'); ?></th>
                <th><?php lang('lab_balance'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($purchaseInvoiceReports)) {
                // echo '<pre>',print_r($purchaseInvoiceReports),'</pre>';
                $grand_total = 0;
                $serial_no=1; foreach($purchaseInvoiceReports as $values) { ?>
                <tr>
                    <td>
                        <?php echo $serial_no++; ?>
                    </td>
                     <td>
                        <?php echo isset($values->purchaseInvoiceNo) ? $values->purchaseInvoiceNo :''; ?>
                    </td>
                  <!--   <td>
                        <?php 
                            echo isset($values->subtotal) ? price_value($values->subtotal) :'';
                         ?>
                    </td> -->
                    <td>
                        <?php 
                           echo isset($values->ledgerPosting->date) ? date('M d Y h:i A',strtotime($values->ledgerPosting->date)) :'';
                        ?>
                    </td>
                    
                    <td>
                    <?php 
                        if(isset($values->supplierId)){
                            $ledgerName=$controller->reports_model->getOne('tbl_accountledger',array('id'=>$values->supplierId));
                            if(!empty($ledgerName)){
                               echo isset($ledgerName->ledgerName) ? $ledgerName->ledgerName :'';
                            }
                        }
                    ?>
                    </td>
                  
                    <td>
                        <?php echo isset($values->subtotal) ? price_value($values->subtotal) :''; ?>
                     
                    </td>
                    <td><?php echo isset($values->tax_amount) ? price_value($values->tax_amount) :''; ?></td>
                    <td><?php echo isset($values->freight) ? price_value($values->freight) :''; ?></td>
                    <td><?php 
                    if(isset($values->discount) && $values->discount != '') {
                        echo price_value($values->discount);
                        echo (isset($values->discount_type) && $values->discount_type != 'amount') ? $values->discount_type : '';
                    }
                     ?></td>
                   
                    <td>
                        <?php
                            echo isset($values->total) ? price_value($values->total):'';
                         ?>
                    </td>
                    <td><?php echo isset($values->payment_receive) ? price_value($values->payment_receive) : ''; ?></td>
                    <td>
                        <?php
                        $payment = isset($values->payment_receive) ? (float)$values->payment_receive : 0;
                        $total = isset($values->total) ? (float)$values->total : 0;
                        echo price_value($total - $payment);
                        ?>
                    </td>
                </tr>
                <?php
                $grand_total += (float)$values->total;
                 } ?>
                <tr>
                    <th colspan="8"><?php lang('lab_total'); ?></th>
                      <th><?php echo price_value($grand_total); ?></th>
                      <th></th>
                      <th></th>
                </tr>
            <?php } else { ?>
            <tr><td colspan="11" style="text-align: center;"><?php lang('lab_no_found'); ?></td></tr>
            <?php  } ?>
            
                </tbody>
            </table>
        </div>
    </div>
</div>