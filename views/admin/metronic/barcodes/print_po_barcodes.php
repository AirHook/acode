<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print();">

    <?php if ( ! empty($data))
    {
        foreach ($data as $item => $val)
        {
            foreach ($val as $key => $value)
            {
                if ($value['qty'] > 0)
                {
                    for ($i=0; $i < $value['qty']; $i++)
                    { ?>

                        <div style="text-align:center;padding-top:15px">
                            <div style="display:inline-block;text-align:justify;margin:0 auto;">
                                <img src="<?php echo base_url('assets/barcodes/').'product_barcode_temp_'.$key.'.png'; ?>" width="242px"/>
                                <div style="width:100%;font-size:10px;padding:0 10px;">
                                    <span style="float:right;">STOCK ID: <?php echo isset($value['st_id']) ? $value['st_id'] :''; ?></span>
                                    <span><?php echo isset($value['prod_no']) ? $value['prod_no'] :''; ?></span><br />
                                    <span><?php echo isset($value['color_name']) ? $value['color_name'] :''; ?></span><br />
                                    <span><?php echo isset($value['size']) ? 'SIZE '.$value['size'] :''; ?></span>
                                </div>
                            </div>
                        </div>

                            <?php
                        }
                    }
                }
            }
        }?>

    </body>
</html>
