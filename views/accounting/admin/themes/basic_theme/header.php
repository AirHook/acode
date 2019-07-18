<!DOCTYPE html>

<html>



<head>

    <base href="<?php echo base_url('accounting/'); ?>">

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <!-- Page title -->

    <title>Accounting ERP</title>



    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->



    <!-- Vendor styles -->

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/fontawesome/css/font-awesome.css" />

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/metisMenu/dist/metisMenu.css" />

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/animate.css/animate.css" />

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/bootstrap/dist/css/bootstrap.css" />

    

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />



    <!-- App styles -->

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>fonts/pe-icon-7-stroke/css/helper.css" />

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>styles/style.css">

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/datatables.net-bs/css/dataTables.bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/sweetalert/lib/sweet-alert.css">



    <!-- select2 -->

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/select2-3.5.2/select2.css">

    <link rel="stylesheet" href="<?php echo $this->theme_css_path ?>vendor/select2-bootstrap/select2-bootstrap.css">

     <link href="<?php echo $this->theme_css_path ?>modals/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo $this->theme_css_path ?>modals/css/style.css" rel="stylesheet">



    <?php

    if(isset($resources['css']) && !empty($resources['css'])) {

        foreach ($resources['css'] as $key => $value) {

            echo '<link href="'.$value.'" rel="stylesheet">';

        }

    }

    ?>

</head>

<body class="fixed-navbar sidebar-scroll" <?php echo (isset($print_view) && $print_view) ? 'onload="window.print();"' : ''; ?> ng-app="myApp">