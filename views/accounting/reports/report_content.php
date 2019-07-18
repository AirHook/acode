<?php $controller =& get_instance(); ?>
<style type="text/css">
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
            .table-box tr th{
                background-color: #dedddd !important;  
            }

           
            .ibox-content {
                padding-bottom: 10px;
            }
</style>
        <div class="">

            <div class="<?php echo (!isset($is_print)) ? 'ibox' : ''; ?>">

                <div class="<?php echo (!isset($is_print)) ? 'ibox-content' : ''; ?>">

                	<div class="head" style="margin-left: 20px;">

                		<h2><?php echo $title; ?>
                        <?php if(!isset($is_print)){ ?>
                        <a target="_blank" href="#" data-url="<?php echo isset($print_url) ? $print_url : '#'; ?>" class="btn btn-success pull-right print_reports"><i class="fa fa-print"></i><?php lang('btn_print_reports'); ?></a>
                        <?php } ?>
                        <br>
                        <span style="font-size: 12px; font-weight: normal;"><?php echo date('M d Y', strtotime($start)); ?> to <?php echo date('M d Y', strtotime($end)); ?></span></h2>
                        <?php if(isset($single_report) && $single_report): ?>
                            <div>
                                <?php echo isset($ledger->ledgerName) ? '<h3>Account Ledger: '.$ledger->ledgerName.'</h3>' : ''; ?>
                            </div>
                            <div>
                                <?php echo isset($ledgerReorts[0]->Opening) ? '<h3>Opening Balance: '.$ledgerReorts[0]->Opening.'</h3>' : ''; ?>
                            </div>
                        <?php endif; ?>
                	</div>
                    <div class="content" style="margin-left: 20px;" >
                        <hr style="border-color: DimGray;">
                        <table class="summary_table" style="margin-bottom: 20px;">
                            <tr>
                                <td>
                                <div class="" style="text-align: left; width:100%;">

                                        <address>

                                            <h5 style="font-size: 18px; font-weight: bold;">Company Information:</h5>
                                            <?php
                                                $userID=$controller->session->userdata('id');
                                                $query="SELECT * FROM tbl_company WHERE companyId IN(SELECT company_id FROM tbl_users WHERE id=$userID)";
                                                $company=$controller->reports_model->universal($query)->row();
                                                ?>
                                                <table>
                                                    <?php if(isset($company->companyName) && $company->companyName != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;">Name</td>
                                                            <td><?php echo $company->companyName; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->emailId) && $company->emailId != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;">Email</td>
                                                            <td><?php echo $company->emailId; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->mobile) && $company->mobile != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;">Phone#</td>
                                                            <td><?php echo $company->mobile; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if(isset($company->address) && $company->address != ''): ?>
                                                        <tr>
                                                            <td style="width: 70px; font-weight: bold;">Address</td>
                                                            <td><?php echo $company->address; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>


                                        </address>

                                    </div>
                                </td>
                                <td>
                                    <div  style="text-align:right;width:100%;">
                                        <!-- <address style="margin-right: 36px;">

                                            <strong style="margin-right: 26px;">Journal Voucher.</strong><br>

                                        <?php if(!empty($journalReports)) { ?>

                                            Voucher#:&nbsp;<?php echo isset($journalReports[0]->voucherNo) ? $journalReports[0]->voucherNo :''; ?>

                                            <br>

                                            Voucher Date:&nbsp;<?php echo isset($journalReports[0]->date) ? date('M d,y', strtotime($journalReports[0]->date) ) :''; ?>

                                        <?php } ?>

                                        </address> -->
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <?php echo isset($content)? $content : ''; ?>

                	</div>

                </div>

            </div>

        </div>

   