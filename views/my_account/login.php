<!DOCTYPE html>
<html>

<!-- login.html 13:37:39 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>My Account</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/my-account/basic_theme/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/my-account/basic_theme/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/my-account/basic_theme/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/my-account/basic_theme/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/my-account/basic_theme/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/my-account/basic_theme/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/my-account/basic_theme/styles/style.css">

</head>
<body class="blank">

<!-- Simple splash screen-->
<!-- <div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>ELoERP</h1><p>Community Edition </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div> -->
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- <div class="color-line"></div> -->

<!-- <div class="back-link">
    <a href="index.html" class="btn btn-primary">Back to Dashboard</a>
</div> -->

<div class="login-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="text-center m-b-md">
                <h3>Please Login</h3>
                
            </div>
            <?php 
                $ci=& get_instance();
                 $ci->showFlash();
             ?>
            <div class="hpanel">
                <div class="panel-body">
                    <form action="<?php echo base_url('my_account/auth') ?>" id="loginForm" method="POST">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="form-group">
                            <label class="control-label" for="username">Username</label>
                            <input type="text" placeholder="example@gmail.com" title="Please enter you username" required="" value="" name="email" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password</label>
                            <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" class="i-checks">
                                 Remember login
                        </div> 
                        <button type="submit" name="submit" class="btn btn-success btn-block">Login</button>
                    </form>
                </div>
            </div>
            <div class="row">
                 <div class="col-sm-6">
                     <!-- <a href="#" class="btn btn-info">Register as new user</a> -->
                 </div>
                 <div class="col-sm-6">
                     <a style="margin-left:49px" href="<?php echo base_url('/') ?>" class="btn btn-primary">Back to Shop7 site</a>
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
<script src="<?php echo base_url()?>assets/my-account/basic_theme/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/my-account/basic_theme/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url()?>assets/my-account/basic_theme/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url()?>assets/my-account/basic_theme/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/my-account/basic_theme/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url()?>assets/my-account/basic_theme/vendor/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url()?>assets/my-account/basic_theme/vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="<?php echo base_url()?>assets/my-account/basic_theme/scripts/homer.js"></script>

</body>

<!-- login.html 13:37:39 GMT -->
</html>