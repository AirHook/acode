<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print();">

    <?php if (isset($barcode_code))
    {
        if ($qty > 0)
        {
            // for each quantity
            for ($i=0; $i < $qty; $i++)
            { ?>

                <div style="text-align:center;padding-top:15px">
                    <div style="display:inline-block;text-align:justify;margin:0 auto;">
                        <img src="<?php echo base_url('assets/barcodes/').$barcode_img; ?>" />
                        <div style="width:100%;font-size:10px;padding:0 10px;">
                            <span style="float:right;">STOCK ID: <?php echo isset($st_id) ? $st_id :''; ?></span>
                            <span><?php echo isset($prod_no) ? $prod_no :''; ?></span><br />
                            <span><?php echo isset($color_name) ? $color_name :''; ?></span><br />
                            <span><?php echo isset($size) ? 'SIZE '.$size :''; ?></span>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
    } ?>

    </body>
</html>
