<?php $controller=& get_instance();?>
<!doctype html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="viewport" content="initial-scale=1.0"/>
      <title></title>
      <link href="<?php echo $controller->theme_css_path ?>css/bootstrap.min.css" rel="stylesheet">
</head>
  <body>
    
    <?php if(isset($barcode_code)){ ?>
      <div class="middle_form" style="padding-top: 50px !important;margin-left:20px !important">
          <div style="width: 2in;height: .8in;word-wrap: break-word;overflow: hidden;margin:0 auto;text-align:center;font-size: 9pt;line-height: 1em;page-break-after: always;padding: 10px;">
              <?php echo '<img src="data:image/png;base64,' . base64_encode($barcode_code) . '">'; ?><br>
              <?php echo isset($code) ? $code :''; ?>
              <br>
              <br>
          </div>
            <div class="row">
              <div class="col-sm-12 text-center">
                <a class="btn btn-info" href="<?php echo base_url('accounting/products/barcodesprint/').$code ?>">Print</a>
              </div>
            </div>
      </div>
    <?php } ?>
  </body>
<script src="<?php echo $controller->theme_js_path ?>js/jquery-2.1.1.js"></script>
<script src="<?php echo $controller->theme_js_path ?>js/bootstrap.min.js"></script>
<script type="text/javascript">
  function printPage(url = null, data=null) {
    if(url != null) {
        $.ajax({
            url: url,
            data: data,
            type: 'GET',
            success: function(response) {
                var originalContents = document.body.innerHTML;
                window.document.body.innerHTML = response;
                setTimeout(function() {
                    window.print();
                    setTimeout(function() {
                        document.body.innerHTML = originalContents; 
                        window.location.reload();
                    }, 300);
                }, 500);
            }
        })
    }
}
</script>
<?php $print_product_barcode = $this->session->flashdata('print_product_barcode');
if(isset($print_product_barcode) && $print_product_barcode != null) { ?>
<script type="text/javascript">
    var url = '<?php echo base_url("accounting/products/printbarcode/".$print_product_barcode); ?>';
    // alert(url);
    printPage(url);
</script>
<?php }?>
</html>