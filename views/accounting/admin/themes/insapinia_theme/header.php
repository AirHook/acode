<?php $controller =& get_instance(); ?>

<!DOCTYPE html>

<html>



<head>



    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <title>Accounting ERP <?php echo isset($page_title) ? '| '.$page_title : ''; ?></title>



    <link href="<?php echo $controller->theme_css_path ?>css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $controller->theme_css_path ?>font-awesome/css/font-awesome.css" rel="stylesheet">



    <!-- Toastr style -->

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- Gritter -->

    <link href="<?php echo $controller->theme_css_path ?>js/plugins/gritter/jquery.gritter.css" rel="stylesheet">



    <link href="<?php echo $controller->theme_css_path ?>css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

    

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    

    <link href="<?php echo $controller->theme_css_path ?>css/animate.css" rel="stylesheet">

    <link href="<?php echo $controller->theme_css_path; ?>css/style.css" rel="stylesheet">



    <link href="<?php echo $controller->theme_css_path ?>css/plugins/switchery/switchery.css" rel="stylesheet">

    <!-- Summernote -->

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/summernote/summernote.css" rel="stylesheet">

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">



    <link href="<?php echo $controller->theme_css_path ?>css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

    

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/select2/select2.min.css" rel="stylesheet">



    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/south-street/jquery-ui.css" rel="stylesheet"> 

     



    <!-- Sweet Alert -->

    <link href="<?php echo $controller->theme_css_path ?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    
    <?php if(isset($is_print) && $is_print): ?>
        <style type="text/css">
            .ibox-content {
                border: none;
            }
            table.summary_table {
                width: 100%;
            }
            table.summary_table>tr>td {
                width: 50%;
            }
                            
            
        </style>
    <?php endif; ?>
    

    <?php

    if(isset($resources['css']) && !empty($resources['css'])) {

        foreach ($resources['css'] as $key => $value) {

            echo '<link href="'.$value.'" rel="stylesheet">';

        }

    }

    ?>

</head>

<?php

if(isset($full_view) && $full_view === true)

    echo '<body class="mini-navbar">';

else if(isset($print) && $print === true)

    echo '<body onload="print();">';

else {
    ?><body <?php echo (isset($is_print) && $is_print) ? 'style="background-color: #fff;" onload="window.print();"' : ''; ?>><?php
}

?>
<script type="text/javascript">
    var sale_type = null;
</script>
    <div id="wrapper" >
    <?php if(isset($is_print) && $is_print): ?>
        <div  class="">

         <div class="">
    <?php endif; ?>

<?php if(isset($is_invoice) && $is_invoice) { ?>
<script type="text/javascript">
    sale_type = 'invoice';
</script>
<?php } ?>