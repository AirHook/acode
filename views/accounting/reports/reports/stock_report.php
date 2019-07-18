<?php

$controller =& get_instance(); 

?>

<hr style="border-color: DimGray;">

<?php if(!empty($stockReports)){?>

<div class="row">

    <div class="col-sm-12">

        <h2><?php lang('heading_reports_detail'); ?></h2>

        <br>

        <table class="table <?php echo (isset($is_print) && $is_print) ? '' : 'dataTables1'; ?>">

                <thead>

                    <tr>

                        <th><?php lang('lab_sr'); ?>.</th>

                        <th><?php lang('lab_product_name'); ?></th>

                        <th><?php lang('lab_unit_name'); ?></th>

                        <th><?php lang('lab_quantity'); ?></th>
                        <th><?php lang('lab_value'); ?></th>

                    </tr>

                </thead>

                <tfoot>

                    <tr>

                        <th colspan="4"></th>

                    </tr>

                </tfoot>

                   <tbody>

                   <?php 

                        $stockId=1;

                        foreach($stockReports as $values) { ?>

                        <tr>

                          <td>

                            <?php echo  $stockId++; ?>

                              

                          </td>

                          <td>

                            <?php echo isset($values->productName) ? $values->productName :''; ?>

                          </td>

                          <td>

                            <?php echo isset($values->unitName->UOMName) ? $values->unitName->UOMName :''; ?>

                          </td>

                          <td>

                            <?php 
                            echo isset($values->total) ? $values->total :''; 
                            if(isset($values->derived_units) && !empty($values->derived_units)) {
                              foreach ($values->derived_units as $unit) {
                                echo isset($unit->unit_name) ? ' ('.number_format(((int)$values->total/(int)$unit->base_qty), 2).' '.$unit->unit_name.')' : '';
                              }
                            }
                            ?>

                          </td>
                          <td>
                           <?php echo isset($values->amount) ? price_value($values->amount) :''; ?>
                          </td>

                        </tr>

                    <?php } ?>

                   </tbody>

                   

        </table>

    </div>

</div>

<?php } else {?>

<div class="alert alert-danger alert-dismissable">

  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

    <h3><?php lang('heading_no_reports_available_for_this_date'); ?></h3>

  

</div>

<?php } ?>