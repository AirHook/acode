<style type="text/css">
    
    body{
        background: #fff;
    }
    table
</style>
<?php $controller=& get_instance();
    $controller->load->model('reports_model');
?>
<?php if(isset($payment_methods) && !empty($payment_methods)): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sales Analysis</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        foreach ($payment_methods as $method) {
            $total += (float)$method->payment;
            ?>
            <tr>
                <td><?php echo $method->total_invoices.'--'.$method->method_name; ?></td>
                <td><?php echo price_value($method->payment); ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Grand Total</th>
            <th><?php echo price_value($total); ?></th>
        </tr>
    </tfoot>
</table>
<!-- <table class="table table-bordered">
    <thead>
        <tr>
            <th>Other Stats</th>
            <th>Total</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Average Orders</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Items per Orders</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Average Price per Items</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table> -->
<?php endif; ?>
<?php if(isset($cashier_sales) && !empty($cashier_sales)): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sales by Staff</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        foreach ($cashier_sales as $method) {
            $total += (float)$method->total;
            ?>
            <tr>
                <td><?php echo $method->cashier.' ('.number_format($method->percentage, 2).'%)'; ?></td>
                <td><?php echo price_value($method->total); ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Grand Total</th>
            <th><?php echo price_value($total); ?></th>
        </tr>
    </tfoot>
</table>
<?php endif; ?>