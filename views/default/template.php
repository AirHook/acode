<!DOCTYPE html>
<html lang="en">

<head>
	
	<title><?php echo @$this->webspace_details->name.(@$this->page_details->title ? ' | '.$this->page_details->title : (@$page_title ? ' | '.$page_title: '')); ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
	<META HTTP-EQUIV="EXPIRES" CONTENT="0">
	<meta name="description" content="<?php echo @$this->webspace_details->description.(@$this->page_details->description ? ', '.$this->page_details->description : '').(@$page_description ? ', '.@$page_description : ''); ?>" />
	<meta name="keywords" content="<?php echo @$this->webspace_details->keywords.(@$this->page_details->keywords ? ', '.$this->page_details->keywords : '').(@$page_keywords ? ', '.@$page_keywords : ''); ?>" />
	<meta name="author" content="Instyle" />
	<meta name="subject" content="<?php echo $this->config->item('site_subject'); ?>" />
	<meta name="coverage" content="worldwide" />
	<meta name="Content-Language" content="english" />
	<meta name="resource-type" content="document" />
	<meta name="robots" content="all,index,follow" />
	<meta name="classification" content="<?php echo $this->config->item('site_name'); ?>" />
	<meta name="rating" content="general" />
	<meta name="revisit-after" content="10 days" />
	<link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" /> 
	<link href="<?php echo base_url('assets/default'); ?>/style/main.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/default'); ?>/style/style_b.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/default'); ?>/style/style.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url('assets/default'); ?>/assets/css/style_default.css" rel="stylesheet" type="text/css"/>
	
	<?php if (ENVIRONMENT === 'development') { ?>
	<script type="text/javascript" src="<?php echo base_url('assets/custom'); ?>/jscript/jquery-3.2.1.min.js"></script>
	<?php } else { ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<?php } ?>
	
	<script type="text/javascript" src="<?php echo base_url('assets/default'); ?>/assets/js/jstools.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/default'); ?>/js/stayontop.js"></script>

	<?php echo @$jscript; ?>

	<?php
	/*****
	 * Unslider items
	 * - used for home page sliders as well as the logo slider
	 */
	?>
	<!-- optional touchswipe file to enable swipping to navigate slideshow -->
	<script type="text/javascript" src="<?php echo base_url('assets/custom'); ?>/jscript/unslider/jquery.event.move.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/custom'); ?>/jscript/unslider/jquery.event.swipe.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/custom'); ?>/jscript/unslider/unslider-min.js"></script>
	<link type="text/css" href="<?php echo base_url('assets/custom'); ?>/jscript/unslider/unslider.css" rel="stylesheet" />
	
	<?php
	/*****
	 * Logo Unslider Styles and Scripts
	 */
	?>
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

	<style>
		body { vertical-align:top; }
		td { vertical-align:top; }
		.left { line-height:20px; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; }
		.left a { color:#999999; text-decoration:none; }
		.left a:hover { color:#CC0000; text-decoration:none; }
		
		div.pagination {
			padding: 3px 0px 3px 3px;
			margin: 2px 0px 3px 17px;
			display: inline;
		}

		div.pagination a {
			padding: 2px 5px 2px 5px;
			margin: 2px 2px 2px 2px;
			border: 1px solid #996600;
			text-decoration: none; /* no underline */
			color:#666666;
		}
		div.pagination a:hover, div.pagination a:active {
			border: 1px solid #CC3300;

			color: #000;
		}
		div.pagination span.current {
			padding: 2px 5px 2px 5px;
			margin: 2px;
			border: 1px solid #888888;
			font-weight: bold;
			background-color: #CC3300;
			color: #FFF;
			}
		div.pagination span.disabled {
			padding: 2px 5px 2px 5px;
			margin: 2px;
			border: 1px solid #EEE;

			color: #DDD;
		}
		div.pagination a.viewall {
			font-family:Arial, Helvetica, sans-serif;
			font-size:11px; font-weight:normal;
			text-align:justify;
			text-decoration:none;
			padding: 2px 5px 2px 5px;
			margin: 2px;
			border: 1px solid #EEE;
			color: #DDD;
		}

		.faceted_search { font-size:9px; line-height:10px; font-family:"tahoma"}

		#dvloader {
			position: fixed;
			z-index: 99;
			top: 0px;
			left: 0px;
			background-color: black;
			width: 100%;
			height: 100%;
			filter: Alpha(Opacity=40);
			opacity: 0.4;
			-moz-opacity: 0.4;
			text-align: center;
			padding-top: 350px;
		}
		#div_loader {
			position: fixed;
			z-index: 99;
			top: 0px;
			left: 0px;
			background-color: black;
			width: 100%;
			height: 100%;
			filter: Alpha(Opacity=40);
			opacity: 0.6;
			-moz-opacity: 0.6;
			text-align: center;
		}
		#img_loader {
			position: relative;
			margin: 0 50% 0;
			z-index: 200;
			padding: 20px;
			background-color: black;
			border: 1px solid #9a9a9a;
			width: 220px;
			text-align: center;
			color: white;
			font-family: Verdana; 
		}
		#img_loader p {
			margin: 0;
			padding: 10px 0 0;
			font-size: 12px;
		}
		
		#dvloader2 {
			position: fixed;
			z-index: 99;
			top: 0px;
			left: 0px;
			background-color: transparent;
			width: 100%;
			height: 100%;
			text-align: center;
			padding-top: 350px;
		}
		
		.dialog_runway_video {
			position: fixed;
		}
	</style>

	<?php
	// place google analytics code here
	if (ENVIRONMENT === 'production')
	{
		echo @$this->webspace_details->options['google_analtyics'] ?: $this->config->item('google_analtyics');
	}
	?>

	<?php
		echo isset($function_reset_checkboxes) ? $function_reset_checkboxes : '';
	?>

