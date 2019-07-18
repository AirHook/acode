<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
	
		<?php
		/*****
		 * jQuery
		 */
		?>
        <script src="<?php echo base_url('roden_assets'); ?>/js/jquery-min.js"></script>
        
		<meta charset="utf-8" />
		<meta name="Description" content="<?php echo @$site_description ? $site_description : $this->config->item('site_description'); ?>" />
		<meta name="Keywords" content="<?php echo @$site_keywords ? $site_keywords : $this->config->item('site_keywords'); ?>" />
		<meta name="abstract" content="<?php echo $this->config->item('site_description'); ?>" />
		<meta name="allow-search" content="YES" />
		<meta name="distribution" content="Global" />
		<meta name="rating" content="General" />
		
		<meta name="pahina" content="<?php echo $file; ?>" />
		
		<!--[if IE 6]>
		<meta http-equiv="imagetoolbar" content="no" />
		<![endif]-->
		
		<meta name="MSSmartTagsPreventParsing" content="TRUE" />
		<meta name="robots" content="noodp,noydir" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>
			<?php echo @$site_title ? $this->config->item('site_name').' | '.$site_title : $this->config->item('site_title'); ?>
		</title>

		<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
		
		<?php if (ENVIRONMENT !== 'development' OR ! $this->uri->uri_string()): ?>
		<link rel="canonical" href="http://<?php echo $this->config->item('site_domain'); ?>/" /> 
		<?php endif; ?>
		
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
		
		<?php
		/*****
		 * Unslider items
		 * - used for home page sliders as well as the logo slider
		 */
		?>
		<!-- optional touchswipe file to enable swipping to navigate slideshow -->
		<script type="text/javascript" src="<?php echo base_url(); ?>jscript/unslider/jquery.event.move.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jscript/unslider/jquery.event.swipe.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>jscript/unslider/unslider-min.js"></script>
		<link type="text/css" href="<?php echo base_url(); ?>jscript/unslider/unslider.css" rel="stylesheet" />
		
		<?php
		/*****
		 * Logo Unslider Styles and Scripts
		 */
		?>
		<style>
			.logo_slider {
				padding-bottom: 12.81%;
			}
			.logo_slider_ li {
				position: absolute;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var sliderOne = $(".logo_slider").unslider({
					animation: "fade",
					autoplay: true,
					nav: false,
					arrows: false
				});
				$(".logo_slider").fadeIn(750);
			});
		</script>

		<?php
		/*****
		 * Some custom css and scripts per page
		 */
		?>
		<?php 
			if ($this->uri->uri_string() == '')
			{
				$this->load->view($this->config->slash_item('template').'template_top_custom_styles_home'); 
				?>
				
				<?php
				/*****
				 * Home Page Unslider Styles
				 */
				?>
				<style>
					#fadeshow_one.fadeslideshow_container,
					#fadeshow_three.fadeslideshow_container,
					#fadeshow_five.fadeslideshow_container {
						padding-bottom: 66.1%;
					}
					#fadeshow_m1.fadeslideshow_container,
					#fadeshow_m2.fadeslideshow_container,
					#fadeshow_m3.fadeslideshow_container,
					#fadeshow_m4.fadeslideshow_container,
					#fadeshow_m5.fadeslideshow_container,
					#fadeshow_two-a.fadeslideshow_container,
					#fadeshow_two-b.fadeslideshow_container,
					#fadeshow_two-c.fadeslideshow_container,
					#fadeshow_four.fadeslideshow_container {
						padding-bottom: 147.7%;
					}
					#fadeshow_m1 li,
					#fadeshow_m2 li,
					#fadeshow_m3 li,
					#fadeshow_m4 li,
					#fadeshow_m5 li {
						float: left !important;
					}
					.fadeslideshow_container img { /* make all images inside slider scale to 100% of slider width */
						width: 100%;
						height: auto;
					}
				</style>

				<?php
				/*****
				 * Home Page Unslider Scripts
				 */
				?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						var sliderOne = $("#fadeshow_one").unslider({
							animation: "fade",
							autoplay: true,
							nav: false,
							arrows: false
						});
						sliderOne.on('mouseover', function() {
							sliderOne.data('unslider').stop();
						}).on('mouseout', function() {
							sliderOne.data('unslider').start();
						});						
						var sliderTwoA = $("#fadeshow_two-a").unslider({
							animation: "fade",
							delay: 5000,
							autoplay: true,
							nav: false,
							arrows: false
						});
						sliderTwoA.on('mouseover', function() {
							sliderTwoA.data('unslider').stop();
						}).on('mouseout', function() {
							sliderTwoA.data('unslider').start();
						});						
						var sliderTwoB = $("#fadeshow_two-b").unslider({
							animation: "fade",
							autoplay: true,
							nav: false,
							arrows: false
						});
						sliderTwoB.on('mouseover', function() {
							sliderTwoB.data('unslider').stop();
						}).on('mouseout', function() {
							sliderTwoB.data('unslider').start();
						});						
						var sliderTwoC = $("#fadeshow_two-c").unslider({
							animation: "fade",
							delay: 4000,
							autoplay: true,
							nav: false,
							arrows: false
						});
						sliderTwoC.on('mouseover', function() {
							sliderTwoC.data('unslider').stop();
						}).on('mouseout', function() {
							sliderTwoC.data('unslider').start();
						});						
						var sliderThree = $("#fadeshow_three").unslider({
							animation: "fade",
							delay: 5000,
							autoplay: true,
							nav: false,
							arrows: false
						});
						sliderThree.on('mouseover', function() {
							sliderThree.data('unslider').stop();
						}).on('mouseout', function() {
							sliderThree.data('unslider').start();
						});						
						var sliderFour = $("#fadeshow_four").unslider({
							animation: "fade",
							autoplay: true,
							nav: false,
							arrows: false
						});
						sliderFour.on('mouseover', function() {
							sliderFour.data('unslider').stop();
						}).on('mouseout', function() {
							sliderFour.data('unslider').start();
						});						
						var sliderFive = $("#fadeshow_five").unslider({
							animation: "fade",
							delay: 5000,
							autoplay: true,
							nav: false,
							arrows: false
						});
						sliderFive.on('mouseover', function() {
							sliderFive.data('unslider').stop();
						}).on('mouseout', function() {
							sliderFive.data('unslider').start();
						});
						
						
						$("#fadeshow_m1").unslider({
							animation: "fade",
							autoplay: true,
							nav: false,
							arrows: false
						});
						$("#fadeshow_m2").unslider({
							animation: "fade",
							autoplay: true,
							delay: 5000,
							nav: false,
							arrows: false
						});
						$("#fadeshow_m3").unslider({
							animation: "fade",
							autoplay: true,
							nav: false,
							arrows: false
						});
						$("#fadeshow_m4").unslider({
							animation: "fade",
							autoplay: true,
							delay: 5000,
							nav: false,
							arrows: false
						});
						$("#fadeshow_m5").unslider({
							animation: "fade",
							autoplay: true,
							nav: false,
							arrows: false
						});
					});
				</script>
				
				<?php
				/*****
				 * Down and Page Up Arrow scripts
				 * Page Down arrow only for home page
				 */
				?>
				<script>
					// fade in #back-top
					$(function () {
						
						// first let us hide the back to top arrow
						$('#back-top a').hide();
						
						$(window).scroll(function () {
							/*
							if ($(this).scrollTop() > 100) {
								$('#back-top a').fadeIn();
							} else {
								$('#back-top a').fadeOut();
							}
							*/
							if ($(this).scrollTop() > ($(document).height() - (1.5 * $(window).height()))) {
								$('#start-page-down a').fadeOut();
								$('#back-top a').fadeIn();
							} else {
								$('#start-page-down a').fadeIn();
								$('#back-top a').fadeOut();
							}
						});

						// scroll body to 0px on click
						$('#back-top a').click(function () {
							$('body,html').animate({
								scrollTop: 0
							}, 800);
							return false;
						});

						// scroll body a page down on click
						$('#start-page-down a').click(function () {
							$('body,html').animate({
								scrollTop: $(window).scrollTop() + $(window).height()
							}, 800);
							return false;
						});
					});
				</script>
				
				<?php
			}
		?>
		
		<?php
		/*****
		 * Custom Stylesheets
		 * - to override source style wihtout editing it
		 */
		?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('roden_assets'); ?>/css/custom_common.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('roden_assets'); ?>/css/custom_<?php echo $this->config->item('site_slug'); ?>.css" />
		
		<?php
		/*****
		 * Google Analytics
		 */
		$this->load->view('tracking_code/'.$this->config->item('site_slug'));
		?>
		
    </head>
	
    <body id="body-tag" class="home_switch_page" style="background-color:black;color:white;text-align:center;">
	
		<div class="wrapper" style="text-align:center;">
		<div class="logo" style="margin-top:8%;">
			<img src="<?php echo base_url(); ?>roden_assets/images/logo-<?php echo $this->config->item('site_slug'); ?>.png" />
		</div>
		<p>Please choose from options below to enter</p>
		<div class="switch_options" style="margin:100px auto 0;height:300px;width:900px;">
			<div class="icon_box" style="display:table-cell;width:300px;height:300px;background-color:grey;text-align:center;">
				<div style="text-align:center;padding:0 20px;">
					<h2 style="font-size:1.2rem;margin:0;">SHOP ONLINE CONSUMERS</h2>
					<p>
						Order items for your personal user and browse the in-stock items
					</p>
				</div>
			</div>
			<div class="icon_box" style="display:table-cell;width:300px;height:300px;text-align:center;">
				&nbsp;
			</div>
			<div class="icon_box" style="display:table-cell;width:300px;height:300px;background-color:grey;text-align:center;">
				<div style="text-align:center;padding:0 20px;">
					<h2 style="font-size:1.2rem;margin:0;">SHOP ONLINE WHOLESALE BUYER</h2>
					<p>
						Browse and order items for your store
					</p>
				</div>
			</div>
		</div>

	</body>
</html>

