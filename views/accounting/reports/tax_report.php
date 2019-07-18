<?php $controller=& get_instance();
    $controller->load->model('reports_model');
 ?>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row overflow-hide">
        <div class="col-sm-12 overflow-hide">
            <div class="ibox overflow-hide">
                <div class="ibox-content">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="hpanel">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <button class="btn btn-success"><i class="fa fa-print"></i><?php lang('btn_print') ?></button>
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel-body p-xl">
                                <div class="row m-b-xl">
                                    <div class="col-sm-6">
                                        <address>
                                            <strong><?php lang('lab_company_information') ?>:</strong><br>
                                            <?php lang('lab_name'); ?>:&nbsp;<?php
                                                $companyInformation=$controller->reports_model->getOne('tbl_company');
                                                if(!empty($companyInformation)){
                                                    echo isset($companyInformation->companyName) ? $companyInformation->companyName :'';
                                                    ?>
                                                  <br>
                                                <?php lang('lab_email'); ?>:&nbsp;<?php echo isset($companyInformation->emailId) ? $companyInformation->emailId :''; ?>
                                                <br>
                                                <?php lang('lab_phone'); ?>#:&nbsp;<?php echo isset($companyInformation->mobile) ? $companyInformation->mobile :''; ?>
                                                <br>
                                                <?php lang('lab_address'); ?>:&nbsp;<?php echo isset($companyInformation->address) ? $companyInformation->address :''; ?>
                                            <?php } ?>
                                        </address>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <span></span>
                                        <address style="margin-right: 36px;">
                                            <strong style="margin-right: 26px;"><?php lang(''); ?>Receipt Voucher.</strong><br>
                                        <?php if(!empty($receiptVoucherReports)) { ?>
                                            <?php lang('lab_voucher'); ?>#:&nbsp;<?php echo isset($receiptVoucherReports[0]->voucherNo) ? $receiptVoucherReports[0]->voucherNo :''; ?>
                                            <br>
                                            <?php lang('lab_voucher_date'); ?>:&nbsp;<?php echo isset($receiptVoucherReports[0]->date) ? date('M d,y', strtotime($receiptVoucherReports[0]->date) ) :''; ?>
                                        <?php } ?>
                                        </address>
                                    </div>
                                </div>

                                <div class="table-responsive m-t">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th><?php lang('lab_sr_no'); ?></th>
                                            <th><?php lang('lab_particulars'); ?></th>
                                            <th><?php lang('lab_cheque_no'); ?></th>
                                            <th><?php lang('lab_cheque_date'); ?></th>
                                            <th><?php lang('lab_currency'); ?></th>
                                            <th><?php lang('lab_amount'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($receiptVoucherReports)) {
                                            $totalDebit=0;
                                            $totalCredit=0;
                                            $serial_no=1; foreach($receiptVoucherReports as $values) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $serial_no++; ?>
                                                </td>
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
                                                <td>
                                                <?php 
                                                    $currencyName='';
                                                    if(isset($values->currency)){
                                                        $currencyName=$controller->reports_model->getOne('tbl_currency',array('id'=>$values->currency));
                                                        if(!empty($currencyName)){
                                                           $currencyName=$currencyName->currency_code;
                                                           echo $currencyName;
                                                        }
                                                    }
                                                ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if(isset($values->debit) && isset($values->credit)){
                                                            echo $values->debit + $values->credit ;
                                                            $totalDebit+=$values->debit;
                                                             $totalCredit+=$values->credit;
                                                        }
                                                     ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                        
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr style="border-top: 1px solid #8c8b8b">
                                    <div class="row">
                                        <div class="col-sm-8"></div>
                                        <div class="col-sm-2">
                                            <h2><?php lang('lab_total_credit'); ?>:</h2>
                                        </div>
                                        <div class="col-sm-2">
                                            <h2>
                                                <?php 
                                                echo isset($totalCredit) ? number_format($totalCredit,2) :'';
                                                echo '&nbsp;&nbsp;';
                                                echo isset($currencyName) ? $currencyName :'';
                                          ?>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8"></div>
                                        <div class="col-sm-2">
                                            <h2><?php lang('lab_total_debit'); ?>:</h2>
                                        </div>
                                        <div class="col-sm-2">
                                            <h2>
                                         <?php 
                                                echo isset($totalDebit) ? number_format($totalDebit,2) :'';
                                                echo '&nbsp;&nbsp;';
                                                echo isset($currencyName) ? $currencyName :'';
                                          ?>
                                            </h2>
                                        </div>
                                    </div>
                                    <hr style="border-top: 1px solid #8c8b8b">
                                    <div class="row">
                                        
                                        <div class="col-sm-2">
                                            <h3><?php lang('lab_total_credit'); ?>:</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>
                                            <?php 
                                                echo isset($currencyName) ? $currencyName :'';
                                                echo '&nbsp;&nbsp;';
                                                if(isset($totalCredit)){
                                                     $totalCreditInWords=$controller->convert_number_to_words($totalCredit);
                                                     echo ucfirst($totalCreditInWords);
                                                 }
                                          ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                       
                                        <div class="col-sm-2">
                                            <h3><?php lang('lab_total_debit'); ?>:</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4>
                                         <?php 
                                                echo isset($currencyName) ? $currencyName :'';
                                                echo '&nbsp;&nbsp;';
                                                if(isset($totalDebit)){
                                                     $totalDebitInWords=$controller->convert_number_to_words($totalDebit);
                                                     echo ucfirst($totalDebitInWords);
                                                 }
                                          ?>

                                            </h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>