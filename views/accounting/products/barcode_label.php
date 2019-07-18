<?php $controller =& get_instance(); 
$controller->load->model('product_model');
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body style="margin: 0px;" <?php echo (isset($print) && $print) ? 'onload="window.print();"' : ''; ?>>
<?php if(!empty($products_detail)) {
         foreach($products_detail as $key =>$value){
          if(!isset($value->product_name) || $value->product_name == '')
            continue;
          ?>
    <div style="width: 2in;height: .8in;word-wrap: break-word;overflow: hidden;margin:0 auto;text-align:center;font-size: 10pt;line-height: 1em;page-break-after: always;padding: 10px;">
        <?php echo isset($value->company_name) ? $value->company_name :''; ?><br>
        <?php echo '<img src="data:image/png;base64,' . base64_encode($barcode[$key]) . '">'; ?><br>
        <?php echo isset($value->barcode) ? $value->barcode :''; ?><br>
        <?php echo number_format($value->cost_price, 2); ?>: <?php echo $value->product_name; ?>
    </div>
<?php } } ?>
</body>
</html>

