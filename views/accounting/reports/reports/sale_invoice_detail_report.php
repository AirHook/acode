<style type="text/css">
    
    body{
        background: #fff;
    }
</style>
<?php $controller=& get_instance();
    $controller->load->model('reports_model');
 ?>
                                <div class="">
                                    <table class="table-box dataTables1">
                                        <thead>
                                        <tr>
                                            <th><?php lang('lab_sr_no'); ?></th>
                                            <th><?php lang('lab_invoice_no'); ?>.</th>
                                            <th><?php lang('date'); ?></th>
                                            <th><?php lang('product_code'); ?></th>
                                            <th><?php lang('product_name'); ?></th>
                                            <th><?php lang('unit'); ?></th>
                                            <th><?php lang('qty'); ?></th>
                                            <th><?php lang('unit_price'); ?></th>
                                            <th><?php lang('lab_discount'); ?></th>
                                            <th><?php lang('lab_tax'); ?></th>
                                            <th><?php lang('total'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($saleInvoiceReports)) {
                                             // echo '<pre>',print_r($saleInvoiceReports),'</pre>';
                                            $grand_total = 0;
                                            $serial_no=1; 
                                            foreach($saleInvoiceReports as $values) { ?>
                                                <tr>
                                                    <td><?php echo $serial_no++; ?></td>
                                                    <td><?php echo $values->invoice_no; ?></td>
                                                    <td><?php echo $values->date; ?></td>
                                                    <td><?php echo $values->code; ?></td>
                                                    <td><?php echo $values->product_name; ?></td>
                                                    <td><?php echo $values->unit_name; ?></td>
                                                    <td><?php echo $values->qty; ?></td>
                                                    <td><?php echo price_value($values->rate); ?></td>
                                                    <td><?php echo price_value($values->discount); ?></td>
                                                    <td><?php echo price_value($values->tax); ?></td>
                                                    <td><?php echo price_value($values->total); ?></td>
                                                </tr>
                                            <?php
                                            $grand_total += (float)$values->total;
                                             } ?>
                                            <!-- <tr>
                                                <th colspan="10"><?php lang('lab_total'); ?></th>
                                                  <th><?php echo number_format($grand_total, 2); ?></th>
                                            </tr> -->
                                        <?php } else { ?>
                                        <!-- <tr><td colspan="11" style="text-align: center;"><?php lang('lab_no_found'); ?></td></tr> -->
                                        <?php  } ?>
                                        
                                            </tbody>
                                        </table>
                                    </div>
    </div>
</div>