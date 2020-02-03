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
    <table id="table-inventory-size_mode-<?php echo $size_mode; ?>" class="table table-bordered table-striped table-hover table-condensed inventory-physical">
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
                { ?>

            <tr>
                <td class="font-default"><?php echo $product->st_id; ?></td>
                <td><?php echo $product->prod_no; ?></td>
                <td><?php echo $product->color_name; ?></td>

                    <?php
                    foreach ($size_names as $size_label => $s)
                    {
                        if ($s == 'XL1' OR $s == 'XL2') continue;
                        $exp = explode('_', $size_label);
                        $inv_size_label = ($inv_prefix == 'available' ? 'size' : $inv_prefix).'_'.end($exp);
                        echo '<td>'.$product->$inv_size_label.'</td>';
                    }
                    ?>

            </tr>

                    <?php
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
