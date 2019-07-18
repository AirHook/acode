<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->

    <!-- BEGIN HEAD -->
    <head>
		<?php //$this->load->view('metronic/sales/template/template_google_site_tags'); ?>
		<?php $this->load->view('metronic/sales/template/template_top'); ?>
	</head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-menu-fixed" data-base_url="<?php echo base_url(); ?>">
        <div class="page-wrapper">

			<?php $this->load->view('metronic/sales/template/template_global_modals_top'); ?>

			<!-- BEGIN HEADER WRAPPER ROW -->
            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">

                        <!-- BEGIN HEADER TOP -->
						<?php $this->load->view('metronic/sales/template/template_header_top'); ?>
                        <!-- END HEADER TOP -->

                        <!-- BEGIN HEADER MENU -->
						<?php
                        // removing header which not needed on sales resource
                        //$this->load->view('metronic/sales/template/template_header_menu');
                        ?>
                        <!-- END HEADER MENU -->

                    </div>
                    <!-- END HEADER -->
                </div>
            </div>
			<!-- END HEADER WRAPPER ROW -->

			<!-- BEGIN BODY WRAPPER ROW -->
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
                                <div class="container-fluid">

                                    <!-- BEGIN PAGE TITLE -->
									<!-- DOC: remove class "hide" to enable div --
                                    <div class="page-title hide">
                                        <h1>Blank Page </h1>
                                    </div>
                                    <!-- END PAGE TITLE -->

                                    <!-- BEGIN PAGE TOOLBAR -->
									<?php
                                    // not used...
                                    //$this->load->view('metronic/sales/template/template_theme_panel');
                                    ?>
                                    <!-- END PAGE TOOLBAR -->

                                </div>
                            </div>
                            <!-- END PAGE HEAD-->

                            <!-- BEGIN PAGE CONTENT BODY -->
							<?php $this->load->view('metronic/sales/template/template_body'); ?>
                            <!-- END PAGE CONTENT BODY -->

                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->

                        <!-- BEGIN QUICK SIDEBAR -->
						<?php
                        // not used...
                        //$this->load->view('metronic/sales/template/template_quick_sidebar');
                        ?>
                        <!-- END QUICK SIDEBAR -->

                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>
			<!-- END BODY WRAPPER ROW -->

			<!-- BEGIN FOOTER WRAPPER ROW -->
            <div class="page-wrapper-row">
                <div class="page-wrapper-bottom">

                    <!-- BEGIN FOOTER -->
					<?php $this->load->view('metronic/sales/template/template_footer'); ?>
                    <!-- END FOOTER -->

                </div>
            </div>
			<!-- END FOOTER WRAPPER ROW -->

        </div>

        <!-- BEGIN QUICK NAV -->
		<?php $this->load->view('metronic/sales/template/template_quick_nav'); ?>
        <!-- END QUICK NAV -->

		<?php $this->load->view('metronic/sales/template/template_global_modals'); ?>
		<?php $this->load->view('metronic/sales/template/template_bottom'); ?>

    </body>

</html>
