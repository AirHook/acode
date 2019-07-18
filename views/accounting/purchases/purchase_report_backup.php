<?php $controller =& get_instance(); 
$controller->load->model('purchase_model')?>
<style type="text/css">
.ibox-content {
    padding: 10px;
}
    .table-box-sec tr td strong{
                margin-bottom: 3px;
                display: inline-block;
            }
            .reports h2{
                margin-top: 20px;
            }
            th {
                text-align: left;
                padding: 15px;
            }
            table{
                width: 100%;
            }
            .table-box  {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 98%;
            }
            .table-box thead tr th{
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            .table-box tbody tr{
                width: 100%;
            }
            .table-box tbody tr td,.table-box tbody tr th{
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            .table-box tbody tr:nth-of-type(2n) td {
                background-color: #f3f0f0;
            }
            .table-box thead tr th{
                background-color: #dedddd;  
            }
           
            .ibox-content {
                padding-bottom: 10px;
            }
            .footer_table {
                /*width: 300px;*/
                margin-right: 0px;
                text-align: right;
            }
            .footer_table th {
                padding: 8px;
            }
}
</style>
        <div class="ibox-content">
            <div class="<?php echo (!isset($is_preview)) ? 'ibox' : ''; ?>">
                <div class="<?php echo (!isset($is_preview)) ? 'ibox-content' : ''; ?>">
                    <div class="head" style="margin-left: 20px;">
                        <h2><?php echo isset($title) ? $title : ''; ?><span><?php echo isset($number) ? '#'.$number : ''; ?></span>
                        <span class="pull-right">
                        <?php if(!isset($is_print)): ?>
                            <a href="<?php echo base_url('accounting/'.$controller_name.'/printFullInvoice'); ?>" class="btn btn-primary print-report" data-id="<?php echo isset($number) ? $number : ''; ?>"><?php lang('btn_print_invoice'); ?></a>
                        <?php if(isset($is_sale) && $is_sale) { ?>
                            <a href="<?php echo base_url('accounting/sales/printMiniReceipt'); ?>" class="btn btn-primary print-mini-receipt" data-id="<?php echo isset($model->salesInvoiceNo) ? $model->salesInvoiceNo : ''; ?>"><?php lang('btn_print_receipt'); ?></a>
                        <?php } ?>
                    <?php endif; ?>
                        </span>
                        </h2>
                        
                    </div>
                    <div class="content" style="margin-left: 20px;" >
                        <hr style="border-color: DimGray;">
                        <table class="summary_table" style="margin-bottom: 20px;">
                            <tr>
                                <td>
                                <div class="" style="text-align: left; width:100%; height: 200px;">
                                        <address>
                                            <h5 style="font-size: 18px; font-weight: bold;"><?php lang('lab_company_information'); ?>:</h5>
                                            <?php
                                                $company=$controller->reports_model->getOne('tbl_company',array('companyId'=>$controller->session->userdata('company_id')));
                                                ?>
                                                <table>
                                                    <?php if(isset($company->companyName) && $company->companyName != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_name'); ?></td>
                                                            <td><?php echo $company->companyName; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->emailId) && $company->emailId != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_email'); ?></td>
                                                            <td><?php echo $company->emailId; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->mobile) && $company->mobile != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_phone'); ?>#</td>
                                                            <td><?php echo $company->mobile; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->address) && $company->address != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_address'); ?></td>
                                                            <td><?php echo $company->address; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                        </address>
                                    </div>
                                </td>
                                <td>
                                    <div  style="width:100%; height: 200px;">
                                        <?php if((isset($ledger->ledgerName) && $ledger->ledgerName != '')
                                            OR (isset($ledger->email) && $ledger->email != '')
                                            OR (isset($ledger->mobile) && $ledger->mobile != '')
                                            OR (isset($ledger->address) && $ledger->address != '')
                                            ): ?>
                                        <address>
                                            <h5 style="font-size: 18px; font-weight: bold;"><?php lang('lab_account_ledger'); ?>:</h5>
                                                <table>
                                                    <?php if(isset($ledger->ledgerName) && $ledger->ledgerName != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_name'); ?></td>
                                                            <td><?php echo $ledger->ledgerName; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($ledger->email) && $ledger->email != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_email'); ?></td>
                                                            <td><?php echo $ledger->email; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($ledger->mobile) && $ledger->mobile != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_phone'); ?>#</td>
                                                            <td><?php echo $ledger->mobile; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($ledger->address) && $ledger->address != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;"><?php lang('lab_address'); ?></td>
                                                            <td><?php echo $ledger->address; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                        </address>
                                    <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        </table><br>
                        <div class="row">
                        <div class="col-sm-12 reports">
                            <table class="table-box" >
                                    <thead>
                                        <tr>
                                            <th><?php lang('lab_sr_no'); ?></th>
                                            <th><?php lang('lab_product_name'); ?></th>
                                            <th><?php lang('lab_unit'); ?></th>
                                            <th><?php lang('lab_price_u'); ?></th>
                                            <th><?php lang('lab_qty'); ?></th>
                                            <th><?php lang('lab_discount') ?></th>
                                            <th><?php lang('lab_tax'); ?></th>
                                            <th><?php lang('lab_total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total = 0;
                                        if(isset($products) && !empty($products)) {
                                            foreach ($products as $key=> $value) {
                                                echo '<tr>';
                                                    echo '<td>';
                                                    echo $key+1;
                                                    echo '</td>';
                                                    echo '<td>'.$value->productName.'</td>';
                                                    echo '<td>';
                                                    if(isset($value->unit->UOMName))
                                                        echo $value->unit->UOMName;
                                                    echo '</td>';
                                                    echo '<td>'.number_format($value->rate, 2).'</td>';
                                                    echo '<td>'.$value->qty.'</td>';
                                                    echo '<td>';
                                                    if(isset($is_sale) && $is_sale){
                                                        echo isset($value->unit_discount) ? $value->unit_discount:''; 
                                                        echo isset($value->discount_amount) ? $value->discount_amount :0.00;
                                                    }
                                                    echo '</td>';
                                                    echo '<td>';
                                                    if(isset($value->taxAmount)) {
                                                        echo $value->taxAmount;
                                                    }
                                                    echo '</td>';
                                                    echo '<td>'.number_format($value->amount, 2).'</td>';
                                                echo '</tr>';
                                                $total += (float)$value->amount;
                                            }
                                        } else {
                                        ?>
                                        <tr><th colspan="8" style="text-align: center;"><?php lang('lab_no_found'); ?></th></tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php
                                    echo '<tfoot class="footer_table">';
                                            echo '<tr>';
                                                echo '<th colspan="6"></th>';
                                                echo '<th>';
                                                     lang('lab_total');
                                                echo  '</th>';
                                                echo '<th>'.number_format($total, 2).'</th>';
                                            echo '</tr>';
                                            if(isset($model->discount) && $model->discount > 0):
                                            echo '<tr>';
                                                echo '<th colspan="6"></th>';
                                                echo '<th>';
                                                    lang('lab_discount');
                                                echo '</th>';
                                                echo '<th>'.number_format($model->discount, 2).'</th>';
                                            echo '</tr>';
                                            endif;
                                            if(isset($model->freight) && $model->freight > 0):
                                            echo '<tr>';
                                                echo '<th colspan="6"></th>';
                                                echo '<th>';
                                                        lang('lab_freight');
                                                echo '</th>';
                                                echo '<th>'.number_format($model->freight, 2).'</th>';
                                            echo '</tr>';
                                            endif;
                                            if(isset($model->tax) && $model->tax > 0){
                                                $taxesOnBill=$controller->purchase_model->getOne('tbl_accountledger',array('id'=>$model->tax));
                                                if(!empty($taxesOnBill)){
                                                    // $tax_amount = 
                                                    if(isset($taxesOnBill->ledgerName) && isset($model->tax_amount) && isset($taxesOnBill->tax_symbal)){
                                                        echo '<tr>';
                                                            echo '<th colspan="6"></th>';
                                                            echo '<th>'.$taxesOnBill->ledgerName.'</th>';
                                                            echo '<th>'.$model->tax_amount.'</th>';
                                                        echo '</tr>';
                                                    }
                                                }
                                            }
                                            echo '<tr>';
                                                echo '<th colspan="6"></th>';
                                                echo '<th>';
                                                        lang('lab_grand_total');
                                                echo '</th>';
                                                echo '<th>'.number_format($model->total, 2).'</th>';
                                            echo '</tr>';
                                            if(isset($model->payment_receive)) {
                                                echo '<tr>';
                                                    echo '<th colspan="6"></th>';
                                                    echo '<th>';
                                                        lang('lab_payment');
                                                    echo '</th>';
                                                    echo '<th>'.number_format($model->payment_receive, 2).'</th>';
                                                echo '</tr>';
                                                $balance = (float)$model->total - (float)$model->payment_receive;
                                                echo '<tr>';
                                                    echo '<th colspan="6"></th>';
                                                    echo '<th>';
                                                            lang('lab_balance');
                                                    echo '</th>';
                                                    echo '<th>'.number_format($balance, 2).'</th>';
                                                echo '</tr>';
                                            }
                                            echo '</tfoot>';
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   