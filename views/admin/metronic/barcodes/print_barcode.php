<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print();">

        <?php if (isset($barcode))
        { ?>

        <div style="text-align:center;padding-top:15px">
            <div style="display:inline-block;text-align:justify;margin:0 auto;" data-max_st_id="<?php echo $this->upc_barcodes->max_st_id; ?>">
                <svg class="barcode"
                    jsbarcode-format="upc"
                    jsbarcode-value="<?php echo $barcode; ?>"
                    jsbarcode-textmargin="0"
                    jsbarcode-width="2"
                    jsbarcode-height="100"
                    jsbarcode-fontoptions="bold">
                </svg>
            </div>
        </div>


            <?php
        } ?>

        <script src="<?php echo base_url(); ?>assets/custom/jscript/jsbarcode/jsbarcode.all.min.js" type="text/javascript"></script>
        <script>
            JsBarcode(".barcode").init();
        </script>

  </body>
</html>
