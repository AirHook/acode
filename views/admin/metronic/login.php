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
        <title>Admin Panel <?php echo @$this->page_details->title ? '| '.$this->page_details->title.' - '.@$this->webspace_details->name : (@$this->webspace_details->name ? '| '.@$this->webspace_details->name : ''); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for " name="description" />
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
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/pages/css/login-4.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
				<?php if (@$this->webspace_details->options['logo']) { ?>
                <img src="<?php echo $this->webspace_details->options['logo']; ?>" alt="" /> </a>
				<?php } else { ?>
                <img src="<?php echo base_url('assets/metronic'); ?>/assets/pages/img/logo-big.png" alt="" /> </a>
				<?php } ?>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
			<!-- BEGIN FORM-->
			<!-- FORM =======================================================================-->
			<?php echo form_open($this->config->slash_item('admin_folder').'login/validate', array('class'=>'login-form')); ?>

				<h3 class="form-title">Login</h3>
				<?php if ($this->session->flashdata('invalid')) { ?>
                <div class="alert alert-danger auto-remove">
                    <button class="close" data-close="alert"></button>
                    <span> Invalid credentials. Please try again. </span>
                </div>
				<?php } ?>
				<?php if ($this->session->flashdata('invalid_email')) { ?>
                <div class="alert alert-danger auto-remove">
                    <button class="close" data-close="alert"></button>
                    <span> You have entered an inalid Email address. </span>
                </div>
				<?php } ?>
				<?php if ($this->session->flashdata('login_info')) { ?>
                <div class="alert alert-danger auto-remove">
                    <button class="close" data-close="alert"></button>
                    <span> You must be logged in to access page. </span>
                </div>
				<?php } ?>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" value="<?php echo $this->session->userdata('remember-at-admin') ? $this->session->userdata('remember-at-admin-username') : ''; ?>" <?php echo $this->session->userdata('remember-at-admin') ? '' : 'autofocus'; ?> /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" <?php echo $this->session->userdata('remember-at-admin') ? 'autofocus' : ''; ?> /> </div>
                </div>
                <div class="form-actions">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember-at-admin" value="1" <?php echo $this->session->userdata('remember-at-admin'); ?> /> Remember me
                        <span></span>
                    </label>
                    <button type="submit" class="btn green pull-right"> Login </button>
                </div>
				<!-- DOC: Remove "hide" class to enable other login options -->
                <div class="login-options hide">
                    <h4>Or login with</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="facebook" data-original-title="facebook" href="javascript:;"> </a>
                        </li>
                        <li>
                            <a class="twitter" data-original-title="Twitter" href="javascript:;"> </a>
                        </li>
                        <li>
                            <a class="googleplus" data-original-title="Goole Plus" href="javascript:;"> </a>
                        </li>
                        <li>
                            <a class="linkedin" data-original-title="Linkedin" href="javascript:;"> </a>
                        </li>
                    </ul>
                </div>
                <div class="forget-password">
                    <h4>Forgot your password ?</h4>
                    <p> no worries, click
                        <a href="javascript:;" id="forget-password"> here </a> to reset your password. </p>
                </div>
                <div class="create-account">
                    <p> Don't have an account yet ?&nbsp;
                        <a href="javascript:;" id="register-btn"> Create an account </a>
                    </p>
                </div>
                <div class="create-account">
                    <p> 
                        <a href="<?php echo site_url(); ?>" id="back-to-main-site-btn"> &laquo; Back to Main Site </a>
                    </p>
                </div>
            </form>
			<!-- End FORM ===================================================================-->
			<!-- END FORM-->
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
			<!-- BEGIN FORM-->
			<!-- FORM =======================================================================-->
			<?php echo form_open($this->config->slash_item('admin_folder').'login/forget_password', array('class'=>'forget-form')); ?>
                <h3>Forget Password ?</h3>
				<p>
				Hi Joe,<br />
				Forget password is not available at this time.
				Please contact your webguy further on this matter.
				</p>
                <p class="hide"> Enter your e-mail address below to reset your password. </p>
                <div class="form-group hide">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn red btn-outline">Back </button>
                    <button type="submit" class="btn green pull-right hide"> Submit </button>
                </div>
            </form>
			<!-- End FORM ===================================================================-->
			<!-- END FORM-->
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
			<!-- BEGIN FORM-->
			<!-- FORM =======================================================================-->
			<?php echo form_open($this->config->slash_item('admin_folder').'login/register', array('class'=>'register-form')); ?>
                <h3>Sign Up</h3>
				<p>
				Hi Joe,<br />
				Sign up is not available at this time.
				Please contact your webguy further on this matter.
				</p>
                <p class="hide"> Enter your personal details below: </p>
				<div class="hide">
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                    <div class="input-icon">
                        <i class="fa fa-font"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="fullname" /> </div>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Address</label>
                    <div class="input-icon">
                        <i class="fa fa-check"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">City/Town</label>
                    <div class="input-icon">
                        <i class="fa fa-location-arrow"></i>
                        <input class="form-control placeholder-no-fix" type="text" placeholder="City/Town" name="city" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">State</label>
                    <select name="state" id="state_list" class="select2 form-control">
                        <option value=""></option>
						<?php foreach (list_states() as $state) { ?>
						<option value="<?php echo $state->abb; ?>"><?php echo $state->state_name; ?></option>
						<?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Country</label>
                    <select name="country" id="country_list" class="select2 form-control">
                        <option value=""></option>
						<?php foreach (list_countries() as $country) { ?>
						<option value="<?php echo $country->countries_iso_code_2; ?>"><?php echo $country->countries_name; ?></option>
						<?php } ?>
                    </select>
                </div>
                <p> Enter your account details below: </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                    <div class="controls">
                        <div class="input-icon">
                            <i class="fa fa-check"></i>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" /> I agree to the
                        <a href="javascript:;">Terms of Service </a> &amp;
                        <a href="javascript:;">Privacy Policy </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
				</div>
                <div class="form-actions">
                    <button id="register-back-btn" type="button" class="btn red btn-outline"> Back </button>
                    <button type="submit" id="register-submit-btn" class="btn green pull-right hide"> Sign Up </button>
                </div>
            </form>
			<!-- End FORM ===================================================================-->
			<!-- END FORM-->
            <!-- END REGISTRATION FORM -->
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright"> <?php echo @date('Y', @time()); ?> &copy; <?php echo $this->webspace_details->name ?: 'Rcpixel'; ?> Admin Panel. </div>
        <!-- END COPYRIGHT -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
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
        <script src="<?php echo base_url('assets/custom'); ?>/js/metronic/login-4.js" type="text/javascript"></script>
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