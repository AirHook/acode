<!DOCTYPE html>

<html>



<!-- register.html 13:42:26 GMT -->

<head>



    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <!-- Page title -->

    <title>Accounting ERP</title>



    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->



    <!-- Vendor styles -->

    <link rel="stylesheet" href="<?php echo base_url()?>assets/erp/basic_theme/vendor/fontawesome/css/font-awesome.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/erp/basic_theme/vendor/metisMenu/dist/metisMenu.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/erp/basic_theme/vendor/animate.css/animate.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/erp/basic_theme/vendor/bootstrap/dist/css/bootstrap.css" />



    <!-- App styles -->

    <link rel="stylesheet" href="<?php echo base_url()?>assets/erp/basic_theme/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/erp/basic_theme/fonts/pe-icon-7-stroke/css/helper.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/erp/basic_theme/styles/style.css">



</head>

<body class="blank">



<!-- Simple splash screen-->

<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1><?php lang('lab_admin_theme'); ?></h1><p><?php lang('par_spacial_admin_theme_intro'); ?> </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>

<!--[if lt IE 7]>

<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>

<![endif]-->



<!-- <div class="color-line"></div> -->

<!-- <div class="back-link">

    <a href="index.html" class="btn btn-primary">Back to Dashboard</a>

</div> -->

<div class="register-container">

    <div class="row">

        <div class="col-md-12">

            <div class="text-center m-b-md">

                <h3><?php lang('heading_registration'); ?></h3>

                <!-- <small>Full suported AngularJS WebApp/Admin template with very clean and aesthetic style prepared for your next app. </small> -->

            </div>

        <?php $controller=& get_instance();

          $controller->showFlash();

         ?>

            <div class="hpanel">

                <div class="panel-body">

                        <form action="<?php echo base_url('accounting/auth/signup') ?>" id="loginForm" method="POST">
                            <input type="hidden" name="<?php echo $controller->security->get_csrf_token_name();?>" value="<?php echo $controller->security->get_csrf_hash();?>" />
                            <div class="row">

                            <div class="form-group col-lg-6">

                                <label><?php lang('lab_fname'); ?></label>

                                <input type="text" placeholder="<?php lang('lab_fname'); ?>" value="" id="" class="form-control" name="first_name" required="">

                            </div>

                            <div class="form-group col-lg-6">

                                <label><?php lang('lab_lname'); ?></label>

                                <input type="text" value="" id="" class="form-control" name="last_name" placeholder="<?php lang('lab_lname'); ?>" required="">

                            </div>

                            <div class="form-group col-lg-6">

                                <label><?php lang('lab_email_address'); ?></label>

                                <input type="email" value="" id="" placeholder="<?php lang('lab_email_address'); ?>" class="form-control" name="email" required="">

                            </div>

                            <div class="form-group col-lg-6">

                                <label><?php lang('lab_password'); ?></label>

                                <input type="password" value="" id="" placeholder="<?php lang('lab_password'); ?>" class="form-control" name="password" required="">

                            </div>

                            <div class="form-group col-lg-6">

                                <label><?php lang('lab_company_name'); ?></label>

                                <input type="text" value="" id="" placeholder="<?php lang('lab_company_name'); ?>" class="form-control" name="company_name" required="">

                            </div>

                            <div class="form-group col-lg-6">

                                <label><?php lang('lab_company_address'); ?></label>

                                <textarea  class="form-control" name="company_address" required=""></textarea>

                                

                            </div>

                            <!-- <div class="form-group col-lg-6">

                                <label>Repeat Email Address</label>

                                <input type="" value="" id="" class="form-control" name="">

                            </div>

                            <div class="checkbox col-lg-12">

                                <input type="checkbox" class="i-checks" checked>

                                Sigh up for our newsletter

                            </div> -->

                            </div>

                            <div class="text-center">

                                <button type="submit" name="submit" class="btn btn-success"><?php lang('register'); ?></button>

                                <a href="<?php echo base_url('accounting/auth') ?>" class="btn btn-default"><?php lang('cancel'); ?></a>

                            </div>

                        </form>

                </div>

            </div>

        </div>

    </div>

    <!-- <div class="row">

        <div class="col-md-12 text-center">

            <strong>HOMER</strong> - AngularJS Responsive WebApp <br/> 2015 Copyright Company Name

        </div>

    </div> -->

</div>



<!-- Vendor scripts -->

<script src="<?php echo base_url()?>assets/erp/basic_theme/vendor/jquery/dist/jquery.min.js"></script>

<script src="<?php echo base_url()?>assets/erp/basic_theme/vendor/jquery-ui/jquery-ui.min.js"></script>

<script src="<?php echo base_url()?>assets/erp/basic_theme/vendor/slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url()?>assets/erp/basic_theme/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url()?>assets/erp/basic_theme/vendor/metisMenu/dist/metisMenu.min.js"></script>

<script src="<?php echo base_url()?>assets/erp/basic_theme/vendor/iCheck/icheck.min.js"></script>

<script src="<?php echo base_url()?>assets/erp/basic_theme/vendor/sparkline/index.js"></script>



<!-- App scripts -->

<script src="<?php echo base_url()?>assets/basic_theme/scripts/homer.js"></script>



</body>



<!-- register.html 13:42:26 GMT -->

</html>