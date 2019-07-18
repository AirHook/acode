<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $this->config->item('site_name'); ?></title>

	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('roden_assets'); ?>/css/base/base.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('roden_assets'); ?>/css/base/layout.css" />
</head>
<body class="l-error-404">
	<div id="wrap">
		<div class="logo error-404-logo" style="padding:60px 0px 60px 0px;">
			<a href="/" accesskey="1">
				<img src="<?php echo base_url(); ?>roden_assets/images/logo-<?php echo $this->config->item('site_slug'); ?>.png" width="100%" height="100%" />
			</a>
		</div>
		<div id="content" class="error error-404 clearfix" style="height:350px;">
			<h1><?php echo $this->config->item('site_name'); ?></h1>
			<h2>Seems to be a Glitch.</h2>
			<p>
			The web address you're trying to access isn't a functioning page on our site.
			</p>
			<p>
			Please visit our homepage: <a href="<?php echo site_url(); ?>">www.<?php echo $this->config->item('site_slug'); ?>.com</a>
			</p>
		</div>
		<div style="text-align:center;height:300px;">
			<p style="font-size:1.1rem;">
			The web address you're trying to access isn't a functioning page on our site.
			</p>
			<p style="font-size:1.1rem;">
			Please visit our homepage: <a href="<?php echo site_url(); ?>"><?php echo $this->config->item('site_domain'); ?></a>
			</p>
		</div>
	</div>
</body>
</html>
