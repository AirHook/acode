<!DOCTYPE html>
<html lang="en" xmlns:fb="http://www.facebook.com/2008/fbml" class="no-js">

    <head>
	
		<?php
		/*****
		 * jQuery
		 */
		?>
        <script src="<?php echo base_url('roden_assets'); ?>/js/jquery-min.js"></script>
        
		<?php
		/*****
		 * Assuming: related to tagging, must be related to eluminate.js
		 * the Digital Data Exchange javascript
		 
		<script>
			cmCreatePageviewTag("PAGE: HOME", "PAGE", null, null);
		</script>
		 */
		?>
		

		<meta charset="utf-8" />
		<meta name="Description" content="Discover Basix Bridal, Anthropologie's wedding brand. Shop our collection of wedding dresses, bridal gowns, bridesmaids dresses, accessories & decor." />
		<meta name="Keywords" content="wedding dresses, wedding dress, simple wedding dresses, simple wedding dress, wedding dresses, wedding gowns, bridesmaid dresses, wedding decorations" />
		<meta name="abstract" content="Basix Bridal Basix Bridal Wedding Dresses | Vintage Inspired Wedding Dresses &amp; Gowns" />
		<meta name="allow-search" content="YES" />
		<meta name="distribution" content="Global" />
		<meta name="rating" content="General" />
		
		
		<?php
		/*****
		 * Some META that we may not be needing
		 * <meta name="reply-to" content="support@roden.com" />
		 *
		 * Google site verification code
		 * <meta name="google-site-verification" content="9h31GEFCmi646CaN7RTrikicU7GIu2NUhvGCAZG2joY" />
		 *
		 * And another validation code thingee
		 * <meta name="msvalidate.01" content="E850C9C7106B629010F66E6EE16E17D5" />
		 */
		?>

		<!--[if IE 6]>
		<meta http-equiv="imagetoolbar" content="no" />
		<![endif]-->
		
		<meta name="MSSmartTagsPreventParsing" content="TRUE" />
		<meta name="robots" content="noodp,noydir" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php
		/*****
		 * 
		<meta property="og:title" content="roden" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="www.roden.com" />
		<meta property="og:image" content="/resources/roden/images/layout/logo_roden_pink.png" />
		<meta property="og:description" content="roden Wedding Dresses | Vintage Inspired Wedding Dresses & Gowns" />
		<meta property="og:site_name" content="roden" />
		
		<link rel="apple-touch-icon" href="/resources/roden/images/apple-touch-icon.png" />
		 */
		?>

		<title>
			Basix Bridal Wedding Dresses | Vintage Inspired Wedding Dresses &amp; Gowns 
		</title>

		<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
		
		<?php if (ENVIRONMENT !== 'development'): ?>
		<link rel="canonical" href="http://www.basixbridal.com/" /> 
		<?php endif; ?>
		
		<script type="text/javascript">
            var dataLayer = dataLayer || [];
            dataLayer.push (
				{
					'PageType': 'Homepage',
					'HashedEmail': 'D41D8CD98F00B204E9800998ECF8427E'
				}
            );
		</script>
        
		<?php
		/*****
		 * Stylesheets
		 */
		?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('roden_assets'); ?>/css/site-min.css" />
		<link rel="stylesheet" type="text/css" media="print" href="<?php echo base_url('roden_assets'); ?>/css/print-min.css" />
			
		<!--[if lte IE 8]>
			<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('roden_assets'); ?>/css/ie-min.css" />
		<![endif]-->

		<script type="text/javascript">document.getElementsByTagName('html')[0].className = 'js';</script>
		<script>
			// Picture element HTML5 shiv
			$(function() {
				document.createElement("picture");
			});
		</script>
		
		<?php
		/*****
		 * Pucturefill javascript
		 *
		 * https://github.com/scottjehl/picturefill
		 * http://scottjehl.github.io/picturefill/
		 */
		?>
		<script src="<?php echo base_url('roden_assets'); ?>/js/picturefill.min.js" async></script>
		<?php if (ENVIRONMENT !== 'development'): ?>
		<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic,700" rel="stylesheet" type="text/css">
		<?php endif; ?>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>roden_assets/font-awesome/css/font-awesome.min.css">
		
		<style> 
		
		.not-loaded {
			/*visibility: hidden;*/
		}

		#site-banner-container {
			display: none!important;
		}

		.wrap {
			max-width: 1400px;
			padding-left: 0;
			padding-right: 0;
		}

		.header {
			max-width: 1280px;
			margin: 0 auto;
		}

		.disclaimer,
		#breadcrumbs {
			display: none!important;
		}

		#content {
			padding: 0 0 19px;
		}

		.homepage {
			-webkit-font-smoothing: antialiased;
			margin: 30px auto 0;
			color: #333333;
			letter-spacing: 1px;
		}

		.homepage [class|=container] {
			overflow: hidden;
		}

		.homepage .inner {
			margin: 0 auto;
		}

		.roden-creative {
			position: relative;
		}

		.footer-nav {
		max-width: 1400px;
		}

		/* Container block styles */

		.homepage [class|=container] {
			text-align: center;
			margin: 0 auto;
			position: relative;
			overflow: hidden;
		}

		.homepage [class|=container]:after {
			content: "";
			clear: both;
			display: block;
		}


		/* Container content styles */

		.homepage .cta-block,
		.homepage .copy-block {
			position: relative;
			font-family: 'Libre Baskerville', serif;
		}

		.homepage .copy-block.products {
			font-family: arial, sans-serif;
		}

		.homepage .cta-block a {
			color: #333333;
		}

		.homepage .copy-container {
			position: relative;
		}

		.homepage .copy-block.products {
			font-size: 11px;
		}

		.homepage .copy-block.products a {
			color: #333333;
		}


		/*.homepage .half-section img {
			max-width: 467px;
		}*/


		/* Container One */

		.homepage .container-one {}

		.homepage .container-one .image-block {
			display: inline-block;
			width: 54%;
			float: left;
			text-align: left;
		}

		.homepage .container-one .copy-container {
			display: inline-block;
			width: 36%;
			float: left;
			padding-left: 45px;
			padding-right: 5px;
			padding-top: 1%;
		}

		.homepage .container-one .title-block h1 {
			font-size: 40px;
			text-transform: uppercase;
			letter-spacing: 8px;
			color: #333333;
			margin: 0;
		}

		.homepage .container-one .title-block h1 i {
			display: block;
			text-transform: lowercase;
			position: relative;
			left: 35px;
		}

		.homepage .container-one .copy-block {
			top: 20px;
			max-width: 300px;
			text-align: left;
			letter-spacing: 2px;
			line-height: 1.8;
			font-size: 14px;
		}

		.homepage .container-one .cta-block {
			top: 38px;
			left: 30px;
		}

		.homepage .container-one .cta-block a p {
			width: 190px;
			padding: 17px 0;
			margin: 0 auto;
		}


		/* Container Two */

		.homepage .container-two {
			margin-top: 30px;
			margin-bottom: 15px;
		}

		.homepage .container-two .top-half .left-half {
			width: 45%;
			display: inline-block;
			float: left;
		}

		.homepage .container-two .top-half .right-half {
			width: 55%;
			display: inline-block;
			float: left;
		}

		.homepage .container-two .top-half .right-half .image-block {
			text-align: left;
		}

		.homepage .container-two .top-half .copy-container {
			padding: 55% 10% 0 20%;
		}

		.homepage .container-two .top-half .copy-block {
			text-align: left;
			text-transform: lowercase;
			font-size: 14px;
			letter-spacing: 2px;
			line-height: 1.8;
		}

		.homepage .container-two .top-half .copy-block span {
			position: relative;
			right: 15px;
		}

		.homepage .container-two .top-half .title-block {
			font-size: 40px;
			font-style: italic;
			text-transform: lowercase;
			right: 25px;
			position: relative;
			letter-spacing: 5px
		}

		.homepage .container-two .top-half .title-block span {
			position: relative;
			display: block;
		}

		.homepage .container-two .top-half .title-block .one {
			right: 20px;
		}

		.homepage .container-two .top-half .title-block .two {
			left: 60px;
		}

		.homepage .container-two .top-half .title-block .three {
			right: 40px;
		}

		.homepage .container-two .top-half .copy-block.products {
			text-align: right;
			text-transform: none;
			top: 100px;
			font-size: 10px;
			letter-spacing: 1px;
		}

		.homepage .container-two .bottom-half {
			position: relative;
			top: -4px;
		}

		.homepage .container-two .bottom-half .left-half {
			width: 55%;
			float: left;
			padding: 0 10px 30px 50px;
		}

		.homepage .container-two .bottom-half .right-half {
			width: 45%;
			float: left;
		}

		.homepage .container-two .bottom-half .left-half .copy-container {
			margin: 15px auto 0;
			max-width: 558px;
		}

		.homepage .container-two .bottom-half .left-half .copy-block.products {
			display: inline-block;
			float: left;
		}

		.homepage .container-two .bottom-half .left-half .cta-block {
			display: inline-block;
			float: right;
		}

		.homepage .container-two .bottom-half .left-half .cta-block a p {
			padding: 17px 0;
			width: 190px;
		}

		.homepage .container-two .bottom-half .right-half {
			padding-top: 5%;
		}

		.homepage .container-two .bottom-half .right-half .inner {
			width: 80%;
			float: right;
		}

		.homepage .container-two .bottom-half .right-half .cta-block {
			margin-top: 20px;
		}

		.homepage .container-two .bottom-half .right-half .cta-block a p {
			width: 220px;
			padding: 17px 0;
			margin: 0 auto;
		}

		.homepage .container-two .bottom-half .right-half .copy-block.products {
			margin-top: 20px;
		}


		/* Conatiner Three */

		.homepage .container-three {}

		.homepage .container-three .inner {
			max-width: 1260px;
			float: left;
			position: relative;
		}

		.homepage .container-three .copy-container {
			position: absolute;
			width: 36%;
			top: 0;
			right: 0;
			color: #ffffff;
			padding: 7% 5px;
		}

		.homepage .container-three .title-block {
			font-size: 33px;
			text-transform: uppercase;
			letter-spacing: 6px;
		}

		.homepage .container-three .title-block p {
			margin: 0;
		}

		.homepage .container-three .title-block i {
			text-transform: lowercase;
			letter-spacing: 4px;
			position:relative;
			left: 5px;
		}

		.homepage .container-three .cta-block {
			margin-top: 30%;
		}

		.homepage .container-three .cta-block a {
			color: #ffffff;
		}

		.homepage .container-three .cta-block a p {
			width: 235px;
			padding: 17px 0;
			border: 1px solid #ffffff;
			color: #ffffff;
			margin: 0 auto;
			-webkit-font-smoothing: antialiased;
		}

		.homepage .container-three .copy-block.products {
			line-height: 2;
			margin-top: 30%;
		}

		.homepage .container-three .copy-block.products a {
			color: #ffffff;
		}


		/* Container Four */

		.homepage .container-four {
			position: relative;
			top: -4px;
			margin-bottom: 30px;
		}

		.homepage .container-four .left-half {
			width: 40%;
			float: left;
		}

		.homepage .container-four .right-half {
			width: 60%;
			float: left;
		}

		.homepage .container-four .copy-container {
			padding-top: 20%;
			padding-left: 40px;
			position: inherit;
			position: initial;
		}

		.homepage .container-four .title-block {
			text-transform: uppercase;
			font-size: 40px;
			line-height: 1.5;
			text-align: left;
			left: 40%;
			font-style: italic;
			display: inline-block;
			letter-spacing: 10px;
		}

		.homepage .container-four .title-block span {
			display: block;
			position: relative;
			right: 40px;
		}

		.homepage .container-four .copy-container .copy-block {
			text-transform: lowercase;
			text-align: left;
			position: relative;
			left: 30%;
			font-size: 14px;
			letter-spacing: 2px;
		}

		.homepage .container-four .cta-block {
			text-align: left;
			position: absolute;
			bottom: 5%;
			left: 10%;
		}

		.homepage .container-four .cta-block a p {
			width: 230px;
			padding: 17px 0;
			text-align: center;
		}

		.homepage .container-four .right-half .image-block {
			display: inline-block;
		}

		.homepage .container-four .right-half .copy-block.products {
			display: inline-block;
			margin-left: 20px;
		}


		/* Container Five*/

		.homepage .container-five .inner {
			max-width: 1060px;
			position: relative;
			right: 20px;
		}

		.homepage .container-five .copy-container {
			width: 45%;
			position: absolute;
			top: 33%;
			left: 0;
		}

		.homepage .container-five .cta-block a {
			color: #ffffff;
		}

		.homepage .container-five .cta-block a p {
			color: #ffffff;
			padding: 17px 0;
			width: 230px;
			border: 1px solid #ffffff;
			margin: 0 auto;
			-webkit-font-smoothing: antialiased;
		}

		.homepage .container-five .copy-block.products a {
			color: #ffffff;
		}

		.homepage .container-five .copy-block.products {
			margin-top: 20%;
			color: #ffffff;
		}


		/* Container Six*/


		/* CTA's */

		.homepage .cta-block a:hover {
			text-decoration: none;
		}

		.homepage .cta-block a:hover p {
			outline: 1px solid #333333;
		}

		.homepage .container-five .cta-block a:hover p,
		.homepage .container-three .cta-block a:hover p {
			outline: 1px solid #ffffff;
		}

		.homepage .cta-block a {
			color: #333333;
		}

		.homepage .cta-block a p {
			color: #333333;
			font-weight: 500;
			font-size: 16px;
			letter-spacing: 2px;
			font-style: italic;
			margin: 0;
			border: 1px solid #333333;
			position: relative;
			border-radius: 1px;
			-webkit-font-smoothing: auto;
		}

		.homepage .cta-block a:hover p:after,
		.homepage .container-two .cta-block p a:hover:after {
			opacity: 1;
		}

		.absolute {
			position: absolute;
		}

		.homepage .inline-mobile {
			display: block;
		}

		.homepage .block-tablet {
			display: inline;
		}

		.homepage .mobile-only {
			display: none;
		}

		.homepage .show-tablet {
			display: none;
		}

		.homepage .tablet-only {
			display: none!important;
		}

		@media screen and (max-width: 959px) {
			.homepage {
				margin: 15px auto 0;
			}
			.homepage .copy-block.products {
				font-size: 10px;
			}

			.homepage .cta-block a p {
				font-size: 14px;
			}

			.homepage .container-one .copy-container {
				width: 90%;
				padding: 5px;
			}
			.homepage .container-one .title-block h1 {
				margin: 0;
				font-size: 32px;
			}
			.homepage .container-one .title-block,
			.homepage .container-one .copy-block {
				display: inline-block;
				width: 45%;
				margin: 15px;
				float: left;
			}
			.homepage .container-one .copy-block {
				top: 0;
				font-size: 11px;
				max-width: 300px;
				margin-top: 25px;
				margin:15px 10px;
				letter-spacing: 1.5px;
			}
			.homepage .container-one .image-block {
				width: 90%;
				margin-bottom: 10px;
			}
			.homepage .container-one .cta-block {
				top: 0;
				left: 0;
			}
			.homepage .container-one .cta-block a p {
				float: right;
			}
			.homepage .container-two .top-half .copy-container {
				padding: 20% 8% 0 15%
			}
			.homepage .container-two .top-half .title-block {
				top: 35px;
			}
			.homepage .container-two .top-half .copy-block {
				font-size: 11px;
			}
			.homepage .container-two .top-half .copy-block span {
				right: 13px;
			}
			.homepage .container-two .bottom-half .left-half .copy-block.products,
			.homepage .container-two .bottom-half .left-half .cta-block {
				float: none;
				display: block;
			}
			.homepage .container-two .bottom-half .left-half {
				padding: 0 35px 30px 0;
			}
			.homepage .container-two .bottom-half .left-half .cta-block {
				margin-top: 15px;
			}
			.homepage .container-two .bottom-half .left-half .cta-block a p {
				margin: 0 auto;
			}
			.homepage .container-two .top-half .copy-block.products {
				top: 150px;
			}
			.homepage .container-three .copy-container {
				padding: 7% 5px;
			}
			.homepage .container-three .title-block {
				font-size: 26px;
			}
			.homepage .container-three .cta-block {
				margin-top: 20%;
			}
			.homepage .container-four .right-half,
			.homepage .container-four .left-half {
				width: 50%;
			}

			.homepage .container-four .title-block {
				font-size: 32px;
			}

			.homepage .container-four .right-half .image-block {
				padding: 25px 5px;
			}
			.homepage .container-four .cta-block {
				left: 8%;
			}
			.homepage .container-four .copy-container .copy-block {
				left: 12%;
			}
			.homepage .tablet-only {
				display: block !important;
			}
			.homepage .hide-tablet {
				display: none!important;
			}
			.homepage .show-tablet {
				display: block;
			}
			.homepage .block-tablet {
				display: block;
			}
			.homepage .inline-block-tablet {
				display: inline-block;
			}
			/* Container content styles */
		}

		@media screen and (max-width: 769px) {
			.homepage .cta-block a p {
				letter-spacing: 3px;
			}
		}

		@media screen and (max-width: 767px) {
			.homepage .cta-block a:hover p {
				outline: 0!important;
			}
			.wrap {
				padding: 0 5px;
			}
			.homepage {
				margin-top: 10px;
			}
			.homepage * {
				float: none!important;
			}
			.homepage .container-four {
				top: 0;
			}
			.homepage [class|=container] .inner {
				margin: 0 auto;
			}
			.homepage {
				max-width: 450px;
				margin: 0 auto;
			}
			.homepage .copy-block.products {
				display: none!important;
			}
			.homepage .container-one .title-block {
				position: absolute;
				width: 100%;
				color: #ffffff;
				text-align: center;
				top: 25px;
				display: block;
				float: none;
				margin: 0;
			}
			.homepage .container-one .copy-container {
				width: 100%;
			}
			.homepage .container-one .title-block h1 {
				color: #ffffff;
				letter-spacing: 5px;
			}
			.homepage .container-one .title-block h1 i {
				display: inline;
				left: 0;
			}
			.homepage .container-one .image-block {
				width: 100%;
				margin-bottom: 0;
			}
			.homepage .container-two .title-block,
			.homepage .container-three .title-block,
			.homepage .container-four .title-block,
			.homepage .copy-block,
			.homepage .container-five .image-block,
			.homepage .container-five .copy-container {
				display: none!important;
			}
			.homepage .cta-block a p,
			.homepage .container-two .cta-block p a {
				font-size: 14px;
				letter-spacing: 3px;
				-webkit-font-smoothing: antialiased!important;
			}
			.homepage [class|=container] {
				position: relative;
			}
			.homepage .container-one .copy-container.mobile-cta {
				display: block;
				position: absolute;
				bottom: 17%;
				width: 100%;
			}
			.homepage .container-two .copy-container {
				display: block;
				position: absolute;
				bottom: 10%;
				width: 100%;
			}
			.homepage .container-two .bottom-half .right-half,
			.homepage .container-four .right-half,
			.homepage .container-two .bottom-half .right-half .inner {
				width: 100%;
				float: none;
				display: block;
			}
			.homepage .cta-block {
				position: absolute!important;
				width: 100%!important;
				left: 0!important;
				right: 0!important;
				margin: 0!important;
				bottom: 10% !important;
			}
			.homepage .container-three .copy-container {
				bottom: 10%!important;
				width: 100%;
				top: inherit;
				right: 0;
				left: 0;
				padding: 0;
			}
			.homepage .container-five .cta-block a p {
				width: 180px;
			}
			.homepage .container-two .bottom-half .right-half .cta-block a p {
				width: 200px;
			}
			.homepage .cta-block a p {
				color: #ffffff!important;
				background: rgba(0, 0, 0, 0.3)!important;
				border: 1px solid #ffffff!important;
			}
			.homepage .container-two .bottom-half .right-half {
				padding-top: 0;
			}
			.homepage .container-five .inner {
				right: 0;
			}
			.homepage .container-four .left-half {
				width: 0;
				float: none;
			}
			.homepage .container-four .right-half .image-block {
				padding: 0;
			}
			.homepage .cta-block a p {
				margin: 0 auto;
			}
			.homepage .inline-block-tablet {
				display: normal;
			}
			.homepage .inline-mobile {
				display: inline;
			}
			.homepage .mobile-only {
				display: block;
			}
			.homepage .block-mobile {
				display: block;
			}
			.homepage .hide-mobile {
				display: none!important;
			}
			.homepage [class|=container] {
				margin: 10px auto;
			}
		}

		@media screen and (max-width: 400px) {}

		@media screen and (max-width: 350px) {}

		</style>

		<?php
		/*****
		 * Custom Stylesheets
		 * - to override source style wihtout editing it
		 */
		?>
		<style>
			.footer-social a {
				background: transparent url("<?php echo base_url(); ?>roden_assets/images/sprite_globals.png") 0 -279px no-repeat;
			}
			.utility .youtube .icon,
			.utility .pinterest .icon,
			.utility .instagram .icon,
			.utility .cart .icon {
				width: 18px;
				height: 18px;
				font-size: 18px;
			}
		</style>
		
		<?php
		/*****
		 * Google Analytics
		 *
        <script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-21290763-1', 'auto');
			ga('require', 'displayfeatures');
			ga('send', 'pageview');
			ga('require', 'ecommerce', 'ecommerce.js');
        </script>
		 */
		?>


		<?php
		/*****
		 * Google Tag Manager
		 *
        <!-- Google Tag Manager -->
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TD59FZ"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TD59FZ');</script>
        <!-- End Google Tag Manager -->
		 */
		?>

		<?php
		/*****
		 * Another msvalidation
		 *
        <meta name="msvalidate.01" content="5D412EAC431B8CDA8B3EDCF08ADAB997" />
		 */
		?>
        
    </head>
	
    <body class="l-home l-default  " >

    
		<script src="<?php echo base_url('roden_assets'); ?>js/p13n.js"></script>
    

		<ul class="screenreaderonly">
			<li><a href="<?php echo site_url('accessibility'); ?>" accesskey="0">Accessibility Information</a></li>
			<li><a href="#content" accesskey="S">Skip To Main Content</a></li>
			<li><a href="#nav-primary" accesskey="M">Skip To Main Navigation</a></li>
		</ul>

		<div class="header-bg-wrap fixedsticky">
			<header>
				<ul class="utility">
				
					<?php
					/*****
					 * Hambutger Menu Icon
					 * For mobile browsing
					 */
					?>
					<li class="primary-nav-control" data-nav-control=''>
						<a href="#" class="icon icon--hamburger">
							<span class="text">Open Navigation</span>
						</a>
					</li>
					<li class="store-locations">
						<a href="<?php echo site_url(); ?>" class="icon icon--location-marker">
							<span class="text">Stores</span>
						</a>
					</li>
					
					<?php
					/*****
					 * Logo
					 */
					?>
					<li class="logo">
						<a href="<?php echo site_url(); ?>" accesskey="1">
							
								<img src="<?php echo base_url(); ?>roden_assets/images/basixbridal-logo.jpg" width="100%" height="100%" />
							
						</a>
					</li>

					<li class="search-control">
						<div class="search-control__wrap">
							<a href="#" class="search-control__link">
								<span class="icon  icon--search fa fa-search"></span>
								<span class="text  js-search-control">Search</span>
							</a>
						</div>
						<div class="search-wrap">
                        
							<div class="v-search-basicsearchform">
								<form id="vSearch-basicSearchForm-form-1" name="vSearch_basicSearchForm_form_1" action="/index.cfm" method="get">
									<input type="hidden" name="fuseaction" value="search.results" />
									<label for="vSearch-basicSearchForm-searchString-1">Search</label>
									<input type="text" class="input-text" required="required" id="vSearch-basicSearchForm-searchString-1" placeholder="Search" name="searchString" />
									<button type="submit" class="input-submit visually-hidden">Search</button>
								</form>
							</div>

						</div>
					</li>

					<!--
					<li class="cart">
						<a href="<?php echo site_url(); ?>" accesskey="Y" class="icon icon--cart fa fa-shopping-bag ">
							<span class="text">Shopping Cart:</span>
							<span class="count">0</span>
						</a>
					</li>
					<li class="account">
						<a href="<?php echo site_url(); ?>">
							Account
							
						</a>
					</li>
					-->
					<li class="instagram">
						<a href="http://instagram.com/" class="icon fa fa-instagram" target="_blank">
							<span class="text">Instagram</span>
						</a>
					</li>
					<li class="pinterest">
						<a href="http://pinterest.com/" class="icon fa fa-pinterest-square" target="_blank">
							<span class="text">Pinterest</span>
						</a>
					</li>
					<li class="youtube">
						<a href="http://youtube.com/" class="icon fa fa-youtube-play" target="_blank">
							<span class="text">Pinterest</span>
						</a>
					</li>
					<li class="store-locations-desktop">
						<a href="<?php echo site_url(); ?>">
							<span class="text">Store Login</span>
						</a>
					</li>
					
					
				</ul>
			</header>
		</div>
		<!-- header-bg-wrap -->
		
		
		<div id="wrap" class="wrap">
			<div id="wrap-bg2" class="wrap--internal">
			
				<div id="wrap-content" class="clearfix">

					<?php
					/**********
					 * HEADER
					 */
					?>
					<div id="header" class="header clearfix" role="banner">
					
						<?php
						/**********
						 * Primary Navigation
						 */
						?>
						<nav id="nav-primary" class="nav nav-primary" role="navigation">
                            <ul>
                                <li>
                                    <a href="<?php echo site_url(); ?>" accesskey="2">
                                        Bridal Dresses
                                    </a>
                                </li>
								
								<li class="nav-item-shop-new ">
									<a accesskey="3" href="<?php echo site_url(); ?>">
										Bridesmaids
									</a>
									<ul>
										<li class="nav-item-shop-new-dresses  first ">
											<a accesskey="3" href="<?php echo site_url(); ?>">Dresses</a>
										</li>
										<li class="nav-item-shop-new-shoes-accessories ">
											<a accesskey="3" href="<?php echo site_url(); ?>">Shoes &amp; Accessories</a>
										</li>
										<li class="nav-item-shop-new-lingerie ">
											<a accesskey="3" href="<?php echo site_url(); ?>">Lingerie</a>
										</li>
										<li class="nav-item-shop-new-decor ">
											<a accesskey="3" href="<?php echo site_url(); ?>">Décor</a>
										</li>
										<li class="nav-item-shop-new-gifts ">
											<a accesskey="3" href="<?php echo site_url(); ?>">Gifts</a>
										</li>
										<li class="nav-item-wedding-trends ">
											<a accesskey="3" href="<?php echo site_url(); ?>">Trends</a>
										</li>
									</ul>
								</li> 
								
								<li class="nav-item-bride ">
									<a accesskey="4" href="<?php echo site_url(); ?>">
										Maid Of Honor
									</a>
									<ul>
										<li class="nav-item-shop-the-bride-wedding-dresses  first ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Wedding Dresses</a>
										</li>
										<li class="nav-item-bride-bridal-separates ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Bridal Separates</a>
										</li>
										<li class="nav-item-bride-reception-rehearsal-dresses ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Reception &amp; Rehearsal Dresses</a>
										</li>
										<li class="nav-item-shop-the-bride-bridal-lingerie ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Bridal Lingerie</a>
										</li>
										<li class="nav-item-shop-the-bride-veils-headpieces ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Veils &amp; Headpieces</a>
										</li>
										<li class="nav-item-shop-the-bride-bridal-jewelry ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Bridal Jewelry</a>
										</li>
										<li class="nav-item-the-bride-bridal-cover-ups ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Bridal Cover Ups</a>
										</li>
										<li class="nav-item-shop-the-bride-bridal-accessories ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Bridal Accessories</a>
										</li>
										<li class="nav-item-shop-the-bride-bridal-shoes ">
											<a accesskey="4" href="<?php echo site_url(); ?>">Bridal Shoes</a>
										</li>
									</ul>
								</li> 
								
								<li class="nav-item-bridesmaids ">
									<a accesskey="5" href="<?php echo site_url(); ?>">
										Mother Of The Bride
									</a>
									<ul>
										<li class="nav-item-bridesmaids-view-all-dresses  first ">
											<a accesskey="5" href="<?php echo site_url(); ?>">View All Dresses</a>
										</li>
										<li class="nav-item-bridesmaids-bridesmaid-dresses ">
											<a accesskey="5" href="<?php echo site_url(); ?>">Bridesmaid Dresses</a>
										</li>
										<li class="nav-item-bridesmaids-bridesmaid-separates ">
											<a accesskey="5" href="<?php echo site_url(); ?>">Bridesmaid Separates</a>
										</li>
										<li class="nav-item-bridesmaids-maid-of-honor-dresses ">
											<a accesskey="5" href="<?php echo site_url(); ?>">Maid of Honor Dresses</a>
										</li>
										<li class="nav-item-bridesmaids-bridesmaid-gifts ">
											<a accesskey="5" href="<?php echo site_url(); ?>">Bridesmaid Gifts</a>
										</li>
										<li class="nav-item-bridesmaids-bridesmaid-accessories ">
											<a accesskey="5" href="<?php echo site_url(); ?>">Bridesmaid Accessories</a>
										</li>
										<li class="nav-item-bridesmaids-bridesmaid-jewelry ">
											<a accesskey="5" href="<?php echo site_url(); ?>">Bridesmaid Jewelry</a>
										</li>
										<li class="nav-item-bridesmaids-mix-and-match ">
											<a accesskey="5" href="<?php echo site_url(); ?>">Mix &amp; Match</a>
										</li>
									</ul>
								</li> 
								
								<li class="nav-item-dresses ">
									<a accesskey="6" href="<?php echo site_url(); ?>">
										Made To Order
									</a>
									<ul>
										<li class="nav-item-dresses-view-all-dresses  first ">
											<a accesskey="6" href="<?php echo site_url(); ?>">View All Dresses</a>
										</li>
										<li class="nav-item-dresses-party-dresses ">
											<a accesskey="6" href="<?php echo site_url(); ?>">Party Dresses</a>
										</li>
										<li class="nav-item-dresses-mother-of-the-bride-dresses ">
											<a accesskey="6" href="<?php echo site_url(); ?>">Mother of the Bride Dresses</a>
										</li>
										<li class="nav-item-dresses-flower-girl-dresses ">
											<a accesskey="6" href="<?php echo site_url(); ?>">Flower Girl Dresses</a>
										</li>
									</ul>
								</li>
								
								<li class="nav-item-bride-beach-wedding-honeymoon ">
									<a accesskey="7" href="<?php echo site_url(); ?>">
										Shows &amp; Events
									</a>
									<ul>
										<li class="nav-item-bride-beach-wedding-honeymoon-dresses  first ">
											<a accesskey="7" href="<?php echo site_url(); ?>">Dresses &amp; Separates</a>
										</li>
										<li class="nav-item-bride-beach-wedding-honeymoon-swim ">
											<a accesskey="7" href="<?php echo site_url(); ?>">Swim</a>
										</li>
										<li class="nav-item-bride-beach-honeymoon-cover-ups ">
											<a accesskey="7" href="<?php echo site_url(); ?>">Cover Ups</a>
										</li>
										<li class="nav-item-bride-beach-honeymoon-accessories ">
											<a accesskey="7" href="<?php echo site_url(); ?>">Accessories</a>
										</li>
									</ul>
								</li>
								
								<!--
								<li class="nav-item-shop-shoes-accessories ">
									<a accesskey="8" href="<?php echo site_url(); ?>">
										Accessories
									</a>
									<ul>
										<li class="nav-item-shop-shoes-accessories-shoes  first ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Shoes</a>
										</li>
										<li class="nav-item-shop-shoes-accessories-jewelry ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Jewelry</a>
										</li>
										<li class="nav-item-shop-shoes-accessories-veils ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Veils</a>
										</li>
										<li class="nav-item-shop-shoes-accessories-headpieces ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Headpieces</a>
										</li>
										<li class="nav-item-shop-shoes-accessories-cover-ups ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Cover Ups</a>
										</li>
										<li class="nav-item-shoes-accessories-belts-sashes ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Belts &amp; Sashes</a>
										</li>
										<li class="nav-item-shoes-accessories-clutches-gloves ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Clutches &amp; Gloves</a>
										</li>
										<li class="nav-item-shop-shoes-accessories-lingerie ">
											<a accesskey="8" href="<?php echo site_url(); ?>">Lingerie</a>
										</li>
									</ul>
								</li>
								
								<li class="nav-item-shop-decor ">
									<a accesskey="9" href="<?php echo site_url(); ?>">
										Décor
									</a>
									<ul>
										<li class="nav-item-shop-decor-view-all-decor  first ">
											<a accesskey="9" href="<?php echo site_url(); ?>">View All Décor</a>
										</li>
										<li class="nav-item-shop-decor-gifts ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Gifts</a>
										</li>
										<li class="nav-item-shop-decor-decorations ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Decorations</a>
										</li>
										<li class="nav-item-shop-decor-centerpieces ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Centerpieces</a>
										</li>
										<li class="nav-item-shop-decor-table-signage ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Table Signage</a>
										</li>
										<li class="nav-item-shop-decor-ceremony ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Ceremony</a>
										</li>
										<li class="nav-item-shop-decor-tabletop ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Tabletop</a>
										</li>
										<li class="nav-item-shop-decor-cake-accessories ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Cake Accessories</a>
										</li>
										<li class="nav-item-shop-decor-stationery ">
											<a accesskey="9" href="<?php echo site_url(); ?>">Stationery</a>
										</li>
									</ul>
								</li>
								
								<li class="nav-item-shop-sale ">
									<a accesskey="10" href="<?php echo site_url(); ?>">
										Sale
									</a>
									<ul>
									<li class="nav-item-shop-sale-just-added  first ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Just Added</a>
										</li>
									<li class="nav-item-sale-wedding-dresses ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Wedding Dresses</a>
										</li>
									<li class="nav-item-sale-dresses ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Dresses</a>
										</li>
									<li class="nav-item-shop-sale-shoes ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Shoes</a>
										</li>
									<li class="nav-item-shop-sale-jewelry ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Jewelry</a>
										</li>
									<li class="nav-item-shop-sale-accessories ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Accessories</a>
										</li>
									<li class="nav-item-shop-sale-headpieces ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Headpieces</a>
										</li>
									<li class="nav-item-shop-sale-lingerie ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Lingerie</a>
										</li>
									<li class="nav-item-shop-sale-decor ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Décor</a>
										</li>
									<li class="nav-item-shop-sale-cover-ups ">
											<a accesskey="10" href="<?php echo site_url(); ?>">Cover Ups</a>
										</li>
									</ul>
								</li>
								-->
                            </ul>
						</nav><!-- #nav-primary -->

						<?php
						/**********
						 * Mobile Navigation
						 */
						?>
						<div id="nav-mobile" class="nav-mobile">
							<div class="mobile-nav-top">
								<a href="<?php echo site_url(); ?>">Account</a>
								<a class="icon icon--close fa fa-times" href="#wl-page-wrap" data-nav-close='' > <span class="visually-hidden">Close</span></a>
							</div>
							<ul>
                                <li id="book-an-appointment">
                                    <a href="<?php echo site_url(); ?>">
                                        Bridal Dresses
                                    </a>
                                </li>
								<li class="navigation-item-b5370bc6-8ce9-4329-b918-7ce432825f45">
									<a href="<?php echo site_url(); ?>" title="Bridesmaids">
										Bridesmaids
									</a>
									<ul>
										<li class="navigation-item-584b1f2e-b51e-46dd-840d-85c309c42bd8">
											<a href="<?php echo site_url(); ?>" title="Dresses">Dresses</a>
										</li>
										<li class="navigation-item-4d040e18-afa4-4cf4-b77b-9b681c369f59">
											<a href="<?php echo site_url(); ?>" title="Shoes &amp; Accessories">Shoes &amp; Accessories</a>
										</li>
										<li class="navigation-item-20835298-7667-487c-896c-153fc0191faa">
											<a href="<?php echo site_url(); ?>" title="Lingerie">Lingerie</a>
										</li>
										<li class="navigation-item-67d397c3-6a84-4863-ad70-6c88960f518b">
											<a href="<?php echo site_url(); ?>" title="Décor">Décor</a>
										</li>
										<li class="navigation-item-352527bc-3ee9-4346-8625-7543c9b2e8af">
											<a href="<?php echo site_url(); ?>" title="Gifts">Gifts</a>
										</li>
										<li class="navigation-item-e14490c1-1fd4-4419-9e9f-1d218d18a7f5">
											<a href="<?php echo site_url(); ?>" title="Trends">Trends</a>
										</li>
									</ul>
								</li>
								
								<li class="navigation-item-bff503d9-2c67-4586-9691-5c0a1ee15824">
									<a href="<?php echo site_url(); ?>" title="Maid Of Honor">
										Maid Of Honor
									</a>
									<ul>
										<li class="navigation-item-ca7207b6-ead4-499b-b51b-61225dd97367">
											<a href="<?php echo site_url(); ?>" title="Wedding Dresses">Wedding Dresses</a>
											<ul>
												<li class="navigation-item-bc86a09b-9241-4fb8-bbce-50a7be49ca82">
													<a href="<?php echo site_url(); ?>" title="Back Detail">Back Detail</a>
												</li>
												<li class="navigation-item-252fbc0e-4cd6-453e-b2a6-78bda96dd3fe">
													<a href="<?php echo site_url(); ?>" title="Lace">Lace</a>
												</li>
												<li class="navigation-item-8cf52d5a-a977-41f1-9ca8-0fc10c194bd5">
													<a href="<?php echo site_url(); ?>" title="Sleeves">Sleeves</a>
												</li>
												<li class="navigation-item-63fb5e7a-56ff-4729-b117-66cb27d2f734">
													<a href="<?php echo site_url(); ?>" title="A-Line">A-Line</a>
												</li>
												<li class="navigation-item-008488c7-87be-4786-894e-8572d5191558">
													<a href="<?php echo site_url(); ?>" title="Strapless">Strapless</a>
												</li>
												<li class="navigation-item-4717a467-8474-4109-9b87-bed0b71aae01">
													<a href="<?php echo site_url(); ?>" title="Sheath">Sheath</a>
												</li>
												<li class="navigation-item-69b95826-224d-4ce6-bcc0-aedbfb9b8231">
													<a href="<?php echo site_url(); ?>" title="Embellished">Embellished</a>
												</li>
												<li class="navigation-item-fa3aa9fe-7ffc-4410-a92c-4fc9dc5f9d65">
													<a href="<?php echo site_url(); ?>" title="Mermaid">Mermaid</a>
												</li>
												<li class="navigation-item-1e87171a-94fe-4878-b639-6d435456bae3">
													<a href="<?php echo site_url(); ?>" title="Ball Gown">Ball Gown</a>
												</li>
											</ul>
										</li>
										
										<li class="navigation-item-f00bfb47-0bb3-4085-a61d-fcf025d22f3d">
											<a href="<?php echo site_url(); ?>" title="Bridal Separates">Bridal Separates</a>
											<ul>
												<li class="navigation-item-f2532a58-8798-4780-abd6-f5747122435d">
													<a href="<?php echo site_url(); ?>" title="Tops">Tops</a>
												</li>
												<li class="navigation-item-717db6b3-ec07-485f-8391-c7f1eb25b2bd">
													<a href="<?php echo site_url(); ?>" title="Skirts">Skirts</a>
												</li>
											</ul>
										</li>
										
										<li class="navigation-item-cb79a941-3582-4e87-a7a9-ce5a8d8409f9">
											<a href="<?php echo site_url(); ?>" title="Reception &amp; Rehearsal Dresses">Reception &amp; Rehearsal Dresses</a>
										</li>
											
										<li class="navigation-item-ffe08345-eeb1-4226-b766-60387201cd2d">
											<a href="<?php echo site_url(); ?>" title="Bridal Lingerie">Bridal Lingerie</a>
											<ul>
												<li class="navigation-item-69493a57-bcfa-47da-8d96-cb38d2389602">
													<a href="<?php echo site_url(); ?>" title="Robes">Robes</a>
												</li>
												<li class="navigation-item-1aaa9d17-da5d-41be-9686-06109f4368a7">
													<a href="<?php echo site_url(); ?>" title="Sleepwear">Sleepwear</a>
												</li>
												<li class="navigation-item-8b27e30c-da5c-40fc-a34b-455ecd268a33">
													<a href="<?php echo site_url(); ?>" title="Lingerie Sets">Lingerie Sets</a>
												</li>
												<li class="navigation-item-4e110396-0f93-45de-9d36-e2ddffb40541">
													<a href="<?php echo site_url(); ?>" title="Garters &amp; Hosiery">Garters &amp; Hosiery</a>
												</li>
												<li class="navigation-item-6faf1b36-67ac-4f2e-8309-d0aa122fb727">
													<a href="<?php echo site_url(); ?>" title="Bras">Bras</a>
												</li>
												<li class="navigation-item-5f7fbcf6-1fb9-4714-a6d1-489ad96c8bae">
													<a href="<?php echo site_url(); ?>" title="Panties">Panties</a>
												</li>
											</ul>
										</li>
										
										<li class="navigation-item-0adcaf5f-0ded-4e7b-b9f8-5523ebe9e6db">
											<a href="<?php echo site_url(); ?>" title="Veils &amp; Headpieces">Veils &amp; Headpieces</a>
											<ul>
												<li class="navigation-item-eec522b3-97c4-4ea8-9c6e-e86615778ccd">
													<a href="<?php echo site_url(); ?>" title="Veils">Veils</a>
												</li>
												<li class="navigation-item-16953a66-67bd-43a5-93d1-fad347eac92e">
													<a href="<?php echo site_url(); ?>" title="Halos &amp; Headbands">Halos &amp; Headbands</a>
												</li>
												<li class="navigation-item-87b890d8-f99e-4426-bde2-3d082d7faff7">
													<a href="<?php echo site_url(); ?>" title="Pins, Clips &amp; Combs">Pins, Clips &amp; Combs</a>
												</li>
											</ul>
										</li>
										
										<li class="navigation-item-de791464-55d7-41fa-b7bc-1842ee5ae089">
											<a href="<?php echo site_url(); ?>" title="Bridal Jewelry">Bridal Jewelry</a>
											<ul>
												<li class="navigation-item-854cd1c1-6d1a-4060-91b3-3963762f708a">
													<a href="<?php echo site_url(); ?>" title="Earrings">Earrings</a>
												</li>
												<li class="navigation-item-a978e0f2-0b97-4a7a-a1df-4cbc70462cbb">
													<a href="<?php echo site_url(); ?>" title="Bracelets">Bracelets</a>
												</li>
												<li class="navigation-item-6179ed83-9f3e-40ff-9d59-b4f305bffe81">
													<a href="<?php echo site_url(); ?>" title="Rings">Rings</a>
												</li>
												<li class="navigation-item-1963983c-bf9e-4089-8228-5f3ba0cefdb2">
													<a href="<?php echo site_url(); ?>" title="Necklaces">Necklaces</a>
												</li>
											</ul>
										</li>
										
										<li class="navigation-item-ba44482e-fa9e-4d18-9a02-d3780c1537c5">
											<a href="<?php echo site_url(); ?>" title="Bridal Cover Ups">Bridal Cover Ups</a>
										</li>
			
										<li class="navigation-item-5c3e874f-af26-470c-b653-24b5fefa5a3a">
											<a href="<?php echo site_url(); ?>" title="Bridal Accessories">Bridal Accessories</a>
											<ul>
												<li class="navigation-item-6e2d34bf-a854-4830-8987-9c4e4ab4a6e0">
													<a href="<?php echo site_url(); ?>" title="Bridal Sashes">Bridal Sashes</a>
												</li>
												<li class="navigation-item-fcae4ca5-83cc-41ce-a90f-6da9e55ac922">
													<a href="<?php echo site_url(); ?>" title="Bridal Clutches &amp; Gloves">Bridal Clutches &amp; Gloves</a>
												</li>
											</ul>
										</li>
										
										<li class="navigation-item-59f1e2e7-1e1e-433a-9483-28a214e078d9">
											<a href="<?php echo site_url(); ?>" title="Bridal Shoes">Bridal Shoes</a>
										</li>
									</ul>
								</li>
								
								<li class="navigation-item-3a19e371-339c-428b-8760-9fd111ab8cdc">
									<a href="<?php echo site_url(); ?>" title="Mother Of The Bride">
										Mother Of The Bride
									</a>
									<ul>
										<li class="navigation-item-d99241e7-b752-4ecd-9a18-8aaaf8f157b0">
											<a href="<?php echo site_url(); ?>" title="View All Dresses">View All Dresses</a>
										</li>
			
										<li class="navigation-item-c9bd7788-cbdb-46cb-a132-16e04bad960f">
											<a href="<?php echo site_url(); ?>" title="Bridesmaid Dresses">Bridesmaid Dresses</a>
											<ul>
												<li class="navigation-item-3b2601ac-b726-4f48-b1c9-7fdd1850cf58">
													<a href="<?php echo site_url(); ?>" title="Long">Long</a>
												</li>
												<li class="navigation-item-1415b4ba-8a5f-420e-8e7d-d1f35b7a0747">
													<a href="<?php echo site_url(); ?>" title="Short">Short</a>
												</li>
												<li class="navigation-item-6ca0fb69-6e1c-4fa0-adea-54381af7e669">
													<a href="<?php echo site_url(); ?>" title="Lace">Lace</a>
												</li>
												<li class="navigation-item-c3002a74-2b0b-4cbf-bf01-af07860c77b8">
													<a href="<?php echo site_url(); ?>" title="Convertible">Convertible</a>
												</li>
											</ul>
										</li>
									
										<li class="navigation-item-db0e39c6-c5db-408f-941e-2f6e97d329d0">
											<a href="<?php echo site_url(); ?>" title="Bridesmaid Separates">Bridesmaid Separates</a>
											<ul>
												<li class="navigation-item-b95050e3-6810-40e5-8889-40e29b202b9e">
													<a href="<?php echo site_url(); ?>" title="Tops">Tops</a>
												</li>
												<li class="navigation-item-a2021417-1e8a-49f8-9ced-a1e334d5cd07">
													<a href="<?php echo site_url(); ?>" title="Skirts">Skirts</a>
												</li>
											</ul>
										</li>
									
										<li class="navigation-item-28207134-02d4-4fe0-8aff-e7ca065346fa">
											<a href="<?php echo site_url(); ?>" title="Maid of Honor Dresses">Maid of Honor Dresses</a>
										</li>
					
										<li class="navigation-item-665c5155-76b8-4e97-8489-98d8d4d67cf9">
											<a href="<?php echo site_url(); ?>" title="Bridesmaid Gifts">Bridesmaid Gifts</a>
										</li>
									
										<li class="navigation-item-40d6e93f-0fa2-4454-9e0c-c6127fcf6fae">
											<a href="<?php echo site_url(); ?>" title="Bridesmaid Accessories">Bridesmaid Accessories</a>
										</li>
									
										<li class="navigation-item-36fbe550-68c1-42b3-8b94-b7c3bef13924">
											<a href="<?php echo site_url(); ?>" title="Bridesmaid Jewelry">Bridesmaid Jewelry</a>
										</li>
									
										<li class="navigation-item-40f6c696-94c5-4494-b939-b9908b469f13">
											<a href="<?php echo site_url(); ?>" title="Mix &amp; Match">Mix &amp; Match</a>
										</li>
									</ul>
								</li>
							
								<li class="navigation-item-561a9a55-fa68-425a-9a40-6720c28cc7c4">
									<a href="<?php echo site_url(); ?>" title="Made To Order">
										Made To Order
									</a>
									<ul>
										<li class="navigation-item-fb5224ee-4351-4b63-a605-c63c2d1e8b26">
											<a href="<?php echo site_url(); ?>" title="View All Dresses">View All Dresses</a>
										</li>
										<li class="navigation-item-da61626f-87e1-4034-82a0-ebed5755eebd">
											<a href="<?php echo site_url(); ?>" title="Party Dresses">Party Dresses</a>
										</li>
										<li class="navigation-item-762c3290-b4dc-4af6-9985-56ff4ab5e74a">
											<a href="<?php echo site_url(); ?>" title="Mother of the Bride Dresses">Mother of the Bride Dresses</a>
											<ul>
												<li class="navigation-item-99f53df7-b1fd-4bb2-a839-29841810d06e">
													<a href="<?php echo site_url(); ?>" title="Mother of the Bride Jewelry">Mother of the Bride Jewelry</a>
												</li>
												<li class="navigation-item-50a2468c-8c82-4d04-93d3-45424c4d8e88">
													<a href="<?php echo site_url(); ?>" title="Mother of the Bride Accessories">Mother of the Bride Accessories</a>
												</li>
												<li class="navigation-item-9ad8e910-65d7-405a-ad53-ac227df49b34">
													<a href="<?php echo site_url(); ?>" title="Mother of the Bride Gifts">Mother of the Bride Gifts</a>
												</li>
											</ul>
										</li>
										<li class="navigation-item-058f548b-6b48-47ec-b72e-5ee3a336ce9d">
											<a href="<?php echo site_url(); ?>" title="Flower Girl Dresses">Flower Girl Dresses</a>
										</li>
									</ul>
								</li>
								
								<li class="navigation-item-4d452794-4493-4afb-b265-d711d68bdc9e">
									<a href="<?php echo site_url(); ?>" title="Shows &amp; Events">
										Shows &amp; Events
									</a>
									<ul>
										<li class="navigation-item-fcf11759-2a5e-42aa-9a09-71e19f789b56">
											<a href="<?php echo site_url(); ?>" title="Dresses &amp; Separates">Dresses &amp; Separates</a>
										</li>
										<li class="navigation-item-0961eebd-2115-4c90-b9d5-e2bacc019c44">
											<a href="<?php echo site_url(); ?>" title="Swim">Swim</a>
										</li>
										<li class="navigation-item-3a76fdae-8ddb-40e9-88c9-d4fd79f5fab8">
											<a href="<?php echo site_url(); ?>" title="Cover Ups">Cover Ups</a>
										</li>
										<li class="navigation-item-c18de56d-bfc2-420d-9e4c-03f342f3af58">
											<a href="<?php echo site_url(); ?>" title="Accessories">Accessories</a>
										</li>
									</ul>
								</li>
								
								<!--
								<li class="navigation-item-3df1d9c3-1cc7-46c2-bef2-67b5f46e7fea">
									<a href="<?php echo site_url(); ?>" title="Accessories">
										Accessories
									</a>
									<ul>
										<li class="navigation-item-940b9e4b-4dec-41fe-916e-dc3c87ecd690">
											<a href="<?php echo site_url(); ?>" title="Shoes">Shoes</a>
										</li>
										<li class="navigation-item-f0ecfbc5-2e24-42a9-9322-e33dd476d16d">
											<a href="<?php echo site_url(); ?>" title="Jewelry">Jewelry</a>
											<ul>
												<li class="navigation-item-9b50e567-971d-4558-9825-82cb199d7e6c">
													<a href="<?php echo site_url(); ?>" title="Earrings">Earrings</a>
												</li>
												<li class="navigation-item-1cf57b20-166c-45d3-934d-4674ef3adba6">
													<a href="<?php echo site_url(); ?>" title="Bracelets">Bracelets</a>
												</li>
												<li class="navigation-item-88658baf-af87-4828-9630-09cce679c076">
													<a href="<?php echo site_url(); ?>" title="Rings">Rings</a>
												</li>
												<li class="navigation-item-ccce227d-15c0-46f4-860d-0f5ddaefa432">
													<a href="<?php echo site_url(); ?>" title="Necklaces">Necklaces</a>
												</li>
											</ul>
										</li>
										<li class="navigation-item-dd0dd252-f38f-4dc0-a6a9-fa4e715da0da">
											<a href="<?php echo site_url(); ?>" title="Veils">Veils</a>
											<ul>
												<li class="navigation-item-c16cf986-0183-476c-88ae-05dff43446ae">
													<a href="<?php echo site_url(); ?>" title="Cathedral &amp; Chapel">Cathedral &amp; Chapel</a>
												</li>
												<li class="navigation-item-c5bbadac-8327-42c7-b26b-a1885a7cf67f">
													<a href="<?php echo site_url(); ?>" title="Ballet &amp; Fingertip">Ballet &amp; Fingertip</a>
												</li>
												<li class="navigation-item-39c58a25-ee0e-4a09-a10c-7d13c084d675">
													<a href="<?php echo site_url(); ?>" title="Blusher">Blusher</a>
												</li>
											</ul>
										</li>
										<li class="navigation-item-5be639b7-1124-434c-82c7-4e1273824295">
											<a href="<?php echo site_url(); ?>" title="Headpieces">Headpieces</a>
											<ul>
												<li class="navigation-item-2aa6a204-4fde-4d4d-b514-07ad5e0270c2">
													<a href="<?php echo site_url(); ?>" title="Halos &amp; Headbands">Halos &amp; Headbands</a>
												</li>
												<li class="navigation-item-08a74b63-e3ef-402f-9bda-59545f10c13e">
													<a href="<?php echo site_url(); ?>" title="Pins, Clips &amp; Combs">Pins, Clips &amp; Combs</a>
												</li>
											</ul>
										</li>
										<li class="navigation-item-0f84332e-e7c3-447e-b40f-952ccefc076c">
											<a href="<?php echo site_url(); ?>" title="Cover Ups">Cover Ups</a>
										</li>
										<li class="navigation-item-ea2b5613-a02a-4c62-baaa-c1ea04979857">
											<a href="<?php echo site_url(); ?>" title="Belts &amp; Sashes">Belts &amp; Sashes</a>
										</li>
										<li class="navigation-item-868b5912-2c53-490e-a480-13748ec29916">
											<a href="<?php echo site_url(); ?>" title="Clutches &amp; Gloves">Clutches &amp; Gloves</a>
										</li>
										<li class="navigation-item-661d0792-9fd5-4906-86cc-cd658683fec0">
											<a href="<?php echo site_url(); ?>" title="Lingerie">Lingerie</a>
											<ul>
												<li class="navigation-item-f47a25f5-9cb7-4f7e-ba66-c6c485476552">
													<a href="<?php echo site_url(); ?>" title="Robes">Robes</a>
												</li>
												<li class="navigation-item-1a00a649-8ad2-4387-b36e-383591f4ad55">
													<a href="<?php echo site_url(); ?>" title="Sleepwear">Sleepwear</a>
												</li>
												<li class="navigation-item-eed61de9-dbf9-40c3-8aaa-b32b2f65ac26">
													<a href="<?php echo site_url(); ?>" title="Lingerie Sets">Lingerie Sets</a>
												</li>
												<li class="navigation-item-781c6c25-02f0-426a-9013-ca9fe35d96bf">
													<a href="<?php echo site_url(); ?>" title="Garters &amp; Hosiery">Garters &amp; Hosiery</a>
												</li>
												<li class="navigation-item-ef4db91f-cbb0-4b5a-a3e8-eba3eeea22c5">
													<a href="<?php echo site_url(); ?>" title="Bras">Bras</a>
												</li>
												<li class="navigation-item-2f7e7f16-8b4c-4bf6-b6bd-89f213971e62">
													<a href="<?php echo site_url(); ?>" title="Panties">Panties</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								
								<li class="navigation-item-616cbe67-5ef7-48ff-9d28-e57bbfe361c2">
									<a href="<?php echo site_url(); ?>" title="Décor">
										Décor
									</a>
									<ul>
										<li class="navigation-item-38161ebf-3583-4d5f-a253-93764fbb37d5">
											<a href="<?php echo site_url(); ?>" title="View All Décor">View All Décor</a>
										</li>
										<li class="navigation-item-d1474973-1bc6-407c-ad65-dc9d906d9831">
											<a href="<?php echo site_url(); ?>" title="Gifts">Gifts</a>
											<ul>
												<li class="navigation-item-ec4fdd97-f64a-4aed-95a6-bed3d3e50b04">
													<a href="<?php echo site_url(); ?>" title="For the Bride">For the Bride</a>
												</li>
												<li class="navigation-item-3ebc148e-eaa4-479a-a304-c6094a1192c9">
													<a href="<?php echo site_url(); ?>" title="For the Bridal Party">For the Bridal Party</a>
												</li>
												<li class="navigation-item-b1790810-397f-42bc-aac5-4b90cb1bdaeb">
													<a href="<?php echo site_url(); ?>" title="For the Groom">For the Groom</a>
												</li>
												<li class="navigation-item-6b83f703-c68d-4347-9606-979b3615320d">
													<a href="<?php echo site_url(); ?>" title="Books &amp; Stationery">Books &amp; Stationery</a>
												</li>
												<li class="navigation-item-b5e0fad9-577f-42af-99e3-2e87463cffa5">
													<a href="<?php echo site_url(); ?>" title="Gifts Under $50">Gifts Under $50</a>
												</li>
											</ul>
										</li>
										<li class="navigation-item-939a96a2-c840-4c8a-b93f-4854bb08c89f">
											<a href="<?php echo site_url(); ?>" title="Decorations">Decorations</a>
										</li>
										<li class="navigation-item-20d70128-6aa2-4847-8578-6d609047721b">
											<a href="<?php echo site_url(); ?>" title="Centerpieces">Centerpieces</a>
										</li>
										<li class="navigation-item-39d49a7d-aaca-4a01-b820-41119cb9742a">
											<a href="<?php echo site_url(); ?>" title="Table Signage">Table Signage</a>
										</li>
										<li class="navigation-item-f1332b38-648c-4a7c-8010-c33d3d31e568">
											<a href="<?php echo site_url(); ?>" title="Ceremony">Ceremony</a>
										</li>
										<li class="navigation-item-24ce5557-e971-4c04-ad76-546b0882d2ce">
											<a href="<?php echo site_url(); ?>" title="Tabletop">Tabletop</a>
										</li>
										<li class="navigation-item-b1103fc4-c8f9-4d16-87d7-5382b0187196">
											<a href="<?php echo site_url(); ?>" title="Cake Accessories">Cake Accessories</a>
										</li>
										<li class="navigation-item-213ec421-4c8c-492a-b20c-6f75ac6998b3">
											<a href="<?php echo site_url(); ?>" title="Stationery">Stationery</a>
										</li>
									</ul>
								</li>
								
								<li class="navigation-item-020caf71-8bd5-4c57-8322-480508065c34">
									<a href="<?php echo site_url(); ?>" title="Sale">
										Sale
									</a>
									<ul>
										<li class="navigation-item-68fdcde0-1908-4474-8b60-70f87c12e560">
											<a href="<?php echo site_url(); ?>" title="Just Added">Just Added</a>
										</li>
										<li class="navigation-item-ff793973-88be-4658-b8fc-2f49a9aae152">
											<a href="<?php echo site_url(); ?>" title="Wedding Dresses">Wedding Dresses</a>
										</li>
										<li class="navigation-item-718f245e-f615-46e7-9d81-1c13fd295446">
											<a href="<?php echo site_url(); ?>" title="Dresses">Dresses</a>
										</li>
										<li class="navigation-item-1ca01b2d-bc7c-42ad-84e9-20d4651f56ed">
											<a href="<?php echo site_url(); ?>" title="Shoes">Shoes</a>
										</li>
										<li class="navigation-item-b900a7f4-6882-4b7d-a186-e0859125f084">
											<a href="<?php echo site_url(); ?>" title="Jewelry">Jewelry</a>
										</li>
										<li class="navigation-item-17c4375a-63ea-456f-ad5b-d32de5e94843">
											<a href="<?php echo site_url(); ?>" title="Accessories">Accessories</a>
										</li>
										<li class="navigation-item-5c4f2710-8dbb-430f-b9ca-9306ff746969">
											<a href="<?php echo site_url(); ?>" title="Headpieces">Headpieces</a>
										</li>
										<li class="navigation-item-5f50d3f4-b179-4c7e-8de1-0eb50c13f293">
											<a href="<?php echo site_url(); ?>" title="Lingerie">Lingerie</a>
										</li>
										<li class="navigation-item-88b01f34-644b-4eea-92ac-c5cce1b218b6">
											<a href="<?php echo site_url(); ?>" title="Décor">Décor</a>
										</li>
										<li class="navigation-item-4639dedd-6c0e-42b6-860e-46c559ca2ce0">
											<a href="<?php echo site_url(); ?>" title="Cover Ups">Cover Ups</a>
										</li>
									</ul>
								</li>
								-->
							</ul>
						</div><!-- #nav-mobile -->

                    
						<?php
						/**********
						 * -----
						 *
						 
                        <div class="ct ct-globalbody clearfix">
                            <script type="text/javascript">
								if (window.location == "http://www.roden.com/b-inspired-designers/?designerID=52c43c4f-6c69-4c86-b334-028d5ea0f0df")
								{
									window.location = "http://www.roden.com/marchesa";
								}
							</script>
                        </div>
						 */
						?>

					</div><!-- end HEADER -->
	
					<?php
					/**********
					 * CONTENT
					 */
					?>
					<div id="content" class="content clearfix">
					
						<div id="main" class="content-grid  clearfix" role="main">
							<div class="ct ct-body clearfix">
								<!-- mod: 04-12-2016 -->
								
								<div class="homepage">
									<div class="roden-creative">
									
										<?php
										/**********
										 * First image container
										 */
										?>
										<div class="container-one">
											<div class="inner">
												<div class="copy-container tablet-only">
													<div class="title-block">
														<h1>Boho <i>Forever</i></h1>
													</div>
													<div class="copy-block hide-mobile">
														<p>
															<i>Meet a new kind of bohemian</i> where lace and tulle are paired with the unexpected – corsets, crystal petals & daring backs
														</p>
													</div>
												</div>
												<div class="image-block">
													<?php
													/**********
													 * Using the picturefill javascript
													 */
													?>
													<a href="<?php echo site_url(); ?>">
														<picture>
															<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_01.jpg" media="(min-width: 768px)" />
															<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_mobile_01.jpg" />
															<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_01.jpg" alt="" />
														</picture>
													</a>
												</div>
												<div class="copy-container mobile-cta">
													<div class="title-block hide-tablet">
														<h1>Boho <i>Forever</i></h1>
													</div>
													<div class="copy-block hide-tablet">
														<p>
															<i>Meet a new kind of bohemian</i> where lace and tulle are paired with the unexpected – corsets, crystal petals & daring backs
														</p>
													</div>
													<div class="cta-block">
														<a href="<?php echo site_url(); ?>">
															<p class="cta">
																<span>Shop new</span>
															</p>
														</a>
													</div>
												</div>
											</div>
											<!-- .inner -->
										</div>
										<!-- .container-one -->
										
										<?php
										/**********
										 * Second image container
										 * of three images (two rows)
										 */
										?>
										<div class="container-two">
											<div class="inner">
											
												<?php
												/**********
												 * Top Row (section)
												 */
												?>
												<div class="clearfix top-half hide-mobile">
													<div class="left-half">
														<div class="copy-container">
															<div class="copy-block">
																<p>
																	Luxe
																	<br /> Embellishment </br>
																	<span>/ Modern</span>
																	<br /> Silhouettes
																</p>
															</div>
															<div class="title-block">
																<p class="large-text">
																	<span class="one">An</span> <span class="two">ethereal</span> <span class="three">duo</span>
																</p>
															</div>
															<div class="copy-block products">
																<p><a href="<?php echo site_url(); ?>">Tabitha Gown</a> // <a href="<?php echo site_url(); ?>">Naya Dress</a> // <a href="<?php echo site_url(); ?>">Hazel Dress</a></p>
															</div>
														</div>
													</div>
													<div class="right-half">
														<div class="image-block">
															<a href="<?php echo site_url(); ?>">
																<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_02.jpg" alt="" />
															</a>
														</div>
													</div>
												</div>
												
												<?php
												/**********
												 * Bottom Row (section)
												 */
												?>
												<div class="bottom-half">
													<div class="left-half hide-mobile">
														<div class="image-block">
															<a href="<?php echo site_url(); ?>">
																<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_03.jpg" alt="" />
															</a>
														</div>
														<div class="copy-container">
															<div class="copy-block products">
																<p>
																	<a href="<?php echo site_url(); ?>">Mara Jumpsuit</a> // <a href="<?php echo site_url(); ?>">Francine Top</a> &amp; <a href="<?php echo site_url(); ?>">Almira Skirt</a>
																</p>
															</div>
															<div class="cta-block">
																<a href="<?php echo site_url(); ?>">
																	<p class="cta">
																		<span>Shop gowns</span>
																	</p>
																</a>
															</div>
														</div>
													</div>
													<div class="right-half">
														<div class="inner">
															<div class="image-block">
																<a href="<?php echo site_url(); ?>">
																
																	<?php
																	/**********
																	 * Using the picturefill javascript
																	 */
																	?>
																	<picture>
																		
																		<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_04.jpg" media="(min-width: 768px)" />
																		<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_mobile_02.jpg" />
																		<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_04.jpg" alt="" />
																		
																	</picture>
																</a>
															</div>
															<div class="copy-container">
																<div class="cta-block">
																	<a href="<?php echo site_url(); ?>">
																		<p class="cta">
																			<span>Shop reception</span>
																		</p>
																	</a>
																</div>
																<div class="copy-block products">
																	<p><a href="<?php echo site_url(); ?>">Bailey Dress</a></p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- .container-two -->
		
										<?php
										/**********
										 * Third image container
										 * about Full width section
										 */
										?>
										<div class="container-three">
											<div class="inner">
												<div class="image-block">
													<a href="<?php echo site_url(); ?>">
													
														<?php
														/**********
														 * Using the picturefill javascript
														 */
														?>
														<picture>
															
															<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_05.jpg" media="(min-width: 768px)" />
															<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_mobile_03.jpg" />
															<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_05.jpg" alt="" />
															
														</picture>
													</a>
												</div>
												<div class="copy-container">
													<div class="title-block">
														<p class="large-text">
															Build<br /> <i>Your own</i> <br />look
														</p>
													</div>
													<div class="cta-block">
														<a href="<?php echo site_url(); ?>">
															<p class="cta">
																<span>Shop bridal separates</span>
															</p>
														</a>
													</div>
													<div class="copy-block products">
														<p>
															<a href="<?php echo site_url(); ?>">Faymi Corset</a> &amp; <a href="<?php echo site_url(); ?>">Ahsan Skirt</a> //
															<br />
															<a href="<?php echo site_url(); ?>">Salene Taffeta Corset</a> &amp; <a href="<?php echo site_url(); ?>">Amora Skirt</a> //
															<br />
															<a href="<?php echo site_url(); ?>">Carina Corset</a> &amp; <a href="<?php echo site_url(); ?>">Maisey Skirt</a>
														</p>
													</div>
												</div>
											</div>
										</div>
										<!-- .container-three -->
		
										<?php
										/**********
										 * Fourth image container
										 */
										?>
										<div class="container-four">
											<div class="inner">
												<div class="left-half">
													<div class="copy-container">
														<div class="title-block hide-mobile">
															<p class="large-text">
																Organic <span class="one">adorn</span>ments
															</p>
														</div>
														<div class="copy-block hide-mobile">
															<p>Floral lace / freshwater pearls</p>
														</div>
														<div class="cta-block">
															<a href="<?php echo site_url(); ?>">
																<p class="cta">
																	<span>Shop accessories</span>
																</p>
															</a>
														</div>
													</div>
												</div>
												<div class="right-half">
													<div class="image-block">
														<a href="<?php echo site_url(); ?>">
														
															<?php
															/**********
															 * Using the picturefill javascript
															 */
															?>
															<picture>
																
																<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_06.jpg" media="(min-width: 768px)" />
																<source srcset="<?php echo base_url(); ?>roden_assets/images/051016_may_mobile_04.jpg" />
																<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_06.jpg" alt="" />
																
															</picture>
														</a>
													</div>
													<div class="copy-block products hide-tablet">
														<p><a href="<?php echo site_url(); ?>">Adelina Lace Veil</a></p>
													</div>
												</div>
											</div>
										</div>
										<!-- .container-four -->
		
										<?php
										/**********
										 * Fifth image container
										 * Boxed grid single image
										 */
										?>
										<div class="container-five">
											<div class="inner">
												<div class="image-block">
													<a href="<?php echo site_url(); ?>">
														<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_07.jpg" alt="" />
													</a>
												</div>
												<div class="copy-container">
													<div class="cta-block">
														<a href="<?php echo site_url(); ?>">
															<p class="cta">
																<span>Shop back detail</span>
															</p>
														</a>
													</div>
													<div class="copy-block products">
														<p><a href="<?php echo site_url(); ?>">Amalia Gown</a> // <a href="<?php echo site_url(); ?>">Jensen Gown</a></p>
													</div>
												</div>
												<div class="mobile-only">
													<a href="<?php echo site_url(); ?>">
														<img class="not-loaded" src="<?php echo base_url(); ?>roden_assets/images/051016_may_mobile_05.jpg" alt="" />
													</a>
													<div class="cta-block">
														<a href="<?php echo site_url(); ?>">
															<p class="cta">
																<span>Shop gowns</span>
															</p>
														</a>
													</div>
												</div>
											</div>
										</div>
										<!-- .container-four -->
										
									</div>
								</div><!-- .homepage -->

							</div><!-- end CT BODY -->
						</div><!-- end MAIN -->
						
						<a class="screenreaderonly" href="#wrap">Top of Page</a>

					</div><!-- end #content -->
                
				</div>
				<!-- #wrap-content -->
				
				<footer>
				
					<ul class="footer-nav">
						<!--
						<li class="about">
							<a href="<?php echo site_url(); ?>" class="about-link  js-about-link">Our Collection</a>
						</li>
						<li class="help">
							<a href="<?php echo site_url(); ?>">Customer Service</a>
						</li>
						-->
						<li class="ordering">
							<a href="<?php echo site_url('ordering'); ?>">Ordering</a>
						</li>
						<li class="shipping">
							<a href="<?php echo site_url('shipping'); ?>">Shippping</a>
						</li>
						<li class="privacy">
							<a href="<?php echo site_url('privacy'); ?>">Privacy</a>
						</li>
						<li class="faq">
							<a href="<?php echo site_url('faq'); ?>">FAQ</a>
						</li>
						<li class="sitemap">
							<a href="<?php echo site_url('sitemap'); ?>">Sitemap</a>
						</li>
						<li class="contact">
							<a href="<?php echo site_url('contact'); ?>">Contact</a>
						</li>
						<!--
						<li class="stylists">
							<a href="<?php echo site_url(); ?>" data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'>Stylists</a>
						</li>
						<li class="country">
							<a href="<?php echo site_url(); ?>" title="International Preferences: Change your Country and Currency">
								USA <em>Change</em>
							</a>
						</li>
						<li class="resources">
							<a href="<?php echo site_url(); ?>"><span class="txt">Resources</span></a>
						</li>
						<li class="trends">
							<a href="<?php echo site_url(); ?>"><span class="txt">Trends</span></a>
						</li>
						<li class="anthro">
							<a href="<?php echo site_url(); ?>" target="_blank">Anthropologie</a>
						</li>
						-->
					</ul>

					<?php
					/*****
					 * Will display onclick of "Our Collection" link
					 */
					?>
					<div class="about-text  js-about-text">
						<p>We offer a keen edit of wedding gowns, bridal accessories, bridesmaid dresses, wedding decor, and gifts. You can browse our full assortment of wedding dresses online at any time. Should you like to try on a style before purchasing, please contact one of our <a href="<?php echo site_url(); ?>">several locations</a> across the country to make an appointment. (Note appointments are recommended for trying on wedding dress styles only.)</p>
					</div>
					
					<?php
					/*****
					 * Socials
					 */
					?>
					<ul class="footer-social clearfix">
						<li class="facebook">
							<a href="http://www.facebook.com/"
								class="coremetrics-tag"
								data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'
								target="_blank">
								<span class="txt">Facebook</span>
								<span class="ico"></span>
							</a>
						</li>
						<!--
						<li class="twitter">
							<a href="http://twitter.com/"
								class="coremetrics-tag"
								data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'
								target="_blank">
								<span class="txt">Twitter</span>
								<span class="ico"></span>
							</a>
						</li>
						-->
						<li class="pinterest">
							<a href="http://pinterest.com/"
								class="coremetrics-tag"
								data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'
								target="_blank">
									<span class="txt">Pinterest</span>
									<span class="ico"></span>
							</a>
						</li>
						<li class="instagram">
							<a href="http://instagram.com/"
								class="coremetrics-tag"
								data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'
								target="_blank">
									<span class="txt">Instagram</span>
									<span class="ico"></span>
							</a>
						</li>
						<li class="googleplus">
							<a href="https://plus.google.com/"
								class="coremetrics-tag"
								data-coremetrics-data='{"id":"PAGE: Home","category":"FOOTER"}'
								target="_blank">
									<span class="txt">Google +</span>
									<span class="ico"></span>
							</a>
						</li>
					</ul>

					<?php
					/*****
					 * Opt In Email
					 */
					?>
					<form id="vLayout-layout-form-1" name="vLayout_layout_form_1" action="/index.cfm" method="post" class="dialog footer-signup" onSubmit="ga.send('send', 'event', 'newsletter signups', 'submit', 'footer');" data-dialog='{"dialogClass": "wl-dialog--bordered", "minHeight": 180}'>
						<input type="hidden" name="fuseaction" value="emailSignup.processBrandedSignUp" />
						<label class="primary" for="email"><span class="required">*</span><span>Email Signup</span></label>
						<input type="email" class="input-text" id="email" name="emailAddress" required="required" placeholder="sign up to receive our emails" />
						
						<div class="actionlist clearfix">
							<ul class="actions clearfix">
								<li class="action-primary action clearfix"> 
									<button type="submit" class="button--icon">Submit</button>
								</li> 
							</ul>
						</div>
					</form>
					
				</footer>
				
			</div>
			<!-- #wrap-bg2 -->
        </div>
		<!-- #wrap -->

        <ul class="sub-footer">
            <li><span class=" ">&copy; <?php echo $this->config->item('site_name').' '.date('Y', time()); ?></span></li>
            <li><a href="<?php echo site_url(); ?>">Terms of Use</a></li>
            <li><a href="<?php echo site_url(); ?>">Privacy Policy</a></li>
            <li><a href="<?php echo site_url(); ?>">CA Notice</a></li>
        </ul>

		<div id="homepageTakeover" class="clearfix">
			<div class="v-emailsignup-homesignupform clearfix">
				<h3 class="wl-h1">Sign up <span>for</span> <?php echo $this->config->item('site_name'); ?> emails</h3>
				<h2>Be the first to know about new arrivals, events, and offers.</h2>
		
				<div class="form-wrap">
					<form id="vEmailSignUp-homeSignUpForm-form-1" name="vEmailSignUp_homeSignUpForm_form_1" action="#" method="post" class="dialog" data-dialog='{"dialogClass": "wl-dialog--bordered", "minHeight": 180}'
					onSubmit="return false; ga.send('event', 'newsletter signups', 'submit', 'homepopup');">
						<input type="hidden" name="fuseaction" value="emailSignup.processHomeSignup" />
						<input type="hidden" name="isFullForm" value="1" />
				
						<div class="pairinglist clearfix" >
							
							<ul class="pairings clearfix">
								<li class="pairing-email pairing-required pairing-vertical pairing clearfix">
									<label class="primary" for="email">
										<span class="required">*</span>
										<span class="pairing-label">Email Address:</span>
										
									</label>
									<div class="pairing-content">
										
										<div class="pairing-controls"> 
												<input type="email" class="input-text email" name="emailAddress" required="required" placeholder="Enter Email" />
														</div>
									</div>
								</li>
								<li class="pairing-zip pairing-required pairing-vertical pairing clearfix">
									<label class="primary" for="zip">
										<span class="required">*</span>
										<span class="pairing-label">Zipcode:</span>
										
									</label>
									<div class="pairing-content">
										
										<div class="pairing-controls"> 
												<input type="text" class="input-text" id="zip" name="zip" placeholder="Enter Zip Code" />
														</div>
									</div>
								</li>
							</ul>
						</div>
		
						<div class="actionlist clearfix">
							<ul class="actions clearfix">
								<li class="action-primary action clearfix"> 
									<input type="submit" class="button button--large" value="Submit" />
								</li> 
							</ul>
						</div>
		
						<p class="legal-copy">By signing up, you agree to receive <?php echo $this->config->item('site_name'); ?> offers, promotions and other commerical messages. You may unsubscribe at any time.</p>
						
					</form>
				</div>
			</div>
		</div>
		
		<div class="overlay" style="display: none;"></div>
        
		<?php
		/*****
		 * ----
		 *
		 
		<!-- PointRoll Adversing Pixel -->
		<script type="text/javascript">
			//<![CDATA[
			 var prd=new Date(),pru=Date.UTC(prd.getUTCFullYear(),prd.getUTCMonth(),prd.getUTCDay(),prd.getUTCHours(),prd.getUTCMinutes(),prd.getUTCSeconds(),prd.getUTCMilliseconds());
			 var pr_eid=pru+Math.random();
			 var pr_event='';
			 var pr_item='';
			 var pr_quantity='';
			 var pr_value='';
			 document.write("<iframe class='point-roll' width='0' height='0' frameborder='0' src='http://container.pointroll.com/event/?ctid=60012257-0682-4E22-A44C-64188213446D&av=7209&eid="+pr_eid+"&ev="+pr_event+"&item="+pr_item+"&q="+pr_quantity+"&val="+pr_value+"&r="+Math.random()+"'></iframe>");
			//]]>
		</script>
		 */
		?>

		<?php
		/*****
		 * ----
		 *
		 
		<!-- Seer Sitelinks Search Box -->
		<script type="application/ld+json">
		{
		  "@context": "http://schema.org",
		  "@type": "WebSite",
		  "url": "http://www.roden.com/",
		  "potentialAction": {
			"@type": "SearchAction",
			"target": "http://www.roden.com/index.cfm?fuseaction=search.results&searchString={search_term_string}",
			"query-input": "required name=search_term_string"
		  }
		}
		</script>
		 */
		?>

		<script src="<?php echo base_url(); ?>roden_assets/js/lib-min.js"></script>
		<script src="<?php echo base_url(); ?>roden_assets/js/site-min.js"></script>
			
		<script type="text/javascript" charset="utf-8">
			//<![CDATA[
				function toggleReadMore(num, closeText, openText){
					$('.readMore' + num).slideToggle(function(){
						 $('.toggleStory').text($(this).is(':visible') ? openText : closeText);
					});
				}
			//]]>
		</script>
        
		<?php
		/*****
		 * ----
		 *
		 
		<script charset="utf-8" type="text/javascript">
			var R3_COMMON = new r3_common();
			R3_COMMON.setApiKey('8a7f2c414a01c56e');
			
			R3_COMMON.setBaseUrl(window.location.protocol+'//recs.richrelevance.com/rrserver/');
			
			R3_COMMON.setClickthruServer(window.location.protocol+"//"+window.location.host);
			R3_COMMON.setSessionId('84304b65d50da9162b4670532f2832c227b2');
			R3_COMMON.setUserId('84304b65d50da9162b4670532f2832c227b2');
			var R3_HOME = new r3_home();
			RR.jsonCallback = function(){
				WEBLINC.renderRichRelevance(RR.data.JSON.placements);
			};
			r3();
		</script>
		 */
		?>
        
		<?php
		/*****
		 * ----
		 *
		 
        <script type="text/javascript">
            adroll_adv_id = "K24PG7KO3VH4XH4FRKQOR3";
            adroll_pix_id = "FGEXM6ZOMFHULOKZ5Q26JI";
            (function () {
            var oldonload = window.onload;
            window.onload = function(){
               __adroll_loaded=true;
               var scr = document.createElement("script");
               var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
               scr.setAttribute('async', 'true');
               scr.type = "text/javascript";
               scr.src = host + "/j/roundtrip.js";
               ((document.getElementsByTagName('head') || [null])[0] ||
                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
               if(oldonload){oldonload()}};
            }());
        </script>
		 */
		?>

		<?php
		/*****
		 * ----
		 *
		 
		<!-- Google Code for Remarketing tag -->
		<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
		
		<script type="text/javascript">
		var google_tag_params = {
		ecomm_prodid: "",
		ecomm_pagetype: "home",
		ecomm_totalvalue: 0.00
		};
		</script>
		
		<script type="text/javascript">
		/* <![CDATA[ * /
		var google_conversion_id = 987982963;
		var google_conversion_label = "BkCNCKXJ_wQQ89iN1wM";
		var google_custom_params = window.google_tag_params;
		var google_remarketing_only = true;
		/* ]]> * /
		</script>
		
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/987982963/?value=0&amp;label=BkCNCKXJ_wQQ89iN1wM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>
        
        <script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"5060961"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");
        </script>
		
        <noscript><img src="//bat.bing.com/action/0?ti=5060961&Ver=2" height="0" width="0" style="display:none; visibility: hidden;" /></noscript>
		 */
		?>
        
    </body>
</html>

<!-- 10.9.5.27 (roden-APP02) -->
<!-- 42 -->