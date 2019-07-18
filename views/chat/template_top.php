        <meta charset="utf-8" />
        <title>Admin Panel <?php echo @$this->page_details->title ? '| '.$this->page_details->title.' - '.@$this->webspace_details->name : (@$this->webspace_details->name ? '| '.@$this->webspace_details->name : ''); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for classic page head option" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES PLUGINS -->
		<?php echo @$page_level_styles_plugins ?: ''; ?>
        <!-- END PAGE LEVEL STYLES PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
		<?php echo @$page_level_styles ?: ''; ?>
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout/css/themes/grey.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <!-- BEGIN GLOBAL CUSTOM STYLES -->
		<link href="<?php echo base_url('assets/custom'); ?>/css/custom.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL CUSTOM STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />

        <script src="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
