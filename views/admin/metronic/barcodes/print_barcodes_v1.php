<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print();" style="padding-top:55px;">

        <?php if (! empty($barcodes))
        {
            foreach ($barcodes as $barcode => $options)
            { ?>

        <div style="text-align:center;padding-top:17px">
            <div style="display:inline-block;text-align:justify;margin:0 auto;">
                <svg class="barcode"
                    jsbarcode-format="upc"
                    jsbarcode-value="<?php echo $barcode; ?>"
                    jsbarcode-textmargin="0"
                    jsbarcode-width="1"
                    jsbarcode-height="40"
                    jsbarcode-fontoptions="bold">
                </svg>
                <div style="font-size:0.5em;padding:0 15px;margin-top:-5px">
                    <span style="float:right;">Size: <?php echo $options['size']; ?></span>
                    <?php echo $options['prod_no']; ?> <br />
                    <?php echo $options['color_name']; ?> <br />
                </div>
            </div>
        </div>

                <?php
            }
        } ?>

        <script src="<?php echo base_url(); ?>assets/custom/jscript/jsbarcode/jsbarcode.all.min.js" type="text/javascript"></script>
        <script>
            JsBarcode(".barcode").init();
        </script>

  </body>
</html>
