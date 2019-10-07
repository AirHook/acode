<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="//window.print();" style="padding-top:55px;">

        <?php if (! empty($barcodes))
        {
            foreach ($barcodes as $barcode => $options)
            {
                for ($i = 1; $i <= $options['qty']; $i++)
                { ?>

        <div style="text-align:center;padding-top:17px;">
            <div style="display:inline-block;text-align:justify;margin:0 auto;position:relative;">
                <p class="barcode-wrapper" style="display:inline-block;margin:0;">
                    <svg class="barcode" style="vertical-align:middle;"
                        jsbarcode-format="upc"
                        jsbarcode-value="<?php echo $barcode; ?>"
                        jsbarcode-textmargin="0"
                        jsbarcode-width="1"
                        jsbarcode-height="50"
                        jsbarcode-fontoptions="bold">
                    </svg>
                    <span style="font-size:0.6em;font-weight:550;padding-right:10px;display:inline-block;position:relative;top:9px;">
                        <?php echo $options['prod_no']; ?> <br />
                        <?php echo $options['color_name']; ?> <br />
                        Size: <?php echo $options['size']; ?>
                    </span>
                </p>
            </div>
        </div>

                    <?php
                }
            }
        } ?>

        <script src="<?php echo base_url(); ?>assets/custom/jscript/jsbarcode/jsbarcode.all.min.js" type="text/javascript"></script>
        <script>
            JsBarcode(".barcode").init();
        </script>

  </body>
</html>
