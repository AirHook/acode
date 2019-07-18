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
                                            <th>Voucher No.</th>
                                            <th><?php lang('lab_particulars'); ?></th>

                                            <th><?php lang('lab_cheque_no'); ?></th>

                                            <th><?php lang('lab_cheque_date'); ?></th>


                                            <th><?php lang('lab_debit'); ?></th>
                                            <th><?php lang('lab_credit'); ?></th>
                                            <th>Actions</th>
                                        </tr>

                                        </thead>

                                        <tbody>

                                        <?php if(!empty($receiptReports)) {

                                            $totalDebit=0;

                                            $totalCredit=0;

                                            $serial_no=1; foreach($receiptReports as $values) { ?>

                                            <tr>

                                                <td>

                                                    <?php echo $serial_no++; ?>

                                                </td>
                                                <td><?php echo isset($values->voucherNo) ? $values->voucherNo : ''; ?></td>
                                                <td>

                                                    <?php 

                                                        if(isset($values->ledgerId)){

                                                            $ledgerName=$controller->reports_model->getOne('tbl_accountledger',array('id'=>$values->ledgerId));

                                                            if(!empty($ledgerName)){

                                                                echo isset($ledgerName->ledgerName) ? $ledgerName->ledgerName :''; 

                                                            }

                                                        }

                                                     ?>

                                                </td>

                                                <td>

                                                    <?php 

                                                        echo isset($values->chequeNo) ? $values->chequeNo :'';

                                                    ?>

                                                </td>

                                                <td>

                                                    <?php 

                                                        echo isset($values->chequeDate) ? date('M d,Y',strtotime($values->chequeDate)) :'';

                                                    ?>

                                                </td>

                                                <?php 

                                                    $currencyName='';

                                                        $currency=$controller->reports_model->getOne('tbl_currency',array('company_id'=>$controller->company_id));

                                                        if(!empty($currency)){

                                                           $currencyName=$currency->currency_code;


                                                        }

                                                ?>
                                                 <td><?php echo isset($values->debit) ? price_value($values->debit) : price_value(0, 2); ?>  <?php echo $currencyName; ?></td>
                                                 <td><?php echo isset($values->credit) ? price_value($values->credit) : price_value(0, 2); ?>  <?php echo $currencyName; ?></td>
                                                 <td><a href="<?php echo base_url('accounting/transactions/printReceiptVoucher/'.$values->voucherNo); ?>" >Print</a></td>
                                            </tr>

                                            <?php } ?>
                                        <?php } else { ?>
                                        <tr><td colspan="8" style="text-align: center;"><?php lang('lab_no_found'); ?></td></tr>
                                        <?php  } ?>

                                        

                                            </tbody>

                                        </table>

                                    </div>


                                       

    </div>

</div>