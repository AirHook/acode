<style type="text/css">

    p{color:black; font-size:14px;font-weight:bold;}

  .top_table tr td{font-size: 14px; font-weight:bold; color:#000;}

  .top_table td {padding-left:20px;color;#000;}

  .table_bord tr td{font-size: 14px; font-weight: bold; color:#000;}

  .row_style{

      margin:10px;

      text-align: center;

      padding:10px;

    }

    .row_info{



      padding-left: 10px;

    }

    #quta{

      position:absolute;top:50px;left:500px;color:#000;

    }

    #tbl_top_left{

      width:300px;height:50px;border:3px solid black;float:right;

    }

    #axcy{

      background-color:black !important;color:white !important;

    }

    @media print{



      #masterContent{max-width:100%;}

      #invoice-payment-table{width: 100% !important;}

      #sum_table{float:right !important;position:relative;right:10px !important;width:208px !important;}

      #axcy th{background-color:#000 !important;color:white !important; -webkit-print-color-adjust: exact; }

      #masterContent{height:auto;}

      #sum_table{width:269px !important;margin-right:-10px !important;}



    }



  </style>

  <body>

  <div class="container" style="width:800px;background-color: #fff;margin-top:20px;">

    <div class="col-sm-12">

        <h1 style="font-size: 20px;margin: 0;padding: 15px 16px;float: left;"><?php lang('heading_INVOICE'); ?> #4                                    

          <span class="label ml15 b-a "><span class="text-primary"><?php lang('heading_recurring'); ?></span></span>

        </h1>

        <div class="btn-group" style="padding: 15px 16px;float:right;">

       <div class="btn-group">

       <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

         <?php lang('lab_actions'); ?>

        </button>
        <a href="<?php echo base_url('accounting/purchases/printMiniReceipt'); ?>" class="btn btn-primary print-mini-receipt"><?php lang('btn_print_receipt'); ?></a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

          <a class="dropdown-item" href="#"><?php lang('btn_preview_invoice'); ?></a>

          <a class="dropdown-item" href="#"><?php lang('btn_print_invoice'); ?></a>

        </div>

      </div>

    </div>