</head>

<body <?php echo isset($reset_checkbox) ? $reset_checkbox : ''; echo isset($onload_scripts) ? $onload_scripts : ''; ?>>

<?php echo isset($div_loader) ? $div_loader : ''; ?>

	<table border="0" cellspacing="0" cellpadding="0" width="100%">

		<?php
		/*
		| -------------------------------------------------------------------------------
		| Top nav
		*/
		?>
		<tr><td id="headblackbg" style="height:40px;">
			<?php $this->load->view('default/top_nav'); ?>
		</td></tr>

		<?php
		/*
		| -------------------------------------------------------------------------------
		| Content Section (this row contains content and footer and footnote
		*/
		?>
		<tr><td>

			<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
			
				<?php
				/*
				| -------------------------------------------------------------------------------
				| Content section
				*/
				?>
				<tr>
					<td><?php $this->load->view('default/'.$file); ?></td>
				</tr>
			  
				<?php die();
				/*
				| -------------------------------------------------------------------------------
				| Footer to footnote section
				*/
				?>
				<tr><td>
				
					<div id="botwhitebg" align="center">
					<div style="border-top:#999999 1px solid;padding-top:10px;">
					<table cellspacing="0" cellpadding="0" width="100%" border="0">
						<tr>
							<td align="left" valign="top">
								<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr>
								<?php
								/*
								| --------------------------------------------------------------------------------------
								| Footer Links by categories
								|
								| NOTES: This footer product subcat links are now universal between instyle and satellite sites
								*/
								$cat_res = $this->set->get_category();
								if($cat_res->num_rows() > 0)
								{
									foreach($cat_res->result() as $cat_rec)
									{
										if ($cat_rec->cat_name != 'Accessories' && $cat_rec->cat_name != 'Outerwear')
										{ ?>
											<td style="vertical-align:top;">
											
												<div class="normal_txt1">
													<?php
													// user 'COLLECTIONS' for satellite sites
													if ($this->config->item('site_domain') !== 'www.instylenewyork.com')
													{
														if (strtoupper($cat_rec->cat_name) == 'WOMENS APPAREL') echo 'COLLECTIONS';
													}
													else
													{
														echo strtoupper($cat_rec->cat_name);
													}
													?>
												</div>
											
												<?php
												//$cat_qry1 = $this->query_category->get_subcat_new($cat_rec->url_structure);
												$cat_qry1 = $this->query_category->get_subcat_new('apparel', $this->config->item('site_slug'));
												if($cat_qry1->num_rows() > 0)
												{
													foreach($cat_qry1->result() as $cat_rec1)
													{
														$url  	 = '';
														$url 	.= $cat_rec1->c_url_structure.'/';
														$url 	.= $cat_rec1->sc_url_structure;
														
														echo anchor(str_replace('https','http',site_url($url)),$cat_rec1->subcat_name,array('class'=>'normal_txt3')).'<br>';
													} 
												}
												?>
											</td>
											<?php
										}
									} 
								}
								else
								{
									echo '<td>No category return</td>';
								}
								?>
								</tr>
								</table>
							</td>
							<td align="right" valign="top">
								<table border=0 cellpadding=0 cellspacing=0>
									<tr><td align=right style="vertical-align:top;">
									
										<?php
										if ($this->session->userdata('user_cat') == 'wholesale')
										{ ?>
											<?php $link_class = uri_string() == 'wholesale_ordering' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('wholesale_ordering')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDERING</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'wholesale_return_policy' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('wholesale_return_policy')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETURNS</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'wholesale_shipping' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('wholesale_shipping')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SHIPPING</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'wholesale_privacy_notice' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('wholesale_privacy_notice')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRIVACY</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'wholesale_order_status' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('wholesale_order_status')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDER STATUS</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'wholesale_faq' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('wholesale_faq')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">FAQ</a><span class="lseparator">|</span>
											<?php
										}
										else
										{ ?>
											<?php $link_class = uri_string() == 'ordering' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('ordering')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDERING</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'return_policy' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('return_policy')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETURNS</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'shipping' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('shipping')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SHIPPING</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'privacy_notice' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('privacy_notice')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRIVACY</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'order_status' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('order_status')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDER STATUS</a><span class="lseparator">|</span>
											
											<?php $link_class = uri_string() == 'faq' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('faq')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">FAQ</a><span class="lseparator">|</span>
											<?php
										}
										?>
										
										<?php $link_class = uri_string() == 'press' ? 'color:#AA0000;' : ''; ?>
										<a href="<?php echo str_replace('https','http',site_url('press')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRESS</a><span class="lseparator">|</span>
										<?php $link_class = uri_string() == 'sitemap' ? 'color:#AA0000;' : ''; ?>
										<a href="<?php echo str_replace('https','http',site_url('sitemap')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SITEMAP</a><span class="lseparator">|</span>
										
										<?php $link_class = uri_string() == 'resource' ? 'color:#AA0000;' : ''; ?>
										<a href="<?php echo str_replace('https','http',site_url('resource')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RESOURCE</a><span class="lseparator">|</span>
										
										<?php
										/*
										if ($this->session->userdata('user_cat') != 'wholesale')
										{
											$link_class = uri_string() == 'wholesale/signin' ? 'color:#AA0000;' : ''; ?>
											<a href="<?php echo str_replace('https','http',site_url('wholesale/signin')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETAILER LOGIN</a><span class="lseparator">|</span>
											<?php
										}
										*/
										?>
										
										<?php $link_class = uri_string() == 'contact' ? 'color:#AA0000;' : ''; ?>
										<a href="<?php echo str_replace('https','http',site_url('contact')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">CONTACT</a>
										<br /><br />
									</td></tr>
									<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;"><?php echo strtoupper($this->config->item('site_name')); ?>, INC</td></tr>
									<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">TEL: 212-840-0846</td></tr>
									<!--<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">EMAIL: <a href="mailto:info@instylenewyork.com">INFO@INSTYLENEWYORK.COM</a></td></tr>-->
									<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">EMAIL: <?php echo safe_mailto($this->config->item('info_email'), strtoupper($this->config->item('info_email'))); ?></td></tr>
									<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">COPYRIGHT <?php echo $this->config->item('site_domain'); ?></td></tr>
								</table>
								<br />
								<a href="http://www.instylenewyork.com/" target="_blank"><img src="<?php echo base_url(); ?>images/blog.png" alt="Blog" title="Blog"border="0" /></a> 
							  
								<a href="http://www.youtube.com/instylenewyork" target="_blank"><img src="<?php echo base_url(); ?>images/y.png" title="Follow us on Youtube" alt="Follow us on Youtube" border="0" /></a> 
							  
								<a href="http://www.facebook.com/pages/Instylenewyork/111176205617161" target="_blank"><img src="<?php echo base_url(); ?>images/ico_facebook.jpg" alt="Facebook Connect"  title="Facebook Connect"border="0" /></a> 
								
								<a href="https://twitter.com/instylenewyork" target="_blank"><img src="<?php echo base_url(); ?>images/ico_twitter.jpg" border="0" alt="Follow us on Twitter" title="Follow us on Twitter" /></a> 
								
								<a href="#"><img src="<?php echo base_url(); ?>images/ico_rss.jpg" border="0" alt="Rss Feeds" title="Rss Feeds" /></a> 
								
								<div style="clear:both;"></div>      
							</td>
						</tr>
						</table>
					</div>
					</div>
				</td></tr>
				
				<tr><td class="normal_txt" style="font-weight:normal; text-decoration:none;">
					<div id="botwhitebg" align="center">
					<div id="wrapbottom" style="text-align:justify;margin-bottom:35px;">
						<?php
						/*
						| ---------------------------------------------------------------------------
						| Footer text will be pulled up from category, subcategory, and designer.
						| If footer text is empty, default footer text will be show up.
						| Default footer text can be change in the custom_config file
						| -- Modified by Verjel --  07/14/2011
						*/
						if (isset($footer_text) && ! empty($footer_text))
						{
							if ($footer_text == $site_title)
							{
								echo $uri_designer.$uri_facets.$footer_text;
							}
							else
							{
								echo $footer_text;
							}
						}
						else
						{
							echo $this->config->item('footer_text');
						}
						?>
					</div>
					</div>
				</td></tr>
			</table>
			
		</td></tr>

	</table>
	
	<?php
	/*
	| -------------------------------------------------
	| ---> Loader GIF image
	| used on as need basis
	| currently used by edit_product_details_view.php javascript of onclick function of submit button
	*/
	?>
	<div style="display:none" id="div_loader"></div>
	<div style="display:none" id="img_loader">
		<span>
			<img src="<?php echo base_url('assets/default'); ?>/images/loadingAnimation.gif" />
			<p>Loading...</p>
		</span>
	</div>

	<?php
	/*
	| -------------------------------------------------
	| ---> Chat (by node)
	*/
	if ($file === 'page' && $this->session->userdata('user_cat') == 'wholesale' && ($this->session->userdata('user_email') == 'rsbgm@innerconcept.com' OR $this->session->userdata('user_email') == 'rsbgm@yahoo.com') && $this->chat_on)
	{
		$this->load->view('default/'.'chat');
		echo $this->set->always_on_top_chat_box();
		echo $this->chat->chat_script_tags();
	}
	?>


	<!-- chat interupt js file -->
	<?php if ($this->session->userdata('user_loggedin') && $this->session->userdata('user_cat') == 'wholesale'): ?>
        <link rel="stylesheet" href="<?php echo $this->config->item('interupt_url'); ?>/chat_interupt_client.css" type="text/css" media="all">
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	    <!-- moment js lib -->
	    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	    <!-- socket io lib -->
	    <script src="//cdn.socket.io/socket.io-1.4.5.js"></script>
	    <!-- expose some user data to javascript -->
	    <script type="text/javascript"> 
	        var email = "<?php echo $this->session->userdata('user_email'); ?>";
	        var base_url = "<?php echo $this->config->item('interupt_url');?>";
	    </script>
	    <!-- chat interupt plugin -->
	    <script type="text/javascript" src="<?php echo $this->config->item('interupt_url'); ?>/chat_interupt_client.js"></script>
	<?php elseif(!$this->session->userdata('user_loggedin')): ?>
		<script type="text/javascript"> 
			if(typeof socket !== 'undefined'){
				socket.disconnect();
			}
			localStorage.removeItem("chat-started");
	        localStorage.removeItem("chat-messages");
			localStorage.removeItem("chat-time");
			localStorage.removeItem("chatbox-open");
	    </script>
	<?php endif; ?>

	<?php
	/*
	| -------------------------------------------------
	| ---> Shopping Cart
	| display when items are in bag
	*/
	if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing')
	{
		$cart_link = site_url('cart');
	}
	else
	{
		$cart_link = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('cart') : str_replace('http','https',site_url('cart'));
	}
	?>
	<div id="img_shopcart" style="display:none;position:relative;width:40px;height:40px;z-index:10000;">
		<a href="<?php echo $cart_link; ?>">
		<img src="<?php echo base_url(); ?>images/cart_40.png" style="position:absolute;" />
		<span style="position:absolute;top:17px;right:0px;color:red;font-weight:bold;font-size:20px;"><?php echo $this->cart->total_items(); ?></span>
		</a>
	</div>

</body>
</html>
