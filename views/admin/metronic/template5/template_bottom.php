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
        <!-- BEGIN GLOBAL PLUGINS -->
		<script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/custom/js/metronic/pages/scripts/components-search_typeahead.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- // handle datatable -->
        <script src="<?php echo base_url(); ?>assets/custom/js/metronic/pages/scripts/barcode-components-script.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/custom/js/metronic/pages/scripts/barcode_scan-components-script.js" type="text/javascript"></script>
        <!-- END GLOBAL PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <?php echo @$page_level_plugins ?: ''; ?>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <?php echo @$page_level_scripts ?: ''; ?>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout5/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/metronic'); ?>/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
