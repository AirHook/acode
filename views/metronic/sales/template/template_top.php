        <meta charset="utf-8" />
		<title>
			<?php echo @$page_title ?: @$this->webspace_details->name.' | '.@$this->webspace_details->site_tagline; ?>
		</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="<?php echo @$page_description ?: @$this->webspace_details->site_description; ?>" />
		<meta name="keywords" content="<?php echo @$page_keywords ?: @$this->webspace_details->site_keywords; ?>" />
		<meta name="abstract" content="<?php echo @$page_description ?: @$this->webspace_details->site_description; ?>" />
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
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo base_url('assets/metronic'); ?>/assets/layouts/layout3/css/custom.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <!-- BEGIN GLOBAL CUSTOM STYLES -->
		<!-- DOC: Typehead used for auto complete of search box among others -->
		<link href="<?php echo base_url('assets/metronic'); ?>/assets/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/custom'); ?>/css/custom_sales_metronic.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/custom'); ?>/css/loading-modal.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL CUSTOM STYLES -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
