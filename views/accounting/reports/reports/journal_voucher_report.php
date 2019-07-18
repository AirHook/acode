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
                                            <th><?php lang('lab_sr_no');?></th>
                                            <th>Voucher No.</th>
                                            <th><?php lang('lab_particulars');?></th>
                                            <th><?php lang('lab_debit');?></th>
                                            <th><?php lang('lab_credit');?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($journalReports)) {
                                            $totalDebit=0;
                                            $totalCredit=0;
                                        $serial_no=1; foreach($journalReports as $values) { ?>
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
                                                <?php 
                                                    $currencyName='';
                                                    $currency=$controller->reports_model->getOne('tbl_currency',array('company_id'=>$controller->company_id));
                                                    if(!empty($currency)){
                                                       $currencyName=$currency->currency_code;
                                                    }
                                                ?>
                                                <td>
                                                    <?php
                                                        if(isset($values->debit) && $values->debit >0){
                                                            echo price_value($values->debit);
                                                            echo '&nbsp;&nbsp;';
                                                            echo $currencyName;
                                                            $totalDebit+=$values->debit;
                                                        }
                                                     ?>
                                                </td>
                                                <td>
                                                <?php    if(isset($values->credit) && $values->credit >0){
                                                            echo price_value($values->credit);
                                                            echo '&nbsp;&nbsp;';
                                                            echo $currencyName;
                                                            $totalCredit+=$values->credit;
                                                        } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <th colspan="2"><?php lang('lab_total');?></th>
                                                  <th><?php echo price_value($totalDebit).' '.$currencyName.' Dr'; ?></th>
                                                  <th><?php echo price_value($totalCredit).' '.$currencyName.' Cr'; ?></th>
                                            </tr>
                                        <?php } else { ?>
                                        <tr><td colspan="5" style="text-align: center;"><?php lang('lab_no_found');?></td></tr>
                                        <?php  } ?>
                                        
                                            </tbody>
                                        </table>
                                    </div>
    </div>
</div>