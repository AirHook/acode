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
		<?php $this->load->view('metronic/template/template_top'); ?>
	</head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid" data-base_url="<?php echo base_url(); ?>">
        <div class="page-wrapper">

			<?php $this->load->view('metronic/template/template_global_modals_top'); ?>

            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">

                        <!-- BEGIN HEADER TOP -->
						<?php $this->load->view('metronic/template/template_header_top'); ?>
                        <!-- END HEADER TOP -->

                        <!-- BEGIN HEADER MENU -->
						<?php $this->load->view('metronic/template/template_header_menu'); ?>
                        <!-- END HEADER MENU -->

                    </div>
                    <!-- END HEADER -->
                </div>
            </div>

            <div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                    <!-- BEGIN CONTAINER -->
                    <div class="page-container">

                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->
                            <div class="page-head">
								<!-- DOC: change between class "container-fluid" and "container" for fluid or boxed layout -->
                                <div class="container">

                                    <!-- BEGIN PAGE TITLE -->
                                    <div class="page-title hide">
                                        <h1>Blank Page </h1>
                                    </div>
                                    <!-- END PAGE TITLE -->

                                    <!-- BEGIN PAGE TOOLBAR -->
									<?php $this->load->view('metronic/template/template_theme_panel'); ?>
                                    <!-- END PAGE TOOLBAR -->

                                </div>
                            </div>
                            <!-- END PAGE HEAD-->

                            <!-- BEGIN PAGE CONTENT BODY -->
							<?php $this->load->view('metronic/template/template_body'); ?>
                            <!-- END PAGE CONTENT BODY -->

                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->

                        <!-- BEGIN QUICK SIDEBAR -->
						<?php $this->load->view('metronic/template/template_quick_sidebar'); ?>
                        <!-- END QUICK SIDEBAR -->

                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>

            <div class="page-wrapper-row">
                <div class="page-wrapper-bottom">

                    <!-- BEGIN FOOTER -->
					<?php $this->load->view('metronic/template/template_footer'); ?>
                    <!-- END FOOTER -->

                </div>
            </div>
        </div>

        <!-- BEGIN QUICK NAV -->
		<?php $this->load->view('metronic/template/template_quick_nav'); ?>
        <!-- END QUICK NAV -->

		<?php $this->load->view('metronic/template/template_global_modals'); ?>
		<?php $this->load->view('metronic/template/template_bottom'); ?>

    </body>

</html>
