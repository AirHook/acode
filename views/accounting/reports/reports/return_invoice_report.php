<style type="text/css">
    
    body{
        background: #fff;
    }
</style>
<?php $controller=& get_instance();
    $controller->load->model('reports_model');
 ?>
                                <div class="table-responsive m-t">
                                    <table class="table-box">
                                        <thead>
                                        <tr>
                                            <th><?php lang('lab_sr_no'); ?></th>
                                            <th><?php lang('lab_invoice_no'); ?>.</th>
                                            <!-- <th>Voucher No</th> -->
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
                                        <?php if(!empty($saleInvoiceReports)) {
                                             // echo '<pre>',print_r($saleInvoiceReports),'</pre>';
                                            $grand_total = 0;
                                            $serial_no=1; foreach($saleInvoiceReports as $values) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $serial_no++; ?>
                                                </td>
                                                 <td>
                                                    <?php echo isset($values->salesInvoiceNo) ? $values->salesInvoiceNo :''; ?>
                                                </td>
                                              <!--   <td>
                                                    <?php 
                                                        echo isset($values->subtotal) ? $values->subtotal :'';
                                                     ?>
                                                </td> -->
                                                <td>
                                                    <?php 
                                                       echo isset($values->ledgerPosting->date) ? date('M,d Y',strtotime($values->ledgerPosting->date)) :'';
                                                    ?>
                                                </td>
                                                
                                                <td>
                                                <?php 
                                                   echo isset($values->customerName->ledgerName) ? $values->customerName->ledgerName :'';
                                                ?>
                                                </td>
                                              
                                                <td>
                                                    <?php echo isset($values->subtotal) ? $values->subtotal :''; ?>
                                                 
                                                </td>
                                                <td><?php echo isset($values->tax_amount) ? $values->tax_amount :''; ?></td>
                                                <td><?php echo isset($values->freight) ? $values->freight :''; ?></td>
                                                <td><?php 
                                                if(isset($values->discount) && $values->discount != '') {
                                                    echo $values->discount;
                                                    echo (isset($values->discount_type) && $values->discount_type != 'amount') ? $values->discount_type : '';
                                                }
                                                 ?></td>
                                               
                                                <td>
                                                    <?php
                                                        echo isset($values->total) ? number_format($values->total,2):'';
                                                     ?>
                                                </td>
                                                <td><?php echo isset($values->payment_receive) ? $values->payment_receive : ''; ?></td>
                                                <td>
                                                    <?php
                                                    $payment = isset($values->payment_receive) ? (float)$values->payment_receive : 0;
                                                    $total = isset($values->total) ? (float)$values->total : 0;
                                                    echo $total - $payment;
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $grand_total += (float)$values->total;
                                             } ?>
                                            <tr>
                                                <th colspan="8"><?php lang('lab_total'); ?></th>
                                                  <th><?php echo number_format($grand_total, 2); ?></th>
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