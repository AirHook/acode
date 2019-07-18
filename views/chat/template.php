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
		<?php $this->load->view('chat/template_top'); ?>
	</head>
    <!-- END HEAD -->
	
	<!-- DOC: Apply "page-sidebar-closed" to start off with the sidebar menu collapsed -->
	<!-- DOC: Apply "page-sidebar-closed-hide-logo" to hide the logo on closed sidebar menu -->
	<!-- DOC: Apply "page-footer-fixed" to fixe footer at bottom -->
    <body class="page-sidebar-closed page-header-fixed page-sidebar-closed-hide-logo page-content-white page-footer-fixed">
        <div class="page-wrapper">
		
            <!-- BEGIN HEADER -->
			<?php $this->load->view('chat/template_header'); ?>
            <!-- END HEADER -->
			
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
		
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
			
                <!-- BEGIN SIDEBAR -->
				<?php $this->load->view('chat/template_sidebar'); ?>
                <!-- END SIDEBAR -->
			
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
						<?php $this->load->view('chat/template_theme_panel'); ?>
                        <!-- END THEME PANEL -->
						<?php $this->load->view('chat/template_page_header'); ?>
                        <!-- END PAGE HEADER-->

                        <!-- BEGIN BODY CONTENT-->
						<?php 
						if (@$file) 
						{
							$this->load->view('chat/'.$file);
						}
						else
						{ ?>
                        <div class="note note-info">
                            <p> A black page template with a minimal dependency assets to use as a base for any custom page you create </p>
                        </div>
							<?php
						}
						?>
                        <!-- END BODY CONTENT-->
						
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
				
                <!-- BEGIN QUICK SIDEBAR -->
				<?php $this->load->view('chat/template_quick_sidebar'); ?>
                <!-- END QUICK SIDEBAR -->
				
            </div>
            <!-- END CONTAINER -->
			
			
            <!-- BEGIN FOOTER -->
			<?php $this->load->view('chat/template_footer'); ?>
            <!-- END FOOTER -->
			
        </div>
		
        <!-- BEGIN QUICK NAV -->
		<?php $this->load->view('chat/template_quick_nav'); ?>
        <!-- END QUICK NAV -->
		
		<?php $this->load->view('chat/template_global_modals'); ?>
		<?php $this->load->view('chat/template_bottom'); ?>
		
    </body>

</html>
