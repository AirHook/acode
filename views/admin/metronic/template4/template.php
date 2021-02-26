<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_top'); ?>
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo" data-base_url="<?php echo base_url(); ?>" data-object_data='{"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}'>

        <?php if (@$show_loading)
        { ?>
        <!-- LOADING -->
		<div class="modal fade bs-modal-sm in" id="loading-start" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display:block;background:rgba(40,40,40,0.35);">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
						<h4 class="modal-title">Loading...</h4>
					</div>
					<div class="modal-body text-center">
						<p class="modal-body-text"></p>
						<i class="fa fa-spinner fa-spin fa-3x text-danger" aria-hidden="true" style="margin:35px 0;"></i>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
            <?php
        } ?>

        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_header_left'); ?>
                    <div class="menu-toggler sidebar-toggler hide">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler hide" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
                    <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_header_right'); ?>
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_sidebar'); ?>
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <!-- BEGIN PAGE TITLE -->
                        <div class="page-title">
                            <h1><?php echo $page_title; ?>
                                <small><?php echo $page_description; ?></small>
                            </h1>
                        </div>
                        <!-- END PAGE TITLE -->
                        <!-- BEGIN PAGE TOOLBAR -->
                        <div class="page-toolbar ">
                            <!-- BEGIN ACTION BUTTONS -->
                            <!-- END ACTION BUTTONS -->
                        </div>
                        <!-- END PAGE TOOLBAR -->
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                    <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_page_breadcrumb'); ?>
                    <ul class="page-breadcrumb breadcrumb hide">
                        <li>
                            <a href="<?php echo site_url($this->config->slash_item('admin_folder').'dashboard'); ?>">Dashborad</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="#">Blank Page</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Page Layouts</span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <?php
                    if (@$file)
                    {
                        $this->load->view($this->config->slash_item('admin_folder').'metronic/'.($file ?: 'dashboard'));
                    }
                    else
                    { ?>
                    <div class="note note-info">
                        <p> A black page template with a minimal dependency assets to use as a base for any custom page you create </p>
                    </div>
                        <?php
                    }
                    ?>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_footer'); ?>
        <!-- END FOOTER -->

        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_global_modals'); ?>
        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/template4/template_bottom'); ?>

    </body>

</html>
