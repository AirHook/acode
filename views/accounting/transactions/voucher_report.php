<?php $controller =& get_instance(); 
$controller->load->model('transaction_model');
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
                                                $company=$controller->transaction_model->getOne('tbl_company',array('companyId'=>$controller->session->userdata('company_id')));
                                                ?>
                                                <table>
                                                    <?php if(isset($company->company_logo) && $company->company_logo != ''): ?>
                                                         <tr>
                                                            <td><img  src="<?php echo base_url($company->company_logo); ?>" alt=""></td>
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
                                                        <td><strong><?php echo isset($title) ? $title : ''; ?></strong></td>
                                                    </tr>
                                                    <tr><td><?php echo isset($products[0]->created_on) ? date('M d Y h:i A', strtotime($products[0]->created_on)) : ''; ?></td></tr>
                                                </table>
                                        </address>
                                    </div>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </table>

                        <div class="sale_id" style="text-align: left;">
                            <b>Voucher ID: <span><?php echo isset($number) ? $number : ''; ?></span></b>
                            <b><?php echo isset($products[0]->employee) ? 'Employee : <span>'.$products[0]->employee.'</span>' : ''; ?></b>
                            <b><?php echo isset($detail->fromLedgerName) ? 'Cash/Bank: <span>'.$detail->fromLedgerName.'</span>' : ''; ?></b>
                          
                        </div>

                        <div class="row">
                        <div class="col-sm-12 reports">
                            <table class="table-box" >
                                    <thead>
                                        <tr>
                                            <th><?php lang('lab_sr_no'); ?></th>
                                            <th>Account Ledger</th>
                                            <th>Date</th>
                                            <th>Cheque No.</th>
                                            <th>Amount</th>
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
                                                    echo '<td>'.$value->toLedgerName.'</td>';
                                                    echo '<td>'.date('M d Y', strtotime($value->created_on)).'</td>';
                                                    echo '<td>'.$value->chequeNo.'</td>';
                                                    echo '<td>'.price_value($value->amount).'</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                        ?>
                                        <tr><th colspan="8" style="text-align: center;"><?php lang('lab_no_found'); ?></th></tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php
                                    // echo '<tfoot class="footer_table">';
                                    //         echo '<tr>';
                                    //             echo '<th colspan="6"></th>';
                                    //             echo '<th>';
                                    //                  lang('lab_total');
                                    //             echo  '</th>';
                                    //             echo '<th>'.price_value($total).'</th>';
                                    //         echo '</tr>';
                                    //  echo '</tfoot>';
                                    ?>
                                </table>
                            </div>
                        </div>
                        <div class="text-left">
                        <p><?php echo (isset($model->narration)) ? $model->narration : ''; ?></p></div>
                        <div class="center_info_box">
                            <?php if(isset($company->invoice_footer_text)): 
                            echo nl2br($company->invoice_footer_text);
                            endif; ?>
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
   