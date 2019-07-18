<style type="text/css">
</style>
<!-- style -->
<?php
$controller =& get_instance(); 
?>
<div class="row">
    <div class="col-sm-12 reports">
        <table class="table-box <?php echo (isset($is_print) && $is_print) ? '' : 'dataTables1'; ?>" >
                <thead>
                    <tr>
                      <?php if((isset($is_print) && $is_print)){ ?>
                        <th></th>
                        <?php } ?>
                        <?php if(isset($single_report) && $single_report): ?>
                          <th><?php lang('lab_date'); ?></th>
                          <th><?php lang('lab_time'); ?></th>
                          <th><?php lang('lab_voucher_type'); ?></th>
                          <th><?php lang('lab_voucher_no'); ?>.</th>
                        <?php else: ?>
                        <th><?php lang('lab_ledger_name'); ?></th>
                        <?php endif; ?>
                          <th><?php lang('lab_opening_balance'); ?></th>
                        <th><?php lang('lab_debit'); ?></th>
                        <th><?php lang('lab_credit'); ?></th>
                        <th><?php lang('lab_closing_balance'); ?></th>
                        <?php if(!isset($single_report)): ?>
                          <?php if(!isset($is_print)): ?>
                          <th><?php lang('lab_actions'); ?></th>
                        <?php endif; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                   <tbody>
                   <?php 
                    $total_debit = 0;
                    $total_credit = 0;
                    $total_closing = 0;
                   if(!empty($ledgerReorts)) { 
                    $sr_no=1;
                    foreach($ledgerReorts as $values){?>
                   		<tr>
                        <?php if((isset($is_print) && $is_print)){ ?>
                        <td></td>
                        <?php } ?>
                        <?php if(isset($single_report) && $single_report): ?>
                          <td><?php echo isset($values->date_time) ? date('M d Y', strtotime($values->date_time)) : ''; ?></td>
                          <td><?php echo isset($values->date_time) ? date('H:i A', strtotime($values->date_time)) : ''; ?></td>
                          <td><?php echo isset($values->voucherTypeName) ? $values->voucherTypeName : ''; ?></td>
                          <td><?php echo isset($values->voucherNo) ? $values->voucherNo : ''; ?></td>
                        <?php else: ?>
                   			<td>
                        <?php echo isset($values->ledgerName) ? $values->ledgerName :'';   ?>  
                        </td>
                        <?php endif; ?>
                     			<td>
                          <?php echo isset($values->Opening) ? price_value($values->Opening) :'';  ?>  
                          </td>
                   			<td>
                        <?php echo isset($values->debit1) ? price_value($values->debit1) :''; ?>  
                        </td>
                   			<td>
                          <?php echo isset($values->credit1) ? price_value($values->credit1) :''; ?>  
                        </td>
                   			<td>
                          <?php echo isset($values->closing) ? price_value($values->closing) :''; ?> 
                        </td>
                        <?php if(!isset($single_report)): 
                        $link = base_url('accounting/reports/accountLedgerReports/'.$values->accountGroupId.'/'.$values->id.'/');
                        if(isset($date_range) && $date_range != '') {
                          if($date_range == -30)
                            $link .= "last30Days";
                          else if($date_range == -15)
                            $link .= "last15Days";
                          else if($date_range == -7)
                            $link .= "lastWeek";
                          else if($date_range == '0')
                            $link .= "today";
                          else if($date_range == 'active_year')
                            $link .= "active_year";
                        } else {
                          if(isset($start))
                            $link .= $start."/";
                          if(isset($end))
                            $link .= $end;
                        }
                        ?>
                         <?php if(!isset($is_print)): ?>
                          <td><a href="<?php echo $link; ?>"><?php lang('btn_detail'); ?></a></td>
                        <?php endif; ?>
                        <?php endif; ?>
                   		</tr>
                    <?php
                    $total_credit += (float)$values->credit1;
                    $total_debit += (float)$values->debit1;
                    $total_closing += (float)$values->closing;
                     }
                     ?>
                     
                     <?php
                     } else { ?>
                    <tr><td colspan="6" style="text-align: center;"><?php lang('lab_no_found'); ?></td>
                    </tr>
                    <?php  } ?>
                    
                   </tbody>
                   <?php if(!isset($single_report) || !$single_report): ?>
                   <tfoot>
                     <tr>
                      <th colspan="1">Total</th>
                          <th></th>
                        <th><?php echo price_value($total_debit); ?></th>
                        <th><?php echo price_value($total_credit); ?></th>
                        <th><?php echo price_value($total_closing); ?></th>
                          <th></th>
                      </tr>
                   </tfoot>
                  <?php endif; ?>
        </table>
    </div>
                   
                    
                   
</div>
