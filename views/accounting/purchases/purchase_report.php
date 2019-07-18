<?php $controller =& get_instance(); 
$controller->load->model('purchase_model');
$controller_name = isset($controller_name) ? $controller_name : 'sales';
$form_title = isset($form_title) ? $form_title : 'Invoice';
if(isset($model->created_by)) {
    $employee = $controller->purchase_model->getOne('tbl_users', array('id' => $model->created_by));
    $employee = isset($employee->first_name) ? $employee->first_name.' '.$employee->last_name : '';
}
?>
<style type="text/css">
    .ibox-content {
        padding: 20px;
    }
    .table-box-sec tr td strong{
        margin-bottom: 3px;
        display: inline-block;
    }
    .reports h2{
        margin-top: 20px;
    }
    .pace-done{
        overflow-y: scroll;
        height: 700px;
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
        border-bottom: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    .table-box tbody tr{
        width: 100%;
    }
    .table-box tbody tr td,.table-box tbody tr th{
        /*border: 1px solid #dddddd;*/
        text-align: left;
        padding: 8px;
    }
    .table-box tbody tr:nth-of-type(2n) td {
        background-color: #f3f0f0;
    }
    .table-box thead tr th{
        /*background-color: #dedddd;  */
    }
   
    .ibox-content {
        padding-bottom: 10px;
    }
    .footer_table {
        /*width: 300px;*/
        margin-right: 0px;
        text-align: right;
    }
    .footer_table th, .footer_table td {
        padding: 8px;
        text-align: left;
    }

}
</style>
        <div class="ibox-content">
            <div class="<?php echo (!isset($is_preview)) ? 'ibox' : ''; ?>">
                <div class="<?php echo (!isset($is_preview)) ? 'ibox-content' : ''; ?>">
                    <div class="head" style="margin-left: 20px;">
                        <h2>
                        <span class="pull-right">
                        <?php if(!isset($is_print)): ?>
                            <a href="#" class="btn btn-primary " onclick="printPage('<?php echo base_url("accounting/".$controller_name."/printInvoice/".$number."/print"); ?>')"><?php lang('btn_print_invoice'); ?></a>
                        <?php if(isset($is_sale) && $is_sale) { ?>
                            <!-- <a href="<?php echo base_url('accounting/sales/printMiniReceipt'); ?>" class="btn btn-primary print-mini-receipt" data-id="<?php echo isset($model->salesInvoiceNo) ? $model->salesInvoiceNo : ''; ?>"><?php lang('btn_print_receipt'); ?></a> -->
                        <?php } ?>
                    <?php endif; ?>
                        </span>
                        </h2>
                        
                    </div>
                    <div class="content" style="margin-left: 20px;" >
                        <!-- <hr style="border-color: DimGray;"> -->
                        <table class="summary_table summary_table_inner" style="margin-bottom: 20px;">
                            <tr>
                                <td>
                                <div class="sale_invoice_table sale_invoice_inner">
                                        <address>
                                            <h5 style="font-size: 18px; font-weight: bold;color:#000;"><?php isset($company->companyName) ? $company->companyName : ''; ?></h5>
                                            <?php
                                                $company=$controller->reports_model->getOne('tbl_company',array('companyId'=>$controller->session->userdata('company_id')));
                                                ?>
                                                <table>
                                                    <?php if(isset($company->company_logo) && $company->company_logo != ''): ?>
                                                         <tr>
                                                            <td><img  src="<?php echo base_url($company->company_logo); ?>" alt=""></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->companyName) && $company->companyName != ''): ?>
                                                        <tr>
                                                            <!-- <td style="font-weight:800;color:#000;"><?php lang('lab_address'); ?> :</td> -->
                                                            <td><strong><?php echo $company->companyName; ?></strong></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->address) && $company->address != ''): ?>
                                                        <tr>
                                                            <!-- <td style="font-weight:800;color:#000;"><?php lang('lab_address'); ?> :</td> -->
                                                            <td><?php echo $company->address; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->mobile) && $company->mobile != ''): ?>
                                                        <tr>
                                                            <!-- <td style="font-weight:800;color:#000;"><?php lang('lab_phone'); ?>#  :</td> -->
                                                            <td><?php echo $company->mobile; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->emailId) && $company->emailId != ''): ?>
                                                        <tr>
                                                           <!--  <td style="font-weight:800;color:#000;"><?php lang('lab_email'); ?> :</td> -->
                                                            <td><?php echo $company->emailId; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <tr><td></td></tr>
                                                    <tr>
                                                        <td><strong><?php echo (isset($is_sale) && $is_sale) ? 'Sale' : 'Purchase'; ?> <?php echo (isset($model->customerId) && $model->customerId == 1 && isset($title) && $title == 'Sale Invoice') ? 'Receipt' : $form_title; ?></strong></td>
                                                    </tr>
                                                    <tr><td><?php echo isset($model->created_on) ? date('M d Y h:i A', strtotime($model->created_on)) : ''; ?></td></tr>
                                                </table>
                                        </address>
                                    </div>
                                </td>
                                <td>
                                   <!--  <div  style="width:100%; height: auto;">
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
                                                            <td style=""><?php lang('lab_name'); ?></td>
                                                            <td><?php echo $ledger->ledgerName; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($ledger->email) && $ledger->email != ''): ?>
                                                        <tr>
                                                            <td style=""><?php lang('lab_email'); ?></td>
                                                            <td><?php echo $ledger->email; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($ledger->mobile) && $ledger->mobile != ''): ?>
                                                        <tr>
                                                            <td style=""><?php lang('lab_phone'); ?>#</td>
                                                            <td><?php echo $ledger->mobile; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($ledger->address) && $ledger->address != ''): ?>
                                                        <tr>
                                                            <td style=""><?php lang('lab_address'); ?></td>
                                                            <td><?php echo $ledger->address; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                        </address>
                                    <?php endif; ?>
                                    </div> -->
                                </td>
                            </tr>
                        </table>

                        <div class="sale_id" style="text-align: left;">
                            <b><?php echo (isset($is_sale) && $is_sale) ? 'Sale' : 'Purchase'; ?> ID : <span><?php echo (isset($is_sale) && $is_sale) ? 'SI-' : 'PI-'; ?><?php echo isset($number) ? $number : ''; ?></span></b>
                            <b><?php echo isset($employee) ? 'Employee : <span>'.$employee.'</span>' : ''; ?></b>
                            <?php
                            $supplier = null;
                            if(isset($is_sale) && $is_sale) {
                                if(isset($model->customerId)) {
                                    $supplier = $controller->purchase_model->getOne('tbl_accountledger', array('id' => $model->customerId));
                                    $supplier = isset($supplier->ledgerName) ? 'Customer: '.$supplier->ledgerName : '';
                                }
                            } else {
                                if(isset($model->supplierId)) {
                                    $supplier = $controller->purchase_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
                                    $supplier = isset($supplier->ledgerName) ? 'Supplier: '.$supplier->ledgerName : '';
                                }
                            }
                            ?>
                            <b><?php echo $supplier; ?></b>
                        </div>

                        <div class="row">
                        <div class="col-sm-12 reports">
                            <table class="table-box" >
                                    <thead>
                                        <tr>
                                            <th><?php lang('product'); ?></th>
                                            <!-- <th><?php lang('lab_unit'); ?></th> -->
                                            <th><?php lang('lab_price_u'); ?></th>
                                            <th><?php if (isset($form_title) && $form_title == 'Return') { echo 'Returned Qty'; } else { lang('lab_qty'); } ?></th>
                                            <!-- <th><?php lang('disc') ?></th> -->
                                            <!-- <th><?php lang('lab_tax'); ?></th> -->
                                            <th><?php lang('lab_total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total = 0;
                                        if(isset($products) && !empty($products)) {
                                            foreach ($products as $key=> $value) {
                                                echo '<tr>';
                                                    echo '<td>'.$value->productName.'</td>';
                                                    // echo '<td>';
                                                    // if(isset($value->unit->UOMName))
                                                    //     echo $value->unit->UOMName;
                                                    // echo '</td>';
                                                    echo '<td>'.price_value($value->rate).'</td>';
                                                    echo '<td>';
                                                    echo (isset($form_title) && $form_title == 'Return') ? $value->return_qty : $value->qty;
                                                    echo '</td>';
                                                    $single_total = 0;
                                                    // echo '<td>';
                                                    // if(isset($value->amount))
                                                    //     $single_total += (float)$value->amount;
                                                    // if(isset($is_sale) && $is_sale){
                                                    //     echo (isset($value->unit_discount) && $value->unit_discount > 0) ? price_value($value->unit_discount):''; 
                                                    //     echo (isset($value->discount_amount) && $value->discount_amount > 0) ? price_value($value->discount_amount) : '';
                                                    // } else {
                                                    //     if(isset($value->unit_discount) && $value->unit_discount > 0)
                                                    //         echo price_value($value->unit_discount);
                                                    // }
                                                    // if(isset($value->unit_discount))
                                                    //     $single_total += (float)$value->unit_discount;
                                                    // if(isset($value->discount_amount))
                                                    //     $single_total += (float)$value->discount_amount;
                                                    // echo '</td>';
                                                    // echo '<td>';
                                                    // if(isset($value->taxAmount) && (float)$value->taxAmount > 0) {
                                                    //     echo price_value($value->taxAmount);
                                                    // } else if(isset($value->tax_id)) {
                                                    //     $tax_row = $controller->purchase_model->getById('tbl_accountledger', $value->tax_id);
                                                    //     $tax_amount = 0;
                                                    //     if(isset($tax_row->tax_value)) {
                                                    //         $tax_amount = (float)$tax_row->tax_value;
                                                    //         $tax_amount = (float)($tax_amount*$single_total)/100;
                                                    //         if($tax_amount > 0)
                                                    //             echo price_value($tax_amount);
                                                    //     }
                                                    // }
                                                    // echo '</td>';
                                                    echo '<td>'.price_value($value->amount).'</td>';
                                                echo '</tr>';
                                                $total += (float)$value->amount;
                                            }
                                        } else {
                                        ?>
                                        <tr><th colspan="5" style="text-align: center;"><?php lang('lab_no_found'); ?></th></tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php
                                    echo '<tfoot class="footer_table">';
                                            echo '<tr>';
                                                echo '<th colspan="3"></th>';
                                                echo '<th>';
                                                     lang('lab_total');
                                                echo  '</th>';
                                                echo '<th>'.price_value($total).'</th>';
                                            echo '</tr>';

                                            if(isset($model->discount) && $model->discount > 0 && isset($form_title) && $form_title != 'Return'):
                                            echo '<tr>';
                                                echo '<th colspan="3"></th>';
                                                echo '<th>';
                                                if(isset($form_title) && $form_title == 'Return')
                                                    echo 'Deduction';
                                                else
                                                    lang('lab_discount');
                                                echo '</th>';
                                                echo '<th>'.price_value($model->discount).'</th>';
                                            echo '</tr>';
                                            endif;
                                            if(isset($model->freight) && $model->freight > 0 && isset($form_title) && $form_title != 'Return'):
                                            echo '<tr>';
                                                echo '<th colspan="3"></th>';
                                                echo '<th>';
                                                        lang('lab_freight');
                                                echo '</th>';
                                                echo '<th>'.price_value($model->freight).'</th>';
                                            echo '</tr>';
                                            endif;
                                            
                                            if(isset($model->tax) && $model->tax > 0){
                                                $taxesOnBill=$controller->purchase_model->getOne('tbl_accountledger',array('id'=>$model->tax));
                                                if(!empty($taxesOnBill)){
                                                    // $tax_amount = 
                                                    if(isset($taxesOnBill->ledgerName) && isset($model->tax_amount) && isset($taxesOnBill->tax_symbal)){
                                                        echo '<tr>';
                                                            echo '<th colspan="3"></th>';
                                                            echo '<th>'.$taxesOnBill->ledgerName.'</th>';
                                                            echo '<th>'.price_value($model->tax_amount).'</th>';
                                                        echo '</tr>';
                                                    }
                                                }
                                            }



                                            echo '<tr>';
                                                echo '<th colspan="3"></th>';
                                                echo '<th>';
                                                        lang('lab_grand_total');
                                                echo '</th>';
                                                echo '<th>';
                                                echo isset($model->total) ? price_value($model->total) : '';
                                                echo '</th>';
                                            echo '</tr>';

                                            

                                            if(isset($model->payment_receive)) {
                                                echo '<tr>';
                                                    echo '<th colspan="3"></th>';
                                                    echo '<th>';
                                                        lang('lab_payment');
                                                    echo '</th>';
                                                    echo '<th>'.price_value($model->payment_receive).'</th>';
                                                echo '</tr>';

                                                $balance = isset($model->return_amount) ? (float)$model->return_amount : ((float)$model->total - (float)$model->payment_receive);
                                                echo '<tr>';
                                                    echo '<th colspan="3"></th>';
                                                    echo '<th>';
                                                            echo ($balance < 0) ? 'Return' : lang('lab_balance');;
                                                    echo '</th>';
                                                    echo '<th>'.price_value(abs($balance)).'</th>';
                                                echo '</tr>';

                                                if(isset($model->salesInvoiceNo)) {
                                                    $payments = $controller->purchase_model->getAll('add_payment', array('company_id' => $controller->company_id, 'salesInvoiceNo' => $model->salesInvoiceNo, 'is_return' => 0));
                                                    if(!empty($payments)) {
                                                        echo '<tr>';
                                                            echo '<th colspan="3"></th>';
                                                            echo '<th>Payment Type</th>';
                                                            echo '<th>Amount</th>';
                                                            // echo '<th>Date</th>';
                                                        echo '</tr>';
                                                        foreach ($payments as $payment) {
                                                            echo '<tr>';
                                                                echo '<td colspan="3"></td>';
                                                                echo '<td>';
                                                                echo $payment->payment_method;
                                                                echo  '</td>';
                                                                echo '<td>'.price_value($payment->payment_value).'</td>';
                                                                // echo '<td>'.date('M d Y', strtotime($payment->created_on)).'</td>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                }
                                                


                                            }
                                            echo '</tfoot>';
                                    ?>
                                </table>
                            </div>
                        </div>
                        <div class="text-left">
                        <p><?php echo (isset($model->narration)) ? $model->narration : ''; ?></p></div>
                        <div class="center_info_box">
                            <?php 
                            if(isset($model->customerId) && $model->customerId == 1 && isset($title) && $title == 'Sale Invoice') {
                                if(isset($company->receipt_footer_text)): 
                                echo nl2br($company->receipt_footer_text);
                                endif; 
                            } else {
                                if(isset($company->invoice_footer_text)): 
                                echo nl2br($company->invoice_footer_text);
                                endif; 
                            }?>
                           <!--  <p>1: Item can only be returned within 7 days of purchase with orignal receipt and packing.</p>
                            <p>2: Item can only be exchange within 14 days of purchase with orignal packing & orignal receipt</p> -->
                            <p>Powered by IT Vision</p>
                            <?php if(isset($barcode)): ?>
                                <img src="<?php echo base_url()?>assets/barcodes/<?php echo $barcode ?>" alt="">
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
   