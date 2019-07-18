<style type="text/css">
    
    body{
        background: #fff;
    }
</style>
<?php $controller=& get_instance();
    $controller->load->model('reports_model');
?>
<div class="">
    <table class="table-box dataTables1">
        <thead>
                <tr>
                    <th><?php lang('date_time'); ?></th>
                    <th><?php lang('voucher_type'); ?>.</th>
                    <th><?php lang('voucher_number'); ?></th>
                    <th><?php lang('user'); ?></th>
                    <th><?php lang('debit_stock'); ?></th>
                    <th><?php lang('credit_stock'); ?></th>
                    <th><?php lang('balance'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $balance = 0;
                if(isset($product_detail->id)) {
                    $balance += (int)$product_detail->opening_stock_qty;
                }
                ?>
                <tr>
                    <td><?php echo isset($product_detail->created_on) ? date('M d Y H:i A', strtotime($product_detail->created_on)) : ''; ?></td>
                    <td>Opening Stock</td>
                    <td></td>
                    <td><?php echo isset($product_detail->user_name) ? $product_detail->user_name : ''; ?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $balance; ?></td>
                </tr>
                <?php
                if(isset($ledgerReorts) && !empty($ledgerReorts)) {
                    foreach ($ledgerReorts as $row) {
                        $balance += (int)$row->debit;
                        $balance -= (int)$row->credit;
                        ?>
                        <tr>
                            <td><?php echo isset($row->created_on) ? date('M d Y h:i A', strtotime($row->created_on)) : ''; ?></td>
                            <td><?php echo $row->voucher_type ?></td>
                            <td><?php echo $row->voucher_no ?></td>
                            <td><?php echo $row->user_name ?></td>
                            <td><?php echo $row->debit ?></td>
                            <td><?php echo $row->credit ?></td>
                            <td><?php echo $balance ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
            </table>
        </div>
    </div>
</div>