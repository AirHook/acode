<?php
/***********
 * Top Pagination
 */
?>
<?php if ( ! @$search) { ?>
<div class="row margin-bottom-10">
    <div class="col-md-12 text-justify pull-right">
        <span style="<?php echo $count_all > 100 ? 'position:relative;top:15px;' : ''; ?>">
            Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all > 100 ? $limit * $page : $count_all; ?> of about <?php echo number_format($count_all); ?> records
        </span>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
<?php } ?>

<div class="table-scrollable" style="margin-top:0px!important;">
    <table id="table-inventory-size_mode-<?php echo $size_mode; ?><?php echo $inv_prefix == 'physical' ? '' : '-disabled-edit'; ?>" class="table table-bordered table-striped table-hover table-condensed inventory-<?php echo $inv_prefix; ?>">
        <thead>
            <tr>
                <th>#</th>
                <th>Prod NO</th>
                <th>Color Name</th>

                <?php
                foreach ($size_names as $size_label => $s)
                {
                    if ($s == 'XL1' OR $s == 'XL2') continue;
                    echo '<th class="size">Size '.$s.'</th>';
                }
                ?>

            </tr>
        </thead>
        <tbody>

            <?php
            if ($products)
            {
                foreach ($products as $product)
                {
                    if ($this->session->admin_id == '1' OR $this->session->admin_id == '2')
                    { ?>

            <tr>
                <td class="font-default" ><?php echo $product->st_id.'-'.$inv_prefix; ?></td>
                <td ><?php echo $product->prod_no; ?></td>
                <td ><?php echo $product->color_name; ?></td>

                        <?php
                        foreach ($size_names as $size_label => $s)
                        {
                            if ($s == 'XL1' OR $s == 'XL2') continue;
                            $exp = explode('_', $size_label);
                            $inv_size_label = ($inv_prefix == 'physical' ? 'size' : $inv_prefix).'_'.end($exp);
                            echo '<td>'.($product->$inv_size_label ?: 0).'</td>';
                        }
                        ?>

            </tr>
            <tr>
                <td class="" style="color:transparent;"><?php echo $product->st_id.'-a_'.$inv_prefix; ?></td>
                <td ></td>
                <td ></td>

                        <?php
                        foreach ($size_names as $size_label => $s)
                        {
                            if ($s == 'XL1' OR $s == 'XL2') continue;
                            $exp = explode('_', $size_label);
                            $inv_size_label = ($inv_prefix == 'available' ? 'admin' : 'admin_'.$inv_prefix).'_'.end($exp);
                            $admin_stock = $product->$inv_size_label ?: 0;
                            echo '<td class="admin-stocks '.($admin_stock ? 'font-red' : 'font-default').'">'.$admin_stock.'</td>';
                        }
                        ?>

            </tr>

                        <?php
                    }
                    else
                    { ?>

            <tr>
                <td class="font-default" ><?php echo $product->st_id.'-'.$inv_prefix; ?></td>
                <td><?php echo $product->prod_no; ?></td>
                <td><?php echo $product->color_name; ?></td>

                    <?php
                    foreach ($size_names as $size_label => $s)
                    {
                        if ($s == 'XL1' OR $s == 'XL2') continue;
                        $exp = explode('_', $size_label);
                        $inv_size_label = ($inv_prefix == 'physical' ? 'size' : $inv_prefix).'_'.end($exp);
                        echo '<td>'.($product->$inv_size_label ?: 0).'</td>';
                    }
                    ?>

            </tr>

                        <?php
                    }
                }
            }
            else
            { ?>

            <tr>
                <td colspan="14">
                    There are no products returned.
                </td>
            </tr>

                <?php
            } ?>

        </tbody>
    </table>
</div>

<?php
/***********
 * Bottom Pagination
 */
?>
<?php if ( ! @$search) { ?>
<div class="row margin-bottom-10">
    <div class="col-md-12 text-justify pull-right">
        <span>
            Showing <?php echo ($limit * $page) - ($limit - 1); ?> to <?php echo $count_all > 100 ? $limit * $page : $count_all; ?> of about <?php echo number_format($count_all); ?> records
        </span>
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
<?php } ?>

</form>
<!-- End FORM =======================================================================-->
<!-- END FORM-->