</div>

  <div class="container" style="width:800px;background-color: #fff;margin-top:20px;">

    

   <div class="row col-sm-12" style="margin-top: 20px; padding-right: 0;">

          <div class="col-sm-6"><img src="https://cdn.filestackcontent.com/wzAnzowGT7iDBG8zNQSY" width="150px" height="100px"><br>

            <b style="color:#000;font-size: 16px;"><?php lang('lab_kayden_pte_Ltd'); ?>  </b> 

            <p>

               <?php lang('par_blk_5_toa_Payoh_Ind_Pk_Main_office_address'); ?><br>

               <br>

               <?php lang('par_enquiry_kaydenfleet_com'); ?>              </p>

          </div>

          <!-- <div class="name" id="quta"><h3>Quotation</h3></div> -->

          <div class="col-sm-6" style="padding-right: 0;">

            <div class="table-responsive" style="margin-left: 40px;">

              <table id="tbl_top_left" class="top_table">

                 <tr>

                    <td><?php lang('lab_date'); ?>:</td>

                    <td>2018-01-24</td>

                 </tr>

                 <tr>

                    <td><?php lang('lab_quotation_number'); ?>:</td>

                    <td>4</td>

                 </tr>

                 <tr>

                    <td><?php lang('lab_validity'); ?>:</td>

                    <td>

                      1<?php lang('lab_day_s'); ?>                    </td>

                 </tr>

                <tr>

                    <td><?php lang('lab_sales_person'); ?>:</td>

                    <td>                     </td>

                 </tr>

                 <tr>

                    <td><?php lang('lab_sales_person_contact'); ?>:</td>

                    <td></td>

                 </tr>

              </table>

            </div>

          </div>

        </div>

        <div class="row col-sm-12">

          <div class="col-sm-8"> 

           <p> <?php lang('lab_to'); ?>: <br> 

             <?php lang('lab_abc'); ?>  <br>

              <br>  

             <?php lang('lab_attn'); ?>: 24</p>

          </div>

        </div>

        <style>

        .table_bord{border:3px solid #000;}

        .table_bord td{border-left: 3px solid #000;}

        </style> 

          <table  id="invoice-payment-table" style="width:100%; height:auto;" class="table_bord display">

            <thead id="axcy" class="border_head">

              <tr>

                <th style="line-height: 2;"><?php lang('lab_no'); ?></th>

                <th style="text-align:center;"><?php lang('lab_description'); ?></th>

                <th style="text-align:center;"><?php lang('lab_quantity'); ?></th>

                <th style="text-align:center;"><?php lang('lab_unit_price'); ?></th>

                <th style="text-align:center;"><?php lang('lab_price'); ?></th>

              </tr>

            </thead>

            <tbody>

              <tr>

                <td class="row_style">1</td>

                <td class="row_info"><?php lang('lab_GT06E_GPS_trackers_Complete_Package'); ?></td>

                <td class="row_style">3</td>

                <td class="row_style">$499.00</td>

                <td class="row_style">$1497.00</td>

              </tr>

              <tr>

                <td class="row_style">2</td>

                <td class="row_info">24 <?php lang('lab_months_subscription_fee'); ?>   $12.00 / </td>

                 <td class="row_style">3</td>

                <td class="row_style">$768.00</td>

                <td class="row_style">$2304.00</td>

              </tr>

              <tr>

                <td class="row_style">3</td>

                <td class="row_info"><?php lang('lab_software_training_session'); ?> (0.5 <?php lang('lab_hours'); ?>)</td>

                <td></td>

                <td class="row_style"> *<?php lang('lab_included'); ?>* </td>

                <td class="row_style"> *<?php lang('lab_included'); ?>*                 </td>

              </tr>

              <tr>

                <td class="row_style">4</td>

                <td class="row_info"><?php lang('lab_hardware_installation'); ?> <br></td>

                <td class="row_style">3</td>

                <td class="row_style">$50.00</td>

                <td class="row_style">$150.00</td>

              </tr>

              <tr>

                <td class="row_style">5</td>

                <td class="row_info"><?php lang('lab_garmin_navigator_for_communication_with_control_centre'); ?> </td>

                 <td class="row_style">3</td>

                <td class="row_style">$350.00</td>

                <td class="row_style">$1050.00</td>

              </tr>

              <tr>

                <td class="row_style">6</td>

                <td class="row_info"><?php lang('lab_technical_support'); ?> </td>

                 <td class="row_style">3</td>

                <td class="row_style"> * <?php lang(); ?>waived * </td>

                <td class="row_style"> * <?php lang(); ?>waived * </td>

              </tr>

               

            </tbody>

            

                          <tr>

                <td class="row_style">3</td>

                <td class="row_info"><?php lang('lab_description'); ?></td>

                <td class="row_style">3</td>

                <td class="row_style">$0.00</td>

                <td class="row_style">5001.00</td>

              </tr>

                          <tr>

                <td class="row_style">4</td>

                <td class="row_info"><?php lang('lab_description'); ?></td>

                <td class="row_style">5</td>

                <td class="row_style">$0.00</td>

                <td class="row_style">5000.00</td>

              </tr>

                          <tr>

                <td class="row_style">5</td>

                <td class="row_info"><?php lang('lab_description'); ?></td>

                <td class="row_style">3</td>

                <td class="row_style">$0.00</td>

                <td class="row_style">5001.00</td>

              </tr>

              

            </tbody>

          </table>

          <table id="sum_table" style="border:3px solid #000;border-top:none; width:285px;height:50px;float:right;position:relative;">

            <tr>

              <td style="color:#000; font-size:16px;font-weight:bold;">&nbsp;&nbsp;&nbsp;<?php lang('lab_total'); ?></td>

              <td style="color:#000; font-size:16px;font-weight:bold;">&nbsp;&nbsp;&nbsp;$15002.00

              </td>

            </tr>

          </table>

          <p style="color:#000;"><?php lang('par_payments_made_by_crossed_cheque_to_Kayden_Pte_Ltd'); ?><br>

          <?php lang('par_all_prices_quoted_singapore_dollars'); ?></p>

          <div style="height:150px;background-color:white;" >

     <div class="col-sm-4" style="float:right; text-align: right;"> 

        <b style="color:#000;"><?php lang('lab_kayden_pte_Ltd'); ?>  </b><br>

        <img src="https://cdn.filestackcontent.com/v5arhdsjR6S34aE3xdLA" style="width:100px;height:70px;">

        <img src="https://cdn.filestackcontent.com/D2Ve9vatSzSzdqALoLr2" style="width:80px;height:80px;"><br>

        ______________________________

        <p style="margin-left:40px;"><?php lang('lab_authorized_signature'); ?></p>

       </div>

    </div>

    </div>

     

    </div> 

    </div>

    </div>

    </div>

    </div>

  </div>