<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title> Sales User Login </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Sales Program Login Page" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN : LOGIN PAGE 5-2 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 login-container bs-reset">
                    <!--<img class="login-logo login-6" src="<?php echo base_url('assets/metronic'); ?>/assets/pages/img/login/login-invert.png" />
                    <img class="login-logo login-6" src="<?php echo base_url(); ?>assets/images/logo/logo-<?php echo $this->webspace_details->slug; ?>.png" style="width:80%;" />-->
                    <div class="login-content" style="margin-top:20%;">
                        <h1> Sales Program Login </h1>
                        <p style="color:black;">
                            1: SEND PRODUCT OFFERS TO YOUR STORES AUTOMATICALLY <br />
                            2: SEND SPECIAL CLEARANCE OFFERS TO YOUR STORE BUYERS <br />
                            3: CREATE A SALES ORDER FROM INVENTORY AND SEND TO SHIPPING <br />
                            4: CREATE PURCHASE ORDERS AND SEND TO FACTORY TO MAKE <br />
                            5: SEND NEW ARRIVALS PRODUCT OFFERS TO YOUR CUSTOMER <br />
                            6: ADD WHOLESALE BUYERS TO YOUR CUSTOMER LIST <br />
                        </p>

						<!--bof form===========================================================================-->
						<?php
						// --------------------------------------
						// Login area
						echo form_open('resource', array('class'=>'login-form'));
						echo form_hidden('site_slug', $this->webspace_details->slug);
						?>

							<?php
							/**********
							 * Notification Area
							 */
							?>
                            <div class="notification">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button>
                                    <span>Enter any username and password. </span>
                                </div>
    							<?php if ($this->session->flashdata('success') == 'recovery_password_email_sent') { ?>
                                <div class="alert alert-metronics auto-remove" style="background-color:#ccc;border-color:#ccc;color:black;">
                                    <button class="close" data-close="alert"></button>
                                    <span> Recovery password email sent. </span>
    							</div>
    							<?php } ?>
    							<?php if ($this->session->flashdata('error') == 'invalid_credentials') { ?>
    							<div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button>
                                    <span> Invalid credetials. Please try again. </span>
    							</div>
    							<?php } ?>
    							<?php if ($this->session->flashdata('error') == 'incorrect_site') { ?>
    							<div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button>
                                    <span> Invalid login site. Please try again. </span>
    							</div>
    							<?php } ?>
    							<?php if ($this->session->flashdata('error') == 'unauthenticated') { ?>
    							<div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button>
                                    <span> You must be logged in to access page. </span>
    							</div>
    							<?php } ?>
    							<?php if ($this->session->flashdata('error') == 'time_lapse') { ?>
    							<div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button>
                                    <span> You have been idle for some time now. Please login again. </span>
    							</div>
    							<?php } ?>
    							<?php if ($this->session->flashdata('error') == 'no_id_passed') { ?>
    							<div class="alert alert-danger auto-remove">
                                    <button class="close" data-close="alert"></button>
                                    <span> An error occured in the authentication process. Please try again. </span>
    							</div>
    							<?php } ?>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Username" name="username" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password" required/> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="rememberme mt-checkbox mt-checkbox-outline hide">
                                        <input type="checkbox" name="remember" value="1" /> Remember me
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-sm-8 text-right">
                                    <div class="forgot-password">
                                        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                                    </div>
                                    <button class="btn dark" type="submit">Sign In</button>
                                </div>
                            </div>

                        </form>
						<!--eof form===========================================================================-->

                        <!-- BEGIN FORGOT PASSWORD FORM -->
						<!--bof form===========================================================================-->
						<?php
						// --------------------------------------
						// Login area
						echo form_open('resource/forget_password', array('class'=>'forget-form'));
						echo form_hidden('site_referrer', ($this->webspace_details->site ?: $this->config->item('site_domain')));
						?>

							<h3>Forgot Password ?</h3>
                            <p> Enter your e-mail address below to request to reset your password. </p>
                            <div class="form-group">
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Name" name="username" /> </div>
                            <div class="form-group">
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                            <div class="form-group">
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Phone" name="telephone" /> </div>
                            <div class="form-actions">
                                <button type="button" id="back-btn" class="btn dark btn-outline">Back</button>
                                <button type="submit" class="btn dark uppercase pull-right">Submit</button>
                            </div>

                        </form>
						<!--eof form===========================================================================-->
                        <!-- END FORGOT PASSWORD FORM -->
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset">
                                <ul class="login-social hide">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-social-dribbble"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p> &reg; POWERED BY RC PIXEL <?php echo @date('Y', time()); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 bs-reset">
                    <div class="login-bg" data-base_url="<?php echo base_url('assets/metronic'); ?>"> </div>
                </div>
            </div>
        </div>
        <!-- END : LOGIN PAGE 5-2 -->
        <!--[if lt IE 9]>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/excanvas.min.js"></script>
<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/pages/scripts/login-5.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
			<?php
			/*********
			 * An auto remove script for those notices, growls, etc...
			 */
			?>
			window.setTimeout(function() {
				$(".auto-remove").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 7000);
        </script>
    </body>

</html>
