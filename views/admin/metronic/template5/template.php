<?php
$template = 'template5';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/'.$template.'/template_top'); ?>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo" data-base_url="<?php echo base_url(); ?>">

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

        <!-- BEGIN CONTAINER -->
        <div class="wrapper">
            <!-- BEGIN HEADER -->
            <header class="page-header">
                <nav class="navbar mega-menu" role="navigation">
                    <div class="container-fluid">
                        <div class="clearfix navbar-fixed-top">
                            <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/'.$template.'/template_header_top'); ?>
                        </div>
                        <!-- BEGIN HEADER MENU -->
                        <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse">
                            <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/'.$template.'/template_header_navbar'); ?>
                        </div>
                        <!-- END HEADER MENU -->
                    </div>
                    <!--/container-->
                </nav>
            </header>
            <!-- END HEADER -->
            <div class="container-fluid">
                <div class="page-content <?php echo @$file; ?>">
                    <!-- BEGIN BREADCRUMBS -->
                    <div class="breadcrumbs">
                        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/'.$template.'/template_page_title_bar'); ?>
                    </div>
                    <!-- END BREADCRUMBS -->
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
                <!-- BEGIN FOOTER -->
                <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/'.$template.'/template_footer'); ?>
                <!-- END FOOTER -->
            </div>
        </div>
        <!-- END CONTAINER -->

        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/'.$template.'/template_global_modals'); ?>
        <?php $this->load->view($this->config->slash_item('admin_folder').'metronic/'.$template.'/template_bottom'); ?>

    </body>

</html>
